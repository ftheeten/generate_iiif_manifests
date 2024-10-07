<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$url=$_REQUEST['url'];

$ch = curl_init();

curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_VERBOSE, 0);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
  curl_setopt($ch, CURLOPT_URL, $url);

  $response = curl_exec($ch);
  curl_close($ch);
    $mime= curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
  header("Content-type: ".$mime);
  $response=str_replace("http://XXX.XXX.XXX.XXX","https://XX.XX.XX.be",$response);
  print($response);

?>