<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ObjectPdfRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'object' => 'required|array',
            'object.id' => 'required|integer',
            'object.type' => 'required|string|in:ZU,Invest',
            'object.district' => 'required|string',
            'object.description' => 'required|string',
            'object.address' => 'required|string',
            'object.ZUType' => 'required_if:object.type,ZU|string',
            'object.groundS' => 'required_if:object.type,ZU|string',
            'object.purposeZU' => 'required_if:object.type,ZU|string',
            'object.purposeOKS' => [
                Rule::requiredIf($this->object['type'] === 'ZU' && $this->ZUType === 'ОКС'),
                'string',
            ],
            'object.groundPlan' => 'required_if:object.type,ZU|boolean',
            'object.buildingType' => 'required_if:object.type,Invest|array',
            'object.buildingType.full' => 'required_if:object.type,Invest|string',
            'object.buildingName' => 'required_if:object.type,Invest|string',
            'object.areaS' => 'required_if:object.type,Invest|string',
            'object.GAP' => 'required_if:object.type,Invest|string',
            'object.caprate' => 'required_if:object.type,Invest|numeric',
            'object.cost' => 'present|string|nullable',
            'object.images' => 'required|array',
            'object.images.*.filename' => 'required|regex:/^[a-z0-9]+\.jpg$/i',
            'object.images.*.caption' => 'present|string|nullable',
        ];
    }

    protected function prepareForValidation()
    {
        if (!$this->ajax()) {
            $this->merge([
                'object' => json_decode($this->object, true)
            ]);
        }
    }
}
