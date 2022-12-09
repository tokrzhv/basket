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
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$zapis=4;                                     
$queryz="select id from moto";               
$rezultz=mysqli_query($dbc, $queryz) or die ("errorzz");
$count_rows=mysqli_num_rows($rezultz);     
$count_pages= ceil($count_rows/$zapis);
                                          
if (isset($_GET['page']))          
{
    $active_page=$_GET['page'];
}else                      
{
    $active_page=1;
}
$scip=($active_page-1)*$zapis; 
                            
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$query="select id, namme, dv, photo, price, id_marca from moto  limit $scip,$zapis";

$rez=mysqli_query($dbc, $query) or die ("error запрос");
echo "<table> <tr>
<th>№</th>
<th>модель</th>
<th>фото</th>
<th>подробнее</th></tr>";
$num=1;
while($next=mysqli_fetch_array($rez))
{
    $id=$next['id'];
    //$idM=$next['id_marca'];
    $namme=$next['namme'];
    $photo=$next['photo'];
    if (empty($photo))
    {
        $photo="nophpto.jpg";
    }
    echo "<tr>
<td>$num</td>
<td>$namme</td>
<td><img src='images/".$photo."' width=100% height=110px></td>
<td><a href='info.php?ida=".$id."'>подробнее</a></td>
</tr>";
$num++;
}
echo "</table><br><hr>";
////////////////////////////////////////////////////////////////////////
echo "<table ><tr>";
if ($active_page==1)
{
    echo "<td bgcolor='#9acd32'> Первая </td>";
    echo "<td bgcolor='#9acd32'><img src='images/images.png' width=100%></td>";
}else
{
    echo "<td> <a href='out.php?page=1'> Первая </a></td>";
    echo "<td> <a href='out.php?page=".($active_page-1)."'><img src='images/images.png' width=100%></a></td>";
}
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
for ($i=1; $i<=$count_pages; $i++)
{
    if ($i==$active_page){
        echo "<td bgcolor='#9acd32'>...</td>";
    }
    else {
        echo "<td><a href='out.php?page=".$i."'>$i</a></td>";
    }
}
echo '</hr>';
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
if ($active_page==$count_pages)
{
    echo "<td bgcolor='#9acd32'><img src='images/download.jpg' width=100%></td>";
    echo "<td bgcolor='#9acd32'> Последняя </td>";
}
else
{
    echo "<td> <a href='out.php?page=".($active_page+1)."'><img src='images/download.jpg' width=100% ></a></td>";
    echo "<td> <a href='out.php?page=".($count_pages)."'> Последняя </a></td>";
}
echo "</tr></table>";
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
mysqli_close($dbc);
?>
</body>
</html>
