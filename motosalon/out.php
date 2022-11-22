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
$zapis=4;                                      //перем хранит колич записей показ на одной стр
$queryz="select id from moto";                //запрос выбез наийменш поле колорое гарант есть в каждой записи
$rezultz=mysqli_query($dbc, $queryz) or die ("errorzz");
$count_rows=mysqli_num_rows($rezultz);      //фун нум\ровс возвр количество строк в результате запроса селект
$count_pages= ceil($count_rows/$zapis);
                                          // в результ деления строк всего на колич записей на одной стр узнаем общее кол страниц
                                         // функ ceil округляет  в болльшею сторону
                                        // round  к ближайшему целому**
                                       //floor к меньшему
                                      //echo $count_pages;
                                     //пров на какую стр переходит пользов и делаем ее активной
if (isset($_GET['page']))          //ссли сущ елем паже то польз нажал ссылку и выполняет перхожд на стр
{
    $active_page=$_GET['page'];
}else                           // иначе если ссылка не нажата покаж 1 стр
{
    $active_page=1;
}
$scip=($active_page-1)*$zapis; //формул выч колич записей которые нужно пропустить перед поазом нужных
                              // от актив стр - 1 получ колич предыдущих стр * на записи на 1 стр получ колич записей котор нудно пропуск


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$query="select id, namme, dv, photo, price, id_marca from moto  limit $scip,$zapis";
//опер лимит послед в запросе и имеет два параметра
// : ск пропустить , ск показать
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