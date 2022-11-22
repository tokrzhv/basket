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
require_once ("param.php");
if (!isset($_POST['send']))
{
    ?>
    <form action="add_info.php" method="post" enctype="multipart/form-data" >
        <input type="text" name="model" placeholder="add model"><br>
        <input type="number" name="price" placeholder="add price"><br>
        <select name="count">
            <option>1</option>
            <option>2</option>
            <option>3</option>
        </select><br>
        <input type="color" name="color" placeholder="add color"><br>
        <input type="number" name="datavup" placeholder="add data"><br>
        <input type="file" name="photo" placeholder="add photo"><br>
        <select name="id_prov">
            <?php
            $queryP="Select id, name, logo from proizv";
            $rezP=mysqli_query($dbc, $queryP) or die ("errorp");
            while ($nextP=mysqli_fetch_array($rezP)){
                $id_p=$nextP['id'];
                $name=$nextP['name'];
                $logo=$nextP['logo'];
                echo "<option value='".$id_p. "'>$name <img src='images/$logo' width='100px'></option>";
            }
            ?>
        </select>
        <input type="text" name="haract" placeholder="add haracter"><br>
        <input type="submit" name="send">
    </form>
<?php
}else if(isset($_POST['send']) && !empty($_POST['model']) && !empty($_POST['price']) && !empty($_POST['count'])  && !empty($_POST['datavup'])){
    $model=$_POST['model'];
    $price=$_POST['price'];
    $count=$_POST['count'];
    $color=$_POST['color'];
    $datav=$_POST['datavup'];
    $id_p=$_POST['id_prov'];
    $har=$_POST['haract'];

    if($_FILES['photo']['error']==0){
        $filename_tmp=$_FILES['photo']['tmp_name'];
        $filename=time().$_FILES['photo']['name'];
        move_uploaded_file($filename_tmp, "images/$filename");
        $query="Insert into towar(model, price, count, color, datavup, photo, id_prov, haract) VALUE ('$model', '$price', '$count', '$color', '$datav', '$filename', '$id_p', '$har')";
    }else {
        $query="Insert into towar(model, price, count, color, datavup, id_prov, haract) VALUE ('$model', '$price', '$count'. '$color', '$datav', '$id_p', '$har')";
    }
    $rez=mysqli_query($dbc, $query) or die ("error");
        echo "Your Tovar add success<br>";
        echo "<a href='add_info.php'>Add New Tovar </a>";
}else {
    echo "Не достаточно данных для добавления ";
    mysqli_close($dbc);
}
?>

</body>
</html>