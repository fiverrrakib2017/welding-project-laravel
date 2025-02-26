<?php

namespace App\Http\Controllers\Backend\Accounts\Master_Ledger;

use App\Http\Controllers\Controller;
use App\Models\Master_Ledger;
use Illuminate\Http\Request;

class MasterLedgerController extends Controller
{
    public function index(){
        return view('Backend.Pages.Accounts.Master_Ledger.index');
    }
    public function get_all_data(Request $request){
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'name','status','status', 'created_at'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirectection = $request->order[0]['dir'];
    
        $object = Master_Ledger::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%$search%");
            $query->where('status', 'like', "%$search%");
            $query->where('created_at', 'like', "%$search%");
        })->orderBy($columnsForOrderBy[$orderByColumn], $orderDirectection);
    
        $total = $object->count();
        $item = $object->skip($request->start)->take($request->length)->get();
    
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $item,
        ]);
    }
    public function store(Request $request){
       $request->validate([
        'master_ledger_name'=>'required|string|max:255',
        'status'=>'required|in:0,1',
       ]);
       $object=new Master_Ledger();
       $object->name=$request->master_ledger_name;
       $object->status=$request->status;
       $object->save();
       return response()->json(['success' =>true, 'message'=>'Added Successfully']);
    }
    public function edit($id){
        $data = Master_Ledger::find($id);
        if (!$data) {
            return response()->json(['error' => 'Not found']);
        }
        return response()->json(['success'=>true,'data' => $data]); 
    }
    public function update(Request $request){
        $request->validate([
            'master_ledger_name'=>'required|string|max:255',
            'status'=>'required|in:0,1',
        ]);
        $object= Master_Ledger::find($request->id);
        $object->name = $request->master_ledger_name;
        $object->status = $request->status;
        $object->save();

        return response()->json(['success' => 'Update Successfully']);
    }
    public function delete(Request $request){
        $object = Master_Ledger::find($request->id);
        if (!$object) {
            return response()->json(['error' => 'Not found']);
        }
        /* Delete the data*/
        $object->delete();
        return response()->json(['success' => true , 'message'=> 'Deleted successfully']); 
    }
}
