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
$zapis=4;

if(isset($_GET['idm']))
{
    $queryz="select id from moto WHERE id_marca=".$_GET['idm'];
}else {
    $queryz="select id from moto";
}
$rezultz=mysqli_query($dbc, $queryz) or die ("errorz");
$count_rows=mysqli_num_rows($rezultz);
$count_page=ceil($count_rows/$zapis);
if(isset($_GET['page']))
{
    $active_page=$_GET['page'];
}else {
    $active_page=1;
}
$scip=($active_page-1)*$zapis;


$querym="select id, namme from marca";
$rezultm=mysqli_query($dbc, $querym) or die ("errorm");

echo "<div class='ho'>";
while($nextm=mysqli_fetch_array($rezultm))
{
    $id_m=$nextm['id'];
    $namem=$nextm['namme'];
    echo "<a href='listalca_filtr.php?idm=".$id_m."'>$namem</a> |";
}
echo "<a href='out.php'>все</a></div>";


if (isset($_GET['idm']) && !empty($_GET['idm']))
{
    $id_m=$_GET['idm'];
    $query="select id, namme, comment, dv, photo, price, id_marca from moto WHERE id_marca=$id_m";
    $id_marca=$id_m;
}else {
    $query="select id, namme, comment, dv, photo, price, id_marca from moto limit $scip, $zapis";
}
$rezult=mysqli_query($dbc, $query) or die ("error");
echo "<table><tr>
<th>№</th>
<th>name</th>
<th>photo</th>
<th>...</th>
</tr>";
$num=1;
while($next=mysqli_fetch_array($rezult))
{
    $id=$next['id'];
    $namme=$next['namme'];
    $photo=$next['photo'];
    if(empty($photo))
    {
        $photo="nophpto.jpg";
    }
    echo "<tr>
<td>$num</td>
<td>$namme</td>
<td><img src='images/".$photo."' width='100%'> </td>
<td>...</td></tr>";
    $num++;
}
echo "</table><hr>";


echo "<table><tr>";
if ($active_page==1)
{
    echo "<td>Первая</td>";
    echo "<td><img src='images/images.png' width=100%></td>";
}else {
    if (isset($id_m))
    {
        echo "<td <a href='listalca_filtr.php?page=1'>Первая</a></td>";
        echo "<td> <a href='listalca_filtr.php?page=".($active_page-1)."&idm=".$id_m."'><img src='images/images.png' width=100%></a></td>";
    }else {
        echo "<td <a href='listalca_filtr.php?page=1'>Первая</a></td>";
        echo "<td> <a href='listalca_filtr.php?page=".($active_page-1)."'><img src='images/images.png' width=100%></a></td>";
    }
}
for($i=1; $i<=$count_page; $i++)
{
    if($i==$active_page)
    {
        echo "<td>...</td>";
    }else
    {
        if (isset($id_m))
        {
            echo "<td><a href='listalca_filtr.php?page=".$i."&idm=".$id_m."'>$i</a></td>";
        }else {
            echo "<td><a href='listalca_filtr.php?page=".$i."'>$i</a></td>";
        }
    }
}
if ($active_page==$count_pages)
{
    echo "<td bgcolor='#9acd32'><img src='images/download.jpg' width=100%></td>";
    echo "<td bgcolor='#9acd32'> Последняя </td>";
}else
{
    if (isset($id_m))
    {
        echo "<td> <a href='listalca_filtr.php?page=".($active_page+1)."&idm=".$id_m."'><img src='images/download.jpg' width=100% ></a></td>";
        echo "<td> <a href='listalca_filtr.php?page=".($count_pages)."&idm=".$id_m."'> Последняя </a></td>";
    }else {
        echo "<td> <a href='listalca_filtr.php?page=".($active_page+1)."'><img src='images/download.jpg' width=100% ></a></td>";
        echo "<td> <a href='listalca_filtr.php?page=".($count_pages)."'> Последняя </a></td>";
    }
}
echo "</table></tr>";
mysqli_close($dbc);
?>
</body>
</html>