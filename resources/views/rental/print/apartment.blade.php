<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>หนังสือสัญญาเช่าห้องชุด</title>
    @LaravelDompdfThaiFont
    <style>
        body{
            font-family: 'THSarabunNew';
        }
        .page-break {
            page-break-after: always;
        }
        .main{
            margin-left: 24px;          
            margin-right: 24px;
            margin-top: -9px;
            margin-bottom: 15px;
            /* width: 94%; */
        }
    </style>
</head>
<body>
    <div class="main" align="center">
        <table border="0" width="100%">
            <tr>
                <td align="center" valign="center"><img src="uploads/images/logo_contract.jpg" width="170px"></td>
            </tr>
            <tr>
                <td align="center">
                    <h1 style="font-size:21px;line-height:2px;">หนังสือสัญญาเช่าห้องชุด</h1>
                </td>
            </tr>
            <tr>
                <td style="line-height:2px;">&nbsp;</td>
            </tr>
            <tr>
                <td align="right" style="font-size:20px;">
                    สัญญาเลขที่ {{ $rents->code_contract_owner }}
                </td>
            </tr>
            <tr>
                <td align="right">
                    <p style="font-size:21px; line-height: 3px;">ทำที่ บริษัท วีบียอนด์ แมเนจเม้นท์ จำกัด</p>
                    <h2 style="font-size:21px; line-height: 5px;"> วันที่ {{ thaidate('j F พ.ศ. Y', $rents->date_print_contract_manual) }} </h2>
                </td>
            </tr>
            <tr>
                <td style="font-size:21px; text-align:justify;line-height:18px;">
                    <p style="margin-top: 0%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หนังสือสัญญาเช่าฉบับนี้ทำขึ้นระหว่าง <b>{{ $rents->Owner }} ถือบัตรประจำตัวประชาชนเลขที่/ 
                            หนังสือเดินทางเลขที่  {{ $rents->cardowner ?? '' }} 
                            ที่อยู่ {{ $rents->numberhome  ?? '' }}
                            ซอย {{ $rents->owner_soi ?? "-" }}
                            ถนน {{ $rents->owner_road ?? "-" }}
                            เเขวง/ตำบล {{ $rents->owner_district }} เขต/อำเภอ {{ $rents->owner_khet }}
                            จังหวัด {{ $rents->owner_province }} </b> ซึ่งต่อไปในในสัญญานี้ เรียกว่า
                        <b>“ผู้ให้เช่า”</b> ฝ่ายหนึ่งกับ
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>บริษัท วีบียอนด์ แมเนจเม้นท์ จำกัด โดยนายสิวะ ศรีสวัสดิ์ กรรมการผู้มีอำนาจ ทะเบียนนิติบุคคลเลขที่ 0105563072893</b>
                        สำนักงานใหญ่ตั้งอยู่ เลขที่ 1 อาคารเอ็มไพร์ ทาวเวอร์ ชั้น 24 ห้องเลขที่ 2401 ถนนสาทรใต้ แขวงยานนาวา เขตสาทร กรุงเทพมหานคร
                        ซึ่งต่อไปในสัญญานี้ เรียกว่า <b>“ผู้เช่า”</b> อีกฝ่ายหนึ่ง
                    </p>
                    <p>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;คู่สัญญาทั้งสองฝ่ายตกลงทำสัญญากัน
                        ดังมีข้อความดังต่อไปนี้
                    </p>
                    @if($rents->address_full)
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 1. ผู้ให้เช่าเป็นเจ้าของกรรมสิทธิ์ใน <b>ห้องชุดเลขที่ {{ $rents->cus_room_no ?? '' }} &nbsp;บ้านเลขที่&nbsp;{{ $rents->RoomNo ?? '' }}
                            &nbsp;ตึก&nbsp;{{ $rents->Building ?? '-' }}&nbsp;ชั้นที่&nbsp;{{ $rents->Floor ?? '-' }}&nbsp;อาคารชุด
                            ชื่อ {{ $rents->Project_NameTH == NULL ? "โครงการ" . $rents->Project_Name : $rents->Project_NameTH }} {{ $rents->address_full }} มีเนื้อที่ห้องชุดประมาณ {{ $rents->Size }} ตารางเมตร</b>
                            ซึ่งต่อไปในสัญญานี้เรียกห้องชุดดังกล่าวว่า <b>“ห้องชุด”</b>
                        </p>
                    @else
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 1. ผู้ให้เช่าเป็นเจ้าของกรรมสิทธิ์ใน <b>ห้องชุดเลขที่ {{ $rents->cus_room_no ??  ''}} &nbsp;&nbsp;บ้านเลขที่&nbsp;{{ $rents->RoomNo ??  ''}}
                            &nbsp;ตึก&nbsp;{{ $rents->Building ?? '' }}&nbsp;ชั้นที่&nbsp;{{ $rents->Floor ?? '' }}&nbsp;อาคารชุด
                            ชื่อ {{ $rents->Project_NameTH == NULL ? "โครงการ" . $rents->Project_Name : $rents->Project_NameTH }} มีเนื้อที่ห้องชุดประมาณ {{ $rents->Size }} ตารางเมตร</b>
                            ซึ่งต่อไปในสัญญานี้เรียกห้องชุดดังกล่าวว่า <b>“ห้องชุด”</b>
                        </p>


                    @endif
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 2. ผู้ให้เช่าตกลงให้เช่าและผู้เช่าตกลงเช่าห้องชุด
                        เพื่อแสวงหาผลประโยชน์จากทางการค้าและการลงทุนหรือ เพื่อพักอาศัยหรือทำกิจการอื่นๆซึ่งไม่เป็นการรบกวนหรือเป็นที่เดือดร้อนรำคาญแก่ผู้อาศัยในห้องพักอื่น <b>มีกำหนดระยะ เวลา
                        {{ $rents->Contract }} เดือน {{ $rents->Day}} วัน เริ่มตั้งแต่วันที่ {{ thaidate('j F พ.ศ. Y', $rents->Contract_Startdate) }}
                        ถึงวันที่ {{ thaidate('j F พ.ศ. Y', $rents->Contract_Enddate) }}</b> โดยการสิ้นสุด สัญญาเช่าฉบับนี้ให้เป็นไปตามที่ระบุไว้ในสัญญานี้
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 3. ผู้เช่าตกลงชำระค่าเช่าให้แก่ผู้ให้เช่าเป็นรายเดือน ทุกวันสิ้นเดือนของแต่ละเดือน
                        ในอัตราค่าเช่า <b>เดือนละ {{ $rents->price == null ? "0 บาท" : number_format($rents->price,2) }} ({{ $room_price == null ? "ศูนย์บาทถ้วน" : $room_price }})</b> โดย ผู้ให้เช่าตกลงยินยอมให้ผู้เช่าดำเนินการ หักถาษี ณ ที่จ่ายได้ ตามกฏหมาย ทั้งนี้ ผู้เช่าจะเริ่มชำระครั้งแรกภายใน<b> วันที่ {{ thaidate('j F พ.ศ. Y',$rents->date_firstget) }}</b> โดยผู้เช่าจะชำระค่าเช่าให้แก่ ผู้ให้เช่าด้วยวิธีการโอนเงินค่าเช่าเข้าบัญชีเงินฝากของผู้ให้เช่า ในกรณีที่ผู้เช่าช่วงชำระค่าเช่าล่าช้าพ้นจากกำหนดระยะ เวลาในการชำระค่าเช่าตามสัญญานี้ ผู้เช่าจะดำเนินการติดตามทวงถามและจัดเก็บค่าเช่าจากผู้เช่าช่วงให้กับผู้ให้เช่า เมื่อ ผู้เช่าช่วงชำระค่าเช่าแล้ว ผู้เช่าจะชำระค่าเช่าให้แก่ผู้ให้เช่าโดยไม่ถือเป็นการผิดสัญญา ในกรณีผู้เช่าช่วงยกเลิกสัญญาเช่า ก่อนครบกำหนดระยะเวลา ผู้เช่า จะดำเนินการแจ้งให้ผู้ให้เช่าทราบโดยเร็ว
                    </p>
                </td>
            </tr>
        </table>
        <div class="page-break"></div>
        <table border="0" width="100%">
            <tr>
                <td style="font-size:21px; text-align:justify;line-height:18px;">
                    <p></p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 4. ข้อปฏิบัติของผู้ให้เช่าต่อผู้เช่า</p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.1 ในระหว่างอายุการเช่าตามสัญญาฉบับนี้หาก ผู้เช่าประสงค์จะนำห้องชุดออกให้เช่าช่วงหรือโอนสิทธิการเช่า ให้แก่บุคคลภายนอก หรือแสวงหาผลประโยชน์ในทางการค้า ผู้ให้เช่ายินยอมให้ผู้เช่ากระทำได้โดยผู้เช่าไม่ต้องขออนุญาต 
                        จากผู้ให้เช่าอีก และให้ถือว่าข้อตกลงตามสัญญาฉบับนี้มีผลผูกพันใช้บังคับต่อผู้ให้เช่า และผู้เช่าช่วง หรือผู้รับโอนสิทธิ ที่จะต้องปฏิบัติตามสัญญานี้ต่อไป
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.2 ผู้ให้เช่าจะไม่ก่อภาระผูกพันหรือทำการโอน ขาย จำหน่าย โดยวิธีอื่นใดในห้องชุดให้แก่บุคคลภายนอก นับแต่วันทำสัญญานี้เป็นต้นไป จนครบอายุการเช่า หากมีกรณีที่ห้องชุดต้องถูกโอนไปไม่ว่าด้วยเหตุใดๆ ก็ตามเว้นแต่ 
                        เป็นเหตุที่เป็นความผิดของผู้เช่า ผู้ให้เช่าต้องดำเนินการให้ผู้รับโอนผูกพันสิทธิและหน้าที่ตามสัญญาเช่าฉบับนี้ทุกประการ หากผู้ให้เช่าผิดเงื่อนไขดังกล่าว หรือมีการยกเลิกสัญญาเช่าก่อนครบกำหนดระยะเวลาและห้องเช่าดังกล่าวอยู่ระหว่าง การที่ผู้เช่า นำห้องเช่าดังกล่าวให้บุคคลภายนอกเช่าช่วง ผู้ให้เช่าจะต้องรับผิดชดใช้
                        ค่าเสียหายให้แก่ผู้เช่าเป็นเงินจำนวน 2 เท่า จากรายได้ค่าเช่าที่ผู้เช่าจะได้รับจากผู่้เช่าช่วง รวมทั้งผู้เช่ามีสิทธิเรียกค่าขาดประโยชน์ค่าเสียหายอื่นใดจากการที่ ผู้ให้เช่าผิดสัญญาดังกล่าวได้อีกด้วยตามความเสียหายที่แท้จริง รวมทั้งมีสิทธินำเงินค่าเช่าที่จะต้องชำระให้แก่ผู้ให้เช่ามา หักชำระเป็นค่าเสียหายดังกล่าวได้อีกด้วย
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.3 กรณีผู้ให้เช่าผิดนัดชำระค่างวดกับสถาบันการเงินที่รับจำนองห้องชุด ผู้ให้เช่ายินยอมให้ผู้เช่านำเงินค่าเช่าตาม ข้อ 3. ในเดือนที่ผู้ให้เช่าผิดนัดชำระค่างวดออกชำระค่างวดต่อสถาบันการเงินแทนผู้ให้เช่า โดยเมื่อผู้เช่าดำเนินการ 
                        เรียบร้อยแล้ว จะแจ้งให้ผู้ให้เช่าทราบภายใน 14 วัน นับแต่วันที่มีการนำเงินค่าเช่าตามข้อ 3. ออกชำระค่างวดแทน ผู้ให้เช่า
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.4 ค่าภาษีหัก ณ ที่จ่ายจากเงินได้ค่าเช่าของผูให้เช่าตลอดจนค่าใช้จ่ายส่วนกลาง ผู้ให้เช่าจะเป็นผู้ชำระเองทั้งสิ้น หากมีการทวงถามจากนิติบุคคลอาคารชุดแล้วผู้ให้เช่าไม่ชำระ ผู้ให้เช่ายินยอมให้ผู้เช่านำค่าเช่าที่จะต้อง
                        ชำระตามข้อ 3. ไปชำระค่าใช้จ่ายส่วนกลางแทนผู้ให้เช่า โดยให้ถือว่าเป็นการชำระค่าเช่าตามสัญญานี้
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 5. ข้อปฏิบัติของผู้เช่าต่อผู้ให้เช่า
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5.1 บรรดาค่าสาธารณูปโภค เช่น ไฟฟ้า น้ำประปา โทรศัพท์ ผู้เช่าจะเป็นผู้ชำระเองทั้งสิ้น</p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5.2 ผู้เช่ายินยอมให้ผู้ให้เช่ามีสิทธิเข้าทำการตรวจสภาพความเรียบร้อยของห้องชุดได้ตามระยะเวลาอันควร โดย ผู้ให้เช่าจะต้องแจ้งเป็นหนังสือให้ผู้เช่าทราบล่วงหน้าไม่น้อยกว่า 14 วันทำการ 
                        ในกรณีที่ผู้เช่าไม่อาจทราบหนังสือของ ผู้ให้เช่าดังกล่าวได้ โดยมีเหตุผลอันควรไม่ให้ถือว่าเป็นความผิดของผู้เช่า
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5.3 ผู้เช่ามีหน้าที่ดูแลรักษา และซ่อมแซมห้องชุด เสมือนวิญญูชนจะพึงสงวนรักษาทรัพย์สินของตนเองด้วยค่า ใช้จ่ายของผู้เช่าเอง เว้นแต่การชำรุดทรุดโทรมที่เกิดขึ้นตามสภาพของห้องชุดจนถึงขนาดต้องซ่อมแซมใหญ่
                        รวมไปถึง การชำรุดทรุดโทรมของอุปกรณ์ภายในห้องที่เกิดขึ้นตามสภาพโดยเสื่อมตามกาลเวลาของการใช้งาน ผู้ให้เช่าจึงเป็นผู้รับ ผิดชอบในค่าใช้จ่าย สำหรับการซ่อมแซมนั้น
                    </p>
                </td>
            </tr>
        </table>
        <div class="page-break"></div>
        <table border="0" width="100%">
            <tr>
                <td style="font-size: 21px; text-align:justify;line-height:18px;">
                    <p style="width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5.4 ผู้เช่าจะไม่ทำการดัดแปลง ต่อเติม รื้อถอน หรือเปลี่ยนแปลง ห้องชุด ไม่ว่าจะทั้งหมดหรือบางส่วน เว้นแต่จะได้รับความยินยอมเป็นลายลักษณ์อักษรจากผู้ให้เช่าก่อน หากผู้เช่าได้กระทำการไปโดยไม่ได้รับความยินยอม 
                        เป็นลายลักษณ์อักษรจากผู้ให้เช่า ผู้ให้เช่ามีสิทธิเรียกให้ผู้เช่าทำห้องชุดดังกล่าวให้กลับคืนคงสภาพเดิม
                    </p>
                    <p style="width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5.5 บรรดาทรัพย์สิน อุปกรณ์หรือเครื่องตกแต่งที่มีลักษณะติดตรึงตราหรือไม่ติดตรึงตรากับห้องชุด ที่ผู้เช่าหรือ บริวารผู้เช่านำมาติดตั้ง ไม่ว่าจะโดยได้รับความยินยอมจากผู้ให้เช่าหรือไม่ก็ตาม หากว่าไม่ใช่สิ่งสาระสำคัญในความเป็น อยู่ของห้องชุดนั้น  
                        เมื่อระยะเวลาการเช่าแห่งสัญญานี้สิ้นสุดลง ผู้เช่าสามารถรื้อถอนทรัพย์สินอุปกรณ์ หรือเครื่องตกแต่ง ดังกล่าวออกไปได้ โดยถือว่าเป็นกรรมสิทธิ์ของผู้เช่าโดยบรรดาค่าใช้จ่ายอันเกิดจาการรื้อถอนให้ผู้เช่าเป็นผู้เสียค่าใช้จ่าย เอง
                    </p>
                    <p style="width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5.6 เมื่อสัญญาฉบับนี้สิ้นสุดลงไม่ว่าด้วยเหตุใด ผู้เช่าต้องส่งมอบห้องชุดตามสภาพที่เกิดขึ้นจริงให้แก่ ผู้ให้เช่า</p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 6. ข้อยกเว้นความรับผิด
                    </p>
                    <p style="width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้ให้เช่าไม่ต้องรับผิดสำหรับความเสียหายหรือสูญหายหรือภยันตรายใดๆ อันเกิดขึ้นแก่ชีวิตร่างกายหรือทรัพย์สิน ใดๆ ของผู้เช่าหรือบริวารของผู้เช่ารวมตลอดถึงบุคคลอื่นใดข้างในห้องชุดยกเว้นเป็นความผิดโดยตรง 
                        หรือความประมาท เลินเล่อ ของผู้ให้เช่าหรือลูกจ้างหรือบริวารของผู้ให้เช่า
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 7. การเพิ่มเติมหรือแก้ไข</p>
                    <p style="width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หากฝ่ายหนึ่งฝ่ายใดประสงค์ที่จะทำการเปลี่ยนแปลงเพิ่มเติมหรือแก้ไข ข้อความใดๆ แห่งสัญญานี้ จะต้องทำเป็น หนังสือลงลายมือชื่อคู่สัญญาทั้งสองฝ่าย จึงจะมีผลผูกพันกันได้ต่อไป</p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 8. การบอกกล่าว</p>
                    <p style="width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บรรดาหนังสือจดหมายหรือคำบอกกล่าวใดๆที่คู่สัญญาฝ่ายหนึ่งฝ่ายใดส่งให้คู่สัญญาอีกฝ่ายหนึ่งไปยังสถานที่ที่ระบุ ไว้ข้างต้น หรือตามที่อยู่ที่คู่สัญญาได้แจ้งเปลี่ยนแปลงให้อีกฝ่ายหนึ่งทราบในภายหลัง ถ้าได้ส่งทางไปรษณีย์ลงทะเบียน
                    ให้ถือว่าได้รับแล้ว เว้นแต่ฝ่ายที่จะต้องได้รับคำบอกกล่าวพิสูจน์ได้ว่าไม่จงใจที่จะหลีกเลี่ยงรับหนังสือบอกกล่าว คู่สัญญา ทุกฝ่ายยินยอมผูกพันให้ถือว่า หนังสือ หรือคำบอกกล่าวนั้น ได้ส่งให้คู่สัญญาแต่ละฝ่ายโดยชอบแล้ว</p>
                    <p style="width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หากผู้เช่าประสงค์จะยกเลิกสัญญาเช่าฉบับนี้ ต้องทำการบอกกล่าวยกเลิกสัญญาเช่าไปยังผู้ให้เช่าทราบล่วงหน้า
                     เป็นระยะเวลาไม่น้อยกว่า 15 วัน ก่อนวันที่มีผลเลิกสัญญา และผู้เช่าจะต้องส่งมอบห้องชุดคืนภายใน 15 วัน นับแต่วันที่ ผู้ให้เช่าทราบ หรือถือว่าทราบการบอกกล่าวยกเลิกสัญญาเช่า</p>
                    
                </td>
            </tr>
        </table>
        <div class="page-break"></div>
        <table  border="0" width="100%">
            <tr>
                <td style="font-size: 21px; text-align:justify;line-height:18px;">
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 9. การผิดสัญญา
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หากคู่สัญญาฝ่ายหนึ่งฝ่ายใดไม่ปฏิบัติตามสัญญานี้ข้อหนึ่งข้อใด คู่สัญญาฝ่ายที่มิได้ปฏิบัติผิดสัญญามีสิทธิบอกเลิก สัญญาได้ทันที หรือคู่สัญญาฝ่ายมิได้ปฏิบัติผิดสัญญาอาจมีหนังสือแจ้งให้อีกฝ่ายหนึ่งทราบ เพื่อให้ปฏิบัติให้ถูกต้องตาม สัญญา ภายในระยะเวลาที่กำหนด หากคู่สัญญาฝ่ายปฏิบัติผิดสัญญายังไม่ปฏิบัติตาม หรือแก้ไขภายในเวลาที่กำหนด อีกฝ่ายหนึ่ง มีสิทธิบอกเลิกสัญญานี้ได้ และมีสิทธิเรียกค่าเสียหาย ค่าปรับ พร้อมดอกเบี้ยจากความเสียหายหรือจากการ ผิดนัดดังกล่าวในอัตราร้อยละ 15 ต่อปี หรือฟ้องร้องต่อศาลให้บังคับตามสัญญานี้
                    </p>
                    
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สัญญานี้ทำขึ้นรวมสองฉบับมีข้อความตรงกัน ต่างฝ่ายต่างยึดถือไว้ฝ่ายละฉบับ คู่สัญญาทั้งสองฝ่ายได้อ่าน ฟัง และเข้าใจข้อความแห่งสัญญานี้ดีแล้ว เห็นว่าถูกต้องตามเจตนาจึงลงลายมือชื่อและประทับตราไว้เป็นสำคัญต่อหน้า พยาน
                    </p>
                </td>
            </tr>
        </table>
        <table border="0" align="center" style="border-style: none;" width="90%">
            <tr>
                <td height="50px;"></td>
            </tr>
            <tr>
                <td width="40%" align="center" style="font-size:21px;">
                    ลงชื่อ.....................................................ผู้ให้เช่า</td>
                <td width="20%"></td>
                <td width="40%" align="center" style="font-size:21px;">
                    ลงชื่อ.....................................................ผู้เช่า</td>
            </tr>
            <tr>
                <td width="40%" align="center" style="font-size:21px;"><b>{{ $rents->Owner }}</b>
                </td>
                <td width="20%"></td>
                <td width="40%" align="center" style="font-size:21px;"><b>บริษัท วีบียอนด์ แมเนจเม้นท์ จำกัด</b></td>
            </tr>
            <tr>
                <td height="35px"></td>
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
                    ({{ $phayarn1 == null ? "....................................................." :  $phayarn1 }} )
                </td>
                <td width="20%"></td>
                <td width="40%" align="center" style="font-size:21px;">
                    ({{ $phayarn2 == null ? "....................................................." : $phayarn2 }} )
            </tr>
        </table>
        <div class="page-break"></div>
        @php
           if (!$rents->KeyCard && !$rents->KeyCard_P && !$rents->KeyCard_B && !$rents->KeyCard_C) {
                $cardKey = "";
           } else{
                $cardKey = ( ((int)$rents->KeyCard) + ((int)$rents->KeyCard_P) + ((int)$rents->KeyCard_B) + ((int)$rents->KeyCard_C)) ?? 0;
           }
           $bedroomAir = isset($rents->Bedroom_Air) && is_numeric($rents->Bedroom_Air) ? $rents->Bedroom_Air : 0;
           $livingroomAir = isset($rents->Livingroom_Air) && is_numeric($rents->Livingroom_Air) ? $rents->Livingroom_Air : 0;
        @endphp
        <h1 align="center"  style="font-size:22px;">รายการแสดงทรัพย์สินและอุปกรณ์แนบท้ายสัญญา</h1>
        <table border=1 cellspacing=0 cellpadding=2 width=100% style="font-size:20px;line-height:16px;">

            <tr bgcolor="#d1d1d1">
                <td align="center" width=6%>ลำดับ</td>
                <td align="center">รายการ</td>
                <td align="center" width=5%>มี</td>
                <td align="center" width=5%>ไม่มี</td>
                <td align="center" width=7%>จำนวน</td>
                <td align="center" width=23%>หมายเหตุ</td>
            </tr>
            <tr bgcolor=#FFFFFF>
                <td align=center>1.</td>
                <td align="left">&nbsp;&nbsp;เครื่องปรับอากาศ (แอร์) ขนาด 9000 บีทียู พร้อมรีโมท (เครื่อง)</td>
                <td align=center>{{ $rents->Bedroom_Air && $rents->Livingroom_Air ? "/" : ""}}</td>
                <td align=center>{{ !$rents->Bedroom_Air && !$rents->Livingroom_Air ? "/" : ""}}</td>
                <td align="center">{{ ($bedroomAir+$livingroomAir) }}</td>
                <td align="right"></td>
            </tr>
            <tr align=center bgcolor=#FFFFFF>
                <td align=center>2.</td>
                <td align="left">&nbsp;&nbsp;เครื่องทำน้ำอุ่น (เครื่อง)</td>
                <td align=center>{{$rents->Water_Heater ? "/" : ""}}</td>
                <td align=center>{{!$rents->Water_Heater ? "/" : ""}}</td>
                <td align="center">{{$rents->Water_Heater ?? 0 }}</td>
                <td align="right"></td>
            </tr>

            <tr align=center bgcolor=#FFFFFF>
                <td align=center>3.</td>
                <td align="left">&nbsp;&nbsp;เตียงนอน (หลัง)</td>
                <td align=center>{{$rents->Bed ? "/" : ""}}</td>
                <td align=center>{{!$rents->Bed ? "/" : ""}}</td>
                <td align="center">{{$rents->Bed ?? 0}}</td>
                <td align="right"></td>
            </tr>
            <tr align=center bgcolor=#FFFFFF>
                <td align=center>4.</td>
                <td align="left">&nbsp;&nbsp;ที่นอน (หลัง)</td>
                <td align=center>{{$rents->Beding ? "/" : ""}}</td>
                <td align=center>{{!$rents->Beding ? "/" : ""}}</td>
                <td align="center">{{$rents->Beding ?? 0 }}</td>
                <td align="right"></td>
            </tr>
            <tr align=center bgcolor=#FFFFFF>
                <td align=center>5.</td>
                <td align="left">&nbsp;&nbsp;หมอน (ใบ)</td>
                <td align=center>{{$rents->Beding ? "/" : ""}}</td>
                <td align=center>{{!$rents->Beding ? "/" : ""}}</td>
                <td align="center">{{$rents->Beding ?? 0 }}</td>
                <td align="right"></td>
            </tr>
            <tr align=center bgcolor=#FFFFFF>
                <td align=center>6.</td>
                <td align="left">&nbsp;&nbsp;ตู้เสื้อผ้า (หลัง)</td>
                <td align=center>{{$rents->Wardrobe ? "/" : ""}}</td>
                <td align=center>{{!$rents->Wardrobe ? "/" : ""}}</td>
                <td align="center">{{$rents->Wardrobe ?? 0}}</td>
                <td align="right"></td>
            </tr>
            <tr align=center bgcolor=#FFFFFF>
                <td align=center>7.</td>
                <td align="left">&nbsp;&nbsp;โซฟา (ชุด)</td>
                <td align=center>{{$rents->Sofa ? "/" : ""}}</td>
                <td align=center>{{!$rents->Sofa ? "/" : ""}}</td>
                <td align="center">{{$rents->Sofa ?? 0 }}</td>
                <td align="right"></td>
            </tr>
            <tr align=center bgcolor=#FFFFFF>
                <td align=center>8.</td>
                <td align="left">&nbsp;&nbsp;โต๊ะรับประทานอาหาร (ตัว)</td>
                <td align=center>{{$rents->Dining_Table ? "/" : ""}}</td>
                <td align=center>{{!$rents->Dining_Table ? "/" : ""}}</td>
                <td align="center">{{$rents->Dining_Table ?? 0}}</td>
                <td align="right"></td>
            </tr>

            <tr align=center bgcolor=#FFFFFF>
                <td align=center>9.</td>
                <td align="left">&nbsp;&nbsp;โต๊ะวางโทรทัศน์ (ตัว)</td>
                <td align=center>{{$rents->TV_Table ? "/" : ""}}</td>
                <td align=center>{{!$rents->TV_Table ? "/" : ""}}</td>
                <td align="center">{{$rents->TV_Table ?? 0}}</td>
                <td align="right"></td>
            </tr>
            <tr align=center bgcolor=#FFFFFF>
                <td align=center>10.</td>
                <td align="left">&nbsp;&nbsp;โต๊ะกลาง (ตัว)</td>
                <td align=center>{{$rents->Center_Table ? "/" : ""}}</td>
                <td align=center>{{!$rents->Center_Table ? "/" : ""}}</td>
                <td align="center">{{$rents->Center_Table ?? 0}}</td>
                <td align="right"></td>
            </tr>
            <tr align=center bgcolor=#FFFFFF>
                <td align=center>11.</td>
                <td align="left">&nbsp;&nbsp;เก้าอี้โต๊ะรับประทานอาหาร (ตัว)</td>
                <td align=center>{{$rents->Chair ? "/" : ""}}</td>
                <td align=center>{{!$rents->Chair ? "/" : ""}}</td>
                <td align="center">{{$rents->Chair ?? 0}}</td>
                <td align="right"></td>
            </tr>
            <tr align=center bgcolor=#FFFFFF>
                <td align=center>12.</td>
                <td align="left">&nbsp;&nbsp;คีย์การ์ด (ใบ)</td>
                <td align=center>{{$cardKey ? "/" : ""}}</td>
                <td align=center>{{!$cardKey ? "/" : ""}}</td>
                <td align="center">{{ $cardKey }}</td>
                <td align="left">{{ $rents->KeyCard ? "คีย์การ์ด" : ""}}{{ $rents->KeyCard_P ? "คีย์การ์ด P" : ""}}{{ $rents->KeyCard_B ? "คีย์การ์ด B" : ""}}{{ $rents->KeyCard_C ? "คีย์การ์ด C" : ""}}</td>
            </tr>
            <tr align=center bgcolor=#FFFFFF>
                <td align=center>13.</td>
                <td align="left">&nbsp;&nbsp;กุญแจเข้าห้อง (ดอก)</td>
                <td align=center>{{$rents->Key_front ? "/" : ""}}</td>
                <td align=center>{{!$rents->Key_front ? "/" : ""}}</td>
                <td align="center">{{$rents->Key_front ?? 0}}</td>
                <td align="right"></td>
            </tr>
            <tr align=center bgcolor=#FFFFFF>
                <td align=center>14.</td>
                <td align="left">&nbsp;&nbsp;กุญแจห้องนอน (ดอก)</td>
                <td align=center>{{$rents->Key_bed ? "/" : ""}}</td>
                <td align=center>{{!$rents->Key_bed ? "/" : ""}}</td>
                <td align="center">{{$rents->Key_bed ?? 0}}</td>
                <td align="right"></td>
            </tr>
            <tr align=center bgcolor=#FFFFFF>
                <td align=center>15.</td>
                <td align="left">&nbsp;&nbsp;กุญแจตู้จดหมาย (ดอก)</td>
                <td align=center>{{$rents->Key_mailbox ? "/" : ""}}</td>
                <td align=center>{{!$rents->Key_mailbox ? "/" : ""}}</td>
                <td align="center">{{$rents->Key_mailbox ?? 0}}</td>
                <td align="right"></td>
            </tr>
            <tr align=center bgcolor=#FFFFFF>
                <td align=center>16.</td>
                <td align="left">&nbsp;&nbsp;ผ้าม่านห้องนั่งเล่น (ชุด)</td>
                <td align=center>{{$rents->Livingroom_Curtain ? "/" : ""}}</td>
                <td align=center>{{!$rents->Livingroom_Curtain ? "/" : ""}}</td>
                <td align="center">{{$rents->Livingroom_Curtain ?? 0}}</td>
                <td align="right"></td>
            </tr>

            <tr align=center bgcolor=#FFFFFF>
                <td align=center>17.</td>
                <td align="left">&nbsp;&nbsp;ผ้าม่านห้องนอน (ชุด)</td>
                <td align=center>{{$rents->Bedroom_Curtain ? "/" : ""}}</td>
                <td align=center>{{!$rents->Bedroom_Curtain ? "/" : ""}}</td>
                <td align="center">{{$rents->Bedroom_Curtain ?? 0}}</td>
                <td align="right"></td>
            </tr>
            <tr bgcolor="#d1d1d1">
                <td colspan="6">อื่น ๆ เพิ่มเติม (ถ้ามี)</td>
            </tr>
            <tr align=center bgcolor=#FFFFFF>
                <td align=center>18.</td>
                <td align="left">&nbsp;&nbsp;ตู้เย็น ขนาด .......... คิว (ตู้)</td>
                <td align=center>{{ $rents->Refrigerator ? "/" : ""}}</td>
                <td align=center>{{ !$rents->Refrigerator ? "/" : ""}}</td>
                <td align="center">{{ $rents->Refrigerator ?? 0 }}</td>
                <td align="right"></td>
            </tr>
            <tr align=center bgcolor=#FFFFFF>
                <td align=center>19.</td>
                <td align=left>&nbsp;&nbsp;ไมโครเวฟ (เครื่อง)</td>
                <td align=center>{{ $rents->microwave  ? "/" : "" }}</td>
                <td align=center>{{ !$rents->microwave  ? "/" : "" }}</td>
                <td align="center">{{ $rents->microwave ?? 0 }}</td>
                <td align="right"></td>
            </tr>
            <tr align=center bgcolor=#FFFFFF>
                <td align=center>20.</td>
                <td align=left>&nbsp;&nbsp;ทีวี .......... นิ้ว (เครื่อง)</td>
                <td align=center>{{ $rents->TV  ? "/" : "" }}</td>
                <td align=center>{{ !$rents->TV  ? "/" : "" }}</td>
                <td align="center">{{ $rents->TV ?? 0}}</td>
                <td align="right"></td>
            </tr>
            <tr align=center bgcolor=#FFFFFF>
                <td align=center>21.</td>
                <td align=left>&nbsp;&nbsp;เครื่องซักผ้า (เครื่อง)</td>
                <td align=center>{{ $rents->wash_machine  ? "/" : "" }}</td>
                <td align=center>{{ !$rents->wash_machine  ? "/" : "" }}</td>
                <td align="center">{{ $rents->wash_machine ?? 0 }}</td>
                <td align="right"></td>
            </tr>



            <tr align=center bgcolor=#FFFFFF>
                <td colspan=6 align=left height="60px">&nbsp;&nbsp;**หมายเหตุ : {{ $rents->Other }}</td>
            </tr>
        </table>
        <table border="0" align="center" style="border-style: none;" width="90%">
            <tr>
                <td height="30px"></td>
            </tr>
            <tr>
                <td width="40%" align="center" style="font-size:22px;">
                    ลงชื่อผู้ให้เช่า</td>
                <td width="20%"></td>
                <td width="40%" align="center" style="font-size:22px;">
                    เจ้าหน้าที่ส่งมอบ</td>
            </tr>
            <tr>
                <td height="40px"></td>
            </tr>
            <tr>
                <td width="40%" align="center" style="font-size:22px;">(<b>{{ $rents->Cus_Name ?? '.....................................................'}}</b>)</td>
                <td width="20%"></td>
                <td width="40%" align="center" style="font-size:22px;">(.....................................................)
                </td>
            </tr>
            <tr>
                <td width="40%" align="center" style="font-size:22px;"> ........ / ........ / ........ </td>
                <td width="20%"></td>
                <td width="40%" align="center" style="font-size:22px;"> ........ / ........ / ........
                </td>
            </tr>

        </table>

    </div>
</body>
</html>