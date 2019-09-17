<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListPdfRequest extends FormRequest
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
        // dd(gettype($this->objects[0]['cost']));
        return [
            'currentCategorySlug' => 'required|string|in:ZU,Invest',
            'objects' => 'required|array',
            'objects.*.district' => 'required|string',
            'objects.*.address' => 'required|string',
            'objects.*.ZUType' => 'required_if:currentCategorySlug,ZU|string',
            'objects.*.groundS' => 'required_if:currentCategorySlug,ZU|string',
            'objects.*.purposeZU' => 'required_if:currentCategorySlug,ZU|string',
            'objects.*.purposeOKS' => [
                Rule::requiredIf($this->currentCategorySlug === 'ZU' && $this->ZUType === 'ОКС'),
                'string',
            ],
            'objects.*.groundPlan' => 'required_if:currentCategorySlug,ZU|boolean',
            'objects.*.buildingType' => 'required_if:currentCategorySlug,Invest|array',
            'objects.*.buildingType.short' => 'required_if:currentCategorySlug,Invest|string',
            'objects.*.buildingName' => 'required_if:currentCategorySlug,Invest|string',
            'objects.*.areaS' => 'required|string',
            'objects.*.GAP' => 'required_if:currentCategorySlug,Invest|string',
            'objects.*.caprate' => 'required_if:currentCategorySlug,Invest|integer',
            'objects.*.cost' => 'present|string|nullable',
            'objects.*.images' => 'required|array',
            'objects.*.images.*.filename' => 'required|regex:/^[a-z0-9]+\.jpg$/i',
            'objects.*.images.*.caption' => 'present|string|nullable',
        ];
    }

    protected function prepareForValidation()
    {
        if (!$this->ajax()) {
            $this->merge([
                'currentCategorySlug' => $this->currentCategorySlug,
                'objects' => json_decode($this->objects, true)
            ]);
        }
    }
}
