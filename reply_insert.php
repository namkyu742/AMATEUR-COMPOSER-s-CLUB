<?php
    require_once("session.php");
?>

<!DOCTYPE html>
<html>

<head>
    <title>댓글 등록 결과</title>
    <meta charset="utf-8" />
</head>

<body>
    <?php
        require_once('Database_Connection.php');
        // 로그인 확인
        if(!isset($_SESSION['id'])){
            echo "<script>alert('로그인 후 이용해주십시오.');</script>";
            echo ("<script>location.href='main_page.php'</script>");
        }
        // 입력 확인
        if (empty($_POST['memo'])){
            exit('<a href="javascript:history.go(-1)">입력 폼을 채워주세요.</a></body></html');
        }
        
        $dbc = mysqli_connect($host, $user, $pass, $dbname) or die("Error Connecting to MySQL Server.");
        // POST방식으로 전달받은 데이터 php변수에 저장
        $postid = mysqli_real_escape_string($dbc, trim($_POST['postid']));
        $id=$_SESSION['id'];
        $memo = mysqli_real_escape_string($dbc, trim($_POST['memo']));
        
        mysqli_query($dbc, 'set names utf8');
        // 데이터베이스 reply테이블에 값 추가
        $query = "INSERT INTO reply VALUES (null, $postid, $id, NOW(), '$memo')";
        $result = mysqli_query($dbc, $query) or die ("Error Querying database.");

        mysqli_close($dbc);
        echo ("<script>location.href='main_page.php'</script>");
    ?>
</body>

</html>