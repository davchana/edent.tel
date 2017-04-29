<?php

$html = '<!doctype html>
<html lang="en-GB">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Terence Eden\'s Contact Details</title>
	<meta name="description" content="@edent all over the web">
	<meta name="author" content="Terence Eden">

	<meta name="twitter:card" content="summary" />
	<meta name="twitter:creator" content="@edent" />
	<meta property="og:url" content="https://edent.tel/" />
	<meta property="og:title" content="Contact @edent" />
	<meta property="og:description" content="Terence Eden\'s contact details - voice, text, fax. OK. Maybe not fax…" />
	<meta property="og:image" content="https://edent.tel/preview.png" />
	<meta property="og:image:width"  content="380" />
	<meta property="og:image:height" content="380" />

	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="/manifest.json">
	<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="theme-color" content="#ffffff">

	<style>';
		$html .= file_get_contents("css/edent.min.css");

$html .='</style>

	<base target="_blank">
</head>
<body>
<div class="marvel-device htc-one">
	<div class="top-bar"></div>
	<div class="camera"></div>
	<div class="sensor"></div>
	<div class="speaker"></div>
	<div class="screen">
		<div itemscope itemtype="http://schema.org/Person" class="h-card" rel="me">
			<h1 itemprop="name" class="p-name">Terence Eden</h1>
			<p itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"><span itemprop="addressLocality">Oxford</span>, <span itemprop="addressCountry">UK</span></p>
			<p class="p-note">Currently running <span itemprop="jobTitle">Open Standards</span> for the <span itemprop="worksFor">UK Government Digital Service.</span></p>
			<p title="I speak a little Chinese" lang="zh">我说一点中文.</p>
			<p><a href="vcard.php" class="download">Download my contact details.</a></p>
			<ul>';

	$str = file_get_contents('config.json');
	$json = json_decode($str, true);

	foreach ($json as $key => $img) {
		$html .= '<li class="icon">';
			$link     = ($img["link"]     != null) ? "href=\"{$img["link"]}\"" : "";
			$itemprop = ($img["itemprop"] != null) ? "itemprop=\"{$img["itemprop"]}\"" : "";
			$rel      = ($img["rel"]      != null) ? "rel=\"{$img["rel"]}\"" : "";
			$class    = ($img["class"]    != null) ? "class=\"{$img["class"]}\"" : "";
			$target   = ($img["target"]   != null) ? "target=\"{$img["target"]}\"" : "";
			$text     = ($img["text"]     != null) ? $img["text"] : "";

			$svg = generate_svg($key, $img["alt"]);

			$html .= "<a {$link} {$itemprop} {$rel} {$class} {$target}>";
			$html .= 	$svg;
			$html .= "<span aria-hidden=\"true\">";
			$html .= 	"{$text}";
			$html .= "</span></a>";
		$html .= "</li>";
	}

	function generate_svg($title,$alt){
			//	Get the tiny SVG
			$svg_file = file_get_contents('svg/'.$title.'.svg');

			//	Add ARIA labels for accessibility
			$start ='<svg
							role="img"
							aria-labelledby="'.$title.'-title"
							class="square" ';
			$title = 			'<title id="'.$title.'-title">'.$alt.'</title>';

			//	Augment the original <svg> tag
			$svg = str_replace("<svg ",$start, $svg_file);

 			//	And add the <title> tag
			$svg = substr_replace($svg, $title, strpos($svg, ">")+1, 0 );

			//	Remove unecessary whitespace
			return preg_replace('/\s+/', ' ',$svg);
		}

$html .= '</ul>		</div>
	</div>
	<div class="speaker" id="bottomspeaker"></div>
</div>
</body>
</html>';

//	Minify
$html = str_replace(array("\r", "\n", "\t"), ' ', $html);
$html = str_replace(array("   "), ' ', $html);
$html = str_replace(array("> <"), "><", $html);
$html = str_replace(array("\" >"), "\">", $html);
$html = str_replace(array("  "), ' ', $html);
$html = str_replace(array("\" />"), "\"/>", $html);
$html = str_replace(array("   "), ' ', $html);
$html = str_replace(array("> <"), "><", $html);

echo $html;
die();
