<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
    if (!isset($_POST['send']))
    {
        ?>
    <form action="add_cad.php" method="post">
        <input type="text" name="marca" placeholder="добавить марку">
        <input type="submit" name="send" placeholder="добавить">
    </form>
<?php
    }else if (isset($_POST['send']) && !empty($_POST['marca']))
{
    $marca=$_POST['marca'];

    require_once("param.php");
    $query="Insert into marca (namme) values ('$marca')";
    
    $rez=mysqli_query($dbc, $query) or die ('error');

    echo "Марка вашего транспорта - $marca - добавлено <br>";
    echo "<a href='add_cad.php'> Добавить еще </a><br>";
}else {
        echo "Не достаточно данных для добавления ";
}
?>
</body>
</html>