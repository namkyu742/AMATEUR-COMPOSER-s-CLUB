<?php
    session_start();
    ob_start();
    if(!isset($_SESSION['id'])){
        if(isset($_COOKIE['id']) && isset($_COOKIE['email'])){
            $userid = $_COOKIE['id'];
            $_SESSION['id'] = $userid;
        }
    }
    // 클라이언트 쪽에 쿠키가 남아있다면 세션에 저장해서 사용하도록 함
?>
