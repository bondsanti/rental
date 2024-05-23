@extends('layouts.app')

@section('title', 'สรุปค่าเช่าของห้องเช่า')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">สรุปค่าเช่าของห้องเช่า </h1>
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
                            <h3 class="card-title">ค้นหาค่าเช่าของห้องเช่า </h3>
                        </div>
                        <form action="{{ route('report.rent.search')}}" method="POST" id="contractSearch">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4"> 
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>ประจำเดือน</label>
                                                <select class="form-control" name="monthly" required>
                                                    <option value="">-- เลือก --</option>
                                                    <option value="1" {{ $monthY === 'มกราคม' ? 'selected' : ''}}>มกราคม</option>
                                                    <option value="2" {{ $monthY === 'กุมภาพันธ์' ? 'selected' : ''}}>กุมภาพันธ์</option>
                                                    <option value="3" {{ $monthY === 'มีนาคม' ? 'selected' : ''}}>มีนาคม</option>
                                                    <option value="4" {{ $monthY === 'เมษายน' ? 'selected' : ''}}>เมษายน</option>
                                                    <option value="5" {{ $monthY === 'พฤษภาคม' ? 'selected' : ''}}>พฤษภาคม</option>
                                                    <option value="6" {{ $monthY === 'มิถุนายน' ? 'selected' : ''}}>มิถุนายน</option>
                                                    <option value="7" {{ $monthY === 'กรกฎาคม' ? 'selected' : ''}}>กรกฎาคม</option>
                                                    <option value="8" {{ $monthY === 'สิงหาคม' ? 'selected' : ''}}>สิงหาคม</option>
                                                    <option value="9" {{ $monthY === 'กันยายน' ? 'selected' : ''}}>กันยายน</option>
                                                    <option value="10" {{ $monthY === 'ตุลาคม' ? 'selected' : ''}}>ตุลาคม</option>
                                                    <option value="11" {{ $monthY === 'พฤศจิกายน' ? 'selected' : ''}}>พฤศจิกายน</option>
                                                    <option value="12" {{ $monthY === 'ธันวาคม' ? 'selected' : ''}}>ธันวาคม</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="col-sm-4"> 
                                    </div>

                                </div>
                               
                                <div class="box-footer text-center">
                                    <button type="submit" class="btn bg-gradient-success"><i class="fa fa-search"></i>
                                        ค้นหา</button>
                                    <a href="{{ route('report.rent') }}" type="button" class="btn bg-gradient-danger"><i
                                            class="fa fa-refresh"></i> เคลียร์</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-info btn-block">
                                <h4 class="mt-2"><i class="fa fa-exclamation"></i> กรุณา ค้นหา ค่าเช่าของห้องเช่า</h4>
                            </button>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header card-outline card-info">
                                    <h3 class="card-title">ข้อมูลสรุปค่าเช่าของห้องเช่า ประจำเดือน <span class="text-bold text-green">{{ $monthY ?? ''}}</span></h3>
        
                                </div>
                                <div class="card-body">
                                    <table id="table" class="table table-hover table-striped text-center ">
                                        <thead>
                                            <tr>
                                                <th class="h6 text-bold">No</th>
                                                <th class="h6 text-bold">เดือน</th>
                                                <th class="h6 text-bold" width="10%">โครงการ</th>
                                                <th class="h6 text-bold">ห้องเลขที่</th>
                                                <th class="h6 text-bold">บ้านเลขที่</th>
                                                <th class="h6 text-bold">AR Code</th>
                                                <th class="h6 text-bold">ผู้เช่า</th>
                                                <th class="h6 text-bold">วันเริ่มเช่า</th>
                                                <th class="h6 text-bold">วันหมดสัญญา</th>
                                                <th class="h6 text-bold">ค่าเช่ารายเดือน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reports as $item)
                                                <tr>
                                                    <td>
                                                        <div class="h6 text-bold">{{ $loop->index + 1 }}</div>
                                                    </td>
                                                    <td>
                                                        <div class="h6 text-bold">{{ $item->rental_months }}</div>
                                                    </td>
                                                    <td>
                                                        <div class="h6 text-bold">{{ $item->project }}</div>
                                                    </td>
                                                    <td>
                                                        <div class="h6 text-bold">{{ $item->roomnumber }}</div>
                                                    </td>
                                                    <td>
                                                        <div class="h6 text-bold">{{ $item->housenumber }}</div>
                                                    </td>
                                                    <td>
                                                        <div class="h6 text-green text-bold">{{ $item->arcode }}</div>
                                                    </td>
                                                    <td>
                                                        <div class="h6 text-bold">{{ $item->name }}</div>
                                                    </td>
                                                    <td>
                                                       <div class="h6 text-green text-bold">{{ $item->startdate }}</div>
                                                    </td>
                                                    <td>
                                                        <div class="h6 text-red text-bold">{{ $item->enddate }}</div>
                                                    </td>
                                                    <td>
                                                        <div class="h6 text-blue text-bold">{{ number_format($item->pricemonth) }}</div>
                                                    </td>
                                                </tr>                                                
                                            @endforeach
                                        
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
        });
    </script>
@endpush
