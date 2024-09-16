<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image,
            'class_type' => $this->class_type,
            'class_category' => $this->class_category,
            'grade' => $this->grade,
            'class_fees' => $this->class_fees,
            'class_fees_date' => $this->class_fees_date,
            'class_year' => $this->class_year,
            'class_start_date' => $this->class_start_date,
            'class_date' => $this->class_date,
            'status' => $this->status,
        ];
    }
}

