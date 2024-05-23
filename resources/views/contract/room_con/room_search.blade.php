@extends('layouts.app')

@section('title', 'สัญญาห้องเช่า')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">สัญญาห้องเช่า</h1>
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
                            <h3 class="card-title">ค้นหาสัญญาห้องเช่า</h3>
                        </div>
                        <form action="{{ route('contract.search') }}" method="POST" id="contractSearch">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>โครงการ</label>
                                            <select name="pid" id="pid" class="form-control">
                                                <option value="all">โครงการ ทั้งหมด</option>
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->pid }}">{{ $project->Project_Name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>วันที่</label>
                                                <select name="dateselect" id="dateselect" class="form-control">
                                                    <option value="Contract_Startdate">วันเริ่มทำสัญญา</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>วันที่เริ่มต้น</label>
                                            <input class="form-control datepicker" name="startdate" id="startdate"
                                                type="text" value="{{ $startdate ?? '' }}" placeholder="วันที่เริ่มต้น"
                                                autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>วันที่สิ้นสุด</label>
                                            <input class="form-control datepicker" name="enddate" id="enddate"
                                                type="text" value="{{ $enddate ?? '' }}" placeholder="วันที่สิ้นสุด"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>ห้องเลขที่</label>
                                            <input class="form-control" name="RoomNo" id="RoomNo" type="text" value=""
                                                placeholder="ห้องเลขที่" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>ชื่อลูกค้า</label>
                                            <input class="form-control" name="Owner" id="Owner" type="text" value=""
                                                placeholder="ชื่อลูกค้า" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>ชื่อคนเช่า</label>
                                            <input class="form-control" name="Customer" id="Customer" type="text" value=""
                                                placeholder="ชื่อคนเช่า" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer text-center">
                                    <button type="submit" class="btn bg-gradient-success"><i class="fa fa-search"></i>
                                        ค้นหา</button>
                                    <a href="{{ route('contract.room') }}" type="button" class="btn bg-gradient-danger"><i
                                            class="fa fa-refresh"></i> เคลียร์</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">จำนวน <b class="text-red">{{ $rentsCount ?? 0}}</b> สัญญาห้องเช่า</h3>
                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-hover table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>โครงการ</th>
                                        <th>ห้องเลขที่</th>
                                        <th>บ้านเลขที่</th>
                                        {{-- <th>Type</th>
                                        <th>Location</th>
                                        <th>ขนาด</th> --}}
                                        {{-- <th>บัญชีแสดงสัญญา</th> --}}
                                        {{-- <th>รหัสเครื่องวัดฯ</th> --}}
                                        <th>ลูกค้า</th>
                                        <th>โทร</th>
                                        {{-- <th>วันรับห้อง</th> --}}
                                        <th>วันสิ้นสุดการันตี</th>
                                        <th>ประเภทห้องเช่า</th>
                                        <th>Status</th>
                                        <th>ผู้เช่า</th>
                                        <th>โทร</th>
                                        <th>ค่าเช่า</th>
                                        <th>วันเริ่มเช่า</th>
                                        <th>วันสิ้นสุดสัญญา</th>
                                        {{-- <th>วันออก</th> --}}
                                        <th>สถานะการเช่า</th>
                                        {{-- <th>สัญญา</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @php
                                    $totalgarantee = 0;
                                    $totalgaranteebefore = 0;
                                    $totalpaidbefore = 0;
                                    $totalcontinvat = 0;
                                    $totalcontexvat = 0;
                                    $totalforrental = 0;
                                    $totalcantcontact = 0;
                                    $totalall = 0;
                                @endphp
                                <tbody>
                                    @foreach ($rents as $item)
                                    @php
                                        if ($item->Cus_price > 0) {
                                            $txtprice = $item->Cus_price;
                                        }else{
                                            $txtprice = $item->room_price;
                                        }
                                        if ($item->rental_status === 'การันตี') {
                                            $totalgarantee++;
                                        }elseif ($item->rental_status === 'การันตีรับล่วงหน้า') {
                                            $totalgaranteebefore++;
                                        }elseif ($item->rental_status === 'เบิกจ่ายล่วงหน้า') {
                                            $totalpaidbefore++;
                                        }elseif ($item->rental_status === 'ฝากต่อหักภาษี') {
                                            $totalcontinvat++;
                                        }elseif ($item->rental_status === 'ฝากต่อไม่หักภาษี') {
                                            $totalcontexvat++;
                                        }elseif ($item->rental_status === 'ฝากเช่า') {
                                            $totalforrental++;
                                        }elseif ($item->rental_status === 'ติดต่อเจ้าของห้องไม่ได้') {
                                            $totalcantcontact++;
                                        }
                                        $totalall++;
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $item->Project_Name }}</td>
                                        <td class="{{ $item->public == 1 && $item->Status_Room === 'พร้อมอยู่' ? 'text-green' : ''}}">{{ $item->RoomNo }}</td>
                                        <td>{{ $item->HomeNo }}</td>
                                        {{-- <td>{{ $item->RoomType }}</td>
                                        <td>{{ $item->Location }}</td>
                                        <td>{{ $item->Size }}</td> --}}
                                        {{-- <td>{{ $item->Electric_Contract }}</td> --}}
                                        {{-- <td>{{ $item->Meter_Code }}</td> --}}
                                        <td width="10%">{{ $item->Owner }}</td>
                                        <td>{{ $item->Phone }}</td>
                                        {{-- <td>{{ $item->Transfer_Date }}</td> --}}
                                        <td>{{ $item->Guarantee_Enddate }}</td>
                                        <td width="7%" class="{{ $item->rental_status === 'ฝากเช่า' ? 'text-green' : ''}} {{ $item->rental_status === 'ติดต่อเจ้าของห้องไม่ได้' ? 'text-red text-bold' : ''}}">{{ $item->rental_status }}</td>
                                        <td class="{{ $item->Status_Room === 'อยู่แล้ว' ? 'text-green text-bold' : ''}}">{{ $item->Status_Room }}</td>
                                        <td width="10%">{{ $item->Cus_Name }}</td>
                                        <td>{{ $item->Cus_phone }}</td>
                                        <td>{{ $txtprice }}</td>
                                        {{-- <td>{{ $item->Contract_Startdate }}</td> --}}
                                        <td>{{ $item->Contract_Startdate === '0000-00-00' ? '-' : $item->Contract_Startdate }}</td>
                                        @if (date("Y-m-d")>date('Y-m-d',strtotime("-1 months", strtotime($item->Contract_Enddate))))
                                            <td class="text-red text-bold">{{ $item->Contract_Enddate }}</td>
                                        @else
                                            <td>{{ $item->Contract_Enddate }}</td>
                                        @endif
                                        
                                        {{-- <td>{{ $item->Cancle_Date }}</td> --}}
                                        <td width="6%" class="{{ $item->Contract_Status === 'เช่าอยู่' ? 'text-green text-bold' : ''}} {{ $item->Contract_Status === 'ต่อสัญญา' ? 'text-blue' : ''}} {{ $item->Contract_Status === 'ยกเลิกสัญญา' ? 'text-red' : ''}}">{{ $item->Contract_Status }}</td>
                                        <td>
                                            <button type="button" class="btn bg-gradient-info btn-sm view-item" data-id="{{ $item->id }}" title="ดูรายละเอียด">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            <a href="{{ url('/rental/edit/' . $item->id) }}"
                                                class="btn bg-gradient-danger btn-sm edit-item" data-toggle="tooltip" data-placement="top" title="แก้ไข">
                                                <i class="fa fa-pencil-square">
                                                </i>

                                            </a>
                                            {{-- <button type="button" class="btn bg-gradient-warning btn-sm print-item  {{ $item->cid ? '' : 'd-none'}}"  data-id="{{ $item->id }}" data-pid="{{ $item->pid }}" data-cid="{{ $item->cid }}" title="ปริ้นเอกสารสัญญา">
                                                <i class="fa fa-print"></i>
                                            </button> --}}
                                            <a href="{{ url('/rental/rent/' . $item->id) }}"
                                                class="btn bg-gradient-success btn-sm edit-item  {{ $item->cid ? '' : 'd-none'}}" data-toggle="tooltip" data-placement="top" title="ค่าเช่า">
                                                <i class="fa fa-credit-card-alt">
                                                </i>

                                            </a>
                                            <a href="{{ url('/rental/history/' . $item->id) }}"
                                            class="btn bg-gradient-info btn-sm edit-item" data-toggle="tooltip" data-placement="top" title="ประวัติการเช่า">
                                            <i class="fa fa-address-card"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    {{-- <tr>
                                        <td colspan="16"><center>Total: {{ $totalall }} | การันตี {{$totalgarantee}} | การันตีรับล่วงหน้า {{$totalgaranteebefore}} | เบิกจ่ายล่วงหน้า {{$totalpaidbefore}} | ฝากต่อหักภาษี {{$totalcontinvat}} | ฝากต่อไม่หักภาษี {{$totalcontexvat}} | ฝากเช่า {{$totalforrental}} | ติดต่อเจ้าของห้องไม่ได้ {{$totalcantcontact}} </center></td>
                                    </tr> --}}
                                </tbody>
                            </table>
                            <table class="table table-hover table-striped text-center h6">
                                <tr>
                                    <td colspan="16"><center>ผลการค้นหาทั้งหมด : {{ $totalall }} | การันตี {{$totalgarantee}} | การันตีรับล่วงหน้า {{$totalgaranteebefore}} | เบิกจ่ายล่วงหน้า {{$totalpaidbefore}} | ฝากต่อหักภาษี {{$totalcontinvat}} | ฝากต่อไม่หักภาษี {{$totalcontexvat}} | ฝากเช่า {{$totalforrental}} | ติดต่อเจ้าของห้องไม่ได้ {{$totalcantcontact}} </center></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- view modal --}}
            <div class="modal fade" id="modal-view">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">รายละเอียดการเช่า</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <div class="modal-body">
                                <div class="box-body">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header card-outline card-info">
                                                <h3 class="card-title">ข้อมูลห้อง</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-3">
    
                                                        <div class="form-group">
                                                            <label>โครงการ</label>
                                                            <input type="text" readonly class="form-control" value="" name="projectName" id="projectName">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>เลขที่บ้านเจ้าของห้อง</label>
                                                            <input type="text" readonly class="form-control" value="" name="numberhome" id="numberhome">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>บ้านเลขที่</label>
                                                            <input type="text" readonly class="form-control" value="" name="HomeNo" id="HomeNo">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>ลูกค้า</label>
                                                            <input type="text" readonly class="form-control" value="" name="ownerName" id="ownerName">
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>บัตรประชาชน</label>
                                                            <input type="text" readonly class="form-control" value="" name="cardOwner" id="cardOwner">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>เลขที่สัญญาเจ้าของ</label>
                                                            <input type="text" readonly class="form-control" value="" name="ownerContract" id="ownerContract">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>ซอย</label>
                                                            <input type="text" readonly class="form-control" value="" name="ownerSoi" id="ownerSoi">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>ถนน</label>
                                                            <input type="text" readonly class="form-control" value="" name="ownerRoad" id="ownerRoad">
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label>แขวง/ตำบล</label>
                                                        <input type="text" readonly class="form-control" value="" name="ownerDistrict" id="ownerDistrict">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label>เขต/อำเภอ</label>
                                                        <input type="text" readonly class="form-control" value="" name="ownerKhet" id="ownerKhet">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>จังหวัด</label>
                                                            <input type="text" readonly class="form-control" value="" name="ownerProvince" id="ownerProvince">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>เบอร์ติดต่อ</label>
                                                            <input type="text" readonly class="form-control" value="" name="ownerPhone" id="ownerPhone">
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div class="row">
                                                    <div class="col-sm-3">
    
                                                        <div class="form-group">
                                                            <label>วันรับห้อง</label>
                                                            <input type="text" readonly class="form-control" value="" name="transferDate" id="transferDate">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>เลขที่ห้อง</label>
                                                            <input type="text" readonly class="form-control" value="" name="roomNo" id="roomNo">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>ประเภทห้อง</label>
                                                            <input type="text" readonly class="form-control" value="" name="roomType" id="roomType">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>ขนาดห้อง</label>
                                                            <input type="text" readonly class="form-control" value="" name="roomSize" id="roomSize">
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div class="row">
                                                    <div class="col-sm-3">
    
                                                        <div class="form-group">
                                                            <label>ทิศ/ฝั่ง</label>
                                                            <input type="text" readonly class="form-control" value="" name="location" id="location">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>อาคาร</label>
                                                            <input type="text" readonly class="form-control" value="" name="building" id="building">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>ชั้น</label>
                                                            <input type="text" readonly class="form-control" value="" name="floor" id="floor">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>บัญชีแสดงสัญญา</label>
                                                            <input type="text" readonly class="form-control" value="" name="electricContract" id="electricContract">
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div class="row">
                                                    <div class="col-sm-3">
    
                                                        <div class="form-group">
                                                            <label>ราคาห้องเช่า</label>
                                                            <input type="text" readonly class="form-control" value="" name="roomPrice" id="roomPrice">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>วันเริ่มสัญญา</label>
                                                            <input type="text" readonly class="form-control" value="" name="dateFirstrend" id="dateFirstrend">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>	วันสิ้นสุดสัญญา</label>
                                                            <input type="text" readonly class="form-control" value="" name="dateEndrend" id="dateEndrend">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>	ประเภทห้องเช่า</label>
                                                            <input type="text" readonly class="form-control" value="" name="rentalStatus" id="rentalStatus">
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div class="row">
                                                    <div class="col-sm-3">
    
                                                        <div class="form-group">
                                                            <label>สถานะห้อง</label>
                                                            <input type="text" readonly class="form-control" value="" name="roomStatus" id="roomStatus">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card">
                                            <div class="card-header card-outline card-info">
                                                <h3 class="card-title">ข้อมูลเช่า</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>ผู้เช่า</label>
                                                            <input type="text" readonly class="form-control" value="" name="cusName" id="cusName">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>เลขบัตรประชาชน</label>
                                                            <input type="text" readonly class="form-control" value="" name="cusIDCard" id="cusIDCard">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>โทร</label>
                                                            <input type="text" readonly class="form-control" value="" name="cusPhone" id="cusPhone">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>เลขที่สัญญาผู้เช่า</label>
                                                            <input type="text" readonly class="form-control" value="" name="cusContract" id="cusContract">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>ค่าเช่า</label>
                                                            <input type="text" readonly class="form-control" value="" name="cusPrice" id="cusPrice">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>วันเริ่มเช่า</label>
                                                            <input type="text" readonly class="form-control" value="" name="contractStart" id="contractStart">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>วันสิ้นสุดสัญญา</label>
                                                            <input type="text" readonly class="form-control" value="" name="contractEnd" id="contractEnd">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>วันออก</label>
                                                            <input type="text" readonly class="form-control" value="" name="cancelDate" id="cancelDate">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>สถานะการเช่า</label>
                                                            <input type="text" readonly class="form-control" value="" name="contractStatus" id="contractStatus">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            {{-- <label>วันเริ่มเช่า</label> --}}
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            {{-- <label>วันสิ้นสุดสัญญา</label> --}}
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            {{-- <label>วันออก</label> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer justify-contentend">
                                <button type="button" class="btn bg-gradient-danger" data-dismiss="modal" id="btnCloseView"><i
                                        class="fa fa-times"></i> ปิดหน้าต่าง</button>
                            </div>
                        {{-- </form> --}}
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
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
            $('#table').DataTable({
                'paging': false,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': false,
                'autoWidth': false,
                "responsive": true,
                "columnDefs": [
                        { "orderable": false, "targets": [0, 1, 2, 3, 5, 6, 10, 11, 12, 13, 15] }
                    ]
            });
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd', // รูปแบบวันที่
                autoclose: true,
            });
            $('#close').click(function() {
                $('#modal-view').trigger("reset");
                $('#modal-view').modal('hide');
            });

            $('#btnCloseView').click(function() {
                $('#modal-view').trigger("reset");
                $('#modal-view').modal('hide');
            });
        });
        //View modal
        $('body').on('click', '.view-item', function() {
            const id = $(this).data('id');
            // console.log(id);
            $('#modal-view').modal('show');
            $.get('../../api/rental/detail/' + id, function(data) {
                console.log(data);
                $('#projectName').val(data.Project_Name);
                $('#numberhome').val(data.numberhome);
                $('#HomeNo').val(data.HomeNo);
                $('#ownerName').val(data.Owner);
                $('#cardOwner').val(data.cardowner ?? '-');
                $('#ownerContract').val(data.contract_owner ?? '-');
                $('#ownerSoi').val(data.owner_soi ?? '-');
                $('#ownerRoad').val(data.owner_road ?? '-');
                $('#ownerDistrict').val(data.owner_district ?? '-');
                $('#ownerKhet').val(data.owner_khet ?? '-');
                $('#ownerProvince').val(data.owner_province ?? '-');
                $('#ownerPhone').val(data.Phone ?? '-');
                $('#transferDate').val(data.Transfer_Date ?? '-');
                $('#roomNo').val(data.RoomNo ?? '-');
                $('#roomType').val(data.RoomType ?? '-');
                $('#roomSize').val(data.Size ?? '-');
                $('#location').val(data.Location ?? '-');
                $('#building').val(data.Building ?? '-');
                $('#floor').val(data.Floor ?? '-');
                $('#electricContract').val(data.Electric_Contract ?? '-');
                $('#roomPrice').val(data.price ?? '-');
                $('#dateFirstrend').val(data.date_firstrend ?? '-');
                $('#dateEndrend').val(data.date_endrend ?? '-');
                $('#rentalStatus').val(data.rental_status ?? '-');
                $('#roomStatus').val(data.Status_Room ?? '-');
                $('#cusName').val(data.Cus_Name ?? '-');
                $('#cusIDCard').val(data.IDCard ?? '-');
                $('#cusPhone').val(data.cusPhone ?? '-');
                $('#cusContract').val(data.contract_cus ?? '-');
                $('#cusPrice').val(data.Price ?? '-');
                $('#contractStart').val(data.Contract_Startdate ?? '-');
                $('#contractEnd').val(data.Contract_Status ?? '-');
                $('#cancelDate').val(data.Cancle_Date ?? '-');
                $('#contractStatus').val(data.Contract_Status ?? '-');
            });
        });
        // JavaScript สำหรับกำหนดค่าให้กับ input ของวันที่
        // โดยใช้คำสั่ง new Date() เพื่อสร้างวัตถุ Date ที่เก็บวันที่และเวลาปัจจุบัน
        var today = new Date();

        // แปลงวัตถุ Date เป็นสตริงในรูปแบบที่ต้องการ (ในที่นี้เราใช้วิธีการกำหนดใน HTML)
        // โดยเราจะให้สตริงนี้เป็นค่าของ value ของ input
        var todayString = today.toISOString().split('T')[0]; // แบ่งส่วนของวันที่และเวลาและเลือกส่วนของวันที่เท่านั้น

        // กำหนดค่าของ input วันที่ใน DOM ด้วยการเลือกจาก id และกำหนดค่า value
        // document.getElementById('startdate').value = todayString;
        // document.getElementById('enddate').value = todayString;
    </script>
@endpush
