
@extends('layouts.app')

@section('title', 'ค่าเช่า')

@section('content')
<form method="post" action="{{ route('rental.recordRent') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="paymentId" value="{{ $result->payment_id }}">
    <input type="hidden" name="project_id" value="{{ $result->project_id }}">
    <input type="hidden" name="customer_id" value="{{ $result->customer_id }}">
    <input type="hidden" name="roomId" value="{{ $result->room_id }}">
    <input type="hidden" name="projectName" value="{{ $result->Project_Name }}">
    <input type="hidden" name="roomNo" value="{{ $result->RoomNo }}">
    <input type="hidden" name="owner" value="{{ $result->Owner }}">
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <h1 class="mb-2">
                    <a href="javascript:void(0);" class="btn bg-gradient-warning" type="button"
                        onclick="goBack();">
                        <i class="fa-solid fa fa-reply"></i> กลับ </a>
                </h1>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-outline card-info">
                        <h3 class="card-title"><u>รายละเอียดเช่า</u></h3>
                    </div>
                    <div class="card-body"> 
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>โครงการ</label>
                                    <input type="text" name="projectName" readonly class="form-control" value="{{ $result->Project_Name }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>ห้องเลขที่</label>
                                    <input type="text" readonly class="form-control"  value="{{ $result->RoomNo }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>บ้านเลขที่</label>
                                    <input type="text" readonly class="form-control"  value="{{ $result->HomeNo }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>เจ้าของห้อง</label>
                                    <input type="text" readonly class="form-control" value="{{ $result->Owner }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>เบอร์ติดต่อ</label>
                                    <input type="text" readonly class="form-control" value="{{ $result->phone }}">
                                </div>
                            </div>
                            <div class="col-sm-4">

                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-outline card-info">
                        <h3 class="card-title"><u>รายละเอียดเช่า</u></h3>
                    </div>
                    <div class="card-body"> 
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>ลูกค้าเช่าซื้อ</label>
                                    <input type="text" name="cusName" readonly class="form-control" value="{{ $result->Cus_Name }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>เบอร์โทรศัพท์</label>
                                    <input type="text" readonly class="form-control" value="{{ $result->Phone }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>วันทำสัญญา</label>
                                    <input type="text" readonly class="form-control" value="{{ $result->Contract_Startdate }} - {{ $result->Contract_Enddate }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>ระยะเวลา</label>
                                    <input type="text" readonly class="form-control" value="{{ $result->Contract }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>ราคา</label>
                                    <input type="text" readonly class="form-control" value="{{ $result->Price }} บาท">
                                </div>
                            </div>
                            <div class="col-sm-4">

                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col" class="bg-success text-white">ค่าเช่า</th>
                                    @for ($i = 1; $i <= $result->Contract; $i++)
                                        <th scope="col" class="bg-success text-white">{{ $result->{"Due{$i}_Date"} }}</th>
                                        <input type="hidden" name="Due{{$i}}_Date" value="{{ $result->{"Due{$i}_Date"} }}" >
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>ยอดเงิน</td>
                                    @for ($i = 1; $i <= $result->Contract; $i++)
                                        <td><input name="Due{{ $i }}_Amount" value="{{ $result->{"Due{$i}_Amount"} }}" class="form-control"></td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td>วันที่ชำระ</td>
                                    @for ($i = 1; $i <= $result->Contract; $i++)
                                        <td><input type="text" name="Payment_Date{{ $i }}" value="{{ $result->{"Payment_Date{$i}"} }}" class="form-control datepicker" placeholder="yyyy-mm-dd"></td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td>หมายเหตุ</td>
                                    @for ($i = 1; $i <= $result->Contract; $i++)
                                        <td><textarea name="Remark{{ $i }}" class="form-control">{{ $result->{"Remark{$i}"} }}</textarea></td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td>สลิป</td>
                                    @for ($i = 1; $i <= $result->Contract; $i++)
                                        <td>
                                            @if ($result->{"slip{$i}"})
                                                @if ($result->{"status_approve{$i}"} == 1)
                                                    <button type="button" class="btn bg-gradient-info view-slip" data-id="{{ $result->id }}" data-src="{{ $result->{"slip{$i}"} }}" title="ดูสลิป">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </button>
                                                    <a href="{{ url('rental/download/' . $result->room_id . '/' .$result->customer_id. '/'. $result->{"Due{$i}_Date"} .'/'. $result->{"Payment_Date{$i}"}) }}" class="btn btn-primary">Print 
                                                        @if ($result->Contract < 12)
                                                            <i class="fa fa-print" aria-hidden="true"></i>
                                                        @endif
                                                    </a>    
                                                @elseif($result->{"status_approve{$i}"} == 2)
                                                    <input type="file" class="form-control" style="width:120px;" name="slips{{ $i }}">
                                                @else
                                                    {{-- check role if admin show modal approve --}}
                                                    {{-- modal approve for admin --}}
                                                    @if ($isRole->role_type=="SuperAdmin" || $isRole->role_type=="Account")
                                                        <button type="button" class="btn bg-gradient-danger view-approve" data-id="{{ $result->room_id }}" data-date="{{ $result->{"Due{$i}_Date"} }}" data-src="{{ $result->{"slip{$i}"} }}" data-index="{{ $i }}"  title="รออนุมัติ">
                                                            รออนุมัติ 
                                                            @if ($result->Contract < 12)
                                                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                            @endif
                                                        </button>
                                                    @else
                                                        {{-- check role if not admin show text --}}
                                                        <button type="button" class="btn bg-gradient-danger" title="รออนุมัติ">
                                                            รออนุมัติ 
                                                            @if ($result->Contract < 12)
                                                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                            @endif
                                                        </button>
                                                    @endif
                                                        
                                                @endif
                                            @else
                                                <input type="file" class="form-control" style="width:120px;" name="slips{{ $i }}">
                                            @endif
                                            
                                        </td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td>สลิป Express</td>
                                    @for ($i = 1; $i <= $result->Contract; $i++)
                                        <td>
                                            @if ($result->{"slip".(16 + $i)})
                                                @if ($result->{"status_approve".(16 + $i)} == 1)
                                                    <button type="button" class="btn bg-gradient-info view-slip" data-id="{{ $result->id }}" data-src="{{ $result->{"slip{16 + $i}"} }}" title="ดูสลิป">
                                                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                    </button>
                                                @elseif($result->{"status_approve".(16 + $i)} == 2)
                                                    <input type="file" class="form-control" style="width:120px;" name="slips{{ 16 + $i }}">
                                                @else
                                                    @if ($isRole->role_type=="SuperAdmin" || $isRole->role_type=="Account")
                                                        <button type="button" class="btn btn-sm bg-gradient-danger view-approve" data-id="{{ $result->room_id }}" data-date="{{ $result->{"Due{$i}_Date"} }}" data-src="{{ $result->{"slip".(16 + $i)} }}" data-index="{{ 16 + $i }}"  title="รออนุมัติ">
                                                            รออนุมัติ 
                                                            @if ($result->Contract < 12)
                                                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                            @endif
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-sm bg-gradient-danger" title="รออนุมัติ">
                                                            รออนุมัติ 
                                                            @if ($result->Contract < 12)
                                                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                            @endif
                                                        </button>
                                                    @endif  
                                                @endif
                                            @else
                                                <input type="file" class="form-control" style="width:120px;" name="slips{{ 16 + $i }}">
                                            @endif
                                           
                                        </td>
                                    @endfor
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col" class="bg-success text-white">{{ $result->Due1_Date }}</th>
                                    <th scope="col" class="bg-success text-white">เงินล่วงหน้า</th>
                                    <th scope="col" class="bg-success text-white">ค่าจอง</th>
                                    <th scope="col" class="bg-success text-white">เงินประกัน(2เดือน)</th>
                                    <th scope="col" class="bg-success text-white">เงิน Prorate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>จำนวนเงิน</td>
                                    <td><input type="text" class="form-control" name="Paymentbefore" value="{{ $result->Paymentbefore }}"></td>
                                    <td><input type="text" class="form-control" name="Deposit" value="{{ $result->Deposit }}"></td>
                                    <td><input type="text" class="form-control" name="Bail" value="{{ $result->Bail }}"></td>
                                    <td><input type="text" class="form-control" name="sum" value="{{ $result->Payment_Prorate ?? '0' }}"></td>
                                </tr>
                                <tr>
                                    <td>ชำระวันที่</td>
                                    <td>
                                        <input type="text" class="form-control datepicker" id="calendar_input26" name="Payment_before" value="{{ ($result->Payment_before == null || $result->Payment_before == '0000-00-00') ? '' : $result->Payment_before }}">
                                    </td>
                                    <td><input type="text" class="form-control datepicker" id="calendar_input27" name="Payment_reservation" value="{{ ($result->Payment_reservation == null || $result->Payment_reservation == '0000-00-00') ? '' : $result->Payment_reservation }}"></td>
                                    <td><input type="text" class="form-control datepicker" id="calendar_input28" name="Payment_guarantee" value="{{ ($result->Payment_guarantee == null || $result->Payment_guarantee == '0000-00-00') ? '' : $result->Payment_guarantee }}"></td>
                                    <td><input type="text" class="form-control datepicker" id="calendar_input28" name="Payment_Prorate" value="{{ ($result->Payment_Prorate == null || $result->Payment_Prorate == '0000-00-00') ? '' : $result->Payment_Prorate }}"></td>
                                </tr>
                                <tr>
                                    <td>หมายเหตุ</td>
                                    <td><textarea name="Remarkpay1" class="form-control" style="height: 50px;">{{ $result->Remarkpay1 }}</textarea></td>
                                    <td><textarea name="Remarkpay2" class="form-control" style="height: 50px;">{{ $result->Remarkpay2 }}</textarea></td>
                                    <td><textarea name="Remarkpay3" class="form-control" style="height: 50px;">{{ $result->Remarkpay3 }}</textarea></td>
                                    <td><textarea name="Remarkpay4" class="form-control" style="height: 50px;">{{ $result->Remarkpay4 }}</textarea></td>
                                </tr>
                                <tr>
                                    @php
                                        $currentDate = now()->format('Y-m-d');
                                    @endphp
                                    <td>สลิป</td>
                                    <td>
                                        @if ($result->slip13)
                                            @if ($result->status_approve13 == 1)
                                                <button type="button" class="btn bg-gradient-info view-slip" data-id="{{ $result->id }}" data-src="{{ $result->slip13 }}" title="ดูสลิป">
                                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                </button>
                                            @elseif($result->status_approve13 == 2)
                                                <input type="file" class="form-control" style="width:120px;" name="slips13">
                                            @else
                                                <button type="button" class="btn btn-sm bg-gradient-danger view-approve" data-id="{{ $result->room_id }}" data-date="{{ $currentDate }}" data-src="{{ $result->slip13 }}" data-index="13"  title="รออนุมัติ">
                                                    รออนุมัติ <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                </button>
                                            @endif
                                        @else
                                            <input type="file" class="form-control" style="width:120px;" name="slips13">
                                        @endif
                                    </td>
                                    <td>
                                        @if ($result->slip14)
                                            @if ($result->status_approve14 == 1)
                                                <button type="button" class="btn bg-gradient-info view-slip" data-id="{{ $result->id }}" data-src="{{ $result->slip14 }}" title="ดูสลิป">
                                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                </button>
                                            @elseif($result->status_approve14 == 2)
                                                <input type="file" class="form-control" style="width:120px;" name="slips14">
                                            @else
                                                <button type="button" class="btn btn-sm bg-gradient-danger view-approve" data-id="{{ $result->room_id }}" data-date="{{ $currentDate }}" data-src="{{ $result->slip14 }}" data-index="14"  title="รออนุมัติ">
                                                    รออนุมัติ <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                </button>
                                            @endif
                                        @else
                                            <input type="file" class="form-control" style="width:120px;" name="slips14">
                                        @endif
                                    </td>
                                    <td>
                                        @if ($result->slip15)
                                            @if ($result->status_approve15 == 1)
                                                <button type="button" class="btn bg-gradient-info view-slip" data-id="{{ $result->id }}" data-src="{{ $result->slip15 }}" title="ดูสลิป">
                                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                </button>
                                            @elseif($result->status_approve15 == 2)
                                                <input type="file" class="form-control" style="width:120px;" name="slips15">
                                            @else
                                                <button type="button" class="btn btn-sm bg-gradient-danger view-approve" data-id="{{ $result->room_id }}" data-date="{{ $currentDate }}" data-src="{{ $result->slip15 }}" data-index="15"  title="รออนุมัติ">
                                                    รออนุมัติ <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                </button>
                                            @endif
                                        @else
                                            <input type="file" class="form-control" style="width:120px;" name="slips15">
                                        @endif
                                    </td>
                                    <td>
                                        @if ($result->slip16)
                                            @if ($result->status_approve16 == 1)
                                                <button type="button" class="btn bg-gradient-info view-slip" data-id="{{ $result->id }}" data-src="{{ $result->slip16 }}" title="ดูสลิป">
                                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                </button>
                                            @elseif($result->status_approve16 == 2)
                                                <input type="file" class="form-control" style="width:120px;" name="slips16">
                                            @else
                                                <button type="button" class="btn btn-sm bg-gradient-danger view-approve" data-id="{{ $result->room_id }}" data-date="{{ $currentDate }}" data-src="{{ $result->slip16 }}" data-index="16"  title="รออนุมัติ">
                                                    รออนุมัติ <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                </button>
                                            @endif
                                        @else
                                            <input type="file" class="form-control" style="width:120px;" name="slips16">
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-lg btn-block">บันทึกข้อมูล</button>
            </div>
        </div>
        <div class="row">

        </div>

        {{-- view modal --}}
        <div class="modal fade" id="modal-view-slip">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ดูข้อมูลสลิป</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeSlip">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="box-body text-center">
                            <img id="slip" src="" alt="sliper" class="img-fluid rounded"> 
                        </div>

                    </div>
                    <div class="modal-footer justify-contentend">
                        <button type="button" class="btn bg-gradient-danger" data-dismiss="modal" id="closeSlip">
                            <i class="fa fa-times"></i> ปิดหน้าต่าง</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>


         {{-- status approve modal --}}
        <div class="modal fade" id="modal-status-approve">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">รออนุมัติ</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeApprove">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editForm" name="editForm" class="form-horizontal" enctype="multipart/form-data">
                        <input type="hidden" name="room_id" id="room_id">
                        <input type="hidden" name="payment_id" id="payment_id">
                        <input type="hidden" name="index" id="index">
                        {{-- <input type="hidden" name="user_id" id="user_id" value="{{ $dataLoginUser->id }}"> --}}
                        @csrf
                        <div class="modal-body">
                            <div class="box-body">
                                <div class="form-group">
                                    <div class="col-md-12">

                                        <label for="code" class="col-form-label">โครงการ</label>
                                        <input type="text" class="form-control" id="projectName" name="projectName"
                                            placeholder="" autocomplete="off" disabled>

                                        <label for="code" class="col-form-label">ห้องเลขที่</label>
                                        <input type="text" class="form-control" id="roomNo" name="roomNo"
                                            placeholder="" autocomplete="off" disabled>

                                        <label for="code" class="col-form-label">เจ้าของห้อง</label>
                                        <input type="text" class="form-control" id="owner" name="owner"
                                            placeholder="" autocomplete="off" disabled>

                                        <label for="code" class="col-form-label">ลูกค้าเช่าซื้อ</label>
                                        <input type="text" class="form-control" id="cus_name" name="cus_name"
                                            placeholder="" autocomplete="off" disabled>

                                        <label for="code" class="col-form-label">ค่าเช่าประจำเดือน</label>
                                        <input type="text" class="form-control" id="monthly" name="monthly"
                                            placeholder="" autocomplete="off" disabled>

                                        <div class="mt-3">
                                            <p class="text-bold">รูปสลิป <span id="slipName" name="slipName"></span></p>
                                            <img id="slip_img" src="" alt="sliper" class="img-fluid rounded">
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="type" class="col-form-label">ประเภทการอนุมัติ</label>
                                        <select class="form-control" id="role_approve" name="role_approve">
                                            <option value="">เลือก</option>
                                            <option value="1">อนุมัติ</option>
                                            <option value="2">ไม่อนุมัติ</option>
                                        </select>
                                        <p class="text-danger mt-1 name_edit_err"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn bg-gradient-danger" data-dismiss="modal" id="closeApprove"><i
                                    class="fa fa-times"></i> ยกเลิก</button>
                            <button type="button" class="btn bg-gradient-success" id="updatedata" value="update"><i
                                    class="fa fa-save"></i> อัพเดท</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        
    </div>
