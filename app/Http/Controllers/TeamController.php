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

class TeamController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index()
    {
        $user = Auth::user();
        $teams = $user->referrals->map(function ($team) {
            return array_merge($team->toArray(), ['user' => $team->user]);
        });

        return Inertia::render('Teams', [
            'teams' => $teams,
            'referralCode' => $user->getReferralCode(),
            'referralLink' => $user->getReferralLink(),
        ]);
    }
}
