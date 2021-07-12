<?php
    require_once("session.php");
?>

<!DOCTYPE html>
<html>

<head>
    <title>댓글 수정</title>
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
        $id=$_SESSION['id'];    // session id 가져옴
        $replyid = mysqli_real_escape_string($dbc, trim($_POST['replyid']));
        $memo = mysqli_real_escape_string($dbc, trim($_POST['memo']));
        mysqli_query($dbc, 'set names utf8');
        // 데이터베이스에서 해당 replyid를 갖는 투플의 데이터 변경
        $query = "UPDATE reply SET memo = '$memo' WHERE replyid = '$replyid'";
        $result = mysqli_query($dbc, $query) or die ("Error Querying database.");

        mysqli_close($dbc);
        echo ("<script>location.href='main_page.php'</script>");
    ?>
</body>

</html>