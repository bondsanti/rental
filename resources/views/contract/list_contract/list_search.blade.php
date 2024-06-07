@extends('layouts.app')

@section('title', 'ทะเบียนสัญญาเช่า')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">รายละเอียดทะเบียนสัญญา</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-outline card-info">
                            <h3 class="card-title">ค้นหา รายละเอียดทะเบียนสัญญา</h3>
                        </div>
                        <form action="{{ route('list.search') }}" method="POST" id="listSearch">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <div class="form-row">
                                            <div class="col-sm-6">
                                                <label>โครงการ</label>
                                                <select name="pid" id="pid" class="form-control">
                                                    <option value="all" {{ $selectedPid == 'all' ? 'selected' : '' }}>
                                                        โครงการ ทั้งหมด</option>
                                                    @foreach ($projects as $project)
                                                        <option value="{{ $project->pid }}"
                                                            {{ $selectedPid == $project->pid ? 'selected' : '' }}>
                                                            {{ $project->Project_Name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="validationDefault04">ปี</label>
                                                <select class="form-control" name="year">
                                                    <option value="">ทั้งหมด</option>
                                                    @php
                                                        $yearmax = date('Y') + 543;
                                                        $yearmin = '2553';
                                                    @endphp

                                                    @for ($y = $yearmin; $y <= $yearmax; $y++)
                                                        <option value="{{ $y }}"
                                                            {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}
                                                        </option>
                                                    @endfor
                                                </select>
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
                                    <a href="{{ route('contract.list') }}" type="button" class="btn bg-gradient-danger"><i
                                            class="fa fa-refresh"></i> เคลียร์</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">จำนวน <b class="text-red">{{ count($results) }}</b> ทะเบียนสัญญา
                                        @if (count($results))
                                            <button id="export-btn" class="btn btn-success">
                                                <input type="hidden" id="btn_export" value="{{ count($results) }}">
                                                <i class="fa fa-file-excel" aria-hidden="true"></i> Export Excel</button>
                                        @endif
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <table id="my-table" class="display table table-bordered table-font table-sm"
                                        style="width:100%">
                                        <thead class="table-success">
                                            <tr>
                                                <th colspan="11" class="text-center">
                                                    <h5 class="mt-2">สัญญาเช่าช่วง+สัญญาประกันทรัพย์สิน</h5>
                                                </th>
                                                <th colspan="6" class="text-center table-info">
                                                    <h5 class="mt-2">สัญญาเช่า</h5>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="text-center" width="2%">#</th>
                                                <th class="text-center" width="8%">โครงการ</th>
                                                <th class="text-center">ห้องชุด</th>
                                                <th class="text-center">สถานะ</th>
                                                <th class="text-center">วันที่ทำสัญญา</th>
                                                <th class="text-center">เลขที่สัญญาเช่าช่วง</th>
                                                <th class="text-center">เลขที่สัญญาประกันทรัพย์สิน</th>
                                                <th class="text-center">วันเริ่มสัญญา</th>
                                                <th class="text-center">วันครบสัญญา</th>
                                                <th class="text-center" width="10%">ผู้เช่าช่วง</th>
                                                <th class="text-center">ค่าเช่าต่อเดือน</th>

                                                <th class="text-center table-info">วันที่ทำสัญญา</th>
                                                <th class="text-center table-info">เลขที่สัญญาเช่า</th>
                                                <th class="text-center table-info">วันเริ่มสัญญา</th>
                                                <th class="text-center table-info">วันครบสัญญา</th>
                                                <th class="text-center table-info" width="11%">เจ้าของห้อง</th>
                                                <th class="text-center table-info">ค่าเช่าต่อเดือน</th>

                                            </tr>
                                        </thead>
                                        @if ($results->isEmpty())
                                            <tbody>
                                                <tr>
                                                    <td colspan="17" class="text-danger">
                                                        <h3>
                                                            <center>ไม่พบข้อมูล</center>
                                                        </h3>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        @else
                                            <tbody>
                                                @foreach ($results as $key => $data)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $data->Project_Name }}</td>
                                                        <td>{{ $data->RoomNo }}</td>
                                                        <td>{{ $data->rental_status }}</td>
                                                        <td>{{ $data->print_contract_cus ? date('Y-m-d', strtotime($data->print_contract_cus)) : '-' }}
                                                        </td>
                                                        <td>{{ $data->code_contract_cus }}</td>
                                                        <td>{{ $data->code_contract_insurance }}</td>
                                                        <td>{{ $data->Contract_Startdate }}</td>
                                                        <td>{{ $data->Contract_Enddate }}</td>
                                                        <td>{{ $data->Cus_Name }}</td>
                                                        <td>{{ number_format($data->Price, 2) }}</td>
                                                        <td>{{ $data->print_contract_owner ? date('Y-m-d', strtotime($data->print_contract_owner)) : '-' }}
                                                        </td>
                                                        <td>{{ $data->code_contract_owner }}</td>
                                                        @if ($data->Guarantee_Startdate != null || $data->Guarantee_Enddate != null)
                                                            <td>{{ $data->Guarantee_Startdate }}
                                                            </td>
                                                            <td>{{ $data->Guarantee_Enddate }}</td>
                                                        @else
                                                            <td>{{ $data->date_firstrend }}</td>
                                                            <td>{{ $data->date_endrend }}</td>
                                                        @endif
                                                        <td>{{ $data->Owner }}</td>
                                                        <td>{{ number_format($data->price, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        @endif
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
                    "targets": [4, 5, 6, 10, 12, 16]
                }]
            });
        });
    </script>
    <script>
        let btn_export = $('#btn_export').val();
        if (btn_export) {
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
                }), 'contract_data.xlsx');
            });
        }
    </script>
@endpush
