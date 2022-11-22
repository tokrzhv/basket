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

</head>
<body>
<?php
require_once ("param.php");
if (isset($_SESSION['items']) && count($_SESSION['items'])>0){
    ////////////////////////
   // print_r($_POST);
    if (isset($_POST['send'])){
        for ($i=0; $i<count($_SESSION['items']); $i++){
            $nameElement="count".$_SESSION['items'][$i]['id'];
        //    echo "<br>$nameElement<br>";
            $_SESSION['items'][$i]['count']=$_POST[$nameElement];
        }
    }
    /////////////////////
    echo "<form action='order.php' method='post'>";
    echo "<table>
 <tr><th colspan='7'>КОРЗИНА</th></tr>
 <tr>
 <th>№</th>
 <th>Photo</th>
 <th>Model</th>
 <th>Price</th>
 <th>Count</th>
 <th>Стоимость</th>
 <th>X</th>
 </tr>";
    $num=1;
    $totalsum=0;
    foreach ($_SESSION['items'] as $tmp){
        $stoimost=$tmp['price']*$tmp['count'];
        $totalsum=$totalsum+$stoimost;

        if (empty($photo)) {
            $photo = "noo.jpq";
        }else {
            $photo=$tmp['photo'];
        }
$query="Select count from towar WHERE id=".$tmp['id'];
        $rez=mysqli_query($dbc, $query) or die ("error");
        $next=mysqli_fetch_array($rez);
        $count=$next['count'];
        echo "<tr>
<td>$num</td>
<td><img width='100px' src='images/".$tmp['photo']."'></td>
<td>".$tmp['model']."</td>
<td>".$tmp['price']."</td>

<td ><input type='number' min='1' max='".$count."'  name='count".$tmp['id']."' value='".$tmp['count']."'></td>

<td>$stoimost</td>
<td><a href='basket.php?id=".$tmp['id']."&mode=del&script=order'>X</a></td></tr>";
        $num++;
    }
    echo "<tr>
<td colspan='5'>Итого</td>
<td colspan='2'>$totalsum</td></tr>";
    echo "<tr>
<td colspan='3'><a href='basket.php?mode=clear'>Очистить</a></td>
<td colspan='4'><a href='order.php'>Заказать</a></td>
<tr><td colspan='7'><input type='submit' name='send'></td></tr>";

    echo "</table>";
    echo "</form>";
}
?>
</body>
</html>