<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/23/2016
 * Time: 4:25 PM
 */
$hFunction = new Hfunction();

?>
<label class="control-label">Manager<span class="tf-color-red">*</span>:</label>
<select class="form-control" id="cbManageStaff" name="cbManageStaff">
    <option value="">Select manager</option>
    {!! $hFunction->option($dataStaff) !!}
</select>
