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
                                            <label>เลือกประเภทวันที่</label>
                                            <select name="dateselect" id="dateselect" class="form-control">
                                                <option value="all">ทั้งหมด</option>
                                                <option value="transfer_date">วันรับห้อง</option>
                                                <option value="Guarantee_Startdate">วันเริ่มการันตี</option>
                                                <option value="Guarantee_Enddate">วันสิ้นสุดการันตี</option>
                                                <option value="Contract_Startdate">วันเริ่มเช่า</option>
                                                <option value="Payment_date">วันชำระเงินค่าเช่า</option>
                                                <option value="Cancle_Date">วันออก</option>
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
                                            <input class="form-control" name="Owner" type="text" value=""
                                                placeholder="ชื่อลูกค้า" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>ชื่อคนเช่า</label>
                                            <input class="form-control" name="Cusmoter" type="text" value=""
                                                placeholder="ชื่อคนเช่า" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">สถานะห้อง</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="all">สถานะห้อง ทั้งหมด</option>
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
                                            <select name="typerent" id="typerent" class="form-control">
                                                <option value="all">ประเภท ทั้งหมด</option>
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
                                    <h3 class="card-title">จำนวน <b class="text-red">{{ $rentsCount }}</b> Asset ห้องเช่า </h3>
                                </div>
                                <div class="card-body">
                                    <table id="my-table" class="display table table-bordered table-font table-sm"
                                        style="width:100%">
                                        <thead class="table-success">
                                            <tr>
                                                <th rowspan=2>
                                                    <div align="center">No.</div>
                                                </th>
                                                <th rowspan=2 width="6%">
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
                                                <th rowspan=2 width="9%">
                                                    <div align="center" >ลูกค้า</div>
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
                                            @php
                                                $sum_key_front = 0;
                                                $sum_Key_bed = 0;
                                                $sum_Key_balcony = 0;
                                                $sum_Key_mailbox = 0;
                                                $sum_KeyCard = 0;
                                                $sum_KeyCard_P = 0;
                                                $sum_KeyCard_B = 0;
                                                $sum_KeyCard_C = 0;
                                                $sum_Bed = 0;
                                                $sum_Beding = 0;
                                                $sum_Bedroom_Curtain = 0;
                                                $sum_Livingroom_Curtain = 0;
                                                $sum_Wardrobe = 0;
                                                $sum_Sofa = 0;
                                                $sum_TV_Table = 0;
                                                $sum_Dining_Table = 0;
                                                $sum_Center_Table = 0;
                                                $sum_Chair = 0;
                                                $sum_Bedroom_Air = 0;
                                                $sum_Livingroom_Air = 0;
                                                $sum_Water_Heater = 0;
                                                $sum_TV = 0;
                                                $sum_Refrigerator = 0;
                                                $sum_microwave = 0;
                                                $sum_wash_machine = 0;
                                            @endphp
                                            @foreach ($rents as $item)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $item->Project_Name }}</td>
                                                    <td>{{ $item->RoomNo }}</td>
                                                    <td>{{ $item->HomeNo }}</td>

                                                    <td class="text-center">{{ $item->Key_front }}</td>
                                                    <td class="text-center">{{ $item->Key_bed }}</td>
                                                    <td class="text-center">{{ $item->Key_balcony }}</td>
                                                    <td class="text-center">{{ $item->Key_mailbox }}</td>
                                                    <td class="text-center">{{ $item->KeyCard }}</td>
                                                    <td class="text-center">{{ $item->KeyCard_P }}</td>
                                                    <td class="text-center">{{ $item->KeyCard_B }}</td>
                                                    <td class="text-center">{{ $item->KeyCard_C }}</td>

                                                    <td class="text-center">{{ $item->Bed }}</td>
                                                    <td class="text-center">{{ $item->Beding }}</td>
                                                    <td class="text-center">{{ $item->Bedroom_Curtain }}</td>
                                                    <td class="text-center">{{ $item->Livingroom_Curtain }}</td>
                                                    <td class="text-center">{{ $item->Wardrobe }}</td>
                                                    <td class="text-center">{{ $item->Sofa }}</td>
                                                    <td class="text-center">{{ $item->TV_Table }}</td>
                                                    <td class="text-center">{{ $item->Dining_Table }}</td>
                                                    <td class="text-center">{{ $item->Center_Table }}</td>
                                                    <td class="text-center">{{ $item->Chair }}</td>

                                                    <td class="text-center">{{ $item->Bedroom_Air }}</td>
                                                    <td class="text-center">{{ $item->Livingroom_Air }}</td>
                                                    <td class="text-center">{{ $item->Water_Heater }}</td>
                                                    <td class="text-center">{{ $item->TV }}</td>
                                                    <td class="text-center">{{ $item->Refrigerator }}</td>
                                                    <td class="text-center">{{ $item->microwave }}</td>
                                                    <td class="text-center">{{ $item->wash_machine }}</td>

                                                    <td>{{ $item->Owner }}</td>
                                                </tr>
                                                @php
                                                    if ($item->Key_front) {
                                                        $sum_key_front += (int)$item->Key_front;
                                                    }
                                                    if ($item->Key_bed) {
                                                        $sum_Key_bed += (int)$item->Key_bed;
                                                    }
                                                    if ($item->Key_balcony) {
                                                        $sum_Key_balcony += (int)$item->Key_balcony;
                                                    }
                                                    if ($item->Key_mailbox) {
                                                        $sum_Key_mailbox += (int)$item->Key_mailbox;
                                                    }
                                                    if ($item->KeyCard) {
                                                        $sum_KeyCard += (int)$item->KeyCard;
                                                    }
                                                    if ($item->KeyCard_P) {
                                                        $sum_KeyCard_P += (int)$item->KeyCard_P;
                                                    }
                                                    if ($item->KeyCard_B) {
                                                        $sum_KeyCard_B += (int)$item->KeyCard_B;
                                                    }
                                                    if ($item->KeyCard_C) {
                                                        $sum_KeyCard_C += (int)$item->KeyCard_C;
                                                    }
                                                    if ($item->Bed) {
                                                        $sum_Bed += (int)$item->Bed;
                                                    }
                                                    if ($item->Beding) {
                                                        $sum_Beding += (int)$item->Beding;
                                                    }
                                                    if ($item->Bedroom_Curtain) {
                                                        $sum_Bedroom_Curtain += (int)$item->Bedroom_Curtain;
                                                    }
                                                    if ($item->Livingroom_Curtain) {
                                                        $sum_Livingroom_Curtain += (int)$item->Livingroom_Curtain;
                                                    }
                                                    if ($item->Wardrobe) {
                                                        $sum_Wardrobe += (int)$item->Wardrobe;
                                                    }
                                                    if ($item->Sofa) {
                                                        $sum_Sofa += (int)$item->Sofa;
                                                    }
                                                    if ($item->TV_Table) {
                                                        $sum_TV_Table += (int)$item->TV_Table;
                                                    }
                                                    if ($item->Dining_Table) {
                                                        $sum_Dining_Table += (int)$item->Dining_Table;
                                                    }
                                                    if ($item->Center_Table) {
                                                        $sum_Center_Table += (int)$item->Center_Table;
                                                    }
                                                    if ($item->Chair) {
                                                        $sum_Chair += (int)$item->Chair;
                                                    }
                                                    if ($item->Bedroom_Air) {
                                                        $sum_Bedroom_Air += (int)$item->Bedroom_Air;
                                                    }
                                                    if ($item->Livingroom_Air) {
                                                        $sum_Livingroom_Air += (int)$item->Livingroom_Air;
                                                    }
                                                    if ($item->Water_Heater) {
                                                        $sum_Water_Heater += (int)$item->Water_Heater;
                                                    }
                                                    if ($item->TV) {
                                                        $sum_TV += (int)$item->TV;
                                                    }
                                                    if ($item->Refrigerator) {
                                                        $sum_Refrigerator += (int)$item->Refrigerator;
                                                    }
                                                    if ($item->microwave) {
                                                        $sum_microwave += (int)$item->microwave;
                                                    }
                                                    if ($item->wash_machine) {
                                                        $sum_wash_machine += (int)$item->wash_machine;
                                                    }
                                                @endphp
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-success">
                                            <tr align=center>
                                                <th colspan=4>Total</th>
                                                <td>{{$sum_key_front}}</td>
                                                <td>{{$sum_Key_bed}}</td>
                                                <td>{{$sum_Key_balcony}}</td>
                                                <td>{{$sum_Key_mailbox}}</td>
                                                <td>{{$sum_KeyCard}}</td>
                                                <td>{{$sum_KeyCard_P}}</td>
                                                <td>{{$sum_KeyCard_B}}</td>
                                                <td>{{$sum_KeyCard_C}}</td>
                                                <td>{{$sum_Bed}}</td>
                                                <td>{{$sum_Beding}}</td>
                                                <td>{{$sum_Bedroom_Curtain}}</td>
                                                <td>{{$sum_Livingroom_Curtain}}</td>
                                                <td>{{$sum_Wardrobe}}</td>
                                                <td>{{$sum_Sofa}}</td>
                                                <td>{{$sum_TV_Table}}</td>
                                                <td>{{$sum_Dining_Table}}</td>
                                                <td>{{$sum_Center_Table}}</td>
                                                <td>{{$sum_Chair}}</td>
                                                <td>{{$sum_Bedroom_Air}}</td>
                                                <td>{{$sum_Livingroom_Air}}</td>
                                                <td>{{$sum_Water_Heater}}</td>
                                                <td>{{$sum_TV}}</td>
                                                <td>{{$sum_Refrigerator}}</td>
                                                <td>{{$sum_microwave}}</td>
                                                <td>{{$sum_wash_machine}}</td>
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
                    "targets": [4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28]
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
