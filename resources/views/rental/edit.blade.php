@extends('layouts.app')

@section('title', 'โครงการ')

@section('content')
<form id="editForm" name="editForm" method="post" action="{{ route('rental.update') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="user_id" value="{{ $dataLoginUser->id }}">
    @foreach ($rents as $item)
        <input type="hidden" name="room_id" value="{{ $item->rid ?? $item->room_id }}">
        <input type="hidden" name="customer_id" value="{{ $item->id }}">
        <input type="hidden" name="project_id" value="{{ $item->pid }}">
        {{-- <input type="hidden" name="product_id" value="{{ $product_id }}">
        <input type="hidden" name="chk_satrt" value="{{ $gauranteestart }}">
        <input type="hidden" name="chk_end" value="{{ $gauranteeend }}"> --}}
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h1 class="m-0">
                            บ้านเลขที่ {{ $item->HomeNo }} ห้องเลขที่ {{ $item->RoomNo }}
                            <a href="javascript:void(0);" class="btn bg-gradient-primary " type="button"
                                onclick="goBack();">
                                <i class="fa-solid fa fa-reply"></i> กลับ </a>
                        </h1>
                        
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
                        <div class="card">
                            <div class="card-header card-outline card-info">
                                <h3 class="card-title">รายละเอียดห้อง</h3>

                            </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-2">

                                            <div class="form-group">
                                                <label>โครงการ</label>
                                                <select name="project_id" id="project_id" class="form-control">
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
                                                <input class="form-control @error('numberhome') is-invalid @enderror" name="numberhome" type="text" value="{{ $item->numberhome ?? old('numberhome') ?? '' }}"
                                                    placeholder="ห้องเลขที่">
                                                @error('numberhome')
                                                    <div class="error text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>บ้านเลขที่</label>
                                                <input class="form-control @error('HomeNo') is-invalid @enderror" name="HomeNo" type="text" value="{{ $item->HomeNo ?? old('HomeNo') ?? '' }}"
                                                    placeholder="บ้านเลขที่">
                                                @error('HomeNo')
                                                    <div class="error text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>เจ้าของห้อง</label>
                                                <input class="form-control @error('onwername') is-invalid @enderror" name="onwername" type="text" value="{{ $item->Owner ?? old('onwername') ?? '' }}"
                                                    placeholder="เจ้าของห้อง">
                                                @error('onwername')
                                                    <div class="error text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>บัตรประชาชน</label>
                                                <input class="form-control @error('cardowner') is-invalid @enderror" name="cardowner" type="text" value="{{ $item->cardowner ?? old('cardowner') ?? '' }}"
                                                    placeholder="บัตรประชาชน">
                                                @error('cardowner')
                                                    <div class="error text-danger">{{ $message }}</div>
                                                @enderror
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
                                                <label class="text-danger">เลขที่สัญญา <u>*เจ้าของห้อง</u></label>
                                                <p class="form-control text-danger">{{ optional($lease_auto_code)->code_contract_owner ?? '' }}</p>
                                                    
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label class="text-danger">เลขที่สัญญา <u>*แต่งตั้งตัวแทน</u></font></label>
                                                <p class="form-control text-danger">{{ optional($lease_auto_code)->code_contract_agent ?? '' }}</p>
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
                                                <input class="form-control" name="owner_soi" type="text" value="{{ $item->owner_soi ??  old('owner_soi') ?? '' }}"
                                                    placeholder="ซอย">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>ถนน</label>
                                                <input class="form-control" name="owner_road" type="text" value="{{ $item->owner_road ?? old('owner_road') ?? '' }}"
                                                    placeholder="ถนน">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">                      
                                            <div class="form-group">
                                                <label for="owner_province">จังหวัด</label>
                                                <select name="owner_province" id="owner_province" class="form-control @error('owner_province') is-invalid @enderror">
                                                    @if (!$item->owner_province)
                                                        <option value="">-- เลือก --</option>
                                                    @endif
                                                    @if (old('owner_province'))
                                                        @foreach ($provinces as $province)
                                                            <option value="{{ $province->province_id }}"
                                                                {{ $province->province_id == old('owner_province') ? 'selected' : '' }}>
                                                                {{ $province->province }}
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        @foreach ($provinces as $province)
                                                            <option value="{{ $province->province_id }}"
                                                                {{ $province->province == $item->owner_province ? 'selected' : '' }}>
                                                                {{ $province->province }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('owner_province')
                                                    <div class="error text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="owner_khet">เขต/อำเภอ</label>
                                                <select name="owner_khet" id="owner_khet" class="form-control @error('owner_khet') is-invalid @enderror">
                                                    @if (!$item->owner_khet)
                                                        <option value="">-- เลือก --</option>
                                                    @endif
                                                    @if (old('owner_khet'))
                                                        @foreach ($amphoes as $amphure)
                                                            <option value="{{ $amphure->amphoe_id }}"
                                                                {{ $amphure->amphoe_id == old('owner_khet') ? 'selected' : '' }}>
                                                                {{ $amphure->amphoe }}
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        @foreach ($amphoes as $amphure)
                                                            <option value="{{ $amphure->amphoe_id }}"
                                                                {{ $amphure->amphoe == $item->owner_khet ? 'selected' : '' }}>
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
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="owner_district">แขวง/ตำบล</label>
                                                <select name="owner_district" id="owner_district"class="form-control @error('owner_district') is-invalid @enderror">
                                                    @if (!$item->owner_district)
                                                        <option value="">-- เลือก --</option>
                                                    @endif
                                                    @if (old('owner_district'))
                                                        @foreach ($tambons as $district)
                                                            <option value="{{ $district->tambon_id }}"
                                                                {{ $district->tambon_id == old('owner_district') ? 'selected' : '' }}>
                                                                {{ $district->tambon }}
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        @foreach ($tambons as $district)
                                                            <option value="{{ $district->tambon_id }}"
                                                                {{ $district->tambon == $item->owner_district ? 'selected' : '' }}>
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
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>เบอร์ติดต่อ</label>
                                                <input class="form-control @error('ownerphone') is-invalid @enderror" name="ownerphone" type="text" value="{{ $item->owner_phone ?? old('ownerphone') ?? '' }}"
                                                    placeholder="เบอร์ติดต่อ">
                                                @error('ownerphone')
                                                    <div class="error text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>วันรับห้อง</label>
                                                <input class="form-control datepicker" name="transfer_date" id="transfer_date" value="{{ $item->Transfer_Date ?? old('transfer_date') ?? '' }}"
                                                    placeholder="วันรับห้อง">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label class="text-danger"><b >*</b> เลขที่ห้อง</label>
                                                <input class="form-control @error('RoomNo') is-invalid @enderror" name="RoomNo" type="text" value="{{ $item->room_no ?? old('RoomNo') ?? '' }}"
                                                    placeholder="เลขที่ห้อง">
                                                @error('RoomNo')
                                                    <div class="error text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>ประเภทห้อง</label>
                                                <input class="form-control" name="room_type" type="text" value="{{ $item->RoomType ?? old('room_type') ?? '' }}"
                                                    placeholder="ประเภทห้อง">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>ขนาดห้อง</label>
                                                <input class="form-control" name="room_size" type="text" value="{{ $item->Size ?? old('room_size') ?? '' }}"
                                                    placeholder="ขนาดห้อง">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>ทิศ/ฝั่ง</label>
                                                <input class="form-control" name="Location" type="text" value="{{ $item->Location ?? old('Location') ?? '' }}"
                                                    placeholder="ทิศ/ฝั่ง">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>อาคาร</label>
                                                <input class="form-control" name="Building" type="text" value="{{ $item->Building ?? old('Building') ?? '' }}"
                                                    placeholder="อาคาร">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>ชั้น</label>
                                                <input class="form-control" name="Floor" type="text" value="{{ $item->Floor ?? old('Floor') ?? '' }}"
                                                    placeholder="ชั้น">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>กุญแจ หน้า</label>
                                                <input class="form-control" name="room_key_front" type="text" value="{{ $item->Key_front ?? old('room_key_front') ?? '' }}"
                                                    placeholder="กุญแจ หน้า">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>กุญแจ นอน</label>
                                                <input class="form-control" name="room_key_bed" type="text" value="{{ $item->Key_bed ?? old('room_key_bed') ?? '' }}"
                                                    placeholder="กุญแจ นอน">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>กุญแจ ระเบียง</label>
                                                <input class="form-control" name="room_key_balcony" type="text" value="{{ $item->Key_balcony ?? old('room_key_balcony') ?? '' }}"
                                                    placeholder="กุญแจ ระเบียง">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>กุญแจ Mail Box</label>
                                                <input class="form-control" name="room_key_mailbox" type="text" value="{{ $item->Key_mailbox ?? old('room_key_mailbox') ?? '' }}"
                                                    placeholder="กุญแจ Mail Box">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>คีย์การ์ด</label>
                                                <input class="form-control" name="room_card" type="text" value="{{ $item->KeyCard ?? old('room_card') ?? '' }}"
                                                    placeholder="คีย์การ์ด">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>คีย์การ์ด P</label>
                                                <input class="form-control" name="room_card_p" type="text" value="{{ $item->KeyCard_P ?? old('room_card_p') ?? '' }}"
                                                    placeholder="คีย์การ์ด P">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>คีย์การ์ด B</label>
                                                <input class="form-control" name="room_card_b" type="text" value="{{ $item->KeyCard_B ?? old('room_card_b') ?? '' }}"
                                                    placeholder="คีย์การ์ด B">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>คีย์การ์ด C</label>
                                                <input class="form-control" name="room_card_c" type="text" value="{{ $item->KeyCard_C ?? old('room_card_c') ?? ''}}"
                                                    placeholder="คีย์การ์ด C">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>ระยะเริ่มการันตี</label>
                                                <input class="form-control datepicker" name="gauranteestart" id="gauranteestart" value="{{ $item->Guarantee_Startdate ?? old('gauranteestart') ?? '' }}"
                                                    placeholder="ระยะเริ่มการันตี">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>ระยะสิ้นสุดการันตี</label>
                                                <input class="form-control datepicker" name="gauranteeend" id="gauranteeend" value="{{ $item->Guarantee_Enddate ?? old('gauranteeend') ?? '' }}"
                                                    placeholder="ระยะสิ้นสุดการันตี">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>วันที่ฝากเช่า</label>
                                                <input class="form-control datepicker" name="date_firstrend" id="date_firstrend"  type="text" value="{{ $item->date_firstrend ?? old('date_firstrend') ?? '' }}"
                                                    placeholder="วันที่ฝากเช่า">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>วันที่สิ้นสุดฝากเช่า</label>
                                                <input class="form-control datepicker" name="date_endrend" id="date_endrend" type="text" value="{{ $item->date_endrend ?? old('date_endrend') ?? '' }}"
                                                    placeholder="วันที่สิ้นสุดฝากเช่า">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>จำนวนเงินการันตี</label>
                                                <input class="form-control" name="gauranteeamount" type="text" value="{{ $item->Guarantee_Amount ?? old('gauranteeamount') ?? '' }}"
                                                    placeholder="จำนวนเงินการันตี">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>สถานะห้อง</label>
                                                <select class="form-control" name="Status_Room">
                                                    <option value="">-- เลือก --</option>
                                                    <option value="รอตรวจ" {{ $item->Status_Room == 'รอตรวจ' ? 'selected' : '' }}>รอตรวจ</option>
                                                    <option value="รอเฟอร์" {{ $item->Status_Room == 'รอเฟอร์' ? 'selected' : '' }}>รอเฟอร์</option>
                                                    <option value="รอคลีน" {{ $item->Status_Room == 'รอคลีน' ? 'selected' : '' }}>รอคลีน</option>
                                                    <option value="พร้อมอยู่" {{ $item->Status_Room == 'พร้อมอยู่' ? 'selected' : '' }}>พร้อมอยู่</option>
                                                    <option value="อยู่แล้ว" {{ $item->Status_Room == 'อยู่แล้ว' ? 'selected' : '' }}>อยู่แล้ว</option>
                                                    <option value="ห้องออฟฟิต" {{ $item->Status_Room == 'ห้องออฟฟิต' ? 'selected' : '' }}>ห้องออฟฟิต</option>
                                                    <option value="ห้องตัวอย่าง" {{ $item->Status_Room == 'ห้องตัวอย่าง' ? 'selected' : '' }}>ห้องตัวอย่าง</option>
                                                    <option value="จอง" {{ $item->Status_Room == 'จอง' ? 'selected' : '' }}>จอง</option>
                                                    <option value="สวัสดิการ" {{ $item->Status_Room == 'สวัสดิการ' ? 'selected' : '' }}>สวัสดิการ</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>วันที่รับค่าเช่างวดแรก</label>
                                                <input class="form-control datepicker" name="date_firstget" id="date_firstget" value="{{ $item->date_firstget ?? old('date_firstget') ?? '' }}"
                                                    placeholder="วันที่รับค่าเช่างวดแรก">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label class="text-danger">วันที่ *<u>ทำสัญญา</u></label>
                                                <input class="form-control datepicker @error('date_print_contract_manual') is-invalid @enderror" name="date_print_contract_manual" id="date_print_contract_manual" value="{{ $item->date_print_contract_manual ?? old('date_print_contract_manual') ?? '' }}"
                                                    placeholder="วันที่ ทำสัญญา">
                                                @error('date_print_contract_manual')
                                                    <div class="error text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>บัญชีแสดงสัญญา</label>
                                                <input class="form-control" name="Electric_Contract" type="text" value="{{ $item->Electric_Contract ?? old('Electric_Contract') ?? '' }}"
                                                    placeholder="บัญชีแสดงสัญญา">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>รหัสเครื่องวัดฯ</label>
                                                <input class="form-control" name="Meter_Code" type="text" value="{{ $item->Meter_Code ?? old('Meter_Code') ?? '' }}"
                                                    placeholder="รหัสเครื่องวัดฯ">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>ประเภทห้องเช่า</label>
                                                <select class="form-control" name="rental_status">
                                                    <option value="การันตี" {{ $item->rental_status == 'การันตี' ? 'selected' : '' }}>การันตี</option>
                                                    <option value="เบิกจ่ายล่วงหน้า" {{ $item->rental_status == 'เบิกจ่ายล่วงหน้า' ? 'selected' : '' }}>เบิกจ่ายล่วงหน้า</option>
                                                    <option value="ฝากต่อหักภาษี" {{ $item->rental_status == 'ฝากต่อหักภาษี' ? 'selected' : '' }}>ฝากต่อหักภาษี</option>
                                                    <option value="ฝากต่อไม่หักภาษี" {{ $item->rental_status == 'ฝากต่อไม่หักภาษี' ? 'selected' : '' }}>ฝากต่อไม่หักภาษี</option>
                                                    <option value="ฝากเช่า" {{ $item->rental_status == 'ฝากเช่า' ? 'selected' : '' }}>ฝากเช่า</option>
                                                    <option value="ติดต่อเจ้าของห้องไม่ได้" {{ $item->rental_status == 'ติดต่อเจ้าของห้องไม่ได้' ? 'selected' : '' }}>ติดต่อเจ้าของห้องไม่ได้</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>ราคาค่าเช่า</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" name="room_price" value="{{ $item->price ?? old('room_price') ?? '' }}">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                        <input type="checkbox" name="show_price" value="{{ $item->public ?? 0}}" {{ $item->public == 1 ? 'checked' : ''}}>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            {{-- <div class="form-group">
                                                <label>รูปภาพปก</label>
                                                <input class="form-control" id="filUploadMain" name="filUploadMain" type="file"
                                                    placeholder="รูปภาพปก">
                                            </div> --}}
                                        </div>
                                        <div class="col-sm-1"></div>

                                        <div class="col-sm-2">
                                            {{-- <div class="form-group">
                                                <label>รูปภาพห้อง</label>
                                                <input class="form-control" id="filUpload" name="filUpload[]" type="file"
                                                    placeholder="รูปภาพห้อง" multiple="multiple">
                                            </div> --}}
                                        </div>
                                        <div class="col-sm-1"></div>
                                        
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
                                            <input style="width: 15%" style="display: inline" name="room_Bed" type="number" value="{{ $item->Bed ?? old('room_Bed') ?? '' }}"> เตียง
                                        </p>
                                    </div>
                                    <div class="col-sm-2">
                                        <p class="form-group">
                                            <input style="width: 15%" style="display: inline" name="room_Beding" type="number" value="{{ $item->Beding ?? old('room_Beding') ?? '' }}"> เครื่องนอน
                                        </p>
                                    </div>

                                    <div class="col-sm-2">
                                        <p class="form-group">
                                            <input style="width: 15%" style="display: inline" name="room_Bedroom_Curtain" type="number" value="{{ $item->Bedroom_Curtain ?? old('room_Bedroom_Curtain') ?? '' }}"> ม่านห้องนอน
                                        </p>
                                    </div>

                                    <div class="col-sm-2">
                                        <p class="form-group">
                                            <input style="width: 15%" style="display: inline" name="room_Livingroom_Curtain" type="number" value="{{ $item->Livingroom_Curtain ?? old('room_Livingroom_Curtain') ?? '' }}"> ม่านห้องรับแขก
                                        </p>
                                    </div>

                                    <div class="col-sm-2">
                                        <p class="form-group">
                                            <input style="width: 15%" style="display: inline" name="room_Wardrobe" type="number" value="{{ $item->Wardrobe ?? old('room_Wardrobe') ?? '' }}"> ตู้เสื้อผ้า
                                        </p>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                    </div>
                                    <div class="col-sm-2">
                                        <p class="form-group">
                                            <input style="width: 15%" style="display: inline" name="room_Sofa" type="number" value="{{ $item->Sofa ?? old('room_Sofa') ?? '' }}"> โซฟา
                                        </p>
                                    </div>
                                    <div class="col-sm-2">
                                        <p class="form-group">
                                            <input style="width: 15%" style="display: inline" name="room_TV_Table" type="number" value="{{ $item->TV_Table ?? old('room_TV_Table') ?? '' }}"> โต๊ะวางโทรทัศน์
                                        </p>
                                    </div>

                                    <div class="col-sm-2">
                                        <p class="form-group">
                                            <input style="width: 15%" style="display: inline" name="room_Dining_Table" type="number" value="{{ $item->Dining_Table ?? old('room_Dining_Table') ?? '' }}"> โต๊ะกินข้าว
                                        </p>
                                    </div>

                                    <div class="col-sm-2">
                                        <p class="form-group">
                                            <input style="width: 15%" style="display: inline" name="room_Center_Table" type="number" value="{{ $item->Center_Table ?? old('room_Center_Table') ?? '' }}"> โต๊ะกลาง
                                        </p>
                                    </div>

                                    <div class="col-sm-2">
                                        <p class="form-group">
                                            <input style="width: 15%" style="display: inline" name="room_Chair" type="number" value="{{ $item->Chair ?? old('room_Chair') ?? '' }}"> เก้าอี้
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <p>เครื่องใช้ไฟฟ้า</p>
                                    </div>
                                    <div class="col-sm-2">
                                        <p class="form-group">
                                            <input style="width: 15%" style="display: inline" name="room_Bedroom_Air" type="number" value="{{ $item->Bedroom_Air ?? old('room_Bedroom_Air') ?? '' }}"> แอร์ห้องนอน
                                        </p>
                                    </div>
                                    <div class="col-sm-2">
                                        <p class="form-group">
                                            <input style="width: 15%" style="display: inline" name="room_Livingroom_Air" type="number" value="{{ $item->Livingroom_Air ?? old('room_Livingroom_Air') ?? '' }}"> แอร์ห้องรับแขก
                                        </p>
                                    </div>

                                    <div class="col-sm-2">
                                        <p class="form-group">
                                            <input style="width: 15%" style="display: inline" name="room_Water_Heater" type="number" value="{{ $item->Water_Heater ?? old('room_Water_Heater') ?? '' }}"> เครื่องทำน้ำอุ่น
                                        </p>
                                    </div>

                                    <div class="col-sm-2">
                                        <p class="form-group">
                                            <input style="width: 15%" style="display: inline" name="room_TV" type="number" value="{{ $item->TV ?? old('room_TV') ?? '' }}"> ทีวี
                                        </p>
                                    </div>

                                    <div class="col-sm-2">
                                        <p class="form-group">
                                            <input style="width: 15%" style="display: inline" name="room_Refrigerator" type="number" value="{{ $item->Refrigerator ?? old('room_Refrigerator') ?? '' }}"> ตู้เย็น
                                        </p>
                                    </div>
                                    
                                </div>
                            
                                <div class="row">
                                    <div class="col-sm-2">
                                    </div>
                                    <div class="col-sm-2">
                                        <p class="form-group">
                                            <input style="width: 15%" style="display: inline" name="room_microwave" type="number" value="{{ $item->wash_machine ?? old('room_microwave') ?? '' }}"> ไมโครเวฟ
                                        </p>
                                    </div>
                                    <div class="col-sm-2">
                                        <p class="form-group">
                                            <input style="width: 15%" style="display: inline" name="room_wash_machine" type="number" value="{{ $item->wash_machine ?? old('room_wash_machine') ?? '' }}"> เครื่องซักผ้า
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
                                        <textarea name="Other" id="" cols="33" rows="3">{{ $item->Other ?? old('Other') ?? '' }}</textarea>
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

                        <div class="card">
                            <div class="card-header card-outline card-info">
                                <h3 class="card-title">รายละเอียดเช่า</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>ลูกค้าเช่าซื้อ</label>
                                            <input class="form-control @error('Cus_Name') is-invalid @enderror" name="Cus_Name" type="text" value="{{ $item->Cus_Name ?? '' }}"
                                                placeholder="ลูกค้าเช่าซื้อ">
                                            @error('Cus_Name')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>เลขบัตรประชาชน</label>
                                            <input class="form-control @error('IDCard') is-invalid @enderror" name="IDCard" type="text" value="{{ $item->IDCard ?? ''}}"
                                                placeholder="เลขบัตรประชาชน">
                                            @error('IDCard')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        @if (!$item->file_id_path_cus)
                                            <div class="form-group">
                                                <label>อัปโหลดไฟล์</label>
                                                <input class="form-control" name="file_id_path_cus" type="file" 
                                                    placeholder="อัปโหลดไฟล์">
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="text-danger">เลขที่สัญญา *<u>ผู้เช่า</u></label>
                                            <p class="form-control text-danger">{{ optional($lease_auto_code)->code_contract_cus ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="text-danger">เลขที่สัญญา *<u>ประกันทรัพย์สิน</u></label>
                                            <p class="form-control text-danger">{{ optional($lease_auto_code)->code_contract_insurance ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="text-danger">เลขที่สัญญาเก่า *<u>กรณีต่อสัญญา</u></label>
                                            <input class="form-control text-danger" name="code_contract_old" type="text" value="{{ $item->code_contract_old ?? '' }}"
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
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
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
                                            <input class="form-control @error('cus_homeAddress') is-invalid @enderror" name="cus_homeAddress" type="text" value="{{ $item->home_address ?? old('cus_homeAddress') ?? '' }}"
                                                placeholder="บ้านเลขที่">
                                        </div>
                                        @error('cus_homeAddress')
                                            <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>ซอย</label>
                                            <input class="form-control" name="cust_soi" type="text" value="{{ $item->cust_soi ?? old('cust_soi') ?? '' }}"
                                                placeholder="ซอย">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>ถนน</label>
                                            <input class="form-control" name="cust_road" type="text" value="{{ $item->cust_road ?? old('cust_road') ?? '' }}"
                                                placeholder="ถนน">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="cus_province">จังหวัด</label>
                                            <select name="cus_province" id="cus_province" class="form-control @error('cus_province') is-invalid @enderror">
                                                @if (!$item->province)
                                                    <option value="">-- เลือก --</option>
                                                @endif
                                                @if (old('cus_province'))
                                                    @foreach ($provinces as $province)
                                                        <option value="{{ $province->province_id }}"
                                                            {{ $province->province_id == old('cus_province') ? 'selected' : '' }}>
                                                            {{ $province->province }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    @foreach ($provinces as $province)
                                                        <option value="{{ $province->province_id }}"
                                                            {{ $province->province == $item->province ? 'selected' : '' }}>
                                                            {{ $province->province }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('cus_province')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                       
                                    </div>
                                    <div class="col-sm-1"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="cus_aumper">เขต/อำเภอ</label>
                                            <select name="cus_aumper" id="cus_aumper" class="form-control @error('cus_aumper') is-invalid @enderror">
                                                @if (!$item->aumper)
                                                    <option value="">-- เลือก --</option>
                                                @endif
                                                @if(old('cus_aumper'))
                                                    @foreach ($amphoes as $amphure)
                                                        <option value="{{ $amphure->amphoe_id }}"
                                                            {{ $amphure->amphoe_id == old('cus_aumper') ? 'selected' : '' }}>
                                                            {{ $amphure->amphoe }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    @foreach ($amphoes as $amphure)
                                                        <option value="{{ $amphure->amphoe_id }}"
                                                            {{ $amphure->amphoe == $item->aumper ? 'selected' : '' }}>
                                                            {{ $amphure->amphoe }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                                
                                            </select>
                                            @error('cus_aumper')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="cus_tumbon">แขวง/ตำบล</label>
                                            <select name="cus_tumbon" id="cus_tumbon" class="form-control @error('cus_tumbon') is-invalid @enderror">
                                                @if (!$item->tumbon)
                                                    <option value="">-- เลือก --</option>
                                                @endif
                                                @if(old('cus_tumbon'))
                                                    @foreach ($tambons as $district)
                                                        <option value="{{ $district->tambon_id }}"
                                                            {{ $district->tambon_id == old('cus_tumbon') ? 'selected' : '' }}>
                                                            {{ $district->tambon }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    @foreach ($tambons as $district)
                                                        <option value="{{ $district->tambon_id }}"
                                                            {{ $district->tambon == $item->tumbon ? 'selected' : '' }}>
                                                            {{ $district->tambon }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('cus_tumbon')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="cus_idPost">รหัสไปรษณีย์</label>
                                            <input class="form-control @error('cus_idPost') is-invalid @enderror" name="cus_idPost" id="cus_idPost" type="text" value="{{ $item->id_post ?? old('cus_idPost') ?? '' }}"
                                                placeholder="รหัสไปรษณีย์">
                                            @error('cus_idPost')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>เบอร์โทรศัพท์</label>
                                            <input class="form-control @error('cus_phone') is-invalid @enderror" name="cus_phone" type="text" value="{{ $item->Phone ?? old('cus_phone') ?? '' }}"
                                                placeholder="เบอร์โทรศัพท์">
                                            @error('cus_phone')
                                                <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>วันเริ่มสัญญา</label>
                                            @if ($item->Contract_Startdate)
                                                <div class="date_rent_show">
                                                    <p class="form-control text-danger" name="Contract_Startdate" readonly> {{ $item->Contract_Startdate }} </p>
                                                    <input class="form-control datepicker" name="Contract_Startdate" type="hidden" value="{{ $item->Contract_Startdate }}">
                                                </div>
                                                <div class="date_rent">
                                                    <input class="form-control datepicker" name="Contract_Startdate_Renew" type="text" value="{{ old('Contract_Startdate_Renew') ?? '' }}"
                                            placeholder="วันเริ่มสัญญา">
                                                </div>
                                            @else
                                                <input class="form-control datepicker @error('Contract_Startdate') is-invalid @enderror" name="Contract_Startdate" type="text" value="{{ old('Contract_Startdate') ?? '' }}"
                                            placeholder="วันเริ่มสัญญา">
                                                @error('Contract_Startdate')
                                                    <div class="error text-danger">{{ $message }}</div>
                                                @enderror
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>วันสิ้นสุดสัญญา</label>
                                            @if ($item->Contract_Enddate)
                                                <div  class="date_rent_show">
                                                    <p class="form-control text-danger" name="Contract_Enddate" readonly> {{ $item->Contract_Enddate }} </p>
                                                    <input class="form-control datepicker" name="Contract_Enddate" type="hidden" value="{{ $item->Contract_Enddate }}">
                                                </div>
                                                <div  class="date_rent">
                                                    <input class="form-control datepicker" name="Contract_Enddate_Renew" type="text" value="{{ old('Contract_Enddate_Renew') ?? '' }}"
                                            placeholder="วันสิ้นสุดสัญญา">
                                                </div>
                                            @else
                                                <input class="form-control datepicker @error('Contract_Enddate') is-invalid @enderror" name="Contract_Enddate" type="text" value="{{ old('Contract_Enddate') ?? '' }}"
                                            placeholder="วันสิ้นสุดสัญญา">
                                                @error('Contract_Enddate')
                                                    <div class="error text-danger">{{ $message }}</div>
                                                @enderror
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>ระยะเวลา</label>
                                            @if ($item->Contract)
                                                <div class="date_rent_show">
                                                    <input class="form-control" name="Contract" type="hidden" value="{{ $item->Contract }}">
                                                    <p class="form-control"><font color="red">{{ $item->Contract }}</font> เดือน <input name="Day" type="text" value="{{ $item->Day ?? old('Day') ?? 0 }}" style="width:25%; margin-left:10px;"> วัน </p>
                                                </div>
                                                <div class="date_rent">
                                                    <p class="form-control"><input name="Contract_Renew" type="number" value="{{ old('Contract_Renew') ?? '' }}" style="width: 25%"> เดือน <input name="Day_Renew" type="number" value="{{ old('Day_Renew') ?? '' }}" style="width:25%; margin-left:15px;"> วัน </p>
                                                </div>
                                            @else
                                                <p class="form-control @error('Contract') is-invalid @enderror"><input name="Contract" type="number" value="{{ old('Contract') ?? '' }}" style="width: 25%"> เดือน <input name="Day" type="number" value="{{ old('Day') ?? '' }}" style="width:25%; margin-left:15px;"> วัน </p>
                                                @error('Contract')
                                                    <div class="error text-danger">{{ $message }}</div>
                                                @enderror
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>วันที่เริ่มจ่ายงวดแรก</label>
                                            @if ($item->start_paid_date)
                                                <div class="date_rent_show">
                                                    <p class="form-control text-danger" readonly>{{ $item->start_paid_date }}</p>
                                                    <input class="form-control" name="start_paid_date" type="hidden" value="{{ $item->start_paid_date }}">
                                                </div>
                                                <div class="date_rent">
                                                    <input class="form-control datepicker" name="start_paid_date_Renew" type="text" value="{{ old('start_paid_date_Renew') ?? '' }}" placeholder="วันที่เริ่มจ่ายงวดแรก">
                                                </div>
                                                
                                            @else
                                                <input class="form-control datepicker @error('start_paid_date') is-invalid @enderror" name="start_paid_date" type="text" value="{{ old('start_paid_date') ?? '' }}"
                                            placeholder="วันที่เริ่มจ่ายงวดแรก">
                                                @error('start_paid_date')
                                                    <div class="error text-danger">{{ $message }}</div>
                                                @enderror
                                            @endif
                                            
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
                                            <input class="form-control" name="Price" type="text" value="{{ $item->Price ?? old('Price') ?? '' }}"
                                                placeholder="ราคา"> บาท
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>สัญญา</label>
                                            <select class="form-control" name="Contract_Reason">
                                                <option value="">--เลือก--</option>
                                                <option value="เซ็นครบ-เอกสารสมบูรณ์" {{ $item->Contract_Reason == 'เซ็นครบ-เอกสารสมบูรณ์' ? 'selected' : '' }}>เซ็นครบ-เอกสารสมบูรณ์</option>
                                                <option value="ลูกค้ายังไม่เซนต์" {{ $item->Contract_Reason == 'ลูกค้ายังไม่เซนต์' ? 'selected' : '' }}>ลูกค้ายังไม่เซนต์</option>
                                                <option value="อยู่ระหว่างดำเนินการเซ็นสัญญา" {{ $item->Contract_Reason == 'อยู่ระหว่างดำเนินการเซ็นสัญญา' ? 'selected' : '' }}>อยู่ระหว่างดำเนินการเซ็นสัญญา</option>
                                                <option value="ยกเลิกสัญญา" {{ $item->Contract_Reason == 'ยกเลิกสัญญา' ? 'selected' : '' }}>ยกเลิกสัญญา</option>
                                                <option value="สัญญาฉบับจริงไม่พบ" {{ $item->Contract_Reason == 'สัญญาฉบับจริงไม่พบ' ? 'selected' : '' }}>สัญญาฉบับจริงไม่พบ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>สถานะเช่า</label>
                                                <select class="form-control" name="Contract_Status" id="ddl">
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

                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>วันออก</label>
                                            <input class="form-control datepicker" name="Cancle_Date" id="Cancle_Date" value="{{ $item->date_firstget ?? old('Cancle_Date') ?? '' }}"
                                                placeholder="วันออก">
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>หมายเหตุ ลูกค้า</label>
                                                    <textarea class="form-control" name="cust_remark" id="" cols="5" rows="3">{{ $item->cust_remark ?? old('cust_remark') ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        
                                    </div>
                                    <div class="col-sm-1"></div>

                                    <div class="col-sm-2">
                                        
                                    </div>
                                    <div class="col-sm-1"></div>

                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            <label style="margin-left: 20px;">รูปภาพปก</label>
                                            @if ($item->image)
                                                <div class="mt-3"><img src="{{ asset($item->image) }}" height="160" style="border-radius: 10%; margin-top: 5px;"/></div>
                                            @else
                                                <img src="{{ url('uploads/noimage.jpg') }}" class="size-image" style="border-radius: 10px;">
                                            @endif
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-1"></div> --}}

                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            <label style="margin-left: 160px; width: 100%">รูปภาพห้อง</label>
                                        </div>
                                    </div>
                                    @forelse ($images as $image)
                                        <div class="col-sm-1">
                                            <div class="form-group">
                                                <label></label>
                                                <span><img src="{{ asset($image->img_path) }}" height="160" style="border-radius: 10%; margin-top: 30px;" height="50"/></span>
                                                    <button class="btn bg-gradient-danger btn-sm delete-room-img"
                                                    data-id="{{ $image->id }}" data-rid="{{ $image->rid }}" title="ลบ" style="margin-left: 100px; margin-top: 2px;">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>
                                    @empty
                                        <div class="col-sm-1">
                                            <div class="form-group">
                                                <label></label>
                                                <img src="{{ url('uploads/noimage.jpg') }}" class="size-image" style="border-radius: 10px; margin-top: 9px;">
                                            </div>
                                        </div>
                                        <div class="col-sm-1"></div>
                                    @endforelse
                                </div>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header card-outline card-info">
                                <h3 class="card-title">อัพโหลดรูป</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <img src="{{ url('uploads/noimage.jpg') }}" class="size-image"
                                                                    alt="" id="img-cover" style="border-radius: 10px;">
                                        <div class="form-group">
                                            <br>
                                            <label for="exampleInputFile">รูปภาพปก</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input"
                                                        onchange="previewImage(event)" accept="image/jpeg, image/jpg, image/png"
                                                        id="filUploadMain" name="filUploadMain">
                                                    <label class="custom-file-label"
                                                        for="exampleInputFile"></label>
                                                </div>
    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div id="imagePreview1">
                                            <img src="{{ url('uploads/noimage.jpg') }}" class="size-image"
                                                                    alt="" id="room1" style="border-radius: 10px;">
                                        </div>
                                        <div class="form-group">
                                            <br>
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
                                    </div>
                                    <div class="col-sm-3">
                                        <div id="imagePreview2">
                                            <img src="{{ url('uploads/noimage.jpg') }}" class="size-image"
                                                                    alt="" id="room2" style="border-radius: 10px;">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div id="imagePreview3">
                                            <img src="{{ url('uploads/noimage.jpg') }}" class="size-image"
                                                                    alt="" id="room3" style="border-radius: 10px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div id="imagePreview4">
                                        </div>
                                    </div>
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
                                </div>
    
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div id="imagePreview4">
                                        </div>
                                    </div>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    @endforeach
</form>
@endsection
@push('script')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd', // รูปแบบวันที่
            autoclose: true,
        });

        const ddl = $("#ddl").val();

        if (ddl != 'ต่อสัญญา') {
            $(".date_rent").hide();
        }

        $("#ddl").change(function() {
            const ddl = $("#ddl").val();
            if (ddl == 'ต่อสัญญา') {
                $(".date_rent").show();
                $(".date_rent_show").hide();

            } else {
                $(".date_rent").hide();
                $(".date_rent_show").show();
            }
        });

        //Delete
        $('body').on('click', '.delete-room-img', function(event) {
            event.preventDefault();
            const id = $(this).data("id");
            const rid = $(this).data("rid");
            console.log(id,rid);

            Swal.fire({
                title: 'คุณแน่ใจไหม? ',
                text: "หากต้องการลบรูปภาพนี้ โปรดยืนยัน การลบข้อมูล",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'ยกเลิก',
                confirmButtonText: 'ยืนยัน'
            }).then((result) => {

                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: '../../api/room/deleteImageRoom/' + id + '/' + rid,

                        success: function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: data.message,
                                showConfirmButton: true,
                                timer: 2500
                            });

                            setTimeout(function(){
                                    location.reload();
                                },1500);

                        },
                    });
                }
            });

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

    function cusAmphoes() {
            let input_province = document.querySelector("#cus_province");                    
            let url = "{{ url('../api/rental/amphoes') }}?province_id=" + input_province.value;
            fetch(url)
                .then(response => response.json())
                .then(result => {
                    let input_amphoe = document.querySelector("#cus_aumper");
                    input_amphoe.innerHTML = '<option value="">กรุณาเลือกเขต/อำเภอ</option>';
                for (let item of result) {
                    let option = document.createElement("option");
                    option.text = item.amphoe;
                    option.value = item.amphoe_id;
                    input_amphoe.appendChild(option);
                }
                cusTambons();
            });
    }

    function cusTambons() {
        let input_province = document.querySelector("#cus_province");
        let input_amphoe = document.querySelector("#cus_aumper");
        let url = "{{ url('../api/rental/tambons') }}?province_id=" + input_province.value + "&amphoe_id=" + input_amphoe
                .value;
        fetch(url)
            .then(response => response.json())
            .then(result => {
                let input_tambon = document.querySelector("#cus_tumbon");
                input_tambon.innerHTML = '<option value="">กรุณาเลือกแขวง/ตำบล</option>';
                for (let item of result) {
                    let option = document.createElement("option");
                    option.text = item.tambon;
                    option.value = item.tambon_id;
                    input_tambon.appendChild(option);
                }
                showZipcode(); // เรียกใช้ showZipcode เมื่อมีการเลือกอำเภอและตำบลใหม่
            });
    }

    function showZipcode() {
        let input_zipcode = document.querySelector("#cus_idPost");
        input_zipcode.value = '';
        let input_province = document.querySelector("#cus_province");
        let input_amphoe = document.querySelector("#cus_aumper");
        let input_tambon = document.querySelector("#cus_tumbon");
        let url = "{{ url('../api/rental/zipcodes') }}?province_id=" + input_province.value + "&amphoe_id=" + input_amphoe
            .value + "&tambon_id=" + input_tambon.value;
        fetch(url)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                // let input_zipcode = document.querySelector("#cus_idPost");
                input_zipcode.value = result[0].zipcode; // แสดง zipcode ที่ได้รับจาก API
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

    // EVENTS CUSTOMER
    document.querySelector('#cus_province').addEventListener('change', (event) => {
        cusAmphoes();
    }); 
    document.querySelector('#cus_aumper').addEventListener('change', (event) => {
        cusTambons();
    });
    document.querySelector('#cus_tumbon').addEventListener('change', (event) => {
        showZipcode();
    });
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
            imagePreviewContainer.innerHTML = ''; // Clear previous previews
            var reader = new FileReader();
            reader.onload = function(e) {
                let elem = 'room'+j;
                console.log(elem);
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