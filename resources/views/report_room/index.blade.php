@extends('layouts.app')

@section('title', 'แดชบอร์ด')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        รายงานสรุปห้องเช่า

                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('main') }}">Home</a></li>
                        <li class="breadcrumb-item active">รายงานสรุปห้องเช่า</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <b> Rental Report : {{ now()->format('Y-m-d') }} </b>
                        </div>
                        <div class="crad-body">
                            <table id="#example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>โครงการ</th>
                                        <th>จำนวนห้องทั้งหมด</th>
                                        <th>จำนวนห้องที่มีคนเช่า</th>
                                        <th>พร้อมอยู่</th>
                                        <th>สวัสดิการ</th>
                                        <th>ออฟฟิศ</th>
                                        <th>จอง</th>
                                        <th>รอตรวจ</th>
                                        <th>รอคืน</th>
                                        <th>ไม่พร้อมอยู่</th>
                                    </tr>
                                </thead>
                                @foreach ($reports as $key => $data)
                                    <tbody>
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data->Project_Name }}</td>
                                            <td>{{ number_format($data->total) }}</td>
                                            <td>{{ number_format($data->rent) }}</td>
                                            <td>{{ number_format($data->readyroom) }}</td>
                                            <td>{{ number_format($data->welfareroom) }}</td>
                                            <td>{{ number_format($data->officeroom) }}</td>
                                            <td>{{ number_format($data->reserveroom) }}</td>
                                            <td>{{ number_format($data->examroom) }}</td>
                                            <td>{{ number_format($data->cleanroom) }}</td>
                                            <td>{{ number_format($data->noreadyroom) }}</td>
                                        </tr>
                                    </tbody>
                                @endforeach
                                @php
                                    $total = 0;
                                    $rent = 0;
                                    $readyroom = 0;
                                    $welfareroom = 0;
                                    $officeroom = 0;
                                    $reserveroom = 0;
                                    $examroom = 0;
                                    $cleanroom = 0;
                                    $noreadyroom = 0;

                                    foreach ($reports as $key => $value) {
                                        $total = $total + $value->total;
                                        $rent = $rent + $value->rent;
                                        $readyroom = $readyroom + $value->readyroom;
                                        $welfareroom = $welfareroom + $value->welfareroom;
                                        $officeroom = $officeroom + $value->officeroom;
                                        $reserveroom = $reserveroom + $value->reserveroom;
                                        $examroom = $examroom + $value->examroom;
                                        $cleanroom = $cleanroom + $value->cleanroom;
                                        $noreadyroom = $noreadyroom + $value->noreadyroom;
                                    }
                                @endphp
                                <tfoot>
                                    <tr bgcolor="#b5c8ff">
                                        <th colspan="2" >
                                            <div align="center">Total</div>
                                        </th>
                                        <td>{{ $total }}</td>
                                        <td>{{ $rent }}</td>
                                        <td>{{ $readyroom }}</td>
                                        <td>{{ $welfareroom }}</td>
                                        <td>{{ $officeroom }}</td>
                                        <td>{{ $reserveroom }}</td>
                                        <td>{{ $examroom }}</td>
                                        <td>{{ $cleanroom }}</td>
                                        <td>{{ $noreadyroom }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        จำนวนผู้เช่าทั้งหมด

                    </h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            {{-- สรุปจำนวนผู้เช่าทั้งหมด --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <b> Rental Report : {{ now()->format('Y-m-d') }} </b>
                        </div>
                        <div class="crad-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>โครงการ</th>
                                        <th>การันตี</th>
                                        <th>การันตี รับล่วงหน้า</th>
                                        <th>ฝากเช่า</th>
                                        <th>เบิกจ่ายล่วงหน้า</th>
                                        <th>จอง</th>
                                        <th>รวม</th>
                                    </tr>
                                </thead>
                                @foreach ($reports as $key => $data2)
                                    <tbody>
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data2->Project_Name }}</td>
                                            <td>{{ $data2->rent1 }}</td>
                                            <td>{{ $data2->rent2 }}</td>
                                            <td>{{ $data2->rent3 }}</td>
                                            <td>{{ $data2->rent4 }}</td>
                                            <td>{{ $data2->rent5 }}</td>
                                            <td>{{ $data2->rent + $data2->rent5 }}</td>
                                        </tr>
                                    </tbody>
                                @endforeach
                                @php
                                    $rent1 = 0;
                                    $rent2 = 0;
                                    $rent3 = 0;
                                    $rent4 = 0;
                                    $rent5 = 0;
                                    $rent0 = 0; // กำหนดค่าเริ่มต้นของ $rent0 เป็น 0

                                    foreach ($reports as $key => $value) {
                                        $rent1 += $value->rent1;
                                        $rent2 += $value->rent2;
                                        $rent3 += $value->rent3;
                                        $rent4 += $value->rent4;
                                        $rent5 += $value->rent5;
                                        $rent0 += $value->rent + $value->rent5; // เพิ่มค่า $value->rent + $value->rent5 ลงใน $rent0
                                    }
                                @endphp
                                <tfoot>
                                    <tr bgcolor="#b5c8ff">
                                        <th  colspan="2">
                                            <div align="center">Total</div>
                                        </th>
                                        <th>{{ $rent1 }}</th>
                                        <th>{{ $rent2 }}</th>
                                        <th>{{ $rent3 }}</th>
                                        <th>{{ $rent4 }}</th>
                                        <th>{{ $rent5 }}</th>
                                        <th>{{ $rent0 }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
