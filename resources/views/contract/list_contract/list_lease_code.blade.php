@extends('layouts.app')

@section('title', 'ทะเบียนสัญญาเช่า')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">รายละเอียดทะเบียนสัญญา</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-outline card-info">
                            <h3 class="card-title">ค้นหา รายละเอียดทะเบียนสัญญา</h3>
                        </div>
                        <form action="{{ route('list.search') }}" method="POST" id="listSearch">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <div class="form-row">
                                            <div class="col-sm-6">
                                                <label>โครงการ</label>
                                                <select name="pid" id="pid" class="form-control">
                                                    <option value="all">โครงการ ทั้งหมด</option>
                                                    @foreach ($projects as $project)
                                                        <option value="{{ $project->pid }}">{{ $project->Project_Name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="validationDefault04">ปี</label>
                                                <select class="form-control" name="year">
                                                    <option value="">ทั้งหมด</option>
                                                    @php
                                                        $yearmax = date('Y') + 543;
                                                        $yearmin = '2553';
                                                    @endphp

                                                    @for ($y = $yearmin; $y <= $yearmax; $y++)
                                                        <option value="{{ $y }}"
                                                            {{ $yearmax == $y ? 'selected' : '' }}>{{ $y }}
                                                        </option>
                                                    @endfor
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                                <br>
                                <div class="box-footer text-center">
                                    <button type="submit" name="search" class="btn bg-gradient-success"><i class="fa fa-search"></i>
                                        ค้นหา</button>
                                    <a href="{{ route('contract.list') }}" type="button" class="btn bg-gradient-danger"><i
                                            class="fa fa-refresh"></i> เคลียร์</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-info btn-block">
                                <h4 class="mt-2"><i class="fa fa-exclamation"></i> กรุณา ค้นหา ทะเบียนสัญญา</h4>
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>





@endsection
