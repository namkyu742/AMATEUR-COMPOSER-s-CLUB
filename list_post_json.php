<?php
    header('Content-Type: application/json;charset=UTF-8');
    require_once('Database_Connection.php');

    $dbc = mysqli_connect($host, $user, $pass, $dbname) or die("Error Connecting to MySQL Server.");
    mysqli_query($dbc, 'set names utf8');
    // JOIN을 사용하여 post테이블과 user테이블을 연결. 작성자와 게시글을 연결하여 내용을 가져옴
    $query = "SELECT post.postid, post.userid, user.email, user.nickname, post.title, post.memo, post.time FROM post INNER JOIN user ON post.userid=user.id ORDER by time desc limit 0, 30";
    
    $result = mysqli_query($dbc, $query) or die("Error Querying database.1");
    $json = array();
    // 연상배열(assoc)을 사용하여 key값으로 접근 가능하도록 함
    while($row = mysqli_fetch_assoc($result)){
        // JOIN을 사용하여 reply테이블과 user테이블을 연결
        $replyquery = "SELECT reply.replyid, reply.userid, user.email, reply.memo, user.nickname, reply.time FROM reply INNER JOIN user ON user.id=reply.userid WHERE reply.postid = $row[postid] ORDER by time desc limit 0, 30";
        $replyresult = mysqli_query($dbc, $replyquery) or die("Error Querying Reply.2");
        $replyjson = array();

        while($replyrow=mysqli_fetch_assoc($replyresult)){
            $replyjson['reply'][]=$replyrow;
        }
        $json['post'][]=$row + $replyjson;

        mysqli_free_result($replyresult);
    }
    mysqli_free_result($result);
    mysqli_close($dbc);

    echo json_encode($json);
?>