<?php
use Carbon\Carbon;

class Hfunction
{
    function __construct()
    {
        $this->dateDefaultHCM();
    }

    public function dateDefaultHCM()
    {
        return date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

    public function defaultTimezone($city = null)
    {
        if (empty($city) || $city == 'HCM') {
            $this->dateDefaultHCM();
        }
    }

    public function convertNumberToWord($num = false)
    {
        $num = str_replace(array(',', ' '), '', trim($num));
        if (!$num) {
            return false;
        }
        $num = (int)$num;
        $words = array();
        $list1 = array('Không', 'một', 'hai', 'ba', 'bốn', 'năm', 'sáu', 'bảy', 'tám', 'chín', 'mười', 'mười một',
            'mười hai', 'mười ba', 'mười bốn', 'mười lăm', 'mười sáu', 'mười bảy', 'mười tám', 'mười chín'
        );
        $list2 = array('Không', 'mười', 'hai mươi', 'ba mươi', 'bốn mươi', 'năm mươi', 'sáu mươi', 'bảy mươi', 'tám mươi', 'chín mươi', 'một trăm');
        $list3 = array('Không', 'nghìn', 'triệu', 'tỷ', 'nghìn tỷ', 'nghìn triệu triệu', 'một triệu', 'sextillion', 'septillion',
            'tám triệu', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
        $num_length = strlen($num);
        $levels = (int)(($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int)($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' trăm' . ' ' : '');
            $tens = (int)($num_levels[$i] % 100);
            $singles = '';
            if ($tens < 20) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
            } else {
                $tens = (int)($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int)($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . (($levels && ( int )($num_levels[$i])) ? ' ' . $list3[$levels] . ' ' : '');
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        return implode(' ', $words);
    }

    public function checkNull($dataCheck)
    {
        return ($dataCheck == null) ? true : false;
    }

    public function setNull()
    {
        return null;
    }

    public function checkEmpty($dataCheck)
    {
        return (empty($dataCheck)) ? true : false;
    }

    public function checkCount($dataCheck = null)
    {
        $result = (empty($dataCheck)) ? 0 : count($dataCheck);
        return ($result > 0) ? true : false;
    }

    public function isHandset()
    {
        $mobile = new Mobile_Detect();
        if ($mobile->isMobile() || $mobile->isTablet()) {
            return true;
        } else {
            return false;
        }
    }

    public function isMobile()
    {
        $mobile = new Mobile_Detect();
        return $mobile->isMobile();
    }

    public function isTablet()
    {
        $mobile = new Mobile_Detect();
        return $mobile->isTablet();
    }

    public function accessDevice()
    {
        if ($this->isMobile()) {
            return 'mobile';
        } elseif ($this->isTablet()) {
            return 'tablet';
        } else {
            return 'other';
        }
    }

    public function identifyLink($content)
    {
        $newArray = explode(' ', $content);
        $total = count($newArray);
        for ($i = 0; $i < $total; $i++) {
            $checkText = $newArray[$i];
            if (strstr($checkText, ':')) {
                $arrayHttpText = explode(':', $checkText);
                $checkHttp = reset($arrayHttpText);
                if ($checkHttp == 'http' || $checkHttp == 'https') {
                    $newArray[$i] = "<a href='$checkText'>$checkText</a>";
                }
            } elseif (strstr($checkText, '.') && strlen($checkText) > 5) {
                $arrayWebText = explode('.', $checkText);
                $checkWeb = end($arrayWebText);
                $arrayWeb = ['com', 'vn', 'net', 'org', 'info', 'me', 'us', 'asia', 'biz', 'html'];
                if (in_array($checkWeb, $arrayWeb)) {
                    $newArray[$i] = "<a href='http://$checkText'>$checkText</a>";
                }
            }
        }
        return implode(' ', $newArray);
    }

    public function getStringSpecialCharacter()
    {
        return "$,@,\\,/,#,%,^,&,*,(,),[,],+,{,},~,=,|";
    }

    // alias
    public function stripUnicode($str)
    {
        if (!$str) return false;
        $unicode = array(
            'a' => 'ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ậ|ẫ|á|à|ả|ạ|ã',
            'A' => 'Ă|Ắ|Ằ|Ẵ|Ẳ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ẫ|Á|À|Ả|Ã|Ạ',
            'd' => 'đ',
            'D' => 'Đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
        );
        foreach ($unicode as $nonUnicode => $uni) {
            $arr = explode('|', $uni);
            $str = str_replace($arr, $nonUnicode, $str);
        }
        return $str;
    }

    public function alias($str, $linked = '', $specialCharacters = true)
    {
        $str = trim($str);
        if ($str == '') return '';
        $str = str_replace('"', '', $str);
        $str = str_replace("'", '', $str);
        $str = str_replace('?', '_', $str);
        $str = $this->stripUnicode($str);
        $str = mb_convert_case($str, MB_CASE_LOWER, 'utf-8');
        $str = str_replace(' ', $linked, $str);
        if ($specialCharacters) {
            $str = str_replace('<', '-', str_replace('>', '-', $str));
            $str = str_replace('/', '-', str_replace("\\", '-', $str));
            $str = str_replace('(', '-', str_replace(")", '-', $str));
        }
        return $str;
    }

    //create random
    public function random($length = 1, $type = 'all')
    {
        $result = '';
        if ($type == 'string') {
            $stringRandom = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            for ($i = 1; $i <= $length; $i++) {
                $result = $result . $stringRandom[rand(0, strlen($stringRandom) - 1)];
            }
        } elseif ($type == 'int') {
            for ($i = 0; $i < $length; $i++) {
                $result = $result . rand(0, 9);
            }

            $result = (int)$result;
        } else {
            $stringRandom = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            for ($i = 1; $i <= $length; $i++) {
                $result = $result . $stringRandom[rand(0, strlen($stringRandom) - 1)];
            }
        }

        return $result;
    }

    public function searchBoldText($text, $content)
    {
        $array = explode(' ', $text);
        foreach ($array as $value) {
            $content = str_replace($value, "<b>$value</b>", $content);
            $valueUpper = strtoupper($value);
            $content = str_replace($valueUpper, "<b>$valueUpper</b>", $content);
            $valueLower = strtolower($value);
            $content = str_replace($valueLower, "<b>$valueLower</b>", $content);
            $valueUcfirst = ucfirst($value);
            $content = str_replace($valueUcfirst, "<b>$valueUcfirst</b>", $content);
            $valueUcwords = ucwords($value);
            $content = str_replace($valueUcwords, "<b>$valueUcwords</b>", $content);
        }
        $content = str_replace($text, "<b>$text</b>", $content);
        return $content;
    }

    //string
    public function cutString($string, $length, $more = '')
    {
        if (strlen($string) > $length) {
            $string = mb_substr($string, 0, $length, 'UTF-8');
            $newArray = explode(' ', $string);
            if (count($newArray) > 2) {
                unset($newArray[count($newArray) - 1]);
                $string = implode(' ', $newArray);
            };
            $string = $string . $more;
        }

        return $string;
    }

    public function serialize($value)
    {
        return serialize($value);
    }

    public function unserialize($value)
    {
        return unserialize($value);
    }

    public function checkEscape($string)
    {
        return mysql_real_escape_string($string);
    }

    public function checkAddSlashes($string)
    {
        return addslashes($string);
    }

    //convert to html type
    public function convertValidHTML($string)
    {
        return $this->checkAddSlashes($string);
    }

    //return html type
    public function returnValidHTML($string)
    {
        return stripslashes($string);
    }

    public function htmlEntities($str)
    {
        return htmlentities($str);
    }

    public function htmlEntityDecode($str)
    {
        return html_entity_decode($str);
    }

    public function htmlSpecialChars($str)
    {
        return htmlspecialchars($str);
    }

    public function htmlSpecialCharsDecode($str)
    {
        return htmlspecialchars_decode($str);
    }

    public function checkExistSpecialCharacter($str)
    {
        $checkArray = explode(',', $this->getStringSpecialCharacter());
        for ($i = 0; $i < strlen($str); $i++) {
            if (in_array($str[$i], $checkArray)) return true;
        }
        return false;

    }

    //convert to int
    public function checkIntval($string)
    {
        return intval($string);
    }

    public function convertViewValue($value)
    {
        if (1000 <= $value && $value < 1000000) {
            $value = ($value / 1000) . "K";
        } elseif (1000000 <= $value && $value < 1000000000) {
            $value = ($value / 1000000) . "M";
        }
        return $value;
    }

    //create option of select
    public function option($data, $select = '')
    {
        foreach ($data as $key => $value) {
            $id = $value['optionKey'];
            $name = $value['optionValue'];
            if ($select != '' && $id == $select) {
                echo "<option value='$id' selected='selected'> $name</option>";
            } else {
                echo "<option value='$id' > $name</option>";
            }
        }
    }

    public function optionMultiple($data, $parent = 0, $str = "--", $select = 0)
    {
        foreach ($data as $key => $value) {
            $id = $value['optionKey'];
            $name = $value['optionValue'];
            $parentID = $value['optionParent'];
            if ($parentID == $parent) {
                if ($select != 0 && $id == $select) {
                    echo "<option value='$id' selected='selected'>$str $name</option>";
                } else {
                    echo "<option value='$id' >$str $name</option>";
                }
            }
        }
    }

    // tim phan tu trong chuoi co dau phay
    public function checkExistOfString($element, $string)
    {
        $array = explode(",", $string);    //chuyen chuoi thành 1 mang
        return in_array($element, $array);
    }

    public function getSubListNew($list_1, $list_2)
    {
        $list_new = "";
        $array_1 = explode(",", $list_1);
        foreach ($array_1 as $key => $value) {
            if (!$this->checkExistOfString($value, $list_2)) {
                $list_new .= $value . ",";
            }
        }
        return substr($list_new, 0, strlen($list_new) - 1);
    }

    public function dotNumber($strNum)
    {
        $result = "";
        $len = strlen($strNum);
        $counter = 3;
        while ($len - $counter >= 0) {
            $con = substr($strNum, $len - $counter, 3);
            $result = '.' . $con . $result;
            $counter += 3;
        }
        $con = substr($strNum, 0, 3 - ($counter - $len));
        $result = $con . $result;
        if (substr($result, 0, 1) == '.') {
            $result = substr($result, 1, $len + 1);
        }
        return $result;
    }

    public function objectToArray($data)
    {
        if (is_array($data) || is_object($data)) {
            $result = array();
            foreach ($data as $key => $value) {
                $result[$key] = object_to_array($value);
            }
            return $result;
        }
        return $data;
    }

    #========== ========== ========= DATE =========== ========== =========
    public function  setTimeZone($country = null)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

    public function  dateFormatDMY($date, $char = '/')
    {
        $date = new DateTime($date);
        return date_format($date, 'd' . $char . 'm' . $char . 'Y');
    }

    public function carbonNow()
    {
        return Carbon::now();
    }

    public function dateTimePlusDay($dateTime, $numberDay)
    {
        return date("Y-m-d H:i:s", strtotime("+$numberDay day", strtotime(date($dateTime))));
    }

    public function dateTimePlusMonth($dateTime, $numberMonth)
    {
        return date("Y-m-d H:i:s", strtotime("+$numberMonth month", strtotime(date($dateTime))));
    }

    public function dateTimePlusYear($dateTime, $numberYear)
    {
        return date("Y-m-d H:i:s", strtotime("+$numberYear year", strtotime(date($dateTime))));
    }

    public function carbonNowAddYears($years)
    {
        return Carbon::now()->addYears($years);
    }

    public function carbonNowAddMonths($month)
    {
        return Carbon::now()->addMonths($month);
    }

    public function carbonNowAddDays($days)
    {
        return Carbon::now()->addDays($days);
    }

    public function createdAt()
    {
        #return date('Y-m-d H:i:s');
        return \Carbon\Carbon::now();
    }

    public function getTimeCode()
    {
        $code = date("y") . date("m") . date("d") . date("H") . date("i") . date("s");
        return $code;
    }

    # -------- plus year\month\day\ for current date (no time)--------
    public function currentDatePlusYear($yearNumber = 0)
    {
        return date('Y-m-d', strtotime("+$yearNumber year", strtotime(date("Y-m-d"))));
    }

    public function currentDatePlusMonth($monthNumber = 0)
    {
        return date('Y-m-d', strtotime("+$monthNumber month", strtotime(date("Y-m-d"))));
    }

    public function currentDatePlusDay($monthNumber = 0)
    {
        return date('Y-m-d', strtotime("+$monthNumber day", strtotime(date("Y-m-d"))));
    }

    // -------- convert date--------
    public function convertStringToDatetime($string_m_d_Y)
    {
        return date('Y-m-d H:i:s', strtotime($string_m_d_Y));
    }

    public function getHoursFromTime($time)
    {
        return date('H', strtotime($time));
    }

    public function getMinuteFromTime($time)
    {
        return date('i', strtotime($time));
    }

    public function getMinuteOfTwoTime()
    {
        //$datetime1 = new DateTime();
        //$datetime2 = new DateTime($ime2);
        //$interval = $datetime1->diff($datetime2);
        //$elapsed = $interval->format('%i minutes');
        //echo $elapsed;
    }

    # -------- plus year\month\day\ for current date time--------
    public function currentDateTimePlusYear($yearNumber = 0, $timeZoneDefault = 'HCM')
    {
        $this->defaultTimezone($timeZoneDefault);
        return date('Y-m-d H:j:s', strtotime("+$yearNumber year", strtotime(date("Y-m-d H:i:s"))));
    }

    public function currentDateTimePlusMonth($monthNumber = 0, $timeZoneDefault = 'HCM')
    {
        $this->defaultTimezone($timeZoneDefault);
        return date('Y-m-d H:i:s', strtotime("+$monthNumber month", strtotime(date("Y-m-d H:i:s"))));
    }

    public function currentDateTimePlusDay($dayNumber = 0, $timeZoneDefault = 'HCM')
    {
        $this->defaultTimezone($timeZoneDefault);
        return date('Y-m-d H:i:s', strtotime("+$dayNumber day", strtotime(date("Y-m-d H:i:s"))));
    }

    public function currentDateTime($timeZoneDefault = 'HCM')
    {
        $this->defaultTimezone($timeZoneDefault);
        return date('Y-m-d H:i:j');
    }

    public function currentDate($timeZoneDefault = 'HCM')
    {
        $this->defaultTimezone($timeZoneDefault);
        return date('Y-m-d');
    }

    public function currentDay($timeZoneDefault = 'HCM')
    {
        $this->defaultTimezone($timeZoneDefault);
        return date('d');
    }

    public function currentMonth($timeZoneDefault = 'HCM')
    {
        $this->defaultTimezone($timeZoneDefault);
        return date('m');
    }

    public function currentYear($timeZoneDefault = 'HCM')
    {
        $this->defaultTimezone($timeZoneDefault);
        return date('Y');
    }

    public function currentHour($timeZoneDefault = 'HCM')
    {
        $this->defaultTimezone($timeZoneDefault);
        return date('H');
    }

    public function firstDateOfMonthFromDate($date_Ymd = null)
    {
        return (empty($date_Ymd)) ? date('Y-m-01') : date("Y-m-01", strtotime($date_Ymd));
    }

    public function lastDateOfMonthFromDate($date_Ymd = null)
    {
        return (empty($date_Ymd)) ? date('Y-m-t') : date("Y-m-t", strtotime($date_Ymd));
    }

    public function checkDateIsWeekend($date)
    {
        $date = strtotime($date);
        $date = date("l", $date);
        $date = strtolower($date);
        if ($date == "saturday" || $date == "sunday") {
            return "true";
        } else {
            return "false";
        }
    }

    public function  checkDateIsSunday($date)  //'2018-02-29'
    {
        $date = strtotime($date);
        $date = date("l", $date);
        $date = strtolower($date);
        if ($date == "sunday") {
            return true;
        } else {
            return false;
        }
    }

    public function checkValidDate($date, $format = 'Y-m-d') //'2018-02-29' (Y-mm-dd)
    {
        //$date = date('Y-m-d', strtotime($ddd));
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }
    # ========== ========== ========== upload image file ========== ========== ==========
    public function getCountFromData($data)
    {
        return (empty($data)) ? 0 : count($data);
    }
    public function getTypeImg($image)
    {
        $array = explode('.', $image);
        return end($array);
    }

    public function selectOneImage($id = '', $name = '', $typeImage = '', $widthImgView = '', $heightImgView = '')
    {
        $widthImgView = (!empty($widthImgView)) ? $widthImgView : 150;
        $heightImgView = (!empty($heightImgView)) ? $heightImgView : 100;
        ?>
        <div class="tf-padding-none col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div>
                <a class="tf-cursor-pointer tf-border-radius-5 tf-padding-5"
                   onclick="tf_main.tf_click('#<?php echo $id; ?>');" style="background-color: #d7d7d7;">
                    <img class="tf-icon-20" alt="icon" src="<?php echo asset('public\main\icons\Photograph.png'); ?>">
                </a>
                <input id="<?php echo $id; ?>" style="display: none;" name="<?php echo $name; ?>" type="file"
                       onchange="tf_main.tf_selectOneImage(this,'#wrapView_<?php echo $name; ?>','viewImage_<?php echo $name; ?>','<?php echo $typeImage; ?>')">
            </div>
            <div id="wrapView_<?php echo $name; ?>" class="tf-vertical-bottom" style="display: none;">
                <img id="viewImage_<?php echo $name; ?>" class="tf-margin-10"
                     style="max-width:<?php echo $widthImgView ?>px;max-height: <?php echo $heightImgView ?>px;"/>
                <span id="cancel_<?php echo $name; ?>" class="tf-cursor-pointer"
                      onclick="tf_main.tf_cancelOneImage('#<?php echo $id; ?>','#wrapView_<?php echo $name; ?>');">Cancel</span>
            </div>
        </div>
        <?php
    }

    # select image on size
    public function selectOneImageFollowSize($id = '', $name = '', $typeImage = '', $idImageCheck = '', $limitSize = '', $limitWidth = '', $limitHeight = '', $widthImgView = '', $heightImgView = '')
    {
        $widthImgView = (!empty($widthImgView)) ? $widthImgView : 150;
        $heightImgView = (!empty($heightImgView)) ? $heightImgView : 100;
        ?>
        <div class="tf-padding-none col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div>
                <a class="tf-cursor-pointer tf-border-radius-5 tf-padding-5"
                   onclick="tf_main.tf_click('#<?php echo $id; ?>');" style="background-color: #d7d7d7;">
                    <img class="tf-icon-20" alt="icon" src="<?php echo asset('public\main\icons\Photograph.png'); ?>">
                </a>
                <input id="<?php echo $id; ?>" name="<?php echo $name; ?>" data-size="<?php echo $limitSize ?>"
                       type="file" style="display: none;" data-width="<?php echo $limitWidth ?>"
                       data-height="<?php echo $limitHeight ?>"
                       onchange="tf_main.tf_selectOneImageFollowSize(this,'#wrapView_<?php echo $name; ?>','viewImage_<?php echo $name; ?>','<?php echo $typeImage; ?>','<?php echo $idImageCheck; ?>')">
            </div>
            <div id="wrapView_<?php echo $name; ?>" class=" tf-vertical-bottom" style="display: none;">
                <img id="viewImage_<?php echo $name; ?>" class="tf-margin-10"
                     style="max-width:<?php echo $widthImgView ?>px;max-height: <?php echo $heightImgView ?>px;"/>
                <img id="<?php echo $idImageCheck; ?>" style="display: none;" alt="image"/>
                <span id="cancel_<?php echo $name; ?>" class="tf-cursor-pointer"
                      onclick="tf_main.tf_cancelOneImage('#<?php echo $id; ?>','#wrapView_<?php echo $name; ?>');">Cancel</span>
            </div>
        </div>
        <?php
    }

    public function uploadSaveNoResize($file, $pathImage, $imageName)
    {
        return $file->move($pathImage, $imageName);
    }

    public function copyFile($rootPath, $newPath, $newName = null)
    {
        return copy($rootPath, $newPath);
    }

    public function uploadSave($file, $pathSmall, $pathFull, $imageName, $smallSize = null)
    {
        $hImageResize = new imageResize();
        $smallSize = (is_null($smallSize)) ? 200 : $smallSize; // default 200px
        if ($file->move($pathFull, $imageName)) {
            # create small image
            $size = getimagesize($pathFull . $imageName);        // lay thong tin size cua hinh anh
            $widthSize = intval($size[0]);
            $heightSize = intval($size[1]);
            if ($widthSize >= $heightSize) {
                if ($widthSize > $smallSize) {
                    $hImageResize->load($pathFull . $imageName);
                    $hImageResize->resizeToWidth($smallSize);
                    $hImageResize->save($pathSmall . $imageName); // luu ten moi , kich thuoc moi

                } else {
                    copy($pathFull . $imageName, $pathSmall . $imageName);
                }

            } else {
                if ($heightSize > $smallSize) {
                    $hImageResize->load($pathFull . $imageName);
                    $hImageResize->resizeToHeight($smallSize);
                    $hImageResize->save($pathSmall . $imageName); // luu ten moi , kich thuoc moi
                } else {
                    copy($pathFull . $imageName, $pathSmall . $imageName);
                }

            }
            return true;
        } else {
            return false;
        }
    }

    public function uploadSaveByFileName($source_img, $name_img, $pathSmall, $pathFull, $smallSize = null, $followMin = true)
    {
        $hImageResize = new imageResize();
        $pathSmallImage = $pathSmall . $name_img;
        $pathFullImage = $pathFull . $name_img;
        $smallSize = (is_null($smallSize)) ? 200 : $smallSize;
        if (move_uploaded_file($source_img, $pathFullImage)) {
            $size = getimagesize($pathFullImage);        // lay thong tin size cua hinh anh
            $widthSize = intval($size[0]);
            $heightSize = intval($size[1]);
            if ($widthSize >= $heightSize) {
                $hImageResize->load($pathFullImage);
                if ($followMin) {
                    $hImageResize->resizeToHeight($smallSize);
                } else {
                    $hImageResize->resizeToWidth($smallSize);
                }
                $hImageResize->save($pathSmallImage);

            } else {
                $hImageResize->load($pathFullImage);
                if ($followMin) {
                    $hImageResize->resizeToWidth($smallSize);
                } else {
                    $hImageResize->resizeToHeight($smallSize);
                }
                //$hImageResize->resizeToHeight($smallSize);
                $hImageResize->save($pathSmallImage); // luu ten moi , kich thuoc moi

            }
            return true;
        } else {
            return false;
        }

    }

    # ========== ========== ========== GENERAL ========== ========== ==========
    # go to url
    public function goToUrl($url)
    {
        echo "<script type='text/javascript'>window.location ='$url'; </script>";
    }

    public function getUrlReferer()
    {
        return $_SERVER["HTTP_REFERER"];
    }
    # get Client IP
    public function getClientIP()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        return $ip;
    }

    # ======= Page ================
    function page($data)
    {
        echo "<ul class='pagination page-tool'>";
        $lastPage = $data->lastPage();
        $currentPage = $data->currentPage();
        $viewPage = 5;
        if (($currentPage + $viewPage) < $lastPage) {
            $limitPage = $currentPage + $viewPage;
        } else {
            $limitPage = $lastPage;
        }
        if ($currentPage > 5) {
            $i = $currentPage - 4;
        } else {
            $i = 1;
        }
        if ($currentPage != 1) {
            $hrefFirst = str_replace('/?', '?', $data->url(1));
            $hrefPrev = str_replace('/?', '?', $data->url($currentPage - 1));
            echo "
                <li>
                    <a href ='$hrefFirst' > First</a >
                </li >
                <li >
                    <a href ='$hrefPrev' > Prev</a >
                </li >";
        }
        for ($i; $i <= $limitPage; $i++) {
            if ($currentPage == $i) $active = 'active'; else $active = '';
            $hrefCenter = str_replace('/?', '?', $data->url($i));
            echo "
                <li class='$active' >
                    <a href = '$hrefCenter'>$i</a >
                </li >";
        }
        if ($currentPage != $lastPage && $lastPage > 1) {
            $hrefNext = str_replace('/?', '?', $data->url($currentPage + 1));
            $hrefLast = str_replace('/?', '?', $data->url($lastPage));
            echo "
            <li >
                <a href = '$hrefNext' > Next</a >
            </li >
            <li >
                <a href = '$hrefLast' > Last</a >
            </li >";
        }
        echo "</ul>";
    }


}

?>