<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 *
 * $modelStaff
 * $modelAbout
 * $dataAbout
 *
 */


$hFunction = new Hfunction();
#login info
$dataStaffLogin = $modelStaff->loginStaffInfo();
$level = $dataStaffLogin->level();
$actionStatus = false;

if ($level == 2) $actionStatus = true;
?>
@extends('manage.content.system.about.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-12 col-sm-12 col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>About</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 " style="background-color: #BFCAE6;">
            <div class="col-md-6 tf-line-height-40">
                Total : {!! $modelAbout->totalRecords() !!}
            </div>
            <div class="col-md-6 tf-line-height-40 text-right">
                @if($modelAbout->totalRecords() == 0)
                    <a class="tf-link-bold" href="{!! route('tf.m.c.system.about.add.get') !!}">
                        <i class="fa fa-plus"></i> &nbsp;Add new
                    </a>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.system.about.view') !!}"
             data-href-edit="{!! route('tf.m.c.system.about.edit.get') !!}">
            <table class="table table-hover">
                <tr>
                    <th class="text-center">No</th>
                    <th>Name</th>
                    <th>Content</th>
                    <th class="tf-width-150 text-right"></th>
                </tr>
                @if(count($dataAbout) > 0)
                    <?php
                    $perPage = $dataAbout->perPage();
                    $currentPage = $dataAbout->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage;
                    ?>
                    @foreach($dataAbout as $aboutObject)
                        <?php
                        $n_o = $n_o + 1;
                        $aboutId = $aboutObject->aboutId();
                        ?>
                        <tr class="tf_object" data-object="{!! $aboutId !!}">
                            <td class="text-center tf-font-bold">
                                {!! $n_o !!}.
                            </td>
                            <td>
                                {!! $aboutObject->name() !!}
                            </td>
                            <td class="tf-overflow-prevent" style="max-width: 500px;">
                                {!! $aboutObject->content() !!}
                            </td>
                            <td class="text-center">
                                <a class="btn btn-default btn-xs tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open tf-color"></i> View
                                </a>
                                @if($actionStatus)
                                    <a class="btn btn-default btn-xs tf_object_edit">
                                        <i class="glyphicon glyphicon-edit tf-color"></i> Edit
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="4">
                            <?php
                            $hFunction->page($dataAbout);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection