@extends('layouts.app')

@section('title', 'โครงการ')

@section('content')
<form id="editForm" name="editForm" method="post" action="{{ route('room.store') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="user_id" value="{{ $dataLoginUser->id }}">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h1 class="m-0">
                        เพิ่มห้องเช่า
                    </h1>
                </div><!-- /.col -->
                <div class="col-md-6 text-right">
                    <div class="form-group">
                        <button class="btn bg-gradient-success " type="submit">
                            <i class="fa-solid fa-arrow-up-from-bracket"></i> เพิ่มข้อมูลห้อง</button>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-outline card-info">
                            <h3 class="card-title">รายละเอียดห้อง</h3>
                        </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><b class="text-danger">*</b> เจ้าของห้อง</label>
                                            <input class="form-control @error('onwername') is-invalid @enderror" name="onwername" type="text"
                                                placeholder="เจ้าของห้อง" value="{{ old('onwername') }}">
                                            @error('onwername')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror         
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><b class="text-danger">*</b> บัตรประชาชน</label>
                                            <input class="form-control @error('cardowner') is-invalid @enderror" name="cardowner" type="text"
                                                placeholder="บัตรประชาชน" value="{{ old('cardowner') }}">
                                            @error('cardowner')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                            {{-- <label><b class="text-danger">*</b> เลขที่บ้านเจ้าของห้อง</label>
                                            <input class="form-control @error('numberhome') is-invalid @enderror" name="numberhome" type="text"
                                                placeholder="เลขที่บ้านเจ้าของ" value="{{ old('numberhome') }}">
                                            @error('numberhome')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror --}}
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>อัปโหลดไฟล์บัตรประชาชน</label>
                                                <input class="form-control" name="filUploadPersonID" type="file" 
                                                    placeholder="เลขที่สัญญา">
                                            </div>      
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><b class="text-danger">*</b> เบอร์ติดต่อ</label>
                                            <input class="form-control @error('ownerphone') is-invalid @enderror" name="ownerphone" type="text"
                                                placeholder="เบอร์ติดต่อ" value="{{ old('ownerphone') }}">
                                            @error('ownerphone')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror    
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><b class="text-danger">*</b> โครงการ</label>
                                            <select name="project_id" id="project_id" class="form-control @error('project_id') is-invalid @enderror">
                                                <option value="">-- เลือก --</option>
                                                @foreach ($projects as $project)
                                                <option value="{{ $project->pid }}" {{ old('project_id') == $project->pid ? 'selected' : '' }}>
                                                    {{ $project->Project_Name }}</option>
                                                @endforeach
                                            </select>
                                            @error('project_id')
                                                    <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><b class="text-danger">*</b> ห้องเลขที่</label>
                                            <input class="form-control @error('RoomNo') is-invalid @enderror" name="RoomNo" type="text"
                                                placeholder="ห้องเลขที่" value="{{ old('RoomNo') }}">
                                            @error('RoomNo')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><b class="text-danger">*</b> บ้านเลขที่</label>
                                            <input class="form-control @error('HomeNo') is-invalid @enderror" name="HomeNo" type="text"
                                                placeholder="บ้านเลขที่" value="{{ old('HomeNo') }}">
                                            @error('HomeNo')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ซอย</label>
                                            <input class="form-control" name="owner_soi" type="text"
                                                placeholder="ซอย" value="{{ old('owner_soi') }}">
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ถนน</label>
                                            <input class="form-control" name="owner_road" type="text"
                                                placeholder="ถนน" value="{{ old('owner_road') }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="owner_province"><b class="text-danger">*</b> จังหวัด</label>
                                            <select name="owner_province" id="owner_province" class="form-control @error('owner_province') is-invalid @enderror">
                                                <option value="">-- เลือก --</option>
                                                @foreach ($provinces as $province)
                                                    <option value="{{ $province->province_id }}"
                                                        {{ $province->province_id == old('owner_province') ? 'selected' : '' }}>
                                                        {{ $province->province }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('owner_province')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="owner_khet"><b class="text-danger">*</b> เขต/อำเภอ</label>
                                            <select name="owner_khet" id="owner_khet" class="form-control @error('owner_khet') is-invalid @enderror">
                                                <option value="">-- เลือก --</option>
                                                @if (old('owner_khet'))
                                                    @foreach ($amphoes as $amphure)
                                                        <option value="{{ $amphure->amphoe_id }}"
                                                            {{ $amphure->amphoe_id == old('owner_khet') ? 'selected' : '' }}>
                                                            {{ $amphure->amphoe }}
                                                        </option>
                                                    @endforeach
                                                @endif    
                                            </select>
                                            @error('owner_khet')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="owner_district"><b class="text-danger">*</b> แขวง/ตำบล</label>
                                            <select name="owner_district" id="owner_district"class="form-control @error('owner_district') is-invalid @enderror">
                                                <option value="">-- เลือก --</option>
                                                @if (old('owner_district'))
                                                    @foreach ($tambons as $district)
                                                        <option value="{{ $district->tambon_id }}"
                                                            {{ $district->tambon_id == old('owner_district') ? 'selected' : '' }}>
                                                            {{ $district->tambon }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('owner_district')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>วันรับห้อง</label>
                                            <input class="form-control datepicker" name="transfer_date" id="transfer_date"
                                                placeholder="วันรับห้อง" value="{{ old('transfer_date') }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ประเภทห้อง</label>
                                            <input class="form-control" name="room_type" type="text"
                                                placeholder="ประเภทห้อง" value="{{ old('room_type') }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ขนาดห้อง</label>
                                            <input class="form-control" name="room_size" type="text"
                                                placeholder="ขนาดห้อง" value="{{ old('room_size') }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ทิศ/ฝั่ง</label>
                                            <input class="form-control" name="Location" type="text"
                                                placeholder="ทิศ/ฝั่ง" value="{{ old('Location') }}">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>อาคาร</label>
                                            <input class="form-control" name="Building" type="text"
                                                placeholder="อาคาร" value="{{ old('Building') }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ชั้น</label>
                                            <input class="form-control" name="Floor" type="text"
                                                placeholder="ชั้น" value="{{ old('Floor') }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="card">
                        <div class="card-header card-outline card-info">
                            <h3 class="card-title">กุญแจ/คีย์การ์ด</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>กุญแจ หน้า</label>
                                        <input class="form-control" name="room_key_front" type="text"
                                            placeholder="กุญแจ หน้า" value="{{ old('room_key_front') }}">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>กุญแจ นอน</label>
                                        <input class="form-control" name="room_key_bed" type="text"
                                            placeholder="กุญแจ นอน" value="{{ old('room_key_bed') }}">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>กุญแจ ระเบียง</label>
                                        <input class="form-control" name="room_key_balcony" type="text"
                                            placeholder="กุญแจ ระเบียง" value="{{ old('room_key_balcony') }}">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>กุญแจ Mail Box</label>
                                        <input class="form-control" name="room_key_mailbox" type="text"
                                            placeholder="กุญแจ Mail Box" value="{{ old('room_key_mailbox') }}">
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>คีย์การ์ด</label>
                                        <input class="form-control" name="room_card" type="text"
                                            placeholder="คีย์การ์ด" value="{{ old('room_card') }}">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>คีย์การ์ด P</label>
                                        <input class="form-control" name="room_card_p" type="text"
                                            placeholder="คีย์การ์ด P" value="{{ old('room_card_p') }}">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>คีย์การ์ด B</label>
                                        <input class="form-control" name="room_card_b" type="text"
                                            placeholder="คีย์การ์ด B" value="{{ old('room_card_b') }}">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>คีย์การ์ด C</label>
                                        <input class="form-control" name="room_card_c" type="text"
                                            placeholder="คีย์การ์ด C" value="{{ old('room_card_c') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header card-outline card-info">
                            <h3 class="card-title">รายละเอียดเช่า</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>ประเภทการเช่า</label>
                                        <select class="form-control"  name="rental_status">
                                            <option value="">-- เลือก --</option>
                                            <option value="การันตี" {{ old('rental_status') == 'การันตี' ? 'selected' : '' }}>การันตี</option>
                                            <option value="เบิกจ่ายล่วงหน้า" {{ old('rental_status') == 'เบิกจ่ายล่วงหน้า' ? 'selected' : '' }}>เบิกจ่ายล่วงหน้า</option>
                                            <option value="ฝากต่อหักภาษี" {{ old('rental_status') == 'ฝากต่อหักภาษี' ? 'selected' : '' }}>ฝากต่อหักภาษี</option>
                                            <option value="ฝากต่อไม่หักภาษี" {{ old('rental_status') == 'ฝากต่อไม่หักภาษี' ? 'selected' : '' }}>ฝากต่อไม่หักภาษี</option>
                                            <option value="ฝากเช่า" {{ old('rental_status') == 'ฝากเช่า' ? 'selected' : '' }}>ฝากเช่า</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>ระยะเริ่มการันตี/ฝากเช่า</label>
                                        <input class="form-control datepicker" name="gauranteestart" id="gauranteestart"
                                            placeholder="ระยะเริ่มการันตี" value="{{ old('gauranteestart') }}">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>ระยะสิ้นสุดการันตี/ฝากเช่า</label>
                                        <input class="form-control datepicker" name="gauranteeend" id="gauranteeend"
                                            placeholder="ระยะสิ้นสุดการันตี" value="{{ old('gauranteeend') }}">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>จำนวนเงินการันตี</label>
                                        <input class="form-control" name="gauranteeamount" type="text"
                                            placeholder="จำนวนเงินการันตี" value="{{ old('gauranteeamount') }}">
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>บัญชีแสดงสัญญา</label>
                                        <input class="form-control" name="Electric_Contract" type="text"
                                            placeholder="บัญชีแสดงสัญญา" value="{{ old('Electric_Contract') }}">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>รหัสเครื่องวัดฯ</label>
                                        <input class="form-control" name="Meter_Code" type="text"
                                            placeholder="รหัสเครื่องวัดฯ" value="{{ old('Meter_Code') }}">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>ราคาค่าเช่าห้อง</label>
                                        <input class="form-control" name="room_price" type="text"
                                            placeholder="ราคาค่าเช่า" value="{{ old('room_price') }}">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>สถานะห้อง</label>
                                        <select class="form-control" name="Status_Room">
                                            <option value="">-- เลือก --</option>
                                            <option value="รอตรวจ" {{ old('Status_Room') == 'รอตรวจ' ? 'selected' : '' }}>รอตรวจ</option>
                                            <option value="รอเฟอร์" {{ old('Status_Room') == 'รอเฟอร์' ? 'selected' : '' }}>รอเฟอร์</option>
                                            <option value="รอคลีน" {{ old('Status_Room') == 'รอคลีน' ? 'selected' : '' }}>รอคลีน</option>
                                            <option value="พร้อมอยู่" {{ old('Status_Room') == 'พร้อมอยู่' ? 'selected' : '' }}>พร้อมอยู่</option>
                                            <option value="อยู่แล้ว" {{ old('Status_Room') == 'อยู่แล้ว' ? 'selected' : '' }}>อยู่แล้ว</option>
                                            <option value="ห้องออฟฟิต" {{ old('Status_Room') == 'ห้องออฟฟิต' ? 'selected' : '' }}>ห้องออฟฟิต</option>
                                            <option value="ห้องตัวอย่าง" {{ old('Status_Room') == 'ห้องตัวอย่าง' ? 'selected' : '' }}>ห้องตัวอย่าง</option>
                                            <option value="จอง" {{ old('Status_Room') == 'จอง' ? 'selected' : '' }}>จอง</option>
                                            <option value="สวัสดิการ" {{ old('Status_Room') == 'สวัสดิการ' ? 'selected' : '' }}>สวัสดิการ</option>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header card-outline card-info">
                            <h3 class="card-title">อัพโหลดรูป</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group">
                                    <label for="exampleInputFile">รูปภาพห้อง</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" accept="image/jpeg, image/jpg, image/png"
                                                id="filUpload" name="filUpload[]" multiple="multiple" onchange="previewMultiImage(event)">
                                            <label class="custom-file-label"
                                                for="exampleInputFile"></label>
                                        </div>

                                    </div>
                                </div>
                                <br>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div id="imagePreview1">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div id="imagePreview2">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div id="imagePreview3">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div id="imagePreview4">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div id="imagePreview5">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div id="imagePreview6">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div id="imagePreview7">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div id="imagePreview8">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <div id="imagePreview9">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div id="imagePreview10">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div id="imagePreview11">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div id="imagePreview12">
                                    </div>
                                </div>
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
                                        <input style="width: 15%" style="display: inline" name="room_Bed" type="number" value="{{ old('room_Bed') }}"> <b class="ml-2">เตียง</b>
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Beding" type="number" value="{{ old('room_Beding') }}"> <b class="ml-2">เครื่องนอน</b>
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Bedroom_Curtain" type="number" value="{{ old('room_Bedroom_Curtain') }}"> <b class="ml-2">ม่านห้องนอน</b>
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Livingroom_Curtain" type="number" value="{{ old('room_Livingroom_Curtain') }}"> <b class="ml-2">ม่านห้องรับแขก</b>
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Wardrobe" type="number" value="{{ old('room_Wardrobe') }}"> <b class="ml-2">ตู้เสื้อผ้า</b>
                                    </p>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Sofa" type="number" value="{{ old('room_Sofa') }}"> <b class="ml-2">โซฟา</b>
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_TV_Table" type="number" value="{{ old('room_TV_Table') }}"> <b class="ml-2">โต๊ะวางโทรทัศน์</b>
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Dining_Table" type="number" value="{{ old('room_Dining_Table') }}"> <b class="ml-2">โต๊ะกินข้าว</b>
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Center_Table" type="number" value="{{ old('room_Center_Table') }}"> <b class="ml-2">โต๊ะกลาง</b>
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Chair" type="number" value="{{ old('room_Chair') }}"> <b class="ml-2">เก้าอี้</b>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <p>เครื่องใช้ไฟฟ้า</p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Bedroom_Air" type="number" value="{{ old('room_Bedroom_Air') }}"> <b class="ml-2">แอร์ห้องนอน</b>
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Livingroom_Air" type="number" value="{{ old('room_Livingroom_Air') }}"> <b class="ml-2">แอร์ห้องรับแขก</b>
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Water_Heater" type="number" value="{{ old('room_Water_Heater') }}"> <b class="ml-2">เครื่องทำน้ำอุ่น</b>
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_TV" type="number" value="{{ old('room_TV') }}"> <b class="ml-2">ทีวี</b>
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Refrigerator" type="number" value="{{ old('room_Refrigerator') }}"> <b class="ml-2">ตู้เย็น</b>
                                    </p>
                                </div>
                                
                            </div>
                           
                            <div class="row">
                                <div class="col-sm-2">
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_microwave" type="number" value="{{ old('room_microwave') }}"> <b class="ml-2">ไมโครเวฟ</b>
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_wash_machine" type="number" value="{{ old('room_wash_machine') }}"> <b class="ml-2">เครื่องซักผ้า</b>
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                </div>

                                <div class="col-sm-2">
                                </div>

                                <div class="col-sm-2">
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
                                </div>

                                <div class="col-sm-2">
                                </div>

                                <div class="col-sm-2">
                                </div>

                                <div class="col-sm-2">
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <td>
                                <div class="col-sm-4 offset-4">

                                    <button type="submit" class="btn btn-success"><i
                                        class="fa-solid fa-arrow-up-from-bracket"></i> เพิ่มข้อมูลห้อง</button>
                                </div>

                            </td>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                </div>
            </div>
            
        </div><!-- /.container-fluid -->
    </section>
</form>
@endsection
@push('script')
<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd', // รูปแบบวันที่
            autoclose: true,
        });
       
    });
    function goBack() {
        window.history.back();
    }

    function showAmphoes() {
            let input_province = document.querySelector("#owner_province");                    
            let url = "{{ url('../api/rental/amphoes') }}?province_id=" + input_province.value;
            fetch(url)
                .then(response => response.json())
                .then(result => {
                    let input_amphoe = document.querySelector("#owner_khet");
                    input_amphoe.innerHTML = '<option value="">กรุณาเลือกเขต/อำเภอ</option>';
                for (let item of result) {
                    let option = document.createElement("option");
                    option.text = item.amphoe;
                    option.value = item.amphoe_id;
                    input_amphoe.appendChild(option);
                }
                showTambons();
            });
    }

    function showTambons() {
        let input_province = document.querySelector("#owner_province");
        let input_amphoe = document.querySelector("#owner_khet");
        let url = "{{ url('../api/rental/tambons') }}?province_id=" + input_province.value + "&amphoe_id=" + input_amphoe
                .value;
        fetch(url)
            .then(response => response.json())
            .then(result => {
                let input_tambon = document.querySelector("#owner_district");
                input_tambon.innerHTML = '<option value="">กรุณาเลือกแขวง/ตำบล</option>';
                for (let item of result) {
                    let option = document.createElement("option");
                    option.text = item.tambon;
                    option.value = item.tambon_id;
                    input_tambon.appendChild(option);
                }
                // showZipcode(); // เรียกใช้ showZipcode เมื่อมีการเลือกอำเภอและตำบลใหม่
            });
    }

    // EVENTS RENT ROOM
    document.querySelector('#owner_province').addEventListener('change', (event) => {
        showAmphoes();
    }); 
    document.querySelector('#owner_khet').addEventListener('change', (event) => {
        showTambons();
    });
    // document.querySelector('#owner_district').addEventListener('change', (event) => {
    //     showZipcode();
    // });
</script>
<script>
    function previewImage(event) {
        var imageElement = document.getElementById('img-cover');
        var fileInput = event.target;

        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                imageElement.src = e.target.result;
            }

            reader.readAsDataURL(fileInput.files[0]);
        }
    }

    function previewMultiImage(event) {
   
        var files = event.target.files;
        let index = 1;
        let j = 1;
        for (var i = 0; i < files.length; i++) {
            let imagePreviewContainer = document.getElementById('imagePreview'+index);
            // console.log(imagePreviewContainer);
            imagePreviewContainer.innerHTML = ''; // Clear previous previews
            var reader = new FileReader();
            reader.onload = function(e) {
                let elem = 'room'+j;
                console.log(elem);
                // let preimg = document.getElementById(elem);
                // preimg.remove();
                // console.log(img);
                var img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('size-image');
                imagePreviewContainer.appendChild(img);
                
                j++;
            }
            reader.readAsDataURL(files[i]);
            index++;
        }
    }
</script>
@endpush