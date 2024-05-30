@extends('layouts.app')

@section('title', 'แดชบอร์ด')

@section('content')

    @push('style')
        <style>
            #table thead th {
                font-size: 13px;
            }

            #table tbody td {
                font-size: 13px;

                vertical-align: middle;
            }

            #badge {
                font-size: 12px;

            }
        </style>
    @endpush


    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">แดชบอร์ด</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2 col-6">
                            <a href="{{ route('main') }}" class="small-box-footer">
                                <div class="small-box bg-gradient-info">
                                    <div class="inner">
                                        <h3>{{ $totalCount }}</h3>
                                        <p>ห้องทั้งหมด</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-building"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-2 col-6">
                            <a href="{{ route('main', ['status' => 'ready']) }}" class="small-box-footer">
                                <div class="small-box bg-gradient-orange">
                                    <div class="inner" style="color: white">
                                        <h3>{{ $readyCount }}</h3>
                                        <p>ห้องพร้อมอยู่</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-home"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-2 col-6">
                            <a href="{{ route('main', ['status' => 'not_ready']) }}" class="small-box-footer">
                                <div class="small-box bg-gradient-gray">
                                    <div class="inner">
                                        <h3>{{ $notReadyCount }}</h3>
                                        <p>ห้องรอคลีน/รอตรวจ/ไม่พร้อมอยู่</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-home"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-2 col-6">
                            <a href="{{ route('main', ['status' => 'occupied']) }}" class="small-box-footer">
                                <div class="small-box bg-gradient-gray-dark">
                                    <div class="inner">
                                        <h3>{{ $occupiedCount }}</h3>
                                        <p>ห้องสวัสดิการ/ห้องออฟฟิต</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-home"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-2 col-6">
                            <a href="{{ route('main', ['status' => 'already']) }}" class="small-box-footer">
                                <div class="small-box bg-gradient-success">
                                    <div class="inner">
                                        <h3>{{ $alreadyCount }}</h3>
                                        <p>ห้องอยู่แล้ว</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-home"></i>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-sm-1"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header ui-sortable-handle" style="cursor: move;">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                ตารางกราฟ
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <!-- Morris chart - Sales -->
                                <div class="chart tab-pane active" id="revenue-chart"
                                    style="position: relative; height: 300px;">
                                    <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                                </div>
                                <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                                    <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header ui-sortable-handle" style="cursor: move;">
                            <h3 class="card-title">
                                <i class="fa-solid fa-chart-simple"></i>
                                ตารางกราฟ
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <!-- Morris chart - Sales -->
                                <div class="chart tab-pane active" style="position: relative; height: 300px;">
                                    <canvas id="barChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 688px;"
                                        width="1376" height="500" class="chartjs-render-monitor"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-outline card-lightblue">
                            <h3 class="card-title text-danger">
                                ห้องทั้งหมด {{ COUNT($rents) }} รายการ
                            </h3>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="table" class="table table-sm text-center table-striped ">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th width="10%">โครงการ</th>
                                        <th>บ้านเลขที่</th>
                                        <th>เลขที่สัญญาเจ้าของ</th>
                                        <th width="15%">ลูกค้า</th>
                                        <th>ประเภทห้องเช่า</th>
                                        <th>สถานะห้องเช่า</th>
                                        <th>สถานะการเช่า</th>
                                        <th width="10%">วันสิ้นสุดสัญญา<sup>(เจ้าของห้อง)</sup></th>
                                        <th width="10%">วันสิ้นสุดสัญญา<sup>(ผู้เช่า)</sup></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($status == 'ready')
                                        @foreach ($rents as $key => $room)
                                            @if ($room->Status_Room == 'พร้อมอยู่')
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $room->Project_Name }}</td>
                                                    <td>{{ $room->HomeNo }}</td>
                                                    <td>{{ $room->contract_owner }}</td>
                                                    <td>{{ $room->Owner }}</td>
                                                    <td>
                                                        <div
                                                            class="text-bold h6 {{ $room->rental_status == 'การันตี' ? 'text-green' : '' }} {{ $room->rental_status == 'ฝากต่อหักภาษี' ? 'text-sky' : '' }} {{ $room->rental_status == 'ฝากต่อไม่หักภาษี' ? 'text-gray' : '' }} {{ $room->rental_status == 'เบิกจ่ายล่วงหน้า' ? 'text-yellow' : '' }} {{ $room->rental_status == 'ฝากเช่า' ? 'text-blue' : '' }}">
                                                            {{ $room->rental_status }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="text-bold h6 {{ $room->Status_Room == 'อยู่แล้ว' ? 'text-green' : '' }} {{ $room->Status_Room == 'พร้อมอยู่' ? 'text-orange' : '' }} {{ $room->Status_Room == 'จอง' ? 'text-yellow' : '' }} {{ $room->Status_Room == 'ไม่พร้อมอยู่' ? 'text-gray' : '' }} {{ $room->Status_Room == 'รอคลีน' ? 'text-gray' : '' }} {{ $room->Status_Room == 'รอตรวจ' ? 'text-gray' : '' }} {{ $room->Status_Room == 'รอเฟอร์' ? 'text-gray' : '' }} {{ $room->Status_Room == 'ห้องตัวอย่าง' ? 'text-sky' : '' }} {{ $room->Status_Room == 'ห้องออฟฟิต' ? 'text-sky' : '' }} ">
                                                            {{ $room->Status_Room }}
                                                        </div>
                                                    </td>
                                                    <td>{{ $room->Contract_Status }}</td>
                                                    <td>
                                                        @if ($room->date_endrend)
                                                            {{ date('d/m/Y', strtotime($room->date_endrend)) }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($room->Contract_Enddate)
                                                            {{ date('d/m/Y', strtotime($room->Contract_Enddate)) }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @elseif($status == 'not_ready')
                                        @foreach ($rents as $key => $room)
                                            @if (in_array($room->Status_Room, ['ไม่พร้อมอยู่', 'รอคลีน', 'รอตรวจ', 'รอเฟอร์']))
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $room->Project_Name }}</td>
                                                    <td>{{ $room->HomeNo }}</td>
                                                    <td>{{ $room->contract_owner }}</td>
                                                    <td>{{ $room->Owner }}</td>
                                                    <td>
                                                        <div
                                                            class="text-bold h6 {{ $room->rental_status == 'การันตี' ? 'text-green' : '' }} {{ $room->rental_status == 'ฝากต่อหักภาษี' ? 'text-sky' : '' }} {{ $room->rental_status == 'ฝากต่อไม่หักภาษี' ? 'text-gray' : '' }} {{ $room->rental_status == 'เบิกจ่ายล่วงหน้า' ? 'text-yellow' : '' }} {{ $room->rental_status == 'ฝากเช่า' ? 'text-blue' : '' }}">
                                                            {{ $room->rental_status }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="text-bold h6 {{ $room->Status_Room == 'อยู่แล้ว' ? 'text-green' : '' }} {{ $room->Status_Room == 'พร้อมอยู่' ? 'text-orange' : '' }} {{ $room->Status_Room == 'จอง' ? 'text-yellow' : '' }} {{ $room->Status_Room == 'ไม่พร้อมอยู่' ? 'text-gray' : '' }} {{ $room->Status_Room == 'รอคลีน' ? 'text-gray' : '' }} {{ $room->Status_Room == 'รอตรวจ' ? 'text-gray' : '' }} {{ $room->Status_Room == 'รอเฟอร์' ? 'text-gray' : '' }} {{ $room->Status_Room == 'ห้องตัวอย่าง' ? 'text-sky' : '' }} {{ $room->Status_Room == 'ห้องออฟฟิต' ? 'text-sky' : '' }} ">
                                                            {{ $room->Status_Room }}
                                                        </div>
                                                    </td>
                                                    <td>{{ $room->Contract_Status }}</td>
                                                    <td>
                                                        @if ($room->date_endrend)
                                                            {{ date('d/m/Y', strtotime($room->date_endrend)) }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($room->Contract_Enddate)
                                                            {{ date('d/m/Y', strtotime($room->Contract_Enddate)) }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @elseif($status == 'occupied')
                                        @foreach ($rents as $key => $room)
                                            @if (in_array($room->Status_Room, ['สวัสดิการ', 'ห้องออฟฟิต', 'เช่าอยู่', 'อยู่แล้ว']))
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $room->Project_Name }}</td>
                                                    <td>{{ $room->HomeNo }}</td>
                                                    <td>{{ $room->contract_owner }}</td>
                                                    <td>{{ $room->Owner }}</td>
                                                    <td>
                                                        <div
                                                            class="text-bold h6 {{ $room->rental_status == 'การันตี' ? 'text-green' : '' }} {{ $room->rental_status == 'ฝากต่อหักภาษี' ? 'text-sky' : '' }} {{ $room->rental_status == 'ฝากต่อไม่หักภาษี' ? 'text-gray' : '' }} {{ $room->rental_status == 'เบิกจ่ายล่วงหน้า' ? 'text-yellow' : '' }} {{ $room->rental_status == 'ฝากเช่า' ? 'text-blue' : '' }}">
                                                            {{ $room->rental_status }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="text-bold h6 {{ $room->Status_Room == 'อยู่แล้ว' ? 'text-green' : '' }} {{ $room->Status_Room == 'พร้อมอยู่' ? 'text-orange' : '' }} {{ $room->Status_Room == 'จอง' ? 'text-yellow' : '' }} {{ $room->Status_Room == 'ไม่พร้อมอยู่' ? 'text-gray' : '' }} {{ $room->Status_Room == 'รอคลีน' ? 'text-gray' : '' }} {{ $room->Status_Room == 'รอตรวจ' ? 'text-gray' : '' }} {{ $room->Status_Room == 'รอเฟอร์' ? 'text-gray' : '' }} {{ $room->Status_Room == 'ห้องตัวอย่าง' ? 'text-sky' : '' }} {{ $room->Status_Room == 'ห้องออฟฟิต' ? 'text-sky' : '' }} ">
                                                            {{ $room->Status_Room }}
                                                        </div>
                                                    </td>
                                                    <td>{{ $room->Contract_Status }}</td>
                                                    <td>
                                                        @if ($room->date_endrend)
                                                            {{ date('d/m/Y', strtotime($room->date_endrend)) }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($room->Contract_Enddate)
                                                            {{ date('d/m/Y', strtotime($room->Contract_Enddate)) }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @elseif($status == 'already')
                                        @foreach ($rents as $key => $room)
                                            @if ($room->Status_Room == 'อยู่แล้ว')
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $room->Project_Name }}</td>
                                                    <td>{{ $room->HomeNo }}</td>
                                                    <td>{{ $room->contract_owner }}</td>
                                                    <td>{{ $room->Owner }}</td>
                                                    <td>
                                                        <div
                                                            class="text-bold h6 {{ $room->rental_status == 'การันตี' ? 'text-green' : '' }} {{ $room->rental_status == 'ฝากต่อหักภาษี' ? 'text-sky' : '' }} {{ $room->rental_status == 'ฝากต่อไม่หักภาษี' ? 'text-gray' : '' }} {{ $room->rental_status == 'เบิกจ่ายล่วงหน้า' ? 'text-yellow' : '' }} {{ $room->rental_status == 'ฝากเช่า' ? 'text-blue' : '' }}">
                                                            {{ $room->rental_status }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="text-bold h6 {{ $room->Status_Room == 'อยู่แล้ว' ? 'text-green' : '' }} {{ $room->Status_Room == 'พร้อมอยู่' ? 'text-orange' : '' }} {{ $room->Status_Room == 'จอง' ? 'text-yellow' : '' }} {{ $room->Status_Room == 'ไม่พร้อมอยู่' ? 'text-gray' : '' }} {{ $room->Status_Room == 'รอคลีน' ? 'text-gray' : '' }} {{ $room->Status_Room == 'รอตรวจ' ? 'text-gray' : '' }} {{ $room->Status_Room == 'รอเฟอร์' ? 'text-gray' : '' }} {{ $room->Status_Room == 'ห้องตัวอย่าง' ? 'text-sky' : '' }} {{ $room->Status_Room == 'ห้องออฟฟิต' ? 'text-sky' : '' }} ">
                                                            {{ $room->Status_Room }}
                                                        </div>
                                                    </td>
                                                    <td>{{ $room->Contract_Status }}</td>
                                                    <td>
                                                        @if ($room->date_endrend)
                                                            {{ date('d/m/Y', strtotime($room->date_endrend)) }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($room->Contract_Enddate)
                                                            {{ date('d/m/Y', strtotime($room->Contract_Enddate)) }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach ($rents as $key => $room)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $room->Project_Name }}</td>
                                                <td>{{ $room->HomeNo }}</td>
                                                <td>{{ $room->contract_owner }}</td>
                                                <td>{{ $room->Owner }}</td>
                                                <td>
                                                    <div
                                                        class="text-bold h6 {{ $room->rental_status == 'การันตี' ? 'text-green' : '' }} {{ $room->rental_status == 'ฝากต่อหักภาษี' ? 'text-sky' : '' }} {{ $room->rental_status == 'ฝากต่อไม่หักภาษี' ? 'text-gray' : '' }} {{ $room->rental_status == 'เบิกจ่ายล่วงหน้า' ? 'text-yellow' : '' }} {{ $room->rental_status == 'ฝากเช่า' ? 'text-blue' : '' }}">
                                                        {{ $room->rental_status }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div
                                                        class="text-bold h6 {{ $room->Status_Room == 'อยู่แล้ว' ? 'text-green' : '' }} {{ $room->Status_Room == 'พร้อมอยู่' ? 'text-orange' : '' }} {{ $room->Status_Room == 'จอง' ? 'text-yellow' : '' }} {{ $room->Status_Room == 'ไม่พร้อมอยู่' ? 'text-gray' : '' }} {{ $room->Status_Room == 'รอคลีน' ? 'text-gray' : '' }} {{ $room->Status_Room == 'รอตรวจ' ? 'text-gray' : '' }} {{ $room->Status_Room == 'รอเฟอร์' ? 'text-gray' : '' }} {{ $room->Status_Room == 'ห้องตัวอย่าง' ? 'text-sky' : '' }} {{ $room->Status_Room == 'ห้องออฟฟิต' ? 'text-sky' : '' }} ">
                                                        {{ $room->Status_Room }}
                                                    </div>
                                                </td>
                                                <td>{{ $room->Contract_Status }}</td>
                                                <td>
                                                    @if ($room->date_endrend)
                                                        {{ date('d/m/Y', strtotime($room->date_endrend)) }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($room->Contract_Enddate)
                                                        {{ date('d/m/Y', strtotime($room->Contract_Enddate)) }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
                'ordering': false,
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
        document.addEventListener('DOMContentLoaded', (event) => {
            // Revenue Chart
            var ctxRevenue = document.getElementById('revenue-chart-canvas').getContext('2d');
            var revenueChart = new Chart(ctxRevenue, {
                type: 'line', // กำหนดประเภทของกราฟ
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                    datasets: [{
                        label: 'Revenue',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [28, 48, 40, 19, 86, 27, 90]
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: false,
                            }
                        }],
                        yAxes: [{
                            gridLines: {
                                display: false,
                            }
                        }]
                    }
                }
            });

            // Sales Chart
            var ctxSales = document.getElementById('sales-chart-canvas').getContext('2d');
            var salesChart = new Chart(ctxSales, {
                type: 'bar', // กำหนดประเภทของกราฟ
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                    datasets: [{
                        label: 'Sales',
                        backgroundColor: 'rgba(210, 214, 222, 1)',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(210, 214, 222, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: [65, 59, 80, 81, 56, 55, 40]
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: false,
                            }
                        }],
                        yAxes: [{
                            gridLines: {
                                display: false,
                            }
                        }]
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Getting the context of the canvas
            var ctx = document.getElementById('barChart').getContext('2d');

            // Creating a bar chart
            var barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                    datasets: [{
                        label: 'Sales',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        data: [65, 59, 80, 81, 56, 55, 40]
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: false,
                            }
                        }],
                        yAxes: [{
                            gridLines: {
                                display: false,
                            }
                        }]
                    }
                }
            });
        });
    </script>
@endpush
