<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelBuildingPost
 * dataBuildingPost
 */
use Carbon\Carbon;


$hFunction = new Hfunction();
?>
@extends('manage.content.building.index')
@section('tf_m_c_building_content')
    <div class="row tf_m_c_building_post tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <h3>List post</h3>
        </div>
        <div class="tf-bg tf-color-white col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40">
                Total : {!! $modelBuildingPost->totalRecords()  !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40 text-right">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.building.post.view') !!}"
             data-href-del="{!! route('tf.m.c.building.post.delete') !!}">
            <table class="table table-hover ">
                <tr>
                    <th class="tf-width-70 text-center">N_o</th>
                    <th>Content</th>
                    <th class="tf-width-100">Date</th>
                    <th class="tf-width-150"></th>
                </tr>
                @if(count($dataBuildingPost) > 0)
                    <?php
                    $perPage = $dataBuildingPost->perPage();
                    $currentPage = $dataBuildingPost->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataBuildingPost as $postObject)
                        <?php
                        $n_o = $n_o + 1;
                        $postId = $postObject->postId();
                        $content = $postObject->content();
                        $image = $postObject->image();
                        $buildingId = $postObject->buildingId();
                        $buildingIntroId = $postObject->buildingIntroId();
                        ?>
                        <tr class="tf_object" data-object="{!! $postId !!}">
                            <td class="text-center">
                                {!! $n_o !!}.
                            </td>
                            <td class="">
                                @if(!empty($content))
                                    {!! $hFunction->cutString($content, 200,'...') !!}
                                @elseif(!empty($image))
                                    <img src="{!! $modelBuildingPost->pathSmallImage($image) !!}">
                                @elseif(!empty($buildingIntroId))
                                    <img style="max-width: 128px; max-height: 128px" alt="building-intro"
                                         src="{!! $modelBuilding->pathImageSample($modelBuilding->sampleId($buildingId)) !!}"/>
                                @endif
                            </td>
                            <td>
                                {!! Carbon::parse($postObject->createdAt())->format('d-m-Y') !!}
                            </td>
                            <td class="text-center">
                                <a class="btn btn-default btn-xs  tf_object_view">
                                    <img class="tf-icon-14" src="{!! asset('public/main/icons/observ.png') !!}"> View
                                </a>
                                <a class="btn btn-default btn-xs tf_object_delete">
                                    <img class="tf-icon-14" src="{!! asset('public/main/icons/del.png') !!}"> Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="4">
                            <?php
                            $hFunction->page($dataBuildingPost);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection

@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/building/js/building-post.js')}}"></script>
@endsection