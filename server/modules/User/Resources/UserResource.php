<?php

namespace Modules\User\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'company_name' => $this->company_name,
            'legal_form_id' => $this->legal_form_id,
            'country_id' => $this->country_id,
            'sector_id' => $this->sector_id,
            'annual_revenue' => $this->annual_revenue,
            'number_of_employees' => $this->number_of_employees,
            'number_of_locations' => $this->number_of_locations,
            'reporting_period' => $this->reporting_period,
            'parent_company_id' => $this->parent_company_id,
            'is_subsidiary' => $this->is_subsidiary,
            'country' => $this->whenLoaded('country'),
            'sector' => $this->whenLoaded('sector'),
            'legal_form' => $this->whenLoaded('legalForm'),
            'parent_company' => $this->whenLoaded('parentCompany'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
