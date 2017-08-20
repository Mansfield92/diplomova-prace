
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    </head>
    <body>
<?php
include("include/db_init.php");
$con = mysqli_connect($sql_login_host, $sql_login_user, $sql_login_pass, $sql_login_db);
$con->set_charset("utf8");

$feed = "http://obchod.bazenovachemie.cz/customDataFeed/A5E91A5F-89CA-40A4-A196-7604566DE787";
$url = $feed;
$xml = simplexml_load_file($url);
$once = false;
$new=$success=$failed=$update=0;

$x = true;
//print_r($xml);

foreach ($xml as $item):
    $productname = $item->PRODUCTNAME;
    $item_id = $item->ITEM_ID;
    $description = htmlspecialchars($item->DESCRIPTION);
    $url = $item->URL;
    $imgurl = $item->IMGURL;
    if(count($item->IMGURL_ALTERNATIVE)>1){
        $help = $item->IMGURL_ALTERNATIVE[0];
        for($a = 1;$a < count($item->IMGURL_ALTERNATIVE);$a++){
            $help.="|".$item->IMGURL_ALTERNATIVE[$a];
        }
        $imgurl_alternative = $help;
    }
    $price_vat = $item->PRICE_VAT;
    $delivery_date = $item->DELIVERY_DATE;
    $manufacturer = $item->MANUFACTURER;
    $categorytext = $item->CATEGORYTEXT;
    $itemgroup_id = $item->ITEMGROUP_ID;
    $ean = $item->EAN;
    $accessory = $item->ACCESSORY;
    $heureka_cpc = $item->HEUREKA_CPC;

    if($x){
        $x = false;
    }

    $query = "SELECT * from products where ITEM_ID = '$item_id'";
    $exist = $con->query($query);
    $toReturn = "";
    if($exist->num_rows == 0){
        $new++;
        $query = "INSERT INTO products VALUES (null,'$productname','$item_id','$description','$url','$imgurl','$imgurl_alternative','$price_vat','$delivery_date','$manufacturer','$categorytext','$itemgroup_id','$ean','$accessory','$heureka_cpc',FALSE,'','','','','')";
//        echo 'INSERT-'.$productname.';'.$item_id.'</br></br>';
//        echo $query;
//        echo '</br></br>';
        $doQuery = mysqli_query($con,$query);
        //$toReturn .= "<span>$query</span>";
        if($doQuery){
            $success++;
        }
    }else{
        $query = "UPDATE products SET PRODUCTNAME = '$productname',DESCRIPTION='$description',URL='$url',IMGURL='$imgurl',IMGURL_ALTERNATIVE='$imgurl_alternative'
    ,PRICE_VAT='$price_vat',DELIVERY_DATE='$delivery_date',MANUFACTURER='$manufacturer',CATEGORYTEXT='$categorytext',ITEMGROUP_ID='$itemgroup_id',EAN='$ean',ACCESSORY='$accessory',HEUREKA_CPC='$heureka_cpc'
    WHERE ITEM_ID = '$item_id'";
//        echo 'UPDATE-'.$productname.'</br>';


        $doQuery = mysqli_query($con,$query);
        if($doQuery){
            $update++;
            //echo "UPDATED ".$item_id."<br/>";
        }else{
            $failed++;
            // echo "FAILED ".$item_id."<br/>";
        }
    }
endforeach;

echo $toReturn;
echo "Nových položek: ".$new."<br/>";
echo "Aktualizovaných/Nezměněných položek: ".$update."<br/>";
echo "Nektualizovaných položek: ".$failed."<br/>";

?>
</body>
</html>