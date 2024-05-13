
@extends('layouts.app')

@section('title', 'ค่าเช่า')

@section('content')
<form method="post" action="{{ route('rental.recordRent') }}" enctype="multipart/form-data">
    @csrf
    {{-- <input type="hidden" name="payment_id" value="{{ $result->payment_id }}">
    <input type="hidden" name="project_id" value="{{ $result->project_id }}">
    <input type="hidden" name="customer_id" value="{{ $result->customer_id }}">
    <input type="hidden" name="room_id" value="{{ $result->room_id }}">
    <input type="hidden" name="projectName" value="{{ $result->Project_Name }}">
    <input type="hidden" name="roomNo" value="{{ $result->RoomNo }}">
    <input type="hidden" name="owner" value="{{ $result->Owner }}"> --}}
    
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
                        <h3 class="card-title"><u>รายละเอียดห้อง</u></h3>
                    </div>
                    <div class="card-body"> 
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>โครงการ</label>
                                    <input type="text" readonly class="form-control" value="{{ $rent->Project_Name }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>ห้องเลขที่</label>
                                    <input type="text" readonly class="form-control"  value="{{ $rent->RoomNo }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>บ้านเลขที่</label>
                                    <input type="text" readonly class="form-control"  value="{{ $rent->HomeNo }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>เจ้าของห้อง</label>
                                    <input type="text" readonly class="form-control" value="{{ $rent->Owner }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>เบอร์ติดต่อ</label>
                                    <input type="text" readonly class="form-control" value="{{ $rent->Phone }}">
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

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-outline card-info">
                        <h3 class="card-title"><u>รายละเอียดห้อง</u></h3>
                    </div>
                    <div class="card-body">
                        @php
                            $sum_money = 0;
                            $sum = 0; 
                            $index = 0;
                        @endphp 
                        {{-- @while ($count > 0) --}}
                            @foreach ($history as $key => $item)
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th width="7.5%" class="text-center">ชื่อลูกค้า</th>
                                            <th colspan="3">
                                                {{ $item->Cus_Name }}
                                            </th>
                                            <th colspan="3" class="bg-green text-light text-center">
                                                วันทำสัญญา {{ $item->Contract_Startdate }} - {{ $item->Contract_Enddate }}
                                            </th>
                                            <th colspan="6" class="bg-light text-dark text-center">สถานะ : <span class="{{ $item->Contract_Status == 'ออก' ? 'text-danger' : 'text-green' }}">{{ $item->Contract_Status }}</span> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="width: 7.5%">วันที่ต้องชำระ</td>
                                            <td style="width: 7.5%">{{ $item->Due1_Date }}</td>
                                            <td style="width: 7.5%">{{ $item->Due2_Date }}</td>
                                            <td style="width: 7.5%">{{ $item->Due3_Date }}</td>
                                            <td style="width: 7.5%">{{ $item->Due4_Date }}</td>
                                            <td style="width: 7.5%">{{ $item->Due5_Date }}</td>
                                            <td style="width: 7.5%">{{ $item->Due6_Date }}</td>
                                            <td style="width: 7.5%">{{ $item->Due7_Date }}</td>
                                            <td style="width: 7.5%">{{ $item->Due8_Date }}</td>
                                            <td style="width: 7.5%">{{ $item->Due9_Date }}</td>
                                            <td style="width: 7.5%">{{ $item->Due10_Date }}</td>
                                            <td style="width: 7.5%">{{ $item->Due11_Date }}</td>
                                            <td style="width: 7.5%">{{ $item->Due12_Date }}</td>
                                        </tr>
                                        <tr>
                                            <td>จำนวนเงินที่ชำระ</td>
                                            <td>
                                                {{ number_format($item->Due1_Amount) }}
                                                @if ($item->Payment_Date1)
                                                    @php
                                                        $sum_money += (int)$item->Due1_Amount;
                                                        $sum++;
                                                    @endphp
                                                @endif
                                            </td>
                                            <td>
                                                {{ number_format($item->Due2_Amount) }}
                                                @if ($item->Payment_Date2)
                                                    @php
                                                        $sum_money += (int)$item->Due2_Amount;
                                                        $sum++;
                                                    @endphp
                                                @endif
                                            </td>
                                            <td>
                                                {{ number_format($item->Due3_Amount) }}
                                                @if ($item->Payment_Date3)
                                                    @php
                                                        $sum_money += (int)$item->Due3_Amount;
                                                        $sum++;
                                                    @endphp
                                                @endif  
                                            </td>
                                            <td>
                                                {{ number_format($item->Due4_Amount) }}
                                                @if ($item->Payment_Date4)
                                                    @php
                                                        $sum_money += (int)$item->Due4_Amount;
                                                        $sum++;
                                                    @endphp
                                                @endif
                                            </td>
                                            <td>
                                                {{ number_format($item->Due5_Amount) }}
                                                @if ($item->Payment_Date5)
                                                    @php
                                                        $sum_money += (int)$item->Due5_Amount;
                                                        $sum++;
                                                    @endphp
                                                @endif
                                            </td>
                                            <td>
                                                {{ number_format($item->Due6_Amount) }}
                                                @if ($item->Payment_Date6)
                                                    @php
                                                        $sum_money += (int)$item->Due6_Amount;
                                                        $sum++;
                                                    @endphp
                                                @endif
                                            </td>
                                            <td>
                                                {{ number_format($item->Due7_Amount) }}
                                                @if ($item->Payment_Date7)
                                                    @php
                                                        $sum_money += (int)$item->Due7_Amount;
                                                        $sum++;
                                                    @endphp
                                                @endif
                                            </td>
                                            <td>
                                                {{ number_format($item->Due8_Amount) }}
                                                @if ($item->Payment_Date8)
                                                    @php
                                                        $sum_money += (int)$item->Due8_Amount;
                                                        $sum++;
                                                    @endphp
                                                @endif
                                            </td>
                                            <td>
                                                {{ number_format($item->Due9_Amount) }}
                                                @if ($item->Payment_Date9)
                                                    @php
                                                        $sum_money += (int)$item->Due9_Amount;
                                                        $sum++;
                                                    @endphp
                                                @endif
                                            </td>
                                            <td>
                                                {{ number_format($item->Due10_Amount) }}
                                                @if ($item->Payment_Date10)
                                                    @php
                                                        $sum_money += (int)$item->Due10_Amount;
                                                        $sum++;
                                                    @endphp
                                                @endif
                                            </td>
                                            <td>
                                                {{ number_format($item->Due11_Amount) }}
                                                @if ($item->Payment_Date11)
                                                    @php
                                                        $sum_money += (int)$item->Due11_Amount;
                                                        $sum++;
                                                    @endphp
                                                @endif
                                            </td>
                                            <td>
                                                {{ number_format($item->Due12_Amount) }}
                                                @if ($item->Payment_Date12)
                                                    @php
                                                        $sum_money += (int)$item->Due12_Amount;
                                                        $sum++;
                                                    @endphp
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>วันที่ชำระ</td>
                                            <td>
                                                {{ $item->Payment_Date1 }}
                                                @if ($item->slip1)
                                                    <button type="button" class="btn btn-sm view-slip" data-id="{{ $item->id }}" data-src="{{ $item->slip1 }}" title="ดูสลิป">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    </button>
                                                @endif
                                            </td>
                                            <td>{{ $item->Payment_Date2 }}</td>
                                            <td>{{ $item->Payment_Date3 }}</td>
                                            <td>{{ $item->Payment_Date4 }}</td>
                                            <td>{{ $item->Payment_Date5 }}</td>
                                            <td>{{ $item->Payment_Date6 }}</td>
                                            <td>{{ $item->Payment_Date7 }}</td>
                                            <td>{{ $item->Payment_Date8 }}</td>
                                            <td>{{ $item->Payment_Date9 }}</td>
                                            <td>{{ $item->Payment_Date10 }}</td>
                                            <td>{{ $item->Payment_Date11 }}</td>
                                            <td>{{ $item->Payment_Date12 }}</td>
                                        </tr>
                                        <tr>
                                            <td>หมายเหตุ</td>
                                            <td>{{ $item->Remark1 }}</td>
                                            <td>{{ $item->Remark2 }}</td>
                                            <td>{{ $item->Remark3 }}</td>
                                            <td>{{ $item->Remark4 }}</td>
                                            <td>{{ $item->Remark5 }}</td>
                                            <td>{{ $item->Remark6 }}</td>
                                            <td>{{ $item->Remark7 }}</td>
                                            <td>{{ $item->Remark8 }}</td>
                                            <td>{{ $item->Remark9 }}</td>
                                            <td>{{ $item->Remark10 }}</td>
                                            <td>{{ $item->Remark11 }}</td>
                                            <td>{{ $item->Remark12 }}</td>
                                        </tr>
                                    </tbody>
                                    <!-- Remaining rows -->
                                </table>
                                <br>
                            @endforeach
                            <h5><b><u>สรุป </u></b> <span> : จำนวนเดือนที่เก็บค่าเช่าทั้งหมด </span>  <b><u>{{ $sum }}  เดือน</u></b><span> เป็นจำนวนเงิน  <b><u>{{ number_format($sum_money) }} บาท</u></b></span></h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-outline card-info">
                        <h3 class="card-title"><u>ประวัติการันตี</u></h3>
                    </div>
                    <div class="card-body">
                        @php
                            $sum_money = 0;
                            $sum = 0; 
                            $index = 0;
                        @endphp 
                        {{-- @while ($count > 0) --}}
                            {{-- @foreach ($quarantees as $key => $item) --}}
                        @for ($i = 1; $i <= $rows; $i++)
                            {{-- @for ($j = 0; $j < 12; $j++) --}}
                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th colspan="13"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr>
                                                <td style="width: 7.5%">วันที่ต้องชำระ</td>
                                                <td style="width: 7.5%">{{ $dueDate[$i][0] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $dueDate[$i][1] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $dueDate[$i][2] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $dueDate[$i][3] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $dueDate[$i][4] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $dueDate[$i][5] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $dueDate[$i][6] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $dueDate[$i][7] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $dueDate[$i][8] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $dueDate[$i][9] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $dueDate[$i][10] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $dueDate[$i][11] ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td>จำนวนเงินที่ชำระ</td>
                                                <td style="width: 7.5%">{{ $amountFix[$i][0] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $amountFix[$i][1] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $amountFix[$i][2] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $amountFix[$i][3] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $amountFix[$i][4] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $amountFix[$i][5] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $amountFix[$i][6] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $amountFix[$i][7] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $amountFix[$i][8] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $amountFix[$i][9] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $amountFix[$i][10] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $amountFix[$i][11] ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td>วันที่ชำระ</td>
                                                <td style="width: 7.5%">{{ $amount[$i][0] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $amount[$i][1] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $amount[$i][2] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $amount[$i][3] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $amount[$i][4] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $amount[$i][5] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $amount[$i][6] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $amount[$i][7] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $amount[$i][8] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $amount[$i][9] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $amount[$i][10] ?? '' }}</td>
                                                <td style="width: 7.5%">{{ $amount[$i][11] ?? '' }}</td>
                                            </tr>
                                    </tbody>
                                    <!-- Remaining rows -->
                                </table>
                                    {{-- @endfor --}}
                                <br>
                                @endfor
                                <br>
                            {{-- @endforeach --}}
                            <h5><b><u>สรุป </u></b> <span> : จำนวนเดือนที่เก็บค่าเช่าทั้งหมด </span>  <b><u>{{ $sum }}  เดือน</u></b><span> เป็นจำนวนเงิน  <b><u>{{ number_format($sum_money) }} บาท</u></b></span></h5>
                           
                        
                        
                    </div>
                </div>
            </div>
        </div>
        
        {{-- view modal --}}
        <div class="modal fade" id="modal-view-slip">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ดูข้อมูลสลิป</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="box-body text-center">
                            <img id="slip" src="" alt="sliper" class="img-fluid rounded"> 
                        </div>

                    </div>
                    <div class="modal-footer justify-contentend">
                        <button type="button" class="btn bg-gradient-danger" data-dismiss="modal">
                            <i class="fa fa-times"></i> ปิดหน้าต่าง</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
</form>

@endsection

@push('script')
<script>
    //View modal
    $('body').on('click', '.view-slip', function() {
        const id = $(this).data('id');
        const src = $(this).data('src');
        console.log(id,src);
        $('#slip').attr('src', '{{ asset('uploads/images_room/autumn-4581105_640.jpg') }}');
        // $('#slip').attr('src', '{{ asset("uploads/image_slip/") }}' + '/' + src);
        $('#modal-view-slip').modal('show');
        // $.get('../api/rental/detail/' + id, function(data) {
        //     console.log(data);
        // });
        });
    function goBack() {
        window.history.back();
    }
</script>
@endpush