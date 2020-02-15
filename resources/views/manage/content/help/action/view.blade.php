<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */
?>
@extends('manage.content.help.index')
@section('tf_m_c_help_content')
    <div class="col-md-12 tf_m_c_help_object_add">
        <div class="col-md-12 tf-padding-20 text-center">
            <h3>Detail Action</h3>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <table class="table ">
                <tr>
                    <td class="col-md-3">
                        <label>Name:</label>
                    </td>
                    <td>
                        {!! $dataHelpAction->name() !!}
                    </td>
                </tr>
                <tr class="text-center">
                    <td colspan="2">
                        <a class="btn btn-primary btn-sm" href="javascript:window.history.back();">
                            Close
                        </a>
                        <a class="btn btn-default btn-sm" href="{!! route('tf.m.c.help.action.edit.get', $dataHelpAction->actionId()) !!}">
                            Edit
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/help/js/help-action.js')}}"></script>
@endsection
