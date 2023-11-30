<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use DataTables;
use Bavix\Wallet\Models\Transaction;
use DB;

class HomeController extends Controller
{
    public function index()
    {
        $deposit  = Transaction::where('confirmed', 1)->where('meta->description', 'Deposit')->get();
        $withdraw = Transaction::where('confirmed', 1)->where('meta->description', 'Withdraw')->get();

        return Inertia::render('Admin/Dashboard', [
            'deposit'  => $deposit->sum('amount'),
            'withdraw' => $withdraw->sum('amount'),
            'user'     => DB::table('users')->count()
        ]);
    }

    public function loadTransactions(Request $request)
    {
        $model = Transaction::with('payable');

        return DataTables::of($model)
            ->addColumn('amount_float', function ($transaction) {
                return $transaction->amount_float;
            })
            ->order(function ($query) {
                $query->orderBy('id', 'desc');
            })
            ->toJson();
    }

    public function verifikasi($id)
    {
        $transaction = Transaction::with('payable')->where('id', $id)->first();
        return Inertia::modal('Admin/Verifikasi', [
            'balance' => $transaction->payable->balanceFloat,
            'amount' => $transaction->amount_float,
            'transaction' => $transaction
        ])
            ->baseRoute('admin.index');
    }

    public function store(Request $request)
    {
        $uuid = $request->uuid;
        $transaction = Transaction::where('uuid', $uuid)->first();
        $transaction->wallet->confirm($transaction);
    }
}
