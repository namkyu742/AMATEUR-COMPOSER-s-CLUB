<?php
    require_once("session.php");
?>

<!DOCTYPE html>
<html>

<head>
    <title>게시글 삭제</title>
    <meta charset="utf-8" />
</head>

<body>
    <?php
        require_once('Database_Connection.php');
        // 로그인 정보 확인
        if(!isset($_SESSION['id'])){
            echo "<script>alert('로그인 후 이용해주십시오.');</script>";
            echo ("<script>location.href='main_page.php'</script>");
        }
        
        if(strcmp($_COOKIE['email'], "admin")){
            //관리자인지 확인
            if ($_GET['userid']!=$_SESSION['id']){    
                // 작성자 본인인지 확인
                echo "<script>alert('삭제 권한이 없습니다.');</script>";
                exit ("<script>location.href='main_page.php'</script>");
            }
        }

        $dbc = mysqli_connect($host, $user, $pass, $dbname) or die("Error Connecting to MySQL Server.");
        // GET방식으로 전달받은 데이터 php변수에 저장
        $postid = $_GET['postid'];
        mysqli_query($dbc, 'set names utf8');
        // 데이터베이스에서 postid가 일치하는 투플 삭제
        $query = "DELETE FROM post WHERE postid = $postid";
        $result = mysqli_query($dbc, $query) or die ("Error Querying database.");

        mysqli_close($dbc);
        echo ("<script>location.href='main_page.php'</script>");
    ?>
</body>

</html>