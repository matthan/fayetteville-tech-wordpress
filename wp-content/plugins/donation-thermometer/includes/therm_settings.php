<?php

// Section HTML, displayed before the first option

function help_section_text_fn() {
	?>
	<h3>Basic usage & sizing</h3>
	<p>Thermometers can be placed in a page, post or widget with the shortcode <code>[thermometer]</code>. Default values for the amount raised and target can be set on the settings tab or in the shortcode:
	<code>[thermometer raised=1523 target=5000]</code>.<br/>
	Individual thermometers can be sized using <code>height=200</code> (pixels), or <code>width=20%</code> (percentage of parent container). Set only width OR height as the aspect ratio remains constant.
	
	<h3>Independent shortcode parameters</h3>
	<p>
		These additional parameters can be used within the <code>[thermometer]</code> shortcode to construct unique thermometers. Examples show the default settings:
	</p>
	<p><ul>
		<li><b>target:</b> the target value can be removed from individual thermometers by placing ';off' after the last value: <code>target=500;off</code></li>
		<li><b>raised:</b> the raised value can be removed from individual thermometers by placing ';off' after the last value: <code>raised=250;off</code></li>
		<li><b>targetlabels:</b> sub target labels can be on/off (will disappear to avoid overlap with raised value): <code>targetlabels=on</code></li>
		<li><b>fill:</b> custom fill colour (hex values): <code>fill=#d7191c</code></li>
		<li><b>align:</b> alignment within the parent container (left/right/center): <code>align=left</code></li>
		<li><b>sep:</b> thousands separator: <code>sep=,</code></li>
		<li><b>currency:</b> raised/target value units: <code>currency=$</code> (or <code>currency=null</code>)</li>
		<li><b>trailing:</b> currency symbols follow numeric values (true/false): <code>trailing=false</code></li>
		<li><b>alt:</b> the default alt and title attributes of the image can be modified, or toggled off. Use apostrophes to input a custom string: <code>alt='Raised £1523 towards the £2000 target.'</code> (or <code>alt=off</code>)</li>
		<li><b>ticks:</b> alignment of ticks and the raised value (left/right): <code>ticks=right</code></li>
		<li><b>colorramp:</b> the sequence of fill colours (hex values) used for multiple categories: <code>colorramp='#d7191c; #fdae61; #abd9e9; #2c7bb6'</code></li>
		</ul>
	</p>
	
	<h3>Multiple categories/targets</h3>
	<p><ul>
		<li>The total raised in the thermometer can be partitioned into multiple categories by separating raised values with a semicolon (bottom to top):<br/><code>[thermometer raised=732;234;100]</code>.</li>
		<li>The colours for each category are set using the default global option below, or can be set for individual thermometers using the <code>colorList</code> parameter, separating hex values using a semicolon:<br/>
			<code>[thermometer raised=732;234;100 colorList='#d7191c; #fdae61; #abd9e9;']</code>.</li>
		<li>Incrementing target levels can be set by separating values with a semicolon (bottom to top):<br/><code>[thermometer raised=500 target=600;1000]</code>.</li>
		<li>A legend can be placed below the thermometer by defining labels separated by semicolons (bottom to top):<br/><code>legend='Source A; Source B; Source C'</code>.</li>
	</p>
	<?php
}


function preview_section_text_fn() {
	?>
	<p>Based on the plugin settings defined on this options page, the shortcode <code>[thermometer]</code> will produce an SVG image like this:</p>
	
	<?php
	echo do_shortcode('[thermometer]');
}

function  section_text_fn() {
	?>
	<h2>Default plugin values:</h2>
	<p>These are the default settings for all thermometers on the site, unless modified within the <code>[thermometer]</code> shortcode independently:</p>
	<?php
	
}


// TEXTBOX - Name: plugin_options[fill_colour]
function fill_colour_fn() {
	global $options;
	echo "<div class='form-item' style='display: inline;'><label for='color1'></label><input type='text' id='color1' name='thermometer_options[colour_picker1]' value='".sanitize_text_field($options['colour_picker1'])."' class='colorwell' />";
	echo "  e.g., red hex value = <code>#d7191c</code>";
	echo '<div id="picker" style="display: inline; position: absolute; margin-left:100px;"></div>';
}

