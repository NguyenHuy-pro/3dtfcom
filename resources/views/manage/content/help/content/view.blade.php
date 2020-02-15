<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */
$modelHelpDetail = new \App\Models\Manage\Content\Help\Detail\TfHelpDetail();
?>
@extends('manage.content.help.index')
@section('tf_m_c_help_content')
    <div class="col-md-12 tf_m_c_help_content_view">
        <div class="col-md-12 tf-padding-20 text-center">
            <h3>Detail help content</h3>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <table class="table ">
                <tr>
                    <td class="col-md-2 text-right">
                        <label>Help description :</label>
                    </td>
                    <td>
                        {!! $modelHelpDetail->name($dataHelpContent->helpDetail_id) !!}
                    </td>
                </tr>

                <tr>
                    <td class="col-md-2 text-right">
                        <label>Name :</label>
                    </td>
                    <td>
                        {!! $dataHelpContent->name !!}
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right">
                        <label>Content :</label>
                    </td>
                    <td>
                        {!! $dataHelpContent->content !!}
                    </td>
                </tr>
                <tr class="text-center">
                    <td colspan="2">
                        <a class="btn btn-primary" href="javascript:window.history.back();">
                            Close
                        </a>
                        <a class="btn btn-default " href="{!! route('tf.m.c.help.content.edit.get', $dataHelpContent->content_id) !!}">
                            Edit
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/help/js/help-content.js')}}"></script>
@endsection
