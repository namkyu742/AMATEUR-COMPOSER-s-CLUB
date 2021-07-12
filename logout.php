<?php
    session_start();
    ob_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>로그아웃 결과</title>
    <meta charset="utf-8" />
</head>

<body>
    <?php
        require_once('Database_Connection.php');

        if (!isset($_SESSION['id'])){        // 로그인이 되어있는 상태가 아니라면
            echo "<script>alert('로그인 상태가 아닙니다.');</script>";
            echo "<script>javascript:history.go(-1)</script>";
        }

        // 세션 변수를 초기화 하면서 삭제함
        $_SESSION = array();

        if(isset($_COOKIE[session_name()])){
            setcookie(session_name(), '', time() - (60*60));
            // 쿠키가 세션 네임을 가지고 있을 경우
            // 세션 네임에 값을 아무것도 주지 않고 현재보다 빠른 시간으로 줌(유효하지 않음)
            
            session_destroy();

            setcookie('id', '', time() - (60*60));
            setcookie('email', '', time() - (60*60));
            setcookie('nickname', '', time() - (60*60));

            echo ("<script>location.href='main_page.php'</script>");
        }

       
    ?>
</body>

</html>