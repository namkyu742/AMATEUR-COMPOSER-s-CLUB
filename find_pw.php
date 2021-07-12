<?php
    session_start();
    ob_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>비밀번호 찾기</title>
    <meta charset="utf-8" />
</head>

<body>
    <?php
        require_once('Database_Connection.php');

        if (empty($_POST['name'])||empty($_POST['userid'])||empty($_POST['phone_number'])||empty($_POST['pass'])){
            echo "<script>alert('입력 폼을 채워주세요.');</script>";
            exit("<script>javascript:history.go(-1)</script>");
        }
        else{
            $dbc = mysqli_connect($host, $user, $pass, $dbname) // 데이터베이스 connection
            or die("Error Connecting to MySQL Server.");
    
            // POST방식으로 전달받은 값 php변수에 저장
            $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
            $userid = mysqli_real_escape_string($dbc, trim($_POST['userid']));
            $phone_number = mysqli_real_escape_string($dbc, trim($_POST['phone_number']));
            $pass = mysqli_real_escape_string($dbc, trim($_POST['pass']));
            mysqli_query($dbc, 'set names utf8');       // 문자 인코딩 utf8로 변경
            // 이메일, 이름과 전화번호를 통해 해당 계정의 소유자인지 인증
            $query = "SELECT id, email, nickname, password FROM user WHERE name='$name' and phone_number='$phone_number'";
            $result = mysqli_query($dbc, $query) 
            or die ("Error Q1uerying database.");
            // SELECT결과로 해당되는 값이 있을 경우 비밀번호 값 변경
            if (mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_assoc($result);
                $temp_email = $row['email'];
                // SQL에 UPDATE문을 사용해서 비밀번호 값을 새로운 비밀번호 값으로 변경
                $query = "UPDATE user SET password = SHA('$pass') WHERE email = '$temp_email' and phone_number = '$phone_number' and name = '$name'";
                $result = mysqli_query($dbc, $query);
                echo ("<script>location.href='login_form.html'</script>");  // 성공 후 로그인 페이지로 돌아감
            }
            else{
                echo "<script>alert('비밀번호 변경 실패');</script>";
                echo "<script>javascript:history.go(-1)</script>";
            }
            mysqli_free_result($result);       
        }
    ?>
</body>

</html>