/**
 * Created by HUY on 4/12/2016.
 */
var tf_system = {
    contact: {
        add: function (formObject) {
            var contentObject = $(formObject).find("textarea[name = 'txtContent']");
            var nameObject = $(formObject).find("input[name = 'txtName']");
            var emailObject = $(formObject).find("input[name = 'txtEmail']");
            var phoneObject = $(formObject).find("input[name = 'txtPhone']");
            var tokenObject = $(formObject).find("input[name = '_token']");

            var data = {
                txtContent: $(contentObject).val(),
                txtName: $(nameObject).val(),
                txtEmail: $(emailObject).val(),
                txtPhone: $(phoneObject).val(),
                _token: $(tokenObject).val(),
            };

            if ($.trim(data.txtContent) == '') {
                alert('Enter contact content');
                $(contentObject).focus();
                return false;
            }
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url : $(formObject).attr('action'),
                data: data,
                beforeSend: function () {
                    tf_master.tf_main_load_status();
                },
                success: function (result) {
                    if (result['error'] == 'fail') {
                        if(result['login'] == 'fail'){
                            alert(result['notifyContent']);
                        }
                        return false;
                    } else if (result['error'] == 'success') {
                        alert(result['notifyContent']);
                        $(formObject).find("button[type = 'reset']").click();
                        return false;
                    }
                },
                complete: function () {
                    tf_master.tf_main_load_status();
                },
                error: function () {
                    alert('Error');
                }
            });

        }
    },
    notify:{
        viewMore:function(containerObject){
            var contentObject = $(containerObject).find('.tf_list_content');
            var dateTake = contentObject.children('.tf_notify_object:last-child').data('date');
            var moreObject = $(containerObject).find('.tf_view_more');
            var take = moreObject.find('a').data('take');
            var href = moreObject.find('a').data('href') + '/' + take + '/' + dateTake;
            $.ajax({
                url: href,
                type: 'GET',
                cache: false,
                data: {},
                beforeSend: function () {
                    tf_master.tf_main_load_status();
                },
                success: function (data) {
                    if (data) {
                        contentObject.append(data);
                    } else {
                        tf_main.tf_remove(moreObject);
                    }
                },
                complete: function () {
                    tf_master.tf_main_load_status();
                }
            });
        },
        view:function(object){
            var objectId = $(object).data('notify');
            var href = $(object).parents('.tf_list_content').data('href-view');
            href = href + '/' + objectId;
            tf_master_submit.ajaxNotReload(href, '#tf_body', false);
        }
    }
}

$(document).ready(function(){
    //on top
    if ($(".tf_system_on_top").length > 0) {
        $('#tf_system_wrap').scroll(function () {
            var e = $('#tf_system_wrap').scrollTop();
            if (e > 300) {
                $(".tf_system_on_top").show()
            } else {
                $(".tf_system_on_top").hide()
            }
        });
        $(".tf_system_on_top").on('click', '.tf_action', function () {
            $('#tf_system_wrap').animate({
                scrollTop: 0
            })
        })
    }
});
//========== ========== ========== Contact ========== ========== ==========
$(document).ready(function () {
    // add contact
    $('.tf_system_contact').on('click', '.tf_system_contact_add', function () {
        var formObject = $(this).parents('.tf_system_contact_form');
        tf_system.contact.add(formObject);
    });


});

//========== ========== ========== Notification ========== ========== ==========
$(document).ready(function () {
    // view more
    $('.tf_system_notify').on('click', '.tf_view_more', function () {
        var containerObject = $(this).parents('.tf_system_notify');
        tf_system.notify.viewMore(containerObject);
    });

    //view detail
    $('body').on('click', '.tf_notify_object .tf_view', function () {
        var object = $(this).parents('.tf_notify_object');
        tf_system.notify.view(object);
    });

});