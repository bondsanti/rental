@extends('layouts.app')

@section('title', 'แดชบอร์ด')

@section('content')
    <style>
        input[type="date"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin: auto;
        }
    </style>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        SummaryRental

                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('main') }}">Home</a></li>
                        <li class="breadcrumb-item active">SummaryRental</li>
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
                        <div class="card-header">
                            <h3 class="card-title">ค้นหา SummaryRental</h3>
                        </div>
                        <form action="{{ route('report.search') }}" method="POST" id="reportSearch">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <div class="form-row">
                                            <div class="col-sm-12 input-wrapper">
                                                <label for="date1">วันที่</label>
                                                <input type="date" name="date1" id="date1" value="{{ $date1 }}">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                                <br>
                                <div class="box-footer text-center">
                                    <button type="submit" name="search" class="btn bg-gradient-success"><i
                                            class="fa fa-search"></i>
                                        ค้นหา</button>
                                    <a href="{{ route('report.rental') }}" type="button" class="btn bg-gradient-danger"><i
                                            class="fa fa-refresh"></i> เคลียร์</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-info btn-block">
                                <h4 class="mt-2"><i class="fa fa-exclamation"></i> กรุณา ค้นหา SummaryRental</h4>
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