// DROP-DOWN-BOX - Name: plugin_options[currency]
function  setting_dropdown_fn() {
	global $options;
	echo "<input id='currency' name='thermometer_options[currency]' size='5' type='text' value='".$options['currency']."' />";
	echo ' define a custom global currency value (also works by entering <code>currency=$</code> in the shortcode)';
}
    
function  setting_thousands_fn() {
	global $options;
	$sep = substr(sanitize_text_field($options['thousands']),0,1);
	$items = array(", (comma)",". (point)"," (space)","(none)");
	echo "<select id='drop_down2' name='thermometer_options[thousands]'>";
	foreach($items as $item) {
		$selected = (substr($item,0,1)==$sep) ? 'selected="selected"' : '';
		echo "<option value='".$item."' ".$selected.">$item</option>";
	}
	echo "</select>";
	echo "  ie. £1,000 or €1.000 or $1000";
}


// tick alignment
function  tick_align_fn() {
	global $options;
	$items = array("right","left");
	echo "<select id='tick_align' name='thermometer_options[tick_align]'>";
	foreach($items as $item) {
		$selected = ($item == sanitize_text_field($options['tick_align'])) ? 'selected="selected"' : '';
		echo "<option value='".$item."' ".$selected.">$item</option>";
	}
	echo "</select>";
	echo ' the raised value will also shift accordingly';
}

// CHECK-BOX - Name: thermometer_options[trailing]
function setting_trailing_fn() {
	global $options;
	$items = array("false","true");
	echo "<select id='trailing' name='thermometer_options[trailing]'>";
	foreach($items as $item) {
		$selected = ($item == sanitize_text_field($options['trailing'])
					 or (sanitize_text_field($options['trailing']) == '1' && $item == 'true')
					 or (sanitize_text_field($options['trailing']) == '2' && $item == 'false')
					 or (sanitize_text_field($options['trailing']) == '0' && $item == 'false')) ? 'selected="selected"' : '';
		echo "<option value='".$item."' ".$selected.">$item</option>";
	}
	echo "</select>";
	echo "  ie. £1,000 (false) or 1.000 NOK (true)";
}

// CHECKBOX - Name: plugin_options[chkbox1] show percentage
function setting_chk1_fn() {
	global $options;
	$items = array("true","false");
	echo "<select id='chkbox1' name='thermometer_options[chkbox1]'>";
	foreach($items as $item) {
		$selected = ($item == sanitize_text_field($options['chkbox1'])
					 or (sanitize_text_field($options['chkbox1']) == '1' && $item == 'true')
					 or (sanitize_text_field($options['chkbox1']) == '0' && $item == 'false')) ? 'selected="selected"' : '';
		echo "<option value='".$item."' ".$selected.">$item</option>";
	}
	echo "</select>";
}
// TEXTBOX - Name: plugin_options[text_colour] 
function text_colour_fn() {
	global $options;
	echo "<div class='form-item'><label for='color2'></label><input type='text' id='color2' name='thermometer_options[colour_picker2]' value='".sanitize_text_field($options['colour_picker2'])."' class='colorwell' />";
	echo "  e.g., black hex value = <code>#000000</code>";
}
// CHECKBOX - Name: plugin_options[chkbox2] show target
function setting_chk2_fn() {
	global $options;
	$items = array("true","false");
	echo "<select id='chkbox2' name='thermometer_options[chkbox2]'>";
	foreach($items as $item) {
		$selected = ($item == sanitize_text_field($options['chkbox2'])
					 or (sanitize_text_field($options['chkbox2']) == '1' && $item == 'true')
					 or (sanitize_text_field($options['chkbox2']) == '0' && $item == 'false')) ? 'selected="selected"' : '';
		echo "<option value='".$item."' ".$selected.">$item</option>";
	}
	echo "</select>";
}

// CHECKBOX - Name: plugin_options[targetlabels] show sub-targets
function setting_chk4_fn() {
	global $options;
	$items = array("true","false");
	echo "<select id='chkbox2' name='thermometer_options[targetlabels]'>";
	foreach($items as $item) {
		$selected = ($item == sanitize_text_field($options['targetlabels'])
					 or (sanitize_text_field($options['targetlabels']) == '1' && $item == 'true')
					 or (sanitize_text_field($options['targetlabels']) == '0' && $item == 'false')) ? 'selected="selected"' : '';
		echo "<option value='".$item."' ".$selected.">$item</option>";
	}
	echo "</select>";
	echo " sub-target values adjacent to the thermometer";
}

