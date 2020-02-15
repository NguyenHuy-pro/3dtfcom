<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
use Carbon\Carbon;
use App\Models\Manage\Content\System\Staff\TfStaff;
use App\Models\Manage\Content\Users\TfUser;

$hFunction = new Hfunction();
$modelStaff = new TfStaff();
$modelUser = new TfUser();

#check action of level
$actionStatus = false;
if ($modelStaff->loginStaffInfo('level') == 2) $actionStatus = true; #level execute

?>
@extends('manage.content.user.user.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-md-12">
            <div class="col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>User</span>
            </div>
        </div>
        <div class="col-md-12 " style="background-color: #BFCAE6;">
            <div class="col-md-6 tf-line-height-40">
                Total : {!! $modelUser->totalRecords() !!}
            </div>
            <div class="col-md-6 tf-line-height-40 text-right"></div>
        </div>
        <div class="col-md-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.user.user.view') !!}"
             data-href-status="{!! route('tf.m.c.user.user.status') !!}"
             data-href-del="{!! route('tf.m.c.user.user.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th class="text-center">No</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th class="text-center">New</th>
                    <th class="text-center">Conform</th>
                    <th class="text-center">Status</th>
                    <th class="tf-width-150 text-right"></th>
                </tr>
                @if(count($dataUser) > 0)
                    <?php
                    $perPage = $dataUser->perPage();
                    $currentPage = $dataUser->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataUser as $userObject)
                        <?php
                        $n_o = $n_o + 1;
                        $userId = $userObject->user_id;
                        $newInfo = $userObject->newInfo;
                        $confirm = $userObject->confirm;
                        $status = $userObject->status;
                        ?>
                        <tr class="tf_object" data-object="{!! $userId !!}">
                            <td class="text-center tf-font-bold">
                                {!! $n_o !!}.
                            </td>
                            <td>
                                {!! $userObject->firstName.' '.$userObject->lastName !!}
                            </td>
                            <td>
                                {!! Carbon::parse($userObject->dateAdded)->format('d-m-Y') !!}
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
                            <td class="text-center ">

                                <span class="@if($status == 1) tf-color-green tf-font-bold @else  @if($actionStatus) tf_object_status tf-link-grey @else tf-color-grey @endif  @endif">
                                    On
                                </span>
                                |
                                <span class="@if($status == 0) tf-color-green tf-font-bold @else @if($actionStatus) tf_object_status tf-link-grey @else tf-color-grey @endif @endif">
                                    Off
                                </span>


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
                        <td class="text-center" colspan="7">
                            <?php
                            $hFunction->page($dataUser);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection