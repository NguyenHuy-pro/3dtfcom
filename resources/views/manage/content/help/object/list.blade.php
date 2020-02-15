<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
use App\Models\Manage\Content\Help\Object\TfHelpObject;
$hFunction = new Hfunction();
$modelHelpObject = new TfHelpObject();
?>
@extends('manage.content.help.index')
@section('tf_m_c_help_content')
    <div class="col-md-12 text-center">
        <h3>Help Object</h3>
    </div>
    <div class="col-md-12" style="background-color: #BFCAE6;">
        <div class="col-md-6 tf-line-height-40">
            Total : {!! $modelHelpObject->totalRecords()  !!}
        </div>
        <div class="col-md-6 tf-line-height-40 text-right">
            <a class="tf-link-bold" href="{!! route('tf.m.c.help.object.add.get') !!}">
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
                <th class="text-center tf-width-100">display rank</th>
                <th class="tf-width-200"></th>
            </tr>
            <?php
            $perPage = $dataHelpObject->perPage();
            $currentPage = $dataHelpObject->currentPage();
            $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
            ?>
            @foreach($dataHelpObject as $object)
                <?php
                $objectId = $object->objectId();
                ?>
                <tr class="tf_object" data-object="{!! $objectId !!}">
                    <td class="text-center">
                        {!! $n_o += 1 !!}.
                    </td>
                    <td>
                        {!! $object->name() !!}
                    </td>

                    <td class="text-center">
                        {!! $object->displayRank() !!}
                    </td>
                    <td class="text-center">
                        <a class="btn btn-default btn-xs " href="{!! route('tf.m.c.help.object.view.get',$objectId) !!}">
                            <img class="tf-icon-14" src="{!! asset('public/main/icons/observ.png') !!}"> View
                        </a>
                        <a class="btn btn-default btn-xs " href="{!! route('tf.m.c.help.object.edit.get', $objectId) !!}">
                            <img class="tf-icon-14" src="{!! asset('public/main/icons/edit.png') !!}"> Edit
                        </a>
                        <a class="btn btn-default btn-xs tf_object_delete" data-href="{!! route('tf.m.c.help.object.delete') !!}">
                            <img class="tf-icon-14" src="{!! asset('public/main/icons/del.png') !!}"> Delete
                        </a>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td class="text-center" colspan="4">
                    <?php
                    $hFunction->page($dataHelpObject);
                    ?>
                </td>
            </tr>
        </table>
    </div>
@endsection
@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/help/js/help-object.js')}}"></script>
@endsection