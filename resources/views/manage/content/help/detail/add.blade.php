<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
$modelHelpObject = new \App\Models\Manage\Content\Help\Object\TfHelpObject();
$modelHelpAction = new \App\Models\Manage\Content\Help\Action\TfHelpAction();
?>
@extends('manage.content.help.index')
@section('tf_m_c_help_content')
    <div class="col-md-12 tf_m_c_help_detail_add">
        <div class="col-md-12 tf-padding-20 text-center">
            <h3>Add help description</h3>
        </div>
        <div class="col-md-12">
            <form class="frm_object_add col-md-8 col-md-offset-2" method="post" role="form" enctype="multipart/form-data"
                  action="{!! route('tf.m.c.help.detail.add.post') !!}">
                @if (Session::has('notifyAddHelpDetail'))
                    <div class="form-group text-center tf-color-red">
                        {!! Session::get('notifyAddHelpDetail') !!}
                        <?php
                        Session::forget('notifyAddHelpDetail');
                        ?>
                    </div>
                @endif
                <div class="form-group">
                    <label class="control-label">Help object <span class="tf-color-red">*</span>:</label>
                    <select class="form-control" name="cbObject">
                        <option value="">Select object</option>
                        {!! $modelHelpObject->getOption() !!}
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Help action <span class="tf-color-red">*</span>:</label>
                    <select class="form-control" name="cbAction">
                        <option value="">Select type</option>
                        {!! $modelHelpAction->getOption() !!}
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Name <span class="tf-color-red">*</span>:</label>
                    <input type="text" class="form-control" name="txtName" placeholder="Enter name">
                </div>
                <div class="form-group">
                    <label class="control-label">Content <span class="tf-color-red">*</span>:</label>
                    <textarea class="form-control" id="txtDescription" name="txtDescription" rows="10"
                              placeholder="Enter content"></textarea>
                    <script type="text/javascript">ckeditor('txtDescription')</script>
                </div>

                <div class="form-group text-center">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <button type="button" class="tf_object_add btn btn-default btn-sm">Save</button>
                    <button type="reset" class="btn btn-default btn-sm">Reset</button>
                    <a class="btn btn-default btn-sm" href="{!! route('tf.m.c.help.detail.list.get') !!}">
                        Close
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/help/js/help-detail.js')}}"></script>
@endsection
