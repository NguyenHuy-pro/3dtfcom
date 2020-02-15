var tf_m_c_content = {
    closeContainerAction:function(){
        tf_main.tf_remove('#tf_m_c_container_wrap');
    }
}
$(document).ready(function() {
    //var windowHeight = window.innerHeight;//screen.height;
    //var windowWidth = window.innerWidth;//screen.height;
    //$('#tf_m_c_wrapper').css('min-height',windowHeight);

    //---------- contain action ----------
    $('body').on('click', '.tf_m_c_container_close', function () {
        tf_m_c_content.closeContainerAction();
    });
});