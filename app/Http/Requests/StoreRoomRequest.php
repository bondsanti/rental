<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
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
            'project_id' => 'required|string',
            // 'numberhome' => 'required|string',
            'HomeNo' => 'required',
            'onwername' => 'required|string',
            'cardowner' => 'required|string',
            'owner_district' => 'required|string',
            'owner_khet' => 'required|string',
            'owner_province' => 'required|string',
            'ownerphone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'RoomNo' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.required' => 'กรุณาเลือกโครงการ',
            // 'numberhome.required' => 'กรุณากรอกเลขที่บ้านเจ้าของห้อง',
            'HomeNo.required' => 'กรุณากรอกบ้านเลขที่',
            'onwername.required' => 'กรุณากรอกชื่อเจ้าของห้อง',
            'cardowner.required' => 'กรุณากรอกเลขบัตรประชาชน',
            'owner_district.required' => 'กรุณากรอกแขวง/ตำบล',
            'owner_khet.required' => 'กรุณากรอกเขต/อำเภอ',
            'owner_province.required' => 'กรุณาเลือกจังหวัด',
            'RoomNo.required' => 'กรุณากรอกห้องเลขที่',
            'ownerphone.required' => 'กรุณากรอกหมายเลขโทรศัพท์',
        ];
    }

    public function attributes(): array
    {
        return [
            'ownerphone' => 'Contact number',
        ];
    }
}
