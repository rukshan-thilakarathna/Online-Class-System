<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class StudentController extends Controller
{
    public $smsService;
    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('guardian.student-form');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'grade' => 'required|string|max:10',
            'birthday' => 'required|date',
            'gender' => 'required|string|in:0,1,other',

        ]);

        if($request->class_type == 'online'){
            $big_student_id = Student::where('class_type','online')->max('student_id') ?? 0;
            $online_class_student_id = $big_student_id + 1;
        }else{
            $online_class_student_id = $request->student_number;
        }


        // $big_student_id = Student::where('class_type','online')->max('student_id') ?? 0;
        // $online_class_student_id = $big_student_id + 1;

        $validatedData['type'] = 0;
        $validatedData['student_id'] = $online_class_student_id;
        $validatedData['class_type'] = $request->class_type;
        $validatedData['guardian_id'] = session()->get('user')->id;
        $validatedData['email'] = "onlineStudent".$online_class_student_id."@gmail.com";
        $validatedData['phone_number'] = session()->get('user')->phone_number;
        $validatedData['c_code'] = session()->get('user')->c_code;
        $validatedData['password'] = session()->get('user')->password;
        $validatedData['whatsapp_number'] = session()->get('user')->whatsapp_number;
        $validatedData['address'] = session()->get('user')->address;
        $validatedData['status'] =1;


        // Create a new student record
        $student = Student::create($validatedData);

        // Redirect to a success page or back with a success message
        return redirect()->route('dashboard')->with('success', 'Student created successfully!');

    }

    public  function Login($id)
    {
        $user = Student::where('id', $id)->first();

        Session::put('user_id', $user->id);
        Session::put('user_type', $user->type);
        Session::put('user', $user);

        if  ($user->type == 0) {
            return redirect()->route('dashboard')->with('success', 'Login successful');
        }elseif($user->type == 1) {
            return redirect()->route('dashboard')->with('success', 'Login successful');
        }
    }


    public function forget01(){
        return view('forget1');
/*************  ✨ Codeium Command 🌟  *************/
    }
     public function forget02(){
        return view('forget2'); 
/******  a79ea56a-e2ea-4952-8e69-16a59e9461f6  *******/
    }

    public function PostForget01(Request $request)
{
    $request->validate([
        'phone_number' => 'required|numeric|digits:10',
    ], [
        'phone_number.required' => 'The phone number is required.',
        'phone_number.numeric' => 'The phone number must contain only numbers.',
        'phone_number.digits' => 'The phone number must be exactly 10 digits long.',
    ]);

    $phoneNumber = $request->input('phone_number');



    $existingStudent = Student::where('phone_number', $phoneNumber)->first();
    if (!$existingStudent) {
        return redirect()->back()->with('error', 'Phone number not found.');
    }

    $otp = rand(100000, 999999);

    try {
        $otpMessage = "Your OTP code is: " . $otp;
        $countryCode = $existingStudent->c_code; // Add your country code here (94 for Sri Lanka)
        $cleanPhone = preg_replace('/[^0-9]/', '', $phoneNumber); // Clean phone number (remove non-numeric characters)

        // Combine country code and phone number
        $fullPhone = $countryCode . $cleanPhone;

        $this->smsService->sendSingleSms($fullPhone, $otpMessage);

        session(['otp' => Hash::make($otp), 'forgotPhoneNumber' => $phoneNumber]);

        return redirect()->route('student-comfirmOtpView')->with('error', $otpMessage);;
    } catch (\Exception $e) {
        Log::error('Failed to send OTP', [
            'error' => $e->getMessage(),
            'phone_number' => $phoneNumber,
        ]);
        return response()->json(['message' => 'Failed to send OTP'], 500);
    }
}

    public function PostForget02(Request $request)
    {

        $request->validate([
            'otp' => 'required|numeric|digits:6',
            'password' => 'required|min:8',
        ]);

        $otp = $request->input('otp');
        $password = $request->input('password');

        if (Hash::check($otp, session('otp'))) {

          
            $otpMessage = "Your New Password is: " . $password;

            $user = Student::where('phone_number', session('forgotPhoneNumber'))->first();
            $user->password = Hash::make($password);
            $user->save();

            $countryCode = $user->c_code;
            $cleanPhone = preg_replace('/[^0-9]/', '', session('forgotPhoneNumber'));
            $fullPhone = $countryCode . $cleanPhone;
            $this->smsService->sendSingleSms($fullPhone, $otpMessage);

           

            return redirect()->route('login','student')->with('success', 'Password changed successfully');
        } else {
            return redirect()->route('student-forget')->with('error', 'Invalid OTP');
        }
        
    }



    
}
