@extends('layouts.app')

@section('title', 'กำหนดรูปแบบ เลขที่สัญญาเช่า')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>กำหนดรูปแบบ เลขที่สัญญาเช่า</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('main')}}">Home</a></li>
                        <li class="breadcrumb-item active">Codeสัญญา</li>
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
                        <div class="card-header"></div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>โครงการ</th>
                                        <th>สัญญาเช่าช่วง</th>
                                        <th>สัญญาประกันทรัพย์สิน</th>
                                        <th>สัญญาเช่า</th>
                                        <th>สัญญาแต่งตั้งตัวแทน</th>
                                        <th>แก้ไข</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Lease_code as $key=>$lcode)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $lcode->Project_Name }}</td>
                                            <td>{{ $lcode->sub_lease_code }}</td>
                                            <td>{{ $lcode->insurance_code }}</td>
                                            <td>{{ $lcode->lease_agr_code }}</td>
                                            <td>{{ $lcode->agent_contract_code }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning edit-btn" data-toggle="modal"
                                                    data-target="#editmodal1{{$lcode->lease_code_id}}" id="edit">แก้ไข</button>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="editmodal1{{$lcode->lease_code_id}}" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">
                                                            แก้ไขรูปแบบสัญญาโครงการ : <font class="text-danger">
                                                            {{ $lcode->Project_Name }}</font>
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('contract.update')}}" method="POST">
                                                            @csrf
                                                            <input type="hidden" class="form-control" name="lease_code_id"
                                                                value="{{ $lcode->lease_code_id}}">
                                                            <input type="hidden" class="form-control" name="pid"
                                                                value="{{ $lcode->pid }}">
                                                            <div class="form-group" id="formGrup1">
                                                                <label for="recipient-name" 
                                                                    class="col-form-label">สัญญาเช่าช่วง
                                                                    :</label>
                                                                <input type="text" class="form-control text-danger"
                                                                    name="sub_lease_code" id="sub_lease_code" value="{{ $lcode->sub_lease_code ?? '' }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="recipient-name"
                                                                    class="col-form-label">สัญญาประกันทรัพย์สิน :</label>
                                                                <input type="text" class="form-control text-danger"
                                                                    name="insurance_code" id="insurance_code" value="{{ $lcode->insurance_code }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">สัญญาเช่า
                                                                    :</label>
                                                                <input type="text" class="form-control text-danger"
                                                                    name="lease_agr_code" id="lease_agr_code" value=" {{ $lcode->lease_agr_code }} ">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="recipient-name"
                                                                    class="col-form-label">สัญญาแต่งตั้งตัวแทน :</label>
                                                                <input type="text" class="form-control text-danger"
                                                                    name="agent_contract_code" id="agent_contract_code" value="{{ $lcode->agent_contract_code }}">
                                                            </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal" id="btnClose">ออก</button>
                                                        <button type="submit" name="update"
                                                            class="btn btn-primary">บันทึก</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection
    @push('script')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                $('.edit-btn').click(function() {
                    var modalId = $(this).data('target'); // Get the target modal ID
                    var inputs = $(modalId).find('input');
                    var sub_lease_code = $(modalId).find('#sub_lease_code').val().trim();
                    var insurance_code = $(modalId).find('#insurance_code').val().trim();
                    var lease_agr_code = $(modalId).find('#lease_agr_code').val().trim();
                    var agent_contract_code = $(modalId).find('#agent_contract_code').val().trim();

                    // Remove previous invalid feedback
                    $(modalId).find('.is-invalid').removeClass('is-invalid');

                    inputs.removeClass('is-invalid').on('input', function() {
                        // Remove is-invalid class when user starts typing
                        $(this).removeClass('is-invalid');
                        $("button[name='update']").prop("disabled", false);
                    });
                    // Validation
                    if (!sub_lease_code) {
                        $(modalId).find('#sub_lease_code').addClass('is-invalid');
                    }
                    if (!insurance_code) {
                        $(modalId).find('#insurance_code').addClass('is-invalid');
                    }
                    if (!lease_agr_code) {
                        $(modalId).find('#lease_agr_code').addClass('is-invalid');
                    }
                    if (!agent_contract_code) {
                        $(modalId).find('#agent_contract_code').addClass('is-invalid');
                    }

                    if (!sub_lease_code || !insurance_code || !lease_agr_code || !agent_contract_code) {
                        $("button[name='update']").prop("disabled", true);
                    }else{
                        $("button[name='update']").prop("disabled", false);
                    }
                    
                    console.log(sub_lease_code,insurance_code);
                });

                $('#close').click(function() {
                    var modalId = $(this).data('target');
                    $(modalId).trigger("reset");
                    $(modalId).modal('hide');
                });

                $('#btnClose').click(function() {
                    var modalId = $(this).data('target');
                    $(modalId).trigger("reset");
                    $(modalId).modal('hide');
                });
                
            
            });
            $(function() {
                $('#example2').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });
            });
        </script>                
    @endpush
    

