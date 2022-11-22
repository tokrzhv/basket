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
if (!empty($_GET['ida']))
{
    $id=$_GET['ida'];

    require_once ("param.php");
    $guery="select  id, model, price, count, color, datavup, photo, id_prov, haract  from towar WHERE id=$id";
    $rez=mysqli_query($dbc, $guery) or die ("error ");
    $next=mysqli_fetch_array($rez);

    $id=$next['id'];
    $model=$next['model'];
    $price=$next['price'];
    $count=$next['count'];
    $color=$next['color'];
    $data=$next['datavup'];

    $photo=$next['photo'];

    if (empty($photo))
    {
        $photo="noo.jpg";
    }
    $id_p=$next['id_prov'];
    $har=$next['haract'];

    $guerym="select name from proizv WHERE id=$id_p";
    $resultM=mysqli_query($dbc, $guerym) or die ("error3");
    $nextm=mysqli_fetch_array($resultM);
    $id_p=$nextm['name'];

    echo "<table>
<tr>
<th>model</th>
<th>price</th>
<th>count</th>
<th>color</th>
<th>data</th>
<th>photo</th>
<th>proizv</th>
<th>haract</th></tr>";
    echo "<tr>
<td>$model</td>
<td>$price</td>
<td>$count</td>
<td>$color</td>
<td>$data</td>
<td><img src='images/".$photo."' width='100%' height='130px'></td>
<td>$id_p</td>
<td>$har</td></tr>";
    mysqli_close($dbc);
}else {
    echo "Недостаточно данных для вывода";
}

?>
<hr>
<p><a href="out_towar.php">back</a></p>
</body>
</html>