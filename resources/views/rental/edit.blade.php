@extends('layouts.app')

@section('title', 'โครงการ')

@section('content')
<form id="editForm" name="editForm" method="post" action="{{ route('rental.update') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="user_id" value="{{ $dataLoginUser->id }}">
    @foreach ($rents as $item)
    <input type="hidden" name="room_id" value="{{ $item->rid ?? $item->room_id }}">
    <input type="hidden" name="customer_id" value="{{ $item->id }}">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6">
                    {{-- @foreach ($rents as $item) --}}
                    <h1 class="m-0">
                        บ้านเลขที่ {{ $item->HomeNo }} ห้องเลขที่ {{ $item->RoomNo }}
                        <a href="javascript:void(0);" class="btn bg-gradient-primary " type="button"
                            onclick="goBack();">
                            <i class="fa-solid fa fa-reply"></i> กลับ </a>
                    </h1>
                    {{-- @endforeach --}}
                    

                </div><!-- /.col -->
                <div class="col-md-6 text-right">
                    <div class="form-group">
                        <a href="https://report.vbeyond.co.th/howto_rent/คู่มือการต่อสัญญาเช่าห้องพัก.pdf"
                            target="_blank" class="btn bg-gradient-warning">
                            <i class="fas fa-file"></i> คู่มือ การต่อสัญญาเช่า
                        </a>
                        <a href="https://report.vbeyond.co.th/howto_rent/อัพเดทระบบAutoเลขที่สัญญา.pdf"
                            target="_blank" class="btn  bg-gradient-primary"><i
                                class="fas fa-file-excel"></i> คู่มือ ระบบ Auto เลขที่สัญญา</a>
                        <button class="btn bg-gradient-success " type="submit"><i
                                    class="fa-solid fa-arrow-up-from-bracket"></i> อัพเดทข้อมูล</button>
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
                    {{-- @foreach ($rents as $item) --}}
                    <div class="card">
                        <div class="card-header card-outline card-info">
                            <h3 class="card-title">รายละเอียดห้อง</h3>

                        </div>
                        {{-- <form action="{{ route('room.search') }}" method="post" id="searchForm"> --}}
                            {{-- @csrf --}}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-2">

                                        <div class="form-group">
                                            <label>โครงการ</label>
                                            <select name="project_id" id="project_id" class="form-control">
                                                {{-- <option value="ทั้งหมด">ทั้งหมด</option> --}}
                                                @foreach ($projects as $project)
                                                <option value="{{  $project->pid  }}"
                                                {{ $project->pid == $item->project_id ? 'selected' : '' }}
                                                >
                                                {{ $project->Project_Name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>เลขที่บ้านเจ้าของห้อง</label>
                                            <input class="form-control" name="room_address" type="text" value="{{ $item->numberhome ?? '' }}"
                                                placeholder="ห้องเลขที่">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>บ้านเลขที่</label>
                                            <input class="form-control" name="numberhome" type="text" value="{{ $item->HomeNo ?? '' }}"
                                                placeholder="บ้านเลขที่">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>เจ้าของห้อง</label>
                                            <input class="form-control" name="onwername" type="text" value="{{ $item->Owner ?? '' }}"
                                                placeholder="เจ้าของห้อง">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>บัตรประชาชน</label>
                                            <input class="form-control" name="cardowner" type="text" value="{{ $item->cardowner ?? '' }}"
                                                placeholder="บัตรประชาชน">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>อัปโหลดไฟล์บัตรประชาชน</label>
                                            <input class="form-control" name="filUploadPersonID" type="file" 
                                                placeholder="อัปโหลดไฟล์บัตรประชาชน">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><font color="red">เลขที่สัญญา <u>*เจ้าของห้อง</u></font></label>
                                            <p class="form-control"><font color="red">{{ optional($lease_auto_code)->code_contract_owner ?? '' }}</font></p>
                                                
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><font color="red">เลขที่สัญญา <u>*แต่งตั้งตัวแทน</u></font></label>
                                            <p class="form-control"><font color="red">{{ optional($lease_auto_code)->code_contract_agent ?? '' }}</font></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>file สัญญา</label>
                                            <input class="form-control" name="filUploadContract" type="file"
                                                placeholder="file สัญญา">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>ซอย</label>
                                            <input class="form-control" name="owner_soi" type="text" value="{{ $item->owner_soi ?? '' }}"
                                                placeholder="ซอย">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>ถนน</label>
                                            <input class="form-control" name="owner_road" type="text" value="{{ $item->owner_road ?? '' }}"
                                                placeholder="ถนน">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>แขวง/ตำบล</label>
                                            <input class="form-control" name="owner_district" type="text" value="{{ $item->owner_district ?? '' }}"
                                                placeholder="แขวง/ตำบล">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>เขต/อำเภอ</label>
                                            <input class="form-control" name="owner_khet" type="text" value="{{ $item->owner_khet ?? '' }}"
                                                placeholder="เขต/อำเภอ">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>จังหวัด</label>
                                            <input class="form-control" name="owner_province" type="text" value="{{ $item->owner_province ?? '' }}"
                                                placeholder="จังหวัด">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>เบอร์ติดต่อ</label>
                                            <input class="form-control" name="ownerphone" type="text" value="{{ $item->owner_phone ?? '' }}"
                                                placeholder="เบอร์ติดต่อ">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>วันรับห้อง</label>
                                            <input class="form-control datepicker" name="transfer_date" id="transfer_date" value="{{ $item->Transfer_Date ?? '' }}"
                                                placeholder="วันรับห้อง">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>เลขที่ห้อง</label>
                                            <input class="form-control" name="RoomNo" type="text" value="{{ $item->RoomNo ?? '' }}"
                                                placeholder="เลขที่ห้อง">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>ประเภทห้อง</label>
                                            <input class="form-control" name="room_type" type="text" value="{{ $item->RoomType ?? '' }}"
                                                placeholder="ประเภทห้อง">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>ขนาดห้อง</label>
                                            <input class="form-control" name="room_size" type="text" value="{{ $item->Size ?? '' }}"
                                                placeholder="ขนาดห้อง">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>ทิศ/ฝั่ง</label>
                                            <input class="form-control" name="Location" type="text" value="{{ $item->Location ?? '' }}"
                                                placeholder="ทิศ/ฝั่ง">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>อาคาร</label>
                                            <input class="form-control" name="Building" type="text" value="{{ $item->Building ?? '' }}"
                                                placeholder="อาคาร">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>ชั้น</label>
                                            <input class="form-control" name="Floor" type="text" value="{{ $item->Floor ?? '' }}"
                                                placeholder="ชั้น">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>กุญแจ หน้า</label>
                                            <input class="form-control" name="room_key_front" type="text" value="{{ $item->Key_front ?? '' }}"
                                                placeholder="กุญแจ หน้า">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>กุญแจ นอน</label>
                                            <input class="form-control" name="room_key_bed" type="text" value="{{ $item->Key_bed ?? '' }}"
                                                placeholder="กุญแจ นอน">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>กุญแจ ระเบียง</label>
                                            <input class="form-control" name="room_key_balcony" type="text" value="{{ $item->Key_balcony ?? '' }}"
                                                placeholder="กุญแจ ระเบียง">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>กุญแจ Mail Box</label>
                                            <input class="form-control" name="room_key_mailbox" type="text" value="{{ $item->Key_mailbox }}"
                                                placeholder="กุญแจ Mail Box">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>คีย์การ์ด</label>
                                            <input class="form-control" name="room_card" type="text" value="{{ $item->KeyCard ?? '' }}"
                                                placeholder="คีย์การ์ด">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>คีย์การ์ด P</label>
                                            <input class="form-control" name="room_card_p" type="text" value="{{ $item->KeyCard_P ?? '' }}"
                                                placeholder="คีย์การ์ด P">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>คีย์การ์ด B</label>
                                            <input class="form-control" name="room_card_b" type="text" value="{{ $item->KeyCard_B ?? '' }}"
                                                placeholder="คีย์การ์ด B">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>คีย์การ์ด C</label>
                                            <input class="form-control" name="room_card_c" type="text" value="{{ $item->KeyCard_C ?? ''}}"
                                                placeholder="คีย์การ์ด C">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>ระยะเริ่มการันตี</label>
                                            <input class="form-control datepicker" name="gauranteestart" id="gauranteestart" value="{{ $item->Guarantee_Startdate ?? '' }}"
                                                placeholder="ระยะเริ่มการันตี">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>ระยะสิ้นสุดการันตี</label>
                                            <input class="form-control datepicker" name="gauranteeend" id="gauranteeend" value="{{ $item->Guarantee_Enddate ?? '' }}"
                                                placeholder="ระยะสิ้นสุดการันตี">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>วันที่ฝากเช่า</label>
                                            <input class="form-control datepicker" name="date_firstrend" id="date_firstrend"  type="text" value="{{ $item->date_firstrend ?? '' }}"
                                                placeholder="วันที่ฝากเช่า">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>วันที่สิ้นสุดฝากเช่า</label>
                                            <input class="form-control datepicker" name="date_endrend" id="date_endrend" type="text" value="{{ $item->date_endrend ?? ''}}"
                                                placeholder="วันที่สิ้นสุดฝากเช่า">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>จำนวนเงินการันตี</label>
                                            <input class="form-control" name="gauranteeamount" type="text" value="{{ $item->Guarantee_Amount ?? '' }}"
                                                placeholder="จำนวนเงินการันตี">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>สถานะห้อง</label>
                                            <input class="form-control" name="Status_Room" type="text" value="{{ $item->Status_Room ?? '' }}"
                                                placeholder="สถานะห้อง"> 
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>วันที่รับค่าเช่างวดแรก</label>
                                            <input class="form-control datepicker" name="date_firstget" id="date_firstget" value="{{ $item->date_firstget ?? '' }}"
                                                placeholder="วันที่รับค่าเช่างวดแรก">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>วันที่ ทำสัญญา</label>
                                            <input class="form-control datepicker" name="date_print_contract_manual" id="date_print_contract_manual" value="{{ $item->print_contract_manual ?? ''}}"
                                                placeholder="วันที่ ทำสัญญา">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>บัญชีแสดงสัญญา</label>
                                            <input class="form-control" name="Electric_Contract" type="text" value="{{ $item->Electric_Contract ?? '' }}"
                                                placeholder="บัญชีแสดงสัญญา">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>รหัสเครื่องวัดฯ</label>
                                            <input class="form-control" name="Meter_Code" type="text" value="{{ $item->Meter_Code ?? '' }}"
                                                placeholder="รหัสเครื่องวัดฯ">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>ประเภทห้องเช่า</label>
                                            <input class="form-control" name="rental_status" type="text" value="{{ $item->rental_status ?? '' }}"
                                                placeholder="ประเภทห้องเช่า">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        {{-- <div class="form-group">
                                            <label>ราคาค่าเช่า</label>
                                            <div><input name="room_price" type="text" value="{{ $item->price ?? ''}}"
                                                placeholder="ราคาค่าเช่า"><input name="show_price" type="checkbox" value="1"
                                               ></div>
                                        </div> --}}
                                        <div class="form-group">
                                            <label>ราคาค่าเช่า</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" name="room_price" value="{{ $item->price ?? ''}}">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                      <input type="checkbox" name="show_price" value="1">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>รูปภาพปก</label>
                                            <input class="form-control" id="filUploadMain" name="filUploadMain" type="file"
                                                placeholder="รูปภาพปก">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>รูปภาพห้อง</label>
                                            <input class="form-control" id="filUpload" name="filUpload[]" type="file"
                                                placeholder="รูปภาพห้อง" multiple="multiple">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    
                                </div>
                            </div>

                            
                        {{-- </form> --}}

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
                                        <input style="width: 15%" style="display: inline" name="room_Bed" type="number" value="{{ $item->Bed }}"> เตียง
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Beding" type="number" value="{{ $item->Beding }}"> เครื่องนอน
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Bedroom_Curtain" type="number" value="{{ $item->Bedroom_Curtain }}"> ม่านห้องนอน
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Livingroom_Curtain" type="number" value="{{ $item->Livingroom_Curtain }}"> ม่านห้องรับแขก
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Wardrobe" type="number" value="{{ $item->Wardrobe }}"> ตู้เสื้อผ้า
                                    </p>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Sofa" type="number" value="{{ $item->Sofa }}"> โซฟา
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_TV_Table" type="number" value="{{ $item->TV_Table }}"> โต๊ะวางโทรทัศน์
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Dining_Table" type="number" value="{{ $item->Dining_Table }}"> โต๊ะกินข้าว
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Center_Table" type="number" value="{{ $item->Center_Table }}"> โต๊ะกลาง
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Chair" type="number" value="{{ $item->Chair }}"> เก้าอี้
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <p>เครื่องใช้ไฟฟ้า</p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Bedroom_Air" type="number" value="{{ $item->Bedroom_Air }}"> แอร์ห้องนอน
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Livingroom_Air" type="number" value="{{ $item->Livingroom_Air }}"> แอร์ห้องรับแขก
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Water_Heater" type="number" value="{{ $item->Water_Heater }}"> เครื่องทำน้ำอุ่น
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_TV" type="number" value="{{ $item->TV }}"> ทีวี
                                    </p>
                                </div>

                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_Refrigerator" type="number" value="{{ $item->Refrigerator }}"> ตู้เย็น
                                    </p>
                                </div>
                                
                            </div>
                           
                            <div class="row">
                                <div class="col-sm-2">
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_microwave" type="number" value="{{ $item->wash_machine }}"> ไมโครเวฟ
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="form-group">
                                        <input style="width: 15%" style="display: inline" name="room_wash_machine" type="number" value="{{ $item->wash_machine }}"> เครื่องซักผ้า
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
                                    <textarea name="Other" id="" cols="33" rows="3">{{ $item->Other }}</textarea>
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
                    <div class="card">
                        <div class="card-header card-outline card-info">
                            <h3 class="card-title">รายละเอียดเช่า</h3>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>ลูกค้าเช่าซื้อ</label>
                                        <input class="form-control" name="Cus_Name" type="text" value="{{ $item->Cus_Name ?? '' }}"
                                            placeholder="ลูกค้าเช่าซื้อ">
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>เลขบัตรประชาชน</label>
                                        <input class="form-control" name="IDCard" type="text" value="{{ $item->IDCard ?? ''}}"
                                            placeholder="ลขบัตรประชาชน">
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label><font color="red">เลขที่สัญญา *<u>ผู้เช่า</u></font></label>
                                        <p class="form-control"><font color="red">{{ optional($lease_auto_code)->code_contract_cus ?? '' }}</font></p>
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label><font color="red">เลขที่สัญญา *<u>ประกันทรัพย์สิน</u></font></label>
                                            <p class="form-control"><font color="red">{{ optional($lease_auto_code)->code_contract_insurance ?? '' }}</font></p>
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label><font color="red">เลขที่สัญญาเก่า *<u>กรณีต่อสัญญา</u></font></label>
                                        <input class="form-control" name="code_contract_old" type="text" value="{{ $item->code_contract_old ?? '' }}"
                                            placeholder="กรุณากรอกเลขสัญญาเก่า">
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>ค่าประกันทรัพย์สิน</label>
                                        <input class="form-control" name="price_insurance" type="text" value="{{ $item->price_insurance ?? ''}}"
                                            placeholder="ค่าประกันทรัพย์สิน">
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>

                                <div class="col-sm-2">
                                    {{-- <div class="form-group">
                                        <label><font color="red">เลขที่สัญญา *<u>ผู้เช่า</u></font></label>
                                        <p class="form-control">{{ $item->contract_cus }}</p>
                                    </div> --}}
                                </div>
                                <div class="col-sm-1"></div>

                                <div class="col-sm-2">
                                    {{-- <div class="form-group">
                                        <label><font color="red">เลขที่สัญญา *<u>ประกันทรัพย์สิน</u></font></label>
                                            <p class="form-control">{{ $item->contract_insurance_number }}</p>
                                    </div> --}}
                                </div>
                                <div class="col-sm-1"></div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header card-outline card-info">
                            <h3 class="card-title">ที่อยู่ลูกค้าในทะเบียนบ้าน</h3>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>บ้านเลขที่</label>
                                        <input class="form-control" name="cus_homeAddress" type="text" value="{{ $item->home_address ?? '' }}"
                                            placeholder="บ้านเลขที่">
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>ซอย</label>
                                        <input class="form-control" name="cust_soi" type="text" value="{{ $item->cust_soi ?? ''}}"
                                            placeholder="ซอย">
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>ถนน</label>
                                        <input class="form-control" name="cust_road" type="text" value="{{ $item->cust_road ?? '' }}"
                                            placeholder="ถนน">
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>แขวง/ตำบล</label>
                                        <input class="form-control" name="cus_tumbon" type="text" value="{{ $item->tumbon ?? '' }}"
                                            placeholder="แขวง/ตำบล">
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>เขต/อำเภอ</label>
                                        <input class="form-control" name="cus_tumbon" type="text" value="{{ $item->cus_tumbon ?? '' }}"
                                            placeholder="เขต/อำเภอ">
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>จังหวัด</label>
                                        <input class="form-control" name="cus_province" type="text" value="{{ $item->province ?? '' }}"
                                            placeholder="จังหวัด">
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>รหัสไปรษณีย์</label>
                                        <input class="form-control" name="cus_idPost" type="text" value="{{ $item->id_post ?? ''}}"
                                            placeholder="รหัสไปรษณีย์">
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>เบอร์โทรศัพท์</label>
                                        <input class="form-control" name="cus_phone" type="text" value="{{ $item->Phone ?? '' }}"
                                            placeholder="เบอร์โทรศัพท์">
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>วันเริ่มสัญญา</label>
                                        <p class="form-control text-danger datepicker" name="Contract_Startdate"> {{ $item->Contract_Startdate ?? '' }} </p>
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>วันสิ้นสุดสัญญา</label>
                                        <p class="form-control text-danger datepicker" name="Contract_Enddate">{{ $item->Contract_Enddate ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>ระยะเวลา</label>
                                        <p class="form-control"><font color="red">{{ $item->Contract ?? ''}}</font> เดือน <input name="Contract" type="text" value="{{ $item->Contract ?? 0}}" style="width: 15%"> วัน </p>
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>วันที่เริ่มจ่ายงวดแรก</label>
                                        <p class="form-control text-danger">{{ $item->star_dueNew ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>หนังสือสัญญา</label>
                                        <input class="form-control" name="file_contract_path" type="file" >
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>ราคา</label>
                                        <input class="form-control" name="Price" type="text" value="{{ $item->Price ?? '' }}"
                                            placeholder="ราคา"> บาท
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>ใบเสร็จจาก express</label>
                                        <input class="form-control" name="fileUploadExpress" type="file" value="{{ $item->print_contract_manual ?? ''}}"
                                            placeholder="ใบเสร็จจาก express">
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>สัญญา</label>
                                        <input class="form-control" name="Contract_Reason" type="text" value="{{ $item->Contract_Reason ?? '' }}"
                                            placeholder="สัญญา">
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>

                                
                            </div>

                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>สถานะเช่า</label>
                                        {{-- <input class="form-control" name="Contract_Status" type="text" value="{{ $item->Contract_Status ?? '' }}"
                                            placeholder="สถานะเช่า"> --}}
                                            <select class="form-control" name="Contract_Status">
                                                <option value="">-- เลือก --</option>
                                                <option value="เช่าอยู่" {{ $item->Contract_Status === 'เช่าอยู่' ? 'selected' : ''}}>เช่าอยู่</option>
                                                <option value="ต่อสัญญา" {{ $item->Contract_Status === 'ต่อสัญญา' ? 'selected' : ''}}>ต่อสัญญา</option>
                                                <option value="ออก" {{ $item->Contract_Status === 'ออก' ? 'selected' : ''}}>ออก</option>
                                                <option value="ยกเลิกสัญญา" {{ $item->Contract_Status === 'ยกเลิกสัญญา' ? 'selected' : ''}}>ยกเลิกสัญญา</option>
                                              </select>
                                            <small class="form-text text-danger" data-toggle="tooltip" data-placement="bottom" title="ออก = ลูกค้าออกตามสัญญา
                                            ยกเลิกสัญญา = ลูกค้าออกก่อนสัญญาที่ระบุไว้">*สถานะ</small>
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>วันออก</label>
                                        <input class="form-control datepicker" name="Cancle_Date" id="Cancle_Date" value="{{ $item->date_firstget ?? '' }}"
                                            placeholder="วันออก">
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>หมายเหตุ ลูกค้า</label>
                                            <textarea class="form-control" name="cust_remark" id="" cols="5" rows="3">{{ $item->print_contract_manual ?? ''}}</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>

                                <div class="col-sm-2">
                                    
                                </div>
                                <div class="col-sm-1"></div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>รูปภาพปก</label>
                                        <input class="form-control" id="filUploadMain" name="filUploadMain" type="file"
                                            placeholder="รูปภาพปก">
                                        {{-- <span><img src="{{ $item->image }}" height="50"/></span> --}}
                                        <div><img src="https://img.freepik.com/free-vector/hacker-anonymous-mask-server-room-with-multiple-computer-monitors-displaying-secret-information_33099-1629.jpg?w=1380&t=st=1712651282~exp=1712651882~hmac=d3f15efe0108fb807d63b90cfec27b9d88c04d955eafd4da8d9c906b00a0f390" height="160" style="border-radius: 10%; margin-top: 5px;"/></div>
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>รูปภาพห้อง</label>
                                        <input class="form-control" id="filUpload" name="filUpload[]" type="file"
                                            placeholder="รูปภาพห้อง" multiple="multiple">
                                            {{-- <span><img src="{{ $item->image }}" height="50"/></span> --}}
                                            <div><img src="https://img.freepik.com/free-vector/hacker-anonymous-mask-server-room-with-multiple-computer-monitors-displaying-secret-information_33099-1629.jpg?w=1380&t=st=1712651282~exp=1712651882~hmac=d3f15efe0108fb807d63b90cfec27b9d88c04d955eafd4da8d9c906b00a0f390" height="160" style="border-radius: 10%; margin-top: 5px;"/></div>
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>


                                <div class="col-sm-2">
                                    <div class="form-group">
                                        {{-- <label>รูปภาพปก</label>
                                        <span><img src="{{ $item->image }}" height="50"/></span> --}}
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        {{-- <label>รูปภาพห้อง</label>
                                        <input class="form-control" name="Meter_Code" type="text" value="{{ $item->Meter_Code ?? '' }}"
                                            placeholder="รูปภาพห้อง"> --}}
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>
                            </div>
                        </div>
                    </div>

                 {{-- @endforeach --}}
                </div>
                
            </div>
            
        </div><!-- /.container-fluid -->
    </section>

    @endforeach
</form>
@endsection
@push('script')
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
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