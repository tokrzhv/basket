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
if(!isset($_POST['send'])){
    ?>
    <form action="add_proizv.php" method="post" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="add name">
        <input type="file" name="logo" placeholder="add logo">
        <input type="submit" name="send">
    </form>
<?
}else if (isset($_POST['send']) && !empty($_POST['name'])){
    $name=$_POST['name'];
    require_once ("param.php");
    if ($_FILES['logo']['error']==0){
        $filename_tmp=$_FILES['logo']['tmp_name'];
        $filename=time().$_FILES['logo']['name'];
        move_uploaded_file($filename_tmp, "images/$filename");
        $query="Insert into korzina.proizv(name, logo) VALUE ('$name', '$filename')";
    }else{
        $query="Insert into korzina.proizv (name) VALUE ('$name')";
    }
    $rez=mysqli_query($dbc, $query) or die ("error rez");

    echo "Модель  - $name - добавлено <br>";
    echo "<a href='add_proizv.php'> Добавить еще </a><br>";
}else {
    echo "Не достаточно данных для добавления ";
    mysqli_close($dbc);
}
?>
</body>
</html>