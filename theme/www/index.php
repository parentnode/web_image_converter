<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");

include_once("classes/helpers/image.class.php");

$FS = new FileSystem();
$ImageClass = new Image();

$files = $FS->files(PRIVATE_FILE_PATH."/convert");
$output_path = PUBLIC_FILE_PATH."/converted/";

function convert($in_file, $out_file, $options) {
	global $ImageClass;
	global $output_path;

	$out_file .= ".".$options["format"];

	$result = $ImageClass->convert($in_file, $output_path.$out_file, $options);
	if($result) {
		print "Converted: ".basename($in_file)." to ".$out_file."<br>";
	}
	else {
		print "<span style=\"color: red;\">Failed</span>: ".basename($in_file)." to ".$out_file." (maybe you need to allow cropping)<br>";
	}

}

foreach($files as $file) {

	$extension = strrchr($file, "."); 
	$file_name = substr(basename($file), 0, strrpos(basename($file), $extension));

	convert($file, $file_name, [
		"width" => 600,
		"height" => 400,
		"allow_cropping" => true,
		"compression" => 60,
		"format" => "jpg"
	]);
	convert($file, $file_name."-small", [
		"width" => 300,
		"height" => 200,
		"allow_cropping" => true,
		"compression" => 60,
		"format" => "jpg"
	]);


	convert($file, $file_name, [
		"width" => 600,
		"height" => 400,
		"allow_cropping" => true,
		"compression" => 60,
		"format" => "avif"
	]);
	convert($file, $file_name."-small", [
		"width" => 300,
		"height" => 200,
		"allow_cropping" => true,
		"compression" => 60,
		"format" => "avif"
	]);


	convert($file, $file_name, [
		"width" => 600,
		"height" => 400,
		"allow_cropping" => true,
		"compression" => 75,
		"format" => "webp"
	]);
	convert($file, $file_name."-small", [
		"width" => 300,
		"height" => 200,
		"allow_cropping" => true,
		"compression" => 75,
		"format" => "webp"
	]);

}

?>
