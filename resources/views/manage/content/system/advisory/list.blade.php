<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 *
 * $modelStaff
 * $modelUser
 * $modelAdvisory
 *
 */
use Carbon\Carbon;
$hFunction = new Hfunction();

$dataStaffLogin = $modelStaff->loginStaffInfo();

#check action of level
$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true; #level execute

?>
@extends('manage.content.system.advisory.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-12 col-sm-12 col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>Advisory</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 " style="background-color: #BFCAE6;">
            <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40">
                Total : {!! $modelAdvisory->totalRecords() !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40 text-right"></div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.system.advisory.view') !!}"
             data-href-del="{!! route('tf.m.c.system.advisory.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th class="text-center">No</th>
                    <th>User</th>
                    <th>Date</th>
                    <th class="text-center">New</th>
                    <th class="text-center">Reply</th>
                    <th class="tf-width-150 text-right"></th>
                </tr>
                @if(count($dataAdvisory) > 0)
                    <?php
                    $perPage = $dataAdvisory->perPage();
                    $currentPage = $dataAdvisory->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataAdvisory as $advisoryObject)
                        <?php
                        $n_o = $n_o + 1;
                        $advisoryId = $advisoryObject->advisoryId();
                        $newInfo = $advisoryObject->newInfo();
                        $confirm = $advisoryObject->confirm();
                        ?>
                        <tr class="tf_object" data-object="{!! $advisoryId !!}">
                            <td class="text-center tf-font-bold">
                                {!! $n_o !!}.
                            </td>
                            <td>
                                {!! $advisoryObject->user->fullName() !!}
                            </td>
                            <td>
                                {!! Carbon::parse($advisoryObject->createdAt())->format('d-m-Y') !!}
                            </td>
                            <td class="text-center">
                                @if($newInfo == 1)
                                    <i class="glyphicon glyphicon-ok-circle tf-color-green tf-font-bold"></i>
                                @else
                                    <i class="glyphicon glyphicon-ok-circle tf-color-grey"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($confirm == 1)
                                    <i class="glyphicon glyphicon-ok-circle tf-color-green tf-font-bold"></i>
                                @else
                                    <i class="glyphicon glyphicon-ok-circle tf-color-grey"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                <a class="btn btn-default btn-xs tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open tf-color"></i> View
                                </a>
                                @if($actionStatus)
                                    <a class="btn btn-default btn-xs tf_object_delete">
                                        <i class="glyphicon glyphicon-trash tf-color"></i> Delete
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="6">
                            <?php
                            $hFunction->page($dataAdvisory);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection