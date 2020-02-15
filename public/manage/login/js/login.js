/**
 * Created by HUY on 6/29/2016.
 */
$(document).ready(function() {
    // check login
    $('.tf-m-login-a').on('click', function(){
        if(tf_main.tf_checkInputNull('#txtAccount','Enter your account')){
            return false;
        }
        if(tf_main.tf_checkInputNull('#txtPass','Enter your password')){
            return false;
        }
    });
});
