<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Jijunair\LaravelReferral\Models\Referral;
use Illuminate\Support\Facades\Cookie;
use App\Models\UserLevel;
use App\Notifications\ReferralUsedNotification;
use App\Notifications\LevelChangedNotification;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        $referralCode = Cookie::get(config('referral.cookie_name'));
        return Inertia::render('Auth/Register', [
            'referralCode' => $referralCode,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            // 'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:'.User::class,
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'wallet_id' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->email,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'wallet_id' => $request->wallet_id,
            'level_id' => 1,
        ]);

        $user->forceFill(['email_verified_at' => Carbon::now()->toDateTimeString()]);
        $user->save();

        $user->addRole('member');

        $referralCode = $request->referral_code;
        $referrer = $referralCode ? Referral::userByReferralCode($referralCode) : null;
        $user->createReferralAccount($referrer ? $referrer->id : null);

        if ($referrer) {

            $referrer->notify(new ReferralUsedNotification($user));

            $referrals = count($referrer->referrals);

            $userLevel = UserLevel::where('referral_count', '<=', $referrals)->orderBy('referral_count', 'desc')->first();

            if ($userLevel && $referrer->level_id !== $userLevel->id) {
                $referrer->update([
                    'level_id' => $userLevel->id
                ]);

                $referrer->notify(new LevelChangedNotification($userLevel->name));
            }
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
