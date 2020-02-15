<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
use App\Models\Manage\Content\System\Staff\TfStaff;
use App\Models\Manage\Content\System\PointTransaction\TfPointTransaction;

$hFunction = new Hfunction();
$modelStaff = new TfStaff();
$modelPointTransaction = new TfPointTransaction();

$actionStatus = false;
if ($modelStaff->loginStaffInfo('level') == 2) $actionStatus = true;

$title = 'Point transaction';
?>
@extends('manage.content.system.point-transaction.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-md-12">
            <div class="col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="col-md-12 tf-bg tf-color-white ">
            <div class="col-md-4 tf-line-height-40">
                Total : {!! $modelPointTransaction->totalRecords() !!}
            </div>
            <div class="col-md-4 text-right tf-line-height-40">

            </div>
            <div class="col-md-4 tf-line-height-40 text-right">
                @if($actionStatus)
                    <a href="{!! route('tf.m.c.system.point-transaction.add.get') !!}">
                        <button class="btn btn-primary tf-link-white-bold">
                            <i class="fa fa-plus"></i> &nbsp;Add new
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="col-md-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.system.point-transaction.view') !!}"
             data-href-edit="{!! route('tf.m.c.system.point-transaction.edit.get') !!}"
             data-href-del="{!! route('tf.m.c.system.point-transaction.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th>No</th>
                    <th>Point type</th>
                    <th class="text-center">Point</th>
                    <th class="text-center">USD</th>
                    <th></th>
                </tr>
                @if(count($dataPointTransaction))
                    <?php
                    $perPage = $dataPointTransaction->perPage();
                    $currentPage = $dataPointTransaction->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataPointTransaction as $itemTransaction)
                        <?php
                        $transactionId = $itemTransaction->transactionId();
                        ?>
                        <tr class="tf_object" data-object="{!! $transactionId !!}">
                            <td>
                                {!! $n_o += 1 !!}.
                            </td>
                            <td>
                                {!! $itemTransaction->pointType->name() !!}
                            </td>
                            <td class="text-center">
                                {!! $itemTransaction->pointValue() !!}
                            </td>
                            <td class="text-center">
                                {!! $itemTransaction->usdValue() !!}
                            </td>
                            <td class="text-right">
                                <a class="btn btn-default btn-xs tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open tf-color"></i> View
                                </a>
                                @if($actionStatus)
                                    <a class="btn btn-default btn-xs tf_object_edit">
                                        <i class="glyphicon glyphicon-edit tf-color"></i> Edit
                                    </a>
                                    <a class="btn btn-default btn-xs tf_object_delete">
                                        <i class="glyphicon glyphicon-trash tf-color"></i> Delete
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="5">
                            <?php
                            $hFunction->page($dataPointTransaction);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection