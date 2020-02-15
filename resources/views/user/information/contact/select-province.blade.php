<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 7/7/2017
 * Time: 9:41 PM
 */
/*
 * modelProvince
 * countryId
 */
?>
<select name="cbProvince" class="form-control">
    <option value="">@if(!empty($countryId)) {!! trans('frontend_user.info_contact_edit_select_province') !!} @else
            Null @endif</option>
    @if(!empty($countryId))
        {!! $modelProvince->getOption($provinceId, $countryId) !!}
    @endif
</select>
