<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelUserAccess
 */
use Carbon\Carbon;
$hFunction = new Hfunction();

$dataStaffLogin = $modelStaff->loginStaffInfo();
#check action of level
$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true; #level execute

?>
@extends('manage.content.user.user.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>Access info</span>
            </div>
        </div>
        <div class="tf-bg tf-color-white col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40">
                Total : {!! $modelUserAccess->totalRecords() !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40 text-right"></div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.user.access.view') !!}">
            <table class="table table-hover">
                <tr>
                    <th class="text-center">No</th>
                    <th>User</th>
                    <th>Access IP</th>
                    <th class="text-center">Login</th>
                    <th class="text-center">Logout</th>
                    <th >Date</th>
                    {{--<th class="tf-width-150 text-right"></th>--}}
                </tr>
                @if(count($dataUserAccess) > 0)
                    <?php
                    $perPage = $dataUserAccess->perPage();
                    $currentPage = $dataUserAccess->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataUserAccess as $object)
                        <?php
                        $n_o = $n_o + 1;
                        $accessId = $object->accessId();
                        $accessStatus = $object->accessStatus();
                        ?>
                        <tr class="tf_object" data-object="{!! $accessId !!}">
                            <td class="text-center tf-font-bold">
                                {!! $n_o !!}.
                            </td>
                            <td>
                                {!!$object->user->fullName() !!}
                            </td>
                            <td>
                                {!! $object->accessIP() !!}
                            </td>
                            <td class="text-center">
                                @if($accessStatus == 1)
                                    <i class="glyphicon glyphicon-ok-circle tf-color-green tf-font-bold"></i>
                                @else
                                    <i class="glyphicon glyphicon-ok-circle tf-color-grey"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($accessStatus == 2)
                                    <i class="glyphicon glyphicon-ok-circle tf-color-green tf-font-bold"></i>
                                @else
                                    <i class="glyphicon glyphicon-ok-circle tf-color-grey"></i>
                                @endif
                            </td>
                            <td>
                                {!! Carbon::parse($object->createdAt())->format('d-m-Y H:i:s') !!}
                            </td>
                            {{--
                            <td class="text-center">
                                <a class="btn btn-default btn-xs tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open tf-color"></i> View
                                </a>
                            </td>--}}

                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="6">
                            <?php
                            $hFunction->page($dataUserAccess);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection