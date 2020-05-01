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
        $currentId = 1;
        $cstId = 1;
        
        // create a demo department
        $dept = new Department();
        $dept->name = 'Computer Science and Engineering';
        $dept->dep_slug = 'CSE';
        $dept->dep_code = 3125;
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
        // create student Profile
        $profile = new Profile();
        $profile->user_id = $cstId;
        $profile->save();
        //$profile->student()->attach($cstId);

        $student->department()->attach($depId);
        $student->class()->attach($classId);
        // create student roll
        $roll = new Roll();
        $roll->roll = $depId->dep_code . 20201 . 10 . $cstId;
        $roll->user_id = $cstId;
        $roll->save();

        // Rolls and Class relation Attaching
        $roll->class()->attach($classId);


        $reg = new Registration();
        $reg->registration = time();
        $reg->roll_id = $cstId;
        $reg->user_id = $cstId;
        $reg->save();

        return response()->json('New Student added with dep cls profile!', 201);
    }

    // multiple students in single class + dep Testing
    public function newuser(Request $request)
    {
        $currentId = 1; // for dep

        // creating a demo Class
        //$sclass = new StudentClass();
        //$sclass->class = 'CSE-102';
        //$sclass->save(); // new class created
        
        // take this student dep n cls
        $classId = StudentClass::where('id', $currentId)->first(); // getting this new class
        $depId = Department::where('id', $currentId)->first();

        //attach this new class with department
        //$classId->department()->attach($depId);


        // creating a new demo student
        $student = new User();
        $student->name = 'Amazad';
        $student->email = 'amz@student.edu';
        $student->password = bcrypt('12345678');
        $student->save();

        $student->department()->attach($depId);
        $student->class()->attach($classId);

        // roll , registration and profile
        // create student Profile
        $profile = new Profile();
        $profile->user_id = $currentId;
        $profile->save();
        //$profile->student()->attach($cstId);

        // create student roll
        $roll = new Roll();
        $roll->roll = $depId->dep_code . 20201 . 10 . 2;
        $roll->user_id = 2;
        $roll->save();

        // Rolls and Class relation Attaching
        $roll->class()->attach($currentId);


        $reg = new Registration();
        $reg->registration = time();
        $reg->roll_id = 2;
        $reg->user_id = 2;
        $reg->save();


        return response()->json('New Student added!', 201);

    }

    // new department with a class
    public function newdepcls(Request $request)
    {
        $currentId = 2;

        // make new department
        $dept = new Department();
        $dept->name = 'Electrical and Electronics Engineering';
        $dept->dep_slug = 'EEE';
        $dept->dep_code = 555;
        $dept->save();

        // make new Class
        $sclass = new StudentClass();
        $sclass->class = 'EEE-101';
        $sclass->save();

        // Department and Class attach
        $classId = StudentClass::where('id', $currentId)->first();
        $depId = Department::where('id', $currentId)->first();

        $dept->classes()->attach($classId); // making relational with class

        return response()->json('New Department and Class are created!', 201);
    }


    // new class only
    public function newcls()
    {
        //
    }



    public function cls(Request $request)
    {
        $getCls = StudentClass::where('class', $request->user)->first();
        //dd($getCls);
        $getResult = [
            'Class_info'    =>  $getCls->department()->get(),
            'Students'      =>  $getCls->rolls()->get()
        ];
        return response()->json($getResult, 200);
    }

    public function dep(Request $request)
    {
        $findDept   = Department::find($request->user);
        $getResult  = $findDept->classes()->get();
        //dd($getResult);
        return response()->json($getResult, 200);
    }

    public function deptocls(Request $request)
    {
        //$getResult = Department::find($request->dep_code)->classes()->get();
        $findDep = Department::where('dep_slug', $request->dep_slug)->first();
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
        $getStudents = $findCls->rolls()->get();
        $getDep = $findCls->department()->get();
        //dd($findCls->department()->get());
        $getResult = [
            'Department'   =>  $getDep,
            'Students'  =>  $getStudents
        ];
        return response()->json($getResult, 200);
    }

    public function getuser(Request $request)
    {
        $findST = User::where('id', $request->id)->first();
        $getCls = $findST->class()->get();
        $getDep = $findST->department()->get();
        $getProfile = $findST->profile()->get();
        $getRoll = $findST->roll()->get();
        $getReg = $findST->registration()->get();
        //dd($findCls->department()->get());
        $getResult = [
            'Profile'       =>  $getProfile,
            'Department'    =>  $getDep,
            'Class'         =>  $getCls,
            'Roll'          =>  $getRoll,
            'Registration'  =>  $getReg
        ];
        return response()->json($getResult, 200);
    }


    public function roll(Request $request)
    {
        $findByRoll = Roll::where('roll', $request->roll)->first();
        //dd($findByRoll);
        $getStudent = $findByRoll->student()->get();
        $getReg     = $findByRoll->registration()->get();
        $getClass   = $findByRoll->class()->get();
        $getResult = [
            'Student'       =>  $getStudent,
            'Registration'  =>  $getReg,
            'Class'         =>  $getClass
        ];
        return response()->json($getResult, 200);
    }


}
