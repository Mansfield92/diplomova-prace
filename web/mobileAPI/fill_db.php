<!DOCTYPE html>
<html>
<head>
    <title>Fill db</title>
    <meta charset="utf-8">

</head>
<body>

<?php
include("../include/db_init.php");
ini_set('display_errors','on');
$con = mysqli_connect($sql_login_host, $sql_login_user, $sql_login_pass, $sql_login_db);
$con->set_charset("utf8");

$feed = "http://obchod.bazenovachemie.cz/customDataFeed/A5E91A5F-89CA-40A4-A196-7604566DE787";
$xml = simplexml_load_file($feed);
$once = false;

$context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
$xml = file_get_contents($feed, false, $context);
$xml = simplexml_load_string($xml);

foreach ($xml as $item):
    $productname = $item->PRODUCTNAME;
    $item_id = $item->ITEM_ID;
    $description = htmlspecialchars($item->DESCRIPTION);
    $url = $item->URL;
    $imgurl = $item->IMGURL;
    $imgurl_alternative = $item->IMGURL_ALTERNATIVE;
    $price_vat = $item->PRICE_VAT;
    $delivery_date = $item->DELIVERY_DATE;
    $manufacturer = $item->MANUFACTURER;
    $categorytext = $item->CATEGORYTEXT;
    $itemgroup_id = $item->ITEMGROUP_ID;
    $ean = $item->EAN;
    $accessory = $item->ACCESSORY;
    $heureka_cpc = $item->HEUREKA_CPC;



    $query = "INSERT INTO products VALUES (null,'$productname','$item_id','$description','$url','$imgurl','$imgurl_alternative','$price_vat','$delivery_date','$manufacturer','$categorytext','$itemgroup_id','$ean','$accessory','$heureka_cpc',FALSE)";

    $doQuery = mysqli_query($con,$query);
    if($doQuery){
        echo "UPDATED ".$item_id."<br/>";
    }else{
        echo "FAILED ".$item_id."<br/>";
    }


endforeach;
?>
</body>
</html>
