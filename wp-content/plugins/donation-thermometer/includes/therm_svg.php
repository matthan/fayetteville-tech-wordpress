<?PHP
/*
 * Creates the SVG thermometer
 */

function stringLength($a,$b){
	return mb_strlen($a.$b);
}


function thermhtml($thermProperties){
	ob_start();
	
	// thermometer values and units
	$raisedA = explode(';',$thermProperties['raised']);
	if (end($raisedA) == 'off'){
		$showRaised = 0;
		array_splice($raisedA,-1);
	}
	else{
		$showRaised = $thermProperties['showRaised'];
	}
	$raisedTotal = array_sum($raisedA);
	
	$targetA = explode(';',$thermProperties['target']);
	if (end($targetA) == 'off'){
		$showTarget = 0;
		array_splice($targetA,-1);
	}
	else{
		$showTarget = $thermProperties['showTarget'];
	}
	$showSubTargets = $thermProperties['targetlabels'];
	$targetTotal = end($targetA);
	
	$currency = $thermProperties['currency'];
	$raisedPercent = number_format(($raisedTotal/$targetTotal * 100),0);
	$raisedValue = ($thermProperties['trailing'] == 'true') ? number_format($raisedTotal,0,'.',$thermProperties['sep']).$currency : $currency.number_format($raisedTotal,0,'.',$thermProperties['sep']);
	$targetValue = ($thermProperties['trailing'] == 'true') ? number_format($targetTotal,0,'.',$thermProperties['sep']).$currency : $currency.number_format($targetTotal,0,'.',$thermProperties['sep']);
	$subTargetValue = ($thermProperties['trailing'] == 'true') ? number_format(max($targetA),0,'.',$thermProperties['sep']).$currency : $currency.number_format(max($targetA),0,'.',$thermProperties['sep']); // use only longest value thats not the target total
	
	// colours & legend
	if (sizeof($raisedA) > 1 && !empty($thermProperties['colorList'])){
		$colorListA = explode(';',rtrim($thermProperties['colorList'],';'));
	}
	else{
		$colorListA = array($thermProperties['fill']);
	}
	
	$legend = rtrim($thermProperties['legend'],';'); // trim last semicolon if added
	$legendA = explode(';',$legend);
	$legendA = array_slice($legendA,0,count($raisedA)); // shorten legend entries to match raised value count
	
	$percentageColor = $thermProperties['percentageColor'];
	$targetColor = $thermProperties['targetColor'];
	$raisedColor = $thermProperties['raisedColor'];
	$subTargetColor = $thermProperties['subtargetColor'];
	
	
	// basic properties of the thermometer
	$minH = 236;
	$maxH = 26;
	$leftM = 20;
	$rightM = 56;
	$tickM = ($thermProperties['ticks'] == 'left') ? $leftM : $rightM;
	$markerSize = 5;
	$legendStep = 15;
	
	// transforms to svg depending what is shown
	$transformY = ($showTarget == '1') ? -10 : 10; // show target value move down
	$viewboxY = ($showTarget == '1') ? 300 : 280;
	
	if (!empty($tickM) && $tickM == $rightM){	// left or right ticks
		$viewboxX1 = 0;
		$viewboxX2 = 76;
		$majorTickL = $rightM - 13;
		$minorTickL = $rightM - 6;
		$markerMargin = $rightM + 2;
		$raisedMargin = $rightM + 10;
		$raisedAnchor = 'start';
	}
	else{
		if(count($targetA) > 1){
			$viewboxX1 = mb_strlen($subTargetValue)*-7;
		}
		else{
			$viewboxX1 = mb_strlen($raisedValue)*-7;
		}
		
		$viewboxX2 = 76;
		$majorTickL = $leftM + 13;
		$minorTickL = $leftM + 6;
		$markerMargin = $leftM - 2;
		$raisedMargin = $leftM - 10;
		$raisedAnchor = 'end';
	}
	
	if (count($targetA) > 1){
		$viewboxX2 = 76 + mb_strlen($subTargetValue)*8; // expand right
	}
	elseif (!empty($raisedValue)){
		$viewboxX2 = 76 + mb_strlen($raisedValue)*8; // expand right
	}
	
	if (!empty($legend)){
		$viewboxY = $viewboxY+(count($legendA)*$legendStep); // expand down
		$maxRaised = max(array_map('stringLength',$raisedA, $legendA)) 
		+ mb_strlen($thermProperties['currency']) 
		+ substr_count(number_format(max($raisedA),0,'.',$thermProperties['sep']), $thermProperties['sep'])
		+ 3; // max legend width incl. space & ()
		$viewboxX2 = max($viewboxX2, $maxRaised*6.25); // expand right
	}
	
	// title/alt attribute
	if (strtolower($thermProperties['title']) == 'off'){
		$title = '';
	}
	elseif(!empty($thermProperties['title'])){
		$title = $thermProperties['title'];
	}
	else{
		$title = 'Raised '.$raisedValue.' towards the '.$targetValue.' target.';
	}
	
	// size properties
	
	$aspectRatio = $viewboxX2/$viewboxY; // width/height
	$workAround = 'n';
	if (!empty($thermProperties['width'])){
		if (is_numeric(substr($thermProperties['width'],-1)) or substr($thermProperties['width'], -2) == 'px'){
			$width = preg_replace("/[^0-9]/", "", $thermProperties['width'] );
			$height = $width / $aspectRatio;
		}
		elseif (substr($thermProperties['width'],-1) == '%'){
			$width = $thermProperties['width'];
			$height = intval($thermProperties['width'])/$aspectRatio.'%';
			$workAround = 'yesW';
		}
	}
	elseif (!empty($thermProperties['height'])){
		if (is_numeric(substr($thermProperties['height'],-1)) or substr($thermProperties['height'], -2) == 'px'){
			$height = preg_replace("/[^0-9]/", "", $thermProperties['height'] );
			$width = $height * $aspectRatio;
		}
		elseif (substr($thermProperties['height'],-1) == '%'){
			$height = $thermProperties['height'];
			$workAround = 'yesH';
		}
	}
	
		
	/*
	 *
	 * start making the svg thermometer
	 * 
	 */
	if ($workAround == 'yesW'){
		echo '<div style="display: inline-block; width: '.$width.'; position: relative; user-select: none;">';
		echo '<canvas class="Icon-canvas" height="'.$viewboxY.'" width="'.$viewboxX2.'" style="display: block; width: 100%!important; visibility: hidden;"></canvas>';
		echo '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewbox="'.$viewboxX1.' '.$transformY.' '.$viewboxX2.' '.$viewboxY.'"
		alt="'.$title.'" preserveAspectRatio="xMidYMid" style="height: 100%; left: 0; position: absolute; top: 0; width: 100%;">';
	}
	elseif ($workAround == 'yesH'){
		echo '<div style="display: inline-block; height: '.$height.'; position: relative; user-select: none;">';
		echo '<canvas class="Icon-canvas" height="'.$viewboxY.'" width="'.$viewboxX2.'" style="display: block; height: 100% !important; visibility: hidden;"></canvas>';
		echo '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewbox="'.$viewboxX1.' '.$transformY.' '.$viewboxX2.' '.$viewboxY.'"
		alt="'.$title.'" preserveAspectRatio="xMidYMid" style="height: 100%; left: 0; position: absolute; top: 0; width: 100%;">';
	}
	else{
		echo '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="'.$width.'" height="'.$height.'" viewbox="'.$viewboxX1.' '.$transformY.' '.$viewboxX2.' '.$viewboxY.'" alt="'.$title.'"
		style="'.$thermProperties['align'].'" preserveAspectRatio>';
	}
	
	echo '<desc>Created using the Donation Thermometer plugin https://wordpress.org/plugins/donation-thermometer/.</desc>';
	
	// target
	if ($showTarget == 1){
		echo '<text x="38" y="10" font-size=16 font-family="sans-serif" text-anchor="middle"
		 fill="'.$targetColor.'" dominant-baseline="baseline">'.$targetValue.'</text>';
	}
	
	// fill
	$oldThermLevel = 236;
	$i = 0;
	foreach($raisedA as $r){
		if ($i == 0) {
			$newThermLevel = ($raisedTotal > $targetTotal) ? $minH - (($minH - $maxH) * ($r/$raisedTotal)) : $minH - (($minH - $maxH) * ($r/$targetTotal));
			echo '<path d="M'.$leftM.' '.$newThermLevel.'
			L '.$leftM.' 241
			C 15.5 245, 13 252, 13 258
			C 13 272, 24 283, 38 283
			C 52 283, 63 272, 63 258
			C 63 252, 60 245, '.$rightM.' 241
			L '.$rightM.' '.$newThermLevel.'
			L '.$leftM.' '.$newThermLevel.'"
			   stroke="black" stroke-width="0.2" fill="'.trim($colorListA[$i]).'"/>';	
		}
		else{
			$fill = ($i > count($colorListA)-1) ? $thermProperties['fill'] : trim($colorListA[$i]); // if not enough colours in list -> transparent
			$newThermLevel = ($raisedTotal > $targetTotal) ? $oldThermLevel - (($minH - $maxH) * ($r/$raisedTotal)) : $oldThermLevel - (($minH - $maxH) * ($r/$targetTotal));
			echo '<rect x="'.$leftM.'" y="'.$newThermLevel.'" width="'.($rightM-$leftM).'" height="'.($oldThermLevel-$newThermLevel).'"
			fill="'.$fill.'" stroke-width="0.3" stroke="black"/>';
		}
		
		$i++;
		$oldThermLevel = $newThermLevel;
		
	}
	
	// raised value & ticks
	if ( !empty($raisedValue) && $showRaised == 1 ){
		if ( $tickM == $rightM ){
			echo '<path d="M '.$markerMargin.' '.$newThermLevel.', '.($markerMargin+$markerSize).' '.($newThermLevel-$markerSize).', '
						.($markerMargin+$markerSize).' '.($newThermLevel+$markerSize).' Z"
				 stroke="black" stroke-width="0.2" fill="black"/>';
		}
		elseif ($tickM == $leftM){
			echo '<path d="M '.$markerMargin.' '.$newThermLevel.', '.($markerMargin-$markerSize).' '.($newThermLevel+$markerSize).', '
						.($markerMargin-$markerSize).' '.($newThermLevel-$markerSize).' Z"
				 stroke="black" stroke-width="0.2" fill="black"/>';
		}
		echo '<text x="'.$raisedMargin.'" y="'.$newThermLevel.'" font-size=14 font-family="sans-serif"
		text-anchor="'.$raisedAnchor.'" dominant-baseline="central" fill="'.$raisedColor.'">'.$raisedValue.'</text>';
	}
	
	// multiple subtargets
	if( count($targetA) > 1 ){ // only if multiple targets
		foreach( array_slice($targetA,0,-1) as $t ){ // and skip the last target total
			
			$targetLevel = $minH - (($minH - $maxH) * ($t/$targetTotal));
			echo '<path d="M'.$leftM.' '.$targetLevel.'
				L '.$rightM.' '.$targetLevel.'"
				 stroke="'.$subTargetColor.'" stroke-width="2.5" fill="transparent"/>';
			
			if ($raisedTotal <= $t*0.9 or $raisedTotal >= $t*1.1 or $showRaised == 0){ // within 10% but only when not reached the subtotal	
				if ($showSubTargets == 1){
					if ( $tickM == $rightM ){
					echo '<path d="M '.$markerMargin.' '.$targetLevel.', '.($markerMargin+$markerSize).' '.($targetLevel-$markerSize).', '
								.($markerMargin+$markerSize).' '.($targetLevel+$markerSize).' Z"
						 stroke="#8a8a8a" stroke-width="0.2" fill="'.$subTargetColor.'"/>';
					}
					elseif ($tickM == $leftM){
						echo '<path d="M '.$markerMargin.' '.$targetLevel.', '.($markerMargin-$markerSize).' '.($targetLevel+$markerSize).', '
									.($markerMargin-$markerSize).' '.($targetLevel-$markerSize).' Z"
							 stroke="#8a8a8a" stroke-width="0.2" fill="'.$subTargetColor.'"/>';
					}
					$t = ($thermProperties['trailing'] == 'true') ? number_format($t,0,'.',$thermProperties['sep']).$currency : $currency.number_format($t,0,'.',$thermProperties['sep']);
					echo '<text x="'.$raisedMargin.'" y="'.$targetLevel.'" fill="'.$subTargetColor.'" font-size=14 font-family="sans-serif" text-anchor="'.$raisedAnchor.'" dominant-baseline="central">'.$t.'</text>';
				}
			}
		}
	}
	
	
			
	// outline overlay	// title needs to be a child element to display as tooltip
	echo '<path d="M38 15.5
			C 28 15.5, 20 20, '.$leftM.' '.$maxH.'
			L '.$leftM.' 241
			C 15.5 245, 13 252, 13 258
			C 13 272, 24 283, 38 283
			C 52 283, 63 272, 63 258
			C 63 252, 60 245, '.$rightM.' 241
			L '.$rightM.' '.$maxH.'
			C '.$rightM.' 20, 48 15.5, 38 15.5"
			   stroke="black" stroke-width="1.5" fill="transparent"><title>'.$title.'</title></path>';
	
	//major ticks       
	echo '<path d="M'.$tickM.' '.$maxH.'
		L '.$majorTickL.' '.$maxH.'
		M'.$tickM.' 68
		L '.$majorTickL.' 68
		M'.$tickM.' 110
		L '.$majorTickL.' 110
		M'.$tickM.' 152
		L '.$majorTickL.' 152
		M'.$tickM.' 194
		L '.$majorTickL.' 194
		M'.$tickM.' '.$minH.'
		L '.$majorTickL.' '.$minH.'"
			 stroke="black" stroke-width="2.5"/>';
	
	//minor ticks
	echo '<path d="M'.$tickM.' 47
		L '.$minorTickL.' 47
		M'.$tickM.' 89
		L '.$minorTickL.' 89
		M'.$tickM.' 131
		L '.$minorTickL.' 131
		M'.$tickM.' 173
		L '.$minorTickL.' 173
		M'.$tickM.' 215
		L '.$minorTickL.' 215
		M'.$tickM.' '.$minH.'
		L '.$minorTickL.' '.$minH.'"
			 stroke="black" stroke-width="2.5"/>';

	
	// percentage
	if ($thermProperties['showPercent'] == 1){
		if (mb_strlen($raisedPercent) < 3){
			$fontS_percent = 17;
		}
		elseif (mb_strlen($raisedPercent) < 4){
			$fontS_percent = 15;
		}
		else{
			$fontS_percent = 12;
		}
			
		echo '<text x="38" y="264" font-size='.$fontS_percent.' font-family="sans-serif"
		fill="'.$percentageColor.'" font-weight="bold" text-anchor="middle">'.$raisedPercent.'%</text>';
	}
	
	// legend	
	if(!empty($legend)){
		$legendLevel = 300;
		$legendAr = array_reverse($legendA);
		$raisedAr = array_reverse($raisedA);
		$i = count($raisedAr) - 1; // for color 
		$i2 = count($legendAr) - 1;
		$j = 0;
		foreach($raisedAr as $r){
			if($i > $i2){
				$i--;
				continue;
			}
			
			$legendColor = (array_key_exists($i, $colorListA)) ? trim($colorListA[$i]) : 'black';	
			echo '<text font-size="12" font-family="sans-serif" x="'.($viewboxX1+4).'" y="'.$legendLevel.'" dominant-baseline="baseline" text-anchor="left" fill="'.$legendColor.'">'.$legendAr[$j];
			if (count($raisedA) >= 1){
				echo ($thermProperties['trailing'] == 'true') ? ' ('.trim(number_format($r,0,'.',$thermProperties['sep'])).$currency.')' : ' ('.$currency.trim(number_format($r,0,'.',$thermProperties['sep'])).')';
			}
			echo '</text>';
			$legendLevel = $legendLevel + $legendStep;
			$i--;
			$j++;
		}
	}
	
	echo '</svg>';
	if ($workAround == 'yesH' or $workAround == 'yesW'){
		echo '</div>';
	}
	return ob_get_clean();
}
?>
