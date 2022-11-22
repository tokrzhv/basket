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
$query="Select id, namme, photo from moto";
$result=mysqli_query($dbc, $query) or die ("error");

    echo "<table><tr>
<th>№</th>
<th>Photo</th>
<th>Model</th>
<th>update</th>
<th>delete</th>
</tr>";
    $num=1;
    while ($next=(mysqli_fetch_array($result)))
    {
        $id=$next['id'];
        $namme=$next['namme'];
        $photo=$next['photo'];
        if (empty ($photo))
        {
            $photo="nophpto.jpg";
        }
        echo "<tr>
<td>$num</td>
<td><img src='../images/".$photo."' width='120px'></td>
<td>$namme</td>
<td><a href='update_moto.php?id=".$id."'>update</a> </td>
<td><a href='del_moto.php?id=".$id."&namme=".$namme."'>delete</a></td></tr>";
        $num++;
    }
    echo "</table>";
    mysqli_close($dbc);
?>
</body>
</html>