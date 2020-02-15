<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
?>
@extends('manage.content.system.notify.index')
@section('tf_m_c_container_object')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30">Add notify</h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <form class="tf_frm_add col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2"
              method="post" role="form" action="{!! route('tf.m.c.system.notify.add.post') !!}">
            @if (Session::has('notifyAddNotify'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyAddNotify') !!}
                    <?php
                    Session::forget('notifyAddNotify');
                    ?>
                </div>
            @endif
            <div class="form-group">
                <label class="control-label">Name <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" id="txtName" name="txtName" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label class="control-label">Content <span class="tf-color-red">*</span>:</label>
                <textarea class="form-control" id="txtContent" name="txtContent" rows="10"
                          placeholder="Enter content"></textarea>
                <script type="text/javascript">ckeditor('txtContent')</script>
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a class="tf-link" href="{!! route('tf.m.c.system.notify.list') !!}">
                    <button type="button" class="btn btn-default">Close</button>
                </a>
            </div>
        </form>
    </div>
@endsection