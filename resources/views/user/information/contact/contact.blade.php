<?php
/*
 $dataUser
 */

$dataUserContact = $dataUser->contactInfo();
if (count($dataUserContact) > 0) {
    $provinceId = $dataUserContact->provinceId();
    $address = $dataUserContact->address();
    $phone = $dataUserContact->phone();
    $email = $dataUserContact->email();
} else {
    $provinceId = null;
    $phone = null;
    $email = null;
}
?>
<div class="col-xs-12 col-sm-12 col-md-12">
    <table class="table">
        <tr>
            <td class="col-xs-4 col-sm-3 col-md-2">
                {!! trans('frontend_user.info_contact_content_label_province') !!} :
            </td>
            <td class="col-xs-8 col-sm-9 col-md-10">
                {!! (empty($provinceId))?'Null':$dataUserContact->province->name() !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! trans('frontend_user.info_contact_content_label_address') !!}:
            </td>
            <td>
                {!! (empty($address))?'Null': $address !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! trans('frontend_user.info_contact_content_label_phone') !!} :
            </td>
            <td>
                {!! (empty($phone))?'Null': $phone !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! trans('frontend_user.info_contact_content_label_email') !!} :
            </td>
            <td>
                {!! (empty($email))?'Null':$email !!}
            </td>
        </tr>
    </table>
</div>