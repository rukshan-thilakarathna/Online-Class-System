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

class ProcessPaymentSubmissionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            $data = $this->data;

            // Retrieve or create PaymentHasClass
            $paymenHasClass = PaymentHasClass::firstOrNew([
                'class_id' => $data['class_id'],
                'student_id' => $data['student_id']
            ]);

            // Check if the payment is already submitted for this month
            if (!empty($paymenHasClass->{$data['month_id']}) && $paymenHasClass->{$data['month_id']} != 0) {
                Log::info('Payment already submitted for student ' . $data['student_id']);
                return;
            }

            // Save payment record
            Payment::create([
                'class_id' => $data['class_id'],
                'user_id' => $data['student_id'],
                'month_id' => $data['month_id'],
                'slip' => $data['slip_name'], // Use file name
            ]);

            // Update payment status
            $paymenHasClass->{$data['month_id']} = 2;
            $paymenHasClass->save();

            // Update student's access records
            $studentHasClass = StudentHasClass::firstOrNew([
                'student_id' => $data['student_id'],
                'class_id' => $data['class_id'],
            ]);

            $monthId = $data['month_id'];
            $studentHasClass->payment_has_classes_id = $studentHasClass->payment_has_classes_id ?? $paymenHasClass->id;
            $studentHasClass->video_access = $this->appendToAccessField($studentHasClass->video_access, $monthId);
            $studentHasClass->test_access = $this->appendToAccessField($studentHasClass->test_access, $monthId);
            $studentHasClass->tute_access = $this->appendToAccessField($studentHasClass->tute_access, $monthId);
            $studentHasClass->save();

            Log::info('Payment successfully processed for student ' . $data['student_id']);
        } catch (Exception $e) {
            // Log the error
            Log::error('Payment submission failed: ' . $e->getMessage());

            // Optionally rethrow the exception for job retries
            throw $e;
        }
    }

    /**
     * Append month to access field.
     */
    private function appendToAccessField($accessField, $monthId)
    {
        $currentAccess = !empty($accessField) ? explode(',', $accessField) : [];
        if (!in_array($monthId, $currentAccess)) {
            $currentAccess[] = $monthId;
        }
        return implode(',', $currentAccess);
    }
}
