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
        $currentId = 2;
        
        // create a demo department
        $dept = new Department();
        $dept->name = 'Computer Science and Engineering';
        $dept->dep_code = 'CSE';
        $dept->save();

        // creating a demo Class
        $sclass = new StudentClass();
        $sclass->class = 'CSE-101';
        $sclass->save();

        // Department and Class attach
        $classId = StudentClass::where('id', $currentId)->first();
        $depId = Department::where('id', $currentId)->first();

        $dept->classes()->attach($classId); // making relational with class

        // creating a demo student
        $student = new User();
        $student->name = 'Mahabub';
        $student->email = 'mahabub@student.edu';
        $student->password = bcrypt('12345678');
        $student->save();

        $student->department()->attach($depId);
        $student->class()->attach($classId);

        return 'Tried, now check that';
    }

    // multiple students in single class + dep Testing
    public function multistu(Request $request)
    {
        $currentId = 1; // for dep and cls

        // take this student dep n cls
        $classId = StudentClass::where('id', $currentId)->first();
        $depId = Department::where('id', $currentId)->first();

        // creating a new demo student
        $student = new User();
        $student->name = 'Zahid';
        $student->email = 'zhd@student.edu';
        $student->password = bcrypt('12345678');
        $student->save();

        $student->department()->attach($depId);
        $student->class()->attach($classId);

        return response()->json('New Student added!', 201);


    }

    public function cls(Request $request)
    {
        $getCls = User::find($request->user)->class()->get();
        //dd($getCls);
        return response()->json($getCls, 200);
    }

    public function dep(Request $request)
    {
        $getResult = User::find($request->user)->department()->get();
        //dd($getResult);
        return response()->json($getResult, 200);
    }

    public function deptocls(Request $request)
    {
        //$getResult = Department::find($request->dep_code)->classes()->get();
        $findDep = Department::where('dep_code', $request->dep_code)->first();
        $getStudents = $findDep->students()->get();
        $getClasses = $findDep->classes()->get();
        //dd($findDep->classes()->get());

        $getResult = [
            'Classes'   =>  $getClasses,
            'Students'  =>  $getStudents
        ];
        return response()->json($getResult, 200);
    }

    public function clstodep(Request $request)
    {
        //$getResult = StudentClass::find($request->class)->department()->get();
        $findCls = StudentClass::where('class', $request->class)->first();
        $getStudents = $findCls->students()->get();
        $getDep = $findCls->department()->get();
        //dd($findCls->department()->get());
        $getResult = [
            'Department'   =>  $getDep,
            'Students'  =>  $getStudents
        ];
        return response()->json($getResult, 200);
    }


}