// TEXTBOX - Name: plugin_options[subtarget_colour] 
function subtarget_colour_fn() {
	global $options;
	echo "<div class='form-item'><label for='color2'></label><input type='text' id='color4' name='thermometer_options[colour_picker5]' value='".sanitize_text_field($options['colour_picker5'])."' class='colorwell' />";
	echo "  e.g., grey hex value = <code>#8a8a8a</code>";
}

// CHECKBOX - Name: plugin_options[chkbox3] show raised
function setting_chk3_fn() {
	global $options;
	$items = array("true","false");
	echo "<select id='chkbox3' name='thermometer_options[chkbox3]'>";
	foreach($items as $item) {
		$selected = ($item == sanitize_text_field($options['chkbox3'])
					 or (sanitize_text_field($options['chkbox3']) == '1' and $item == 'true')
					 or (sanitize_text_field($options['chkbox3']) == '0' and $item == 'false')) ? 'selected="selected"' : '';
		echo "<option value='".$item."' ".$selected.">$item</option>";
	}
	echo "</select>";
} 
// TEXTBOX - Name: plugin_options[target_colour] 
function target_colour_fn() {
	global $options;
	echo "<div class='form-item'><label for='color3'></label><input type='text' id='color3' name='thermometer_options[colour_picker3]' value='".sanitize_text_field($options['colour_picker3'])."' class='colorwell' />";
	echo "  e.g., black hex value = <code>#000000</code>";
}
// TEXTBOX - Name: plugin_options[raised_colour] 
function raised_colour_fn() {
	global $options;
	echo "<div class='form-item'><label for='color4'></label><input type='text' id='color4' name='thermometer_options[colour_picker4]' value='".sanitize_text_field($options['colour_picker4'])."' class='colorwell' />";
	echo "  e.g., black hex value = <code>#000000</code>";
}
// TEXTBOX - Name: plugin_options[color_ramp]
function color_ramp_fn() {
	global $options;
	echo "<textarea id='color_ramp' name='thermometer_options[color_ramp]' rows='3' col='15'>".sanitize_text_field($options['color_ramp'])."</textarea>";
	echo '<p>a list of hex colours for multiple thermometer categories (bottom to top), separated by semicolons<br/>
	(e.g., <code>#d7191c; #fdae61; #abd9e9; #2c7bb6</code>).
	This default colour ramp is red-green colour-blind friendly.</p>';

}
// TEXTBOX - Name: plugin_options[target_string]
function target_string_fn() {
	global $options;
	echo "<input id='target_string' name='thermometer_options[target_string]' type='text' value='".sanitize_text_field($options['target_string'])."' />";
	echo ' separate incrementing target values with a semi-colon for multiple categories. <code>[therm_t]</code>';
}
// TEXTBOX - Name: plugin_options[raised_string]
function raised_string_fn() {
	global $options;
	echo "<input id='raised_string' name='thermometer_options[raised_string]' type='text' value='".sanitize_text_field($options['raised_string'])."' />";
	echo '  separate raised values with a semi-colon for multiple categories. <code>[therm_r]</code>
	<p><b>Shortcode example</b>: So far we have raised £<code>[therm_r]</code> towards our £<code>[therm_t]</code> target! That\'s <code>[therm_%]</code> of the total!</p>';


}

// Validate user data for some/all of your input fields
function thermometer_options_validate($input) {

	// Check for missed entries - input default
	if (empty($input['colour_picker1']) || strlen($input['colour_picker1']) !=  7){
		$input['colour_picker1'] = $options['colour_picker1'];
	}
	if (empty($input['colour_picker2']) || strlen($input['colour_picker2']) !=  7){
	    $input['colour_picker2'] = $options['colour_picker2'];
	}
	if (empty($input['colour_picker3']) || strlen($input['colour_picker3']) !=  7){
	    if (empty($input['colour_picker4'])){
			$input['colour_picker3'] = $options['colour_picker3'];
	    }
	    else{
			$input['colour_picker3'] = ($input['colour_picker4']); // if 4 not empty make the same
	    }
	}
	if (empty($input['colour_picker4']) || strlen($input['colour_picker4']) !=  7){
	    $input['colour_picker4'] = $options['colour_picker4'];
	}
	
	return $input; // return validated input
}


?>
