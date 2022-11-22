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
    $query="Select id, model, price, count, color, datavup, photo, id_prov, haract  from towar WHERE id=$id";
    $result=mysqli_query($dbc, $query) or die ("error");
    $next=mysqli_fetch_array($result);

    $id=$next['id'];
    $model=$next['model'];
    $price=$next['price'];
    $count=$next['count'];
    $color=$next['color'];
    $data=$next['datavup'];
    $photo=$next['photo'];
    $idpp=$next['id_prov'];
    $har=$next['haract'];

    ?>
    <form action="update.php" method="post" enctype="multipart/form-data">
        <input type="text" name="model" value="<?=$model?>"><br>
        <input type="number" name="price" value="<?=$price?>"><br>
        <input type=number name="count" value="<?=$count?>"><br>
        <input type="color" name="color" value="<?=$color?>"><br>
        <input type="number" name="datavup" value="<?=$data?>"><br>
        <input type="file" name="pho"><br>
        <?php
        echo "<table><tr><td><img src='images/".$photo."' width='120px'></td></tr></table>";
        ?>

        измените марку <br>
        <select name="idpp">
           <?php
            $queryP="Select id, name from korzina.proizv";
            $resultP=mysqli_query($dbc, $queryP) or die ("error3");
            while ($nextP=mysqli_fetch_array($resultP)) {
                $idp = $nextP['id'];
                $namep = $nextP['name'];
                if ($idpp == $idp) {
                    echo "<option selected value='" . $idp . "'>$namep</option>";
                } else {
                    echo "<option value='" . $idp . "'>$namep</option>";
                }
            }
            ?>
        </select><br>
        <input type="text" name="haract" value="<?=$har?>"><br>
        <input type="hidden" name="id" value="<?=$id?>"><br>
        <input type="submit" name="send" value="send"><br>
    </form>
    <?
} else if(isset($_POST['send']) && !empty($_POST['model']) && !empty($_POST['price']) && !empty($_POST['count'])){
    $id=$_POST['id'];
    $model=$_POST['model'];
    $price=$_POST['price'];
    $count=$_POST['count'];
    $color=$_POST['color'];
    $datav=$_POST['data'];
    $pho=$_POST['photo'];
    $idpp=$_POST['idpp'];
    $har=$_POST['haract'];
    require_once ("param.php");
    $query2="Select photo from korzina.towar WHERE id=$id";
    $result2=mysqli_query($dbc, $query2) or die ("error запрос/2");
    $next2=mysqli_fetch_array($result2);
    $photo=$next2['photo'];
    if (empty($pho)) {
        @unlink("images/$photo");
    }
    if ($_FILES['pho']['error']==0)
    {
        $filename_tmp=$_FILES['pho']['tmp_name'];
        $filename=time().$_FILES['pho']['name'];
        move_uploaded_file($filename_tmp, "images/$filename");

        $query="Insert into korzina.towar(model, price, count, color, datavup, photo, id_prov, haract) VALUE ('$model', '$price', '$count', '$color', '$datav', '$filename', '$idpp', '$har')";
    }else {
        $query="Insert into korzina.towar(model, price, count, color, datavup, id_prov, haract) VALUE ('$model', '$price', '$count'. '$color', '$datav', '$idpp', '$har')";
    }
    require_once ("param.php");
    $query="UPDATE korzina.towar SET model='$model', price='$price', count='$count', color='$color', datavup='$datav', photo='$filename', id_prov='$idpp', haract='$har'  WHERE id=$id";
    $rez=mysqli_query($dbc, $query) or die ("error запрос");
    echo "Данные успешно добавлены";
    mysqli_close($dbc);
} else {
    echo "Редактирование не возможно";
    echo "<a href='index.php'>Попробуйте еще раз</a>";
}
?>
</body>
</html>