<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
require_once ("../param.php");
$zapis=3;
$queryz="select idk from relation";
$rezultz=mysqli_query($dbc, $queryz) or die ("errorzz");
$count_rows=mysqli_num_rows($rezultz);
$count_pages= ceil($count_rows/$zapis);
if (isset($_GET['page']))
{
    $active_page=$_GET['page'];
}else
{
    $active_page=1;
}
$scip=($active_page-1)*$zapis;
$query="Select fio, phone, email, adres, prem, model, count, price, idk, photo, haract, data_zakaza from klient
 INNER JOIN relation on klient.id = relation.idk 
 INNER JOIN towar on relation.idt = towar.id WHERE status=1 ORDER by relation.idk DESC, data_zakaza DESC limit $scip, $zapis";
$rez=mysqli_query($dbc, $query) or die ("error");
echo "<table border='1'>";
$num=1;
$totalsum=0;
$stroka=1;
$smena=0;
while($next=mysqli_fetch_array($rez)){
    $idk=$next['idk'];
    $fio=$next['fio'];
    $phone=$next['phone'];
    $email=$next['email'];
    $adres=$next['adres'];
    $prem=$next['prem'];
    $model=$next['model'];
    $price=$next['price'];
    $count=$next['count'];
    $photo=$next['photo'];
    $har=$next['haract'];
    $data=$next['data_zakaza'];
    if (empty($photo)){
        $photo="noo.jpg";
    }
    $stoimost=$price*$count;
    if($idk!=$smena){
        $stroka=1;
        $totalsum=0;
        $query1="Select idt from relation WHERE idk=$idk";
        $rez1=mysqli_query($dbc, $query1) or die ("error1");
        $rows=mysqli_num_rows($rez1);

        echo "<tr style='border: lime; border-bottom-color: red; font-size: 30px'>
    <th>№</th>
    <th>fio</th>
    <th>phone</th>
    <th>email</th>
    <th>adres</th>
    <th>prem</th>
    <th>data_zakaza</th>
    <th>Вернуть</th></tr>";
        echo "<tr>
<td>$num</td>
<td>$fio</td>
<td>$phone</td>
<td>$email</td>
<td>$adres</td>
<td>$prem</td>
<td>$data</td>
<td><a href='run_arx.php?idk=".$idk."'> >>> </a></td>
</tr>";
        echo "<tr>
    <th>PHOTO</th>
    <th>MODEL</th>
    <th>Price</th>
    <th>Count</th>
    <th>Stoimost</th>
    <th>Haract</th></tr>";
        $smena=$idk;
    }
    $totalsum+=$stoimost;
    echo "<tr>
<td><img src='../images/".$photo."' width='150px'></td>
<td>$model</td>
<td>$price</td>
<td>$count</td>
<td>$stoimost</td>
<td>$har</td></tr>";
    if ($stroka==$rows){
        echo "<tr style='color: red; font-family: Comic Sans MS; font-size: 25px'>
<td colspan='6'>Общaя стоимость:</td>
<td colspan='2'>$totalsum</td>
</tr>";
    }
    $stroka++;
    $num++;
}

echo "</table>";
echo "<table ><tr>";
if ($active_page==1)
{
    echo "<td bgcolor='#9acd32'> Первая </td>";
    echo "<td bgcolor='#9acd32'><img src='../images/images.png' width=100px></td>";
}else
{
    echo "<td> <a href='zakaz_listal.php?page=1'> Первая </a></td>";
    echo "<td> <a href='zakaz_listal.php?page=".($active_page-1)."'><img src='../images/images.png' width=100px></a></td>";
}
for ($i=1; $i<=$count_pages; $i++)
{
    if ($i==$active_page){
        echo "<td bgcolor='#9acd32'>...</td>";
    }
    else {
        echo "<td><a href='zakaz_listal.php?page=".$i."'>$i</a></td>";
    }
}
echo '</hr>';
if ($active_page==$count_pages)
{
    echo "<td bgcolor='#9acd32'><img src='../images/download.jpg' width=100px></td>";
    echo "<td bgcolor='#9acd32'> Последняя </td>";
}
else
{
    echo "<td> <a href='zakaz_listal.php?page=".($active_page+1)."'><img src='../images/download.jpg' width=100px ></a></td>";
    echo "<td> <a href='zakaz_listal.php?page=".($count_pages)."'> Последняя </a></td>";
}
echo "</tr></table>";
mysqli_close($dbc);
?>
</body>
</html>