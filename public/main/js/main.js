//$('div .alert').delay(10000).slideUp();
var tf_main = {
    tf_confirmDelete: function (smg) {
        if (window.confirm(smg)) {
            return true;
        } else {
            return false;
        }
    }
    ,

    //----------- ----------- ----------- DATE ----------- ----------- -----------
    // set datePicker for input
    tf_setDatepicker: function (object) {
        $(object).datepicker({
            dateFormat: "yy-mm-dd",
            dayNames: "Sunday Monday Tuesday Wednessday Thursday Friday Satuday".split(" "),
            dayNamesMin: "Sun Mon Tue Wed Thur Fri Sa".split(" "),
            dayNamesShort: "Su Mo Tu We Th Fr Sa".split(" "),
            monthNames: "January Febuary March April May Jun July Agust Septembe Octobe November December".split(" "),
            monthNamesShort: "Jan Feb Mar Apr May Jun July Agu Sep Oct Nov Dec".split(" "),
            prevText: "Ant",
            nextText: "Sig",
            currentText: "Hoy",
            changeMonth: !0,
            changeYear: !0,
            showAnim: "slideDown",
            yearRange: "1950:2100",
            beforeShow: function () {
                setTimeout(function () {
                    $('.ui-datepicker').css('z-index', 999999999999);
                }, 0);
            }
        });
    },

    tf_getCurrentDate: function (style, str) {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1;
        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }
        if (style == 'd-m-y') {
            return dd + str + mm + str + yyyy;
        } else {
            return yyyy + str + mm + str + dd;
        }
    },

    tf_existSpecialCharacter: function (str) {
        if (/^[a-zA-Z0-9- ]*$/.test(str) == false) {
            return true;
        } else {
            return false;
        }
    },
    //----------- ----------- ----------- check string\ email ----------- ----------- -----------
    // fix when first character is $
    tf_checkStringValid: function (str, strHandle) {
        if (str.length > 0) {
            for (var $i = 0; $i <= strHandle.length; $i++) {
                if (str.indexOf(strHandle.charAt($i)) > 0) {
                    return true;
                }

            }
        }
        return false;
    },

    // check email
    tf_checkEmail: function (email) {
        var result = false;
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) result = true;     //cach 1 ko cho cham(dau email)
        // var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;    ////cach 2 cho cham(dau email)
        if (email.indexOf(" ") > 0) result = false;
        //if(regex.test($Email)) $res = true;
        return result;
    },
    tf_checkEmailJav: function (email) {
        if (email == "") return false;
        if (email.indexOf(" ") > 0) return false;
        if (email.indexOf("@") == -1) return false;
        var i = 1;
        var sLength = email.length;
        if (email.indexOf(".") == -1) return false;
        if (email.indexOf("..") != -1) return false;
        if (email.indexOf("@") != email.lastIndexOf("@")) return false;
        if (email.lastIndexOf(".") == email.length - 1) return false;
        var str = "abcdefghikjlmnopqrstuvwxyz-@._0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        for (var j = 0; j < email.length; j++) {
            if (str.indexOf(email.charAt(j)) == -1)return false;
        }
        return true;
    },

    //----------- ----------- ----------- check input ----------- ----------- -----------
    // input text
    tf_checkInputNull: function (object, smg) {
        var value = $(object).val();
        if (value == '') {
            if (smg != '') alert(smg);
            $(object).focus();
            return true;
        } else {
            return false;
        }
    },
    tf_checkInputMaxLength: function (object, limit, smg) {
        var value = $(object).val();
        if (value.length > limit) {
            if (smg != '') alert(smg);
            $(object).focus();
            return true;
        } else {
            return false;
        }
    },
    tf_checkInputMinLength: function (object, limit, smg) {
        var value = $(object).val();
        if (value.length < limit) {
            if (smg != '') alert(smg);
            $(object).focus();
            return true;
        } else {
            return false;
        }
    },

    // radio
    tf_getRadioValue: function (formName, radioName) {
        var val;
        var radios = $("form[name='" + formName + "']").find("input[name= '" + radioName + "']");
        for (var i = 0, len = radios.length; i < len; i++) {
            if (radios[i].checked) {
                val = radios[i].value;
                break;
            }
        }
        return val;
    },
    tf_checkRadioNull: function (formName, radioName) {
        var result = true;
        var radios = $("form[name='" + formName + "']").find("input[name= '" + radioName + "']");
        for (var i = 0, len = radios.length; i < len; i++) {
            if (radios[i].checked) {
                result = false;
            }
        }
        return result;
    },

    // check box
    tf_checkCheckboxChecked: function (formName, checkboxName) {
        var checkbox = $("form[name='" + formName + "']").find("input[name= '" + checkboxName + "']");
        if (checkbox.is(':checked')) {
            return true;
        } else {
            checkbox.focus();
            return false;
        }
    },

    //----------- ----------- -----------  END UPLOAD FILE ----------- ----------- -----------
    tf_checkInputFileValid: function (fileUp, typeCheck, smg) {
        if (!this.tf_checkFile(fileUp, typeCheck)) {
            alert(smg);
            return false;
        } else {
            return true
        }
    },
    tf_checkFile: function (fileUp, typeCheck) {
        var extension = fileUp.split('.').pop().toLowerCase();
        if ($.inArray(extension, typeCheck.split(',')) == -1) {
            return false;
        }
        else {
            return true;
        }
    },

    // view image upload
    tf_selectOneImage: function (file, wrapView, idViewImage, typeSelect) {
        //file: id cua file upload
        //wrapView : id contain view
        // idViewImage: image view
        //typeSelect : type of select file
        if (typeSelect == '') typeSelect = 'gif,jpg,jpeg,png,GIF,JPG,JPEG,PNG';
        var photo = $(file).val();
        if (!this.tf_checkFile(photo, typeSelect)) {
            alert('Invalid ! File type: ' + typeSelect);
            $(file).val('');
            $(file).focus();
            return false;
        }
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = document.getElementById(idViewImage);
            img.src = e.target.result;
            img.style.display = 'inline';
        };
        reader.readAsDataURL(file.files[0]);
        $(wrapView).show();
    },
    // view image upload follow size
    tf_selectOneImageFollowSize: function (file, wrapView, idViewImage, typeSelect, idImageCheckSize) {
        //file: id cua file upload
        //wrapView : id contain view
        // idViewImage: image view
        //typeSelect : type of select file
        if (typeSelect == '') typeSelect = 'gif,jpg,jpeg,png,GIF,JPG,JPEG,PNG';
        var photo = $(file).val();
        if (!this.tf_checkFile(photo, typeSelect)) {
            alert('Invalid ! File type: ' + typeSelect);
            $(file).val('');
            $(file).focus();
            return false;
        }
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = document.getElementById(idViewImage);
            img.src = e.target.result;
            img.style.display = 'inline';

            var checkImg = document.getElementById(idImageCheckSize);
            checkImg.src = e.target.result;
        };
        reader.readAsDataURL(file.files[0]);
        $(wrapView).show();
    },

    // cancel selected image
    tf_cancelOneImage: function (idFile, wrapView) {
        $(idFile).val('');
        $(wrapView).hide();
    },

    //========= ========= submit ajax ========== ========= =========
    // submit ajax
    tf_getSelectAppend: function (url_s, token, id, object_contain) {
        token = $(token).val();
        $.ajax({
            url: url_s + '/' + id,
            type: 'GET',
            cache: false,
            data: {"_token": token, 'id': id},
            success: function (data) {
                if ($(object_contain.length > 0)) {
                    $(object_contain).append(data);
                }
            }
        });
    },

    //----------- ----------- ----------- general ----------- ----------- -----------
    tf_textareaAutoHeight: function (object, row) {
        var t = $(object).val();
        var line = parseInt((t == '') ? 1 : (t.split("\n").length));
        $(object).attr('rows', line + row);
    },
    tf_closeWindow: function (smg) {
        if (smg == '') {
            window.open('', '_self');
            window.close();
        } else {
            if (confirm(smg)) window.close();
        }

    },
    tf_click: function (object) {
        $(object).click();
    },
    tf_empty: function (object) {
        if ($(object).length > 0) $(object).empty();
    },
    tf_remove: function (object) {
        if ($(object).length > 0) $(object).remove();
    },
    tf_show: function (object) {
        if ($(object).length > 0) $(object).show();
    },
    tf_hide: function (object) {
        if ($(object).length > 0) $(object).hide();
    },
    tf_toggle: function (object) {
        if ($(object).length > 0) $(object).toggle();
    },

    tf_show_top: function (object) {
        $(object).addClass('tf-zindex-top');
    },
    tf_hide_top: function (object) {
        $(object).removeClass('tf-zindex-top');
    },

    //replay url
    tf_url_replace: function (href) {
        window.location.replace(href);
    },
    //window reload
    tf_window_reload: function () {
        window.location.reload();
    },

    tf_scrollTop: function () {
        $('body,html').animate({
            scrollTop: 0
        })
    },

    tf_page_new: function (href) {
        window.location.href = href;
    },
    tf_page_back: function () {
        window.history.back(-1);
    },

    //drag object
    tf_main_draggable: function (gridStatus, dragObject, containObject, href) {
        if ($(dragObject).hasClass('moving')) {
            objectWidth = $(dragObject).outerWidth();
            objectHeight = $(dragObject).outerHeight();
            // limit move area (size of contain)
            limitWidht = $(containObject).outerWidth();
            limitHeight = $(containObject).outerHeight();
            $(dragObject).draggable(
                {zIndex: 9999999999},
                {cursor: 'pointer'}, {
                    start: function () {
                        //open project grid when drag
                        if (gridStatus) tf_show('.tf_m_build_project_grid');
                    },
                    drag: function () {
                        topPosition = $(this).position().top;
                        leftPosition = $(this).position().left;
                        //size of drag object

                        //overflow
                        if (leftPosition < 0 || leftPosition > (limitWidht - objectWidth) || topPosition < 0 || topPosition > (limitHeight - objectHeight)) {
                            $(this).addClass('tf-drag-overflow-mask');
                        }
                        else {
                            $(this).removeClass('tf-drag-overflow-mask');
                        }
                    },
                    stop: function () {
                        //close project grid when stop
                        if (gridStatus) tf_hide('.tf_m_build_project_grid');
                        topPosition = $(this).position().top;
                        leftPosition = $(this).position().left;
                        if (topPosition < 0) topPosition = 0;
                        if (topPosition > (limitHeight - objectHeight )) topPosition = limitHeight - objectHeight + 4;
                        if (leftPosition < 0) leftPosition = 0;
                        if (leftPosition > (limitWidht - objectWidth )) leftPosition = limitWidht - objectWidth + 4;

                        //apply to cases overflow
                        if ($(this).hasClass('tf-drag-overflow-mask')) $(this).removeClass('tf-drag-overflow-mask');
                        topPosition = parseInt(topPosition / 16) * 16;
                        leftPosition = parseInt(leftPosition / 16) * 16;

                        //create zindex
                        defualtZindex = 802817;
                        topZindex = topPosition + objectHeight; //top position for create z-index
                        leftZindex = leftPosition + objectWidth; //top position for create z-index
                        for (y = 0; y <= limitHeight; y++) {    // he
                            for (x = 0; x <= limitWidht; x++) {
                                if (y == topZindex && x == leftZindex) newZindex = defualtZindex; // each land has a different z-index
                                defualtZindex = defualtZindex + 1;
                            }
                        }
                        if (typeof newZindex == 'undefined') newZindex = defaultZindex;
                        $(this).css({'top': topPosition, 'left': leftPosition, 'z-index': newZindex});
                        $.ajax({
                            type: 'GET',
                            url: href + '/' + topPosition + '/' + leftPosition + '/' + newZindex,
                            dataType: 'html',
                            data: {},
                            beforeSend: function () {
                                tf_m_build.load_status();
                            },
                            success: function (data) {
                                //process after submit
                            },
                            complete: function () {
                                tf_m_build.load_status();
                            }
                        });
                    }
                });
        } else {
            return false;
        }
    },
};

//process event on mobile
/*

 function touchHandler(event) {
 var touch = event.changedTouches[0];

 var simulatedEvent = document.createEvent("MouseEvent");
 simulatedEvent.initMouseEvent({
 touchstart: "mousedown",
 touchmove: "mousemove",
 touchend: "mouseup"
 }[event.type], true, true, window, 1,
 touch.screenX, touch.screenY,
 touch.clientX, touch.clientY, false,
 false, false, false, 0, null);

 touch.target.dispatchEvent(simulatedEvent);
 event.preventDefault();
 }

 function init() {
 document.addEventListener("touchstart", touchHandler, true);
 document.addEventListener("touchmove", touchHandler, true);
 document.addEventListener("touchend", touchHandler, true);
 document.addEventListener("touchcancel", touchHandler, true);
 }

 */


//action all page
$(document).ready(function () {
    //back
    $('body').on('click', '.tf_page_back', function () {
        tf_main.tf_page_back();
    });

    //reload
    $('body').on('click', '.tf_page_reload', function () {
        tf_main.tf_window_reload();
    });
});