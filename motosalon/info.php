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
if (!empty($_GET['ida']))
{
    $id=$_GET['ida'];

    require_once ("admin/param.php");
    $guery="select id, namme, comment, dv, photo, price, id_marca from moto WHERE id=$id";
    $rez=mysqli_query($dbc, $guery) or die ("error ");
    $next=mysqli_fetch_array($rez);

    $id=$next['id'];
    $namme=$next['namme'];
    $comment=$next['comment'];
    $dv=$next['dv'];

    $photo=$next['photo'];

    if (empty($photo))
    {
        $photo="nophpto.jpg";
    }

    $price=$next['price'];

    $id_marca=$next['id_marca'];
    $guerym="select namme from marca WHERE id=$id_marca";
    $resultM=mysqli_query($dbc, $guerym) or die ("error3");
    $nextm=mysqli_fetch_array($resultM);
    $id_m=$nextm['namme'];

    echo "<table>
<tr>
<th>name</th>
<th>comment</th>
<th>dv</th>
<th>photo</th>
<th>price</th>
<th>marca</th></tr>";
    echo "<tr>
<td>$namme</td>
<td>$comment</td>
<td>$dv</td>
<td><img src='images/".$photo."' width='100%' height='130px'></td>
<td>$price</td>
<td>$id_m</td></tr>";
    mysqli_close($dbc);
}else {
    echo "Недостаточно данных для вывода";
}

?>
<hr>
<p><a href="out.php">back</a></p>
</body>
</html>