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
        /* padding: 1rem; */
        padding-bottom: 0.8rem; 
        text-align: center;
        /* margin: 2rem; */
        margin: 0 auto;

        position: relative;
    }
    input[type="radio"]:checked+#btn-print {
        background: #70b018;
        color: white;

    }

    /* input[type="radio"]#control_05:checked+label {
        background: #70b018;
        color: white;

    } */
    .button {
        background-color: #078f09;
        /* Green */
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
                </div><!-- /.col -->
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
                                                <option value="all">สถานะห้องเช่า ทั้งหมด</option>
                                                @foreach ($status as $item)
                                                    <option value="{{ $item->name }}">{{ $item->name }} </option>
                                                @endforeach
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
                                            <label>วันที่เริ่มต้น</label>
                                            <input class="form-control datepicker" name="startdate" id="startdate"
                                            type="text" value="" placeholder="วันที่เริ่มต้น" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>วันที่สิ้นสุด</label>
                                            <input class="form-control datepicker" name="enddate" id="enddate"
                                            type="text" value="" placeholder="วันที่สิ้นสุด" autocomplete="off">
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
                            <h3 class="card-title">จำนวน <b class="text-red">{{ $rentsCount }}</b> ห้อง</h3>

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
                                <tbody>
                                    @foreach ($rents as $item)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $item->Project_Name }}</td>
                                            {{-- <td>{{ $item->RoomNo }}</td> --}}
                                            <td>{{ $item->HomeNo }}</td>
                                            <td>{{ $item->contract_owner }}</td>
                                            <td>{{ $item->Owner }}</td>
                                            {{-- <td>{{ number_format($item->price) }}</td> --}}
                                            <td>{{ $item->rental_status }}</td>
                                            <td>{{ $item->Status_Room }}</td>
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
                                                @if ($item->Contract_Enddate)
                                                    {{ date('d/m/Y', strtotime($item->Contract_Enddate)) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                {{-- <a href="{{ url('/rental/detail/' . $item->id) }}"
                                                class="btn bg-gradient-info btn-sm edit-item" data-toggle="tooltip" data-placement="top" title="ดูรายละเอียด">
                                                <i class="fa fa-eye">
                                                </i>

                                                </a> --}}
                                                <button type="button" class="btn bg-gradient-info btn-sm view-item" data-id="{{ $item->id }}" title="ดูรายละเอียด">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                {{-- <button class="btn bg-gradient-danger  btn-sm delete-item" data-toggle="tooltip" data-placement="top" title="ลบ"
                                                    data-id="">
                                                    <i class="fa fa-trash">
                                                    </i>
                                                </button> --}}
                                                {{-- @elseif ($isRole->role_type == "User" && $isRole->dept == "Legal") --}}
                                                <a href="{{ url('/rental/edit/' . $item->id) }}"
                                                    class="btn bg-gradient-danger btn-sm edit-item" data-toggle="tooltip" data-placement="top" title="แก้ไข">
                                                    <i class="fa fa-pencil-square">
                                                    </i>

                                                </a>
                                                {{-- <a href=""
                                                    class="btn bg-gradient-warning btn-sm edit-item" data-toggle="tooltip" data-placement="top" title="พิมพ์">
                                                    <i class="fa fa-print">
                                                    </i>

                                                </a> --}}
                                                <button type="button" class="btn bg-gradient-warning btn-sm print-item  {{ $item->cid ? '' : 'd-none'}}"  data-id="{{ $item->id }}" data-pid="{{ $item->pid }}" data-cid="{{ $item->cid }}" title="ปริ้นเอกสารสัญญา">
                                                    <i class="fa fa-print"></i>
                                                </button>
                                                <a href="{{ url('/rental/rent/' . $item->id) }}"
                                                    class="btn bg-gradient-success btn-sm edit-item" data-toggle="tooltip" data-placement="top" title="ค่าเช่า">
                                                    <i class="fa fa-credit-card-alt">
                                                    </i>

                                                </a>
                                                <a href=""
                                                class="btn bg-gradient-info btn-sm edit-item" data-toggle="tooltip" data-placement="top" title="พิมพ์">
                                                <i class="fa fa-address-card">
                                                </i>

                                            </a>
                                                {{-- @endif --}}
                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- view modal --}}
            <div class="modal fade" id="modal-view">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">ข้อมูลห้องและข้อมูลการเช่า</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        {{-- <form id="createForm" name="createForm" class="form-horizontal" method="post"> --}}
                            {{-- <form id="createForm" name="createForm"  method="post" action="{{route('project.insert')}}" class="form-horizontal"> --}}
                            {{-- @csrf --}}

                            {{-- <input type="hidden" class="form-control" id="user_id" name="user_id"
                                value="{{ $dataLoginUser->id }}"> --}}
                            <div class="modal-body">

                                <div class="box-body">
                                    <h5 class="modal-title text-info">ข้อมูลห้อง</h5>

                                    <div class="row">
                                        <div class="col-sm-4">

                                            <div class="form-group">
                                                <label>โครงการ</label>
                                                {{-- <select name="project_id" id="project_id" class="form-control">
                                                    <option value="ทั้งหมด">ทั้งหมด</option>
                                                    @foreach ($projects as $project)
                                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                                    @endforeach
                                                </select> --}}
                                                {{-- <p>{{$rents->Project_Name ?? ''}}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>ห้องเลขที่</label>
                                                {{-- <input class="form-control" name="room_address" type="text" value=""
                                                    placeholder="ห้องเลขที่"> --}}
                                                    {{-- <p>{{ $rents->RoomNo ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>บ้านเลขที่</label>
                                                {{-- <input class="form-control" name="address" type="text" value=""
                                                    placeholder="บ้านเลขที่"> --}}
                                                    {{-- <p>{{ $rents->HomeNo ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>ประเภทห้อง</label>
                                                {{-- <input class="form-control" name="agent" type="text" value=""
                                                    placeholder="MNG"> --}}
                                                    {{-- <p>{{ $rents->RoomType ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>ขนาดห้อง</label>
                                                {{-- <input class="form-control" name="fixseller" type="text" value=""
                                                    placeholder="ช่องทางการขาย"> --}}
                                                    {{-- <p>{{ $rents->Size ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Location</label>
                                                {{-- <input class="form-control" name="startprice" type="number" value=""
                                                    placeholder="ราคาเริ่มต้น"> --}}
                                                    {{-- <p>{{ $rents->Location ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label>บัญชีแสดงสัญญา</label>
                                            {{-- <p>{{ $rents->Electric_Contract ?? '' }}</p> --}}
                                        </div>
                                        <div class="col-sm-4">
                                            <label>เลขที่สัญญาเจ้าของ</label>
                                            {{-- <p>{{ $rents->contract_owner ?? '' }}</p> --}}
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>ชื่อลูกค้า</label>
                                                {{-- <input class="form-control" name="user_name" type="text" value=""
                                                    placeholder="ชื่อลูกค้า"> --}}
                                                    {{-- <p>{{ $rents->owner ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">

                                            <div class="form-group">
                                                <label>เบอร์โทรศัพท์</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->Phone ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>ราคาค่าเช่าห้อง</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->price ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>วันเริ่มสัญญา</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->date_firstrend ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">

                                            <div class="form-group">
                                                <label>วันสิ้นสุดสัญญา</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->date_endrend ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>ประเภทห้องเช่า</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                {{-- <p>{{ $rents->rental_status ?? '' }}</p>     --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Status</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->Status_Room ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">

                                            <div class="form-group">
                                                <label>เลขที่สัญญาผู้เช่า</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->contract_cus ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>ผู้เช่า</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->Cus_Name ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>	โทร</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->Phone ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">

                                            <div class="form-group">
                                                <label>ค่าเช่า</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->Price ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>วันเริ่มเช่า</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->Contract_Startdate ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>วันสิ้นสุดสัญญา</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->Contract_Enddate ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">

                                            <div class="form-group">
                                                <label>วันออก</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->Contract_Status }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>สถานะการเช่า</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->Contract_Status ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>ค่าประกันทรัพย์สิน</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->price_insurance ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h5 class="modal-title text-info">เฟอร์นิเจอร์</h5>

                                    <div class="row">
                                        <div class="col-sm-4">

                                            <div class="form-group">
                                                <label>เตียง</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->Contract_Status }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>เครื่องนอน</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->Contract_Status ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>ม่านห้องนอน</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->price_insurance ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">

                                            <div class="form-group">
                                                <label>ม่านห้องรับแขก</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->Contract_Status }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>ตู้เสื้อผ้า</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->Contract_Status ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>โซฟา</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->price_insurance ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">

                                            <div class="form-group">
                                                <label>โต๊ะวางโทรทัศน์</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->Contract_Status }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>โต๊ะกินข้าว</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->Contract_Status ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>โต๊ะกลาง</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->price_insurance ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">

                                            <div class="form-group">
                                                <label>เก้าอี้</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->Contract_Status }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                {{-- <label>สถานะการเช่า</label> --}}
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->Contract_Status ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                {{-- <label>ค่าประกันทรัพย์สิน</label> --}}
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->price_insurance ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h5 class="modal-title text-info">เครื่องใช้ไฟฟ้า</h5>

                                    <div class="row">
                                        <div class="col-sm-4">

                                            <div class="form-group">
                                                {{-- <label>แอร์ห้องนอน</label> --}}
                                                <p><label> แอร์ห้องนอน </label> 1</p>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->Contract_Status }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                {{-- <label>แอร์ห้องรับแขก</label> --}}
                                                <p>แอร์ห้องรับแขก 1</p>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->Contract_Status ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>เครื่องทำน้ำอุ่น</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->price_insurance ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">

                                            <div class="form-group">
                                                <label>ทีวี</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->Contract_Status }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>ตู้เย็น</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->Contract_Status ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>ไมโครเวฟ</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->price_insurance ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">

                                            <div class="form-group">
                                                <label>เครื่องซักผ้า</label>
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->Contract_Status }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                {{-- <label>โต๊ะกินข้าว</label> --}}
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->Contract_Status ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                {{-- <label>โต๊ะกลาง</label> --}}
                                                {{-- <input class="form-control" name="phone" type="text" value=""
                                                    placeholder="เบอร์โทรศัพท์"> --}}
                                                    {{-- <p>{{ $rents->price_insurance ?? '' }}</p> --}}
                                            </div>
                                        </div>
                                    </div>

                                </div>


                            </div>
                            <div class="modal-footer justify-contentend">
                                <button type="button" class="btn bg-gradient-danger" data-dismiss="modal"><i
                                        class="fa fa-times"></i> ปิดหน้าต่าง</button>
                                {{-- <button type="button" class="btn bg-gradient-success" id="savedata"
                                    value="create"><i class="fa fa-save"></i> บันทึก</button> --}}
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
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        {{-- <form id="createForm" name="createForm" class="form-horizontal" method="post"> --}}
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
                                            <button type="submit" name="submit" value="approve" class="button
                                                {{-- <?php echo ($lease_agr_code == null ? "button-dis":"button");?> button1 fontGoogle"
                                                <?php echo ($lease_agr_code == null ? "disabled":"");?> 
                                                <?php echo ($sub_lease_code == null ? "disabled":"");?> 
                                                <?php echo ($insurance_code == null ? "disabled":"");?> 
                                                <?php echo ($agent_contract_code == null ? "disabled":"");?>--}}
                                                "> 
                                                {{-- <?php echo ($lease_agr_code == null ? "ไม่สามารถปริ้นเอกสารได้ เนื่องจากไม่ได้กำหนดรูปแบบ<br>กรุณาติดต่อ IT":"ยืนยันการปริ้นเอกสาร");?>  --}}
                                                ยืนยันการปริ้นเอกสาร
                                            </button>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer justify-contentend">
                                <button type="button" class="btn bg-gradient-danger" data-dismiss="modal"><i
                                        class="fa fa-times"></i> ปิดหน้าต่าง</button>
                                {{-- <button type="button" class="btn bg-gradient-success" id="savedata"
                                    value="create"><i class="fa fa-save"></i> บันทึก</button> --}}
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
        });

        //View modal
        $('body').on('click', '.view-item', function() {

            const id = $(this).data('id');
            console.log(id);
            $('#modal-view').modal('show');
            $.get('../api/rental/detail/' + id, function(data) {
                console.log(data);
                // $('#id_edit').val(data.id);
                // $('#code_edit').val(data.role.code);
                // $('#name_edit').val(data.role.name_th);
                // // $('#dept_edit').val(data.dept);
                // $('#dept_edit2').val(data.dept);
                // $('#logo_img').attr('src', data.logo);
                // if (data.role_type == null || data.role_type === "") {
                //     $('#role_type_edit option[value=""]').prop('selected', true);
                // } else {
                //     $('#role_type_edit option[value="' + data.role_type + '"]').prop('selected',
                //         true);
                // }
                // if (data.dept == null || data.dept === "") {
                //     $('#dept_edit option[value=""]').prop('selected', true);
                // } else {
                //     $('#dept_edit option[value="' + data.dept + '"]').prop('selected', true);
                // }


                // $('input[name="r1"][value="' + data.active + '"]').prop('checked', true);
                // handleRoleChange();


            });
        });

        //View modal
        $('body').on('click', '.print-item', function() {

            const room_id = $(this).data('id');
            const project_id = $(this).data('pid');
            const customer_id = $(this).data('cid');
            console.log(room_id,project_id,customer_id);
            $('#modal-print').modal('show');
            $('#room_id').val(room_id);
            $('#project_id').val(project_id);
            $('#customer_id').val(customer_id);
            // $.get('../api/rental/detail/' + id, function(data) {
            //     console.log(data);
                
            // });
        });

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
