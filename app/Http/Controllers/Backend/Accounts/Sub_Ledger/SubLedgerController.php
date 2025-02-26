<?php

namespace App\Http\Controllers\Backend\Accounts\Sub_Ledger;

use App\Http\Controllers\Controller;
use App\Models\Ledger;
use App\Models\Sub_ledger;
use Illuminate\Http\Request;

class SubLedgerController extends Controller
{
    public function index(){
        $ledger=Ledger::latest()->get();
        $sub_ledger=Sub_ledger::where('status',1)->latest()->get();
        return view('Backend.Pages.Accounts.Sub_Ledger.index',compact('sub_ledger','ledger'));
    }
    public function get_all_data(Request $request){
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'ledger_id','sub_ledger_name','status', 'created_at'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirectection = $request->order[0]['dir'];
    
        $object = Sub_ledger::with('ledger')
        ->when($search, function ($query) use ($search) {
            $query->whereHas('ledger', function ($q) use ($search) {
                $q->where('ledger_name', 'like', "%$search%");
            })
            ->orWhere('sub_ledger_name', 'like', "%$search%");
        })
        ->orderBy($columnsForOrderBy[$orderByColumn], $orderDirectection)
        ->paginate($request->length);

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $object->total(),
            'recordsFiltered' => $object->total(),
            'data' => $object->items(),
        ]);
    }
    public function edit($id){
        $data = Sub_Ledger::with('ledger')->find($id);
        if (!$data) {
            return response()->json(['error' => 'not found']);
        }
        return response()->json(['success'=>true,'data' => $data]); 
    }
    public function update(Request $request){
        $request->validate([
            'ledger_id'=>'required|integer|max:255',
            'sub_ledger_name'=>'required|string|max:255',
            'status'=>'required|in:0,1',
        ]);
        $object= Sub_ledger::find($request->id);
        $object->ledger_id=$request->ledger_id;
        $object->sub_ledger_name=$request->sub_ledger_name;
        $object->status=$request->status;
        $object->save();

        return response()->json(['success' => 'Update Successfully']);
    }
    public function store(Request $request){
        $request->validate([
         'ledger_id'=>'required|integer|max:255',
         'sub_ledger_name'=>'required|string|max:255',
         'status'=>'required|in:0,1',
        ]);
        $object=new Sub_ledger();
        $object->ledger_id=$request->ledger_id;
        $object->sub_ledger_name=$request->sub_ledger_name;
        $object->status=$request->status;
        $object->save();
        return response()->json(['success' =>true, 'message'=>'Added Successfully']);
    }
    public function delete(Request $request){
        $object = Sub_Ledger::find($request->id);
        if (!$object) {
            return response()->json(['error' => 'Not found']);
        }
        /* Delete the data*/
        $object->delete();
        return response()->json(['success' => true , 'message'=> 'Deleted successfully']); 
    }
    public function get_sub_ledger($id){
        $object = Sub_Ledger::where('ledger_id',$id)->latest()->get();
        if (!$object) {
            return response()->json(['error' => 'Not found']);
        }
        return response()->json(['success' =>true, 'data'=>$object]);
    }
}
