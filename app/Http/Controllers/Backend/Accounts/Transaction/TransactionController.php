<?php

namespace App\Http\Controllers\Backend\Accounts\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Account_transaction;
use App\Models\Master_Ledger;
use App\Models\Ledger;
use App\Models\Sub_ledger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(){
        $master_ledger=Master_Ledger::where('status',1)->latest()->get();
        $ledger=Ledger::where('status',1)->latest()->get();
        return view('Backend.Pages.Accounts.Transaction.index',compact('ledger','master_ledger'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'sub_ledger_id' => 'required|integer|max:255',
            'qty' => 'required|integer',
            'amount' => 'required|integer',
            'total' => 'required|integer',
        ]);

        if (!empty($request->sub_ledger_id)) {
            $sub_ledger = Sub_ledger::find($request->sub_ledger_id);

            /***Check if Ledger exists or not***/
            if (!$sub_ledger) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sub Ledger not found!'
                ], 404);
            }

            $ledger_id = $sub_ledger->ledger_id;
            $master_ledger_id = Ledger::find($ledger_id)->master_ledger_id;
        }

        /*Check Ledger id And Master ledger id*/
        if (!empty($ledger_id) && !empty($master_ledger_id)) {
            $object = new Account_transaction();
            $object->refer_no = $request->refer_no ?? strtoupper(uniqid());
            $object->transaction_number = "TRANSID-" . strtoupper(uniqid());
            $object->description = $request->description ?? strtoupper(uniqid());
            $object->master_ledger_id = $master_ledger_id;
            $object->ledger_id = $ledger_id;
            $object->sub_ledger_id = $request->sub_ledger_id;
            $object->qty = $request->qty;
            $object->value = $request->amount;
            $object->total = $request->total;
            $object->date = $request->create_date;
            $object->status = 0;
            $object->note = $request->note ?? '';
            $object->save();

            return response()->json(['success' => true, 'message' => 'Added Successfully']);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Ledger ID or Master Ledger ID is missing!'
            ], 400);
        }
    }


    public function show_account_transaction(){
       $data= Account_transaction::with('ledger','sub_ledger','master_ledger')->where('status',0)->get();
       return response()->json(['success' =>true, 'data'=>$data]);
    }
    public function finished_account_transaction(){
        $data=Account_transaction::where('status',0)->get();
        foreach ($data as $transaction) {
            $transaction->status = 1;
            $transaction->save();
        }
        return response()->json(['success' =>true, 'message'=>'Completed Successfully']);
    }

    public function transaction_report(){
        $master_ledger=Master_Ledger::where('status',1)->latest()->get();
        return view('Backend.Pages.Accounts.Transaction.Report.index',compact('master_ledger'));
    }
    public function report_generate(Request $request)
    {
        /*Validate date inputs*/
        $request->validate([
            'from_date' => 'required|date',
            'master_ledger_id' => 'required|integer',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        /* Get data based on selected date range*/
        $from_date = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
        $to_date = Carbon::createFromFormat('Y-m-d', $request->to_date)->endOfDay();
        $master_ledger_id = $request->master_ledger_id;

        /* Check if the dates are the same */
        $same_date_flag = '';
        if ($from_date->isSameDay($to_date)) {
            $same_date_flag=true;
        } else {
            $same_date_flag=false;
        }

        /* Fetch data with relations*/
        $transactions = Account_transaction::with(['ledger', 'sub_ledger'])
        ->where('master_ledger_id', $master_ledger_id)
        ->where('status', 1)
         ->whereBetween('created_at', [$from_date, $to_date])
        ->get()
        ->groupBy('ledger.ledger_name');

        $master_ledger = Master_Ledger::where('status', 1)->latest()->get();
        $ledger = Ledger::where('status', 1)->latest()->get();
        return view('Backend.Pages.Accounts.Transaction.Report.index', compact('transactions', 'master_ledger', 'ledger','same_date_flag'));
    }

}
