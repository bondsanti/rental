@extends('layouts.app')

@section('title', 'ห้องเช่า')

@section('content')

@push('style')
<style>

    /* ลดขนาดตัวอักษรในส่วนของส่วนหัวของตาราง (thead) */
    #table thead th {
        font-size: 13px; /* ปรับขนาดตามที่คุณต้องการ */
    }

    /* ลดขนาดตัวอักษรในส่วนของข้อมูลในตาราง (tbody) */
    #table tbody td {
        font-size: 13px; /* ปรับขนาดตามที่คุณต้องการ */
    }

    input[type="radio"] {
        display: none;
    }

    input[type="radio"]:not(:disabled)~label {
        cursor: pointer;
    }

    input[type="radio"]:disabled~label {
        color: #159F5C;
        border-color: #159F5C;

        cursor: not-allowed;
    }
    #btn-print {
        height: 100%;
        width: 65%;
        display: block;
        background: white;
        border: 2px solid #D8D9DC;
        border-radius: 5px;
        padding-bottom: 0.8rem;
        text-align: center;
        margin: 0 auto;

        position: relative;
    }
    input[type="radio"]:checked+#btn-print {
        background: #70b018;
        color: white;

    }

    .button {
        background-color: #078f09;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        margin: 2px 1px;
        cursor: pointer;
        border-radius: 5px;
    }
