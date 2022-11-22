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
    $query="Select id, namme from motosalon.marca";
    $result=mysqli_query($dbc, $query) or die ("error запрос");
    $next=mysqli_fetch_array($result);
    $id=$next['id'];
    $namme=$next['namme'];
    echo "<table><tr>
<th>№</th>
<th>model</th>
<th>update</th>
<th>delete</th></tr>";
    $num=1;
    while ($next=mysqli_fetch_array($result))
    {
        $id=$next['id'];
        $namme=$next['namme'];
        echo "<tr>
<td>$num</td>
<td>$namme</td>
<td><a href='update_marca.php?id=".$id."'>update</a> </td>
<td><a href='del_marca.php?id=".$id."&namme=".$namme."'>delete</a> </td></tr>";
        $num++;
    }
echo "</table>";
    mysqli_close($dbc);
?>
</body>
</html>