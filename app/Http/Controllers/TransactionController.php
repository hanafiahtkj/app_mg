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
use Telegram\Bot\Laravel\Facades\Telegram;

class TransactionController extends Controller
{
    // protected $chatId = '-4198448403';
    protected $chatId = '-4039531416';

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

        $this->_sendMessage(
            'New Transaction, Type: Deposit, Amount: $'.formatCurrencyDisplay($amount).' USDT, Status: Waiting for Payment, User/Email: '.$user->email
        );

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

        $this->_sendMessage(
            'Waiting for Payment, Type: Withdraw, Amount: $'.formatCurrencyDisplay($amount).' USDT, User/Email: '.Auth::user()->email
        );

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

        $this->_sendMessage(
            'Waiting for confirmation, Type: Deposit, Amount: $'.formatCurrencyDisplay($transaction->amount_float).' USDT, Txhash: '.$request->txhash.', User/Email: '.Auth::user()->email
        );

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
        $investment = $user->startInvestment($amount, $duration);

        $referrer = $user->referralAccount->referrer;
        if($referrer) {
            $amount = formatCurrency($investment->amount * 0.10); // referrer dapat 10% dari jumlah total earning.
            $transaction = $referrer->depositFloat($amount, [
                'description' => 'Earning',
                'investment_id' => $investment->id,
                'referrer_earning' => true,
                'referral_user_id' => $user->id,
            ]);

            $referrer->notify(new ReferrerEarningNotification($amount, $user->email));
        }
    }

    public function claimEarning(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'investment_id' => 'required',
            'is_completed'  => 'required',
        ]);

        $investment_id = $request->investment_id;
        $investment = Investment::find($investment_id);
        if ($investment->can_claim) {
            $amount = $investment->daily_earning;
            $transaction = $user->depositFloat($amount, [
                'description' => 'Earning',
                'investment_id' => $investment_id,
            ]);
        }

        if ($request->is_completed && $investment->can_claim_completed) {
            $amount = formatCurrency($investment->amount);
            $transaction = $user->depositFloat($amount, [
                'description'   => 'Earning',
                'investment_id' => $investment_id,
                'is_completed'  => true,
            ]);

            // $referrer = $user->referralAccount->referrer;
            // if($referrer) {
            //     $amount = formatCurrency($investment->amount * 0.10); // referrer dapat 10% dari jumlah total earning.
            //     $transaction = $referrer->depositFloat($amount, [
            //         'description' => 'Earning',
            //         'investment_id' => $investment_id,
            //         'referrer_earning' => true,
            //         'referral_user_id' => $user->id,
            //     ]);

            //     $referrer->notify(new ReferrerEarningNotification($amount, $user->email));
            // }
        }
    }

    protected function _sendMessage($message) {
        Telegram::bot('mybot')->sendMessage([
            'chat_id' => $this->chatId,
            'text' => $message
        ]);
    }
}