</style>
@endpush


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
                                                <option value="all">ทั้งหมด</option>
                                                @foreach ($status as $item)
                                                    @if ($item->status_room)
                                                        <option value="{{ $item->status_room }}">{{ $item->status_room }} </option>
                                                    @endif
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
                                                <input class="form-control" name="Cusmoter" type="text" value=""
                                                    placeholder="ชื่อคนเช่า" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="box-footer text-center">
                                    <button type="submit" class="btn bg-gradient-success"><i
                                            class="fa fa-search"></i>
                                        ค้นหา</button>
                                    <a href="{{ route('rental') }}" type="button"
                                        class="btn bg-gradient-danger"><i class="fa fa-refresh"></i> เคลียร์</a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-outline card-info">
                            <h3 class="card-title mt-2 mr-2">จำนวน <b class="text-red">{{ $rentsCount }}</b> ห้อง</h3>
                            @if ($rentsCount)
                                <button id="export-btn" class="btn btn-success">
                                    <input type="hidden" id="btn_export" value="{{ $rentsCount }}">
                                    <i class="fa fa-file-excel" aria-hidden="true"></i> Export Excel</button>
                            @endif
                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-hover table-striped text-center ">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th width="10%">โครงการ</th>
                                        {{-- <th width="5%" >ห้องเลขที่</th> --}}
                                        <th>บ้านเลขที่</th>
                                        <th>เลขที่สัญญาเจ้าของ</th>
                                        {{-- <th>ขนาด<sup>(ตรม.)</sup></th> --}}
                                        <th width="15%">ลูกค้า</th>
                                        <th>ประเภทห้องเช่า</th>
                                        <th>สถานะห้องเช่า</th>
                                        <th>สถานะการเช่า</th>
                                        <th>วันสิ้นสุดสัญญา<sup>(เจ้าของห้อง)</sup></th>
                                        <th>วันสิ้นสุดสัญญา<sup>(ผู้เช่า)</sup></th>
                                        <th class="text-center">Action</th>
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
                                            <td>
                                                <div class="h6">{{ $loop->index + 1 }}</div>
                                            </td>
                                            <td>
                                                <div class="h6">{{ $item->Project_Name }}</div>
                                            </td>
                                            {{-- <td>{{ $item->RoomNo }}</td> --}}
                                            <td>
                                                <div class="h6">{{ $item->HomeNo }}</div>
                                            </td>
                                            <td>
                                                <div class="h6">{{ $item->contract_owner }}</div>
                                            </td>
                                            <td>
                                                <div class="h6">{{ $item->Owner }}</div>
                                            </td>
                                            {{-- <td>{{ number_format($item->price) }}</td> --}}
                                            <td>
                                                <div class="text-bold h6 {{ $item->rental_status == 'การันตี' ? 'text-green' : ''}} {{ $item->rental_status == 'ฝากต่อหักภาษี' ? 'text-sky' : ''}} {{ $item->rental_status == 'ฝากต่อไม่หักภาษี' ? 'text-gray' : ''}} {{ $item->rental_status == 'เบิกจ่ายล่วงหน้า' ? 'text-yellow' : ''}} {{ $item->rental_status == 'ฝากเช่า' ? 'text-blue' : ''}}">
                                                    {{ $item->rental_status }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-bold h6 {{ $item->Status_Room == 'อยู่แล้ว' ? 'text-green' : ''}} {{ $item->Status_Room == 'พร้อมอยู่' ? 'text-orange' : ''}} {{ $item->Status_Room == 'จอง' ? 'text-yellow' : ''}} {{ $item->Status_Room == 'ไม่พร้อมอยู่' ? 'text-gray' : ''}} {{ $item->Status_Room == 'รอคลีน' ? 'text-gray' : ''}} {{ $item->Status_Room == 'รอตรวจ' ? 'text-gray' : ''}} {{ $item->Status_Room == 'รอเฟอร์' ? 'text-gray' : ''}} {{ $item->Status_Room == 'ห้องตัวอย่าง' ? 'text-sky' : ''}} {{ $item->Status_Room == 'ห้องออฟฟิต' ? 'text-sky' : ''}} ">
                                                    {{ $item->Status_Room }}
                                                </div>
                                            </td>
                                            <td>{{ $item->Contract_Status }}</td>
                                            <td>
                                                @if ($item->rental_status=="การันตี")
                                                    @if ($item->Guarantee_Enddate)
                                                    {{ date('d/m/Y', strtotime($item->Guarantee_Enddate)) }}
                                                    @else
                                                        -
                                                    @endif
                                                @else
                                                    @if ($item->date_endrend)
                                                    {{ date('d/m/Y', strtotime($item->date_endrend)) }}
                                                    @else
                                                        -
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->Contract_Enddate  == "0000-00-00" || $item->Contract_Enddate < "1990-01-01")
                                                    -
                                                @else
                                                    @if (date("Y-m-d") > date('Y-m-d', strtotime("-1 months", strtotime($item->Contract_Enddate))))
                                                        <div class="text-danger text-bold">{{ date('d/m/Y', strtotime($item->Contract_Enddate)) }}</div>
                                                    @else
                                                        {{ date('d/m/Y', strtotime($item->Contract_Enddate)) }}
                                                    @endif
                                                    
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn bg-gradient-info btn-sm view-item" data-id="{{ $item->id }}" title="ดูรายละเอียด">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                @if ($isRole->role_type=="SuperAdmin" || $isRole->role_type=="Admin")
                                                    <a href="{{ url('/rental/edit/' . $item->id) }}"
                                                        class="btn bg-gradient-danger btn-sm edit-item" data-toggle="tooltip" data-placement="top" title="แก้ไข">
                                                        <i class="fa fa-pencil-square">
                                                        </i>
                                                    </a>
                                                    <button type="button" class="btn bg-gradient-warning btn-sm print-item  {{ $item->cid ? '' : 'd-none'}}"  data-id="{{ $item->id }}" data-pid="{{ $item->pid }}" data-cid="{{ $item->cid }}" title="ปริ้นเอกสารสัญญา">
                                                        <i class="fa fa-print"></i>
                                                    </button>
                                                    <a href="{{ url('/rental/rent/' . $item->id) }}"
                                                        class="btn bg-gradient-success btn-sm edit-item  {{ $item->cid ? '' : 'd-none'}} {{ $item->Contract_Status != 'เช่าอยู่' ? 'd-none' : ''}}" data-toggle="tooltip" data-placement="top" title="ค่าเช่า">
                                                        <i class="fa fa-credit-card-alt">
                                                        </i>
                                                    </a>
                                                    <a href="{{ url('/rental/history/' . $item->id) }}"
                                                        class="btn bg-gradient-info btn-sm edit-item {{ $item->cid ? '' : 'd-none'}}" data-toggle="tooltip" data-placement="top" title="ประวัติการเช่า">
                                                        <i class="fa fa-address-card"></i>
                                                    </a>
                                                @endif
                                                @if ($isRole->role_type=="Account")
                                                    <a href="{{ url('/rental/rent/' . $item->id) }}"
                                                        class="btn bg-gradient-success btn-sm edit-item  {{ $item->cid ? '' : 'd-none'}}" data-toggle="tooltip" data-placement="top" title="ค่าเช่า">
                                                        <i class="fa fa-credit-card-alt">
                                                        </i>
                                                    </a>
                                                @endif
                                                @if ($isRole->role_type=="SuperAdmin")
                                                    <button class="btn bg-gradient-danger btn-sm delete-item {{ $item->cid ? 'd-none' : ''}}"
                                                        data-id="{{ $item->id }}" title="ลบ">
                                                        <i class="fa fa-trash">
                                                        </i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if ($rentsCount)
                                <table class="table table-hover table-striped text-center h6">
                                    <tr>
                                        <td colspan="16"><center>ผลการค้นหาทั้งหมด : {{ $totalall }} | การันตี {{$totalgarantee}} | การันตีรับล่วงหน้า {{$totalgaranteebefore}} | เบิกจ่ายล่วงหน้า {{$totalpaidbefore}} | ฝากต่อหักภาษี {{$totalcontinvat}} | ฝากต่อไม่หักภาษี {{$totalcontexvat}} | ฝากเช่า {{$totalforrental}} | ติดต่อเจ้าของห้องไม่ได้ {{$totalcantcontact}} </center></td>
                                    </tr>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- table for export excel --}}
            <table id="table-excel" class="d-none table table-hover table-striped text-center ">
                <thead>
                    <tr>
                        <th>No</th>
                        <th width="10%">โครงการ</th>
                        <th width="5%" >ห้องเลขที่</th>
                        <th>บ้านเลขที่</th>
                        <th>Type</th>
                        <th>Location</th>
                        <th>ขนาด<sup>(ตรม.)</sup></th>
                        <th>บัญชีแสดงสัญญา</th>
                        <th>เลขที่สัญญาเจ้าของ</th>
                        <th width="15%">ลูกค้า</th>
                        <th>โทร</th>
                        <th>ราคาห้องเช่า</th>
                        <th>วันเริ่มสัญญา</th>
                        <th>วันสิ้นสุดสัญญา</th>
                        <th>ประเภทห้องเช่า</th>
                        <th>สถานะห้องเช่า</th>
                        <th>เลขที่สัญญาผู้เช่า</th>
                        <th>ผู้เช่า</th>
                        <th>โทร</th>
                        <th>ค่าเช่า</th>
                        <th>วันเริ่มเช่า</th>
                        <th>วันสิ้นสุดสัญญา</th>
                        <th>วันออก</th>
                        <th>สถานะการเช่า</th>
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
                    $txtprice = 0;
                @endphp
                <tbody>
                    @foreach ($rents as $item)
                    @php
                        if ($item->price_cus > 0) {
                            $txtprice = $item->price_cus;
                        } else {
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
                            <td>{{ $item->RoomNo }}</td>
                            <td>{{ $item->HomeNo }}</td>
                            <td>{{ $item->RoomType }}</td>
                            <td>{{ $item->Location }}</td>
                            <td>{{ $item->Size }}</td>
                            <td>{{ $item->Electric_Contract }}</td>
                            <td>{{ $item->contract_owner }}</td>
                            <td>{{ $item->Owner }}</td>
                            <td>{{ $item->phone_owner }}</td>
                            <td>{{ number_format($item->room_price) }}</td>
                            @if ($item->date_endrend != '')
                                <td>{{ $item->date_firstrend ?? ''}}</td>
                                <td>{{ $item->date_endrend ?? ''}}</td>
                            @else
                                <td>{{ $item->Guarantee_Startdate ?? '' }}</td>
                                <td>{{ $item->Guarantee_Enddate ?? '' }}</td>
                            @endif
                            
                            <td>{{ $item->rental_status }}</td>
                            <td>{{ $item->Status_Room }}</td>
                            @if ($item->Status_Room == 'ไม่พร้อมอยู่')
                                <td>{{ $item->Other }}</td>
                            @else
                                <td>{{ $item->contract_cus }}</td>
                                <td>{{ $item->Cus_Name }}</td>
                                <td>{{ $item->phone_cus }}</td>
                                <td>{{ $txtprice ?? 0 }}</td>
                            @endif
                            <td>{{ $item->Contract_Startdate ?? '' }}</td>
                            <td>
                                @if ($item->Contract_Enddate  == "0000-00-00" || $item->Contract_Enddate < "1990-01-01")
                                    -
                                @else
                                    @if (date("Y-m-d") > date('Y-m-d', strtotime("-1 months", strtotime($item->Contract_Enddate))))
                                        <div class="text-danger text-bold">{{ date('d/m/Y', strtotime($item->Contract_Enddate)) }}</div>
                                    @else
                                        {{ date('d/m/Y', strtotime($item->Contract_Enddate)) }}
                                    @endif
                                    
                                @endif
                            </td>
                            <td>{{ $item->Cancle_Date ?? '' }}</td>
                            <td>{{ $item->Contract_Status }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="16"><center>ผลการค้นหาทั้งหมด : {{ $totalall }} | การันตี {{$totalgarantee}} | การันตีรับล่วงหน้า {{$totalgaranteebefore}} | เบิกจ่ายล่วงหน้า {{$totalpaidbefore}} | ฝากต่อหักภาษี {{$totalcontinvat}} | ฝากต่อไม่หักภาษี {{$totalcontexvat}} | ฝากเช่า {{$totalforrental}} | ติดต่อเจ้าของห้องไม่ได้ {{$totalcantcontact}} </center></td>
                    </tr>
                </tbody>
            </table>

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
                                                            {{-- <label>วันสิ้นสุดสัญญา</label> --}}
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

                                        {{-- <div class="card">
                                            <div class="card-header card-outline card-info">
                                                <h3 class="card-title">เฟอร์นิเจอร์</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-4">

                                                        <div class="form-group">
                                                            <label>เตียง</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>เครื่องนอน</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>ม่านห้องนอน</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4">

                                                        <div class="form-group">
                                                            <label>ม่านห้องรับแขก</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>ตู้เสื้อผ้า</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>โซฟา</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4">

                                                        <div class="form-group">
                                                            <label>โต๊ะวางโทรทัศน์</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>โต๊ะกินข้าว</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>โต๊ะกลาง</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4">

                                                        <div class="form-group">
                                                            <label>เก้าอี้</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}

                                        {{-- <div class="card">
                                            <div class="card-header card-outline card-info">
                                                <h3 class="card-title">เครื่องใช้ไฟฟ้า</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-4">

                                                        <div class="form-group">
                                                            <p><label> แอร์ห้องนอน </label> 1</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <p>แอร์ห้องรับแขก 1</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>เครื่องทำน้ำอุ่น</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4">

                                                        <div class="form-group">
                                                            <label>ทีวี</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>ตู้เย็น</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>ไมโครเวฟ</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4">

                                                        <div class="form-group">
                                                            <label>เครื่องซักผ้า</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}

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
            <!-- /.modal -->

            {{-- print modal --}}
            <div class="modal fade" id="modal-print">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-bold"><img src="../uploads/images/print.svg" width="20" height="20" style="margin-top: -4px;"> ปริ้นเอกสารสัญญา</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closePrint">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <form id="createForm" name="createForm"  method="post" action="{{route('rental.print')}}" class="form-horizontal" target="_blank">
                            @csrf

                            {{-- <input type="hidden" class="form-control" id="user_id" name="user_id"
                                value="{{ $dataLoginUser->id }}"> --}}
                            <input type="hidden" class="form-control" id="room_id" name="room_id">
                            <input type="hidden" class="form-control" id="project_id" name="project_id">
                            <input type="hidden" class="form-control" id="customer_id" name="customer_id">
                            <div class="modal-body">
                                <div class="box-body">
                                    <div class="row text-center">
                                        <div class="col-sm-6">
                                            <input type="radio" id="control_04" name="status_approve" value="4" required>
                                            <label for="control_04" id="btn-print">
                                                <img src="../uploads/images/slipers.svg" width="25" height="25" style="margin: 4.5px;">&nbsp;<br><span>สัญญาเช่าห้องชุด</span>
                                            </label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="radio" id="control_03" name="status_approve" value="3" required>
                                            <label for="control_03" id="btn-print">
                                                <img src="../uploads/images/furniture.svg" width="35" height="35">&nbsp;<br><span>สัญญาตั้งตัวเเทน</span>
                                            </label>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="row text-center">
                                        <div class="col-sm-6">
                                            <input type="radio" id="control_01" name="status_approve" value="1" required>
                                            <label for="control_01" id="btn-print">
                                                <img src="../uploads/images/slipers.svg" width="25" height="25" style="margin: 4.5px;">&nbsp;<br><span>สัญญาเช่าช่วง</span>
                                            </label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="radio" id="control_05" name="status_approve" value="2" required>
                                            <label for="control_05" id="btn-print">
                                                <img src="../uploads/images/furniture.svg" width="35" height="35">&nbsp;<br><span>สัญญาเช่าห้อง+เฟอร์นิเจอร์</span>
                                            </label>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="row text-center">
                                        <div class="col-sm-6">
                                            <label for="control_01">
                                                กรอกชื่อ-สกุล พยานคนที่ 1
                                            </label>
                                            <input type="text" name="phayarn1" style="height: 35px; width:65%;border: 2px solid #dbdbdb ;border-radius: 4px;margin-top:10px;text-align: center;">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="control_05">
                                                กรอกชื่อ-สกุล พยานคนที่ 2
                                            </label>
                                            <input type="text" name="phayarn2" style="height: 35px; width:65%;border: 2px solid #dbdbdb ;border-radius: 4px;margin-top:10px;text-align: center;">
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="row text-center">
                                        <div class="col-sm-12">
                                            <button type="submit" name="submit" value="approve" class="button btnApprove">
                                                ยืนยันการปริ้นเอกสาร
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-contentend">
                                <button type="button" class="btn bg-gradient-danger" data-dismiss="modal" id="btnPrint"><i
                                        class="fa fa-times"></i> ปิดหน้าต่าง</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

        </div><!-- /.container-fluid -->
    </section>
@endsection
@push('script')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.6/xlsx.full.min.js"></script>
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
                        { "orderable": false, "targets": [0, 1, 2, 3] }
                    ]
            });

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd', // รูปแบบวันที่
                autoclose: true,
            });

            $('#startdate').on('changeDate', function(e) {
                var selectedStartDate = e.date;
                $('#enddate').datepicker('setStartDate', selectedStartDate);
            });

            $('#close').click(function() {
                $('#modal-view').trigger("reset");
                $('#modal-view').modal('hide');
            });

            $('#btnCloseView').click(function() {
                $('#modal-view').trigger("reset");
                $('#modal-view').modal('hide');
            });

            $('#closePrint').click(function() {
                $('#createForm').trigger("reset");
                $('#modal-print').modal('hide');
            });

            $('#btnPrint').click(function() {
                $('#createForm').trigger("reset");
                $('#modal-print').modal('hide');
            });
        });

        //View modal
        $('body').on('click', '.view-item', function() {

            const id = $(this).data('id');
            // console.log(id);
            $('#modal-view').modal('show');
            $.get('../api/rental/detail/' + id, function(data) {
                // console.log(data);
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
                $('#contractEnd').val(data.Contract_Enddate ?? '-');
                $('#cancelDate').val(data.Cancle_Date ?? '-');
                $('#contractStatus').val(data.Contract_Status ?? '-');
            });
        });

        //View modal
        $('body').on('click', '.print-item', function() {

            const room_id = $(this).data('id');
            const project_id = $(this).data('pid');
            const customer_id = $(this).data('cid');
            // console.log(room_id,project_id,customer_id);
            $('#modal-print').modal('show');
            $('#room_id').val(room_id);
            $('#project_id').val(project_id);
            $('#customer_id').val(customer_id);
            $.get('../api/rental/getLeaseCode/' + project_id, function(data) {
                // console.log(data);
                const lease_code_id = data.lease_code_id;
                const lease_agr_code = data.lease_agr_code;
                const sub_lease_code = data.sub_lease_code;
                const insurance_code = data.insurance_code;
                const agent_contract_code = data.agent_contract_code;
                if(lease_code_id == null || lease_agr_code == null || sub_lease_code == null || insurance_code == null || agent_contract_code == null){
                    $('.btnApprove').prop('disabled', true);
                    $('.btnApprove').html('ไม่สามารถปริ้นเอกสารได้ เนื่องจากไม่ได้กำหนดรูปแบบ<br>กรุณาติดต่อ IT');
                    $('.btnApprove').css({
                        'background-color': 'gray',
                        'cursor': 'not-allowed',
                    });
                }else{
                    $('.btnApprove').prop('disabled', false);
                    $('.btnApprove').html('ยืนยันการปริ้นเอกสาร');
                    $('.btnApprove').css({
                        'background-color': 'green',
                        'cursor': 'pointer',
                    });
                }
                // console.log(lease_code_id);
            });
        });

        //Delete
        $('body').on('click', '.delete-item', function() {

            const id = $(this).data("id");
            //console.log(id);
            Swal.fire({
                title: 'คุณแน่ใจไหม? ',
                text: "หากต้องการลบข้อมูลนี้ โปรดยืนยัน การลบข้อมูล",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'ยกเลิก',
                confirmButtonText: 'ยืนยัน'
            }).then((result) => {

                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: '../api/rental/destroy/' + id,

                        success: function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: data.message,
                                showConfirmButton: true,
                                timer: 2500
                            });

                            setTimeout(function(){
                                    // "location.href = '{{ route('user') }}';",
                                    location.reload();
                                },
                                1500);

                        },
                    });
                }
            });
        });

    </script>
    <script>
        let btn_export = $('#btn_export').val();
        if (btn_export) {
            document.getElementById('export-btn').addEventListener('click', function() {
                var table = document.getElementById('table-excel');
                var wb = XLSX.utils.table_to_book(table, {
                    sheet: "Sheet JS"
                });
                var wbout = XLSX.write(wb, {
                    bookType: 'xlsx',
                    bookSST: true,
                    type: 'binary'
                });

                function s2ab(s) {
                    var buf = new ArrayBuffer(s.length);
                    var view = new Uint8Array(buf);
                    for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
                    return buf;
                }
                saveAs(new Blob([s2ab(wbout)], {
                    type: "application/octet-stream"
                }), 'rental.xlsx');
            });
        }
        
    </script>
    <!-- Return Form-->
    @if (isset($formInputs))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var formInputs = @json($formInputs);

                Object.keys(formInputs).forEach(function(key) {
                    var input = document.querySelector('[name="' + key + '"]');
                    if (input) {
                        input.value = formInputs[key];
                    }
                });
            });
        </script>
    @endif
@endpush
