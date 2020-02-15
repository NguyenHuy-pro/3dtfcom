/**
 * Created by HUY on 4/9/2016.
 */
var tf_point = {
    online: {
        selectPackage: function (object) {
            $('.tf_point_package').filter(function () {
                if ($(this).hasClass('tf-point-package-selected')) $(this).removeClass('tf-point-package-selected');
            });
            $(object).addClass('tf-point-package-selected');
        },
        wallet: {
            get: function (formObject) {
                var selectStatus = false;
                var pointValue = 0;
                $('.tf_point_package').filter(function () {
                    if ($(this).hasClass('tf-point-package-selected')) {
                        selectStatus = true;
                        pointValue = parseInt($(this).data('point'));
                    }
                });

                if (selectStatus) {
                    $(formObject).find('.txt_point').val(pointValue);
                    tf_master_submit.normalForm(formObject);
                } else {
                    alert('You have to select a package');
                    return false;
                }
            },
            selectWallet: function (object) {
                $('.tf_point_wallet').filter(function () {
                    if ($(this).hasClass('tf-point-wallet-selected')) $(this).removeClass('tf-point-wallet-selected');
                });
                $(object).addClass('tf-point-wallet-selected');
            },
            nganluong: {
                paymentDetail: function (formObject) {
                    var selectStatus = false;
                    var walletId = 0;
                    var href = '';
                    $('.tf_point_wallet').filter(function () {
                        if ($(this).hasClass('tf-point-wallet-selected')) {
                            selectStatus = true;
                            walletId = parseInt($(this).data('wallet'));
                            href = $(this).data('href');
                        }
                    });

                    if (selectStatus) {
                        $(formObject).find('.txt_wallet').val(walletId);
                        $(formObject).attr('action', href);
                        $(formObject).submit();
                    } else {
                        alert('You have to select a wallet');
                        return false;
                    }
                }
            }


        }
    }
}

$(document).ready(function () {
    //select package
    $('body').on('mouseover', '.tf_point_package', function () {
        tf_point.online.selectPackage(this);
    });

    //get payment type
    /*
    $('body').on('click', '.tf_point_online_payment_get', function () {
        var formObject = $(this).parents('#frm_point_online_package');
        tf_point.online.wallet.get(formObject);
    });
    */
    $('body').on('click', '.tf_point_package_buy_button', function () {
        var packageObject = $(this).parents('.tf_point_package');
        if(!packageObject.hasClass('tf-point-package-selected')){
            tf_point.online.selectPackage(packageObject);
        }

        var formObject = $(this).parents('#frm_point_online_package');
        tf_point.online.wallet.get(formObject);
    });

    //select wallet
    $('body').on('click', '.tf_point_wallet', function () {
        tf_point.online.wallet.selectWallet(this);
    });

    //get payment detail
    $('body').on('click', '.tf_point_online_payment_detail', function () {
        var formObject = $(this).parents('#frm_point_online_payment_detail');
        tf_point.online.wallet.nganluong.paymentDetail(formObject);
    });
});