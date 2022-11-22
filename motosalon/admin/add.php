<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">+
    <title>Document</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
 <?php
 require_once("param.php");
 if (!isset($_POST['send']))
 {
     ?>
 <form action="add.php" method="post" enctype="multipart/form-data" >
     <!-- Параметр  enctype="multipart/form-data" обезательный иначе файл формой передаватся не будет
      работает только с методом пост и значит что формой перед данные многими частями разных типов -->
     <input type="text"  name="namme" placeholder="добавить модель"><br>
     <input type="text" name="comment" placeholder="добавить коментарий"><br>
     <input type="date" name="dv" placeholder="добавить дату выпуска"><br>
     <input type="number" name="price" placeholder="добавить цену"><br>
     выберите марку <br>
     <select name="id_marca">
         <?php
         $queryM="Select id, namme from marca";
         $rezultM=mysqli_query($dbc, $queryM) or die ("error zapros");

         while ($nextM=mysqli_fetch_array($rezultM))
         {
             $id_m=$nextM['id'];
             $nammeM=$nextM['namme'];
             echo "<option value='".$id_m."'>$nammeM</option>";
         }
         ?>
     </select><br>
     выберите файл<br>
     <input type="file" name="photo"><br>
     <input type="submit" name="send" placeholder="добавить"><br>
 </form>
 <?php
 }else if (isset($_POST['send'])&& !empty($_POST['namme']) && !empty($_POST['comment']) && !empty($_POST['dv']) && !empty($_POST['price']) && !empty($_POST['id_marca']))
 {
     $namme=$_POST['namme'];
     $comment=$_POST['comment'];
     $dv=$_POST['dv'];
     $price=$_POST['price'];
     $id_marca=$_POST['id_marca'];
    /*
     * работа с фа*лами
     * файл попадает в супер глоб массив $_FILES имеет элем ['photo'] - где название элем получ с тэга формы
      <input type="file" name="photo"> который имеет 5 состояний
     * 1. $_FILES['photo']['type'] возвращает тип загружаемого файла Например: image/gif text/doc
     * 2. $_FILES['photo']['size'] - возвращ размер в мб загруж файла
     * 3. $_FILES['photo']['name'] -возвр название загруж файла как он назывался на копм клиента
     * 4. $_FILES['phpto']['tmp_name'] - возвр временное место располож и временое название файла на сервере
     * 5. $_FILES['photo']['error'] -возвр код ошибки если файл на сервер не загружен или вернет код ошибки 0 если файл загруж успешно
     */
    if ($_FILES['photo']['error']==0)
    {
        $filename_tmp=$_FILES['photo']['tmp_name'];
        $filename=time().$_FILES['photo']['name'];
        move_uploaded_file($filename_tmp, "../images/$filename");
        //ФУНК перетаск файл на хостинг сайта и имеет параметры 1. где файл взять и как он временно наз
        //                                                      2. куда положить и как назвать
        $query="Insert into moto(namme, comment, dv, price, id_marca, photo) VALUE ('$namme', '$comment', '$dv', '$price', '$id_marca', '$filename')";
    }else {
        $query="Insert into moto(namme, comment, dv, price, id_marca) VALUE ('$namme', '$comment', '$dv', '$price', '$id_marca')";
    }
     $rez=mysqli_query($dbc,$query) or die ("error");
     echo " ваше авто $namme добавлено<br>";
     echo "<a href='add.php'> Добавить еще </a><br>";
 }else {
     echo "Не достаточно данных для добавления ";
 }
 mysqli_close($dbc);
?>
</html>