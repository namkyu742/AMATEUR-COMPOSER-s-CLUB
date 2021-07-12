<?php
    require_once("session.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>댓글 등록</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="styles/login_and_sighup.css?ver=2.0aba" />

    </head>
    <body>
        <a href="main_page.php"><img class="title_image" src="images/R_comment_image.png" alt="write_image" /></a>
        <img class="title_line" src="images/title_line.png" alt="title_line" />

        <?php
            if (!isset($_SESSION['id'])){
                echo "<script>alert('로그인 후 이용해주십시오.');</script>";
                echo ("<script>location.href='main_page.php'</script>");
            }
        ?>
        
        <form method="post"  action="reply_insert.php">
            <p>댓글</p>
            <textarea name="memo" cols="50" rows="10" maxlength="5"></textarea>
            <input type="hidden" name="postid" value="<?php echo $_GET['postid'];?>"/>
            
            <button class="submit" type="submit">등록하기</button>
        </form>
    </body>
</html>