</form>

@endsection

@push('script')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd', // รูปแบบวันที่
            autoclose: true,
        });

        $('#closeApprove').click(function() {
            $('#editForm').trigger("reset");
            $('#modal-status-approve').modal('show');
        });

        $('#closeSlip').click(function() {
            $('#modal-view-slip').trigger("reset");
            $('#modal-view-slip').modal('show');
        });
    });
    function goBack() {
        window.history.back();
    }

     //View modal
     $('body').on('click', '.view-slip', function() {

        const id = $(this).data('id');
        const src = $(this).data('src');
        // console.log(id,src);
        // $('#slip').attr('src', '{{ asset('uploads/images_room/autumn-4581105_640.jpg') }}');
        $('#slip').attr('src', '{{ asset("uploads/image_slip/") }}' + '/' + src);
        $('#modal-view-slip').modal('show');
  
    });

    //modal approve
    $('body').on('click', '.view-approve', function() {

        const id = $(this).data('id');
        const date = $(this).data('date');
        const src = $(this).data('src');
        const index = $(this).data('index');
        let name = '';
        const d = new Date(date)
        if (index == 13) {
            name = 'เงินล่วงหน้า';
        }else if(index == 14){
            name = 'ค่าจอง';
        }else if(index == 15){
            name = 'เงินประกัน(2เดือน)';
        }else if(index == 16){
            name = 'เงิน Prorate';
        }else{
            name = index > 12 ? 'Express' : 'ค่าเช่า';
        }
        
        // console.log(name);
        let month_full = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
        const year = d.getFullYear()+543;;
        const month = month_full[d.getMonth()];
        const monthYear = month + ' ' + year;
        // console.log(monthYear);
        // console.log(index);
        $('#modal-status-approve').modal('show');
        $.get('../../api/rental/rent/preapprove/' + id, function(data) {
            // console.log(data.room_id);
             
            $('#payment_id').val(data.payment_id);
            $('#room_id').val(data.room_id);
            $('#projectName').val(data.Project_Name);
            $('#roomNo').val(data.RoomNo);
            $('#owner').val(data.Owner);
            $('#cus_name').val(data.Cus_Name);
            $('#monthly').val(monthYear);
            // $('#slip_img').attr('src', '{{ asset('uploads/images_room/autumn-4581105_640.jpg') }}');
            $('#slip_img').attr('src', '{{ asset("uploads/image_slip/") }}' + '/' + src);
            $('#index').val(index);
            $('#slipName').html(name);
        });
    });

    $('#updatedata').click(function(e) {
        e.preventDefault();
        // const approve = $("#role_approve").val();
        const status = $("#role_approve").val();
        const index = $("#index").val();
        const id = $("#payment_id").val();
        const room_id = $("#room_id").val();
        if(!status){
            $(".name_edit_err").html('กรุณาเลือกประเภทการอนุมัติ');
        }else{
            $(".name_edit_err").html('');
            $(this).html('รอสักครู่..');
            const formData = new FormData($('#editForm')[0]);
            
            $.ajax({
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: "../../api/rental/rent/approve/" + id + "/" + status + "/" + index,
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        if (data.success = true) {

                            if ($.isEmptyObject(data.error)) {
                                Swal.fire({

                                    icon: 'success',
                                    title: data.message,
                                    showConfirmButton: true,
                                    timer: 2500
                                });
                                $('#modal-status-approve').trigger("reset");
                                $('#modal-status-approve').modal('hide');
                                setTimeout(function() {
                                    location.href = '{{ url('rental/rent') }}' + '/' + room_id;
                                }, 1500);
                            } else {

                                $('#update').html('ลองอีกครั้ง');

                                Swal.fire({
                                    position: 'top-center',
                                    icon: 'error',
                                    title: 'ไม่สามารถบันทึกข้อมูลได้',
                                    html: `เนื่องจากกรอกข้อมูลไม่ครบถ้วน`,
                                    timer: 2500
                                });
                            }

                        } else {
                            Swal.fire({
                                position: 'top-center',
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                showConfirmButton: true,
                                timer: 2500
                            });
                            $('#editForm').trigger("reset");
                        }
                    },

                });
            
            // console.log(formData);
        }
        
    });
    function goBack() {
        window.history.back();
    }

   
</script>
@endpush