<?php
    require_once("session.php");
    require_once("header.html");
?>
<!-- require_once를 통해 반복되는 코드 분리 후 불러옴 -->
<section class="board">
    <nav>
        <ul>
            <?php
                // 로그인 정보가 있으면 '로그아웃'을 표시
                if (!isset($_SESSION['id']))
                    echo '<li><a href="login_form.html">로그인</a></li>';
                else
                    echo '<li><a href="logout.php">로그아웃</a></li>';
            ?>
            <li><a href="post_insert_form.php">게시글 작성</a></li>
            <li><a href="main_page.php">홈</a></li>
            <!-- 접속중인 계정의 닉네임 출력 -->
            <section class = "user_info_main"> <?php echo '<div
            class="main_user_name">LOGIN : '.$_COOKIE['nickname'].'</div>'; ?>
            </section>
        </ul>
    </nav>
    <br><br><hr>

    <section class="post_contents"></section>   <!-- 게시글 내용이 출력될 section -->
    <br><br><br><br>
    <div id="list_toggle">목록열기</div>
    <section class="post_list"></section>       <!-- 게시글 목록이 출력될 section -->
    <section class="post_search">               <!-- 검색 기능을 위한 입력공간 -->
        <form method="post" action="post_search.php">
            <br/><input class="search_input" type="text" size="50" name="search" placeholder="검색어">
            <button class="search_submit" type="submit">검색</button>
        </form>
    </section>
</section>
<br><br><br><br>
<?php
    require_once("footer.php");
?>