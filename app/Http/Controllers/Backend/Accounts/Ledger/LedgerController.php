<?php

namespace App\Http\Controllers\Backend\Accounts\Ledger;

use App\Http\Controllers\Controller;
use App\Models\Ledger;
use App\Models\Master_Ledger;
use Illuminate\Http\Request;

class LedgerController extends Controller
{
    public function index(){
        $ledger=Ledger::with('master_ledger')->get();
        $master_ledger=Master_Ledger::where('status',1)->latest()->get();
        return view('Backend.Pages.Accounts.Ledger.index',compact('master_ledger'));
    }
    public function get_all_data(Request $request){
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'master_ledger_id','ledger_name','status', 'created_at'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirectection = $request->order[0]['dir'];

        $states = Ledger::with('master_ledger')
        ->when($search, function ($query) use ($search) {
            $query->whereHas('master_ledger', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })
            ->orWhere('ledger_name', 'like', "%$search%");
        })
        ->orderBy($columnsForOrderBy[$orderByColumn], $orderDirectection)
        ->paginate($request->length);

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $states->total(),
            'recordsFiltered' => $states->total(),
            'data' => $states->items(),
        ]);
    }
    public function edit($id){
        $data = Ledger::with('master_ledger')->find($id);
        if (!$data) {
            return response()->json(['error' => 'Api not found']);
        }
        return response()->json(['success'=>true,'data' => $data]);
    }
    public function get_ledger($id){
      $data=  Ledger::Where('master_ledger_id', $id)->get();
      return response()->json(['success'=>true,'data' => $data],200);
    }
    public function update(Request $request){
        $request->validate([
            'master_ledger_name'=>'required|integer|max:255',
            'ledger_name'=>'required|string|max:255',
            'status'=>'required|in:0,1',
        ]);
        $object= Ledger::find($request->id);
        $object->master_ledger_id = $request->master_ledger_name;
        $object->ledger_name = $request->ledger_name;
        $object->status = $request->status;
        $object->save();

        return response()->json(['success' => 'Update Successfully']);
    }
    public function store(Request $request){
        $request->validate([
         'master_ledger_name'=>'required|integer|max:255',
         'ledger_name'=>'required|string|max:255',
         'status'=>'required|in:0,1',
        ]);
        $object=new Ledger();
        $object->master_ledger_id=$request->master_ledger_name;
        $object->ledger_name=$request->ledger_name;
        $object->status=$request->status;
        $object->save();
        return response()->json(['success' =>true, 'message'=>'Added Successfully']);
    }
    public function delete(Request $request){
        $object = Ledger::find($request->id);
        if (!$object) {
            return response()->json(['error' => 'Not found']);
        }
        /* Delete the data*/
        $object->delete();
        return response()->json(['success' => true , 'message'=> 'Deleted successfully']);
    }
}
