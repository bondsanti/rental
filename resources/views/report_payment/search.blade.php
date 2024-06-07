@extends('layouts.app')

@section('title', 'รายงานชำระค่าเช่า')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">รายงานชำระค่าเช่า</h1>
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
                            <h3 class="card-title">ค้นหารายงานชำระค่าเช่า</h3>
                        </div>
                        <form action="{{ route('report.payment.search')}}" method="POST" id="contractSearch">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>ประจำเดือน</label>
                                                <input class="form-control datepicker" name="monthly" id="monthly"
                                                type="text" value="{{ $monthly ?? '' }}" placeholder="ประจำเดือน"
                                                autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>วันในใบแจ้งหนี้</label>
                                            <input class="form-control datepicker" name="invoiceDate" id="invoiceDate"
                                                type="text" value="{{ $invoiceDate ?? '' }}" placeholder="วันในใบแจ้งหนี้"
                                                autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
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
                                                    <input type="checkbox" name="p" id="p" value="{{ $p ?? ''}}" {{ $p == 1 ? 'checked' : ''}}>
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
                                                    <input type="checkbox" name="np" id="np" value="{{ $np ?? ''}}" {{ $np == 1 ? 'checked' : ''}}>
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
                                                    <input type="checkbox" name="sp" id="sp" value="{{ $sp ?? ''}}" {{ $sp == 1 ? 'checked' : ''}}>
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
                                    <a href="{{ route('report.payment') }}" type="button" class="btn bg-gradient-danger"><i
                                            class="fa fa-refresh"></i> เคลียร์</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-info btn-block">
                                <h4 class="mt-2"><i class="fa fa-exclamation"></i> กรุณา ค้นหา รายงานชำระค่าเช่า</h4>
                            </button>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-outline card-info">
                            <h3 class="card-title">ข้อมูลชำระค่างวดห้องเช่า</b></h3>

                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-hover table-striped text-center ">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th width="10%">โครงการ</th>
                                        <th width="5%" >ห้องเลขที่</th>
                                        <th>เลขที่บ้าน</th>
                                        <th>ขื่อลูกค้า</th>
                                        <th width="10%">เบอร์โทร</th>
                                        <th>สถานะห้องเช่า</th>
                                        <th>เริ่มต้นสัญญา</th>
                                        <th>สิ้นสุดสัญญา</th>
                                        <th>สถานะ</th>
                                        <th>ค่างวด</th>
                                        <th>สถานะการจ่าย</th>
                                        <th>วันที่จ่าย</th>
                                        <th>จ่ายแล้ว</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($results as $item)
                                        <tr>
                                            <td>
                                                <div class="h6">{{ $loop->index + 1 }}</div>
                                            </td>
                                            <td>
                                                <div class="h6">{{ $item->project_name }}</div>
                                            </td>
                                            <td>
                                                <div class="h6">{{ $item->Roomno }}</div>
                                            </td>
                                            <td>
                                                <div class="h6">{{ $item->HomeNo }}</div>
                                            </td>
                                            <td>
                                                <div class="h6">{{ $item->cus_name }}</div>
                                            </td>
                                            <td>
                                                <div class="h6">{{ $item->Phone }}</div>
                                            </td>
                                            <td>
                                                <div class="h6 {{ $item->status_room === 'อยู่แล้ว' ? 'text-green' : ''}}">{{ $item->status_room }}</div>
                                            </td>
                                            <td>
                                                <div class="h6">
                                                    {{ $item->STATUS ?? '' }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="h6">
                                                    {{ $item->contract_enddate ?? '-'  }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="h6 {{ $item->Contract_Status === 'ออก' ? 'text-red' : ''}} {{ $item->Contract_Status === 'เช่าอยู่' ? 'text-green' : ''}} {{ $item->Contract_Status === 'ต่อสัญญา' ? 'text-orange' : ''}}">{{ $item->Contract_Status }}</div>
                                            </td>
                                            <td>
                                                <div class="h6">{{ number_format($item->price) }}</div>
                                            </td>
                                            <td>
                                                <div class="text-bold h6 {{ $item->paid ===  'จ่ายแล้ว' ? 'text-green' : ''}} {{ $item->paid === 'ห้องสวัสดิการ'  ? 'text-orange' : ''}} {{$item->paid ===  'ยังไม่จ่าย' ? 'text-red' : ''}}">{{ $item->paid === 'ห้องสวัสดิการ' ? 'จ่ายแล้ว' : $countPayment[$loop->index] }}</div>
                                            </td>
                                            <td>
                                                <div class="h6 {{ $item->date_paid != '-' ? 'text-green text-bold' : '' }}">{{ $item->date_paid }}</div>
                                            </td>
                                            <td>
                                                <div class="h6 {{ $item->total_paid != '0' ? 'text-green text-bold' : '' }}">{{ $item->total_paid }}</div>
                                            </td>
                                            @if ($isRole->role_type=="SuperAdmin" || $isRole->role_type=="Admin")
                                                <td>
                                                    @if ($item->paid ===  'ยังไม่จ่าย' && $monthly != '')
                                                        <a href="{{ url('report/payment/download/' . $item->rid . '/' . $item->cid. '/' . $monthly. '/'. $item->paid) }}" class="btn btn-warning"><i class="fa fa-print" aria-hidden="true"></i></a>
                                                    @elseif($item->paid ===  'จ่ายแล้ว')
                                                        <a href="{{ url('report/payment/download/' . $item->rid . '/' . $item->cid. '/' . $item->date_paid. '/'. $item->paid) }}" class="btn btn-success"><i class="fa fa-print" aria-hidden="true"></i></a>
                                                    @endif
                                                </td>
                                            @else
                                               <td></td>
                                            @endif
                                            
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@push('script')
    {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script> --}}
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

            $('#table').DataTable({
                'paging': false,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': false,
                'autoWidth': false,
                "responsive": true,
                "columnDefs": [
                        { "orderable": false, "targets": [0, 2, 3, 5, 10, 12, 13, 14] }
                    ]
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
        const monthly =  $('#monthly').val();
        const invoiceDate =  $('#invoiceDate').val();
        if (!monthly) {
            document.getElementById('monthly').value = todayString;
        }
        if (!invoiceDate) {
            document.getElementById('invoiceDate').value = todayString;
        }
        
    </script>
@endpush
