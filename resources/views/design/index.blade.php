@extends('master')
@section('titlePage')
    Design
@endsection
@section('shortcutPage')
    <link rel="shortcut icon" href="{!! asset('public/main/icons/3dlogo128.png') !!}"/>
@endsection

{{--css--}}
@section('tf_master_page_css')
    <link href="{{ url('public/design/css/design.css')}}" rel="stylesheet">
@endsection

{{--js--}}
@section('tf_master_page_js_header')
    <script src="{{ url('public/design/js/design.js')}}"></script>
@endsection

{{--========== ========= header content ========= ========== --}}
{{--left header--}}
@section('tf_main_header_Left')
    {{--search--}}
    @include('components.search.search-form')
@endsection

{{--========== ========= main content ========= ========== --}}
@section('tf_main_content')
    <div class="tf-design-wrap tf-border-none">
        <div class="container tf-design-content tf-border-none">
            <!-- banner -->
            <div class="row ">
                <div class=" col-xs-12 col-md-12 col-lg-12 tf-design-top text-center ">
                    <img class="tf-height-full" src="{!! asset('public/imgsample/test.jpg') !!}"/>
                </div>
            </div>

            {{--menu--}}
            <div class="row">
                <nav class="navbar navbar-default navbar-static-top tf-font-bold " role="navigation"
                     style="background-color: #d7d7d7;">
                    <div class="container ">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header ">
                            <button type="button" class="navbar-toggle" data-toggle="collapse"
                                    data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse " id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav navbar-left ">
                                <li class="dropdown ">
                                    <a class="@if($name=='storeDesign' or $name=='') tf-bg-active tf-border-radius-8 @endif"
                                       href="{!! URL::route('tf.design.store.get') !!}">
                                        Store design
                                    </a>
                                </li>
                                <li class="dropdown ">
                                    <a class="@if($name=='uploadDesign' or $name=='') tf-bg-active tf-border-radius-8 @endif"
                                       href="{!! URL::route('tf.uploadDesign') !!}">
                                        Upload design
                                    </a>
                                </li>
                                <li class="dropdown ">
                                    <a class="@if($name=='requestDesign' or $name=='') tf-bg-active tf-border-radius-8 @endif"
                                       href="{!! URL::route('tf.requestDesign') !!}">
                                        Request design
                                    </a>
                                </li>
                                <li class="dropdown ">
                                    <a class="@if($name=='shopDesign' or $name=='') tf-bg-active tf-border-radius-8 @endif"
                                       href="{!! URL::route('tf.shopDesign') !!}">
                                        Shop design
                                    </a>
                                </li>
                                <li class="dropdown ">
                                    <a class="@if($name=='systemDesign' or $name=='') tf-bg-active tf-border-radius-8 @endif"
                                       href="{!! URL::route('tf.systemDesign') !!}">
                                        System design
                                    </a>
                                </li>
                                <li class="dropdown ">
                                    <a class="@if($name=='confirmDesign' or $name=='') tf-bg-active tf-border-radius-8 @endif"
                                       href="{!! URL::route('tf.confirmDesign') !!}">
                                        Confirm design
                                    </a>
                                </li>
                                <li class="dropdown ">
                                    <a class="" href="{!! URL::route('tf.help') !!}">
                                        Help
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.navbar-collapse -->
                    </div>
                    <!-- /.container-fluid -->
                </nav>
            </div>

            {{--content design--}}
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    @yield('tf_design_main_content')
                </div>
            </div>

        </div>
    </div>
@endsection