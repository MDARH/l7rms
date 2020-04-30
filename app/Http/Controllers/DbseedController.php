<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\User;
use App\StudentClass;
use App\Department;
use App\GPA;
use App\Mark;
use App\Profile;
use App\Registration;
use App\Roll;
use App\Semester;
use App\Session;
use App\Subject;
//use App\Roll;

class DbseedController extends Controller
{
    public function seed(Request $request)
    {
        // DB Seed
        
        // create a demo department
        $dept = new Department();
        $dept->name = 'Electrical and Electronics Engineering';
        $dept->dep_code = 'EEE';
        $dept->save();

        // creating a demo Class
        $sclass = new StudentClass();
        $sclass->class = 'EEE-101';
        $sclass->save();

        // creating a demo student
        $student = new User();
        $student->name = 'Rumon';
        $student->email = 'rmn@student.edu';
        $student->password = bcrypt('12345678');
        $student->save();

        $classId = StudentClass::where('id', 2)->first();
        $depId = Department::where('id', 2)->first();

        $student->department()->attach($depId);
        $student->class()->attach($classId);

        return 'Tried, now check that';
    }

    public function cls(Request $request)
    {
        $getCls = User::find($request->user)->class()->get();
        //dd($getCls);
        return response()->json($getCls, 200);
    }

    public function dep(Request $request)
    {
        $getDep = User::find($request->user)->department()->get();
        //dd($getDep);
        return response()->json($getDep, 200);
    }
}
