/**
 * Created by HUY on 6/16/2016.
 */
//---------- ---------- ---------- general ---------- ---------- ----------
$(document).ready(function(){
    $('.tf-m-c-project-sample-del-a').on('click', function(){
        var url = $(this).data('href');
        var sampleID = $(this).data('sample');
        if(window.confirm('Do you want to delete?')){
            window.location.replace(url + '/' + sampleID);
        }else{
            return false
        }
    });
});