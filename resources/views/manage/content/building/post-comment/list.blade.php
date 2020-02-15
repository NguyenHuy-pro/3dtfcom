<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelBuildingPostComment
 * dataBuildingPostComment
 */
use Carbon\Carbon;

$hFunction = new Hfunction();
?>
@extends('manage.content.building.index')
@section('tf_m_c_building_content')
    <div class="row tf_m_c_building_post_comment tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <h3>List Comment</h3>
        </div>
        <div class=" tf-bg tf-color-white col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40">
                Total : {!! $modelBuildingPostComment->totalRecords()  !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40 text-right">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.building.post.comment.view') !!}"
             data-href-del="{!! route('tf.m.c.building.post.comment.delete') !!}">
            <table class="table table-hover ">
                <tr>
                    <th class="tf-width-70 text-center">N_o</th>
                    <th>Content</th>
                    <th class="tf-width-100">Date</th>
                    <th class="tf-width-150"></th>
                </tr>
                @if(count($dataPostComment) > 0)
                    <?php
                    $perPage = $dataPostComment->perPage();
                    $currentPage = $dataPostComment->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataPostComment as $commentObject)
                        <?php
                        $commentId = $commentObject->commentId();
                        $content = $commentObject->content();
                        ?>
                        <tr class="tf_object" data-object="{!! $commentId !!}">
                            <td class="text-center">
                                {!! $n_o += 1 !!}.
                            </td>
                            <td>
                                {!! $hFunction->cutString($content, 200,'...') !!}
                            </td>
                            <td>
                                {!! Carbon::parse($commentObject->createdAt())->format('d-m-Y') !!}
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
                            $hFunction->page($dataPostComment);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection

@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/building/js/building-post-comment.js')}}"></script>
@endsection