<?php

namespace App\Orchid\Layouts\Student;

use App\Models\Student;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class GuardiansListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'guardians';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID')
            ->width('50px')
            ->filter(TD::FILTER_TEXT)
            ->sort()
            ->cantHide(),

       
                TD::make('first_name', 'First Name')
                ->filter(TD::FILTER_TEXT)
                ->sort(),
    
    
                TD::make('last_name', 'Last Name')
                ->filter(TD::FILTER_TEXT)
                ->sort(),
    
    
                TD::make('phone_number', 'Mobile Number')
                ->render(function ($model) {
                    $phone = $model->phone_number; 
                    $countryCode = $model->c_code; // Add your country code here (94 for Sri Lanka)
                    $cleanPhone = preg_replace('/[^0-9]/', '', $phone); // Clean phone number (remove non-numeric characters)
    
                    // Combine country code and phone number
                    $fullPhone = $countryCode . $cleanPhone;
    
                    $name = $model->name ?? 'there';
                    $whatsappLink = "https://wa.me/{$fullPhone}";
                    
                    return "<a style=\"
                        background: #008dd1;
                        color: white;
                        font-weight: bold;
                        padding: 11px;
                        border-radius: 3px;
                        text-decoration: none;
                    \" href=\"{$whatsappLink}\" target=\"_blank\">{$fullPhone}</a>";
                })
                ->filter(TD::FILTER_TEXT)
                ->sort(),
    
    
                TD::make('address', 'Address')
                ->filter(TD::FILTER_TEXT)
                ->defaultHidden()
                ->width('150px')
                ->sort(),
    
                TD::make('email', 'Email')
                ->filter(TD::FILTER_TEXT)
                ->defaultHidden()
                ->sort(),
    
                TD::make('gender', 'Gender')
                ->sort()
                ->render(fn (Student $student) => $student->gender == 0 ? 'Male' : 'Female')
                ->filter(TD::FILTER_SELECT, [
                    '' => 'All',
                    '0' => 'Male',
                    '1' => 'Female'
                ]),
    
                
    
                TD::make('status', 'Status')
                ->sort()
                ->render(fn (Student $student) => $student->status == 1 ? 'Active' : 'Inactive')
                ->filter(TD::FILTER_SELECT, [
                    '' => 'All',
                    '1' => 'Active',
                    '0' => 'Inactive'
                ]),
    
                



            
        ];
    }
}
