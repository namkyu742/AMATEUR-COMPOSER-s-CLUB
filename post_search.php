<?php
    require_once("session.php");
    require_once("header.html");
?>

<section class="board">
    <nav>
        <ul>
        <?php
                if (!isset($_SESSION['id']))
                    echo '<li><a href="login_form.html">로그인</a></li>';
                else
                    echo '<li><a href="logout.php">로그아웃</a></li>';
            ?>
            <li>
                <a href="post_insert_form.php">게시글 작성</a>
            </li>
            <li>
                <a href="main_page.php">홈</a>
            </li>
        </ul>
    </nav>
    <br><br>

    <section class="post_contents">
        <?php
            require_once('Database_Connection.php');
            // 검색어 입력이 없을 시 전 페이지로 돌아감
            if (empty($_POST['search'])){
                echo "<script>alert('입력 폼을 채워주세요.');</script>";
                exit("<script>javascript:history.go(-1)</script>");
            }

            $dbc = mysqli_connect($host, $user, $pass, $dbname) or die("Error Connecting to MySQL Server.");

            $id=$_SESSION['id'];
            $search = mysqli_real_escape_string($dbc, trim($_POST['search'])); // POST방식으로 전달받은 데이터 php변수에 저장 
            mysqli_query($dbc, 'set names utf8');
            // JOIN으로 post테이블과 user테이블을 연결하고 LIKE를 사용하여 제목과 내용에서 검색어와 같은 문자열을 가지는 투플을 가져옴
            $query = "SELECT post.postid, post.userid, user.email, post.time, post.music, post.title, user.nickname, post.memo FROM post INNER JOIN user ON post.userid=user.id WHERE title LIKE '%$search%' or memo LIKE '%$search%'";
            $result = mysqli_query($dbc, $query) or die ("Error Querying database.");
            
            // 아래 코드들은 자바스크립트쪽 코드를 php에서 사용하도록 수정함
            // 자바스크립트 코드는 4.2.13에서 설명

            while($row = mysqli_fetch_assoc($result)){
                echo ('<div class="img_frame">');

                echo ('<div class="post_title">'.$row[title].'</div>');
                echo ('<div><a href="post_update_form.php?postid='.$row[postid].'&userid='.$row[userid].'&isAdmin='.$row[isAdmin].'"><button class="post_update" type="button">수정</button></a></div>'); // 게시글 수정
                echo ('<div><a href="post_delete.php?postid='.$row[postid].'&userid='.$row[userid].'&isAdmin='.$row[isAdmin].'"><button class="post_delete" type="button">삭제</button></a></div>'); // 게시글 삭제
                echo ('<br><br><br><br>');
                $link = '\'/images/tsuyucon/NULL.png\'';
                echo ('<img class="user_thumbnail" src="get_userimage.php?email='.$row[email].'" onerror="this.src='.$link.'">');
                echo ('<div class="user_nickname">'.$row[nickname].'</div>');
                echo ('<div class="user_date">'.$row[time].'</div>');

                echo ('<br><br><hr>');
                $text = $row[memo];
                $text = str_replace("\n", "<br>", $text);
 
                echo ('<div class="post_content">'.$text.'</div>');
                echo ('<audio class="music_player" controls ><source class="player" src="get_music.php?postid='.$row[postid].'" type="audio/mp3"></audio>');
                echo ('</div>');
                // JOIN으로 reply테이블과 user테이블을 연결하고 LIKE를 사용하여 제목과 내용에서 검색어와 같은 문자열을 가지는 투플을 가져옴
                $replyquery = "SELECT reply.replyid, reply.userid, user.email, reply.memo, user.nickname, reply.time FROM reply INNER JOIN user ON user.id=reply.userid WHERE reply.postid = $row[postid] ORDER by time desc limit 0, 30";
                $replyresult = mysqli_query($dbc, $replyquery)
                or die("Error Querying Reply.");

                while($replyrow=mysqli_fetch_assoc($replyresult)){
                    echo ('<article class="reply">');
                    echo ('<img class="user_thumbnail" src="get_userimage.php?email='.$replyrow[email].'" onerror="this.src='.$link.'">');
                    echo ('<div class="user_nickname">'.$replyrow[nickname].'</div>');

                    echo ('<div class="user_date">'.$replyrow[time].'</div>');
                    echo ('<div><a href="reply_update_form.php?replyid='.$row[replyid].'&userid='.$row[userid].'"><img class="post_updates" src="/images/update.png"></a></div>'); // 게시글 수정
                    echo ('<div><a href="reply_delete.php?replyid='.$row[replyid].'&userid='.$row[userid].'"><img class="post_updates" src="/images/delete.png"></a></div>'); // 게시글 삭제
                    
                    $text2 = $replyrow[memo];
                    $text2 = str_replace("\n", "<br>", $text2);
                    echo ('<div class="user_reply"><br>   '.$text2.'</div>');
                    echo ('</article>');
                }
            }
            mysqli_close($dbc);
        ?>
    </section>
    <br><br><br><br>

</section>
<br><br><br><br>

<?php
    require_once("footer.php");
?>