<?php
function set_custom_css($css_theme_uri){
    
    $css_theme_uri = get_template_directory_uri() . '/assets/css/vkrz/login.css';
    return $css_theme_uri;

}
add_filter('oa_social_login_default_css', 'set_custom_css');
add_filter('oa_social_login_widget_css', 'set_custom_css');
add_filter('oa_social_login_link_css', 'set_custom_css');