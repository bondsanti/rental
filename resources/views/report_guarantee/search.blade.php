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
                                                type="text" value="{{ $month ?? ''}}" placeholder="ประจำเดือน"
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
                                                    <option value="{{ $project->pid }}" {{ $project->pid == $pid ? 'selected' : ''}}>{{ $project->Project_Name }}</option>
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
                                                    <option value="{{ $bank->id }}" {{ $bank->id == $bid ? 'selected' : ''}}>{{ $bank->Code }}</option>
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
                                                <p class="form-control">จ่ายเงินล่วงหน้า</p>
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

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header card-outline card-info">
                                    <h3 class="card-title">ข้อมูลรายงานชำระค่าการันตี</b></h3>
        
                                </div>
                                <div class="card-body">
                                    <table id="table" class="table table-hover table-striped text-center ">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th width="10%">โครงการ</th>
                                                <th>ห้องเลขที่</th>
                                                <th>ชื่อลูกค้า</th>
                                                <th>เริ่มต้นสัญญา</th>
                                                <th>สิ้นสุดสัญญา</th>
                                                <th>ธนาคาร</th>
                                                <th>เลขบัญชีโอนการันตี</th>
                                                <th>เลขบัญชีเงินกู้ 1</th>
                                                <th>เลขบัญชีเงินกู้ 2</th>
                                                <th>เลขบัญชีเงินกู้ 3</th>
                                                <th>ค่างวด</th>
                                                <th>สถานะการจ่าย</th>
                                                <th width="8%">วันที่จ่าย</th>
                                                <th width="5%">เงินที่จ่าย</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $sumMoney = 0;
                                            @endphp
                                            @foreach ($quarantees as $item)
                                                <tr>
                                                    @if ($item->amount_fix > $item->due_date_amount)
                                                        <td rowspan="2">
                                                            <div class="h6">{{ $loop->index + 1 }}</div>
                                                        </td>
                                                        <td rowspan="2">
                                                            <div class="h6">{{ $item->Project_Name }}</div>
                                                        </td>
                                                        <td rowspan="2">
                                                            <div class="h6">{{ $item->RoomNo }}</div>
                                                        </td>
                                                        <td rowspan="2">
                                                            <div class="h6">{{ $item->name }}</div>
                                                        </td>
                                                        <td rowspan="2">
                                                            <div class="h6">{{ $item->gauranteestart }}</div>
                                                        </td>
                                                        <td rowspan="2">
                                                            <div class="h6">{{ $item->gauranteeend }}</div>
                                                        </td>
                                                        <td rowspan="2">
                                                            <div class="h6">{{ $item->bank_name }}</div>
                                                        </td>
                                                        <td>
                                                            @if ($item->bank_acc_quarantee == '' || $item->bank_acc_quarantee == NULL)
                                                                <div class="h6">
                                                                    <a href="#">เพิ่ม</a>
                                                                    {{-- <button type="button" class="btn bg-gradient-success view-add" data-pid="{{ $item->pid }}" title="เพิ่ม">
                                                                        เพิ่ม <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                                    </button> --}}
                                                                </div>
                                                            @else 
                                                                <div class="h6">
                                                                    <a href="#">แก้ไข</a>
                                                                    {{-- <button type="button" class="btn bg-gradient-warning view-edit" data-pid="{{ $item->pid }}" data-bank="{{ $item->bank_name }}" data-bacc="{{ $item->bank_acc_quarantee }}" title="แก้ไข">
                                                                        แก้ไข <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                                                    </button> --}}
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td rowspan="2">
                                                            <div class="h6">
                                                                {{ $item->loan_account_number1 ?? ''  }}
                                                            </div>
                                                        </td>
                                                        <td rowspan="2">
                                                            <div class="h6">{{ $item->loan_account_number2 ?? '' }}</div>
                                                        </td>
                                                        <td rowspan="2">
                                                            <div class="h6">{{ $item->loan_account_number3 ?? '' }}</div>
                                                        </td>
                                                        <td>
                                                            <div class="text-bold h6 ">{{ number_format($item->amount_fix - $item->due_date_amount) }}</div>
                                                        </td>
                                                        <td>
                                                            <div class="text-bold h6 ">จ่ายล่วงหน้า</div>
                                                        </td>
                                                        <td>
                                                            <div class="h6"><input type="text" value="{{ $item->date_new }}" disabled></div>
                                                        </td>
                                                        <td>
                                                            <div class="h6"><input type="text" value="{{ $item->amount_fix - $item->due_date_amount }}" disabled></div>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <div class="h6">{{ $loop->index + 1 }}</div>
                                                        </td>
                                                        <td>
                                                            <div class="h6">{{ $item->Project_Name }}</div>
                                                        </td>
                                                        <td>
                                                            <div class="h6">{{ $item->RoomNo }}</div>
                                                        </td>
                                                        <td>
                                                            <div class="h6">{{ $item->name }}</div>
                                                        </td>
                                                        <td>
                                                            <div class="h6">{{ $item->gauranteestart }}</div>
                                                        </td>
                                                        <td>
                                                            <div class="h6">{{ $item->gauranteeend }}</div>
                                                        </td>
                                                        <td>
                                                            <div class="h6">{{ $item->bank_name }}</div>
                                                        </td>
                                                        <td>
                                                            <div class="h6">
                                                                {{ $item->bank_acc_quarantee ?? '' }}
                                                                @if ($item->bank_acc_quarantee == '' || $item->bank_acc_quarantee == NULL)
                                                                    <div class="h6">
                                                                        {{-- <a href="#">เพิ่ม</a> --}}
                                                                        <button type="button" class="btn bg-gradient-success view-add" data-pid="{{ $item->pid }}" title="เพิ่ม">
                                                                            เพิ่ม <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                                        </button>
                                                                    </div>
                                                                @else 
                                                                    <div class="h6">
                                                                        {{-- <a href="#">แก้ไข</a> --}}
                                                                        <button type="button" class="btn bg-gradient-warning view-edit" data-pid="{{ $item->pid }}" data-bank="{{ $item->bank_name }}" data-bacc="{{ $item->bank_acc_quarantee }}" title="แก้ไข">
                                                                            แก้ไข <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                                                        </button>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="h6">
                                                                {{ $item->loan_account_number1 ?? ''  }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="h6">{{ $item->loan_account_number2 ?? '' }}</div>
                                                        </td>
                                                        <td>
                                                            <div class="h6">{{ $item->loan_account_number3 ?? '' }}</div>
                                                        </td>
                                                    @endif
                                                    <td>
                                                        <div class="text-bold h6 ">{{ number_format($item->due_date_amount) }}</div>
                                                    </td>
                                                    <td>
                                                        @if (($item->amount != '0') && ($item->amount != ''))
                                                            <div class="text-bold h6 text-green">จ่ายแล้ว</div>
                                                        @elseif($item->amount == '0')
                                                            <div class="text-bold h6 text-orange">จ่ายล่วงหน้า</div>
                                                        @else
                                                            <div class="text-bold h6 text-red">ยังไม่จ่าย</div>
                                                        @endif
                                                    </td>
                                                    <form action="{{ route('report.guarantee.saveData') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" value="{{ $item->id }}" name="id" id="id">
                                                        <input type="hidden" value="{{ $item->pid }}" name="pid" id="pid">
                                                        <input type="hidden" value="{{ $item->create_date }}" name="create_date" id="create_date">
                                                        <input type="hidden" value="{{ $item->due_date_amount }}" name="amount_check" id="amount_check">
                                                        <input type="hidden" value="{{ $item->gauranteeamount }}" name="gauranteeamount" id="gauranteeamount">
                                                        <input type="hidden" value="{{ $item->due_date }}" name="due_date" id="due_date">
                                                        <input type="hidden" value="{{ $month }}" name="month" id="month">
                                                        <input type="hidden" value="0" name="sum_Money" id="sum_Money">
                                                    <td>
                                                        @if ($item->amount == '0')
                                                            <input class="form-control" type="text"  name="date_payments" value="{{ $item->payment_date }}" disabled>
                                                        @else
                                                            <input class="form-control datepicker" type="text" name="date_payments" value="{{ $item->payment_date == '0000-00-00' ? '' : $item->payment_date }}" autocomplete="off" required>
                                                        @endif
                                                        
                                                    </td>
                                                    {{-- <td> --}}
                                                    @if ($item->amount == '0')
                                                        <td><input class="form-control" type="text" name="amounts" id="" value="{{ $item->due_date_amount }}" disabled ></td>
                                                        <td><button href="" class="btn btn-secondary" style="cursor: not-allowed" disabled><i class="fa fa-save" aria-hidden="true" ></i></a></td>
                                                        {{-- <td><a href="" class="btn btn-secondary" style="cursor: not-allowed" disabled><i class="fa fa-save" aria-hidden="true" ></i></a></td> --}}
                                                    @else
                                                        <td><input class="form-control" type="text" name="amounts"  value="{{ $item->amount }}" required></td>
                                                        <td><button type="submit" class="btn bg-gradient-warning save" id="saveData"><i class="fa fa-save" aria-hidden="true"></i></button></td>
                                                        {{-- <td> <a href="" class="btn btn-success"><i class="fa fa-save" aria-hidden="true"></i></a></td> --}}
                                                    @endif
                                                        
                                                    </form>
                                                    
                                                </tr>
                                                @php
                                                    $sumMoney += $item->due_date_amount;
                                                @endphp
                                                
                                            @endforeach

                                            <tr class="bg-green">
                                                <td colspan="6" class="h6 text-bold text-center">Total</td>
                                                <td colspan="5"></td>
                                                <td ><div class="h6 text-bold">{{ number_format($sumMoney) }}</div></td>
                                                <td colspan="4"></td>
                                            </tr>
                                        </tbody>
        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modal-add-bank">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><span class="text-red">*</span> กรุณาเลือกธนาคาร และระบุหมายเลขบัญชีธนาคาร</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeAdd">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="addForm" name="addForm" class="form-horizontal" enctype="multipart/form-data">
                                    <input type="hidden" name="project_id" id="project_id">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="box-body">
                                            <div class="form-group">
                                                {{-- <div class="col-md-4"></div> --}}
                                                <div class="col-md-12">
                                                    <label>ธนาคาร</label>
                                                    <select name="bankId" id="bankId" class="form-control">
                                                        <option value="0">ธนาคาร ทั้งหมด</option>
                                                        @foreach ($activeBanks as $bank)
                                                            <option value="{{ $bank->id }}" >{{ $bank->Code }}</option>
                                                        @endforeach
                                                    </select>
                                                    <p class="text-danger mt-1 name_err"></p>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="type" class="col-form-label">หมายเลขบัญชี</label>
                                                    <input type="text" class="form-control" name="code_bank" id="code_bank">
                                                    <p class="text-danger mt-1 code_err"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn bg-gradient-danger" data-dismiss="modal" id="btnCloseAdd"><i
                                                class="fa fa-times"></i> ยกเลิก</button>
                                        <button type="button" class="btn bg-gradient-success" id="addData" value="update"><i
                                                class="fa fa-save"></i> อัพเดท</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>

                    <div class="modal fade" id="modal-edit-bank">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><span class="text-red">*</span> กรุณาเลือกธนาคาร และระบุหมายเลขบัญชีธนาคาร</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeAdd">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="addForm" name="addForm" class="form-horizontal" enctype="multipart/form-data">
                                    <input type="hidden" name="project_id" id="Eproject_id">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="box-body">
                                            <div class="form-group">
                                                {{-- <div class="col-md-4"></div> --}}
                                                <div class="col-md-12">
                                                    <label>ธนาคาร</label>
                                                    <select name="bankId" id="EbankId" class="form-control">
                                                        <option value="0">ธนาคาร ทั้งหมด</option>
                                                        @foreach ($quarantees as $item)
                                                            @foreach ($activeBanks as $bank)
                                                                <option value="{{ $bank->id }}" {{ $bank->Code == $item->bank_name ? 'selected' : '' }}>{{ $bank->Code }}</option>
                                                            @endforeach
                                                        @endforeach
                                                    </select>
                                                    <p class="text-danger mt-1 name_err"></p>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="type" class="col-form-label">หมายเลขบัญชี</label>
                                                    <input type="text" class="form-control" name="code_bank" id="Ecode_bank" value="">
                                                    <p class="text-danger mt-1 code_err"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn bg-gradient-danger" data-dismiss="modal" id="btnCloseAdd"><i
                                                class="fa fa-times"></i> ยกเลิก</button>
                                        <button type="button" class="btn bg-gradient-success" id="editData" value="update"><i
                                                class="fa fa-save"></i> อัพเดท</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
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

            $('#closeAdd').click(function() {
                $('#addForm').trigger("reset");
                $('#modal-add-bank').modal('hide');
                $(".name_err").html('');
                $(".code_err").html('');
                // $('#addData').html('');
            });

            $('#btnCloseAdd').click(function() {
                $('#addForm').trigger("reset");
                $('#modal-add-bank').modal('hide');
                $(".name_err").html('');
                $(".code_err").html('');
                // $('#addData').html('');
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
        //modal add
        $('body').on('click', '.view-add', function() {
            const pid = $(this).data('pid'); 
            // console.log(pid);
            $('#project_id').val(pid);
            $('#modal-add-bank').modal('show');
        });

        $('#addData').click(function(e) {
            e.preventDefault();
            const pid = $("#project_id").val();
            const bankId = $("#bankId").val();
            const bankName = $("#code_bank").val();
            console.log(pid);
            if(bankId == '0' && !bankName){
                $(".name_err").html('กรุณาเลือกธนาคาร');
                $(".code_err").html('กรุณาเลือกกรอกหมายเลขบัญชี');
            }else if(bankId == '0' && bankName){
                $(".name_err").html('กรุณาเลือกธนาคาร');
                $(".code_err").html('');
            }
            else if(bankId != '0' && !bankName){
                $(".name_err").html('');
                $(".code_err").html('กรุณาเลือกกรอกหมายเลขบัญชี');
            }
            else{
                $(".name_err").html('');
                $(".code_err").html('');
                $(this).html('รอสักครู่..');
                const formData = new FormData($('#addForm')[0]);
                
                $.ajax({
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: "../../api/report/guarantee/updateBank/" + pid + "/" + bankId + "/" + bankName,
                        type: "POST",
                        dataType: 'json',

                        success: function(data) {
                            console.log(data);
                            if (data.success = true) {

                                if ($.isEmptyObject(data.error)) {
                                    Swal.fire({

                                        icon: 'success',
                                        title: data.message,
                                        showConfirmButton: true,
                                        timer: 2500
                                    });
                                    $('#modal-add-bank').trigger("reset");
                                    $('#modal-add-bank').modal('hide');
                                    setTimeout(function() {
                                        // location.href = '{{ url('report/guarantee') }}';
                                        location.reload();
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
                                $('#addForm').trigger("reset");
                            }


                        },

                    });
                
                console.log(formData);
            }

        });

        //modal edit
        $('body').on('click', '.view-edit', function() {
            const pid = $(this).data('pid');
            const bacc = $(this).data('bacc');
            
            console.log(pid);
            $('#Eproject_id').val(pid);
            $('#Ecode_bank').val(bacc);
            $('#modal-edit-bank').modal('show');
           
        });

        // save data edit
        $('#editData').click(function(e) {
            e.preventDefault();
            const pid = $("#Eproject_id").val();
            const bankId = $("#EbankId").val();
            const bankName = $("#Ecode_bank").val();
            console.log(pid,bankId,bankName);
            if(bankId == '0' && !bankName){
                $(".name_err").html('กรุณาเลือกธนาคาร');
                $(".code_err").html('กรุณาเลือกกรอกหมายเลขบัญชี');
            }else if(bankId == '0' && bankName){
                $(".name_err").html('กรุณาเลือกธนาคาร');
                $(".code_err").html('');
            }
            else if(bankId != '0' && !bankName){
                $(".name_err").html('');
                $(".code_err").html('กรุณาเลือกกรอกหมายเลขบัญชี');
            }
            else{
                $(".name_err").html('');
                $(".code_err").html('');
                $(this).html('รอสักครู่..');
                const formData = new FormData($('#addForm')[0]);
                
                $.ajax({
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: "../../api/report/guarantee/updateBank/" + pid + "/" + bankId + "/" + bankName,
                        type: "POST",
                        dataType: 'json',

                        success: function(data) {
                            console.log(data);
                            if (data.success = true) {

                                if ($.isEmptyObject(data.error)) {
                                    Swal.fire({

                                        icon: 'success',
                                        title: data.message,
                                        showConfirmButton: true,
                                        timer: 2500
                                    });
                                    $('#modal-edit-bank').trigger("reset");
                                    $('#modal-edit-bank').modal('hide');
                                    setTimeout(function() {
                                        // location.href = '{{ url('report/guarantee') }}';
                                        location.reload();
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
                                $('#addForm').trigger("reset");
                            }


                        },

                    });
                // console.log(formData);
            }

        });



        
    </script>
    <script>
        // JavaScript สำหรับกำหนดค่าให้กับ input ของวันที่
        // โดยใช้คำสั่ง new Date() เพื่อสร้างวัตถุ Date ที่เก็บวันที่และเวลาปัจจุบัน
        var today = new Date();

        // แปลงวัตถุ Date เป็นสตริงในรูปแบบที่ต้องการ (ในที่นี้เราใช้วิธีการกำหนดใน HTML)
        // โดยเราจะให้สตริงนี้เป็นค่าของ value ของ input
        var todayString = today.toISOString().split('T')[0]; // แบ่งส่วนของวันที่และเวลาและเลือกส่วนของวันที่เท่านั้น
        // monthly
        const monthly = $("#monthly");
        console.log(monthly);
        if(!monthly){
            // กำหนดค่าของ input วันที่ใน DOM ด้วยการเลือกจาก id และกำหนดค่า value
            document.getElementById('monthly').value = todayString;
            // document.getElementById('enddate').value = todayString;
        }
        
    </script>
@endpush
