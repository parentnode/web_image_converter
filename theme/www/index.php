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


foreach($files as $file) {

	$extension = strrchr($file, "."); 
	$file_name = substr(basename($file), 0, strrpos(basename($file), $extension));

	$ImageClass->convert($file, PUBLIC_FILE_PATH."/converted/".$file_name.".avif", [
		"compression" => 60,
		"format" => "avif"
	]);
	print "Converted: ".basename($file)." to ".$file_name.".avif<br>";

	$ImageClass->convert($file, PUBLIC_FILE_PATH."/converted/".$file_name.".webp", [
		"compression" => 75,
		"format" => "webp"
	]);
	print "Converted: ".basename($file)." to ".$file_name.".webp<br>";

}

?>
