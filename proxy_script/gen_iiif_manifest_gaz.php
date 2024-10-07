<?php
$path=$_REQUEST["path"];
$path=str_replace("|","/", $path);
$year=$_REQUEST["year"];
$year=str_replace("|","/", $year);
$img=$_REQUEST["img"];


$url_prefix="https://xxx/iiif/xx/";


$phys_path='/mnt/xx.xx.xx.xxx/xxx/xxx/xxx/'.$path.'/'.$year;
$url_path='xxxx/xxx/xxx/'.$path.'/'.$year;
$files=scandir($phys_path);

$pattern=str_replace(".", "\.", $img);
$possible=Array();
foreach($files as $file)
{
	
	if(preg_match('/^('.$pattern.')([\d]*).*/i', $file, $matches)===1&&preg_match('/^.*\.(tiff|tif|jpeg|jpg|jp2|png)$/i', $file, $matches)===1)
	{
		//print($file);
		//print_r($matches);µ
		if(count($matches)>0)
		{
			$sort=str_replace($img, "", $file);
			if(preg_match('/(^[^A-Za-z])(\d+)(.*)/i', $sort, $matches2))
			{
				//print_r($matches2);
				if(count($matches2)==4)
				{
					
					$prefix=(string)$matches2[2];
					$prefix= str_pad($prefix, 4, "0", STR_PAD_LEFT);
					
					$sort=$matches2[1].$prefix.$matches2[3];
				}
			}
			$possible[$sort]=$file;
		}
		
	}
	
}
ksort($possible);

$img_desc=Array();
foreach($possible as $file)
{
	$phys_file=$phys_path."/".$file;
	$desc=getimagesize($phys_file);

	$img_desc[$file]=["w"=>$desc[0], "h"=> $desc[1]];
}

header('Content-Type: application/json; charset=utf-8');
?>{
    "@context": "http://iiif.io/api/presentation/2/context.json",
    "@id": "<?php print((empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");?>",
    "@type": "sc:Manifest",
    "label": "<?php print($img);?>",
    "sequences": [
		{
		"@type": "sc:Sequence",
		 "canvases":  [
				<?php $i=0; ?>
				<?php foreach($img_desc as $key=>$im):?>
				<?php if($i>0): ?>
					,
				<?php endif;?>
				{
					 "@id": "https://xx.xxxxxxxxx.xxxxxxxxxxx.be/manifests/canvas/<?php print($key).".json";?>",
                    "@type": "sc:Canvas",
                    "label": "<?php print($key);?>",
                    "height": <?php print($im["h"]);?>,
                    "width": <?php print($im["w"]);?>,
                    "images": [
                        {
                            "@type": "oa:Annotation",
                            "motivation": "sc:painting",
                            "resource": {
                                "@id": "<?php print($url_prefix.urlencode($url_path)."%2F".$key);?>/full/max/0/default.jpg",
                                "@type": "dctypes:Image",
                                "format": "image/jpeg",
                                "service": {
                                    "@context": "http://iiif.io/api/image/2/context.json",
                                    "@id": "<?php print($url_prefix.urlencode($url_path)."%2F".$key);?>",
                                    "profile": "http://iiif.io/api/image/2/level2.json"
                                }
                            },
                            "on": "https://xx.xxxxxxxxx.xxxxxxxxxxx.be/manifests/canvas/page-DA.4.1_SCAN_0001.jp2.json"
                        }
					]
				}
				<?php $i++; ?>
				<?php endforeach; ?>
		 
				]
		  }
		 
		]
}