<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
?>
@extends('manage.content.help.index')
@section('tf_m_c_help_content')
    <div class="col-md-12 tf_m_c_help_object_edit">
        <div class="col-md-12 tf-padding-20 text-center">
            <h3>Update Object</h3>
        </div>
        <div class="col-md-12">
            @if(count($dataHelpObject) > 0)
                <form class="frm_object_update col-md-8 col-md-offset-2" method="post" role="form"
                      action="{!! route('tf.m.c.help.object.edit.post',$dataHelpObject->object_id) !!}">
                    @if (Session::has('notifyEditHelpObject'))
                        <div class="form-group text-center tf-color-red">
                            {!! Session::get('notifyEditHelpObject') !!}
                            <?php
                            Session::forget('notifyEditHelpObject');
                            ?>
                        </div>
                    @endif
                    <div class="form-group">
                        <label class="control-label">Name <span class="tf-color-red">*</span>:</label>
                        <input type="text" class="form-control" name="txtName" placeholder="Enter name" value="{!! $dataHelpObject->name !!}">
                    </div>
                    <div class="form-group text-center">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <button type="button" class="tf_object_update btn btn-primary ">Save</button>
                        <button type="reset" class="btn btn-default ">Reset</button>
                        <a href="{!! route('tf.m.c.help.object.list.get') !!}">
                            <button type="button" class="btn btn-default">Close</button>
                        </a>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection
@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/help/js/help-object.js')}}"></script>
@endsection
