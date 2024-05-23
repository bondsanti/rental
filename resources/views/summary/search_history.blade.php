@extends('layouts.app')

@section('title', 'รายงานชำระค่าเช่าและค่าการันตึ')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">รายงานชำระค่าเช่าและค่าการันตี </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-outline card-info">
                            <h3 class="card-title">ค้นหารายงานชำระค่าเช่าและค่าการันตี <span class="text-red">(*วันที่จ่ายค่าเช่า ค่าการันตี*)</span></h3>
                        </div>
                        <form action="{{ route('summary.history.search')}}" method="POST" id="contractSearch">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4"> 
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>วันที่</label>
                                                <input class="form-control datepicker" name="monthly" id="monthly"
                                                type="text" value="{{ $monthly ?? '' }}" placeholder="วันที่"
                                                autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="col-sm-4"> 
                                    </div>

                                </div>
                               
                                <div class="box-footer text-center">
                                    <button type="submit" class="btn bg-gradient-success"><i class="fa fa-search"></i>
                                        ค้นหา</button>
                                    <a href="{{ route('summary.history') }}" type="button" class="btn bg-gradient-danger"><i
                                            class="fa fa-refresh"></i> เคลียร์</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-info btn-block">
                                <h4 class="mt-2"><i class="fa fa-exclamation"></i> กรุณา ค้นหา รายงานชำระค่าเช่าและค่าการันตี</h4>
                            </button>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header card-outline card-info">
                                    <h3 class="card-title">ข้อมูลรายงานชำระค่าเช่าและค่าการันตี</b></h3>
        
                                </div>
                                <div class="card-body">
                                    <table id="table" class="table table-hover table-striped text-center ">
                                        <thead>
                                            <tr>
                                                <th class="h6 text-bold">No</th>
                                                <th class="h6 text-bold" width="10%">โครงการ</th>
                                                <th class="h6 text-bold">บ้านเลขที่</th>
                                                <th class="h6 text-bold">ห้องเลขที่</th>
                                                <th class="h6 text-bold">ค่าเช่า(เดือน)</th>
                                                <th class="h6 text-bold">ค่าเช่า(บาท)</th>
                                                <th class="h6 text-bold">ค่าการันตี(เดือน)</th>
                                                <th class="h6 text-bold">ค่าการันตี(บาท)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $sum_total_r = 0;
                                                $sum_total_q = 0;
                                            @endphp
                                            @foreach ($results as $item)
                                                @php
                                                    $sum_total_r += $item->total_r;
                                                    $sum_total_q += $item->total_q;
                                                @endphp
                                                <tr>
                                                        <td>
                                                            <div class="h6 text-bold">{{ $loop->index + 1 }}</div>
                                                        </td>
                                                        <td>
                                                            <div class="h6 text-bold">{{ $item->Project_Name }}</div>
                                                        </td>
                                                        <td>
                                                            <div class="h6 text-bold">{{ $item->HomeNo }}</div>
                                                        </td>
                                                        <td>
                                                            <div class="h6 text-bold">{{ $item->RoomNo }}</div>
                                                        </td>
                                                        <td>
                                                            <div class="h6 text-bold">{{ number_format($item->paid_r) }}</div>
                                                        </td>
                                                        <td>
                                                            <div class="h6 text-green text-bold">{{ number_format($item->total_r) }}</div>
                                                        </td>
                                                        <td>
                                                            <div class="h6 text-bold">{{ number_format($item->paid_q) }}</div>
                                                        </td>
                                                        <td>
                                                           <div class="h6 text-green text-bold">{{ number_format($item->total_q) }}</div>
                                                        </td>
                                                </tr>                                                
                                            @endforeach
                                            <tr class="bg-green">
                                                <td colspan="5">
                                                    <div colspan="6" class="h6 text-bold text-center">Total</div>
                                                </td>
                                                <td>
                                                    <div class="h6 text-bold">{{ number_format($sum_total_r) }}</div>
                                                </td>
                                                <td></td>
                                                <td><div class="h6 text-bold">{{ number_format($sum_total_q) }}</div></td>
                                            </tr>
                                        </tbody>
        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

    </section>
@endsection
@push('script')
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd', // รูปแบบวันที่
                autoclose: true,
            });

        });

    </script>
    <script>
        // JavaScript สำหรับกำหนดค่าให้กับ input ของวันที่
        // โดยใช้คำสั่ง new Date() เพื่อสร้างวัตถุ Date ที่เก็บวันที่และเวลาปัจจุบัน
        var today = new Date();

        // แปลงวัตถุ Date เป็นสตริงในรูปแบบที่ต้องการ (ในที่นี้เราใช้วิธีการกำหนดใน HTML)
        // โดยเราจะให้สตริงนี้เป็นค่าของ value ของ input
        var todayString = today.toISOString().split('T')[0]; // แบ่งส่วนของวันที่และเวลาและเลือกส่วนของวันที่เท่านั้น

        // กำหนดค่าของ input วันที่ใน DOM ด้วยการเลือกจาก id และกำหนดค่า value
        document.getElementById('startdate').value = todayString;
        document.getElementById('enddate').value = todayString;
    </script>
@endpush
