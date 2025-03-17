<?php
namespace App\Http\Controllers\Backend\Pop\Area;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Pop_area;
use App\Models\Pop_branch;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller
{
    public function index()
    {
        return view('Backend.Pages.Pop.Area.index');
    }
    public function get_all_data(Request $request)
    {
        $search = $request->search['value'];
        $columnsForOrderBy = ['id', 'pop_id', 'name', 'billing_cycle'];
        $orderByColumn = $request->order[0]['column'];
        $orderDirectection = $request->order[0]['dir'];

        $query = Pop_area::with(['pop'])->when($search, function ($query) use ($search) {
            $query
                ->where('name', 'like', "%$search%")
                ->orWhere('billing_cycle', 'like', "%$search%")
                ->orWhereHas('pop', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                });
        });

        $total = $query->count();

        $query = $query->orderBy($columnsForOrderBy[$orderByColumn], $orderDirectection);

        $items = $query->skip($request->start)->take($request->length)->get();

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $items,
        ]);
    }
    public function store(Request $request)
    {
        /* Validate the form data*/
        $this->validateForm($request);

        /* Create a new Supplier*/
        $object = new Pop_area();
        $object->pop_id = $request->pop_id;
        $object->name = $request->name;
        $object->billing_cycle = $request->billing_cycle;

        /* Save to the database table*/
        $object->save();
        return response()->json([
            'success' => true,
            'message' => 'Added successfully!',
        ]);
    }

    public function delete(Request $request)
    {
        $object = Pop_area::find($request->id);

        if (empty($object)) {
            return response()->json(['error' => 'Not found.'], 404);
        }

        /* Delete it From Database Table */
        $object->delete();

        return response()->json(['success' => true, 'message' => 'Deleted successfully.']);
    }
    public function edit($id)
    {
        $data = Pop_area::find($id);
        if ($data) {
            return response()->json(['success' => true, 'data' => $data]);
            exit();
        } else {
            return response()->json(['success' => false, 'message' => 'Not found.']);
        }
    }
    public function get_pop_wise_area($pop_id){
        $data = Pop_area::Where('pop_id',$pop_id)->get();
        if ($data) {
            return response()->json(['success' => true, 'data' => $data]);
            exit();
        } else {
            return response()->json(['success' => false, 'message' => 'Not found.']);
        }
    }
    public function view($id)
    {
        $data=Pop_area::findOrFail($id);


         /*Tickets Details*/
         $total_area=Pop_area::where('pop_id',$id)->count();
         $tickets=Ticket::where('pop_id',$id)->count();
         $ticket_completed=Ticket::where('pop_id',$id)->where('status','1')->count();
         $ticket_pending=Ticket::where('pop_id',$id)->where('status','0')->count();

        /*Customer Details*/
        $online_customer=Customer::where('area_id',$id)->where('status','online')->count();
        $active_customer=Customer::where('area_id',$id)->where('status','active')->count();
        $expire_customer=Customer::where('area_id',$id)->where('status','expire')->count();
        $offline_customer=Customer::where('area_id',$id)->where('status','offline')->count();
        $disable_customer=Customer::where('area_id',$id)->where('status','disabled')->count();
        return view('Backend.Pages.Pop.Area.View',compact('data','total_area','tickets','ticket_completed','ticket_pending','online_customer','active_customer','expire_customer','offline_customer','disable_customer'));
    }
    public function area_change_status($id) {
        $object = Pop_area::find($id);

        if (!$object) {
            return response()->json([
                'success' => false,
                'message' => 'POP/Area not found!'
            ], 404);
        }
        $object->status = $object->status === 'active' ? 'inactive' : 'active';

        $object->save();

        return response()->json([
            'success' => true,
            'message' => 'Status changed successfully!',
            'new_status' => $object->status
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request);

        $object = Pop_area::findOrFail($id);
        $object->pop_id = $request->pop_id;
        $object->name = $request->name;
        $object->billing_cycle = $request->billing_cycle;
        $object->update();

        return response()->json([
            'success' => true,
            'message' => 'Update successfully!',
        ]);
    }
    private function validateForm($request)
    {
        /*Validate the form data*/
        $rules = [
            'pop_id' => 'required|string',
            'name' => 'required|string',
            'billing_cycle' => 'required|string',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'errors' => $validator->errors(),
                ],
                422,
            );
        }
    }
}
