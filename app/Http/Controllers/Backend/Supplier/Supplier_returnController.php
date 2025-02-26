<?php
namespace App\Http\Controllers\Backend\Supplier;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Supplier_Invoice;
use App\Models\Supplier_Invoice_Details;
use App\Models\Supplier_return_invoice;
use App\Models\Supplier_return_invoice_details;
use Illuminate\Http\Request;

class Supplier_returnController extends Controller
{
    public function index(){
        return view('Backend.Pages.Supplier.Return.index');
    }
    public function create_return(){
        $suppliers=Supplier::latest()->get();
        $products=Product::latest()->where('status',1)->get();
        $invoices=Supplier_Invoice::with('supplier')->latest()->get();
        return view('Backend.Pages.Supplier.Return.create',
        [
            'suppliers'=>$suppliers,
            'products'=>$products,
            'invoices'=>$invoices,
        ]);
    }
    public function get_product($id)
    {
        $products = Supplier_Invoice_Details::where('invoice_id', $id)->with('product')->get();

        $data = $products->map(function($item) {
            return [
                'id' => $item->product->id,
                'title' => $item->product->title,
                'barcode' => $item->product->barcode,
            ];
        });

        return response()->json($data);
    }

    public function return_invoice_store(Request $request){
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'invoice_id' => 'required|exists:supplier__invoices,id',
            'return_note' => 'nullable|string',
            'product_id.*' => 'required|exists:products,id',
            'qty.*' => 'required|integer|min:1',
            'price.*' => 'required|numeric|min:0',
            'total_price.*' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
        ]);
        /*Create the invoice*/
        $invoice = new Supplier_return_invoice();
        $invoice->supplier_id = $request->supplier_id;
        $invoice->invoice_id = $request->invoice_id;
        $invoice->total_return_amount = $request->total_amount ?? 0;
        $invoice->return_note = $request->return_note ?? ' ';
        $invoice->save();
        /* Create invoice items*/
        foreach ($request->product_id as $index => $productId) {
            $invoiceItem = new Supplier_return_invoice_details();
            $invoiceItem->return_invoice_id = $invoice->id;
            $invoiceItem->product_id = $productId;
            $invoiceItem->return_qty = $request->qty[$index];
            $invoiceItem->return_price = $request->price[$index];
            $invoiceItem->total_return_price = $request->qty[$index] * $request->price[$index] ?? 00;
            $invoiceItem->save();
            
            /*Update product stock*/ 
            $product = Product::find($productId);
            if ($product) {
                $product->qty -= $request->qty[$index];
                $product->save();
            }
        }
        return response()->json(['success' =>true, 'message'=> 'Return Invoice stored successfully'], 201);
    }
}