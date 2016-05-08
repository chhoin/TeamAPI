@extends('app') @section('head')
    <link rel="stylesheet"
          href="{{ asset('asset/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('asset/sweetalert/sweetalert.css') }}">
@stop @section('body')
    <div class='container-fluid'>
        <div class='row'>
            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                <div class="panel panel-primary">
                    <div class="panel-heading ">menu</div>
                    <div class="panel-body">
                        <ul class="nav  bg-info">
                            <li><a href="{{ URL::to('/article') }}">Article</a></li>
                            <li><a href="{{ URL::to('/category') }}">Category</a></li>
                            <li><a href="{{ URL::to('/product') }}">Product</a></li>
                            <li><a href="#">Log Out</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop @section('footer')
@stop