<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
$modelHelpDetail = new \App\Models\Manage\Content\Help\Detail\TfHelpDetail();
?>
@extends('manage.content.help.index')
@section('tf_m_c_help_content')
    <div class="col-md-12 tf_m_c_help_content_add">
        <div class="col-md-12 tf-padding-20 text-center">
            <h3>Add help content</h3>
        </div>
        <div class="col-md-12">
            <form class="frm_object_add col-md-8 col-md-offset-2" method="post" role="form" enctype="multipart/form-data"
                  action="{!! route('tf.m.c.help.content.add.post') !!}">
                @if (Session::has('notifyAddHelpContent'))
                    <div class="form-group text-center tf-color-red">
                        {!! Session::get('notifyAddHelpContent') !!}
                        <?php
                        Session::forget('notifyAddHelpContent');
                        ?>
                    </div>
                @endif
                <div class="form-group">
                    <label class="control-label">Help Description <span class="tf-color-red">*</span>:</label>
                    <select class="form-control" name="cbDetail">
                        <option value="">Select help description</option>
                        {!! $modelHelpDetail->getOption() !!}
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Name <span class="tf-color-red">*</span>:</label>
                    <input type="text" class="form-control" name="txtName" placeholder="Enter name">
                </div>
                <div class="form-group">
                    <label class="control-label">Content <span class="tf-color-red">*</span>:</label>
                    <textarea class="form-control" id="txtContent" name="txtContent" rows="10"
                              placeholder="Enter content"></textarea>
                    <script type="text/javascript">ckeditor('txtContent')</script>
                </div>

                <div class="form-group text-center">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <button type="button" class="tf_object_add btn btn-default btn-sm">Save</button>
                    <button type="reset" class="btn btn-default btn-sm">Reset</button>
                    <a class="btn btn-default btn-sm" href="{!! route('tf.m.c.help.content.list.get') !!}">
                        Close
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/help/js/help-content.js')}}"></script>
@endsection
