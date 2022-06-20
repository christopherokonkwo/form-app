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
            'machine_number' => 'required|string',
            'phone' => 'required|string',
            'incident_detail_option' => 'required|string',
            'incident_details' => 'nullable|string',
            'incident_causes' => 'required|string',
            'incident_status' => 'required|string',
            'additional_notes' => 'nullable|string',
            'date' => 'required|string',
            'location' => 'required|string',
            'time' => 'required|string',
            'police_notified' => 'nullable|integer',
            'recieved_by' => 'nullable|string',
            'recieved_at' => 'nullable|string',
            'reported_by'=> 'nullable|string',
            'solved_by'=> 'nullable|string',
        ];
    }
}
