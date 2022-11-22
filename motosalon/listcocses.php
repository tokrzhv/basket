<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="admin/style.css" rel="stylesheet" >
</head>
<body>
<?php
require_once ("admin/param.php");
if (isset($_POST['send'])&& isset($_POST['sel']))
{
$zapis=$_POST['sel'];
echo "$zapis";

setcookie("zapis", "$zapis",time()+60*60*24*30*3);

} else if (!isset($_POST['sel']) && isset($_COOKIE['zapis']))
{
 $zapis=$_COOKIE['zapis'];
}
else
{
    $zapis=4;
}

$queryz="select id from moto ";
$resultz=mysqli_query($dbc, $queryz) or die ("error");
$count_rows=mysqli_num_rows($resultz);
$count_page=ceil($count_rows/$zapis);

if (isset($_GET['page']))
{
$activ_page=$_GET['page'];
} else
{
$activ_page=1;
}
$scip=($activ_page-1)/$zapis;


$query="select id, namme, dv, photo, price, id_marca from moto limit $scip, $zapis";
$rez=mysqli_query($dbc, $query) or die ("error запрос");
echo "<table> <tr>
<th>№</th>
<th>модель</th>
<th>фото</th>
<th>подробнее</th></tr>";
$num=1;
while($next=mysqli_fetch_array($rez)) {
    $id = $next['id'];
    //$idM=$next['id_marca'];
    $namme = $next['namme'];
    $photo = $next['photo'];
    if (empty($photo)) {
        $photo = "nophpto.jpg";
    }
    echo "<tr>
<td>$num</td>
<td>$namme</td>
<td><img src='images/" . $photo . "' width=100% height=110px></td>
<td><a href='info.php?ida=" . $id . "'>подробнее</a></td>
</tr>";
    $num++;
}
echo "</table><br><hr>";
echo "<table ><tr>";
if ($activ_page=1)
{
    echo "<td bgcolor='#9acd32'> Первая </td>";
}else {
    echo "<td> <a href='out.php?page=1'> Первая </a></td>";
    echo "<td> <a href='out.php?page=".($activ_page-1)."'><img src='images/images.png' width=100%></a></td>";
}
for ($i=1; $i<=$count_page; $i++ )
{
    if ($i==$activ_page){
        echo "<td bgcolor='#9acd32'>...</td>";
    }
    else {
        echo "<td><a href='out.php?page=".$i."'>$i</a></td>";
    }
}
if ($activ_page==$count_page)
{
    echo "<td bgcolor='#9acd32'> Последняя </td>";
}
else {
    echo "<td><a href='out.php?page=".($count_page)."'> Последняя</td>";
}
echo "</tr></table>";
mysqli_close($dbc);
?>
<hr>
<form method="post" action="listcocses.php">
    <select name="sel">
        <?php
               if ($zapis==3) {
                   echo "<option>3</option>";
                   echo "<option >5</option>";
                   echo "<option >10</option>";
               }
               else if ($zapis==5)
                {
                    echo "<option>5</option>";
                    echo "<option >3</option>";
                    echo "<option >10</option>";
                }
                else if ($zapis==10)
                {
                    echo "<option>10</option>";
                    echo "<option >3</option>";
                    echo "<option >5</option>";
                } else
                {
                    echo "<option>3</option>";
                    echo "<option >5</option>";
                    echo "<option >10</option>";
                }
?>
    </select>
    <input type="submit" name="send" value="ok">
</form>
</body>
</html>