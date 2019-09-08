<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class StoreObjectRequest extends FormRequest
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
        $districts = ['Москва, ЦАО', 'Москва, САО', 'Москва, СВАО', 'Москва, ВАО', 'Москва, ЮВАО', 'Москва, ЮАО', 'Москва, ЮЗАО', 'Москва, СЗАО', 'Новая Москва и Зеленоград', 'Московская область'];
        return [
            'images' => 'required|array',
            'images.*.id' => ['required', 'integer', 'exists:files,id'],
            'images.*.caption' => [
                'required_if:type,ZU',
                Validator::extend('foo', function ($attribute, $value, $parameters, $validator) {
                    if ($parameters['type'] === 'Invest') return true;
                    if (gettype($value) === 'string') return true;
                    return false;
                }),
            ],
            'images.*.filename' => 'required|string',
            'images.*.isMain' => 'required|boolean',
            'docs' => 'array',
            'docs.*.id' => ['required', 'integer', 'exists:files,id'],
            'cost' => 'required|numeric',
            'type' => 'required|string|in:ZU,Invest',
            'areaS' => [
                Rule::requiredIf(($this->type === 'ZU' && $this->ZUType === 'ОКС') || $this->type === 'Invest'),
                'numeric'
            ],
            'ZUType' => 'required_if:type,ZU|string|in:ЗУ,ОКС',
            'address' => 'required|string',
            'groundS' => 'required_if:type,ZU|numeric',
            'district' => [
                'required',
                'string',
                Rule::in($districts),
            ],
            'location' => 'required|string|in:Moscow,MO,New_Moscow',
            'purposeZU' => 'required_if:type,ZU|string|in:Жилое,Нежилое',
            'groundPlan' => 'required_if:type,ZU|boolean',
            'purposeOKS' => [
                Rule::requiredIf($this->type === 'ZU' && $this->ZUType === 'ОКС'),
                'string',
                'in:Жилое,Нежилое,Апартаменты'
            ],
            'coordinates' => 'required|array',
            'coordinates.*' => 'required|numeric',
            'costCurrency' => 'required|string|in:rouble,dollar,euro',
            'kadastrNumberZU' => 'required_if:type,ZU|string',
            'kadastrNumberOKS' => [
                Rule::requiredIf($this->type === 'ZU' && $this->ZUType === 'ОКС'),
                'string'
            ],
            'responsible' => 'string',
            'description' => 'required|string',
            'GAP' => 'required_if:type,Invest|numeric',
            'GAPCurrency' => 'required_if:type,Invest|string|in:rouble,dollar,euro',
            'caprate' => 'required_if:type,Invest|numeric',
            'buildingName' => 'required_if:type,Invest|string',
            'buildingType' => 'required_if:type,Invest|array',
            'buildingType.short' => 'required_if:type,Invest|string',
            'buildingType.full' => 'required_if:type,Invest|string',
            'buildingType.bg' => 'required_if:type,Invest|string',
            'buildingType.icon' => 'required_if:type,Invest|string',
            'only_auth' => 'required|boolean',
            'price_admins_only' => 'required|boolean',
            'object_admins_only' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }
}
