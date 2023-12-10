<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Http;
use DB;
use Bavix\Wallet\Models\Transaction;
use App\Models\Investment;
use App\Notifications\ReferrerEarningNotification;

class TransactionController extends Controller
{
    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => [
                'required',
                'numeric',
                // 'not_in:0',
                'min:1', // 1 USDT
            ],
        ]);

        $amount = formatCurrency($request->amount);
        $user = Auth::user();
        $transaction = $user->depositFloat($amount, ['description' => 'Deposit'], false);

        return Redirect::route('transaction.view', $transaction->uuid);
    }

    public function withdraw(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'amount' => [
                'required',
                'numeric',
                'not_in:0',
                'lte:'.$user->balanceFloat
            ],
        ]);

        $amount = formatCurrency($request->amount);
        $transaction = $user->withdrawFloat($amount, ['description' => 'Withdraw'], false);

        return Redirect::route('transaction.view', $transaction->uuid);
    }

    public function view($uuid)
    {
        $user = Auth::user();
        $transaction = $user->transactions()->where('uuid', $uuid)->first();
        return Inertia::render('TransactionDetail', [
            'transaction' => array_merge($transaction->toArray(), [
                'amount_float' => $transaction->amount_float,
            ]),
            'uuid' => $uuid
        ]);
    }

    public function paymentConfirmation(Request $request)
    {
        $request->validate([
            'txhash' => 'required',
        ]);

        $uuid = $request->uuid;
        $transaction = Transaction::where('uuid', $uuid)->first();
        $meta = $transaction->meta;
        $meta['txhash'] = $request->txhash;
        $transaction->update([
            'meta' => $meta
        ]);
        // $transaction->wallet->confirm($transaction);

        return Redirect::route('transaction.view', $uuid);
    }

    public function investment(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'duration' => 'required',
            'amount' => [
                'required',
                'numeric',
                'not_in:0',
                'lte:'.$user->balanceFloat
            ],
        ]);

        $amount = formatCurrency($request->amount);
        $duration = $request->duration;
        $transaction = $user->startInvestment($amount, $duration);
    }

    public function claimEarning(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'investment_id' => 'required',
        ]);

        $investment_id = $request->investment_id;
        $investment = Investment::find($investment_id);
        if ($investment->can_claim) {
            $amount = $investment->daily_earning;
            $transaction = $user->depositFloat($amount, [
                'description' => 'Earning',
                'investment_id' => $investment_id,
            ]);

            $referrer = $user->referralAccount->referrer;
            if($referrer) {
                $transaction = $referrer->depositFloat($amount, [
                    'description' => 'Earning',
                    'investment_id' => $investment_id,
                    'referrer_earning' => true,
                    'referral_user_id' => $user->id,
                ]);

                $referrer->notify(new ReferrerEarningNotification($amount, $user->email));
            }
        }
    }
}
