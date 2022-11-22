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
$query="Select id, model, id_prov, photo from towar";
$result=mysqli_query($dbc, $query) or die ("error");

echo "<table><tr>
<th>№</th>
<th>Photo</th>
<th>Model</th>
<th>Proizv</th>
<th>update</th>
<th>delete</th>
</tr>";
$num=1;
while ($next=(mysqli_fetch_array($result)))
{
    $id=$next['id'];
    $model=$next['model'];
    $id_p=$next['id_prov'];
    $photo=$next['photo'];
    if (empty ($photo))
    {
        $photo="noo.jpg";
    }

    $guerym="select name from proizv WHERE id=$id_p";
    $resultM=mysqli_query($dbc, $guerym) or die ("error3");
    $nextm=mysqli_fetch_array($resultM);
    $id_p=$nextm['name'];

    echo "<tr>
<td>$num</td>
<td><img src='images/".$photo."' width='120px'></td>
<td>$model</td>
<td>$id_p</td>
<td><a href='update.php?id=".$id."'>update</a> </td>
<td><a href='delete.php?id=".$id."&model=".$model."&proizv=".$id_p."'>delete</a></td></tr>";
    $num++;
}
echo "</table>";
mysqli_close($dbc);
?>
</body>
</html>