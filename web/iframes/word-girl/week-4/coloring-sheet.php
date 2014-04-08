<?php

if (isset($_GET['name'])) {
	require_once 'classes/fpdf/fpdf.php';
	

	$current_site = $_SERVER['SERVER_NAME'];
	$current_site = str_replace('www.','',strtolower($current_site));

	$pdf = 'old-country';
	
	switch($current_site) {
		case 'buffet.com':
			$pdf = 'old-country';
		break;
		case 'buffetsinc.com':
			$pdf = 'old-country';
		break;		
		case 'oldcountrybuffet.com':
			$pdf = 'old-country';
		break;
		case 'countrybuffet.com':
			$pdf = 'country';
		break;
		case 'firemountainbuffet.com':
			$pdf = 'fire-mountain';
		break;
		case 'grannysbuffet.com':
			$pdf = 'old-country';
		break;
		case 'hometownbuffet.com':
			$pdf = 'hometown';
		break;
		case 'ryans.com':
			$pdf = 'ryans';
		break;
		
		
	}
	$coloring_sheet = $pdf.'-coloring-sheet.jpg';
	

	// Set the content-type
	//header('Content-Type: image/png');
	// Create the image
	$tree = imagecreatefromjpeg('images/'.$coloring_sheet);

	imagealphablending($tree, true);
	imagesavealpha($tree, true);
	
	
	$white = imagecolorallocate($tree, 255, 255, 255);
	$grey = imagecolorallocate($tree, 128, 128, 128);
	$black = imagecolorallocate($tree, 0, 0, 0);
	//imagefilledrectangle($im, 0, 0, 399, 29, $white);
	
	// The text to draw
	$text = $_GET['name'];
	// Replace path by your own font path
	$font = 'css/fonts/ARIAL.TTF';
	$bold = 'css/fonts/ARLRDBD.TTF';
	// Add the text
	
	
	$tb = imagettfbbox(30, 0, $font, $text);
	$theight =  abs(ceil($tb[1] - $tb[7]));
	$twidth = abs(ceil($tb[2] - $tb[0]));
	
	
	
	imagettftext($tree, 30, 0, 430 - ($twidth / 2) - 20, 62,  $black, $bold, $text);
	
	
	// Using imagepng() results in clearer text compared with imagejpeg()
	
	$filename = 'images/'.time().'_'.rand().'.png';
	
	$rotate = imagerotate($tree, 90, 0);
	
	imagepng($rotate, $filename);		

	
	$pdf = new FPDF('P','in','Letter');
	$pdf->AddPage();
	$pdf->Image($filename, 0.5, 1);

	$pdf->Output('buffets-coupon.pdf','I');
	
	imagedestroy($tree);
	unlink($filename);

		
	
}

?>