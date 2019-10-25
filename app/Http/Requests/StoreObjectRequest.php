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
        $rules = $this->any();
        if ($this->type === 'ZU') {
            $rules = array_merge($rules, $this->zu());
        } elseif ($this->type === 'Invest') {
            $rules = array_merge($rules, $this->invest());
        } elseif ($this->type === 'Retail') {
            $rules = array_merge($rules, $this->retail());
        }
        return $rules;
    }

    public function messages()
    {
        return [
            //
        ];
    }

    public function any()
    {
        $districts = ['Москва, ЦАО', 'Москва, САО', 'Москва, СВАО', 'Москва, ВАО', 'Москва, ЮВАО', 'Москва, ЮАО', 'Москва, ЮЗАО', 'Москва, ЗАО', 'Москва, СЗАО', 'Новая Москва и Зеленоград', 'Московская область'];

        return [
            'type' => 'required|string|in:ZU,Invest,Retail',
            'images' => 'required|array',
            'images.*.id' => ['required', 'integer', 'exists:files,id'],
            'images.*.caption' => [
                'present',
                'string',
                'nullable'
            ],
            'images.*.filename' => 'required|string',
            'images.*.isMain' => 'required|boolean',
            'docs' => 'array',
            'docs.*.id' => ['required', 'integer', 'exists:files,id'],
            'cost' => 'required|numeric',
            'address' => 'required|string',
            'district' => [
                'required',
                'string',
                Rule::in($districts),
            ],
            'location' => 'required|string|in:Moscow,MO,New_Moscow',
            'coordinates' => 'required|array',
            'coordinates.*' => 'required|numeric',
            'costCurrency' => 'required|string|in:rouble,dollar,euro',
            'responsible' => 'required|string',
            'description' => 'required|string',
            'only_auth' => 'required|boolean',
            'price_admins_only' => 'required|boolean',
            'object_admins_only' => 'required|boolean',
            'hide_company_info_in_tizer' => 'required|boolean',
        ];
    }

    public function zu()
    {
        return [
            'areaS' => 'required_if:ZUType,ОКС|numeric',
            'ZUType' => 'required|string|in:ЗУ,ОКС',
            'groundS' => 'required|numeric',
            'purposeZU' => 'required|string|in:Жилое,Нежилое,Апартаменты',
            'groundPlan' => [
                'required',
                Rule::in([true, false, 'in_process']),
            ],
            'purposeOKS' => 'required_if:ZUType,ОКС|string|in:Жилое,Нежилое,Апартаменты',
            'kadastrNumberZU' => 'string',
            'kadastrNumberOKS' => 'string',
        ];
    }

    public function invest()
    {
        return [
            'areaS' => 'required|numeric',
            'GAP' => 'numeric',
            'GAPCurrency' => 'required_with:GAP|string|in:rouble,dollar,euro',
            'caprate' => 'numeric',
            'buildingName' => 'required|string',
            'buildingType' => 'required|array',
            'buildingType.short' => 'required|string',
            'buildingType.full' => 'required|string',
            'buildingType.bg' => 'required|string',
            'buildingType.icon' => 'required|string',
        ];
    }

    public function retail()
    {
        return [
            'areaS' => 'required|numeric',
            'underground' => 'string',
            'isArendator' => 'required|boolean',
            'purposeRetail' => 'required|array',
            'purposeRetail.short' => 'required|string',
            'purposeRetail.full' => 'required|string',
            'purposeRetail.slug' => 'required|string',
            'purposeRetail.icon' => 'required|string',
            'MAP' => 'numeric',
            'MAPCurrency' => 'required_with:MAP|string|in:rouble,dollar,euro',
            'payback' => 'numeric'
        ];
    }
}
