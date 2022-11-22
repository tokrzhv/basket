<?php
session_start();
if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['mode']) && $_GET['mode']=="add") {//проверяем если сущ айди и режим работы корзины добавить
    $exist = false;//созд перемен сущест товар или нет , изначально товар не сущест
    if (!isset($_SESSION['items'])) {// если корзина не сущест
        $_SESSION['items'] = array();//то создаем корзину пустым масивом
    }
    for ($i = 0; $i < count($_SESSION['items']); $i++) {//если количество товаров в корз больше нуля то ищем тип товара по айди
        if ($_SESSION['items'][$i]['id'] == $_GET['id']) {//проверяем если в товара сущест айди получ по ссылке
            $_SESSION['items'][$i]['count']++;//увелич количест даного товара на 1
            $exist = true;//уст статус - товар сущест
            break;//прекращ работу цыкла так как товар найден
        }
    }
    // если данноготовара в корзине нет -- то нужно данный товар добавить
    if (!$exist) {//провер если товара не существ (статусная перемен осталась фозс) то вытаск инфо о товаре с базы данных и добав  данный тип товар в корзину
        require_once("param.php");
        $query = "Select photo, model, price from towar WHERE id=" . $_GET['id'];
        $rezult = mysqli_query($dbc, $query) or die ("error");
        $next = mysqli_fetch_array($rezult);
        $_SESSION['items'][] = array("id" => $_GET['id'], "photo" => $next['photo'], "model" => $next['model'], "price" => $next['price'], "count" => 1);
        //в корзину новым елем добав товар который является масивом полей содерж инфо о товаре
    }
}
//print_r($_SESSION['items']);
/////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_GET['mode']) && $_GET['mode']=="clear" && isset($_SESSION['items'])){
    unset($_SESSION['items']); //функ унсет разименовывает переменную уничтожает значение и саму переменную
    $_SESSION['items']=array();
}
if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['mode']) && $_GET['mode']=="del"){
    for ($i=0; $i<count($_SESSION['items']); $i++){
        if ($_SESSION['items'][$i]['id']){
            unset($_SESSION['items'][$i]);
            break;
        } //end if
    } // end for
    $items=array();
    foreach ($_SESSION['items'] as $tmp){
        if (!empty($tmp)){
            array_push($items, $tmp);
            //$items[]=$tmp;
        }
    }
    unset($_SESSION['items']);
    $_SESSION['items']=array();
    $_SESSION['items']=$items;
    unset($items);
} // end if del
if (isset($_GET['script']) && !empty($_GET['script'])){
    header("location: order.php");
}else{
    if (isset($_GET['page']) && !empty($_GET['page'])){
        $page=$_GET['page'];
        header("location: out_towar.php?page=$page");
    }else {
        header("location: out_towar.php");
    }
}
?>