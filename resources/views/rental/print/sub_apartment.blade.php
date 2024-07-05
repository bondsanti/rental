<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>หนังสือสัญญาเช่าช่วงห้องชุด</title>
    @LaravelDompdfThaiFont
    <style>
        body{
            font-family: 'THSarabunNew';
            /* line-height: 105%; */
        }
        .page-break {
            page-break-after: always;
        }
        .container{
            margin-left: 24px;          
            margin-right: 24px;
            margin-top: -16px;
            margin-bottom: 15px;

        }
    </style>
</head>
<body>
    <div class="container" align="center">
        <table border="0" width="100%">
            <tr>
                <td align="center" valign="center">
                    <img src="uploads/images/logo_contract.jpg" width="170px">
                </td>
            </tr>
        
            <tr>
                <td align="center">
                    <h1 style="font-size:21px; line-height:2px;">หนังสือสัญญาเช่าช่วงห้องชุด</h1>
                </td>
            </tr>
            <tr>
                <td style="line-height:2px;">&nbsp;</td>
            </tr>
            <tr>
                <td align="right" style="font-size:20px;">สัญญาเลขที่ {{ $rents->code_contract_owner }}</td>
            </tr>
        </table>
        
        <table border="0" width="100%">
            <tr>
                <td width="50%"></td>
                <td width="50%" align="right" style="font-size:21px; line-height: 5px">
                    <p style="font-size:21px; line-height: 3px;">ทำที่ บริษัท วีบียอนด์ แมเนจเม้นท์ จำกัด</p>
                    <h2 style="font-size:21px; line-height: 5px;">วันที่ {{ thaidate('j F พ.ศ. Y',$rents->date_print_contract_manual) }}</h2>
                </td>
            </tr>
            <tr style="line-height:2px;">
                <!-- content -->
                <td colspan="2" style="font-size: 21px; text-align:justify;line-height:18px;">
                    <p style="margin-top:-2px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หนังสือสัญญาเช่าช่วงฉบับนี้ทำขึ้นระหว่าง&nbsp;<b>บริษัท&nbsp;วีบียอนด์&nbsp;แมเนจเม้นท์&nbsp;จำกัด&nbsp;โดย นายสิวะ ศรีสวัสดิ์ กรรมการผู้มีอำนาจ ทะเบียนนิติบุคคลเลขที่ 0105563072893</b> สำนักงานใหญ่&nbsp;ตั้งอยู่เลขที่&nbsp;1
                        อาคารเอ็มไพร์ทาวเวอร์ ชั้นที่&nbsp;24&nbsp;ห้องเลขที่&nbsp;2401&nbsp;ถนนสาทรใต้&nbsp;แขวงยานนาวา&nbsp;เขตสาทร&nbsp;กรุงเทพมหานคร ซึ่งต่อไปในสัญญานี้ เรียกว่า&nbsp;<b>“ผู้ให้เช่าช่วง”</b>&nbsp;ฝ่ายหนึ่ง
                    </p>
                    <p style="margin-top:-6px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;กับ <b>{{ $rents->Cus_Name }}
                            ถือบัตรประจำตัวประชาชนเลขที่/หนังสือเดินทางเลขที่ {{ $rents->IDCard }} ที่อยู่บ้านเลขที่ {{ $rents->home_address }}
                            ซอย {{ $rents->cust_soi ?? " -" }}
                            ถนน {{ $rents->cust_road ?? " -" }}
                            แขวง/ตำบล {{ $rents->tumbon }}&nbsp;เขต/อำเภอ {{ $rents->aumper }}&nbsp;จังหวัด {{ $rents->province }}</b>&nbsp;ซึ่งต่อไปในสัญญานี้เรียกว่า <b>“ผู้เช่าช่วง”</b> อีกฝ่ายหนึ่ง</p>
                    <p style="margin-top:-6px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;คู่สัญญาทั้งสองฝ่ายตกลงทำสัญญากัน ดังมีข้อความดังต่อไปนี้</p>
                    @if($rents->address_full)
                        {{-- Error --}}
                        {{-- print_contract_manual --}}
                        <p style="margin-top:-6px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 1.&nbsp;ผู้ให้เช่าช่วงเป็นผู้มีสิทธิให้เช่าช่วงใน&nbsp;<b>ห้องชุดเลขที่ {{ $rents->cus_room_no ??  '' }}&nbsp;บ้านเลขที่&nbsp;{{ $rents->RoomNo ??  ''}}
                                &nbsp;ตึก&nbsp;{{ $rents->Building ?? '' }}&nbsp;ชั้นที่&nbsp;{{ $rents->Floor ?? '' }}&nbsp;อาคารชุด
                                ชื่อ {{ $rents->Project_NameTH == NULL ? "โครงการ" . $rents->Project_Name : $rents->Project_NameTH }} {{ $rents->address_full }} มีเนื้อที่ห้องชุด ประมาณ {{ $rents->Size }} ตารางเมตร</b>
                                ซึ่งต่อไปในสัญญานี้เรียกห้องชุดดังกล่าวว่า <b>“ห้องชุด”</b> โดยการเช่าห้องชุดดังกล่าว เป็นการเช่าพร้อมเฟอร์นิเจอร์ ดังมีรายละเอียดปรากฎตามสัญญาประกันทรัพย์สิน และอุปกรณ์ตกแต่งห้องชุด <b>สัญญาเลขที่ {{ $rents->code_contract_insurance ?? ''}} </b> ฉบับลงวันที่ <b> {{ thaidate('j F พ.ศ. Y',$rents->date_print_contract_manual) }} </b> ซึ่งถือว่าเป็นส่วนหนึ่ง แห่งสัญญานี้
                        </p>
                    @else
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 1.&nbsp;ผู้ให้เช่าช่วงเป็นผู้มีสิทธิให้เช่าช่วงใน&nbsp;<b>ห้องชุดเลขที่ {{ $rents->cus_room_no ??  ''}} &nbsp;&nbsp;บ้านเลขที่&nbsp;{{ $rents->RoomNo ??  ''}}
                                &nbsp;ตึก&nbsp;{{ $rents->Building ?? '' }}&nbsp;ชั้นที่&nbsp;{{ $rents->Floor ?? '' }}&nbsp;อาคารชุด
                                ชื่อ {{ $rents->Project_NameTH == NULL ? "โครงการ" . $rents->Project_Name : $rents->Project_NameTH }} มีเนื้อที่ห้องชุด ประมาณ {{ $rents->Size }} ตารางเมตร</b>
                                ซึ่งต่อไปในสัญญานี้เรียกห้องชุดดังกล่าวว่า <b>“ห้องชุด”</b> โดยการเช่าห้องชุดดังกล่าวเป็นการเช่าพร้อมเฟอร์นิเจอร์ ดังมีรายละเอียดปรากฎตามสัญญาประกันทรัพย์สิน และอุปกรณ์ตกแต่งห้องชุด <b>สัญญาเลขที่ {{ $rents->code_contract_insurance ?? ''}} </b> ฉบับลงวันที่<b> {{ thaidate('j F พ.ศ. Y',$rents->date_print_contract_manual) }} </b> ซึ่งถือว่าเป็นส่วนหนึ่ง แห่งสัญญานี้
                        </p>
                    @endif
                    <p style="line-height: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 2. ข้อตกลงเกี่ยวกับห้องชุดที่เช่า</p>
                    <p style="margin-top:-6px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.1 ผู้ให้เช่าช่วงตกลงให้เช่าช่วงและผู้เช่าช่วงตกลงเช่าช่วงห้องชุด เพื่อพักอาศัยเท่านั้น และระหว่าง ที่พักอาศัยอยู่ตามสัญญานี้จะไม่ทำการรบกวน หรือกระทำการใดๆ ที่เดือดร้อนรำคาญแก่ผู้อาศัยในห้องพักอื่นโดย
                        เด็ดขาด <b>มีกำหนดระยะเวลา {{ $rents->Contract }} เดือน {{ $rents->Day}} วัน ตั้งแต่วันที่ {{ thaidate('j F พ.ศ. Y', $rents->Contract_Startdate) }}
                        ถึงวันที่ {{ thaidate('j F พ.ศ. Y', $rents->Contract_Enddate) }} </b>
                        โดยการสิ้นสุดสัญญาเช่าฉบับนี้ให้เป็นไปตามที่ระบุไว้ในสัญญานี้</p>
                    <p style="margin-top:-6px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.2 ผู้ให้เช่าช่วงได้ส่งมอบการครอบครองห้องชุดให้กับผู้เช่าช่วง และผู้เช่าช่วงได้รับมอบการครอบครอง รวมทั้งตรวจดูสภาพห้องชุดที่เช่าเป็นที่พอใจแล้วในวันทำสัญญานี้
                    </p>
                    <p style="margin-top:-6px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.3 ผู้เช่าช่วงจะใช้ห้องชุดเพื่อการอย่างอื่นนอกจากที่ระบุไว้ในข้อ 2 แห่งสัญญานี้ไม่ได้ หากไม่ได้รับ ความยินยอมเป็นหนังสือจากผู้ให้เช่าช่วง</p>
                </td>
            </tr>
            {{-- <tr style="line-height:2px;">
                <td colspan="2" style="font-size:21px; text-align:justify; line-height:18px;">
                    @if($rents->address_full)
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 1.&nbsp;ผู้ให้เช่าช่วงเป็นผู้มีสิทธิให้เช่าช่วงใน&nbsp;<b>ห้องชุดเลขที่ {{ $rents->cus_room_no ??  '' }} &nbsp;&nbsp;บ้านเลขที่&nbsp;{{ $rents->RoomNo ??  ''}}
                                &nbsp;ตึก&nbsp;{{ $rents->Building ?? '' }}&nbsp;ชั้นที่&nbsp;{{ $rents->Floor ?? '' }}&nbsp;อาคารชุด
                                ชื่อ {{ $rents->Project_NameTH == NULL ? "โครงการ" . $rents->Project_Name : $rents->Project_NameTH }} {{ $rents->address_full }} มีเนื้อที่ห้องชุด ประมาณ {{ $rents->Size }} ตารางเมตร</b>
                                ซึ่งต่อไปในสัญญานี้เรียกห้องชุดดังกล่าวว่า <b>“ห้องชุด”</b> โดยการเช่าห้องชุดดังกล่าวเป็นการเช่า พร้อมเฟอร์นิเจอร์ดังมีรายละเอียดปรากฎตามสัญญาประกันทรัพย์สินและ อุปกรณ์ตกแต่งห้องชุด <b>สัญญาเลขที่ {{ $rents->code_contract_old ?? ''}} </b> ฉบับลงวันที่ <b> {{ thaidate('j F พ.ศ. Y',$rents->print_contract_manual) }} </b> ซึ่งถือว่าเป็นส่วนหนึ่ง แห่งสัญญานี้
                        </p>
                    @else
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 1.&nbsp;ผู้ให้เช่าช่วงเป็นผู้มีสิทธิให้เช่าช่วงใน&nbsp;<b>ห้องชุดเลขที่ {{ $rents->cus_room_no ??  ''}} &nbsp;&nbsp;บ้านเลขที่&nbsp;{{ $rents->RoomNo ??  ''}}
                                &nbsp;ตึก&nbsp;{{ $rents->Building ?? '' }}&nbsp;ชั้นที่&nbsp;{{ $rents->Floor ?? '' }}&nbsp;อาคารชุด
                                ชื่อ {{ $rents->Project_NameTH == NULL ? "โครงการ" . $rents->Project_Name : $rents->Project_NameTH }} มีเนื้อที่ห้องชุด ประมาณ {{ $rents->Size }} ตารางเมตร</b>
                                ซึ่งต่อไปในสัญญานี้เรียกห้องชุดดังกล่าวว่า <b>“ห้องชุด”</b> โดยการเช่าห้องชุดดังกล่าวเป็นการเช่า พร้อมเฟอร์นิเจอร์ดังมีรายละเอียดปรากฎตามสัญญาประกันทรัพย์สินและ อุปกรณ์ตกแต่งห้องชุด <b>สัญญาเลขที่ {{ $rents->code_contract_old ?? ''}} </b> ฉบับลงวันที่ <b> {{ thaidate('j F พ.ศ. Y',$rents->print_contract_manual) }} </b> ซึ่งถือว่าเป็นส่วนหนึ่ง แห่งสัญญานี้
                        </p>
                    @endif
                </td>
            </tr> --}}
            {{-- <tr>
                <td colspan="2" style="font-size:21px; text-align:justify; line-height:18px;">
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 2. ข้อตกลงเกี่ยวกับห้องชุดที่เช่า</p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.1 ผู้ให้เช่าช่วงตกลงให้เช่าช่วงและผู้เช่าช่วงตกลงเช่าช่วงห้องชุด เพื่อพักอาศัยเท่านั้น และระหว่างที่พักอาศัยอยู่ ตามสัญญานี้จะไม่ทำการรบกวนหรือกระทำการใดๆ ที่เดือดร้อนรำคาญแก่ผู้อาศัยในห้องพัก อื่น
                        โดยเด็ดขาด <b>มีกำหนด ระยะเวลา {{ $rents->Contract }} เดือน {{ $rents->Day}} วัน ตั้งแต่วันที่ {{ thaidate('j F พ.ศ. Y', $rents->Contract_Startdate) }}
                             ถึงวันที่ {{ thaidate('j F พ.ศ. Y', $rents->Contract_Enddate) }} </b>
                        โดยการสิ้นสุดสัญญาเช่าฉบับนี้ให้เป็นไปตามที่ระบุไว้ในสัญญานี้</p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.2 ผู้ให้เช่าช่วงได้ส่งมอบการครอบครองห้องชุดให้กับผู้เช่าช่วง และผู้เช่าช่วงได้รับมอบ การครอบครองรวมทั้ง ตรวจดูสภาพห้องชุดที่เช่าเป็นที่พอใจแล้วในวันทำสัญญานี้
                    </p>
                </td>
            </tr> --}}
        </table>
        
        <div class="page-break"></div>
        
        <table border="0" width="100%">
            <tr>
                <td style="font-size:21px; text-align:justify; line-height:18px;">
                    <p style="margin-top: -2px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.4 ผู้เช่าช่วงไม่มีสิทธิที่จะโอนสิทธิการเช่าตามสัญญานี้หรือจะนำห้องชุดไปให้ผู้อื่นเช่าช่วง หรือให้อาศัย ใช้ห้องชุด ไม่ว่าจะมีค่าตอบแทนหรือไม่ ไม่ว่าจะมีผลประโยชน์แลกเปลี่ยนอื่นใดหรือไม่ 
                        ไม่ว่าจะเป็นการชั่วคราวหรือไม่ และไม่ว่าจะทั้งหมดหรือแค่บางส่วนของห้องชุด</p>
                    <p style="margin-top: -12px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.5 การแก้ไข เพิ่มเติมหรือเปลี่ยนแปลงสัญญานี้ไม่ว่าส่วนหนึ่งส่วนใด หรือทั้งหมดจะต้องทำเป็นหนังสือ และลงลายมือชื่อของคู่สัญญาทั้งสองฝ่าย ไว้เป็นสำคัญจึงจะมีผลใช้บังคับระหว่างคู่สัญญาได้</p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 3. อัตราค่าเช่าและระยะเวลา</p>
                    <p style="margin-top:-8px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.1 ผู้เช่าช่วงตกลงชำระค่าเช่าล่วงหน้าให้แก่ผู้ให้เช่าช่วง ล่วงหน้าเป็นรายเดือน ภายในวันที่ 5 ของ แต่ละเดือน ในอัตราค่าเช่า <b>เดือนละ {{ $rents->Price == null ? "0 บาท" : number_format($rents->Price, 2) }}
                            ({{ $customer_price == null ? "ศูนย์บาทถ้วน" : $customer_price }})</b> จะชำระค่าเช่าเดือนแรกภายใน วันที่ <b>{{ thaidate('j F พ.ศ. Y', $rents->date_firstget) }}</b>
                        โดยผู้เช่าช่วงจะชำระค่าเช่าให้แก่ผู้ให้เช่าช่วง ด้วยวิธีการโอนเงินค่าเช่าเข้าบัญชีเงินฝาก 
                        <b>ธนาคารกสิกรไทย ชื่อบัญชี บจก.วีบียอนด์ แมเนจเม้นท์ เลขที่บัญชี 069-8-38772-6 </b>หรือนำไปชำระ ณ ภูมิลำเนาของผู้ให้เช่าช่วง
                    </p>
                    <p style="margin-top:-8px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.2 หากผู้เช่าช่วงชำระค่าเช่าล่าช้าไปจากวันที่กำหนดชำระ ผู้เช่าช่วงยินดีจะเสียค่าปรับสำหรับความ ล่าช้านั้นให้แก่ผู้ให้เช่าช่วงวันละ 100 (หนึ่งร้อย) บาท และค่าใช้จ่ายต่าง ๆ
                        ที่ผู้ให้เช่าช่วง ต้องเสียไปเพื่อการทวงถาม ให้ชำระเงินค่าเช่าอีกด้วย
                    </p>
                    <p style="margin-top:-12px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.3 การผ่อนผันการชำระเงินงวดใดงวดหนึ่ง ไม่มีผลเป็นการเปลี่ยนแปลงกำหนดชำระค่าเช่าตาม&nbsp;&nbsp;&nbsp; สัญญานี้</p>
                    <p style="margin-top:-30px;">
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 4. เงินประกันสัญญา
                    </p>
                    {{-- Error print_contract_manual, สัญญาเลขที่ --}}
                    <p style="margin-top:-12px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.1 ในวันทำสัญญาฉบับนี้ผู้เช่าช่วงได้มอบเงินประกันสัญญา เพื่อเป็นการประกันความเสียหายเกี่ยวกับ ห้องชุด และเพื่อประกันการปฏิบัติตามสัญญาจำนวนเงิน <b>{{$rents->price_insurance == null ? "0 บาท" : number_format($rents->price_insurance, 2)}} ({{$price_insurance == null ? "ศูนย์บาท" :  $price_insurance}})</b>
                        ให้แก่ผู้ให้เช่าช่วงแล้ว ตามหนังสือสัญญาเช่าช่วงห้องชุด <b>สัญญาเลขที่ {{ $rents->code_contract_old ?? $rents->code_contract_cus }} </b> ฉบับวันที่ <b>{{ thaidate('j F พ.ศ. Y',$rents->date_print_contract_manual) }}</b> เมื่อสัญญา เช่าช่วงห้องชุดได้สิ้นสุดลง โดยผู้เช่าช่วงมิได้ผิดสัญญาและมิได้มีหนี้คงค้างชำระ หรือภาระผูกพันใดๆ ตามสัญญานี้ผู้ให้ เช่าช่วงจะคืนเงินประกันสัญญานี้ให้แก่ผู้เช่าช่วงโดยไม่มีดอกเบี้ย
                        หากมีความเสียหายเกี่ยวกับห้องชุดที่เช่าหรือการปฏิบัติ ตามสัญญาเช่า ผู้เช่าช่วงยินยอมให้ผู้ให้เช่าช่วงหักจำนวนค่าเสียหายนั้นออกจากเงินประกันสัญญา และคืนเงินส่วน ที่เหลือโดยไม่มีดอกเบี้ยให้กับผู้เช่าช่วง ภายใน 30 (สามสิบ) วัน
                        นับจากวันที่ผู้ให้เช่าช่วงได้รับมอบการครอบครอง ห้องชุดที่เช่าเรียบร้อยแล้ว
                    </p>
                    <p>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 5. ข้อปฏิบัติของผู้ให้เช่าช่วงและผู้เช่าช่วงตกลงว่า
                    </p>
                    <p style="margin-top:-12px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5.1 ผู้เช่าช่วงจะซ่อมแซมห้องชุดให้อยู่ในสภาพที่ดี ไม่ว่าจะเป็นการซ่อมแซมเล็กน้อย หรือซ่อมแซมใหญ่ ด้วยค่า ใช้จ่ายของผู้เช่าช่วงทั้งสิ้น และจะซ่อมแซมโดยทันทีที่ความชำรุดบกพร่องเกิดขึ้นกับห้องชุด
                    </p>
                    <p style="margin-top:-12px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5.2 ผู้เช่าช่วงจะดูแลรักษาห้องชุดที่เช่าให้อยู่ในสภาพที่ดี สะอาด เรียบร้อย เสมือนวิญญูชนจะพึงปฏิบัติ ในการรักษาทรัพย์สินของตน ด้วยค่าใช้จ่ายของตนเอง
                    </p>
                </td>
            </tr>
        
        </table>
        <div class="page-break"></div>
        <table border="0" width="100%" >
            <tr>
                <td style="font-size:21px; text-align: justify; line-height:18px;">
                    <p style="margin-top: -2px;width: 100%;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5.3 ผู้เช่าช่วงจะยินยอมให้ผู้ให้เช่าช่วง หรือตัวแทนที่ได้รับมอบอำนาจจากผู้ให้เช่าช่วง เข้าตรวจตรา ห้องชุดได้เป็นครั้งคราวในระยะเวลาอันควร
                    </p>
                    <p style="margin-top:-12px;width: 100%;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5.4 ผู้เช่าช่วงจะไม่ทำการดัดแปลง ต่อเติม รื้อถอน หรือเปลี่ยนแปลงห้องชุด ไม่ว่าจะทั้งหมดหรือ บางส่วน เว้นแต่จะได้รับความยินยอมเป็นลายลักษณ์อักษรจากผู้ให้เช่าช่วงก่อน
                        หากผู้เช่าช่วงได้กระทำการไปโดยไม่ได้ รับความยินยอมเป็นลายลักษณ์อักษรจากผู้ให้เช่าช่วง ผู้ให้เช่าช่วงจะเรียกให้ผู้เช่าช่วงทำห้องชุดให้กลับสู่สภาพเดิมด้วย ทุนทรัพย์ของผู้เช่าช่วงเอง
                    </p>
                    <p style="margin-top:-12px;width: 100%;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5.5 ผู้เช่าช่วงจะไม่กระทำการหรือยินยอมให้กระทำการใดๆ ในห้องชุด อันเป็นการฝ่าฝืนกฎหมาย หรือขัดต่อความสงบเรียบร้อย หรือศีลธรรมอันดีของประชาชน
                    </p>
                    <p style="margin-top:-12px;width: 100%;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5.6 ผู้เช่าช่วงและบริวารจะพักอาศัยในห้องชุดด้วยความเรียบร้อย และอยู่ภายใต้กฎระเบียบของนิติ บุคคลอาคารชุดตลอดจนจะไม่นำสัตว์ มาเลี้ยงหรืออาศัยร่วมในห้องชุด
                    </p>
                    <p style="margin-top:-12px;width: 100%;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5.7 ผู้เช่าช่วงจะไม่นำห้องชุดที่เช่า ให้ผู้อื่นเช่าช่วงหรือโอนสิทธิการเช่าให้ผู้อื่น ไม่ว่าทั้งหมดหรือบาง ส่วน&nbsp;
                    </p>
                    <p style="margin-top:-12px;width: 100%;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5.8 เมื่อสัญญาฉบับนี้สิ้นสุดลงไม่ว่าด้วยเหตุใดผู้เช่าช่วงจะต้องส่งมอบห้องชุดในสถาพเรียบร้อยสามารถ ใช้งานได้ตามปกติให้แก่ ผู้ให้เช่าช่วง ทันที
                    </p>
                    <p style="width: 100%;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 6. บรรดาค่าสาธารณูปโภค เช่น ไฟฟ้า น้ำประปา โทรศัพท์ ผู้เช่าช่วงจะเป็นผู้ชำระเองทั้งสิ้นกับ หน่วยงานราชการ
                    </p>
                    <p>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 7. ข้อยกเว้นความรับผิด
                    </p>
                    <p style="margin-top:-12px;width: 100%;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้ให้เช่าช่วงไม่ต้องรับผิดสำหรับความเสียหายหรือสูญหายหรือภยันตรายใด ๆ อันเกิดขึ้นเเก่ชีวิตร่างกายหรือ ทรัพย์สินใดๆ ของผู้เช่าช่วงหรือบริวารของผู้เช่าช่วง รวมตลอดถึงบุคคลอื่นใดข้างในห้องชุด
                        ยกเว้นเป็นความผิดโดยตรง หรือความประมาทเลินเล่อของผู้ให้เช่าช่วงหรือลูกจ้างหรือบริวารของผู้ให้เช่าช่วงหรือลูกจ้างหรือบริวารของผู้ให้เช่าช่วง
                    </p>
                    <p>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 8. การเพิ่มเติมหรือเเก้ไข
                    </p>
                    <p style="margin-top:-12px;width: 100%;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หากฝ่ายหนึ่งฝ่ายใดประสงค์ที่จะทำการเปลี่ยนเเปลงเพิ่มเติมหรือเเก้ไข ข้อความใดๆ เเห่งสัญญานี้จะต้องทำ เป็นหนังสือลงลายมือชื่อคู่สัญญาทั้งสองฝ่ายจึงจะมีผลผูกพันกันต่อไป
                    </p>
                    <p>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 9. การบอกกล่าว
                    </p>
                    <p style="margin-top:-12px;width: 100%;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บรรดาหนังสือ จดหมาย หรือคำบอกกล่าวใดๆ ที่คู่สัญญาฝ่ายหนึ่งฝ่ายใด ส่งให้คู่สัญญาอีกฝ่ายหนึ่งไปยัง สถานที่ที่ระบุไว้ข้างต้น
                        หรือตามที่คู่สัญญาได้เเจ้งเปลี่ยนเเปลงให้อีกฝ่ายหนึ่งทราบในภายหลัง ถ้าได้ส่งทางไปรษณีย์ ลงทะเบียนให้ถือว่าได้รับแล้ว เว้นแต่ฝ่ายที่จะต้องได้รับคำบอกกล่าวพิสูจน์ได้ว่า ไม่จงใจที่จะหลีกเลี่ยงรับหนังสือ บอกกล่าว คู่สัญญาทุกฝ่ายยินยอมผูกพันให้ถือว่า หนังสือ หรือคำบอกกล่าวนั้น ได้ส่งให้คู่สัญญาแต่ละฝ่ายโดยชอบแล้ว
                    </p>
                </td>
            </tr>
        </table>

        <div class="page-break"></div>
        <table border="0" width="100%" style="font-size:22px; text-align: justify;">
            <tr>
                <td style="font-size:21px; text-align: justify; line-height:18px;">
                     <p style="margin-top: -2px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 10. การสิ้นสุดของสัญญาเเละการผิดสัญญา
                    </p>
                    <p style="margin-top:-12px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10.1 สัญญาสิ้นสุดลงเมื่อครบกำหนดระยะเวลาตามสัญญาเช่า
                    </p>
                    <p style="margin-top:-12px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10.2 กรณีคู่สัญญาฝ่ายใดประพฤติผิดสัญญาข้อหนึ่งข้อใด หรือกระทำผิดวัตถุประสงค์ข้อหนึ่งข้อใดเเห่ง สัญญานี้ก็ดี ให้คู่สัญญาอีกฝ่ายมีสิทธิบอกเลิกสัญญาเช่าฉบับนี้ได้
                    </p>
                    <p style="margin-top:-12px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10.3 กรณีที่ผู้เช่าช่วงผิดนัดชำระค่าเช่า และผู้ให้เช่าช่วงได้บอกเลิกสัญญาเช่าช่วงแล้ว ผู้ให้เช่าช่วงมีสิทธิ ระงับการใช้กระแสไฟฟ้า น้ำประปา เปลี่ยนกุญแจ หรือทำการปิดกั้นห้องชุดที่ให้เช่าได้ทันที โดยไม่ถือเป็นการละเมิด หรือขัดขวางการใช้ห้องชุด ทั้งนี้
                        รวมถึงมีสิทธิยึดหน่วงและนำออกขายทรัพย์ที่อยู่ในห้องชุดที่เช่าเพื่อชดใช้แทนค่าเช่า เบี้ยปรับล่าช้า รวมถึงค่าใช้จ่ายอื่นๆ ที่ค้างชำระแก่ผู้ให้เช่าช่วง
                    </p>
                    <p>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 11. การผิดสัญญา
                    </p>
                    <p style="margin-top:-8px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เมื่อสัญญานี้สิ้นสุดลงไม่ว่าด้วยเหตุใดก็ตาม และผู้ให้เช่าช่วงได้บอกเลิกสัญญาเช่าช่วงแล้ว ผู้เช่าช่วงต้องออก จากสถานที่เช่าทันที 
                        โดยผู้ให้เช่ามีสิทธิเข้าครอบครองสถานที่เช่าเเละทรัพย์สินต่างๆ ของผู้ให้เช่าตามข้อ 1. เเห่งสัญญานี้ เเละผู้ให้เช่าช่วงสามารถขนย้ายทรัพย์สินของผู้เช่าออกจากสถานที่เช่าได้
                        ตลอดจนระงับการจ่ายกระเเสไฟฟ้า เเละน้ำ รวมถึงการเปลี่ยนกุญเเจหรือทำการปิดกั้นทรัพย์ให้เช่าตามสัญญานี้ได้ทันทีโดยปราศจากความรับผิดใดๆ
                        
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;กรณีผู้เช่าช่วงผิดสัญญา ผู้เช่าช่วงตกลงชดใช้ค่าเสียหายแก่ผู้ให้เช่าช่วง เป็นดอกเบี้ย ในอัตราร้อยละ 18 ต่อปี นับตั้งแต่วันผิดสัญญา จนถึงวันที่ชำระค่าเสียหายครบถ้วน รวมถึงยอดชดใช้ค่าใช้จ่ายต่างๆ ที่ผู้ให้เช่าช่วงต้องเสียไปเพื่อ การทวงถาม หรือเพื่อการฟ้องร้องบังคับคดีด้วย</p>
                    <p>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สัญญานี้ทำขึ้นรวมสองฉบับมีข้อความตรงกัน ต่างฝ่ายต่างยึดถือไว้ฝ่ายละฉบับ คู่สัญญาทั้งสองฝ่ายได้อ่าน ฟัง และเข้าใจข้อความแห่งสัญญานี้ดีแล้ว เห็นว่าถูกต้องตามเจตนา จึงลงลายมือชื่อและประทับตราไว้เป็นสำคัญต่อหน้า
                        พยาน
                    </p>
                </td>
            </tr>
        </table>
        <table border="0" align="center" style="border-style: none;" width="90%">
            <tr>
                <td height="100px"></td>
            </tr>
            <tr>
                <td width="40%" align="center" style="font-size:21px;">
                    ลงชื่อ.....................................................ผู้ให้เช่าช่วง</td>
                <td width="20%"></td>
                <td width="40%" align="center" style="font-size:21px;">
                    ลงชื่อ.....................................................ผู้เช่าช่วง</td>
            </tr>
            <tr>
                <td width="40%" align="center" style="font-size:21px;"><b>บริษัท วีบียอนด์ แมเนจเม้นท์ จำกัด</b></td>
                <td width="20%"></td>
                <td width="40%" align="center" style="font-size:21px;"><b>{{ $rents->Cus_Name }}</b></td>
            </tr>
            <tr>
                <td height="30px"></td>
            </tr>
            <tr>
                <td width="40%" align="center" style="font-size:21px;">
                    ลงชื่อ.....................................................พยาน</td>
                <td width="20%"></td>
                <td width="40%" align="center" style="font-size:21px;">
                    ลงชื่อ.....................................................พยาน</td>
            </tr>
            <tr>
                <td width="40%" align="center" style="font-size:21px;">

                    ( {{ $phayarn1 == null ? "....................................................." :  $phayarn1 }} )
                </td>
                <td width="20%"></td>
                <td width="40%" align="center" style="font-size:21px;">
                    ( {{ $phayarn2 == null ? "....................................................." :  $phayarn2 }} )
                </td>
            </tr>
        </table>

    </div>
    {{-- @endforeach --}}
</body>
</html>