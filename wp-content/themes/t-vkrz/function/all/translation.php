<?php
add_filter( 'weglot_add_json_keys',  'custom_weglot_add_json_keys' );
function custom_weglot_add_json_keys($keys){
    $keys[]  =  'top_question';
	  $keys[]  =  'top_title';
	  $keys[]  =  'championname';
	  $keys[]  =  'description_user';
    return $keys;
}

function custom_weglot_dynamics_selectors($default_dynamics) {
    return [
        ['value' => 'body'],
        ['value' => '.text-muted']
    ];
}
add_filter('weglot_dynamics_selectors', 'custom_weglot_dynamics_selectors');
add_filter('weglot_whitelist_selectors', 'custom_weglot_dynamics_selectors');
add_filter('weglot_translate_dynamics', '__return_true');
add_filter('weglot_allowed_urls', function ($urls) {
    return 'all';
});

add_filter( 'weglot_words_translate', 'custom_weglot_words_translate' );
function custom_weglot_words_translate( $words ){        
    $words[] = "créée par";         
    return $words;
}