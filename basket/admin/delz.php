<?php
require_once ("../param.php");
if (isset($_GET['idk']) && !empty($_GET['idk'])){
    $query="Delete from  relation   WHERE idk=".$_GET['idk'];
    $rez=mysqli_query($dbc, $query) or die ("error");
    echo "Данные успешно удалены!";
    mysqli_close($dbc);
}
header("location: zakaz.php");
?>