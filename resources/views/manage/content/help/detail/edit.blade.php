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
    <div class="col-md-12 tf_m_c_help_detail_update">
        <div class="col-md-12 tf-padding-20 text-center">
            <h3>Edit help description</h3>
        </div>
        @if(count($dataHelpDetail) > 0)
            <div class="col-md-12">
                <form class="frm_object_update col-md-8 col-md-offset-2" method="post" role="form"
                      enctype="multipart/form-data"
                      action="{!! route('tf.m.c.help.detail.edit.post', $dataHelpDetail->detail_id) !!}">
                    @if (Session::has('notifyEditHelpDetail'))
                        <div class="form-group text-center tf-color-red">
                            {!! Session::get('notifyEditHelpDetail') !!}
                            <?php
                            Session::forget('notifyEditHelpDetail');
                            ?>
                        </div>
                    @endif
                    <div class="form-group">
                        <label class="control-label">Help object <span class="tf-color-red">*</span>:</label>
                        <select class="form-control" name="cbObject">
                            {!! $modelHelpObject->getOption($dataHelpDetail->helpObject_id) !!}
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Help action <span class="tf-color-red">*</span>:</label>
                        <select class="form-control" name="cbAction">
                            {!! $modelHelpAction->getOption($dataHelpDetail->helpAction_id) !!}
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Name <span class="tf-color-red">*</span>:</label>
                        <input type="text" class="form-control" name="txtName" placeholder="Enter name"
                               value="{!! $dataHelpDetail->name !!}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Content <span class="tf-color-red">*</span>:</label>
                    <textarea class="form-control" id="txtDescription" name="txtDescription" rows="10"
                              placeholder="Enter content">{!! $dataHelpDetail->description !!}</textarea>
                        <script type="text/javascript">ckeditor('txtDescription')</script>
                    </div>

                    <div class="form-group text-center">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <button type="button" class="tf_object_update btn btn-default btn-sm">Save</button>
                        <button type="reset" class="btn btn-default btn-sm">Reset</button>
                        <a class="btn btn-default btn-sm" href="{!! route('tf.m.c.help.detail.list.get') !!}">
                            Close
                        </a>
                    </div>
                </form>
            </div>
        @endif

    </div>
@endsection
@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/help/js/help-detail.js')}}"></script>
@endsection
