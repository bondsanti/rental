<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>สัญญาประกันทรัพย์สินและอุปกรณ์ตกแต่งห้องชุด</title>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> --}}
    {{-- <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@200;300;400;500&display=swap" rel="stylesheet"> --}}
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
                    <h1>สัญญาประกันทรัพย์สินและอุปกรณ์ตกแต่งห้องชุด</h1>
                </td>
            </tr>
            <tr>
                <td align="right" style="font-size:20px; line-height: 0px">
                    สัญญาเลขที่ {{ $rents->code_contract_insurance }}
                </td>
            </tr>
            <tr>

                <td align="right" style="line-height: 5px">
                    <h2>ทำที่ บริษัท วีบียอนด์ แมเนจเม้นท์ จำกัด</h2>
                    <h2> วันที่ {{ thaidate('j F พ.ศ. Y',$rents->print_contract_manual) }}</h2>
                </td>
            </tr>
            <tr>
                <td style="font-size: 22px; text-align:justify;">
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สัญญาฉบับนี้ทำขึ้นระหว่าง <b>บริษัท วีบียอนด์
                            แมเนจเม้นท์ จำกัด สำนักงานใหญ่ เลขที่ 1 อาคาร
                            เอ็มไพร์ ทาวเวอร์ ชั้นที่ 24 ห้องเลขที่ 2401 ถนนสาทรใต้ แขวงยานนาวา เขตสาทร
                            กรุงเทพมหานคร</b> ซึ่งต่อไปใน สัญญานี้เรียกว่า <b>“ผู้ให้เช่าช่วง”</b> ฝ่ายหนึ่ง</p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;กับ <b> {{ $rents->Cus_Name }}
                        ถือบัตรประจำตัวประชาชนเลขที่/หนังสือเดินทางเลขที่ {{ $rents->IDCard }}
                        ที่อยู่ {{ $rents->home_address }}  
                        ซอย {{ $rents->cust_soi ?? " -" }} ถนน {{ $rents->cust_road ?? " -" }}
                        แขวง/ตำบล {{ $rents->tumbon }}
                        เขต/อำเภอ {{ $rents->aumper }}
                        จังหวัด {{ $rents->province }}</b> ซึ่งต่อไปในสัญญานี้เรียกว่า
                        <b>“ผู้เช่าช่วง”</b> อีกฝ่ายหนึ่ง ทั้งสองฝ่ายตกลงทำสัญญากัน ดังมีข้อความต่อไปนี้
                    </p>
                    @if($rents->address_full)
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สัญญาฉบับนี้ถือเป็นส่วนหนึ่งของสัญญาเช่าช่วงห้องชุดในอาคารชุด
                            <b>ห้องชุดเลขที่ {{ $rents->cus_room_no ??  '' }} บ้านเลขที่ {{ $rents->RoomNo ??  ''}} ตึก {{ $rents->Building ?? '' }}
                                 ชั้นที่ {{ $rents->Floor ?? '' }} อาคารชุด {{ $rents->Project_NameTH == NULL ? "โครงการ" . $rents->Project_Name : $rents->Project_NameTH }} {{ $rents->address_full }}</b>
                             </b> สัญญาเช่าช่วงห้องชุด <b>สัญญาเลขที่ {{ $rents->code_contract_old }} </b>
                            ฉบับลงวันที่ <b>วันที่ {{ thaidate('j F พ.ศ. Y',$rents->print_contract_manual) }}</b>
                        </p>
                    @else
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สัญญาฉบับนี้ถือเป็นส่วนหนึ่งของสัญญาเช่าช่วงห้องชุดในอาคารชุด
                            <b>ห้องชุดเลขที่ {{ $rents->cus_room_no ??  '' }} บ้านเลขที่ {{ $rents->RoomNo ??  ''}} ตึก {{ $rents->Building ?? '' }}
                                ชั้นที่ {{ $rents->Floor ?? '' }} อาคารชุด {{ $rents->Project_NameTH == NULL ? "โครงการ" . $rents->Project_Name : $rents->Project_NameTH }}</b>
                            </b> สัญญาเช่าช่วงห้องชุด <b>สัญญาเลขที่ {{ $rents->code_contract_old }} </b>
                            ฉบับลงวันที่ <b>วันที่ {{ thaidate('j F พ.ศ. Y',$rents->print_contract_manual) }}</b>
                        </p>
                    @endif

                    @if($rents->address_full)
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 1. ผู้ให้เช่าช่วงตกลงให้เช่า และผู้เช่าช่วงตกลงประกันทรัพย์สินและอุปกรณ์ที่ติดตั้งหรือมีอยู่ใน <b>ห้องชุดเลขที่ {{ $rents->cus_room_no ??  '' }} อาคารชุดชื่อ {{ $rents->Project_NameTH == NULL ? "โครงการ" . $rents->Project_Name : $rents->Project_NameTH }} {{ $rents->address_full }} มีเนื้อที่ ห้องชุดประมาณ {{  $rents->Size}} ตารางเมตร
                                มีกำหนดระยะเวลาการเช่า {{ $rents->Contract }} เดือน {{ $rents->Day }} วัน เริ่มตั้งแต่วันที่ {{ thaidate('j F พ.ศ. Y', $rents->Contract_Startdate) }} ถึง วันที่ {{ thaidate('j F พ.ศ. Y', $rents->Contract_Enddate) }}</b> ตามรายการแสดงทรัพย์สินและ อุปกรณ์แนบท้ายสัญญานี้ซึ่งต่อไปในสัญญานี้ เรียกว่า <b>“ทรัพย์สินที่เช่า”</b>
                        </p>
                    @else
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 1. ผู้ให้เช่าช่วงตกลงให้เช่า และผู้เช่าช่วงตกลงประกันทรัพย์สินและอุปกรณ์ที่ติดตั้งหรือมีอยู่ใน <b>ห้องชุดเลขที่ {{ $rents->cus_room_no ??  '' }} อาคารชุดชื่อ {{ $rents->Project_NameTH == NULL ? "โครงการ" . $rents->Project_Name : $rents->Project_NameTH }} มีเนื้อที่ ห้องชุดประมาณ {{  $rents->Size}} ตารางเมตร
                                มีกำหนดระยะเวลาการเช่า {{ $rents->Contract }} เดือน {{ $rents->Day }} วัน เริ่มตั้งแต่วันที่ {{ thaidate('j F พ.ศ. Y', $rents->Contract_Startdate) }} ถึง วันที่ {{ thaidate('j F พ.ศ. Y', $rents->Contract_Enddate) }}</b> ตามรายการแสดงทรัพย์สินและ อุปกรณ์แนบท้ายสัญญานี้ซึ่งต่อไปในสัญญานี้ เรียกว่า <b>“ทรัพย์สินที่เช่า”</b>
                        </p>
                    @endif

                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 2. เพื่อเป็นประกันในการปฏิบัติตามสัญญา ผู้เช่าช่วงตกลงมอบเงินประกันการเช่าจำนวนเงิน <b>{{ $rents->price_insurance == null ? "0 บาท" : number_format($rents->price_insurance, 2) }} ({{ $price_insurance == null ? "ศูนย์บาท" :  $price_insurance }})</b> ตามหนังสือสัญญาทรัพย์สินและอุปกรณ์ตกแต่งห้อง <b>สัญญาเลขที่ {{ $rents->code_contract_old ?? ''}} </b> ฉบับลงวันที่ <b>{{ thaidate('j F พ.ศ. Y',$rents->print_contract_manual) }}</b> และผู้ให้ เช่าช่วงได้รับเงินจำนวนดังกล่าวแล้วในวันทำสัญญาฉบับนี้ ถ้าผู้เช่าช่วงเช่าครบตามที่สัญญากำหนด และมิได้มีหนี้ค้างชำระ ตามสัญญาผู้ให้เช่าช่วงจะคืนเงินประกัน
                        สัญญานี้ให้แก่ผู้เช่าโดยไม่มีดอกเบี้ย หากมีความเสียหายเกี่ยวกับทรัยพ์สินและ อุปกรณ์ตกแต่งห้องชุด หรือไม่ปฏิบัติตามสัญญาเช่าช่วงห้องชุด ผู้เช่าช่วงยินยอมให้ผู้ให้เช่าหักชำระค่าเสียหายนั้นออกจาก เงินประกันสัญญา และคืนเงินส่วนที่เหลือโดยไม่มีดอกเบี้ยให้ หลังจากที่ได้หักเป็นค่าใช้จ่ายหรือค่าเสียหายอย่างใดๆ อันเกิดขึ้นแก่ทรัพย์สินที่ประกันแล้วภายใน 30 (สามสิบ) วัน นับจากวันที่ผู้ให้เช่าได้รับมอบครอบครองทรัพย์สินและ อุปกรณ์ตกแต่งห้องชุดเรียบร้อยแล้ว
                    </p>
                    
            </tr>
        </table>
        <div class="page-break"></div>
        <table border="0" width="100%">
            <tr>
                <td style="font-size: 22px; text-align:justify;">
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 3. เงินประกันทรัพย์สินและอุปกรณ์ตามข้อ 2. หากผู้เช่าช่วงมียอดหนี้ค่าเช่าค้างชำระในแต่ละเดือน ผู้ให้เช่าช่วง มีสิทธินำเงินประกันทรัพย์สิน และอุปกรณ์มาหักเป็นค่าเช่าที่ค้างชำระได้ทั้งหมด หากมียอดค้างค่าเช่าในแต่ละเดือนโดย ผู้ให้เช่าช่วงไม่ต้องบอกกล่าวแก่ผู้เช่าช่วงก่อน</p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 4. สำหรับเงินประกันทรัพย์สินและอุปกรณ์ ตามข้อ 2. ในระหว่างที่สัญญายังไม่ได้เลิกกัน ผู้เช่าช่วงไม่มีสิทธิ ให้ผู้เช่าช่วงนำเงินประกันทรัพย์สินและอุปกรณ์มาหักเป็นค่าเช่าที่ค้างชำระในแต่ละงวดการชำระได้</p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 5. ผู้เช่าช่วงสัญญาว่าจะไม่ต่อเติมดัดแปลงหรือทำการใดๆ อันทำให้ทรัพย์สินที่ประกันเสียหาย ชำรุด หรือไม่ สามารถใช้การได้โดยปกติ
                        การดัดแปลงหรือต่อเติมใดๆ ที่ผู้เช่าช่วงได้กระทำลงไปในทรัพย์ที่ประกันผู้ให้เช่าช่วงมีสิทธิที่จะให้ ผู้เช่าช่วงแก้ไข หรือซ่อมแซมให้คืนสภาพเดิม โดยผู้เช่าช่วงจะเป็นผู้ออกค่าใช่จ่ายสำหรับการนั้น และหากผู้เช่าไม่สามารถ ทำให้ทรัพย์สิน
                        ที่เช่ากลับคืนสู่สภาพปกติได้ ผู้เช่าช่วงต้องรับผิดชอบสำหรับความเสียหายอันเกิดนั้น โดยผู้เช่าช่วงจะ บำรุงรักษาทรัพย์สินที่ประกัน ให้อยู่ในสภาพที่ดีตลอดเวลาเสมือนหนึ่งเป็นทรัพย์สินของตนเอง โดยการนี้ผู้เช่าช่วงยินยอม ให้ผู้ให้เช่าช่วงเข้าทำการตรวจสภาพ ทรัพย์สิน ที่ประกันได้ตามระยะเวลาอันควร
                        โดยผู้ให้เช่าช่วงจะต้องแจ้งเป็นหนังสือ ให้ผู้เช่าช่วงทราบล่วงหน้าไม่น้อยกว่า 7 (เจ็ดวัน) วันทำการ</p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 6. ทรัพย์สินที่ประกันตามสัญญานี้ผู้เช่าช่วงจะให้เช่าช่วง หรือโอนสิทธิการเช่าไม่ว่าทั้งหมด หรือบางส่วนให้แก่ ผู้อื่นไม่ได้ <b> เว้นแต่จะได้รับความยินยอมเป็นลายลักษณ์อักษรจาก “ผู้ให้เช่าช่วง”</b></p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 7. เมื่อครบกำหนดอายุสัญญาเช่าสิ้นสุดลงไม่ว่าเหตุใดๆ ผู้เช่าช่วงจะต้องส่งมอบทรัพย์สินที่ประกันคืนแก่ผู้ให้เช่า ช่วง ในสภาพเรียบร้อยทันทีหากผู้เช่าช่วงล่าช้า
                        ในการส่งคืนทรัพย์สินที่เช่า ไม่ว่าเหตุประการใดๆ ก็ตาม ผู้เช่าช่วงยอมให้ <b> “ผู้ให้เช่าช่วง” </b>ปรับในอัตรา 2 เท่าของเงินประกันนอกจากนี้ <b>“ผู้ให้เช่าช่วง”</b> มีสิทธิเข้าครอบครองยึดหน่วงทรัพย์สิน ที่ประกันทั้งปวงได้ทันที หากปรากฎว่าทรัพย์สินที่ประกันเกิดชำรุดเสียหาย
                        บุบสลายหรือสูญเสียไปด้วยประการใดๆก็ดี ผู้เช่าช่วงต้องรับผิดชอบชดใช้ค่าเสียหายอื่นๆ อันอาจจะพึงมี อีกส่วนหนึ่งด้วย
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 8. หากผู้เช่าช่วงประสงค์จะทำการประกันภัยทรัพย์สินภายในห้องเช่า จะต้องแจ้งเป็นหนังสือให้ผู้ให้เช่าช่วงได้ พิจารณา และยินยอมเป็นลายลักษณ์อักษรก่อนจึงกระทำได้
                    </p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 9. นอกจากที่กำหนดไว้ในสัญญานี้โดยชัดแจ้งแล้ว ข้อตกลงอื่นให้ถือตามสัญญาเช่าช่วงห้องชุด <b>ฉบับลงวันที่ {{ thaidate('j F พ.ศ. Y',$rents->print_contract_manual) }}</b></p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 10. หากฝ่ายใดฝ่ายหนึ่งประสงค์ที่จะทำการเปลี่ยนแปลงเพิ่มเติม หรือแก้ไขข้อความใดๆ แห่งสัญญานี้จะต้อง ทำเป็นหนังสือลงลายมือชื่อคู่สัญญาทั้งสองฝ่าย จึงจะมีผลผูกพันกันได้ต่อไป</p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สัญญานี้ทำขึ้นเป็นสองฉบับมีข้อความถูกต้องตรงกันทุกประการ คู่สัญญาได้อ่านฟังและเข้าใจข้อความแห่ง&nbsp; สัญญานี้ดีแล้วและเห็นว่าถูกต้องตามเจตนา จึงลงลายมือชื่อและประทับตราไว้เป็นสำคัญต่อหน้าพยาน</p>
                </td>
            </tr>
        </table>
        <div class="page-break"></div>
        <table border="0" align="center" style="border-style: none;">
            <tr>
                <td height="700px"></td>
            </tr>
            <tr>
                <td width="45%" align="center" style="font-size:22px;">
                    ลงชื่อ.....................................................ผู้ให้เช่าช่วง</td>
                <td width="10%"></td>
                <td width="45%" align="center" style="font-size:22px;">
                    ลงชื่อ.....................................................ผู้เช่า</td>
            </tr>
            <tr>
                <td width="45%" align="center" style="font-size:22px;"><b>บริษัท วีบียอนด์ แมเนจเม้นท์ จำกัด</b></td>
                <td width="10%"></td>
                <td width="45%" align="center" style="font-size:22px;">({{ $rents->Cus_Name ?? '' }})
                </td>
            </tr>
            <tr>
                <td height="35px"></td>
            </tr>
            <tr>
                <td width="45%" align="center" style="font-size:22px;">
                    ลงชื่อ.....................................................พยาน</td>
                <td width="20%"></td>
                <td width="45%" align="center" style="font-size:22px;">
                    ลงชื่อ.....................................................พยาน</td>
            </tr>
            <tr>
                <td width="45%" align="center" style="font-size:22px;">

                    ( {{ $phayarn1 == null ? "....................................................." : $phayarn1 }} )
                </td>
                <td width="10%"></td>
                <td width="45%" align="center" style="font-size:22px;">
                    ( {{ $phayarn2 == null ? "....................................................." : $phayarn2 }} )
                </td>
            </tr>
        </table>
        <div class="page-break"></div>
        <h1 align="center">รายการแสดงทรัพย์สินและอุปกรณ์แนบท้ายสัญญา</h1>
        <table border=1 cellspacing=0 cellpadding=2 width=100% style="font-size:20px;">

            <tr class="container" bgcolor="#d1d1d1">
                <td align="center" width=8%>ลำดับ</td>
                <td align="center">รายการ</td>
                <td align="center" width=5%>มี</td>
                <td align="center" width=5%>ไม่มี</td>
                <td align="center" width=8%>จำนวน</td>
                <td align="center" width=25%>หมายเหตุ</td>
            </tr>
            <tr class="container" bgcolor=#FFFFFF>
                <td align=center>1.</td>
                <td align="left">&nbsp;&nbsp; เครื่องปรับอากาศ (แอร์) ขนาด 9000 บีทียู พร้อมรีโมท (เครื่อง)</td>
                <td align=center></td>
                <td align=center></td>
                <td align="center"></td>
                <td align="right"></td>
            </tr>
            <tr class="container" align=center bgcolor=#FFFFFF>
                <td align=center>2.</td>
                <td align="left">&nbsp;&nbsp;เครื่องทำน้ำอุ่น (เครื่อง)</td>
                <td align=center></td>
                <td align=center></td>
                <td align="center"></td>
                <td align="right"></td>
            </tr>

            <tr class="container" align=center bgcolor=#FFFFFF>
                <td align=center>3.</td>
                <td align="left">&nbsp;&nbsp;เตียงนอน (หลัง)</td>
                <td align=center></td>
                <td align=center></td>
                <td align="center"></td>
                <td align="right"></td>
            </tr>
            <tr class="container" align=center bgcolor=#FFFFFF>
                <td align=center>4.</td>
                <td align="left">&nbsp;&nbsp;ที่นอน (หลัง)</td>
                <td align=center></td>
                <td align=center></td>
                <td align="center"></td>
                <td align="right"></td>
            </tr>
            <tr class="container" align=center bgcolor=#FFFFFF>
                <td align=center>5.</td>
                <td align="left">&nbsp;&nbsp;หมอน (ใบ)</td>
                <td align=center></td>
                <td align=center></td>
                <td align="center"></td>
                <td align="right"></td>
            </tr>
            <tr class="container" align=center bgcolor=#FFFFFF>
                <td align=center>6.</td>
                <td align="left">&nbsp;&nbsp;ตู้เสื้อผ้า (หลัง)</td>
                <td align=center></td>
                <td align=center></td>
                <td align="center"></td>
                <td align="right"></td>
            </tr>
            <tr class="container" align=center bgcolor=#FFFFFF>
                <td align=center>7.</td>
                <td align="left">&nbsp;&nbsp;โซฟา (ชุด)</td>
                <td align=center></td>
                <td align=center></td>
                <td align="center"></td>
                <td align="right"></td>
            </tr>
            <tr class="container" align=center bgcolor=#FFFFFF>
                <td align=center>8.</td>
                <td align="left">&nbsp;&nbsp;โต๊ะรับประทานอาหาร (ตัว)</td>
                <td align=center></td>
                <td align=center></td>
                <td align="center"></td>
                <td align="right"></td>
            </tr>

            <tr class="container" align=center bgcolor=#FFFFFF>
                <td align=center>9.</td>
                <td align="left">&nbsp;&nbsp;โต๊ะวางโทรทัศน์ (ตัว)</td>
                <td align=center></td>
                <td align=center></td>
                <td align="center"></td>
                <td align="right"></td>
            </tr>
            <tr class="container" align=center bgcolor=#FFFFFF>
                <td align=center>10.</td>
                <td align="left">&nbsp;&nbsp;โต๊ะกลาง (ตัว)</td>
                <td align=center></td>
                <td align=center></td>
                <td align="center"></td>
                <td align="right"></td>
            </tr>
            <tr class="container" align=center bgcolor=#FFFFFF>
                <td align=center>11.</td>
                <td align="left">&nbsp;&nbsp;เก้าอี้โต๊ะรับประทานอาหาร (ตัว)</td>
                <td align=center></td>
                <td align=center></td>
                <td align="center"></td>
                <td align="right"></td>
            </tr>
            <tr class="container" align=center bgcolor=#FFFFFF>
                <td align=center>12.</td>
                <td align="left">&nbsp;&nbsp;คีย์การ์ด (ใบ)</td>
                <td align=center></td>
                <td align=center></td>
                <td align="center"></td>
                <td align="left"></td>
            </tr>
            <tr class="container" align=center bgcolor=#FFFFFF>
                <td align=center>13.</td>
                <td align="left">&nbsp;&nbsp;กุญแจเข้าห้อง (ดอก)</td>
                <td align=center></td>
                <td align=center></td>
                <td align="center"></td>
                <td align="right"></td>
            </tr>
            <tr class="container" align=center bgcolor=#FFFFFF>
                <td align=center>14.</td>
                <td align="left">&nbsp;&nbsp;กุญแจห้องนอน (ดอก)</td>
                <td align=center></td>
                <td align=center></td>
                <td align="center"></td>
                <td align="right"></td>
            </tr>
            <tr class="container" align=center bgcolor=#FFFFFF>
                <td align=center>15.</td>
                <td align="left">&nbsp;&nbsp;กุญแจตู้จดหมาย (ดอก)</td>
                <td align=center></td>
                <td align=center></td>
                <td align="center"></td>
                <td align="right"></td>
            </tr>
            <tr class="container" align=center bgcolor=#FFFFFF>
                <td align=center>16.</td>
                <td align="left">&nbsp;&nbsp;ผ้าม่านห้องนั่งเล่น (ชุด)</td>
                <td align=center></td>
                <td align=center></td>
                <td align="center"></td>
                <td align="right"></td>
            </tr>

            <tr class="container" align=center bgcolor=#FFFFFF>
                <td align=center>17.</td>
                <td align="left">&nbsp;&nbsp;ผ้าม่านห้องนอน (ชุด)</td>
                <td align=center></td>
                <td align=center></td>
                <td align="center"></td>
                <td align="right"></td>
            </tr>
            <tr bgcolor="#d1d1d1">
                <td colspan="6">อื่น ๆ เพิ่มเติม (ถ้ามี)</td>
            </tr>
            <tr class="container" align=center bgcolor=#FFFFFF>
                <td align=center>18.</td>
                <td align="left">&nbsp;&nbsp;ตู้เย็น ขนาด .......... คิว (ตู้)</td>
                <td align=center></td>
                <td align=center></td>
                <td align="center"></td>
                <td align="right"></td>
            </tr>
            <tr class="container" align=center bgcolor=#FFFFFF>
                <td align=center>19.</td>
                <td align=left>&nbsp;&nbsp;ไมโครเวฟ (เครื่อง)</td>
                <td align=center></td>
                <td align=center></td>
                <td align="center"></td>
                <td align="right"></td>
            </tr>
            <tr class="container" align=center bgcolor=#FFFFFF>
                <td align=center>20.</td>
                <td align=left>&nbsp;&nbsp;ทีวี .......... นิ้ว (เครื่อง)</td>
                <td align=center></td>
                <td align=center></td>
                <td align="center"></td>
                <td align="right"></td>
            </tr>
            <tr class="container" align=center bgcolor=#FFFFFF>
                <td align=center>21.</td>
                <td align=left>&nbsp;&nbsp;เครื่องซักผ้า (เครื่อง)</td>
                <td align=center></td>
                <td align=center></td>
                <td align="center"></td>
                <td align="right"></td>
            </tr>



            <tr class="container" align=center bgcolor=#FFFFFF>
                <td colspan=6 align=left height="60px">&nbsp;&nbsp;**หมายเหตุ : </td>
            </tr>
        </table>
        <table border="0" align="center" style="border-style: none;">
            <tr>
                <td height="30px"></td>
            </tr>
            <tr>
                <td width="45%" align="center" style="font-size:22px;">
                    ผู้เช่าช่วงตรวจรับ</td>
                <td width="10%"></td>
                <td width="45%" align="center" style="font-size:22px;">
                    เจ้าหน้าที่ส่งมอบ</td>
            </tr>
            <tr>
                <td height="40px"></td>
            </tr>
            <tr>
                <td width="45%" align="center" style="font-size:22px;">({{ $rents->Cus_Name ?? '.....................................................'}})</td>
                <td width="10%"></td>
                <td width="45%" align="center" style="font-size:22px;">(.....................................................)
                </td>
            </tr>
            <tr>
                <td width="45%" align="center" style="font-size:22px;"> ........ / ........ / ........ </td>
                <td width="10%"></td>
                <td width="45%" align="center" style="font-size:22px;"> ........ / ........ / ........
                </td>
            </tr>

        </table>

    </div>
</body>
</html>