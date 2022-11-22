<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="admin/style.css" rel="stylesheet">
</head>
<body>
<?php
require_once ("admin/param.php");
$queryM="select id, namme from marca";
$rezultM=mysqli_query($dbc, $queryM) or die ("error");
echo "<div class='ho'>";
while($nextM=mysqli_fetch_array($rezultM))
{
    $id_m=$nextM['id'];
    $nameM=$nextM['namme'];
    echo "<a href='out_moto.php?idm=".$id_m."'>$nameM</a> |";

}
echo "<a href='out_moto.php'>Все</a></div>";

if (isset($_GET['idm']) && !empty($_GET['idm']))
{
    $id_marka=$_GET['idm'];
    $query="select id, namme, comment, dv, photo, price, id_marca from moto WHERE id_marca=$id_marka";
    $id_marca=$id_marka;
}else {
    $query="select id, namme, comment, dv, photo, price, id_marca from moto";
}




$rez=mysqli_query($dbc, $query) or die ("error");
echo "<table><tr>
<th>№</th>
<th>model</th>
<th>photo</th>
<th>подробнее</th></tr>";
$num=1;
while($next=mysqli_fetch_array($rez))
{
    $id=$next['id'];
    $namme=$next['namme'];
    $photo=$next['photo'];
    if (empty($photo))
    {
        $photo="nophpto.jpg";
    }
    echo "<tr>
<td>$num</td>
<td>$namme</td>
<td><img src='images/".$photo."' width=100% height=110px></td>
<td><a href='info.php?ida=".$id."'>подробнее</a></td>
</tr>";
    $num++;
}
echo "</table>";
?>

</body>
</html>