<?php
require_once ("../param.php");
if (isset($_GET['idk']) && !empty($_GET['idk'])){
    $query="UPDATE relation SET status = 0 WHERE idk=".$_GET['idk'];
    $rez=mysqli_query($dbc, $query) or die( "error");
    $query1="Select idt, kolvo from relation WHERE idk=".$_GET['idk'];
    $rez1=mysqli_query($dbc, $query) or die ("erro1");
    while($next1=mysqli_fetch_array($rez1)){
        $query2="Update towar set count =count + ".$next1['kolvo']." WHERE id =".$next1['idt'];
        $rez=mysqli_query($dbc, $query2) or die ("error2");
    }
}
header("location:zakaz.php");
?>