<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Investment extends Model
{
    use HasFactory;

    protected $table = 'investments';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends = ['status', 'can_claim', 'can_claim_completed', 'daily_earning'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function duration()
    {
        return $this->belongsTo(InvestmentDuration::class, 'investment_duration_id');
    }

    public function getStatusAttribute()
    {
        $now = now();
        if ($this->start_date <= $now &&  Carbon::parse($this->end_date)->addDays(1) >= $now) {
            return 'Active';
        } else {
            return 'Inactive';
        }
    }

    public function getDailyEarningAttribute()
    {
        // return $this->amount * $this->duration->earning_rate / $this->duration->name;
        return formatCurrency($this->amount * $this->duration->earning_rate);
    }

    public function hasEarningOnDate($date)
    {
        $startDate = Carbon::parse($this->start_date)->addDays(1);
        $differenceInDays = $startDate->diffInDays($date);
        $newDateTime = $startDate->addDays($differenceInDays);
        return $this->user->transactions()
            ->where('meta->description', 'Earning')
            ->where('meta->investment_id', $this->id)
            ->where('created_at', '>=', $newDateTime)
            ->exists();
    }

    public function hasEarningCompleted()
    {
        return $this->user->transactions()
            ->where('meta->description', 'Earning')
            ->where('meta->investment_id', $this->id)
            ->where('meta->is_completed', true)
            ->exists();
    }

    protected function isDateWithinInvestmentPeriod($date)
    {
        return Carbon::parse($this->start_date)->addDays(1) <= $date && Carbon::parse($this->end_date)->addDays(1) >= $date;
    }

    public function getCanClaimAttribute()
    {
        $date = now();
        $claimDate = Carbon::parse($this->start_date)->addDays(1);
        return $date >= $claimDate && $this->isDateWithinInvestmentPeriod($date) && !$this->hasEarningOnDate($date);
    }

    public function getCanClaimCompletedAttribute()
    {
        $date = now();
        $claimDate = Carbon::parse($this->start_date)->addDays(1);
        return $date >= $claimDate && !$this->isDateWithinInvestmentPeriod($date) && !$this->hasEarningCompleted();
    }
}
