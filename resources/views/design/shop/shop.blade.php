@extends('design.index')
@section('titlePage')
    Shop
@endsection
@section('tf_design_main_content')
    <div class="panel panel-default tf-border-none">

        <!-- menu -->
        <div class="panel-heading tf-bg-none tf-border-none">
            <select class="tf-float-right">
                <option>All business</option>
                <option>type business 1</option>
                <option>type business 2</option>
                <option>type business 3</option>
            </select>
            <ul class="nav nav-tabs" role="tablist">
                <li class="active">
                    <a class="tf-link" href="#">List</a>
                </li>
            </ul>

        </div>
        <!-- end menu -->

        <!-- content shop -->
        <div class="panel-body ">
            <div class="table-responsive ">
                <table class="table table-hover ">
                    <tr>
                        <th>Image</th>
                        <th style="width: 300px;">Request</th>
                        <th>Size design<br />(Width/Height)</th>
                        <th>Date<br />(design)</th>
                        <th>Price</th>
                        <th>Order</th>
                    </tr>
                    <tr>
                        <td>
                            <img style="max-height: 150px;max-width: 150px;" src="{!! asset('public/imgsample/b1.gif') !!}" >
                        </td>
                        <td style="width: 300px;">
                            <span class="tf-link" onclick="tf_toggle('#view_1');">click view/hide...</span>
                            <p id="view_1" class="tf-display-none">
                                noi dung yeu cau
                            </p>
                        </td>
                        <td style="text-align:justify;">
                            (128 X 128)px
                        </td>
                        <td>
                            10(day)
                        </td>
                        <td>
                            1600  point
                        </td>
                        <td>
                            <span class="btn btn-default btn-xs" onclick="tf_orderDesign();">receive</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img style="max-height: 150px;max-width: 150px;" src="{!! asset('public/imgsample/b2.png') !!}" >
                        </td>
                        <td style="width: 300px;">
                            <span class="tf-link" onclick="tf_toggle('#view_1');">click view/hide...</span>
                            <p id="view_1" class="tf-display-none">
                                noi dung yeu cau
                            </p>
                        </td>
                        <td style="text-align:justify;">
                            (128 X 128)px
                        </td>
                        <td>
                            10(day)
                        </td>
                        <td>
                            1600  point
                        </td>
                        <td>
                            <span class="btn btn-default btn-xs" onclick="tf_orderDesign();">receive</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img style="max-height: 150px;max-width: 150px;" src="{!! asset('public/imgsample/b3.gif') !!}" >
                        </td>
                        <td style="width: 300px;">
                            <span class="tf-link" onclick="tf_toggle('#view_1');">click view/hide...</span>
                            <p id="view_1" class="tf-display-none">
                                noi dung yeu cau
                            </p>
                        </td>
                        <td style="text-align:justify;">
                            (128 X 128)px
                        </td>
                        <td>
                            10(day)
                        </td>
                        <td>
                            1600  point
                        </td>
                        <td>
                            <span class="btn btn-default btn-xs" onclick="tf_orderDesign();">receive</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img style="max-height: 150px;max-width: 150px;" src="{!! asset('public/imgsample/b4.gif') !!}" >
                        </td>
                        <td style="width: 300px;">
                            <span class="tf-link" onclick="tf_toggle('#view_1');">click view/hide...</span>
                            <p id="view_1" class="tf-display-none">
                                noi dung yeu cau
                            </p>
                        </td>
                        <td style="text-align:justify;">
                            (128 X 128)px
                        </td>
                        <td>
                            10(day)
                        </td>
                        <td>
                            1600  point
                        </td>
                        <td>
                            <span class="btn btn-default btn-xs" onclick="tf_orderDesign();">receive</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img style="max-height: 150px;max-width: 150px;" src="{!! asset('public/imgsample/b5.gif') !!}" >
                        </td>
                        <td style="width: 300px;">
                            <span class="tf-link" onclick="tf_toggle('#view_1');">click view/hide...</span>
                            <p id="view_1" class="tf-display-none">
                                noi dung yeu cau
                            </p>
                        </td>
                        <td style="text-align:justify;">
                            (128 X 128)px
                        </td>
                        <td>
                            10(day)
                        </td>
                        <td>
                            1600  point
                        </td>
                        <td>
                            <span class="btn btn-default btn-xs" onclick="tf_orderDesign();">receive</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center" colspan="6">
                            <ul class="pagination pagination-sm">
                                <li><a href="#">&laquo;</a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">&raquo;</a></li>
                            </ul>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <!--end content shop -->
    </div>
@endsection