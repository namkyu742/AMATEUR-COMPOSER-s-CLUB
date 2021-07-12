<!DOCTYPE html>
<html>

<head>
    <title>SIGNUP</title>
    <meta charset="utf-8" />
</head>

<body>
    <?php
        require_once('Database_Connection.php');
        // form에 입력하지 않은 사항이 있을 경우 form으로 돌아감
        if (empty($_POST['email'])||empty($_POST['pass'])||empty($_POST['passcon'])){
            echo "<script>alert('입력 폼을 채워주세요.');</script>";
            exit("<script>javascript:history.go(-1)</script>");
        }
        // 이미지 파일 가져오기 실패시 form으로 돌아감
        if(!isset($_FILES['userimg'])){
            echo "<script>alert('이미지 업로드 에러가 발생했습니다.');</script>";
            exit("<script>javascript:history.go(-1)</script>");
        }

        $dbc = mysqli_connect($host, $user, $pass, $dbname)
        or die("Error Connecting to MySQL Server.");
        // POST방식으로 전달된 값들 php변수에 저장
        $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
        $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
        $nickname = mysqli_real_escape_string($dbc, trim($_POST['nickname']));
        $pass = mysqli_real_escape_string($dbc, trim($_POST['pass']));
        $passcon = mysqli_real_escape_string($dbc, trim($_POST['passcon']));
        $image = addslashes(file_get_contents($_FILES['userimg']['tmp_name']));
        $phone_number = mysqli_real_escape_string($dbc, trim($_POST['phone_number']));
        // 이메일 중복 검사
        $query = "SELECT id FROM user WHERE email='$email'";
        $result = mysqli_query($dbc, $query) 
        or die ("Error Querying database.");

        if (mysqli_num_rows($result) != 0){
            echo "<script>alert('이미 존재하는 e-mail 입니다.');</script>";
            exit("<script>javascript:history.go(-1)</script>");
        }
        mysqli_free_result($result);
        mysqli_query($dbc, 'set names utf8');
        // 비밀번호는 SHA암호화를 하여 입력
        $query = "INSERT INTO user VALUES (null, '$email', '$name', '$nickname', '$phone_number', SHA('$pass'), '$image')";
        
        $result = mysqli_query($dbc, $query) 
        or die ("Error Querying database.");

        mysqli_close($dbc);
        echo "<script>alert('회원가입에 성공하였습니다.');</script>";
        echo ("<script>location.href='main_page.php'</script>");  
    ?>
</body>

</html>