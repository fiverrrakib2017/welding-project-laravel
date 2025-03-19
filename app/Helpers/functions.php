<?php
namespace App\Helpers;

use App\Models\Branch_transaction;
use App\Models\Customer;
use App\Models\Customer_recharge;
use Illuminate\Http\Request;

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
if(!function_exists('fetch_customer_data')) {
    function fetch_customer_data(Request $request, $isDeleteCondition) {
        $search = $request->search['value'] ?? '';
        $columnsForOrderBy = ['id', 'id', 'fullname', 'package', 'amount', 'created_at', 'expire_date', 'username', 'phone', 'pop_id', 'area_id', 'created_at', 'created_at'];

        $orderByColumn = $request->order[0]['column'] ?? 0;
        $orderDirection = $request->order[0]['dir'] ?? 'desc';

        $start = $request->start ?? 0;
        $length = $request->length ?? 10;

        $query = Customer::with(['pop', 'area', 'package'])
            ->where('is_delete', '!=', $isDeleteCondition)
            ->when($search, function ($query) use ($search) {
                $query->where('phone', 'like', "%$search%")
                      ->orWhere('username', 'like', "%$search%")
                      ->orWhereHas('pop', function ($query) use ($search) {
                          $query->where('fullname', 'like', "%$search%");
                      })
                      ->orWhereHas('area', function ($query) use ($search) {
                          $query->where('name', 'like', "%$search%");
                      })
                      ->orWhereHas('package', function ($query) use ($search) {
                          $query->where('name', 'like', "%$search%");
                      });
            });

        /*Pagination*/
        $paginatedData = $query->orderBy($columnsForOrderBy[$orderByColumn], $orderDirection)
            ->paginate($length, ['*'], 'page', ($start / $length) + 1);

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => Customer::where('is_delete', '!=', $isDeleteCondition)->count(),
            'recordsFiltered' => $paginatedData->total(),
            'data' => $paginatedData->items(),
        ]);
    }
}
