@extends('layouts.app')

@section('title', 'Assetห้องเช่าSearch')
<style>
    #my-table {
        font-size: 12px;
        /* กำหนดขนาดตัวอักษร */
    }

    th,
    td {
        padding: 5px;
        /* กำหนดระยะห่างของข้อมูลในเซลล์ */
        font-size: 12px;
        /* กำหนดขนาดตัวอักษร */
    }
</style>
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Asset ห้องเช่า

                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('main') }}">Home</a></li>
                        <li class="breadcrumb-item active">Asset ห้องเช่า</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">ค้นหา Asset ห้องเช่า</h3>
                        </div>
                        <form action="{{ route('report.asset.search') }}" method="POST" id="AssetSearch">
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
                                            <label for="">วันที่</label>
                                            <select name="dt" id="dt" class="form-control text-center">
                                                <option value="99"
                                                    {{ request()->input('dt') == '99' ? 'selected' : '' }}>------- All Date
                                                    -------</option>
                                                <option value="1"
                                                    {{ request()->input('dt') == '1' ? 'selected' : '' }}>วันรับห้อง
                                                </option>
                                                <option value="2"
                                                    {{ request()->input('dt') == '2' ? 'selected' : '' }}>วันเริ่มการันตี
                                                </option>
                                                <option value="3"
                                                    {{ request()->input('dt') == '3' ? 'selected' : '' }}>วันสิ้นสุดการันตี
                                                </option>
                                                <option value="4"
                                                    {{ request()->input('dt') == '4' ? 'selected' : '' }}>วันเริ่มเช่า
                                                </option>
                                                <option value="5"
                                                    {{ request()->input('dt') == '5' ? 'selected' : '' }}>วันชำระเงินค่าเช่า
                                                </option>
                                                <option value="6"
                                                    {{ request()->input('dt') == '6' ? 'selected' : '' }}>วันออก</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>วันที่เริ่มต้น</label>
                                            <input class="form-control datepicker" name="startdate" id="startdate"
                                                type="text" value="{{ $startDate }}" placeholder="วันที่เริ่มต้น"
                                                autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>วันที่สิ้นสุด</label>
                                            <input class="form-control datepicker" name="enddate" id="enddate"
                                                type="text" value="{{ $endDate }}" placeholder="วันที่สิ้นสุด"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>ห้องเลขที่</label>
                                            <input class="form-control" name="RoomNo" type="text" value=""
                                                placeholder="ห้องเลขที่" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>ชื่อลูกค้า</label>
                                            <input class="form-control" name="" type="text" value=""
                                                placeholder="ชื่อลูกค้า" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>ชื่อคนเช่า</label>
                                            <input class="form-control" name="" type="text" value=""
                                                placeholder="ชื่อคนเช่า" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">สถานะห้อง</label>
                                            <select name="s1" id="s1" class="form-control">
                                                <option value="All">--- All Status ---</option>
                                                @foreach ($statuses as $status)
                                                    <option value="{{ $status->status_room }}">{{ $status->status_room }}
                                                    </option>
                                                @endforeach
                                                <option value="เช่าอยู่">เช่าอยู่</option>
                                                <option value="คืนห้อง">คืนห้อง</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">ประเภทห้องเช่า</label>
                                            <select name="rt" id="rt" class="form-control">
                                                <option value="All">--- All Status ---</option>
                                                <option value="การันตี">การันตี</option>
                                                <option value="การันตีรับล่วงหน้า">การันตีรับล่วงหน้า</option>
                                                <option value="เบิกจ่ายล่วงหน้า">เบิกจ่ายล่วงหน้า</option>
                                                <option value="ฝากต่อหักภาษี">ฝากต่อหักภาษี</option>
                                                <option value="ฝากต่อไม่หักภาษี">ฝากต่อไม่หักภาษี</option>
                                                <option value="ฝากเช่า">ฝากเช่า</option>
                                                <option value="ติดต่อเจ้าของห้องไม่ได้">ติดต่อเจ้าของห้องไม่ได้</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer text-center">
                                    <button type="submit" name="search" class="btn bg-gradient-success"><i
                                            class="fa fa-search"></i>
                                        ค้นหา</button>
                                    <a href="{{ route('report.asset') }}" type="button"
                                        class="btn bg-gradient-danger"><i class="fa fa-refresh"></i> เคลียร์</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">จำนวน <b class="text-red">0</b> Assetห้องเช่า </h3>
                                </div>
                                <div class="card-body">
                                    <table id="my-table" class="display table table-bordered table-font table-sm"
                                        style="width:100%">
                                        <thead class="table-success">
                                            <tr>
                                                <th rowspan=2>
                                                    <div align="center">No.</div>
                                                </th>
                                                <th rowspan=2>
                                                    <div align="center">โครงการ</div>
                                                </th>
                                                <th rowspan=2>
                                                    <div align="center">ห้องเลขที่</div>
                                                </th>
                                                <th rowspan=2>
                                                    <div align="center">บ้านเลขที่</div>
                                                </th>
                                                <th colspan=8>
                                                    <div align="center">กุญแจ</div>
                                                </th>
                                                <th colspan=10>
                                                    <div align="center">เฟอนิเจอร์</div>
                                                </th>
                                                <th colspan=7>
                                                    <div align="center">เครื่องใช้ไฟฟ้า</div>
                                                </th>
                                                <th rowspan=2>
                                                    <div align="center">ลูกค้า</div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>หน้า</th>
                                                <th>นอน</th>
                                                <th>ระเบียง</th>
                                                <th>Mailbox</th>
                                                <th>คีย์การ์ด</th>
                                                <th>P</th>
                                                <th>B</th>
                                                <th>C</th>

                                                <th>เตียง</th>
                                                <th>เครื่องนอน</th>
                                                <th>ม่านห้องนอน</th>
                                                <th>ม่านห้องรับแขก</th>
                                                <th>ตู้เสื้อผ้า</th>
                                                <th>โซฟา</th>
                                                <th>โต๊ะวางโทรทัศน์</th>
                                                <th>โต๊ะกินข้าว</th>
                                                <th>โต๊ะกลาง</th>
                                                <th>เก้าอี้ 2 ตัว</th>

                                                <th>แอร์ห้องนอน</th>
                                                <th>แอร์ห้องรับแขก</th>
                                                <th>เครื่องทำน้ำอุ่น</th>
                                                <th>ทีวี</th>
                                                <th>ตู้เย็น</th>
                                                <th>ไมโครเวฟ</th>
                                                <th>เครื่องซักผ้า</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- @foreach ($result as $key=>$data) --}}
                                                <tr>
                                                    {{-- <td>{{ $key + 1 }}</td>
                                                    <td>{{ $data->Project_Name }}</td> --}}
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

                                                    <td></td>
                                                </tr>
                                            {{-- @endforeach --}}
                                        </tbody>
                                        <tfoot class="table-success">
                                            <tr align=center>
                                                <th colspan=4>Total</th>
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
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
            $('#my-table').DataTable({
                'paging': false,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': false,
                'autoWidth': false,
                "responsive": true,
                "columnDefs": [{
                    "orderable": false,
                    "targets": [0, 1, 2, 3]
                }]
            });
        });
    </script>
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

            $('#startdate').on('changeDate', function(e) {
                var selectedStartDate = e.date;
                $('#enddate').datepicker('setStartDate', selectedStartDate);
            });
        });
    </script>
@endpush
