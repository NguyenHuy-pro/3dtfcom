<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/14/2016
 * Time: 2:25 PM
 *
 * $modelStaffAccess
 * $dataStaffAccess
 */
$hFunction = new Hfunction();
?>
@extends('manage.content.system.index')
@section('tf_m_c_content_system')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3>Access info</h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 " style="background-color: #BFCAE6;">
        <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40">
            Total : {!!  $modelStaffAccess->totalRecords() !!}
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40 text-right">

        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <table class="table table-hover">
            <tr>
                <th class="text-center">No</th>
                <th>Staff</th>
                <th class="text-center">IP</th>
                <th class="text-center">Status</th>
                <th class="text-center">Date</th>
            </tr>
            @if(count($dataStaffAccess) > 0)
                <?php
                $perPage = $dataStaffAccess->perPage();
                $currentPage = $dataStaffAccess->currentPage();
                $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage;
                ?>
                @foreach($dataStaffAccess as $itemStaffAccess)
                    <?php
                    $n_o = $n_o + 1;
                    ?>
                    <tr>
                        <td class="text-center">
                            {!! $n_o !!}.
                        </td>
                        <td>
                            {!! $itemStaffAccess->staff->fullName() !!}
                        </td>
                        <td class="text-center tf-overflow-prevent" style="max-width: 500px;">
                            {!! $itemStaffAccess->accessIP() !!}
                        </td>
                        <td class="text-center">
                            <em>
                                @if($itemStaffAccess->accessStatus() == 1)
                                    login
                                @else
                                    logout
                                @endif
                            </em>
                        </td>
                        <td class="text-center">
                            {!! $itemStaffAccess->createdAt() !!}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td class="text-center" colspan="5">
                        <?php
                        $hFunction->page($dataStaffAccess);
                        ?>
                    </td>
                </tr>
            @endif
        </table>
    </div>
@endsection