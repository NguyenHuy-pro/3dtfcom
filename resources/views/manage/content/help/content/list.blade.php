<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
$hFunction = new Hfunction();
$modelHelpDetail = new \App\Models\Manage\Content\Help\Detail\TfHelpDetail();
$modelHelpContent = new \App\Models\Manage\Content\Help\Content\TfHelpContent();
?>
@extends('manage.content.help.index')
@section('tf_m_c_help_content')
    <div class="col-md-12 text-center">
        <h3>Help Content</h3>
    </div>
    <div class="col-md-12" style="background-color: #BFCAE6;">
        <div class="col-md-6 tf-line-height-40">
            Total : {!! $modelHelpContent->totalRecords()  !!}
        </div>
        <div class="col-md-6 tf-line-height-40 text-right">
            <a class="tf-link-bold" href="{!! route('tf.m.c.help.content.add.get') !!}">
                <button class="btn btn-primary btn-xs">
                    <img class="tf-icon-14" src="{!! asset('public/main/icons/addnew.png') !!}"> Add
                </button>
            </a>
        </div>
    </div>
    <div class="col-md-12">
        <table class="table table-hover ">
            <tr>
                <th class="tf-width-70 text-center">No</th>
                <th>Name</th>
                <th>Help description</th>
                <th class="tf-width-200"></th>
            </tr>
            <?php
            $perPage = $dataHelpContent->perPage();
            $currentPage = $dataHelpContent->currentPage();
            $N_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
            ?>
            @foreach($dataHelpContent as $object)
                <?php
                $N_o = $N_o + 1;
                $contentId = $object->content_id;
                $helpDetailId = $object->helpDetail_id;
                ?>
                <tr class="tf_object" data-object="{!! $contentId !!}">
                    <td class="text-center">
                        {!! $N_o !!}.
                    </td>

                    <td>
                        {!! $object->name !!}
                    </td>

                    <td>
                        {!! $modelHelpDetail->name($helpDetailId) !!}
                    </td>

                    <td class="text-center">
                        <a class="btn btn-default btn-xs "
                           href="{!! route('tf.m.c.help.content.view.get',$contentId) !!}">
                            <img class="tf-icon-14" src="{!! asset('public/main/icons/observ.png') !!}"> View
                        </a>
                        <a class="btn btn-default btn-xs "
                           href="{!! route('tf.m.c.help.content.edit.get', $contentId) !!}">
                            <img class="tf-icon-14" src="{!! asset('public/main/icons/edit.png') !!}"> Edit
                        </a>
                        <a class="btn btn-default btn-xs tf_object_delete"
                           data-href="{!! route('tf.m.c.help.content.delete') !!}">
                            <img class="tf-icon-14" src="{!! asset('public/main/icons/del.png') !!}"> Delete
                        </a>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td class="text-center" colspan="4">
                    <?php
                    $hFunction->page($dataHelpContent);
                    ?>
                </td>
            </tr>
        </table>
    </div>
@endsection
@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/help/js/help-content.js')}}"></script>
@endsection