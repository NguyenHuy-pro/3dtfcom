/**
 * Created by HUY on 6/15/2016.
 */
$(document).ready(function(){
    $('.tf-m-c-wallet-del-a').on('click', function(){
        var url = $(this).data('href');
        var walletID = $(this).data('wallet');
        if(window.confirm('Do you want to delete?')){
            window.location.replace(url + '/' + walletID);
        }else{
            return false;
        }
    });
});