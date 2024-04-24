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
                                            <label>โครงการ</label>
                                            <select name="project_id" id="project_id" class="form-control">
                                                <option value="">-- เลือก --</option>
                                                @foreach ($projects as $project)
                                                <option value="{{ $project->pid }}"
                                                >
                                                {{ $project->Project_Name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>เลขที่บ้านเจ้าของห้อง</label>
                                            <input class="form-control" name="numberhome" type="text"
                                                placeholder="เลขที่บ้านเจ้าของ">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ห้องเลขที่</label>
                                            <input class="form-control" name="room_address" type="text"
                                                placeholder="ห้องเลขที่">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>บ้านเลขที่</label>
                                            <input class="form-control" name="address" type="text"
                                                placeholder="บ้านเลขที่">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>เจ้าของห้อง</label>
                                            <input class="form-control" name="onwername" type="text"
                                                placeholder="เจ้าของห้อง">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>บัตรประชาชน</label>
                                            <input class="form-control" name="cardowner" type="text"
                                                placeholder="บัตรประชาชน">
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
                                            <label>แขวง/ตำบล</label>
                                            <input class="form-control" name="owner_district" type="text"
                                                placeholder="แขวง/ตำบล">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>เขต/อำเภอ</label>
                                            <input class="form-control" name="owner_khet" type="text"
                                                placeholder="เขต/อำเภอ">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>จังหวัด</label>
                                            <input class="form-control" name="owner_province" type="text"
                                                placeholder="จังหวัด">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>เบอร์ติดต่อ</label>
                                            <input class="form-control" name="ownerphone" type="text"
                                                placeholder="เบอร์ติดต่อ">
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
                                        <input style="width: 15%" style="display: inline" name="room_Bed" type="number" value=""> เตียง
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Beding" type="number" value=""> เครื่องนอน
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Bedroom_Curtain" type="number" value=""> ม่านห้องนอน
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Livingroom_Curtain" type="number" value=""> ม่านห้องรับแขก
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Wardrobe" type="number" value=""> ตู้เสื้อผ้า
                                    </p>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Sofa" type="number" value=""> โซฟา
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_TV_Table" type="number" value=""> โต๊ะวางโทรทัศน์
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Dining_Table" type="number" value=""> โต๊ะกินข้าว
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Center_Table" type="number" value=""> โต๊ะกลาง
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Chair" type="number" value=""> เก้าอี้
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <p>เครื่องใช้ไฟฟ้า</p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Bedroom_Air" type="number" value=""> แอร์ห้องนอน
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Livingroom_Air" type="number" value=""> แอร์ห้องรับแขก
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Water_Heater" type="number" value=""> เครื่องทำน้ำอุ่น
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_TV" type="number" value=""> ทีวี
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Refrigerator" type="number" value=""> ตู้เย็น
                                    </p>
                                </div>
                                
                            </div>
                           
                            <div class="row">
                                <div class="col-sm-2">
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_microwave" type="number" value=""> ไมโครเวฟ
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_wash_machine" type="number" value=""> เครื่องซักผ้า
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