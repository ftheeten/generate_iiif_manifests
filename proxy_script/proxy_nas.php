<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$iiif_manifest=$_REQUEST['iiif_manifest'];
$url="https://nascollec64.museum.africamuseum.be/manifests/".$iiif_manifest;

/*function replace_url($p_url)
{
	$tmp=str_replace("https://cc.museum.africamuseum.be/loris2/","", $p_url);
	$exploded=explode('/full', $tmp);
	if(count($exploded)>0)
	{
		$exploded[0]=str_replace("/", "%2F", $exploded[0]);
	}
	$returned="https://cantaloupe.museum.africamuseum.be/iiif/3/".implode("/full", $exploded);
	return $returned;
}*/


$ch = curl_init();

  //curl_setopt($ch, CURLOPT_REFERER, 'http://www.example.com/1');
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_VERBOSE, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
  curl_setopt($ch, CURLOPT_URL, $url);
  $response = curl_exec($ch);
  $response=str_replace("http://172.16.11.168/", "https://cc.museum.africamuseum.be/", $response);
  $response=str_replace("http://cc.museum.africamuseum.be", "https://cc.museum.africamuseum.be/", $response);
  
  $response=str_replace("https://cc.museum.africamuseum.be", "https://cc.museum.africamuseum.be/proxy_script/forward_loris.php?url=https://cc.museum.africamuseum.be",$response);
  /*preg_match_all("/http[^\s|\'|\"]+/",$response, $matches);
	$replace=Array();
	foreach($matches[0] as $m)
	{
		$replace[$m]=replace_url($m);	
	}
   foreach($replace as $ori=>$val)
   {
	   $response=str_replace($ori, $val, $response);
   }*/   
  curl_close($ch);
  header('Content-Type: application/json; charset=utf-8');
  print($response);
?>