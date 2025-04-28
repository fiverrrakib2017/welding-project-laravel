<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Customer_Invoice;
use App\Models\Pop_area;
use App\Models\Product;
use App\Models\Product_Order;
use Illuminate\Support\Facades\DB;
use App\Models\Supplier;
use App\Models\Customer_recharge;
use App\Models\Ticket;
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
