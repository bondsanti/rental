<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Document</title>
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
                <tr style="font-size: 12px;"><td rowspan="5" align="left" valign="top"><img src="uploads/images/logo.png" width="150"></td><td>	</td></tr>
                <tr style="font-size: 20px;"><td class="text-right text-bold">บริษัท วีบียอนด์ แมเนจเม้นท์ จำกัด</td></tr>
                <tr style="font-size: 16px;"><td class="text-right">เลขที่ 1 อาคารเอ็มไพร์ ทาวเวอร์ ชั้นที่ 24 ห้องเลขที่ 2403 ถนนสาทรใต้ แขวงยานนาวา เขตสาทร กรุงเทพมหานคร</td></tr>
                <tr style="font-size: 16px;"><td class="text-right">เลขประจำตัวผู้เสียภาษี : 0105563072893	</td></tr>
                <tr style="font-size: 16px;"><td class="text-right">โทร : 02-006-8008 </td></tr>
            </table>
        </div>
    </div>
    <div class="container-fluid">
        <hr>
    </div>
    <div class="container-fluid">
        @php
            $unit = 1;
            $vat = 0;
        @endphp
        {{-- <div class="text-center mt-4 mb-4">ใบแจ้งหนี้</div> --}}
    
        <div class="row">
            {{-- <div class="col-md-6">
                <p class="font-weight-bold">ชื่อ : {{ $result->Cus_Name }}</p>
                <p>โครงการ {{ $result->Project_Name }} บ้านเลขที่ {{ $result->HomeNo }}  ห้องเลขที่ {{ $result->RoomNo }} </p>
                <p>ที่อยู่ : {{ $result->address_full }}</p>
            </div>
            <div class="col-md-6">
                <p>เลขที่ :</p>
                <p>วันที่ :</p>
            </div> --}}
            <table class="table-borderless">
                <tr style="font-size: 12px;">
                    <td colspan="4" align="center" valign="top" style="font-size: 26px;">&nbsp;&nbsp;ใบแจ้งหนี้</td>
                </tr>
                <tr style="font-size: 18px;">
                    <td align="right" width="35">ชื่อ &nbsp;&nbsp;:</td>
                    <td align="left" width="auto">{{ $result->Cus_Name }} </td>
                    <td align="right" width="70" >เลขที่ :</td><td align="left" width="100" >
                    </td>
                </tr>
                <tr style="font-size: 18px;">
                    <td align="right" width="35">ที่อยู่ &nbsp;&nbsp;:</td>
                    <td align="left" width="auto">โครงการ {{ $result->Project_Name }}&emsp; บ้านเลขที่ {{ $result->HomeNo }} &emsp;ห้องเลขที่ {{ $result->RoomNo }}&emsp;{{ $result->address_full }}</td>
                    <td align="right" width="70" >วันที่ :</td><td align="left" width="100" >
            </table>
        </div>
    
        <div class="table-responsive">
            <table class="table table-bordered mt-4">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">ลำดับ<br>Item</th>
                        <th class="text-center" colspan="5">รายการ<br>Description</th>
                        <th class="text-center">จำนวนหน่วย<br>Qty</th>
                        <th class="text-center">ราคาต่อหน่วย<br>Unit Price</th>
                        <th class="text-center">จำนวนเงิน<br>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">1</td>
                        <td colspan="5">- ค่าเช่าห้องประจำเดือน {{ $monthY }}</td>
                        <td class="text-center"></td>
                        <td class="text-center">{{ number_format($result->price,2)}} </td>
                        <td class="text-right">{{ number_format($unit*$result->price,2) }}</td>
                    </tr>
                    <!-- Additional rows here -->
                    <tr style="font-size: 10px;" >
	
                        <td colspan="7" >
                            <table class="table-borderless">
                                <tr><td  align="left" style="font-size: 10px;" valign=top>&nbsp;หมายเหตุ : 1. กรุณาโอนเงินเข้าบัญชีกระแสรายวัน "บริษัท วีบียอนด์ แมเนจเม้นท์ จำกัด"  ธนาคารกสิกรไทย เลขที่บัญชี 069-8-38772-6
                                    <br>&emsp;&emsp;&emsp;&emsp;&emsp;และนำสลิปโอนเงิน แจ้งที่สำนักงานขาย หรือ ส่งเข้ามาที่ Line
                                    <br>&emsp;&emsp;&emsp;&emsp;&emsp;2. กรุณาชำระ ก่อนวันที่ 5 เพื่อหลีกเลี่ยงค่าปรับล่าช้าตามระบบอัตโนมัติ</td>
                                    <td align=center>LINE QR CODE <br><img src='uploads/images/IDline-rental.jpg' width=80></td>  
                                </tr>
                            </table>
                        </td>
                        <td  align="right" style="font-size: 14px;">รวมเงิน <br>ภาษีหัก ณ ที่จ่าย <br>จำนวนเงินทั้งสิ้น&nbsp;</td>
                        <td  align="right" style="font-size: 14px;">&emsp;<br>&emsp;<br>&emsp;</td>
                    </tr>
                </tbody>
            </table>
        </div>
    
    
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="text-right">
                    <p class="font-weight-bold  mr-5">ลงชื่อ _________________________________ </p>
                    <p class="font-weight-bold" style="margin-right: 100px;">( แผนกบัญชี )</p>
                </div>
            </div>
        </div>
    </div>
    
    
</body>
</html>