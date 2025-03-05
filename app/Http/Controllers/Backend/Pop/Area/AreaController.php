<?php
namespace App\Http\Controllers\Backend\Pop\Area;
use App\Http\Controllers\Controller;
use App\Models\Pop_area;
use App\Models\Pop_branch;
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

        /* Image Find And Delete it From Local Machine */
        // if (!empty($object->profile_image)) {
        //     $imagePath = public_path('Backend/uploads/photos/' . $object->profile_image);

        //     if (file_exists($imagePath)) {
        //         unlink($imagePath);
        //     }
        // }

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
    public function view($id)
    {
        return $id;
        // $total_invoice=Supplier_Invoice::where('supplier_id',$id)->count();
        // $total_paid_amount=Supplier_Invoice::where('supplier_id',$id)->sum('paid_amount');
        // $total_due_amount=Supplier_Invoice::where('supplier_id',$id)->sum('due_amount');
        // $invoices = Supplier_Invoice::where('supplier_id', $id)->get();
        // $data = Supplier::find($id);
        //  $supplier_transaction_history=Supplier_Transaction_History::where('supplier_id',$id)->get();
        // return view('Backend.Pages.Supplier.Profile',compact('data','total_invoice','total_paid_amount','total_due_amount','invoices','supplier_transaction_history'));
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
