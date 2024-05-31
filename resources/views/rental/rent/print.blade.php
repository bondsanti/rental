<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>ใบเสร็จรับเงิน</title>
    @LaravelDompdfThaiFont
    <style>
        body{
            font-family: 'THSarabunNew';
            line-height: 100%;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <table class="table-borderless" width="98%">
                <tr style="font-size: 20px;"><td class="text-left"><div style="margin-left: 20px; font-weight: bold;">บริษัท วีบียอนด์ แมเนจเม้นท์ จำกัด</div></td></tr>
                <tr style="font-size: 16px;"><td class="text-left"><div style="margin-left: 20px;">เลขประจำตัวผู้เสียภาษี : 0105563072893</div></td></tr>
                <tr style="font-size: 16px;"><td class="text-left"><div style="margin-left: 20px;">เลขที่ 1 อาคารเอ็มไพร์ ทาวเวอร์ ชั้นที่ 24 ห้องเลขที่ 2403 ถนนสาทรใต้ แขวงยานนาวา เขตสาทร กรุงเทพมหานคร</div></td></tr>
                <tr style="font-size: 16px;"><td class="text-left"><div style="margin-left: 20px;">โทร : 02-006-8008 </div></td></tr>
                <tr style="font-size: 12px;"><td rowspan="5" align="right" valign="top"><img src="uploads/images/logo.png" width="150" style="margin-top: -75px; margin-right: 15px;"></td><td>	</td></tr>
            </table>   
        </div>
    </div>
    <div class="container-fluid">
        <hr>
    </div>
    <div class="container-fluid">
        <div class="row">
            <table class="table-borderless">
                <tr style="font-size: 12px;">
                    <td colspan="4" align="center" valign="top" style="font-size: 26px; font-weight: bold;">&nbsp;&nbsp;ใบเสร็จรับเงิน</td>
                </tr>
                <tr style="font-size: 18px;">
                    <td align="right" width="35">ชื่อ &nbsp;&nbsp;:</td>
                    <td align="left" width="auto">{{ $result->Cus_Name }} </td>
                    <td align="right" width="70" >เลขที่ : </td><td align="left" width="100" >{{ $REC }}</td>
                </tr>
                <tr style="font-size: 18px;">
                    <td align="right" width="35">ที่อยู่ &nbsp;&nbsp;:</td>
                    <td align="left" width="auto">โครงการ {{ $result->Project_Name }}&emsp; บ้านเลขที่ {{ $result->HomeNo }} &emsp;ห้องเลขที่ {{ $result->RoomNo }}&emsp;{{ $result->address_full }}</td>
                    <td align="right" width="70" >วันที่ : </td><td align="left" width="100" >{{ $Payment_Dates }}</td>
            </table>
        </div>
    
        <div class="table-responsive">
            <table class="table table-bordered mt-4">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">ลำดับที่</th>
                        <th class="text-center" colspan="4">รายการ</th>
                        <th class="text-center" colspan="2">จำนวนเงิน</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center"><br>1 <br><br><br><br></td>
                        <td colspan="4"><br>&emsp;- ค่าเช่าห้องประจำเดือน {{ $monthY }}<br><br><br><br></td>
                        <td class="text-center"  colspan="2"><br>{{ number_format($price,2) }}<br><br><br><br></td>
                    </tr>
                    <tr>
                        <td><td colspan="2" class="text-center"> {{ $convert_price ?? '' }} </td></td>
                        <td colspan="2" class="text-center">จำนวนเงิน &emsp;</td>
                        <td class="text-center" colspan="2">{{ number_format($price,2) }}</td>
                    </tr>
                    
                </tbody>
            </table>
            <table>
                <tr>
                    <td width="33" align="left" valign="top"><i class="far fa-square" style="font-size: 20px;"></i>&emsp;</td><td colspan="2">เงินสด จำนวนเงิน <span style="text-decoration:underline;"> _____________________ </span> บาท</td>
                </tr>
                <tr>
                    <td align="left" valign="top"><i class="far fa-check-square" style="font-size: 20px;"></i>&emsp;</td><td colspan="2">โอนเงินเข้าบัญชีกระแสรายวัน ธนาคารกสิกรไทย ชื่อบัญชี บจก.วีบียอนด์ แมเนจเม้นท์ <br> เลขที่บัญชี 069-8-38772-6</td>
                </tr>
                <tr>
                    <td align="center"></td><td width="290">&emsp;- จำนวนเงิน &nbsp; {{ number_format($price,2) }}  <span style="text-decoration:underline;"></span> &nbsp;  บาท </td><td>วันที่ : <span style="text-decoration:underline;">{{ $Payment_Dates }}</span></td>
                </tr>
                <tr>
                    <td align="center"></td><td>&emsp;- ผู้รับเงิน <span style="text-decoration:underline;"> _____________________ </span></td><td>วันที่ : <span style="text-decoration:underline;">{{ $Payment_Dates }}</span></td>
                </tr>
            </table>
            <table>
                <tr style="font-size:12px; color: red;">
                    <td><br>หมายเหตุ : ใบเสร็จรับเงินจะสมบูรณ์ต่อเมื่อมีลายเซ็นผู้มีอำนาจลงนามแทนบริษัท และในกรณีจ่ายด้วยการโอนใบเสร็จรับเงินจะสมบูรณ์ต่อเมื่อเงินเข้าบัญชีธนาคารได้แล้ว</td>
                </tr>
            </table>
        </div>
    </div>
    
    
</body>
</html>