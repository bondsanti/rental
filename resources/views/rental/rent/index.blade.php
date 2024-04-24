
@extends('layouts.app')

@section('title', 'โครงการ')

@section('content')
<form method="post" action="" enctype="multipart/form-data">
    @csrf
    {{-- <input type="hidden" name="p1" value="{{ request()->input('p1') }}">
    <input type="hidden" name="c1" value="{{ request()->input('c1') }}"> --}}
    
    <div class="container-fluid">
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
                                    <label>โครงการ</label>
                                    <input type="text" readonly class="form-control" id="project" value="{{ $result->Project_Name }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>ห้องเลขที่</label>
                                    <input type="text" readonly class="form-control" id="roomNo" value="{{ $result->RoomNo }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>บ้านเลขที่</label>
                                    <input type="text" readonly class="form-control" id="homeNo" value="{{ $result->HomeNo }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>เจ้าของห้อง</label>
                                    <input type="text" readonly class="form-control" id="owner" value="{{ $result->Owner }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>เบอร์ติดต่อ</label>
                                    <input type="text" readonly class="form-control" id="phone" value="{{ $result->Phone }}">
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
                                    <input type="text" readonly class="form-control" value="{{ $result->Cus_Name }}">
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
        {{-- <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered" style="background: #cccccc;">
                    <thead>
                        <tr align="center">
                            <th scope="col" class="bg-success text-white">ค่าเช่า</th>
                            @for($i = 1; $i <= 12; $i++)
                            <th scope="col" class="bg-success text-white"></th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row" class="bg-white">ยอดเงิน</th>
                            @for($i = 1; $i <= 12; $i++)
                            <td class="bg-white"><input name="Due{{ $i }}_Amount" value="" class="form-control" style="width: 80px; text-align: right;"></td>
                            @endfor
                        </tr>
                        <tr>
                            <th scope="row" class="bg-white">ชำระวันที่</th>
                            <!-- Assuming you want to add date inputs here -->
                            @for($i = 1; $i <= 12; $i++)
                            <td class="bg-white"><input type="date" name="Due{{ $i }}_Date" value="" class="form-control"></td>
                            @endfor
                        </tr>
                        <tr>
                            <th scope="row" class="bg-white">หมายเหตุ</th>
                            @for($i = 1; $i <= 12; $i++)
                            <td class="bg-white"><textarea name="Remark{{ $i }}" class="form-control" style="width:80px; height:50px;"></textarea></td>
                            @endfor
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> --}}
        
    </div>
</form>

@endsection
@push('script')
<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd', // รูปแบบวันที่
            autoclose: true,
        });

        // $('#startdate').on('changeDate', function(e) {
        //     var selectedStartDate = e.date;
        //     $('#enddate').datepicker('setStartDate', selectedStartDate);
        // });
    });
    function goBack() {
        window.history.back();
    }
</script>
@endpush