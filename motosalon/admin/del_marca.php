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
<a href="index_marca.php">back to index</a>
<?php
        if (!empty($_GET['id']) && isset($_GET['namme']))
            {
                $id=$_GET['id'];
                $namme=$_GET['namme'];
                ?>

<h2>Вы действительно хотите удалить <?=$namme?></h2>
<form action="del_marca.php" method="post">
    <p>Да</p>
    <input type="radio" name="del" checked value="yes">
    <p>Нет</p>
    <input type="radio" name="del" value="no">
    <input type="hidden" name="id" value="<?=$id?>">
    <input type="submit" name="send" value="Подтвердить">
</form>
<?php
            }
            else if (isset($_POST['send']) && !empty($_POST['id']) && $_POST['del']=="yes")
            {
                $id=$_POST['id'];
                require_once ("param.php");
                $query="DELETE FROM motosalon.marca WHERE id=$id";
                mysqli_query($dbc, $query) or die ("error апрос");
                echo "Данные успешно удалены!";
                mysqli_close($dbc);
            }
            else {
                echo "Удаление отменено или невозможно";
                echo "<a href='index_marca.php'>Попробуйте еще раз</a>";
            }
?>
</body>
</html>