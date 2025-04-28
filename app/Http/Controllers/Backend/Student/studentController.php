<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Services\DateService;
class studentController extends Controller
{
    public function index(){
        return view('Backend.Pages.Student.index');
    }
    public function create(){
        return view('Backend.Pages.Student.create');
    }

}
