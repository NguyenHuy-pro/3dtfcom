<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */
$modelHelpObject = new \App\Models\Manage\Content\Help\Object\TfHelpObject();
$modelHelpAction = new \App\Models\Manage\Content\Help\Action\TfHelpAction();
?>
@extends('manage.content.help.index')
@section('tf_m_c_help_content')
    <div class="col-md-12 tf_m_c_help_object_add">
        <div class="col-md-12 tf-padding-20 text-center">
            <h3> Help detail</h3>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <table class="table ">
                <tr>
                    <td class="col-md-2 text-right">
                        <label>Object :</label>
                    </td>
                    <td>
                        {!! $modelHelpObject->name($dataHelpDetail->helpObject_id) !!}
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right">
                        <label>Action :</label>
                    </td>
                    <td>
                        {!! $modelHelpAction->name($dataHelpDetail->helpAction_id) !!}
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right">
                        <label>Name :</label>
                    </td>
                    <td>
                        {!! $dataHelpDetail->name !!}
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right">
                        <label>Content :</label>
                    </td>
                    <td>
                        {!! $dataHelpDetail->description !!}
                    </td>
                </tr>
                <tr class="text-center">
                    <td colspan="2">
                        <a class="btn btn-primary " href="javascript:window.history.back();">
                            Close
                        </a>
                        <a class="btn btn-default " href="{!! route('tf.m.c.help.detail.edit.get', $dataHelpDetail->detail_id) !!}">
                            Edit
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/help/js/help-object.js')}}"></script>
@endsection
