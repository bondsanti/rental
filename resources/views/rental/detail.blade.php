@extends('layouts.app')

@section('title', 'โครงการ')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">รายละเอียดห้อง

                    </h1>

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
                    <div class="card">
                        <div class="card-header card-outline card-info">
                            <h3 class="card-title">ข้อมูลห้องและข้อมูลการเช่า</h3>

                        </div>
                        {{-- <form action="{{ route('room.search') }}" method="post" id="searchForm"> --}}
                            @csrf
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-sm-3">

                                        <div class="form-group">
                                            <label>โครงการ</label>
                                            {{-- <select name="project_id" id="project_id" class="form-control">
                                                <option value="ทั้งหมด">ทั้งหมด</option>
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                                @endforeach
                                            </select> --}}
                                            <p>{{$rents->Project_Name ?? ''}}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ห้องเลขที่</label>
                                            {{-- <input class="form-control" name="room_address" type="text" value=""
                                                placeholder="ห้องเลขที่"> --}}
                                                <p>{{ $rents->RoomNo ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>บ้านเลขที่</label>
                                            {{-- <input class="form-control" name="address" type="text" value=""
                                                placeholder="บ้านเลขที่"> --}}
                                                <p>{{ $rents->HomeNo ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ประเภทห้อง</label>
                                            {{-- <input class="form-control" name="agent" type="text" value=""
                                                placeholder="MNG"> --}}
                                                <p>{{ $rents->RoomType ?? '' }}</p>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ขนาดห้อง</label>
                                            {{-- <input class="form-control" name="fixseller" type="text" value=""
                                                placeholder="ช่องทางการขาย"> --}}
                                                <p>{{ $rents->Size ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Location</label>
                                            {{-- <input class="form-control" name="startprice" type="number" value=""
                                                placeholder="ราคาเริ่มต้น"> --}}
                                                <p>{{ $rents->Location ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        {{-- <div class="ถึงช่วงราคา-group">
                                            <label>ราคาสิ้นสุด</label>
                                            <input class="form-control" name="endprice" type="number" value=""
                                                placeholder="ถึงช่วงราคา">
                                        </div> --}}
                                        <label>บัญชีแสดงสัญญา</label>
                                        <p>{{ $rents->Electric_Contract ?? '' }}</p>
                                    </div>
                                    <div class="col-sm-3">
                                        {{-- <div class="form-group">
                                            <label>เลือกประเภทวันที่</label>
                                            <select name="dateselect" id="dateselect" class="form-control">
                                                <option value="bid_date">วันที่เสนอราคา</option>
                                                <option value="mortgaged_date">วันที่โอน</option>
                                                <option value="booking_date">วันที่จอง</option>
                                                <option value="contract_date">วันที่ทำสัญญา</option>
                                                <option value="" selected>ทั้งหมด</option>

                                            </select>
                                        </div> --}}
                                        <label>เลขที่สัญญาเจ้าของ</label>
                                        <p>{{ $rents->contract_owner ?? '' }}</p>
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ชื่อลูกค้า</label>
                                            {{-- <input class="form-control" name="user_name" type="text" value=""
                                                placeholder="ชื่อลูกค้า"> --}}
                                                <p>{{ $rents->owner ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>เบอร์โทรศัพท์</label>
                                            {{-- <input class="form-control" name="phone" type="text" value=""
                                                placeholder="เบอร์โทรศัพท์"> --}}
                                                <p>{{ $rents->Phone ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ราคาค่าเช่าห้อง</label>
                                            {{-- <input class="form-control" name="phone" type="text" value=""
                                                placeholder="เบอร์โทรศัพท์"> --}}
                                                <p>{{ $rents->price ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>วันเริ่มสัญญา</label>
                                            {{-- <input class="form-control" name="phone" type="text" value=""
                                                placeholder="เบอร์โทรศัพท์"> --}}
                                                <p>{{ $rents->date_firstrend ?? '' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>วันสิ้นสุดสัญญา</label>
                                            {{-- <input class="form-control" name="phone" type="text" value=""
                                                placeholder="เบอร์โทรศัพท์"> --}}
                                                <p>{{ $rents->date_endrend ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ประเภทห้องเช่า</label>
                                            {{-- <input class="form-control" name="phone" type="text" value=""
                                                placeholder="เบอร์โทรศัพท์"> --}}
                                            <p>{{ $rents->rental_status ?? '' }}</p>    
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Status</label>
                                            {{-- <input class="form-control" name="phone" type="text" value=""
                                                placeholder="เบอร์โทรศัพท์"> --}}
                                                <p>{{ $rents->Status_Room ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>เลขที่สัญญาผู้เช่า</label>
                                            {{-- <input class="form-control" name="phone" type="text" value=""
                                                placeholder="เบอร์โทรศัพท์"> --}}
                                                <p>{{ $rents->contract_cus ?? '' }}</p>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ผู้เช่า</label>
                                            {{-- <input class="form-control" name="phone" type="text" value=""
                                                placeholder="เบอร์โทรศัพท์"> --}}
                                                <p>{{ $rents->Cus_Name ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>	โทร</label>
                                            {{-- <input class="form-control" name="phone" type="text" value=""
                                                placeholder="เบอร์โทรศัพท์"> --}}
                                                <p>{{ $rents->Phone ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ค่าเช่า</label>
                                            {{-- <input class="form-control" name="phone" type="text" value=""
                                                placeholder="เบอร์โทรศัพท์"> --}}
                                                <p>{{ $rents->Price ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>วันเริ่มเช่า</label>
                                            {{-- <input class="form-control" name="phone" type="text" value=""
                                                placeholder="เบอร์โทรศัพท์"> --}}
                                                <p>{{ $rents->Contract_Startdate ?? '' }}</p>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>วันสิ้นสุดสัญญา</label>
                                            {{-- <input class="form-control" name="phone" type="text" value=""
                                                placeholder="เบอร์โทรศัพท์"> --}}
                                                <p>{{ $rents->Contract_Enddate ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>วันออก</label>
                                            {{-- <input class="form-control" name="phone" type="text" value=""
                                                placeholder="เบอร์โทรศัพท์"> --}}
                                                {{-- <p>{{ $rents->Contract_Status }}</p> --}}
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>สถานะการเช่า</label>
                                            {{-- <input class="form-control" name="phone" type="text" value=""
                                                placeholder="เบอร์โทรศัพท์"> --}}
                                                <p>{{ $rents->Contract_Status ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ค่าประกันทรัพย์สิน</label>
                                            {{-- <input class="form-control" name="phone" type="text" value=""
                                                placeholder="เบอร์โทรศัพท์"> --}}
                                                <p>{{ $rents->price_insurance ?? '' }}</p>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        {{-- </form> --}}

                    </div>
                </div>
                
            </div>
            
        </div><!-- /.container-fluid -->
    </section>
@endsection
