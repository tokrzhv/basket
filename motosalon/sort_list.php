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
if (isset($_GET['sort']))
{
    $sort=$_GET['sort'];
}
switch ($sort)
{
    case"asc":
        $sort="desc";
        break;
    case "desc":
        $sort="asc";
        break;
    default:
        $sort="asc";
        break;
}
$zapic=4;

if (isset($_GET['id']))
{
    $query="Select id from moto WHERE id_marca=".$_GET['id'];
}else {
    $query="Select id from moto";
}

//$query="Select id from moto";
$rez=mysqli_query($dbc, $query) or die ("error");
$count_rows=mysqli_num_rows($rez);
$count_page=ceil($count_rows/$zapic);
if (isset($_GET['page']))
{
    $activ_page=$_GET['page'];
}else{
    $activ_page=1;
}
$scip=($activ_page-1)*$zapic;


$querym="Select id, namme from marca";
$rezm=mysqli_query($dbc, $querym) or die ("error");
echo "<div class='ho'>";
while ($nextp=mysqli_fetch_array($rezm))
{
    $id=$nextp['id'];
    $nam_e=$nextp['namme'];
if ($sort="asc"){
    if (isset($activ_page ))
    {
        echo "<a href='sort_list.php?id=".$id."&sort=desc&activp=".$activ_page."'>$nam_e</a> |";
    }else {
        echo "<a href='sort_list.php?id=".$id."&sort=desc'>$nam_e</a> |";
    }
} else {
    if (isset($activ_page ))
    {
        echo "<a href='sort_list.php?id=".$id."&sort=asc&activp=".$activ_page."'>$nam_e</a> |";
    }else {
        echo "<a href='sort_list.php?id=".$id."&sort=asc'>$nam_e</a> |";
    }
}
}
echo"<a href='sort_list.php?sort=".$sort."'>все</a></div>";


if(isset($_GET['id']) && !empty($_GET['id']))
{
    $idm=$_GET['id'];
    $query="Select id, namme, comment, dv, photo, price from moto WHERE id_marca=$idm";
    $id_m=$idm;
}else
{
    $query="Select id, namme, comment, dv, photo, price from moto ORDER BY price $sort limit $scip, $zapic";
}



$rez=mysqli_query($dbc, $query) or die ("error");


echo "<table><tr>
<th>№</th>
<th>name</th>
<th>coment</th>
<th>dv</th>
<th>photo</th>";
if (isset($activ_page)){
    echo"<th><a href='sort_list.php?page=".$activ_page."&sort=".$sort."'>price</a></th>";
}

echo "</tr>";


$num=$scip+1;;
while ($next=mysqli_fetch_array($rez))
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
    echo "<tr><td>$num</td>
<td>$namme</td>
<td>$comment</td>
<td>$dv</td>
<td><img src='images/".$photo."' width='100px'></td>
<td>$price</td></tr>";
    $num++;
}
echo "</table>";


echo "<table><tr>";

if ($activ_page==1)
{
    echo "<td> << </td>";
}else
    {
        if ($sort=="asc")
{
    echo "<td><a href='sort_list.php?page=".($activ_page-1)."&sort=desc'> < </a> </td>";
}else {
            echo "<td><a href='sort_list.php?page=".($activ_page-1)."&sort=asc'> < </a> </td>";
        }
}


for ($i=1; $i<=$count_page; $i++)
{
    if ($i==$activ_page){
        echo "<td>...</td>";
    }else {
        if($sort=="asc"){
            echo "<td><a href='sort_list.php?page=".$i."&sort=desc'>$i</a> </td>";
        }else {
            echo "<td><a href='sort_list.php?page=".$i."&sort=asc'>$i</a></td>";
        }
        }

}
if ($activ_page==$count_page)
{
    echo "<td>Последняя</td>";
}else{
    if ($sort=="asc"){
        echo "<td><a href='sort_list.php?page=".($activ_page+1)."&sort=desc'> > </a></td>";
        echo "<td><a href='sort_list.php?page=".($count_page)."&sotr=desc'> >> </a></td>";
    }else{
        echo "<td><a href='sort_list.php?page=".($activ_page+1)."&sort=asc'> > </a></td>";
        echo "<td><a href='sort_list.php?page=".($count_page)."&sort=asc'> >> </a></td>";
    }
}
echo "</table>";
?>

</body>
</html>