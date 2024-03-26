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
use App\Models\ApiCoin;
use Carbon\Carbon;
use DB;

class HomeController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function index()
    {
        if (auth()->check()) {
            return Redirect::route('home');
        }

        return Inertia::render('Landing', []);
    }

    public function home()
    {
        $user = Auth::user();

        $earningTransactions = $user->transactions()->where('meta->description', 'Earning')->where('confirmed', 1)->get();
        $totalEarning = $earningTransactions->sum('amount_float');

        $incomeTransactions = $user->transactions()->where('meta->description', 'Deposit')->where('confirmed', 1)->get();
        $totalIncome = $incomeTransactions->sum('amount_float') + $totalEarning;

        $withdrawTransactions = $user->transactions()->where('meta->description', 'Withdraw')->where('confirmed', 1)->get();
        $totalWithdraw = $withdrawTransactions->sum('amount_float');

        return Inertia::render('Welcome', [
            'balance' => $user->balanceFloat,
            'earning' => $totalEarning,
            'income'  => $totalIncome,
            'withdraw'=> $totalWithdraw,
            'referallCount' => count($user->referrals),
            'level' => $user->level,
            'coinsMarkets' => $this->coinsMarkets(),
        ]);
    }

    public function coinsMarkets()
    {
        $apiCoin = ApiCoin::first();
        if ($apiCoin->updated_at->diffInDays(Carbon::now()) >= 1) {
            $url = "https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=20&page=1&sparkline=false&locale=en";
            $response = Http::get($url);

            if ($response->successful()) {
                $data = $response->json();
                $apiCoin->update([
                    'json' => $data
                ]);
            }
        }
        return $apiCoin->json;
    }
}
