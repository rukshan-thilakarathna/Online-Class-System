<?php

namespace App\Jobs;

use App\Models\QandA;
use App\Models\Test;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Log;

class ProcessTestQuestionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $test;

    /**
     * Create a new job instance.
     */
    public function __construct(Test $test)
    {
        $this->test = $test;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            $excelFilePath = public_path($this->test->xml_file);
            
            $spreadsheet = IOFactory::load($excelFilePath);
            $sheet = $spreadsheet->getActiveSheet();

            $quiz = [];
            foreach ($sheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $questionData = [];
                $answerData = [];

                foreach ($cellIterator as $cell) {
                    $cellValue = $cell->getValue();
                    if ($cell->getColumn() == 'A') {
                        $questionData['question'] = $cellValue;
                    } elseif ($cell->getColumn() == 'B') {
                        $questionData['correct_answer'] = $cellValue;
                        $answerData[] = $cellValue;
                    } elseif ($cell->getColumn() == 'C') {
                        $answerData[] = $cellValue;
                    } elseif ($cell->getColumn() == 'D') {
                        $answerData[] = $cellValue;
                    } elseif ($cell->getColumn() == 'E') {
                        $answerData[] = $cellValue;
                    } elseif ($cell->getColumn() == 'F') {
                        $answerData[] = $cellValue;
                    }
                }

                $questionData['answers'] = $answerData;
                $quiz[] = $questionData;
            }

            $mark = $this->test->marks / count($quiz);
            $time = $this->test->test_time / count($quiz);

            foreach ($quiz as $questionData) {
                $question = new QandA();
                $question->question = $questionData['question'];
                $question->answer_1 = $questionData['answers'][0];
                $question->answer_2 = $questionData['answers'][1];
                $question->answer_3 = $questionData['answers'][2] ?? 'null';
                $question->answer_4 = $questionData['answers'][3] ?? 'null';
                $question->answer_5 = $questionData['answers'][4] ?? 'null';
                $question->correct_answer = $questionData['correct_answer'];
                $question->type_id = $this->test->test_type_id;
                $question->test_id = $this->test->id;
                $question->marks = $mark;
                $question->time = $time;
                $question->status = 1;

                $question->save();
            }

            Log::info('Test questions processed successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to process test questions: ' . $e->getMessage());
        }
    }
}
