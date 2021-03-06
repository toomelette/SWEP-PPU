<?php


namespace App\Http\Requests\PPMP;


use App\Swep\Helpers\Helper;
use App\Swep\Helpers\PPUHelpers;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PPMPFormRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        $rules = [
            'budget_type' => [
                'required',
            ],
            'gen_desc.*' => 'required',
            'unit_cost.*' => 'required',
            'qty.*' => 'required|int|min:1',
            'mode_of_proc.*' => [
                'required',
                Rule::in(array_keys(Helper::modesOfProcurement())),
                'max:50',
            ],
            'source_of_fund.*' => [
                'required',
                Rule::in(array_keys(Helper::fundSources())),
            ],
            'uom.*' => [
                'required',
                Rule::in(array_keys(PPUHelpers::ppmpSizes()))
            ]
        ];
        foreach (Helper::milestones() as $month){
            $rules['qty_'.strtolower($month).'.*'] = ['nullable','int'];
        }


        return $rules;
    }
}