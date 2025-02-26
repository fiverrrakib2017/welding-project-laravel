<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Customer_Invoice;
use App\Models\Product;
use App\Models\Product_Order;
use Illuminate\Support\Facades\DB;
use App\Models\Supplier;
use App\Models\Supplier_Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Services\DateService;
class AdminController extends Controller
{
    protected $dateService;

    public function __construct(DateService $dateService)
    {
        $this->dateService = $dateService;
    }
    public function login_form(){
        return view('Backend.Pages.Login.Login');
    }
    public function get_data(Request $request)
{
    if ($request->data == 'customer_data') {
        $response_data = Customer::latest()->take(5)->get();
        return response()->json($response_data);
    }

    if ($request->has('date')) {
        $s_date = $this->dateService->getStartDate($request->date);
        $e_date = $this->dateService->getEndDate($request->date);

        $count_entries = function ($model) use ($s_date, $e_date) {
            return $model::whereBetween('created_at', [$s_date, $e_date])->count();
        };

        $sum_invoice_amount = function ($model) use ($s_date, $e_date) {
            return $model::whereDate('created_at', '>=', $s_date)
                         ->whereDate('created_at', '<=', $e_date)
                         ->sum('paid_amount');
        };

        $total_sales_amount = $sum_invoice_amount(Customer_Invoice::class);
        $total_purchase_amount = $sum_invoice_amount(Supplier_Invoice::class);
        $total_customer = $count_entries(Customer::class);
        $total_customer_invoice = $count_entries(Customer_Invoice::class);
        $total_supplier = $count_entries(Supplier::class);
        $total_products = $count_entries(Product::class);

        /* Calculate net profit*/
        $net_profit = $total_sales_amount - $total_purchase_amount;

        $response_data = [
            'total_sales_amount' => intval($total_sales_amount),
            'total_purchase_amount' => intval($total_purchase_amount),
            'total_customer_invoice' => intval($total_customer_invoice),
            'total_customer' => intval($total_customer),
            'total_supplier' => intval($total_supplier),
            'total_products' => intval($total_products),
            'net_profit' => intval($net_profit),
            'total_customer_order' => intval($total_customer_invoice), 
            'total_quantity' => intval(Product::sum('qty')),
        ];

        return response()->json($response_data);
    }

    if ($request->data == 'get_top_rated_product') {
        $top_selling_products = DB::table('customer__invoice__details')
        ->select('product_id', DB::raw('SUM(qty) as total_qty'))
        ->groupBy('product_id')
        ->orderByDesc('total_qty')
        ->limit(5)
        ->get();

        $top_selling_products = $top_selling_products->map(function ($item) {
        $product = DB::table('products')->where('id', $item->product_id)->first();
        $product_image = DB::table('product_images')->where('product_id', $item->product_id)->first();
        return [
            'product_id' => $item->product_id,
            'total_qty' => $item->total_qty,
            'product_title' => $product ? $product->title : 'Unknown', 
            'product_image' => $product_image ? $product_image->image : 'default_image.jpg', 
        ];
    });

    return response()->json($top_selling_products);
    }
}

    public function login_functionality(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('admin.dashboard');
        }else{
            return redirect()->back()->with('error-message','Invalid Email or Password');
        }
    }
    public function dashboard()
    {
        return view('Backend.Pages.Dashboard.index');
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
