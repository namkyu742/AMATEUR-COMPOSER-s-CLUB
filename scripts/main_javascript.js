$(document).ready(function () {
    // 아이디 찾기 & 비밀번호 찾기
    $("#find_id").click(function () {
        $(".find_id_form").fadeToggle(500);
    })
    $("#find_pw").click(function () {
        $(".find_pw_form").fadeToggle(500);
    })

    refresh_post();

    String.prototype.replaceAll = function (org, dest) {
        // 문자열 치환 함수 정의
        return this.split(org).join(dest);
    }

    $("#list_toggle").click(function () {
        // 게시글 목록을 slideToggle을 이용하여 열고 닫을 수 있도록 함
        $(".post_list").slideToggle(500);
        if ($(this).text() == "목록닫기")
            $(this).text("목록열기");
        else
            $(this).text("목록닫기");
    });

    function refresh_post() {
        $(".find_id_form").hide();
        $(".find_pw_form").hide();
        // 게시판 목록 출력
        $.getJSON("list_post_json.php", function (json) {
            // 게시판은 테이블을 사용하여 모양을 만들었다. 
            var list = '';
            list += '<table class="sub_news" border="1" cellspacing="0">';
            list += '<caption>게시판 리스트</caption>';
            list += '<colgroup>\
                        <col width="50">\
                        <col>\
                        <col width="110">\
                        <col width="100">\
                    </colgroup>';
            list += '<thead>';
            list += '<tr>\
                        <th scope="col">번호</th>\
                        <th scope="col">제목</th>\
                        <th scope="col">작성자</th>\
                        <th scope="col">날짜</th>\
                    </tr>';
            list += '</thead ><tbody>';
            var index = 0;
            while (index < 30) {
                $(".post").remove();
                $.each(json.post, function () {
                    // 게시판에 게시글들을 목록화하여 출력한다.
                    if (this['postid'] == index) {
                        list += '<tr>\
                            <td class="name">'+ this['postid'] + '</td>\
                            <td class="title"><a href="#'+ this['postid'] + '">' + this['title'] + '</a></td>\
                            <td class="name">'+ this['nickname'] + '</td>\
                            <td class="date">'+ this['time'] + '</td>\
                        </tr>';
                    }
                });
                index++;
            }
            list += '</tbody></table>';
            $(".post_list").append(list);
        });
    };

    function clicked_post(id_number) {
        // 게시글의 내용을 출력하는 함수
        $.getJSON("list_post_json.php", function (json) {   // 게시글 내용을 JSON형식으로 가져옴
            $(".post").remove();                            // 이미 있던 내용을 지움으로서 원하는 게시글만 출력
            $.each(json.post, function () {
                //  데이터는 json에서 하나씩 꺼내서 조건이 맞는 데이터만 출력하도록 한다.
                if (id_number == this['postid']) {
                    var post = '<article class="post">';
                    post += '<div class="img_frame">';

                    post += '<div class="post_title">' + this["title"] + '</div>';
                    post += '<div><a href="post_update_form.php?postid=' + id_number + '&userid=' + this["userid"] + '"><button class="post_update" type="button">수정</button></a></div>'; // 게시글 수정
                    post += '<div><a href="post_delete.php?postid=' + id_number + '&userid=' + this["userid"] + '"><button class="post_delete" type="button">삭제</button></a></div>'; // 게시글 삭제
                    post += '<br><br><br><br>';
                    var link = '\'/images/tsuyucon/NULL.png\''; // 주소 방식 이미지 파일 가져오기
                    post += '<img class="user_thumbnail" src="get_userimage.php?email=' + this["email"] + '" onerror="this.src=' + link + '"/>';
                    // 유저 이미지를 출력할때 데이터베이스에 MediumBLOB으로 저장된 이미지를 가져오도록 하였으며 이미지를 가져오지 못하는 경우에는 주소를 통해 기본이미지를 출력하도록 하였다.
                    post += '<div class="user_nickname">' + this["nickname"] + '</div>';
                    post += '<div class="user_date">' + this["time"] + '</div>';

                    post += '<br><br><hr>';
                    var text = this['memo'];
                    text = text.replaceAll("\n", "<br>");   // 웹과 SQL의 개행문자가 다르기 때문에 치환과정이 필요
                    post += '<div class="post_content">' + text + '</div>';
                    post += '<audio class="music_player" controls ><source class="player" src="get_music.php?postid=' + this["postid"] + '" type="audio/mp3"></audio>'; //음원파일 플레이어

                    post += '</div>';
                    post += '<section class="post_reply"><br>';
                    if (this.reply) {
                        $.each(this.reply, function () {
                            var reply = '<article class="reply">';
                            reply += '<img class="user_thumbnail" src="get_userimage.php?email=' + this["email"] + '" onerror="this.src=' + link + '"/>';
                            reply += '<div class="user_nickname">' + this["nickname"] + '</div>';

                            reply += '<div class="user_date">' + this["time"] + '</div>';
                            reply += '<div><a href="reply_update_form.php?replyid=' + this["replyid"] + '&userid=' + this["userid"] + '"><img class="post_updates" src="/images/update.png"></a></div>'; // 댓글 수정
                            reply += '<div><a href="reply_delete.php?replyid=' + this["replyid"] + '&userid=' + this["userid"] + '"><img class="post_updates" src="/images/delete.png"></a></div>'; // 댓글 삭제

                            var text2 = this['memo'];
                            text2 = text2.replaceAll("\n", "<br>");   // 웹과 SQL의 개행문자가 다르기 때문에 치환과정이 필요
                            reply += '<div class="user_reply"><br>   ' + text2 + '</div>';
                            reply += '</article>';
                            post += reply;      // 댓글을 게시글에 붙여서 한번에 출력한다.
                        });
                    }

                    post += '</section>';
                    post += '</article>';
                    $(".post_contents").append(post);
                    // 댓글 달기
                    $(".comment_input").remove();
                    register_comments = '';
                    // 댓글 입력 form 출력
                    register_comments += '<form method="post" class="comment_input" action="reply_insert.php">\
                        <input type="hidden" name="postid" value="' + this["postid"] + '"/>\
                        <div><textarea class="comment_text "name="memo" maxlength="1000"></textarea></div>\
                        < div > <button class="comment_submit" type="submit">등록하기</button></div >\
                    </form > ';
                    $(".post_contents").append(register_comments);
                }
            });
        });
    };

    window.onhashchange = function () {
        // 게시글 제목 클릭 시 해당 게시글의 내용을 출력할 수 있도록 함수 호출
        var temp = window.location.href;
        temp = temp.substr(31, 4);
        clicked_post(temp);
    }
});