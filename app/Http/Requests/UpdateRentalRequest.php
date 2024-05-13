<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRentalRequest extends FormRequest
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
            'numberhome' => 'required|string',
            'HomeNo' => 'required',
            'onwername' => 'required|string',
            'cardowner' => 'required|string',
            'owner_district' => 'required|string',
            'owner_khet' => 'required|string',
            'owner_province' => 'required|string',
            'ownerphone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'RoomNo' => 'required',
            'date_print_contract_manual' => 'required',
            'Cus_Name' => 'required',
            'IDCard' => 'required',
            'cus_homeAddress' => 'required',
            'cus_tumbon' => 'required|string',
            'cus_aumper' => 'required|string',
            'cus_province' => 'required|string',
            'cus_idPost' => 'required',
            'cus_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'start_paid_date' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'numberhome.required' => 'กรุณากรอกเลขที่บ้านเจ้าของห้อง',
            'HomeNo.required' => 'กรุณากรอกบ้านเลขที่',
            'onwername.required' => 'กรุณากรอกเจ้าของบ้าน',
            'cardowner.required' => 'กรุณากรอกเลขบัตรประชาชน',
            'owner_district.required' => 'กรุณากรอกแขวง/ตำบล',
            'owner_khet.required' => 'กรุณากรอกเขต/อำเภอ',
            'owner_province.required' => 'กรุณาเลือกจังหวัด',
            'RoomNo.required' => 'กรุณากรอกเลขที่ห้อง',
            'ownerphone.required' => 'กรุณากรอกหมายเลขโทรศัพท์',
            'date_print_contract_manual.required' => 'กรุณากรอกวันที่ทำสัญญา',
            'Cus_Name.required' => 'กรุณากรอกชื่อลูกค้าเช่าซื้อ',
            'IDCard.required' => 'กรุณากรอกเลขบัตรประชาชนของลูกค้าเช่าซื้อ',
            'cus_homeAddress.required' => 'กรุณากรอกเลขบัตรประชาชนของลูกค้าเช่าซื้อ',
            'cus_tumbon.required' => 'กรุณากรอกแขวง/ตำบล',
            'cus_aumper.required' => 'กรุณากรอกเขต/อำเภอ',
            'cus_province.required' => 'กรุณาเลือกจังหวัด',
            'cus_idPost.required' => 'กรุณากรอกรหัสไปรษณีย์',
            'cus_phone.required' => 'กรุณากรอกเลขบัตรประชาชนของลูกค้าเช่าซื้อ',
            'start_paid_date.required' => 'กรุณากรอกวันที่จ่ายงวดแรก',
        ];
    }

    public function attributes(): array
    {
        return [
            // 'numberhome' => 'เลขที่บ้านเจ้าของห้อง',
            // 'HomeNo' => 'บ้านเลขที่',
            // 'onwername' => 'เจ้าของบ้าน',
            // 'cardowner' => 'เลขบัตรประชาชน',
            // 'owner_district' => 'แขวง/ตำบล',
            // 'owner_khet' => 'เขต/อำเภอ',
            // 'owner_province' => 'จังหวัด',
            // 'RoomNo' => 'เลขที่ห้อง',
            'ownerphone' => 'Contact number',
            // 'date_print_contract_manual' => 'วันที่ทำสัญญา',
            // 'Cus_Name' => 'ชื่อลูกค้าเช่าซื้อ',
            // 'IDCard' => 'เลขบัตรประชาชนของลูกค้าเช่าซื้อ',
            'cus_phone' => 'Telephone number',
        ];
    }
}
