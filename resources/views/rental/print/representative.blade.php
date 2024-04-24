<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>สัญญาตั้งตัวแทน</title>
    @LaravelDompdfThaiFont
    <style>
        body{
            font-family: 'THSarabunNew';
            line-height: 105%;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="container" align="center">
        <table border="0" width="100%">
            <tr>
                <td align="center" valign="center"><img src="uploads/images/logo_contract.jpg" width="190px"></td>
            </tr>

            <tr>
                <td align="center">
                    <h1>สัญญาตั้งตัวแทน</h1>
                </td>
            </tr>
            <tr>
                <td align="right" style="font-size:20px; line-height: 0px">
                    สัญญาเลขที่ {{ $rents->code_contract_agent ?? ''}}
                </td>
            </tr>
            <tr>
                <td align="right" style="line-height: 5px">
                    <h2>ทำที่ บริษัท วีบียอนด์ แมเนจเม้นท์ จำกัด</h2>
                    <h2> วันที่ {{ thaidate('j F พ.ศ. Y',$rents->print_contract_manual) }}</h2>
                </td>
            </tr>
            <tr>
                <td style="font-size:22px; text-align:justify;">
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หนังสือสัญญาฉบับนี้ทำขึ้นระหว่าง<b> {{ $rents->Owner }} ถือบัตรประจำตัวประชาชนเลขที่
                            /หนังสือเดินทางเลขที่ {{ $rents->cardowner ?? '' }} 
                            ที่อยู่ {{ $rents->numberhome  ?? '' }} 
                            ซอย {{ $rents->owner_soi ?? "-" }}
                            ถนน {{ $rents->owner_road ?? "-" }}
                            เเขวง/ตำบล {{ $rents->owner_district }} เขต/อำเภอ {{ $rents->owner_khet }}
                            จังหวัด {{ $rents->owner_province }} </b> ซึ่งต่อไปในในสัญญานี้ เรียกว่า
                        <b>“ผู้ให้สัญญา”</b> ฝ่ายหนึ่ง
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;กับ <b>บริษัท วีบียอนด์ แมเนจเม้นท์ จำกัด โดยนายสิวะ ศรีสวัสดิ์ กรรมการผูมีอำนาจ ทะเบียนนิติบุคคล เลขที่ 0105563072893 </b> 
                        สำนักงานใหญ่ตั้งอยู่ เลขที่ 1 อาคารเอ็มไพร์ ทาวเวอร์ ชั้น 24 ห้องเลขที่ 2401 ถนนสาทรใต้ แขวงยานนาวา เขตสาทร กรุงเทพมหานคร 
                        ซึ่งต่อไปในสัญญานี้เรียกว่า <b>“ตัวแทน”</b> อีกฝ่ายหนึ่ง
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;คู่สัญญาทั้งสองฝ่ายตกลงทำสัญญากัน 
                        มีรายละเอียดดังนี้ </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ข้อ 1. </b>ผู้ให้สัญญาเป็นเจ้าของกรรมสิทธิ์ใน <b>ห้องชุดเลขที่
                        {{ $rents->cus_room_no ??  ''}} บ้านเลขที่ {{ $rents->RoomNo ??  ''}} ตึก {{ $rents->Building ?? '-' }}
                        ชั้นที่ {{ $rents->Floor ?? '-' }} อาคารชุด <br>
                        {{ $rents->Project_NameTH == NULL ? "โครงการ" . $rents->Project_Name : $rents->Project_NameTH }} {{ $rents->address_full }}
                        มีเนื้อที่ห้องชุดประมาณ {{ $rents->Size }}
                        ตารางเมตร</b> ซึ่งต่อไปในสัญญานี้เรียกห้องชุดดังกล่าว <b>“ห้องชุด”</b></p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ข้อ 2. วัตถุประสงค์แห่งสัญญา</b></p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้ให้สัญญาตกลงแต่งตั้งตัวแทนให้ดำเนินการจัดหาบุคคล และ/หรือ นิติบุคคลใดๆ (ต่อไปในสัญญานี้ เรียกว่า<b>“ผู้เช่า”</b>) เข้ามาทำการเช่าห้องชุดพร้อมเฟอร์นิเจอร์ (รายละเอียดเฟอร์นิเจอร์และอุปกรณ์ตกแต่งปรากฏตามเอกสารแนบ ท้าย)</p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ข้อ 3. กำหนดระยะเวลาตามสัญญา</b></p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;คู่สัญญาทั้งสองฝ่ายตกลงให้สัญญานี้ <b>มีกำหนดระยะเวลา
                        {{ $rents->Contract }} เดือน {{ $rents->Day }} วัน เริ่มตั้งแต่วันที่
                        {{ thaidate('j F พ.ศ. Y', $rents->Contract_Startdate) }} ถึง วันที่
                        {{ thaidate('j F พ.ศ. Y', $rents->Contract_Enddate) }} </b>
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ข้อ 4. ค่าตอบแทน</b></p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;กรณีตัวแทนจัดหาผู้เช่าเข้าทำสัญญาเช่ากับผู้ให้สัญญาสำเร็จ ผู้ให้สัญญาตกลงชำระค่าตอบแทนให้ แก่ตัวแทน เท่ากับอัตราค่าเช่าหนึ่งเดือนที่ผู้ให้สัญญาได้รับจากผู้เช่า สำหรับการเช่าที่ผู้เช่าทำการเช่าเป็นระยะเวลา 1 (หนึ่ง) ปี และ จ่ายค่าบริการอื่นๆ อีก ตามข้อตกลง (ถ้ามี)

                </td>
            </tr>
        </table>
        <div class="page-break"></div>
        <table border="0" width="100%">
            <tr>
                <td style="font-size: 22px; text-align:justify;">
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หากผู้เช่าทำการเช่ากับผู้ให้สัญญาน้อยกว่า 1 (หนึ่ง) (ปี) ผู้ให้สัญญาเช่าตกลงจ่ายค่าตอบแทนให้แก่ตัวแทน ในอัตราเฉลี่ยของค่าเช่าหนึ่งเดือนที่ผู้ให้สัญญาได้รับจากผู้เช่า
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ข้อ 5. การเพิ่มเติมหรือแก้ไข</b></p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หากคู่สัญญาฝ่ายหนึ่งฝ่ายใดประสงค์ที่จะทำการเปลี่ยนแปลงเพิ่มเติม หรือแก้ไขข้อความใดๆ แห่งสัญญานี้จะต้อง ทำเป็นหนังสือลงลายมือชื่อคู่สัญญาทั้งสองฝ่าย จึงจะมีผลผูกพันกันได้ต่อไป
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ข้อ 6. การบอกกล่าว</b></p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บรรดาหนังสือ จดหมาย หรือคำบอกกล่าวใดๆ ที่คู่สัญญาฝ่ายหนึ่งฝ่ายใด ส่งให้คู่สัญญาอีกฝ่ายหนึ่งไปยังสถานที่ ที่ระบุไว้ข้างต้น หรือตามที่อยู่ที่คู่สัญญา
                        ได้แจ้งเปลี่ยนแปลงให้อีกฝ่ายหนึ่งทราบในภายหลัง ถ้าได้ส่งทางไปรษณีย์ ลงทะเบียน ให้ถือว่าได้รับแล้วเว้นแต่ฝ่ายที่จะต้องได้รับคำบอกกล่าวพิสูจน์ได้ว่าไม่จงใจที่จะหลีกเลี่ยงรับ หนังสือ บอกกล่าว คู่สัญญาทุกฝ่ายยินยอมผูกพันให้ถือว่าหนังสือ หรือคำบอกกล่าวนั้นได้ส่งให้คู่สัญญาแต่ละฝ่าย โดยชอบแล้ว
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ข้อ 7. ข้อกำหนดทั่วไป</b></p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;7.1 ความสัมพันธ์ระหว่างผู้ให้สัญญาและตัวแทนตามสัญญานี้ ไม่มีนิติสัมพันธ์กันในลักษณะการจ้างแรงงาน และ/หรือ หุ้นส่วนบริษัท แต่อย่างใด
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;7.2 กรณีคู่สัญญาฝ่ายใดฝ่ายหนึ่งผิดสัญญาข้อใดข้อหนึ่ง คู่สัญญาอีกฝ่ายหนึ่งมีสิทธิบอกเลิกสัญญาฉบับนี้ได้
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;7.3 หากคู่สัญญาฝ่ายหนึ่งฝ่ายใด ไม่ปฏิบัติตามสัญญานี้ ข้อหนึ่งข้อใดอีกฝ่ายหนึ่งมีสิทธิตักเตือนให้อีกฝ่ายนั้น ทราบ
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;7.4 ในระหว่างอายุสัญญานี้ผู้ให้สัญญาจะไม่ตั้งบุคคลอื่น ให้เป็นตัวแทนตามเพื่อดำเนินการตามวัตถุประสงค์ของ สัญญานี้อีก
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;7.5 บรรดาค่าใช้จ่ายที่เกิดขึ้นระหว่างสัญญานี้ เช่น ค่าภาษีโรงเรือน และภาษีที่ดิน ค่าสาธาณูปโภคของ ห้องชุด ค่าไฟฟ้า ค่าน้ำประปา ค่าโทรศัพท์ ค่าบริการบำรุงรักษาทรัพย์ส่วนกลางของนิติบุคคลอาคารชุด เป็นต้น ผู้ให้สัญญา จะเป็นผู่้ชำระเองทั้งสิ้น
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;7.6 ผู้ให้สัญญาตกลงมอบอำนาจให้ตัวแทนมีอำนาจลงนามในสัญญาเช่ากับผู้เช่าแทนผู้ให้สัญญาตลอดจน มีอำนาจเต็ม ในการเจรจาอัตราค่าเช่าและเงื่อนไขต่างๆ ได้ทุกประการ โดยผู้ให้สัญญาให้ถือว่าการกระทำของตัวแทน ตามขอบวัตถุประสงค์แห่งสัญญานี้ เป็นเสมือนการกระทำของผู้ให้สัญญาเอง</p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;7.7 หากมีข้อสัญญาข้อใดข้อหนึ่งภายใต้สัญญาฉบับนี้ที่ตกเป็นโมฆะ ไม่สมบูรณ์ผิดกฎหมาย หรือไม่อาจบังคับได้ ตามกฎหมายไม่ว่าด้วยเหตุใดก็ตาม
                        คู่สัญญาตกลงให้ข้อสัญญาหรือข้อกำหนดอื่นในสัญญาฉบับนี้ที่สมบูรณ์นั้น บังคับใช้กัน ต่อไปได้</p>
                </td>
            </tr>
        </table>
        <div class="page-break"></div>
        <table border="0" width="100%">
            <tr>
                <td style="font-size: 22px; text-align:justify;">
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;7.8 ผู้ให้สัญญาตกลงเป็นผู้จัดหาเฟอร์นิเจอร์และอุปกรณ์ตกแต่งห้องชุด</p> 
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;7.9 สัญญาฉบับนี้ และเอกสารแนบท้ายเป็นสัญญาเบ็ดเสร็จซึ่งสามารถเข้าใจได้โดยคู่สัญญา และใช้แทนที่สัญญา ความเข้าใจ ความตกลงที่ทำขึ้นหมดก่อนหน้านี้ ไม่ว่าจะด้วยวาจาหรือเป็นหนังสือ ซึ่งเกี่ยวข้องกับเรื่อง ที่อยู่ในสัญญาฉบับนี้
                    </p>
                    <br>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สัญญานี้ทำขึ้นรวมสองฉบับมีข้อความตรงกัน ต่างฝ่ายต่างยึดถือไว้ฝ่ายละฉบับ คู่สัญญาทั้งสองฝ่ายได้อ่าน ฟัง และเข้าใจข้อความแห่งสัญญานี้ดีแล้ว เห็นว่าถูกต้องตามเจตนา จึงลงลายมือชื่อและประทับตราไว้เป็นสำคัญ ต่อหน้าพยาน</p>
                </td>
            </tr>
        </table>
        {{-- <div class="page-break"></div> --}}
        <table border="0" align="center" style="border-style: none;">
            <tr>
                <td height="500px"></td>
            </tr>
            <tr>
                <td width="45%" align="center" style="font-size:22px;">
                    ลงชื่อ.....................................................ผู้ให้สัญญา</td>
                <td width="10%"></td>
                <td width="45%" align="center" style="font-size:22px;">
                    ลงชื่อ.....................................................ตัวแทน</td>
            </tr>
            <tr>
                <td width="45%" align="center" style="font-size:22px;">({{ $rents->Owner }})
                </td>
                <td width="10%"></td>
                <td width="45%" align="center" style="font-size:22px;"><b>บริษัท วีบียอนด์ แมเนจเม้นท์ จำกัด</b></td>
            </tr>
            <tr>
                <td height="35px"></td>
            </tr>
            <tr>
                <td width="45%" align="center" style="font-size:22px;">
                    ลงชื่อ.....................................................พยาน</td>
                <td width="10%"></td>
                <td width="45%" align="center" style="font-size:22px;">
                    ลงชื่อ.....................................................พยาน</td>
            </tr>
            <tr>
                <td width="45%" align="center" style="font-size:22px;">
                    ({{ $phayarn1 == null ? "....................................................." : $phayarn1 }} )
                </td>
                <td width="10%"></td>
                <td width="45%" align="center" style="font-size:22px;">
                    ({{ $phayarn2 == null ? "....................................................." : $phayarn2 }})
                </td>
            </tr>
        </table>
    </div>
</body>
</html>