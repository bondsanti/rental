<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <td colspan="2">บริษัท วี บียอนด์ ดีเวลอปเม้นท์ จำกัด</td>
                        <td rowspan="4" align="right" valign="top"><img src="uploads/images/logo.png" width="200"></td>
                    </tr>
                    <tr>
                        <td>เลขประจำตัวผู้เสียภาษี : 0505557011329</td>
                    </tr>
                    <tr>
                        <td>สำนักงานสาขา: เลขที่ 1 อาคารเอ็มไพร์ ทาวเวอร์ ชั้นที่ 24</td>
                    </tr>
                    <tr>
                        <td>ห้องเลขที่ 2403 ถนนสาทรใต้ แขวงยานนาวา เขตสาทร กรุงเทพมหานคร</td>
                    </tr>
                    <tr>
                        <td>โทร: 020068008</td>
                    </tr>
                </table>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center">ใบเสร็จรับเงิน</h3>
                <table class="table table-bordered">
                    <tr>
                        <td>เลขที่:</td>
                        {{-- <td>{{ substr($year, -2).'/'.$Payment[1].'/' }}<?php printf("%04d", $idResult['bill_id']); ?></td> --}}
                        <td></td>
                        <td>วันที่:</td>
                        <td>{{ $result->Payment_Dates }}</td>
                    </tr>
                    <tr>
                        <td>ชื่อ:</td>
                        <td colspan="3">{{ $result->Cus_Name }}</td>
                    </tr>
                    <tr>
                        <td>ที่อยู่:</td>
                        <td colspan="3">โครงการ {{ $result->Project_Name }} บ้านเลขที่ {{ $result->HomeNo }} ห้องเลขที่ {{ $result->RoomNo }} {{ $result->address_full }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-center" style="width: 10%">ลำดับที่</th>
                            <th scope="col" colspan="4" class="text-center">รายการ</th>
                            <th scope="col" colspan="2" class="text-center">จำนวนเงิน</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="font-size: 14px;">
                            <td class="align-middle text-center" style="width: 10%"><br>1<br><br><br><br></td>
                            <td colspan="4" class="align-middle"><br>&emsp;- ค่าเช่าห้องประจำเดือน {{ $monthY }}<br><br><br><br></td>
                            <td class="align-middle text-center" colspan="2"><br> {{ number_format($result->Due_Amount,2) }} <br><br><br><br></td>
                        </tr>
                        <tr style="font-size: 14px;">
                            <td class="align-middle text-center" style="border-right: 0px;"></td>
                            <td colspan="2" class="align-middle" style="border-left: 0px;">&emsp;&emsp; 
                                <?php
                                    // $a = $Due_Amounts;
                                    // $x = new hk_baht($a);
                                    // echo $x->toBaht($a).'ถ้วน'; 
                                ?>&emsp;&emsp;
                            </td>
                            <td align="right" colspan="2" style="width: auto">จำนวนเงิน &emsp;</td>
                            <td class="text-center">{{ number_format($result->Due_Amount,2) }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="cash">
                            <label class="form-check-label" for="cash">
                                เงินสด จำนวนเงิน <span style="text-decoration:underline;">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</span> บาท
                            </label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="bankTransfer">
                            <label class="form-check-label" for="bankTransfer">
                                โอนเงินเข้าบัญชีเงินฝาก ธนาคารกสิกรไทย ชื่อบัญชี บจก.วี บียอนด์ ดีเวอลอปเม้นท์ เลขที่บัญชี 039-2-87055-5
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <p> - จำนวนเงิน <span style="text-decoration:underline;">{{ $result->Due_Amount ?? 0 }}</span> บาท</p>
                    </div>
                    <div class="col-md-4">
                        <p>วันที่ : <span style="text-decoration:underline;">{{ $result->Payment_Date }}</span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <p> - ผู้รับเงิน <span style="text-decoration:underline;">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</span></p>
                    </div>
                    <div class="col-md-4">
                        <p>วันที่ : <span style="text-decoration:underline;">{{ $result->Payment_Date }}</span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-danger" style="font-size:12px;"><br><br>หมายเหตุ : ใบเสร็จรับเงินจะสมบูรณ์ต่อเมื่อมีลายเซ็นผู้มีอำนาจลงนามแทนบริษัท และในกรณีจ่ายด้วยการโอนใบเสร็จรับเงินจะสมบูรณ์ต่อเมื่อเงินเข้าบัญชีธนาคารได้แล้ว</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>