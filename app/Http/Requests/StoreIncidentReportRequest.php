<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncidentReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'phone' => 'required|string',
            'machine_number' => 'required|string',
            'machine_type' => 'required|string',
            'incident_detail_option' => 'required|string',
            'incident_details' => 'nullable|string',
            'additional_notes' => 'nullable|string',
            'location' => 'required|string',
            'recieved_by' => 'nullable|string',
            'recieved_at' => 'nullable|string',
            'reported_by'=> 'nullable|string',
            'solved_by'=> 'nullable|string',
        ];
    }
}
