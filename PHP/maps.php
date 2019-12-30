<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>位置表示システム</title>
</head>
<body>

<h1 align="center">「郵便番号⇒位置」表示システム</h1>

<?php
   //入力された郵便番号を変数にセットする
   if(isset($_GET[''])&&isset($_GET['sanketa'])) {
      $zn=$_GET['sanketa'].$_GET['yonketa'];
   } else {
      $zn="2750016";
      $_GET['sanketa']="275";
      $_GET['yonketa']="0016";
   }
?>

<!-- form文で郵便番号を入力する -->
<form method="GET" action="maps.php">
   郵便番号： <input type="text" name="sanketa" size="2" value=<?php echo $_GET['sanketa']; ?>>-<input type="text" name="yonketa" size="4" value=<?php echo $_GET['yonketa']; ?>>
   <input type="submit" value="表示する">
</form>

<script type="text/javascript" charset="utf-8" src="https://map.yahooapis.jp/js/V1/jsapi?appid=dj00aiZpPU1majZ6dkNGSTZkViZzPWNvbnN1bWVyc2VjcmV0Jng9OTk-&&output=json"></script>
<script type="text/javascript">
window.onload = function(){
   var ymap = new Y.Map("map", {
   configure : {
       doubleClickZoom : true,
       scrollWheelZoom : true,
       singleClickPan : true,
   }
});
   var Slider = new Y.SliderZoomControlVertical();
   var Scale = new Y.ScaleControl();
   var lat = 35.68947530937599;
   var lng = 140.02119831775047;
   ymap.addControl(Slider);
   ymap.addControl(Scale);
   ymap.drawMap(new Y.LatLng(lat, lng), 17, Y.LayerSetId.NORMAL);
}

/*
var map;
window.onload = function() {
    map = new Y.Map("map");
    map.drawMap(new Y.LatLng(35.680840,139.767009), 10, Y.LayerSetId.NORMAL);

    //クリックイベントを設定
    map.bind("click", function(latlng){onClicked(latlng);});
}

//クリックイベントを定義
function onClicked(latlng){
    document.getElementById("lat").value = latlng.lat();
    document.getElementById("lng").value = latlng.lng();
}
*/

</script>

<?php
   //郵便番号API用リクエストURLを生成する
   $req = "http://zip.cgis.biz/xml/zip.php?zn=".$zn;
   //郵便番号から緯度経度を割り出すAPI用リクエストURLを生成する
   $latlng = "http://geoapi.heartrails.com/api/xml?method=searchByPostal&postal=".$zn;
   //郵便番号APIを用いてXMLデータをダウンロードする
   $xml= simplexml_load_file($req);
   //郵便番号から緯度経度を割り出すAPIを用いてXMLデータをダウンロードする
   $xml2= simplexml_load_file($latlng);

   /*print_r($xml2);
   echo "<br><br>\n";*/

   //XMLデータから目的とするデータを抽出する
   $state_kana = (string)$xml->ADDRESS_value->value[0]->attributes()->state_kana; 
   $city_kana = (string)$xml->ADDRESS_value->value[1]->attributes()->city_kana; 
   $address_kana = (string)$xml->ADDRESS_value->value[2]->attributes()->address_kana; 
   $company_kana = (string)$xml->ADDRESS_value->value[3]->attributes()->company_kana; 
   $state = (string)$xml->ADDRESS_value->value[4]->attributes()->state; 
   $city = (string)$xml->ADDRESS_value->value[5]->attributes()->city;
   $address = (string)$xml->ADDRESS_value->value[6]->attributes()->address;
   $company = (string)$xml->ADDRESS_value->value[7]->attributes()->company;

   //XML2から緯度経度を抽出する。
   $lat = (double)$xml2->location[0]->x;
   $lng = (double)$xml2->location[0]->y;
   print_r($lat);
   echo "<br><br>\n";
   print_r($lng);
   echo "<br><br>\n";

   //抽出したデータを表形式に整理して表示する
   if(isset($state)){
      echo "<table>\n";
      echo "<tr><td></td><td>";
      if($state_kana<>"none"){ echo $state_kana;}
      echo "</td><td>";
      if($city_kana<>"none") { echo $city_kana; }
      echo "</td><td>";
      if($address_kana<>"none"){ echo $address_kana; }
      echo "</td>";
      if($company_kana<>"none"){ echo "<td> $company_kana </td>"; }
      echo "</tr>\n";
      echo "<tr><td>住所</td><td> $state </td><td> $city </td><td> $address </td>";
      if($company<>"none"){ echo "<td> $company </td>"; }
      echo "</tr>\n";
      echo "</table>\n";
   } else {
      echo "該当するデータがありませんでした．<br>";
   }
?>
<div id="map" style="width:600px; height:450px"></div>
</body>
</html>
