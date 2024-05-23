@extends('layouts.app')

@section('title', 'รายงานชำระค่าการันตี')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">รายงานชำระค่าการันตี</h1>
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
                            <h3 class="card-title">ค้นหารายงานชำระค่าการันตี</h3>
                        </div>
                        <form action="{{ route('report.guarantee.search')}}" method="POST" id="contractSearch">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-1"> 
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>ประจำเดือน</label>
                                                <input class="form-control datepicker" name="monthly" id="monthly"
                                                type="text" value="" placeholder="ประจำเดือน"
                                                autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>โครงการ</label>
                                            <select name="pid" id="pid" class="form-control">
                                                <option value="All">โครงการ ทั้งหมด</option>
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->pid }}">{{ $project->Project_Name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ธนาคาร</label>
                                            <select name="bid" id="bid" class="form-control">
                                                <option value="0">ธนาคาร ทั้งหมด</option>
                                                @foreach ($activeBanks as $bank)
                                                    <option value="{{ $bank->id }}">{{ $bank->Code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-1"> 
                                    </div>

                                </div>
                                <div class="row" id="Payment">
                                    <div class="col-sm-1">
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label></label>
                                            <div class="text-bold text-right h6 mt-2 ml-3">
                                                สถานะการจ่ายเงิน
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label></label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                    <input type="checkbox" name="p" id="p" value="" checked>
                                                    </div>
                                                </div>
                                                <p class="form-control">จ่ายเงินแล้ว</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label></label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                    <input type="checkbox" name="np" id="np" value="" checked>
                                                    </div>
                                                </div>
                                                <p class="form-control">ยังไม่จ่ายเงิน</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label></label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                    <input type="checkbox" name="fp" id="fp" value="" checked>
                                                    </div>
                                                </div>
                                                <p class="form-control">ห้องสวัสดิการ</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                    </div>
                                </div>
                                <div class="box-footer text-center">
                                    <button type="submit" class="btn bg-gradient-success"><i class="fa fa-search"></i>
                                        ค้นหา</button>
                                    <a href="{{ route('report.guarantee') }}" type="button" class="btn bg-gradient-danger"><i
                                            class="fa fa-refresh"></i> เคลียร์</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-info btn-block">
                                <h4 class="mt-2"><i class="fa fa-exclamation"></i> กรุณา ค้นหา รายงานชำระค่าการันตี</h4>
                            </button>

                        </div>
                    </div>
                </div>
            </div>
            
        </div>

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

            $('#monthly').on('changeDate', function(e) {
                var selectedStartDate = e.date;
                $('#invoiceDate').datepicker('setStartDate', selectedStartDate);
            });

            $('#Payment').on('change', function(e) {
                updateStatus();
            });

            updateStatus();
        });

        function updateStatus(){
            let count = 1;
                var checkboxesInContainer = $('#Payment input[type="checkbox"]');
                checkboxesInContainer.each(function() {
                    if ($(this).is(':checked')) {
                        let value = $(this);
                        let id = value[0]['id'];
                        $('#'+id).val(count);
                    }else{
                        let value = $(this);
                        let id = value[0]['id'];
                        $('#'+id).val('');
                    }
                });
        }
    </script>
    <script>
        // JavaScript สำหรับกำหนดค่าให้กับ input ของวันที่
        // โดยใช้คำสั่ง new Date() เพื่อสร้างวัตถุ Date ที่เก็บวันที่และเวลาปัจจุบัน
        var today = new Date();

        // แปลงวัตถุ Date เป็นสตริงในรูปแบบที่ต้องการ (ในที่นี้เราใช้วิธีการกำหนดใน HTML)
        // โดยเราจะให้สตริงนี้เป็นค่าของ value ของ input
        var todayString = today.toISOString().split('T')[0]; // แบ่งส่วนของวันที่และเวลาและเลือกส่วนของวันที่เท่านั้น

        // กำหนดค่าของ input วันที่ใน DOM ด้วยการเลือกจาก id และกำหนดค่า value
        document.getElementById('monthly').value = todayString;
        // document.getElementById('enddate').value = todayString;
    </script>
@endpush
