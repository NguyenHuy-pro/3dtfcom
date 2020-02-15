<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 *
 * modelStaff
 * modelBuildingShare
 *
 *
 */
use Carbon\Carbon;

$hFunction = new Hfunction();
?>
@extends('manage.content.building.index')
@section('tf_m_c_building_content')
    <div class="row tf_m_c_building_share tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <h3>List share</h3>
        </div>
        <div class="tf-bg tf-color-white col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40">
                Total : {!! $modelBuildingShare->totalRecords()  !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40 text-right">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.building.share.view') !!}">
            <table class="table table-hover ">
                <tr>
                    <th >N_o</th>
                    <th>Building</th>
                    <th class="text-center">To friends</th>
                    <th class="text-center">To email</th>
                    <th class="text-center">Get link</th>
                    <th class="text-center">Visit</th>
                    <th class="text-center">Register</th>
                    <th class="tf-width-100">Date</th>
                    <th class="tf-width-100"></th>
                </tr>
                @if(count($dataBuildingShare) > 0)
                    <?php
                    $perPage = $dataBuildingShare->perPage();
                    $currentPage = $dataBuildingShare->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataBuildingShare as $shareObject)
                        <?php
                        $shareId = $shareObject->shareId();
                        $shareLink = $shareObject->shareLink();
                        $email = $shareObject->email();
                        ?>
                        <tr class="tf_object" data-object="{!! $shareId !!}">
                            <td class="text-center">
                                {!! $n_o +=1 !!}.
                            </td>
                            <td>
                                {!! $shareObject->building->name() !!}
                            </td>
                            <td class="text-center">
                                @if(empty($shareLink) && empty($email))
                                    <i class="glyphicon glyphicon-ok-circle tf-color-green tf-font-bold"></i>
                                @else
                                    <i class="glyphicon glyphicon-ok-circle tf-color-grey"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                @if(!empty($email))
                                    <i class="glyphicon glyphicon-ok-circle tf-color-green tf-font-bold"></i>
                                @else
                                    <i class="glyphicon glyphicon-ok-circle tf-color-grey"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                @if(!empty($shareLink) && empty($email))
                                    <i class="glyphicon glyphicon-ok-circle tf-color-green tf-font-bold"></i>
                                @else
                                    <i class="glyphicon glyphicon-ok-circle tf-color-grey"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                {!! $shareObject->totalView() !!}
                            </td>
                            <td class="text-center">
                                {!! $shareObject->totalViewRegister() !!}
                            </td>
                            <td>
                                {!! Carbon::parse($shareObject->createdAt())->format('d-m-Y') !!}
                            </td>
                            <td class="text-right">
                                <a class="btn btn-default btn-xs  tf_object_view">
                                    <img class="tf-icon-14" src="{!! asset('public/main/icons/observ.png') !!}"> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="9">
                            <?php
                            $hFunction->page($dataBuildingShare);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection

@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/building/js/building-share.js')}}"></script>
@endsection