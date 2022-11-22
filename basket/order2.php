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
if (!isset($_POST['send'])){
    ?>
<form method="post" action="order2.php">
    <input type="text" name="name" placeholder="ФИО">
    <input type="number" name="phone" placeholder="add phone">
    <input type="email" name="email" placeholder="add email">
    <input type="text" name="adres" placeholder="add adres">
    <textarea name="prem" placeholder="add prem"></textarea>
    <input type="submit" name="send">
</form>
<?php
}else if (isset($_POST['send']) && !empty($_POST['name']) && !empty($_POST['phone'])){
    $namme=$_POST['name'];
    $phone=$_POST['phone'];
    $email=$_POST['email'];
    $adres=$_POST['adres'];
    $prem=$_POST['prem'];
    $query="Insert into korzina.klient(fio, phone, email, adres, prem )  VALUE ('$namme', '$phone', '$email', '$adres', '$prem')";
    $rez=mysqli_query($dbc, $query) or die ("error ");
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $idk=mysqli_insert_id($dbc);//функ возвращ айди только что добавл строки к бд, работает сразу после майскл куери которая передает
    // запрос инсерт инто и вохвращает значени  по идентефикатору подключеня
            foreach($_SESSION['items'] as $tmp){
                $queryk="Insert into korzina.relation (idk, idt, kolvo, data_zakaza) VALUE ($idk, '".$tmp['id']."', '".$tmp['count']."', now())";
                mysqli_query($dbc, $queryk) or die ("errork");
            }
    echo " Ваш заказ принят , с вами свяжется...";
    unset($_SESSION['items']);
    $_SESSION['items']=array();
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else {
    echo "Не достаточно данных для добавления";
}

echo "<table>
    <tr><th colspan='7'>КОРЗИНА</th></tr>
    <tr>
        <th>№</th>
        <th>Photo</th>
        <th>Model</th>
        <th>Price</th>
        <th>Count</th>
        <th>Стоимость</th>
    </tr>";
        $num=1;
        $totalsum=0;
foreach ($_SESSION['items'] as $tmp) {
$stoimost=$tmp['price']*$tmp['count'];
$totalsum=$totalsum+$stoimost;
if (empty($photo)){
    $photo="noo.jpg";
}else{
    $photo=$tmp['photo'];
}
    $query="Select id, model, photo, price, count from towar";
    $rez=mysqli_query($dbc, $query) or die ("error");
    $next=mysqli_fetch_array($rez);
    $count=$next['count'];
    echo "<tr>
<td>$num</td>
<td><img width='100px' src='images/".$tmp['photo']."'></td>
<td>".$tmp['model']."</td>
<td>".$tmp['price']."</td>
<td>".$tmp['count']."</td>
<td>$stoimost</td></tr>";
$num++;
}
echo "<tr>
<td colspan='5'>Итого</td>
<td colspan='2'>$totalsum</td></tr>";
echo "<tr>
<td colspan='6'>Заказать</td>";
echo "</table>";
mysqli_close($dbc);
?>
</body>
</html>