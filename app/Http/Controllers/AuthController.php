<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentHasClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{



    public function RegisterStore(Request $request)
    {
        $big_student_id = Student::where('class_type','online')->max('student_id') ?? 0;

        $online_class_student_id = $big_student_id + 1;

        // Validate the request data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|numeric|digits_between:10,15|unique:students,phone_number',
            'gender' => 'required|in:0,1',
            'password' => 'required|string|min:8',
            'type' => 'required|in:student,guardian',
            'grade' => $request->type === 'student' ? 'required|integer|min:1|max:11' : 'nullable',
            'student_id' => $request->class_type === 'physical' ? 'numeric|unique:students,student_id' : 'nullable',
            'class_type' => $request->type === 'student' ? 'required' : 'Guardian Account',
        ]);

        // If the class type is not physical, assign the default student ID
        if ($request->class_type !== 'physical') {
            $validatedData['student_id'] = $online_class_student_id;
        }



        // Hash the password before storing
        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['email'] = $validatedData['first_name'].rand(10000, 99999).'@gmail.com';
        $validatedData['type'] = $validatedData['type'] == 'student' ? 0 : 1;
        $validatedData['c_code'] = $request->c_code;

        // Create a new user (assuming you have a User model and 'users' table)
        $user = Student::create($validatedData);

        // Store user information in the session
        Session::put('user_id', $user->id);
        Session::put('user_type', $user->type);
        Session::put('user', $user);


        // Redirect or respond with success
        return redirect()->route('dashboard')->with('success', 'Registration successful! Welcome!');
    }


    public function LoginStore(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'phone_number' => 'required|numeric|digits_between:10,15',
            'password' => 'required|string|min:8'
        ]);

        // Check if the user exists with the given phone number
        $user = Student::where('phone_number', $validatedData['phone_number'])->first();

        if ($user && Hash::check($validatedData['password'], $user->password)) {
            Session::put('user_id', $user->id);
            Session::put('user_type', $user->type);
            Session::put('user', $user);

            if  ($user->type == 0) {
                return redirect()->route('dashboard')->with('success', 'Login successful');
            }elseif($user->type == 1) {
                return redirect()->route('dashboard')->with('success', 'Login successful');
            }

        } else {

            return redirect()->back()->with('error', 'Invalid phone number or password');

        }
    }

    public function logout()
    {
        // Log the user out
        Auth::logout(); // This will log out the user via Laravel's built-in authentication

        // Optionally, clear the session data
        Session::flush(); // Clears all session data (optional if you use `Auth::logout()`)

        // Redirect the user to the login page (or any other page)
        return redirect()->route('index'); // Change 'login' to your route name
    }


}
