<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
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
            'location' => 'required|string',
            'machine_number' => 'required|string',
            'machine_type' => 'required|string',
            'incident_detail_option' => 'required|string',
            'incident_details' => 'nullable|string',
            'additional_notes' => 'nullable|string',
            'recieved_by' => 'nullable|string',
            'reported_by'=> 'nullable|string',
            // 'assigned_to'=> 'nullable|array',
            'assigned_at' => 'nullable|string',
            'status' => 'nullable|string',

            'assigned_user' => 'nullable|array',
        ];
    }
}
