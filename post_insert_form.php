<?php
    require_once("session.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Self-composed song registration</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="styles/login_and_sighup.css?ver=2.0aba" />
    </head>
    <body>
        <!-- 상단 배너 -->
        <a href="main_page.php"><img class="title_image" src="images/R_post_image.png" alt="write_image" /></a> 
        <img class="title_line" src="images/title_line.png" alt="title_line" />

        <?php
            // 로그인 여부 확인
            if (!isset($_SESSION['id'])){
                echo "<script>alert('로그인 후 이용해주십시오.');</script>";
                echo ("<script>location.href='main_page.php'</script>");
            }
        ?>
        <!-- 입력 form -->
        <form method="post" enctype="multipart/form-data" action="post_insert.php">
            <p>제목</p>
            <input type="text" name="title" placeholder=" 게시글 제목을 입력해주세요." /><br />
            <p>설명</p>
            <textarea name="memo" cols="50" rows="10" placeholder=" 게시글 내용을 입력해주세요."></textarea>
            <br/>
            <p>자작곡</p>
            <!-- 자작곡은 file형식으로 가져온다. -->
            <div class="filebox">
                <label for="ex_file">업로드</label>
                <input type="file" name="music_file" accept=".mp3" id="ex_file">
            </div>
            <button class="submit" type="submit">등록하기</button>
        </form>    
    </body>
</html>