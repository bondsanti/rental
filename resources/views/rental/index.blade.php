@extends('layouts.app')

@section('title', 'ห้องเช่า')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">ห้องเช่า</h1>
                </div>
                <div class="col-sm-5">
                </div>
                <div class="col-sm-1">
                    <a href="{{ route('room') }}" type="button" class="btn bg-gradient-primary"><i class="fa fa-plus"></i> เพิ่มห้องเช่า</a>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-outline card-info">
                            <h3 class="card-title">ค้นหา ห้อง</h3>
                        </div>
                        <form action="{{ route('rental.search') }}" method="post" id="searchForm">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>โครงการ</label>
                                            <select name="pid" id="pid" class="form-control">
                                                <option value="all">โครงการ ทั้งหมด</option>
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->pid }}">{{ $project->Project_Name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>สถานะห้องเช่า</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="all">สถานะห้องเช่า ทั้งหมด</option>
                                                @foreach ($status as $item)
                                                    <option value="{{ $item->status_room }}">{{ $item->status_room }} </option>
                                                @endforeach
                                                <option value="เช่าอยู่">เช่าอยู่</option>
                                                <option value="คืนห้อง">คืนห้อง</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>ประเภทห้องเช่า</label>
                                            @php
                                                $typerents = ['การันตี', 'การันตีรับร่วงหน้า', 'เบิกจ่ายล่วงหน้า', 'ฝากต่อหักภาษี', 'ฝากต่อไม่หักภาษี', 'ฝากเช่า', 'ติดต่อเจ้าของห้องไม่ได้'];
                                            @endphp
                                            <select name="typerent" id="typerent" class="form-control">
                                                <option value="all">ประเภท ทั้งหมด</option>
                                                @foreach ($typerents as $typerent)
                                                    <option value="{{$typerent}}">{{$typerent}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>เลือกประเภทวันที่</label>
                                            <select name="dateselect" id="dateselect" class="form-control">
                                                <option value="all">ทั้งหมด</option>
                                                <option value="transfer_date">วันรับห้อง</option>
                                                <option value="Guarantee_Startdate">วันเริ่มสัญญา</option>
                                                <option value="Guarantee_Enddate">วันสิ้นสุดสัญญา</option>
                                                <option value="Contract_Startdate">วันเริ่มเช่า</option>
                                                <option value="Payment_date">วันชำระเงินค่าเช่า</option>
                                                <option value="Cancle_Date">วันออก</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>วันที่เริ่มต้น</label>
                                            <input class="form-control datepicker" name="startdate" id="startdate"
                                            type="text" value="" placeholder="วันที่เริ่มต้น" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>วันที่สิ้นสุด</label>
                                            <input class="form-control datepicker" name="enddate" id="enddate"
                                            type="text" value="" placeholder="วันที่สิ้นสุด" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ห้องเลขที่</label>
                                                <input class="form-control" name="RoomNo" type="text" value=""
                                                    placeholder="ห้องเลขที่" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>บ้านเลขที่</label>
                                                <input class="form-control" name="HomeNo" type="text" value=""
                                                    placeholder="บ้านเลขที่" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ชื่อลูกค้า</label>
                                                <input class="form-control" name="Owner" type="text" value=""
                                                    placeholder="ชื่อลูกค้า" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ชื่อคนเช่า</label>
                                                <input class="form-control" name="Customer" type="text" value=""
                                                    placeholder="ชื่อคนเช่า" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="box-footer text-center">
                                    <button type="submit" class="btn bg-gradient-success btn-search"><i
                                            class="fa fa-search"></i>
                                        ค้นหา</button>
                                    <a href="{{ route('rental') }}" type="button"
                                        class="btn bg-gradient-danger"><i class="fa fa-refresh"></i> เคลียร์</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-info btn-block">
                                <h4 class="mt-2"><i class="fa fa-exclamation"></i> กรุณา ค้นหา ห้องที่คุณต้องการ</h4>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
@endsection
@push('script')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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

            $('#startdate').on('changeDate', function(e) {
                var selectedStartDate = e.date;
                $('#enddate').datepicker('setStartDate', selectedStartDate);
            });


            $('body').on('click', '.btn-search', function() {

                $.post('../api/search-rental', function(data) {
                    console.log(data);
                });
            });
        });
    </script>
    <script>
        // JavaScript สำหรับกำหนดค่าให้กับ input ของวันที่
        // โดยใช้คำสั่ง new Date() เพื่อสร้างวัตถุ Date ที่เก็บวันที่และเวลาปัจจุบัน
        var today = new Date();

        // getFirstDayOfMonth
        const year = today.getFullYear();
        const month = today.getMonth() + 1; // Note: Month starts from 0
        const formattedMonth = month < 10 ? '0' + month : month; 
        // แปลงวัตถุ Date เป็นสตริงในรูปแบบที่ต้องการ (ในที่นี้เราใช้วิธีการกำหนดใน HTML)
        // โดยเราจะให้สตริงนี้เป็นค่าของ value ของ input
        var todayString = today.toISOString().split('T')[0]; // แบ่งส่วนของวันที่และเวลาและเลือกส่วนของวันที่เท่านั้น

        // กำหนดค่าของ input วันที่ใน DOM ด้วยการเลือกจาก id และกำหนดค่า value
        document.getElementById('startdate').value = `${year}-${formattedMonth}-01`;
        document.getElementById('enddate').value = todayString;
    </script>
@endpush
