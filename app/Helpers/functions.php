<?php
namespace App\Helpers;

use App\Models\Branch_transaction;
use App\Models\Customer_recharge;


if (!function_exists('check_pop_balance')) {
    function check_pop_balance($pop_id)
    {
        $total_balance = Branch_transaction::where('pop_id', $pop_id)
            ->where('transaction_type', '!=', 'due_paid')
            ->sum('amount');

        $total_customer_recharge = Customer_recharge::where('pop_id', $pop_id)
            ->where('transaction_type', '!=', 'due_paid')
            ->sum('amount');

        return $total_balance - $total_customer_recharge;
    }
}
