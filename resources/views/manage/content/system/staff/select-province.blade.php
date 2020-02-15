<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/23/2016
 * Time: 4:34 PM
 */
$hFunction = new Hfunction();
?>
<label class="control-label">Province<span class="tf-color-red">*</span>:</label>
<select class="form-control" id="cbProvince" name="cbProvince">
    <option value="">Select province</option>
    {!! $hFunction->option($dataProvince) !!}
</select>
