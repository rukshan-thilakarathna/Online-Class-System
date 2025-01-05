<?php

namespace App\Jobs;

use App\Models\Payment;
use App\Models\PaymentHasClass;
use App\Models\StudentHasClass;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessPaymentRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $classId;
    protected $monthId;
    protected $userId;

    public function __construct($classId, $monthId, $userId)
    {
        $this->classId = $classId;
        $this->monthId = $monthId;
        $this->userId = $userId;
    }

    public function handle()
    {
        try {
            // Retrieve existing payment record for the class and student
            $paymenHasClass = PaymentHasClass::firstOrNew([
                'class_id' => $this->classId,
                'student_id' => $this->userId
            ]);

            // Create payment record
            Payment::create([
                'class_id' => $this->classId,
                'user_id' => $this->userId,
                'month_id' => $this->monthId,
                'slip' => ' ',
            ]);

            // Update payment status for the specific month
            $paymenHasClass->{$this->monthId} = 2;
            $paymenHasClass->save();

            // Handle student's access records
            $studentHasClass = StudentHasClass::firstOrNew([
                'student_id' => $this->userId,
                'class_id' => $this->classId,
            ]);

            // Update access fields with the new month
            $studentHasClass->payment_has_classes_id = $studentHasClass->payment_has_classes_id ?? $paymenHasClass->id;
            $studentHasClass->video_access = $this->appendToAccessField($studentHasClass->video_access, $this->monthId);
            $studentHasClass->test_access = $this->appendToAccessField($studentHasClass->test_access, $this->monthId);
            $studentHasClass->tute_access = $this->appendToAccessField($studentHasClass->tute_access, $this->monthId);
            $studentHasClass->save();

        } catch (Exception $e) {
            // Log the error for debugging
            Log::error('Payment request failed: ' . $e->getMessage());

            // Optionally, rethrow the exception for retries
            throw $e;
        }
    }

    // Helper function to append month to access field
    private function appendToAccessField($accessField, $monthId)
    {
        $currentAccess = !empty($accessField) ? explode(',', $accessField) : [];
        if (!in_array($monthId, $currentAccess)) {
            $currentAccess[] = $monthId;
        }
        return implode(',', $currentAccess);
    }
}
