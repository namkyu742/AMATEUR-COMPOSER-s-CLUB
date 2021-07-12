<?php
    require_once("session.php");
?>

<!DOCTYPE html>
<html>

<head>
    <title>게시글 등록</title>
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
        // 입력 form 확인
        if (empty($_POST['title'])||empty($_POST['memo'])){
            echo "<script>alert('입력 폼을 채워주세요.');</script>";
            exit("<script>javascript:history.go(-1)</script>");
        }
        // 음원 인식 불가 시 전 페이지로 돌아감
        if(!isset($_FILES['music_file'])){
            exit('<a href="javascript:history.go(-1)">음원 업로드 에러가 발생했습니다.</a></body></html');
        }

        $dbc = mysqli_connect($host, $user, $pass, $dbname) or die("Error Connecting to MySQL Server.");
        // POST방식으로 전달받은 데이터 php변수에 저장
        $id=$_SESSION['id'];    // 세션 id 가져옴
        $title = mysqli_real_escape_string($dbc, trim($_POST['title']));
        $memo = mysqli_real_escape_string($dbc, trim($_POST['memo']));
        $music = addslashes(file_get_contents($_FILES['music_file']['tmp_name']));
        mysqli_query($dbc, 'set names utf8');

        if(empty($_FILES['music_file']['tmp_name'])){ // 음원 파일이 없는 경우
            $query = "INSERT INTO post VALUES (null, $id, NOW(), null, '$title', '$memo')";
        }
        else{ // 음원 파일이 있는 경우
            $query = "INSERT INTO post VALUES (null, $id, NOW(), '$music', '$title', '$memo')";
        }
        $result = mysqli_query($dbc, $query) or die ("Error Querying database.");

        mysqli_close($dbc);
        echo ("<script>location.href='main_page.php'</script>");
    ?>
</body>

</html>