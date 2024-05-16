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
                                                    {{-- @foreach ($projects as $project)
                                                    <option value="{{ $project->pid }}">{{ $project->Project_Name }}
                                                    </option>
                                                @endforeach --}}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>วันที่เริ่มต้น</label>
                                            <input class="form-control datepicker" name="startdate" id="startdate"
                                                type="text" value="" placeholder="วันที่เริ่มต้น"
                                                autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>วันที่สิ้นสุด</label>
                                            <input class="form-control datepicker" name="enddate" id="enddate"
                                                type="text" value="" placeholder="วันที่สิ้นสุด"
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
                            <h3 class="card-title">จำนวน <b class="text-red">0</b> สัญญาห้องเช่า</h3>
                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-hover table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>โครงการ</th>
                                        <th>ห้องเลขที่</th>
                                        <th>บ้านเลขที่</th>
                                        <th>Type</th>
                                        <th>Location</th>
                                        <th>ขนาด</th>
                                        <th>บัญชีแสดงสัญญา</th>
                                        <th>รหัสเครื่องวัดฯ</th>
                                        <th>ลูกค้า</th>
                                        <th>โทร</th>
                                        <th>วันรับห้อง</th>
                                        <th>วันสิ้นสุดการันตี</th>
                                        <th>ประเภทห้องเช่า</th>
                                        <th>Status</th>
                                        <th>ผู้เช่า</th>
                                        <th>โทร</th>
                                        <th>ค่าเช่า</th>
                                        <th>วันเริ่มเช่า</th>
                                        <th>วันสิ้นสุดสัญญา</th>
                                        <th>วันออก</th>
                                        <th>สถานะการเช่า</th>
                                        <th>สัญญา</th>
                                        <th>ค่าเช่า</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
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
    <script>
        // JavaScript สำหรับกำหนดค่าให้กับ input ของวันที่
        // โดยใช้คำสั่ง new Date() เพื่อสร้างวัตถุ Date ที่เก็บวันที่และเวลาปัจจุบัน
        var today = new Date();

        // แปลงวัตถุ Date เป็นสตริงในรูปแบบที่ต้องการ (ในที่นี้เราใช้วิธีการกำหนดใน HTML)
        // โดยเราจะให้สตริงนี้เป็นค่าของ value ของ input
        var todayString = today.toISOString().split('T')[0]; // แบ่งส่วนของวันที่และเวลาและเลือกส่วนของวันที่เท่านั้น

        // กำหนดค่าของ input วันที่ใน DOM ด้วยการเลือกจาก id และกำหนดค่า value
        document.getElementById('startdate').value = todayString;
        document.getElementById('enddate').value = todayString;
    </script>
@endpush
