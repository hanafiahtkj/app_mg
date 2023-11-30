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
use App\Models\Investment;
use App\Models\InvestmentDuration;
use DB;

class InvestmentController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index()
    {
        // dd($date = now());
        $user = Auth::user();
        return Inertia::render('Investments', [
            'balance' => $user->balance,
            'investments' => Investment::with('duration')->where('user_id', $user->id)->orderBy('id')->get(),
            'durations'   => InvestmentDuration::orderBy('id')->get(),
            'level'       => $user->level,
            'currentInvestments' => $this->_currentInvestments()
        ]);
    }

    function _currentInvestments() {
        return $currentInvestments = DB::table('investments')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('user_id', '=', Auth::user()->id)
            ->count();
    }
}
