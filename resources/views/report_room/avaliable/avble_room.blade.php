@extends('layouts.app')

@section('title', 'AvaliableRoom')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Available Room

                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('main') }}">Home</a></li>
                        <li class="breadcrumb-item active">Available Room</li>
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
                            <h3 class="card-title">Available Room
                                @if (COUNT($results))
                                    <button id="export-btn" class="btn btn-success"><i class="fa fa-file-excel"
                                        aria-hidden="true"></i> Export Excel</button>
                                @endif
                            </h3>
                        </div>
                        <div class="card-body">
                            <table id="my-table" class="display table table-bordered table-font table-sm"
                                style="width:100%">
                                <thead class="table-success">
                                    <tr class="text-center">
                                        <th>No.</th>
                                        <th>โครงการ</th>
                                        <th>ฝากเช่า</th>
                                        <th>เบิกจ่ายล่วงหน้า</th>
                                        <th>การันตี</th>
                                        <th>การันตีรับล่วงหน้า</th>
                                        <th>ติดต่อเจ้าของห้องไม่ได้</th>
                                        <th>ฝากต่อหักภาษี</th>
                                        <th>ฝากต่อไม่หักภาษี</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($results as $key=>$data)
                                    <tr>
                                        <td align=center>{{ $key + 1 }}</td>
                                        <td align=center>{{ $data->project_name }}</td>
                                        <td align=center>{{ $data->rental_status1 }}</td>
                                        <td align=center>{{ $data->rental_status2 }}</td>
                                        <td align=center>{{ $data->rental_status3 }}</td>
                                        <td align=center>{{ $data->rental_status4 }}</td>
                                        <td align=center>{{ $data->rental_status5 }}</td>
                                        <td align=center>{{ $data->rental_status6 }}</td>
                                        <td align=center>{{ $data->rental_status7 }}</td>
                                        <td align=center>{{ $data->totalall }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                @php
                                    $rental_status1 = 0;
                                    $rental_status2 = 0;
                                    $rental_status3 = 0;
                                    $rental_status4 = 0;
                                    $rental_status5 = 0;
                                    $rental_status6 = 0;
                                    $rental_status7 = 0;
                                    $totalall       = 0;
                                     foreach ($results as $key => $value) {
                                        $rental_status1 += $value->rental_status1;
                                        $rental_status2 += $value->rental_status2;
                                        $rental_status3 += $value->rental_status3;
                                        $rental_status4 += $value->rental_status4;
                                        $rental_status5 += $value->rental_status5;
                                        $rental_status6 += $value->rental_status6;
                                        $rental_status7 += $value->rental_status7;
                                        $totalall       += $value->totalall;

                                     }
                                @endphp
                                <tfoot class="table-success">
                                    <tr>
                                        <td colspan="2" align="center">Total</td>
                                        <td align=center>{{ $rental_status1 }}</td>
                                        <td align=center>{{ $rental_status2 }}</td>
                                        <td align=center>{{ $rental_status3 }}</td>
                                        <td align=center>{{ $rental_status4 }}</td>
                                        <td align=center>{{ $rental_status5 }}</td>
                                        <td align=center>{{ $rental_status6 }}</td>
                                        <td align=center>{{ $rental_status7 }}</td>
                                        <td align=center>{{ $totalall }}</td>
                                    </tr>
                                </tfoot>
                            </table>
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
                    "targets": [0, 2, 3, 4, 5, 6, 7, 8, 9]
                }]
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
            }), 'Available_data.xlsx');
        });
    </script>
@endpush
