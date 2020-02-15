<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 7/1/2016
 * Time: 12:04 PM
 */

$hFunction = new Hfunction();
?>
<label class="control-label">Image <span class="tf-color-red">*</span>:</label>
<?php
    $limitWidth = $dataSize->width();
    $limitHeight = $dataSize->height();
    $hFunction->selectOneImageFollowSize('fileImage','fileImage','','checkImgSize','',$limitWidth,$limitHeight);
?>

