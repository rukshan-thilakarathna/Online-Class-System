<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Classes\ClassController;
use App\Jobs\ProcessPaymentRequest;
use App\Jobs\ProcessPaymentSubmissionJob;
use App\Models\Classes;
use App\Models\Payment;
use App\Models\PaymentHasClass;
use App\Models\Student;
use App\Models\StudentHasClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PageRouteController extends Controller
{
    public function IndexPage()
    {
        return view('index');
    }

    public function dashboardPage(ClassController $classController)
    {


        if (session()->has('user_id')  && session()->get('user_type') == 0) {

            $studentClasses = $classController->getStudentHasClass();
            $RelatedClass = $classController->RelatedClass();


            return view('student.index', compact('studentClasses','RelatedClass'));


        }elseif (session()->has('user_id') && session()->get('user_type') == 1) {

            $students = Student::where('guardian_id', session()->get('user_id'))->get();
            return view('guardian.index' , compact('students'));

        }else{
            return redirect()->route('login', 'student');
        }


    }

    public function ClassesPage(ClassController $classController)
    {
        if  (session()->has('user_id')) {

            $studentClasses = $classController->getStudentHasClass();
            return view('student.classes.index', compact('studentClasses'));

        }else{
            return redirect('/login/student');
        }
    }

    public function ClassesProfilePage($id , ClassController $classController)
    {
        if  (session()->has('user_id')) {

            $classProfile = $classController->ClassProfile($id);
            return view('student.classes.profile', compact('classProfile'));

        }else{
            return redirect('/login/student');
        }
    }
    public function TesdtPage($id , ClassController $classController , $class)
        {


            if  (session()->has('user_id')) {

                $QA = $classController->StartTest($id);
                $class_id = $class;
                return view('student.classes.test', compact('QA','class_id'));

            }else{
                return redirect('/login/student');
            }
        }

    public function loginPage($type)
    {
        if  (session()->has('user_id')) {
            if  (session()->get('user_type') == 0) {
                return view('student.index');
            }else{
                return view('guardian.index');
            }
        }else{
            return view('login', compact('type'));
        }
    }

    public function registerPage($type)
    {
        if  (session()->has('user_id')) {
            if  (session()->get('user_type') == 0) {
                return view('student.index');
            }else{
                return view('guardian.index');
            }
        }else{
            return view('register', compact('type'));
        }

    }

    public function TestResult($test_id , ClassController $classController ){

        if  (session()->has('user_id')) {

            $QA = $classController->StartTest($test_id);
            return view('student.classes.test-result', compact('QA'));

        }else{
            return redirect('/login/student');
        }


    }

    public function PaymentPage($class_id = null, $month_id = null)
    {
        $class_id = $class_id ?? 0;
        $month_id = $month_id ?? 0;

        $amount = Classes::find($class_id)->class_fees;
        
        return view('student.payment', compact('class_id', 'month_id', 'amount'));
    }

    public function SendRequest($class_id, $month_id)
    {
        // Get the user ID from the session
        $userId = session()->get('user_id');
        $randomDelay = rand(1, 20) * 60; // Delay in seconds
        // Dispatch the job to the queue
        ProcessPaymentRequest::dispatch($class_id, $month_id, $userId)->delay(now()->addSeconds($randomDelay));
    
        // Redirect with a success message
        return redirect()->route('classes.profile', $class_id)
            ->with('success', 'Request successfully submitted! It has been forwarded for review. (ඉල්ලීම සාර්ථකව ඉදිරිපත් කර ඇත! එය පරික්ෂා කිරීමට යොමුකර ඇත)');
    }

    public function PaymentSubmit(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'slip' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $paymenHasClass = PaymentHasClass::firstOrNew([
            'class_id' => $request['class_id'],
            'student_id' => session()->get('user_id')
        ]);

        // Check if the payment is already submitted for this month
        if (!empty($paymenHasClass->{$request['month_id']}) && $paymenHasClass->{$request['month_id']} != 0) {
            Log::info('Payment already submitted for student ' . session()->get('user_id'));
            return redirect()->back()->with('error', 'Payment already submitted for this month.');
        }else{
            $file = $request->file('slip');
            $slipName = time() . '_' . $file->getClientOriginalName(); // Unique file name
            $file->move(public_path('slip'), $slipName); // Move file to 'public/slip'
        
            // Prepare data for the job
            $data = [
                'class_id' => $request->class_id,
                'student_id' => session()->get('user_id'),
                'month_id' => $request->month_id,
                'slip_name' => $slipName, // Pass the file name instead of UploadedFile
            ];
    
            $randomDelay = rand(1, 20) * 60; // Delay in seconds
        
            // Dispatch the job
            ProcessPaymentSubmissionJob::dispatch($data)->delay(now()->addSeconds($randomDelay));
        
     
        
        
            $message = 'Payment submitted successfully! It has been forwarded for review. (ගෙවීම සාර්ථකව ඉදිරිපත් කර ඇත! එය පරික්ෂා කිරීමට යොමුකර ඇත)';
            return redirect()->route('dashboard')->with('success', $message);
        }
    
       
    

    // Random delay between 1 minute and 20 minutes
  
}

    /**
     * Append a new value to a comma-separated field, ensuring no duplicates.
     *
     * @param string|null $field
     * @param string $value
     * @return string
     */
    private function appendToAccessField(?string $field, string $value): string
    {
        $values = array_filter(explode(',', $field)); // Convert field to array
        $values[] = $value; // Add the new value
        return implode(',', array_unique($values)); // Ensure uniqueness and re-convert to string
    }



}
