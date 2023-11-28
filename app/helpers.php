<?php

function formatCurrency($value) {
    return number_format((float)$value, 2, '.', ',');
}

function getAllReferrals($userId, &$result = []) {
    $referrals = DB::table('referrals')
        ->join('users', 'users.id', '=', 'referrals.user_id')
        ->select('user_id', 'referral_code', 'users.email')
        ->where('referrer_id', $userId)
        ->get();

    foreach ($referrals as $referral) {
        $result[] = $referral;
        getAllReferrals($referral->user_id, $result);
    }

    return $result;
}

function getAllAncestors($userId, &$result = []) {
    $referrerId = DB::table('referrals')
        ->where('user_id', $userId)
        ->value('referrer_id');

    if ($referrerId) {
        $result[] = $referrerId;
        getAllAncestors($referrerId, $result);
    }

    return $result;
}


