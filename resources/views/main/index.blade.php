@extends('layouts.app')

@section('title', 'แดชบอร์ด')

@section('content')

    @push('style')
        <style>


            #table thead th {
                font-size: 13px;
            }

            #table tbody td {
                font-size: 13px;
                /* text-align: center; */
                vertical-align: middle;
            }
            #badge {
                font-size: 12px;
                /* color: #000 !important; */
            }
        </style>
    @endpush


    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">แดชบอร์ด</h1>
                </div><!-- /.col -->
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



                </div>

            </div>

        </div><!-- /.container-fluid -->
    </section>
@endsection

