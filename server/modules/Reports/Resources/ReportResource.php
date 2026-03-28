<?php

namespace Modules\Reports\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => $this->whenLoaded('user'),
            'section1' => $this->whenLoaded('section1'),
            'section2' => $this->whenLoaded('section2'),
            'section3' => $this->whenLoaded('section3'),
            'section4' => $this->whenLoaded('section4'),
            'section5' => $this->whenLoaded('section5'),
            'section6' => $this->whenLoaded('section6'),
            'section7' => $this->whenLoaded('section7'),
            'frameworks' => $this->whenLoaded('frameworks'),
            'certifications' => $this->whenLoaded('certifications'),
        ];
    }
}
