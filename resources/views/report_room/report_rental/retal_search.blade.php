@extends('layouts.app')

@section('title', 'แดชบอร์ด')

@section('content')
    <style>
        input[type="date"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin: auto;
        }
    </style>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        SummaryRental

                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('main') }}">Home</a></li>
                        <li class="breadcrumb-item active">SummaryRental</li>
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
                            <h3 class="card-title">ค้นหา SummaryRental</h3>
                        </div>
                        <form action="{{ route('report.search') }}" method="POST" id="reportSearch">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <div class="form-row">
                                            <div class="col-sm-12 input-wrapper">
                                                <label for="date1">วันที่</label>
                                                <input type="date" name="date1" id="date1"
                                                    value="{{ $date1 }}">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                                <br>
                                <div class="box-footer text-center">
                                    <button type="submit" name="search" class="btn bg-gradient-success"><i
                                            class="fa fa-search"></i>
                                        ค้นหา</button>
                                    <a href="{{ route('report.rental') }}" type="button" class="btn bg-gradient-danger"><i
                                            class="fa fa-refresh"></i> เคลียร์</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">จำนวน <b class="text-red">{{ COUNT($requests) }}</b>
                                        SummaryRental
                                        <button id="export-btn" class="btn btn-success"><i class="fa fa-file-excel"
                                            aria-hidden="true"></i> Export Excel</button>
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <table id="my-table" class="display table table-bordered table-font table-sm"
                                        style="width:100%">
                                            <tr class="table-success">
                                                <th colspan="4" id="th">1.จำนวนห้องเช่าทั้งหมด
                                                    และจำนวนเงินค่าเช่าที่ต้องเก็บได้</th>
                                            </tr>


                                            @php
                                                $totalRoom = 0;
                                                $totalAmount = 0;
                                            @endphp
                                            @foreach ($requests as $data)
                                                <tr>
                                                    <td id="td">ผู้เช่าโครงการ{{ $data->project_name }}</td>
                                                    <td id="td1"> {{ $data->room }} ห้อง</td>
                                                    <td id="td1">เป็นเงิน</td>
                                                    <td id="total">{{ number_format($data->total, 2, '.', ',') }} บาท
                                                    </td>
                                                </tr>
                                                @php
                                                    $totalRoom += $data->room;
                                                    $totalAmount += $data->total;
                                                @endphp
                                            @endforeach
                                            <tr>
                                                <th id="td">รวมห้องเช่าทั้งหมด</th>
                                                <th id="td1">{{ $totalRoom }} ห้อง</th>
                                                <th id="td1">เป็นเงิน</th>
                                                <th id="total">{{ number_format($totalAmount, 2, '.', ',') }} บาท</th>
                                            </tr>

                                            <tr class="table-success">
                                                <th colspan="4" id="th">2.รายละเอียดการชำระ ของลูกค้า</th>
                                            </tr>
                                            @php
                                                $totalRooms = 0;
                                                $totalAmounts = 0;
                                            @endphp
                                            @foreach ($results as $data_total)
                                            <tr>
                                                <td id="td">{{ $data_total->paid }}</td>
                                                <td id="td1">{{ $data_total->room }} ห้อง</td>
                                                <td id="td1">เป็นเงิน</td>
                                                <td id="total">{{ number_format($data_total->total, 2, '.', ',') }} บาท
                                                </td>
                                            </tr>
                                            @php
                                                    $totalRooms += $data_total->room;
                                                    $totalAmounts += $data_total->total;
                                                @endphp
                                            @endforeach
                                            <tr>
                                                <th id="td">รวมห้องเช่าทั้งหมด</th>
                                                <th id="td1">{{ $totalRooms }} ห้อง</th>
                                                <th id="td1">เป็นเงิน</th>
                                                <th id="total">{{ number_format($totalAmounts, 2, '.', ',') }} บาท</th>
                                            </tr>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.6/xlsx.full.min.js"></script>
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
    <script>
        document.getElementById('export-btn').addEventListener('click', function() {
            var table = document.getElementById('my-table');
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
            }), 'SummaryRental_data.xlsx');
        });
    </script>
@endpush
