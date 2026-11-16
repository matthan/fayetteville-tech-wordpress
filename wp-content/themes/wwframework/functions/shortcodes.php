<?php

/*
function ww_shortcode( $atts , $content = null ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'attr1' => 'false',
			'attr2' => 'false',
		), $atts )
	);

	// Code
	return '';
}
*/

/* Ultra Font Shortcode */
function ww_ultra_font($atts, $content = null) {
    return '<span class="ultra">' . $content . '</span>';
}
add_shortcode('ultra', 'ww_ultra_font');

/* Button Shortcode */
function ww_make_button($atts, $content = null) {
    extract(shortcode_atts(array(
        'color' => 'yellow',
    ), $atts));
    return '<div class="btn btn-default ' . $color. '" role="button" aria-label="' . strip_tags($content) . '">' . $content . '</div>';
}
add_shortcode('button', 'ww_make_button');

/* Highlight Shortcode */
function ww_highlight($atts, $content = null) {
    extract(shortcode_atts(array(
        'color' => 'yellow',
    ), $atts));
    return '<span class="highlight ' . $color. '">' . $content . '</span>';
}
add_shortcode('highlight', 'ww_highlight');

/* ccwidget Shortcode */
function ww_ccwidget($atts, $content = null) {
    extract(shortcode_atts(array(
        'degree' => '',
        'careers' => '',
    ), $atts));
    return "<script src=\"https://s3-us-west-2.amazonaws.com/cc-widget-v2/ccWidget.js\"></script><script src=\"https://s3-us-west-2.amazonaws.com/emsi-specialist-program-files/Dynamic+Plugins/dynamicPluginV2.js\"></script><link rel=\"stylesheet\" type=\"text/css\" href=\"https://s3-us-west-2.amazonaws.com/cc-widget-v2/ccWidget.css\"><script type=\"text/javascript\">window.onload = async function() {try {const onets = await generatePluginData('faytechcc','" . $degree . "','cfe4ab72326543b2905c27203e13b441'); const subdomain = 'faytechcc'; const level = 'msa'; const geoids = ['22180']; ccWidget.render(subdomain, level, geoids, onets, false);} catch(e) {const subdomain = 'faytechcc'; const level = 'msa'; const geoids = ['22180']; const onets = [" . $careers . "]; ccWidget.render(subdomain, level, geoids, onets, false);}}</script><div id='cc-widget-careers'></div>";

    return '<span class="highlight ' . $color . '">' . $content . '</span>';
}
add_shortcode('ccwidget', 'ww_ccwidget');

?>
