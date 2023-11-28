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
use DB;

class HistoryController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index()
    {
        $user = Auth::user();
        $transactions = $user->transactions()
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($transaction) {
                return array_merge($transaction->toArray(), [
                    'amount_float' => $transaction->amount_float,
                ]);
            });
        return Inertia::render('History', [
            'transactions' => $transactions
        ]);
    }
}
