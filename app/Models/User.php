<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Illuminate\Support\Facades\Storage;
use Jijunair\LaravelReferral\Traits\Referrable;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWalletFloat;
use Bavix\Wallet\Interfaces\WalletFloat;
use Jijunair\LaravelReferral\Models\Referral;

class User extends Authenticatable implements LaratrustUser, MustVerifyEmail, Wallet, WalletFloat
{
    use HasApiTokens, HasFactory, Notifiable, HasRolesAndPermissions, Referrable, HasWallet, HasWalletFloat;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'wallet_id',
        'level_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = ['avatar'];

    public function getAvatarAttribute(): string
    {
        if ($this->perusahaan) {
            if ($this->perusahaan->logo) {
                return Storage::url($this->perusahaan->logo);
            }
        }
        return asset('assets/img/2.jpg');
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function level()
    {
        return $this->belongsTo(UserLevel::class, 'level_id');
    }

    public function startInvestment($amount, $durationId)
    {
        $duration = InvestmentDuration::find($durationId);

        // Cek apakah saldo cukup
        if ($this->balanceFloat >= $amount) {
            // Mengurangkan nilai dari saldo
            $this->withdrawFloat($amount, ['description' => 'Investment']);

            // Membuat investasi
            return $this->investments()->create([
                'amount' => $amount,
                'start_date' => now(),
                'end_date' => now()->addDays($duration->name),
                'investment_duration_id' => $durationId,
            ]);
        } else {
            // Saldo tidak mencukupi
            throw new \Exception("Insufficient balance for investment.");
        }
    }

    public function createReferralAccount(int $referrerID = NULL)
    {

        $prefix = config('referral.ref_code_prefix');
        $length = config('referral.referral_length');

        // $referralCode = $this->generateUniqueReferralCode($prefix, $length);
        $prefix = strtolower($prefix);
        $referralCode = $prefix . strtolower($this->username);

        $ref = new Referral;
        $ref->user_id = $this->getKey();
        $ref->referrer_id = $referrerID;
        $ref->referral_code = $referralCode;
        $ref->save();
    }
}
