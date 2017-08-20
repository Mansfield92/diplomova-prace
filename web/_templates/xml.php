<section id="content">
    <div class="content__wrapper">
        <div class="content__headline">XML feed</div>
        <div class="content__inside">

<?php

function get_data($url) {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

//$feed = "http://obchod.bazenovachemie.cz/customDataFeed/A5E91A5F-89CA-40A4-A196-7604566DE787";
$feed = "http://img.obchod.bazenovachemie.cz/xmlfeeds/a5e91a5f-89ca-40a4-a196-7604566de787.xml";
$url = $feed;
$xml = simplexml_load_file($url);


$once = false;
$new = $success = $failed = $update = 0;

$failedMessages = array();

$x = true;
//print_r($xml);

foreach ($xml as $item):

    $productname = $item->PRODUCTNAME;
    $item_id = $item->ITEM_ID;
    $description = $item->DESCRIPTION;
    $description = str_replace("'", '"', $description);
    $url = $item->URL;
    $imgurl = $item->IMGURL;
    if (count($item->IMGURL_ALTERNATIVE) > 1) {
        $help = $item->IMGURL_ALTERNATIVE[0];
        for ($a = 1; $a < count($item->IMGURL_ALTERNATIVE); $a++) {
            $help .= "|" . $item->IMGURL_ALTERNATIVE[$a];
        }
        $imgurl_alternative = $help;
    }else{
        $imgurl_alternative = '';
    }
    $price_vat = $item->PRICE_VAT;
    $delivery_date = $item->DELIVERY_DATE;
    $manufacturer = $item->MANUFACTURER;
    $categorytext = $item->CATEGORYTEXT;
    $itemgroup_id = $item->ITEMGROUP_ID;
    $ean = $item->EAN;
    $accessory = $item->ACCESSORY;
    $heureka_cpc = $item->HEUREKA_CPC;

    if ($x) {
        $x = false;
    }

    $query = "SELECT * from products where ITEM_ID = '$item_id'";
    $exist = $con->query($query);
    $toReturn = "";
    if ($exist->num_rows == 0) {
        $new++;
        $query = "INSERT INTO `products` (`id_product`, `PRODUCTNAME`, `ITEM_ID`, `DESCRIPTION`, `URL`, `IMGURL`, `IMGURL_ALTERNATIVE`, `PRICE_VAT`, 
        `DELIVERY_DATE`, `MANUFACTURER`, `CATEGORYTEXT`, `ITEMGROUP_ID`, `EAN`, `ACCESSORY`, `HEUREKA_CPC`, `listed`, `baleni`, `davkovani`, `interval_`, `material`, `efficiency`, `alternative_description`)
        VALUES (NULL, '$productname', '$item_id', '$description', '$url', '$imgurl', '$imgurl_alternative', '$price_vat', '$delivery_date', '$manufacturer', '$categorytext', '$itemgroup_id', '$ean', '$accessory', '$heureka_cpc', '', '', '', '', '', NULL, '')";

        $doQuery = $con->query($query);
        //$toReturn .= "<span>$query</span>";
        if ($doQuery) {
            $success++;
        }
    } else {
        $query = "UPDATE products SET PRODUCTNAME = '$productname',DESCRIPTION='$description',URL='$url',IMGURL='$imgurl',IMGURL_ALTERNATIVE='$imgurl_alternative'
    ,PRICE_VAT='$price_vat',DELIVERY_DATE='$delivery_date',MANUFACTURER='$manufacturer',CATEGORYTEXT='$categorytext',ITEMGROUP_ID='$itemgroup_id',EAN='$ean',ACCESSORY='$accessory',HEUREKA_CPC='$heureka_cpc'
    WHERE ITEM_ID = '$item_id'";
//        echo 'UPDATE-'.$productname.'</br>';


        $doQuery = $con->query($query);
        if ($doQuery) {
            $update++;
        } else {
            $failedMessages[] = array($con->error, $query);

            $failed++;
        }
    }
endforeach;

echo $toReturn;
echo "Nových položek: " . $new . "<br/>";
echo "Aktualizovaných/Nezměněných položek: " . $update . "<br/>";
echo "Nektualizovaných položek: " . $failed . "<br/>";

echo '<p style="padding: 15px; "><h2>Obsah feedu</h2></p>';

echo '<pre><textarea style="border:none; width: 100%; min-height: 500px;">', (get_data($feed)), '</textarea></pre>';

if(count($failedMessages) > 0) print_r($failedMessages);

?>
        </div>
    </div>
</section>
