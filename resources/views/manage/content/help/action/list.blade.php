<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
$hFunction = new Hfunction();
$modelHelpAction = new \App\Models\Manage\Content\Help\Action\TfHelpAction();
?>
@extends('manage.content.help.index')
@section('tf_m_c_help_content')
    <div class="col-md-12 text-center">
        <h3>Help Action</h3>
    </div>
    <div class="col-md-12" style="background-color: #BFCAE6;">
        <div class="col-md-6 tf-line-height-40">
            Total : {!! $modelHelpAction->totalRecords()  !!}
        </div>
        <div class="col-md-6 tf-line-height-40 text-right">
            <a class="tf-link-bold" href="{!! route('tf.m.c.help.action.add.get') !!}">
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
                <th class="tf-width-200"></th>
            </tr>
            <?php
            $perPage = $dataHelpAction->perPage();
            $currentPage = $dataHelpAction->currentPage();
            $N_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
            ?>
            @foreach($dataHelpAction as $object)
                <?php
                $N_o = $N_o + 1;
                $actionId = $object->action_id;
                ?>
                <tr class="tf_object" data-object="{!! $actionId !!}">
                    <td class="text-center">
                        {!! $N_o !!}.
                    </td>
                    <td>
                        {!! $object->name !!}
                    </td>
                    <td class="text-center">
                        <a class="btn btn-default btn-xs " href="{!! route('tf.m.c.help.action.view.get',$actionId) !!}">
                            <img class="tf-icon-14" src="{!! asset('public/main/icons/observ.png') !!}"> View
                        </a>
                        <a class="btn btn-default btn-xs " href="{!! route('tf.m.c.help.action.edit.get', $actionId) !!}">
                            <img class="tf-icon-14" src="{!! asset('public/main/icons/edit.png') !!}"> Edit
                        </a>
                        <a class="btn btn-default btn-xs tf_object_delete" data-href="{!! route('tf.m.c.help.action.delete') !!}">
                            <img class="tf-icon-14" src="{!! asset('public/main/icons/del.png') !!}"> Delete
                        </a>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td class="text-center" colspan="3">
                    <?php
                    $hFunction->page($dataHelpAction);
                    ?>
                </td>
            </tr>
        </table>
    </div>
@endsection
@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/help/js/help-action.js')}}"></script>
@endsection