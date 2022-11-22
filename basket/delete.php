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
if (!empty($_GET['id']) && isset($_GET['model']) && isset($_GET['proizv']))
{
    $id=$_GET['id'];
    $model=$_GET['model'];
    $pro=$_GET['proizv']
    ?>
    <h1>удалить <?=$pro?><?=$model?></h1>
    <form action="delete.php" method="post">
        <h2>yes</h2>
        <input type="radio" name="del" checked value="yes">
        <h2>no</h2>
        <input type="radio" name="del" value="no">
        <input type="hidden" name="id" value="<?=$id?>"><br>
        <input type="submit" name="send" value="подтвердить">
    </form>
    <?php
} else if (isset($_POST['send']) && !empty($_POST['id']) && $_POST['del']=="yes")
{
    $id=$_POST['id'];
    require_once ("param.php");
    $query2="Select photo from korzina.towar WHERE id=$id";
    $result2=mysqli_query($dbc, $query2) or die ("error запрос/2");
    $next2=mysqli_fetch_array($result2);
    $photo=$next2['photo'];
    if (!empty($photo)) {
        @unlink("images/$photo");
    }
    require_once ("param.php");
    $query="DELETE FROM korzina.towar WHERE id=$id";
    mysqli_query($dbc, $query) or die ("error");
    echo "Данные успешно удалены!";
    mysqli_close($dbc);
}
else
{
    echo "Удаление отменено или невозможно";
    echo "<a href='index.php'>Попробуйте еще раз</a>";
}
?>
</body>
</html>