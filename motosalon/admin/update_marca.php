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
if(!empty($_GET['id']))
{
         $id=$_GET['id'];
         require_once ("param.php");
         $query="Select namme from marca WHERE id=$id";
         $result=mysqli_query($dbc, $query) or die ("error запрос");
         $next=mysqli_fetch_array($result);
         $namme=$next['namme'];
         ?>

         <form action="update_marca.php" method="post">
             <input type="text" name="marca" value="<?=$namme?>">
             <input type="hidden" name="id" value="<?=$id?>">
             <input type="submit" name="send" value="Изменить данные">
         </form>
         <?
     }
        else if( isset($_POST['send']) && !empty($_POST['id']))
        {
            $id=$_POST['id'];
            $namme=$_POST['marca'];

            require_once("param.php");

            $query="UPDATE marca SET namme='$namme' WHERE id=$id";
            mysqli_query($dbc, $query) or die ("error");
            echo "Данные успешно изменены";
            mysqli_close($dbc);
        } else {
            echo "Редактирование не возможно";
            echo "<a href='index_marca.php'>Попробуйте еще раз</a>";
        }
?>
</body>
</html>