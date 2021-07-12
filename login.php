<?php
    session_start();
    ob_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>LOGIN</title>
    <meta charset="utf-8" />
</head>

<body>
    <?php
        require_once('Database_Connection.php');

        if (isset($_SESSION['id'])){
            exit('<a href="main_page.php">세션을 통해서 로그인 정보를 확인했습니다.</a></body></html>');
        }

        if (empty($_POST['email'])||empty($_POST['pass'])){
            echo "<script>alert('로그인 폼을 채워주세요.');</script>";
            exit("<script>javascript:history.go(-1)</script>");
        }
        else{
            // 데이터베이스 Connection
            $dbc = mysqli_connect($host, $user, $pass, $dbname)
            or die("Error Connecting to MySQL Server.");
            // POST방식으로 받은 값 php변수에 저장
            $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
            $pass = mysqli_real_escape_string($dbc, trim($_POST['pass']));
            // 비밀번호는 SHA를 사용하여 암호화한 값을 대조(복호화가 어렵기 때문)
            $query = "SELECT id, email, nickname FROM user WHERE email='$email' and password=SHA('$pass')";
            $result = mysqli_query($dbc, $query) 
            or die ("Error Q1uerying database.");
            // 해당되는 계정이 존재할 경우 세션에 id번호 저장
            if (mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_assoc($result);
                $userid = $row['id'];
                $_SESSION['id'] = $userid;
                // 쿠키에 로그인 정보를 1일동안 보관
                setcookie('id', $row['id'], time() + (60*60*24));
                setcookie('email', $row['email'], time() + (60*60*24));
                setcookie('nickname', $row['nickname'], time() + (60*60*24));
                // 로그인에 성공하였으므로 메인 페이지로 이동
                echo "$email" . "님의 로그인에 성공했습니다.<br/><br/><a href='main_0428.php'>홈으로</a>";
                echo ("<script>location.href='main_page.php'</script>");
            }
            else{
                echo "<script>alert('아이디 또는 비밀번호를 잘못 입력하셨습니다');</script>";
                echo "<script>javascript:history.go(-1)</script>";
            }
            mysqli_free_result($result);       
        }
    ?>
</body>

</html>