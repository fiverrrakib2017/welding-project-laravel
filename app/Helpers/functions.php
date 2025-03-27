<?php
namespace App\Helpers;

use App\Models\Branch_transaction;
use App\Models\Customer;
use App\Models\Customer_log;
use App\Models\Sms_configuration;
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

if (!function_exists('send_message')) {
    function send_message($phone_number, $message) {
        /**GET Message Api Details From Database Table**/
        $message=Sms_configuration::latest()->first();
        $api_url = $message->api_url;
        $api_token = $message->api_token;

        $data = json_encode([
            "phone" => $phone_number,
            "message" => $message
        ]);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Token: $api_token"
            ],
        ]);

        $response = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);

        curl_close($curl);

        if ($error) {
            return "cURL Error: " . $error;
        } elseif ($http_code !== 201) {
            return "Error: Received HTTP status code " . $http_code . " - Response: " . $response;
        }

        return true;
    }
     function customer_log($customerId, $actionType, $userId, $description = null)
    {
        $object=new Customer_log();
        $object->customer_id=$customerId;
        $object->action_type=$actionType;
        $object->user_id=$userId;
        $object->description=$description;
        $object->ip_address=request()->ip();
        $object->save();
        return $object;
    }
}
