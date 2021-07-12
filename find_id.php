<?php
    session_start();
    ob_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>아이디 찾기</title>
    <meta charset="utf-8" />
</head>

<body>
    <?php
        require_once('Database_Connection.php');

        if (empty($_POST['name'])||empty($_POST['phone_number'])){
            echo "<script>alert('입력 폼을 채워주세요.');</script>";
            exit("<script>javascript:history.go(-1)</script>");
        }
        else{
            $dbc = mysqli_connect($host, $user, $pass, $dbname)
            or die("Error Connecting to MySQL Server.");
    
            $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
            $phone_number = mysqli_real_escape_string($dbc, trim($_POST['phone_number']));
            mysqli_query($dbc, 'set names utf8');
            
            $query = "SELECT id, email, nickname FROM user WHERE name='$name' and phone_number='$phone_number'";
            $result = mysqli_query($dbc, $query) 
            or die ("Error Q1uerying database.");
    
            if (mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_assoc($result);
                echo "<script>alert('ID : ".$row['email']."')</script>";
                echo ("<script>location.href='login_form.html'</script>");
            }
            else{
                echo "<script>alert('ID 찾기 실패');</script>";
                echo "<script>javascript:history.go(-1)</script>";
            }
            mysqli_free_result($result);       
        }
    ?>
</body>

</html>