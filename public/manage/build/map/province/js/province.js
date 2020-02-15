/**
 * Created by HUY on 4/15/2016.
 */
$(function(){
    $('.tf_m_build_province').draggable(
        // set position on mini map (file map.js)
        {
            drag: function () {
                tf_m_build.mini_map_set_xy();
            }
        }
    );

})