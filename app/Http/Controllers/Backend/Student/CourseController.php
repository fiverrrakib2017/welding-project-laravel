<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Student_log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class CourseController extends Controller
{
    public function course_list()
    {
        $courses = DB::table('courses')->get();
        return view('Backend.Pages.Student.course', compact('courses'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        DB::table('courses')->insert([
            'name' => $request->name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Course added successfully!'
        ]);
    }
    public function edit($id)
    {
        $course = DB::table('courses')->where('id', $id)->first();
        if ($course) {
            return response()->json([
                'success' => true,
                'data' => $course
            ]);
        }
        return response()->json(['status' => 'error', 'message' => 'Course not found'], 404);
    }
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required|string|max:255',
        ]);

        DB::table('courses')->where('id', $request->id)->update([
            'name' => $request->name,
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Course updated successfully!'
        ]);
    }
    public function destroy(Request $request)
    {
        DB::table('courses')->where('id', $request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Course deleted successfully!'
        ]);
    }
}