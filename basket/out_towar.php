<?php
session_start();
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
<?php
require_once ("param.php");

$zapis=3;
$query1="Select id from korzina.towar";
$rezult1=mysqli_query($dbc, $query1) or die ("error1");
$count_rows=mysqli_num_rows($rezult1);
$count_page= ceil($count_rows/$zapis);
if (isset($_GET['page'])){
    $activ_page=$_GET['page'];
}else {
    $activ_page=1;
}
$skip=($activ_page-1)*$zapis;
//////////////////////////////////////////////////////////////////////////////////////////
/*
$queryM="select id, name from korzina.proizv";
$rezultM=mysqli_query($dbc, $queryM) or die ("error");
echo "<div class='ho'>";
while($nextM=mysqli_fetch_array($rezultM))
{
    $id_m=$nextM['id'];
    $nameM=$nextM['name'];
    echo "<a href='out_towar.php?idm=".$id_m."'>$nameM</a> |";
}
echo "<a href='out_towar.php'>Все</a></div>";
*/

if (isset($_GET['idp']) && !empty($_GET['idp']))
{
    $id_p=$_GET['idp'];
    $query="select id, model, price, count, color, datavup, photo, price, id_prov, haract from towar WHERE id_prov=$id_p limit $skip, $zapis";
    $id_marca=$id_p;
}else {
    $query="select  id, model, price, count, color, datavup, photo, price, id_prov, haract  from towar limit $skip, $zapis ";
}
$rez=mysqli_query($dbc, $query) or die ("error");
echo "<table><tr>
<th>№</th>
<th>model</th>
<th>photo</th>
<th>count</th>
<th>price</th>
<th>подробнее</th></tr>";
$num=$skip+1;
while($next=mysqli_fetch_array($rez))
{
    $id=$next['id'];
    $model=$next['model'];
    $photo=$next['photo'];
    $count=$next['count'];
    $price=$next['price'];
    if (empty($photo))
    {
        $photo="nophpto.jpg";
    }
    echo "<tr>
<td>$num</td>
<td>$model</td>
<td><img src='images/".$photo."' width=100% height=110px></td>";

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////добавление товара
    if ($count==0){
    echo "<td>Нет на складе </td>";
    }else {
        echo"<td>$count <a href='basket.php?id=".$id."&mode=add&page=".$activ_page."'>Купить</a></td>";
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

echo "<td>$price</td>
<td><a href='info.php?ida=".$id."'>подробнее</a></td>
</tr>";
    $num++;
}
echo "</table>";
echo "<table><tr>";
if ($activ_page==1){
    echo "<td bgcolor='#9acd32'>Первая</td>";
}else{
    echo "<td><a href='out_towar.php?page=1'>Первая</td>";
    echo "<td><a href='out_towar.php?page".($activ_page-1)."'> < </a> </td>";
}
for ($i=1; $i<=$count_page; $i++){
    if ($i==$activ_page){
        echo "<td bgcolor='#9acd32'>...</td>";
    }else {
        echo "<td><a href='out_towar.php?page=".$i."'>$i</a></td>";
    }
}
if ($activ_page==$count_page)
{
    echo "<td bgcolor='#9acd32'> Последняя </td>";
}
else
{
    echo "<td> <a href='out_towar.php?page=".($activ_page+1)."'> > </a></td>";
    echo "<td> <a href='out_towar.php?page=".($count_page)."'> Последняя </a></td>";
}
echo "</tr></table><hr>";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_SESSION['items']) && count($_SESSION['items'])>0){
    echo "<table border='1'>
<tr><th colspan='7'>КОРЗИНА</th></tr>
<tr><th>№</th>
<th>Photo</th>
<th>Model</th>
<th>Price</th>
<th>Count</th>
<th>Стоимость</th>
<th> X </th>
</tr>";
    $num=1;
    $totalsum=0;
    foreach ($_SESSION['items'] as $tmp ){
        $stoimost=$tmp['price']*$tmp['count'];
        $totalsum=$totalsum+$stoimost;
        if (empty($tmp['photo'])){
            $tmp['photo']="noo.jpg";
        }
        echo "<tr>
<td>$num</td>
<td><img width='100px' src='images/".$tmp['photo']."'> </td>
<td>".$tmp['model']."</td>
<td>".$tmp['price']."</td>
<td>".$tmp['count']."</td>
<td>$stoimost</td>
<td><a href='basket.php?id=".$tmp['id']."&mode=del'> X </a> </td></tr>";
        $num++;

    }
    echo "<tr>
<td colspan='5'>Итого</td>
<td colspan='2'> = $totalsum</td>
</tr>";
    echo "<tr>
<td colspan='3'><a href='basket.php?mode=clear'>Очистить</a></td>
<td colspan='4'><a href='order.php'>Заказать</a> </td>
</tr>";
    echo "</table>";

}
mysqli_close($dbc);
?>
</body>
</html>