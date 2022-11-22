<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="style.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>

<?php

if (!empty($_GET['id']))
{
    $id=$_GET['id'];
    require_once ("param.php");
    $query="Select namme, comment, dv, photo, price, id_marca from moto WHERE id=$id";
    $result=mysqli_query($dbc, $query) or die ("error");
    $next=mysqli_fetch_array($result);
    $namme=$next['namme'];
    $comment=$next['comment'];
    $dv=$next['dv'];
    $photo=$next['photo'];
    $price=$next['price'];
    $id_marca=$next['id_marca'];

    ?>
<form action="update_moto.php" method="post" enctype="multipart/form-data">
    <input type="text" name="namme" value="<?=$namme?>"><br>
    <input type="text" name="comment" value="<?=$comment?>"><br>
    <input type="date" name="dv" value="<?=$dv?>"><br>

    <input type="file" name="pho"><br>
    <?php
    echo "<table><tr><td><img src='../images/".$photo."' width='120px'></td></tr></table>";
    ?>

    <input type="number" name="price" value="<?=$price?>"><br>
    измените марку <br>
    <select name="id_marca">
        <?php
        $queryM="Select id, namme from marca";
        $resultM=mysqli_query($dbc, $queryM) or die ("error3");

        while ($nextM=mysqli_fetch_array($resultM)) {
            $idm = $nextM['id'];
            $nammeM = $nextM['namme'];
            if ($id_marca == $idm) {
                echo "<option selected value='" . $idm . "'> $nammeM</option>";
            } else {
                echo "<option value='" . $idm . "'>$nammeM</option>";
            }
        }
        ?>
    </select><br>
    <input type="hidden" name="id" value="<?=$id?>"><br>
    <input type="submit" name="send" value="send"><br>
</form>
    <?

} if (isset($_POST['send']) && !empty($_POST['id']) && !empty($_POST['namme']) && !empty($_POST['comment']) & !empty($_POST['dv'])&& !empty($_POST['price']) && !empty($_POST['id_marca']))
{
    $id=$_POST['id'];
    $namme=$_POST['namme'];
    $comment=$_POST['comment'];
    $dv=$_POST['dv'];
    $pho=$_POST['pho'];
    $price=$_POST['price'];
    $id_marca=$_POST['id_marca'];

    require_once ("param.php");
    $query2="Select photo from moto WHERE id=$id";
    $result2=mysqli_query($dbc, $query2) or die ("error запрос/2");
    $next2=mysqli_fetch_array($result2);
    $photo=$next2['photo'];
    if (empty($pho)) {
        @unlink("../images/$photo");
    }
    if ($_FILES['pho']['error']==0)
    {
        $filename_tmp=$_FILES['pho']['tmp_name'];
        $filename=time().$_FILES['pho']['name'];
        move_uploaded_file($filename_tmp, "../images/$filename");
        //ФУНК перетаск файл на хостинг сайта и имеет параметры 1. где файл взять и как он временно наз
        //                                                      2. куда положить и как назвать
        $query="Insert into moto(namme, comment, dv,  photo, price, id_marca) VALUE ('$namme', '$comment', '$dv', '$filename', '$price', '$id_marca')";
    }
    else {
        $query="Insert into moto(namme, comment, dv, photo, price, id_marca) VALUE ('$namme', '$comment', '$dv', '$photo', '$price', '$id_marca')";
    }

    require_once ("param.php");
    $query="UPDATE moto SET namme='$namme', comment='$comment', dv='$dv', photo='$filename', price='$price', id_marca='$id_marca' WHERE id=$id";
    //if (!empty($photo)) {
     //   @unlink("../images/$photo");
   // }
    mysqli_query($dbc, $query) or die ("error запрос");
    echo "Данные успешно добавлены";
    mysqli_close($dbc);
} else {
    echo "Редактирование не возможно";
    echo "<a href='index_items.php'>Попробуйте еще раз</a>";
}
?>
</body>
</html>0