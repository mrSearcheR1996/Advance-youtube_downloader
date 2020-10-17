<?php
$text=$_GET['title'];
//$titlec=str_replace('"'," ",$text);
$title= iconv("UTF-8", "UTF-8//TRANSLIT", $text);
$file=$_GET['in'];
$url = strtok($file, '?');
$filename = basename($url);
$file_extension = strtolower(substr(strrchr($filename,"."),1));

switch( $file_extension ) {
    case "gif": $ctype="image/gif"; break;
    case "png": $ctype="image/png"; break;
    case "jpeg":
    case "jpg": $ctype="image/jpeg"; break;
    case "svg": $ctype="image/svg+xml"; break;
    default:
}
header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename="'.$title.'"');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-type: ' . $ctype);

readfile($url);
?>
