<?php
ini_set('max_execution_time', 300);
ob_start();

$downloadURL = urldecode($_GET['link']);
//print  $downloadURL;exit;
$type = urldecode($_GET['type']);
$title = urldecode($_GET['title']);

//Finding file extension from the mime type
$typeArr = explode("/",$type);
$extension = $typeArr[1];

$fileName = $title.'.'.$extension;
$new_fileName = preg_replace('~[\\\\/:*?"<>|# ]~', '_', $fileName);


$dwdir="dupload/".$new_fileName;

if (isset($_GET['dl']))
{
                  echo "<strong>Please Waiting For Downloading...</strong> ";
		
		downloadDistantFile($downloadURL,$dwdir);
		
               ob_clean(); 
		
		echo "<a href=".$dwdir."> Download $new_fileName </a>";
		die();
	
}


 function downloadDistantFile($url, $dest)
  {
    $options = array(
      CURLOPT_FILE => is_resource($dest) ? $dest : fopen($dest, 'w'),
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_URL => $url,
      CURLOPT_FAILONERROR => true, // HTTP code > 400 will throw curl error
    );

    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $return = curl_exec($ch);

    if ($return === false)
    {
      return curl_error($ch);
    }
    else
    {
      return true;
    }
	fclose($dest);
  }


if (!empty($downloadURL)) {
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment;filename=\"$fileName\"");
    header("Content-Transfer-Encoding: binary");

    readfile($downloadURL);

}
ob_end_flush();
?>

