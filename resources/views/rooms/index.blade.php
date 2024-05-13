@extends('layouts.app')

@section('title', 'โครงการ')

@section('content')
<form id="editForm" name="editForm" method="post" action="{{ route('room.store') }}">
    @csrf
    <input type="hidden" name="user_id" value="{{ $dataLoginUser->id }}">
    {{-- @foreach ($rents as $item)
    <input type="hidden" name="room_id" value="{{ $item->rid }}">
    <input type="hidden" name="customer_id" value="{{ $item->id }}"> --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6">
                    {{-- @foreach ($rents as $item) --}}
                    <h1 class="m-0">
                        เพิ่มห้องเช่า
                        {{-- <a href="javascript:void(0);" class="btn bg-gradient-primary " type="button"
                            onclick="goBack();">
                            <i class="fa-solid fa fa-reply"></i> กลับ </a> --}}
                    </h1>
                    {{-- @endforeach --}}
                    

                </div><!-- /.col -->
                <div class="col-md-6 text-right">
                    <div class="form-group">
                        {{-- <a href="https://report.vbeyond.co.th/howto_rent/คู่มือการต่อสัญญาเช่าห้องพัก.pdf"
                            target="_blank" class="btn bg-gradient-warning">
                            <i class="fas fa-file"></i> คู่มือ การต่อสัญญาเช่า
                        </a>
                        <a href="https://report.vbeyond.co.th/howto_rent/อัพเดทระบบAutoเลขที่สัญญา.pdf"
                            target="_blank" class="btn  bg-gradient-primary"><i
                                class="fas fa-file-excel"></i> คู่มือ ระบบ Auto เลขที่สัญญา</a> --}}
                        <button class="btn bg-gradient-success " type="submit"><i
                                    class="fa-solid fa-arrow-up-from-bracket"></i> เพิ่มข้อมูลห้อง</button>
                    </div>
                    
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
            {{-- <form action="{{ route('room.store') }}" method="post" id="searchForm"> --}}
                {{-- @csrf --}}
                <div class="col-md-12">
                    {{-- @foreach ($rents as $item) --}}
                    <div class="card">
                        <div class="card-header card-outline card-info">
                            <h3 class="card-title">รายละเอียดห้อง</h3>
                        </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">

                                        <div class="form-group">
                                            <label><b class="text-danger">*</b> โครงการ</label>
                                            <select name="project_id" id="project_id" class="form-control @error('project_id') is-invalid @enderror">
                                                <option value="">-- เลือก --</option>
                                                @foreach ($projects as $project)
                                                <option value="{{ $project->pid }}"
                                                >
                                                {{ $project->Project_Name }}</option>
                                                @endforeach
                                            </select>
                                            @error('project_id')
                                                    <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><b class="text-danger">*</b> เลขที่บ้านเจ้าของห้อง</label>
                                            <input class="form-control @error('numberhome') is-invalid @enderror" name="numberhome" type="text"
                                                placeholder="เลขที่บ้านเจ้าของ">
                                            @error('numberhome')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><b class="text-danger">*</b> ห้องเลขที่</label>
                                            <input class="form-control @error('RoomNo') is-invalid @enderror" name="RoomNo" type="text"
                                                placeholder="ห้องเลขที่">
                                            @error('RoomNo')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><b class="text-danger">*</b> บ้านเลขที่</label>
                                            <input class="form-control @error('HomeNo') is-invalid @enderror" name="HomeNo" type="text"
                                                placeholder="บ้านเลขที่">
                                            @error('HomeNo')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><b class="text-danger">*</b> เจ้าของห้อง</label>
                                            <input class="form-control @error('onwername') is-invalid @enderror" name="onwername" type="text"
                                                placeholder="เจ้าของห้อง">
                                            @error('onwername')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><b class="text-danger">*</b> บัตรประชาชน</label>
                                            <input class="form-control @error('cardowner') is-invalid @enderror" name="cardowner" type="text"
                                                placeholder="บัตรประชาชน">
                                            @error('cardowner')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>อัปโหลดไฟล์บัตรประชาชน</label>
                                            <input class="form-control" name="filUploadPersonID" type="file" 
                                                placeholder="เลขที่สัญญา">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ซอย</label>
                                            <input class="form-control" name="owner_soi" type="text"
                                                placeholder="ซอย">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ถนน</label>
                                            <input class="form-control" name="owner_road" type="text"
                                                placeholder="ถนน">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><b class="text-danger">*</b> แขวง/ตำบล</label>
                                            <input class="form-control @error('owner_district') is-invalid @enderror" name="owner_district" type="text"
                                                placeholder="แขวง/ตำบล">
                                            @error('owner_district')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><b class="text-danger">*</b> เขต/อำเภอ</label>
                                            <input class="form-control @error('owner_khet') is-invalid @enderror" name="owner_khet" type="text"
                                                placeholder="เขต/อำเภอ">
                                            @error('owner_khet')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><b class="text-danger">*</b> จังหวัด</label>
                                            {{-- <input class="form-control @error('owner_province') is-invalid @enderror" name="owner_province" type="text"
                                                placeholder="จังหวัด"> --}}
                                            <select class="form-control @error('owner_province') is-invalid @enderror" name="owner_province">
                                                <option value="">-- เลือก --</option>
                                                <option value="กรุงเทพมหานคร">กรุงเทพมหานคร</option>
                                                <option value="กระบี่">กระบี่</option>
                                                <option value="กาญจนบุรี">กาญจนบุรี</option>
                                                <option value="กาฬสินธุ์">กาฬสินธุ์</option>
                                                <option value="กำแพงเพชร">กำแพงเพชร</option>
                                                <option value="ขอนแก่น">ขอนแก่น</option>
                                                <option value="จันทบุรี">จันทบุรี</option>
                                                <option value="ฉะเชิงเทรา">ฉะเชิงเทรา</option>
                                                <option value="ชัยนาท">ชัยนาท</option>
                                                <option value="ชัยภูมิ">ชัยภูมิ</option>
                                                <option value="ชุมพร">ชุมพร</option>
                                                <option value="ชลบุรี">ชลบุรี</option>
                                                <option value="เชียงใหม่">เชียงใหม่</option>
                                                <option value="เชียงราย">เชียงราย</option>
                                                <option value="ตรัง">ตรัง</option>
                                                <option value="ตราด">ตราด</option>
                                                <option value="ตาก">ตาก</option>
                                                <option value="นครนายก">นครนายก</option>
                                                <option value="นครปฐม">นครปฐม</option>
                                                <option value="นครพนม">นครพนม</option>
                                                <option value="นครราชสีมา">นครราชสีมา</option>
                                                <option value="นครศรีธรรมราช">นครศรีธรรมราช</option>
                                                <option value="นครสวรรค์">นครสวรรค์</option>
                                                <option value="นราธิวาส">นราธิวาส</option>
                                                <option value="น่าน">น่าน</option>
                                                <option value="นนทบุรี">นนทบุรี</option>
                                                <option value="บึงกาฬ">บึงกาฬ</option>
                                                <option value="บุรีรัมย์">บุรีรัมย์</option>
                                                <option value="ประจวบคีรีขันธ์">ประจวบคีรีขันธ์</option>
                                                <option value="ปทุมธานี">ปทุมธานี</option>
                                                <option value="ปราจีนบุรี">ปราจีนบุรี</option>
                                                <option value="ปัตตานี">ปัตตานี</option>
                                                <option value="พะเยา">พะเยา</option>
                                                <option value="พระนครศรีอยุธยา">พระนครศรีอยุธยา</option>
                                                <option value="พังงา">พังงา</option>
                                                <option value="พิจิตร">พิจิตร</option>
                                                <option value="พิษณุโลก">พิษณุโลก</option>
                                                <option value="เพชรบุรี">เพชรบุรี</option>
                                                <option value="เพชรบูรณ์">เพชรบูรณ์</option>
                                                <option value="แพร่">แพร่</option>
                                                <option value="พัทลุง">พัทลุง</option>
                                                <option value="ภูเก็ต">ภูเก็ต</option>
                                                <option value="มหาสารคาม">มหาสารคาม</option>
                                                <option value="มุกดาหาร">มุกดาหาร</option>
                                                <option value="แม่ฮ่องสอน">แม่ฮ่องสอน</option>
                                                <option value="ยโสธร">ยโสธร</option>
                                                <option value="ยะลา">ยะลา</option>
                                                <option value="ร้อยเอ็ด">ร้อยเอ็ด</option>
                                                <option value="ระนอง">ระนอง</option>
                                                <option value="ระยอง">ระยอง</option>
                                                <option value="ราชบุรี">ราชบุรี</option>
                                                <option value="ลพบุรี">ลพบุรี</option>
                                                <option value="ลำปาง">ลำปาง</option>
                                                <option value="ลำพูน">ลำพูน</option>
                                                <option value="เลย">เลย</option>
                                                <option value="ศรีสะเกษ">ศรีสะเกษ</option>
                                                <option value="สกลนคร">สกลนคร</option>
                                                <option value="สงขลา">สงขลา</option>
                                                <option value="สมุทรสาคร">สมุทรสาคร</option>
                                                <option value="สมุทรปราการ">สมุทรปราการ</option>
                                                <option value="สมุทรสงคราม">สมุทรสงคราม</option>
                                                <option value="สระแก้ว">สระแก้ว</option>
                                                <option value="สระบุรี">สระบุรี</option>
                                                <option value="สิงห์บุรี">สิงห์บุรี</option>
                                                <option value="สุโขทัย">สุโขทัย</option>
                                                <option value="สุพรรณบุรี">สุพรรณบุรี</option>
                                                <option value="สุราษฎร์ธานี">สุราษฎร์ธานี</option>
                                                <option value="สตูล">สตูล</option>
                                                <option value="หนองคาย">หนองคาย</option>
                                                <option value="หนองบัวลำภู">หนองบัวลำภู</option>
                                                <option value="อำนาจเจริญ">อำนาจเจริญ</option>
                                                <option value="อุดรธานี">อุดรธานี</option>
                                                <option value="อุตรดิตถ์">อุตรดิตถ์</option>
                                                <option value="อุทัยธานี">อุทัยธานี</option>
                                                <option value="อุบลราชธานี">อุบลราชธานี</option>
                                                <option value="อ่างทอง">อ่างทอง</option>
                                            </select>
                                            @error('owner_province')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><b class="text-danger">*</b> เบอร์ติดต่อ</label>
                                            <input class="form-control @error('ownerphone') is-invalid @enderror" name="ownerphone" type="text"
                                                placeholder="เบอร์ติดต่อ">
                                            @error('ownerphone')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>วันรับห้อง</label>
                                            <input class="form-control datepicker" name="transfer_date" id="transfer_date"
                                                placeholder="วันรับห้อง">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ประเภทห้อง</label>
                                            <input class="form-control" name="room_type" type="text"
                                                placeholder="ประเภทห้อง">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ขนาดห้อง</label>
                                            <input class="form-control" name="room_size" type="text"
                                                placeholder="ขนาดห้อง">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}
                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ทิศ/ฝั่ง</label>
                                            <input class="form-control" name="Location" type="text"
                                                placeholder="ทิศ/ฝั่ง">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>อาคาร</label>
                                            <input class="form-control" name="Building" type="text"
                                                placeholder="อาคาร">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ชั้น</label>
                                            <input class="form-control" name="Floor" type="text"
                                                placeholder="ชั้น">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>กุญแจ หน้า</label>
                                            <input class="form-control" name="room_key_front" type="text"
                                                placeholder="กุญแจ หน้า">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>กุญแจ นอน</label>
                                            <input class="form-control" name="room_key_bed" type="text"
                                                placeholder="กุญแจ นอน">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>กุญแจ ระเบียง</label>
                                            <input class="form-control" name="room_key_balcony" type="text"
                                                placeholder="กุญแจ ระเบียง">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>กุญแจ Mail Box</label>
                                            <input class="form-control" name="room_key_mailbox" type="text"
                                                placeholder="กุญแจ Mail Box">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>คีย์การ์ด</label>
                                            <input class="form-control" name="room_card" type="text"
                                                placeholder="คีย์การ์ด">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>คีย์การ์ด P</label>
                                            <input class="form-control" name="room_card_p" type="text"
                                                placeholder="คีย์การ์ด P">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>คีย์การ์ด B</label>
                                            <input class="form-control" name="room_card_b" type="text"
                                                placeholder="คีย์การ์ด B">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>คีย์การ์ด C</label>
                                            <input class="form-control" name="room_card_c" type="text"
                                                placeholder="คีย์การ์ด C">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ระยะเริ่มการันตี</label>
                                            <input class="form-control datepicker" name="gauranteestart" id="gauranteestart"
                                                placeholder="ระยะเริ่มการันตี">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ระยะสิ้นสุดการันตี</label>
                                            <input class="form-control datepicker" name="gauranteeend" id="gauranteeend"
                                                placeholder="ระยะสิ้นสุดการันตี">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>จำนวนเงินการันตี</label>
                                            <input class="form-control" name="gauranteeamount" type="text"
                                                placeholder="จำนวนเงินการันตี">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>สถานะห้อง</label>
                                            {{-- <input class="form-control" name="Status_Room" type="text"
                                                placeholder="สถานะห้อง">  --}}
                                                <select class="form-control" name="Status_Room">
                                                    <option value="">-- เลือก --</option>
                                                    <option value="รอตรวจ">รอตรวจ</option>
                                                    <option value="รอเฟอร์">รอเฟอร์</option>
                                                    <option value="รอคลีน">รอคลีน</option>
                                                    <option value="พร้อมอยู่">พร้อมอยู่</option>
                                                    <option value="อยู่แล้ว">อยู่แล้ว</option>
                                                    <option value="ห้องออฟฟิต">ห้องออฟฟิต</option>
                                                    <option value="ห้องตัวอย่าง">ห้องตัวอย่าง</option>
                                                    <option value="จอง">จอง</option>
                                                    <option value="สวัสดิการ">สวัสดิการ</option>
                                                </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>บัญชีแสดงสัญญา</label>
                                            <input class="form-control" name="Electric_Contract" type="text"
                                                placeholder="บัญชีแสดงสัญญา">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>รหัสเครื่องวัดฯ</label>
                                            <input class="form-control" name="Meter_Code" type="text"
                                                placeholder="รหัสเครื่องวัดฯ">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ประเภทห้องเช่า</label>
                                            <select class="form-control"  name="rental_status">
                                                <option value="">-- เลือก --</option>
                                                <option value="การันตี">การันตี</option>
                                                <option value="เบิกจ่ายล่วงหน้า">เบิกจ่ายล่วงหน้า</option>
                                                <option value="ฝากต่อหักภาษี">ฝากต่อหักภาษี</option>
                                                <option value="ฝากต่อไม่หักภาษี">ฝากต่อไม่หักภาษี</option>
                                                <option value="ฝากเช่า">ฝากเช่า</option>
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ราคาค่าเช่าห้อง</label>
                                            <input class="form-control" name="room_price" type="text"
                                                placeholder="ราคาค่าเช่า">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>รูปภาพปก</label>
                                            <input class="form-control" id="filUploadMain" name="filUploadMain" type="file"
                                                placeholder="รูปภาพปก">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>รูปภาพห้อง</label>
                                            <input class="form-control" id="filUpload" name="filUpload[]" type="file"
                                                placeholder="รูปภาพห้อง" multiple="multiple">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}
                                    
                                </div>
                            </div>

                            
                        

                    </div>
                    <div class="card">
                        <div class="card-header card-outline card-info">
                            <h3 class="card-title">เฟอร์นิเจอร์/เครื่องใช้ไฟฟ้า</h3>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-2">
                                    <p>เฟอร์นิเจอร์</p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Bed" type="number" value=""> <b class="ml-2">เตียง</b>
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Beding" type="number" value=""> <b class="ml-2">เครื่องนอน</b>
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Bedroom_Curtain" type="number" value=""> <b class="ml-2">ม่านห้องนอน</b>
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Livingroom_Curtain" type="number" value=""> <b class="ml-2">ม่านห้องรับแขก</b>
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Wardrobe" type="number" value=""> <b class="ml-2">ตู้เสื้อผ้า</b>
                                    </p>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Sofa" type="number" value=""> <b class="ml-2">โซฟา</b>
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_TV_Table" type="number" value=""> <b class="ml-2">โต๊ะวางโทรทัศน์</b>
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Dining_Table" type="number" value=""> <b class="ml-2">โต๊ะกินข้าว</b>
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Center_Table" type="number" value=""> <b class="ml-2">โต๊ะกลาง</b>
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Chair" type="number" value=""> <b class="ml-2">เก้าอี้</b>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <p>เครื่องใช้ไฟฟ้า</p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Bedroom_Air" type="number" value=""> <b class="ml-2">แอร์ห้องนอน</b>
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Livingroom_Air" type="number" value=""> <b class="ml-2">แอร์ห้องรับแขก</b>
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Water_Heater" type="number" value=""> <b class="ml-2">เครื่องทำน้ำอุ่น</b>
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_TV" type="number" value=""> <b class="ml-2">ทีวี</b>
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Refrigerator" type="number" value=""> <b class="ml-2">ตู้เย็น</b>
                                    </p>
                                </div>
                                
                            </div>
                           
                            <div class="row">
                                <div class="col-sm-2">
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_microwave" type="number" value=""> <b class="ml-2">ไมโครเวฟ</b>
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_wash_machine" type="number" value=""> <b class="ml-2">เครื่องซักผ้า</b>
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    {{-- <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="cardowner" type="number"> เครื่องทำน้ำอุ่น
                                    </p> --}}
                                </div>

                                <div class="col-sm-2">
                                    {{-- <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="cardowner" type="number"> ทีวี
                                    </p> --}}
                                </div>

                                <div class="col-sm-2">
                                    {{-- <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="cardowner" type="number"> ตู้เย็น
                                    </p> --}}
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <p>หมายเหตุ</p>
                                </div>
                                <div class="col-sm-2">
                                    <textarea name="Other" id="" cols="33" rows="3"></textarea>
                                </div>
                                <div class="col-sm-2">
                                    {{-- <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="cardowner" type="number" value="{{ $item->Sofa }}"> เครื่องซักผ้า
                                    </p> --}}
                                </div>

                                <div class="col-sm-2">
                                    {{-- <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="cardowner" type="number"> เครื่องทำน้ำอุ่น
                                    </p> --}}
                                </div>

                                <div class="col-sm-2">
                                    {{-- <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="cardowner" type="number"> ทีวี
                                    </p> --}}
                                </div>

                                <div class="col-sm-2">
                                    {{-- <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="cardowner" type="number"> ตู้เย็น
                                    </p> --}}
                                </div>
                                
                            </div>
                        </div>
                    </div>
                
                 {{-- @endforeach --}}
                </div>
            {{-- </form>     --}}
            </div>
            
        </div><!-- /.container-fluid -->
    </section>

    {{-- @endforeach --}}
</form>
@endsection
@push('script')
<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd', // รูปแบบวันที่
            autoclose: true,
        });

        // $('#startdate').on('changeDate', function(e) {
        //     var selectedStartDate = e.date;
        //     $('#enddate').datepicker('setStartDate', selectedStartDate);
        // });
    });
    function goBack() {
        window.history.back();
    }
</script>
@endpush