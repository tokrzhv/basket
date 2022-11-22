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
if(isset($_GET['sort']))
{
    $sort=$_GET['sort'];
}
switch ($sort){
    case"asc":
        $sort="desc";
        break;
    case"decs":
        $sort="asc";
        break;
    default:
        $sort="asc";
        break;
}
$query="Select id, namme, comment, dv, photo, price, id_marca from moto ORDER BY price $sort ";
//запрос выбер с бд данные где опер ордер бай значит сортировать по названию поля и примен оператор аск по возвраст иlи деск по убыванию
$rez=mysqli_query($dbc, $query) or die ("error");
echo "<table><tr>
<th>№</th>
<th>model</th>
<th>comment</th>
<th>dv</th>;
<th>photo</th>
<th><a href='sortirovka.php?sort=".$sort."'>price</a></th>";
$num=1;
while($next=mysqli_fetch_array($rez))
{
    $id=$next['id'];
    $namme=$next['namme'];
    $comment=$next['comment'];
    $dv=$next['dv'];
    $photo=$next['photo'];
    if(empty($photo))
    {
         $photo="nophpto.jpg";
    }
    $price=$next['price'];
    $id_marca=$next['id_marca'];
    echo "<tr><td>$num</td>
<td>$namme</td>
<td>$comment</td>
<td>$dv</td>
<td><img src='images/".$photo."' width='100px'> </td>
<td>$price</td></tr>";
    $num++;
}
echo "</table>";
?>


</body>
</html>