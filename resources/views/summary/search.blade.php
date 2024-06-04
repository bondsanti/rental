@extends('layouts.app')

@section('title', 'รายงานสรุป ค่าจอง/ค่าประกัน')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">รายงานสรุป ค่าจอง/ค่าประกัน (ห้องเช่า)</h1>
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
                            <h3 class="card-title">ค้นหาค่าจอง/ค่าประกัน </h3>
                        </div>
                        <form action="{{ route('summary.booking.search')}}" method="POST" id="contractSearch">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4"> 
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>วันที่</label>
                                                <input class="form-control datepicker" name="monthly" id="monthly"
                                                type="text" value="{{ $monthly ?? ''}}" placeholder="วันที่"
                                                autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="col-sm-4"> 
                                    </div>

                                </div>
                               
                                <div class="box-footer text-center">
                                    <button type="submit" class="btn bg-gradient-success"><i class="fa fa-search"></i>
                                        ค้นหา</button>
                                    <a href="{{ route('summary.booking') }}" type="button" class="btn bg-gradient-danger"><i
                                            class="fa fa-refresh"></i> เคลียร์</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-info btn-block">
                                <h4 class="mt-2"><i class="fa fa-exclamation"></i> กรุณา ค้นหา ค่าจอง/ค่าประกัน</h4>
                            </button>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header card-outline card-info">
                                    <h3 class="card-title">ข้อมูลรายงานสรุป ค่าจอง/ค่าประกัน</b></h3>
        
                                </div>
                                <div class="card-body">
                                    <table id="table" class="table table-hover table-striped text-center ">
                                        <thead>
                                            <tr>
                                                <th class="h6 text-bold">No</th>
                                                <th class="h6 text-bold" width="10%">โครงการ</th>
                                                <th class="h6 text-bold">ห้องที่ทำสัญญา</th>
                                                <th class="h6 text-bold">ค่าจอง</th>
                                                <th class="h6 text-bold">ค่าประกัน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $total = 0;
                                                $rent = 0;
                                            @endphp
                                            @foreach ($results as $item)
                                                @php
                                                    $total += $item->deposit1;
                                                    $rent += $item->bail1;
                                                @endphp
                                                <tr>
                                                        <td>
                                                            <div class="h6 text-bold">{{ $loop->index + 1 }}</div>
                                                        </td>
                                                        <td>
                                                            <div class="h6 text-bold">{{ $item->Project_Name }}</div>
                                                        </td>
                                                        <td>
                                                            <div class="h6 text-bold">{{ number_format($item->amtroom) }}</div>
                                                        </td>
                                                        <td>
                                                            <div class="h6 text-bold">{{ number_format($item->deposit1) }}</div>
                                                        </td>
                                                        <td>
                                                            <div class="h6 text-bold">{{ number_format($item->bail1) }}</div>
                                                        </td>
                                                </tr>                                                
                                            @endforeach
                                            <tr class="bg-green">
                                                <td colspan="3">
                                                    <div class="h6 text-bold text-center">Total</div>
                                                </td>
                                                <td>
                                                    <div class="h6 text-bold">{{ number_format($total) }}</div>
                                                </td>
                                                <td><div class="h6 text-bold">{{ number_format($rent) }}</div></td>
                                            </tr>
                                        </tbody>
        
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

        });
    </script>
@endpush
