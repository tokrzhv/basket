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
$query="SELECT fio, phone, email, adres, prem, model, price, idk, count,  photo, haract, data_zakaza from klient 
INNER JOIN relation on klient.id = relation.idk 
INNER JOIN towar on relation.idt =  towar.id 
WHERE status = 0 ORDER BY relation.idk DESC, data_zakaza desc";
$rez=mysqli_query($dbc, $query) or die ("errorkl");
echo"<table border='1px'>";
$num=1;
$totalsum=0;
$stroka=1;// перем показ кол товара у 1 покупателя ( >=1 )
$smena=0;//перемен контрол смену нового клиента
while ($next=mysqli_fetch_array($rez)){
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
    if ($idk!=$smena) {
        $stroka=1;
        $totalsum=0;
        $query1="Select idt from relation WHERE idk= $idk"; // узн сколько товаров у одного покупателя
        $rez1=mysqli_query($dbc, $query1) or die ("error1");
        $rows=mysqli_num_rows($rez1);
        echo "<tr style='border: lime; border-bottom-color: red; font-size: 30px'>
<th>№</th>
<th>fio</th>
<th>phone</th>
<th>email</th>
<th>adres</th>
<th>prem</th>
<th>DATA_ZAKAZA</th>
<th>Удалить</th>
<th>Выполнить</th></tr>";
        echo "<tr>
<td>$num</td>
<td>$fio</td>
<td>$phone</td>
<td>$email</td>
<td>$adres</td>
<td>$prem</td>
<td>$data</td>
<td><a href='delz.php?idk=".$idk."'>X</a></td>
<td><a href='runz.php?idk=".$idk."'> >>> </a></td></tr>";
        echo "
<tr>
<th>PHOTO</th>
<th>MODEL</th>
<th>PRICE</th>
<th>COUNT</th>
<th>STOIMOST</th>
<th colspan='2'>HARACT</th></tr>";
    $smena=$idk;
    }
    $totalsum+=$stoimost;
    echo "<tr>
<td><img src='../images/".$photo."' width='150px'></td>
<td>$model</td>
<td>$price</td>
<td>$count</td>
<td>$stoimost</td>
<td colspan='2'>$har</td></tr>";
    if ($stroka==$rows) {
        echo "<tr style='color: red; font-family: Comic Sans MS; font-size: 25px'>
<td colspan='6'>Общая стоимость:</td>
<td colspan='1'>$totalsum</td></tr>";
    }
    $stroka++;
    $num++;
    echo "";
}
echo "</table>";
?>
</body>
</html>