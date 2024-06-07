@extends('layouts.app')

@section('title', 'แดชบอร์ด')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>รายชื่อ โครงการ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('main') }}">Home</a></li>
                        <li class="breadcrumb-item active">รายละเอียดโครงการ (ออกสัญญา)</li>
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
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ชื่อโครงการ(EN)</th>
                                        <th>ชื่อโครงการ(TH)</th>
                                        <th>ที่อยู่</th>
                                        <th>แก้ไข</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projects as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data->Project_Name }}</td>
                                            <td>{{ $data->Project_NameTH }}</td>
                                            <td>{{ $data->address_full }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning edit-btn" data-toggle="modal"
                                                    data-target="#editmodal2{{ $data->pid }}">แก้ไข</button>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="editmodal2{{ $data->pid }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขข้อมูล :
                                                            <font class="text-danger"> {{ $data->Project_Name }} </font>
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close" id="close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('out.update') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" class="form-control" name="pid"
                                                                id="pid" value="{{ $data->pid }}">

                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">ชื่อ TH
                                                                    :</label>
                                                                <input type="text" class="form-control text-danger"
                                                                    id="Project_NameTH" name="Project_NameTH"
                                                                    value="{{ $data->Project_NameTH }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">ที่อยู่
                                                                    :</label>
                                                                <textarea class="form-control text-danger" name="address_full" id="address_full" rows="3">{{ $data->address_full }}</textarea>
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
    <script>
        $(document).ready(function(){
            $('.edit-btn').click(function() {
                var modalId = $(this).data('target'); // Get the target modal ID
                var inputs = $(modalId).find('input');
                var textarea = $(modalId).find('textarea');
                var Project_NameTH = $(modalId).find('#Project_NameTH').val().trim();
                var address_full = $(modalId).find('#address_full').val().trim();

                // Remove previous invalid feedback
                $(modalId).find('.is-invalid').removeClass('is-invalid');

                inputs.removeClass('is-invalid').on('input', function() {
                    // Remove is-invalid class when user starts typing
                    $(this).removeClass('is-invalid');
                    $("button[name='update']").prop("disabled", false);
                });
                textarea.removeClass('is-invalid').on('input', function() {
                    // Remove is-invalid class when user starts typing
                    $(this).removeClass('is-invalid');
                    $("button[name='update']").prop("disabled", false);
                });
                // Validation
                if (!Project_NameTH) {
                    $(modalId).find('#Project_NameTH').addClass('is-invalid');
                }
                if (!address_full) {
                    $(modalId).find('#address_full').addClass('is-invalid');
                }
                   
                if (!Project_NameTH || !address_full) {
                    $("button[name='update']").prop("disabled", true);
                }else{
                    $("button[name='update']").prop("disabled", false);
                }
                
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
            $('#example1').DataTable({
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
@endsection
