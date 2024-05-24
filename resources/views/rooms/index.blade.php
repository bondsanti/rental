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
                                            <label><b class="text-danger">*</b> เลขที่บ้านเจ้าของห้อง</label>
                                            <input class="form-control @error('numberhome') is-invalid @enderror" name="numberhome" type="text"
                                                placeholder="เลขที่บ้านเจ้าของ" value="{{ old('numberhome') }}">
                                            @error('numberhome')
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
                                </div>
                                
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
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>อัปโหลดไฟล์บัตรประชาชน</label>
                                            <input class="form-control" name="filUploadPersonID" type="file" 
                                                placeholder="เลขที่สัญญา">
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
                                            <label><b class="text-danger">*</b> แขวง/ตำบล</label>
                                            <input class="form-control @error('owner_district') is-invalid @enderror" name="owner_district" type="text"
                                                placeholder="แขวง/ตำบล" value="{{ old('owner_district') }}">
                                            @error('owner_district')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><b class="text-danger">*</b> เขต/อำเภอ</label>
                                            <input class="form-control @error('owner_khet') is-invalid @enderror" name="owner_khet" type="text"
                                                placeholder="เขต/อำเภอ" value="{{ old('owner_khet') }}">
                                            @error('owner_khet')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><b class="text-danger">*</b> จังหวัด</label>
                                            <select class="form-control @error('owner_province') is-invalid @enderror" name="owner_province">
                                                <option value="">-- เลือก --</option>
                                                <option value="กรุงเทพมหานคร" {{ old('owner_province') == 'กรุงเทพมหานคร' ? 'selected' : '' }}>กรุงเทพมหานคร</option>
                                                <option value="กระบี่" {{ old('owner_province') == 'กระบี่' ? 'selected' : '' }}>กระบี่</option>
                                                <option value="กาญจนบุรี" {{ old('owner_province') == 'กาญจนบุรี' ? 'selected' : '' }}>กาญจนบุรี</option>
                                                <option value="กาฬสินธุ์" {{ old('owner_province') == 'กาฬสินธุ์' ? 'selected' : '' }}>กาฬสินธุ์</option>
                                                <option value="กำแพงเพชร" {{ old('owner_province') == 'กำแพงเพชร' ? 'selected' : '' }}>กำแพงเพชร</option>
                                                <option value="ขอนแก่น" {{ old('owner_province') == 'ขอนแก่น' ? 'selected' : '' }}>ขอนแก่น</option>
                                                <option value="จันทบุรี" {{ old('owner_province') == 'จันทบุรี' ? 'selected' : '' }}>จันทบุรี</option>
                                                <option value="ฉะเชิงเทรา" {{ old('owner_province') == 'ฉะเชิงเทรา' ? 'selected' : '' }}>ฉะเชิงเทรา</option>
                                                <option value="ชัยนาท" {{ old('owner_province') == 'ชัยนาท' ? 'selected' : '' }}>ชัยนาท</option>
                                                <option value="ชัยภูมิ" {{ old('owner_province') == 'ชัยภูมิ' ? 'selected' : '' }}>ชัยภูมิ</option>
                                                <option value="ชุมพร" {{ old('owner_province') == 'ชุมพร' ? 'selected' : '' }}>ชุมพร</option>
                                                <option value="ชลบุรี" {{ old('owner_province') == 'ชลบุรี' ? 'selected' : '' }}>ชลบุรี</option>
                                                <option value="เชียงใหม่" {{ old('owner_province') == 'เชียงใหม่' ? 'selected' : '' }}>เชียงใหม่</option>
                                                <option value="เชียงราย" {{ old('owner_province') == 'เชียงราย' ? 'selected' : '' }}>เชียงราย</option>
                                                <option value="ตรัง" {{ old('owner_province') == 'ตรัง' ? 'selected' : '' }}>ตรัง</option>
                                                <option value="ตราด" {{ old('owner_province') == 'ตราด' ? 'selected' : '' }}>ตราด</option>
                                                <option value="ตาก" {{ old('owner_province') == 'ตาก' ? 'selected' : '' }}>ตาก</option>
                                                <option value="นครนายก" {{ old('owner_province') == 'นครนายก' ? 'selected' : '' }}>นครนายก</option>
                                                <option value="นครปฐม" {{ old('owner_province') == 'นครปฐม' ? 'selected' : '' }}>นครปฐม</option>
                                                <option value="นครพนม" {{ old('owner_province') == 'นครพนม' ? 'selected' : '' }}>นครพนม</option>
                                                <option value="นครราชสีมา" {{ old('owner_province') == 'นครราชสีมา' ? 'selected' : '' }}>นครราชสีมา</option>
                                                <option value="นครศรีธรรมราช" {{ old('owner_province') == 'นครศรีธรรมราช' ? 'selected' : '' }}>นครศรีธรรมราช</option>
                                                <option value="นครสวรรค์" {{ old('owner_province') == 'นครสวรรค์' ? 'selected' : '' }}>นครสวรรค์</option>
                                                <option value="นราธิวาส" {{ old('owner_province') == 'นราธิวาส' ? 'selected' : '' }}>นราธิวาส</option>
                                                <option value="น่าน" {{ old('owner_province') == 'น่าน' ? 'selected' : '' }}>น่าน</option>
                                                <option value="นนทบุรี" {{ old('owner_province') == 'นนทบุรี' ? 'selected' : '' }}>นนทบุรี</option>
                                                <option value="บึงกาฬ" {{ old('owner_province') == 'บึงกาฬ' ? 'selected' : '' }}>บึงกาฬ</option>
                                                <option value="บุรีรัมย์" {{ old('owner_province') == 'บุรีรัมย์' ? 'selected' : '' }}>บุรีรัมย์</option>
                                                <option value="ประจวบคีรีขันธ์" {{ old('owner_province') == 'ประจวบคีรีขันธ์' ? 'selected' : '' }}>ประจวบคีรีขันธ์</option>
                                                <option value="ปทุมธานี" {{ old('owner_province') == 'ปทุมธานี' ? 'selected' : '' }}>ปทุมธานี</option>
                                                <option value="ปราจีนบุรี" {{ old('owner_province') == 'ปราจีนบุรี' ? 'selected' : '' }}>ปราจีนบุรี</option>
                                                <option value="ปัตตานี" {{ old('owner_province') == 'ปัตตานี' ? 'selected' : '' }}>ปัตตานี</option>
                                                <option value="พะเยา" {{ old('owner_province') == 'พะเยา' ? 'selected' : '' }}>พะเยา</option>
                                                <option value="พระนครศรีอยุธยา" {{ old('owner_province') == 'พระนครศรีอยุธยา' ? 'selected' : '' }}>พระนครศรีอยุธยา</option>
                                                <option value="พังงา" {{ old('owner_province') == 'พังงา' ? 'selected' : '' }}>พังงา</option>
                                                <option value="พิจิตร" {{ old('owner_province') == 'พิจิตร' ? 'selected' : '' }}>พิจิตร</option>
                                                <option value="พิษณุโลก" {{ old('owner_province') == 'พิษณุโลก' ? 'selected' : '' }}>พิษณุโลก</option>
                                                <option value="เพชรบุรี" {{ old('owner_province') == 'เพชรบุรี' ? 'selected' : '' }}>เพชรบุรี</option>
                                                <option value="เพชรบูรณ์" {{ old('owner_province') == 'เพชรบูรณ์' ? 'selected' : '' }}>เพชรบูรณ์</option>
                                                <option value="แพร่" {{ old('owner_province') == 'แพร่' ? 'selected' : '' }}>แพร่</option>
                                                <option value="พัทลุง" {{ old('owner_province') == 'พัทลุง' ? 'selected' : '' }}>พัทลุง</option>
                                                <option value="ภูเก็ต" {{ old('owner_province') == 'ภูเก็ต' ? 'selected' : '' }}>ภูเก็ต</option>
                                                <option value="มหาสารคาม" {{ old('owner_province') == 'มหาสารคาม' ? 'selected' : '' }}>มหาสารคาม</option>
                                                <option value="มุกดาหาร" {{ old('owner_province') == 'มุกดาหาร' ? 'selected' : '' }}>มุกดาหาร</option>
                                                <option value="แม่ฮ่องสอน" {{ old('owner_province') == 'แม่ฮ่องสอน' ? 'selected' : '' }}>แม่ฮ่องสอน</option>
                                                <option value="ยโสธร" {{ old('owner_province') == 'ยโสธร' ? 'selected' : '' }}>ยโสธร</option>
                                                <option value="ยะลา" {{ old('owner_province') == 'ยะลา' ? 'selected' : '' }}>ยะลา</option>
                                                <option value="ร้อยเอ็ด" {{ old('owner_province') == 'ร้อยเอ็ด' ? 'selected' : '' }}>ร้อยเอ็ด</option>
                                                <option value="ระนอง" {{ old('owner_province') == 'ระนอง' ? 'selected' : '' }}>ระนอง</option>
                                                <option value="ระยอง" {{ old('owner_province') == 'ระยอง' ? 'selected' : '' }}>ระยอง</option>
                                                <option value="ราชบุรี" {{ old('owner_province') == 'ราชบุรี' ? 'selected' : '' }}>ราชบุรี</option>
                                                <option value="ลพบุรี" {{ old('owner_province') == 'ลพบุรี' ? 'selected' : '' }}>ลพบุรี</option>
                                                <option value="ลำปาง" {{ old('owner_province') == 'ลำปาง' ? 'selected' : '' }}>ลำปาง</option>
                                                <option value="ลำพูน" {{ old('owner_province') == 'ลำพูน' ? 'selected' : '' }}>ลำพูน</option>
                                                <option value="เลย" {{ old('owner_province') == 'เลย' ? 'selected' : '' }}>เลย</option>
                                                <option value="ศรีสะเกษ" {{ old('owner_province') == 'ศรีสะเกษ' ? 'selected' : '' }}>ศรีสะเกษ</option>
                                                <option value="สกลนคร" {{ old('owner_province') == 'สกลนคร' ? 'selected' : '' }}>สกลนคร</option>
                                                <option value="สงขลา" {{ old('owner_province') == 'สงขลา' ? 'selected' : '' }}>สงขลา</option>
                                                <option value="สมุทรสาคร" {{ old('owner_province') == 'สมุทรสาคร' ? 'selected' : '' }}>สมุทรสาคร</option>
                                                <option value="สมุทรปราการ" {{ old('owner_province') == 'สมุทรปราการ' ? 'selected' : '' }}>สมุทรปราการ</option>
                                                <option value="สมุทรสงคราม" {{ old('owner_province') == 'สมุทรสงคราม' ? 'selected' : '' }}>สมุทรสงคราม</option>
                                                <option value="สระแก้ว" {{ old('owner_province') == 'สระแก้ว' ? 'selected' : '' }}>สระแก้ว</option>
                                                <option value="สระบุรี" {{ old('owner_province') == 'สระบุรี' ? 'selected' : '' }}>สระบุรี</option>
                                                <option value="สิงห์บุรี" {{ old('owner_province') == 'สิงห์บุรี' ? 'selected' : '' }}>สิงห์บุรี</option>
                                                <option value="สุโขทัย" {{ old('owner_province') == 'สุโขทัย' ? 'selected' : '' }}>สุโขทัย</option>
                                                <option value="สุพรรณบุรี" {{ old('owner_province') == 'สุพรรณบุรี' ? 'selected' : '' }}>สุพรรณบุรี</option>
                                                <option value="สุราษฎร์ธานี" {{ old('owner_province') == 'สุราษฎร์ธานี' ? 'selected' : '' }}>สุราษฎร์ธานี</option>
                                                <option value="สตูล" {{ old('owner_province') == 'สตูล' ? 'selected' : '' }}>สตูล</option>
                                                <option value="หนองคาย" {{ old('owner_province') == 'หนองคาย' ? 'selected' : '' }}>หนองคาย</option>
                                                <option value="หนองบัวลำภู" {{ old('owner_province') == 'หนองบัวลำภู' ? 'selected' : '' }}>หนองบัวลำภู</option>
                                                <option value="อำนาจเจริญ" {{ old('owner_province') == 'อำนาจเจริญ' ? 'selected' : '' }}>อำนาจเจริญ</option>
                                                <option value="อุดรธานี" {{ old('owner_province') == 'อุดรธานี' ? 'selected' : '' }}>อุดรธานี</option>
                                                <option value="อุตรดิตถ์" {{ old('owner_province') == 'อุตรดิตถ์' ? 'selected' : '' }}>อุตรดิตถ์</option>
                                                <option value="อุทัยธานี" {{ old('owner_province') == 'อุทัยธานี' ? 'selected' : '' }}>อุทัยธานี</option>
                                                <option value="อุบลราชธานี" {{ old('owner_province') == 'อุบลราชธานี' ? 'selected' : '' }}>อุบลราชธานี</option>
                                                <option value="อ่างทอง" {{ old('owner_province') == 'อ่างทอง' ? 'selected' : '' }}>อ่างทอง</option>
                                            </select>
                                            @error('owner_province')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
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
                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ทิศ/ฝั่ง</label>
                                            <input class="form-control" name="Location" type="text"
                                                placeholder="ทิศ/ฝั่ง" value="{{ old('Location') }}">
                                        </div>
                                    </div>

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
                                            <label>กุญแจ หน้า</label>
                                            <input class="form-control" name="room_key_front" type="text"
                                                placeholder="กุญแจ หน้า" value="{{ old('room_key_front') }}">
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row">
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

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>คีย์การ์ด</label>
                                            <input class="form-control" name="room_card" type="text"
                                                placeholder="คีย์การ์ด" value="{{ old('room_card') }}">
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row">
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

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ระยะเริ่มการันตี</label>
                                            <input class="form-control datepicker" name="gauranteestart" id="gauranteestart"
                                                placeholder="ระยะเริ่มการันตี" value="{{ old('gauranteestart') }}">
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ระยะสิ้นสุดการันตี</label>
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

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>บัญชีแสดงสัญญา</label>
                                            <input class="form-control" name="Electric_Contract" type="text"
                                                placeholder="บัญชีแสดงสัญญา" value="{{ old('Electric_Contract') }}">
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>รหัสเครื่องวัดฯ</label>
                                            <input class="form-control" name="Meter_Code" type="text"
                                                placeholder="รหัสเครื่องวัดฯ" value="{{ old('Meter_Code') }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ประเภทห้องเช่า</label>
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
                                            <label>ราคาค่าเช่าห้อง</label>
                                            <input class="form-control" name="room_price" type="text"
                                                placeholder="ราคาค่าเช่า" value="{{ old('room_price') }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>รูปภาพปก</label>
                                            <input class="form-control" id="filUploadMain" name="filUploadMain" type="file"
                                                placeholder="รูปภาพปก">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>รูปภาพห้อง</label>
                                            <input class="form-control" id="filUpload" name="filUpload[]" type="file"
                                                placeholder="รูปภาพห้อง" multiple="multiple">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                    </div>

                                    <div class="col-sm-3">
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