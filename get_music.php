<?php
    header('Content-Type: image/jpg');
?>
<?php
    require_once('Database_Connection.php');

    $dbc = mysqli_connect($host, $user, $pass, $dbname)
    or die("Error Connecting to MySQL Server.");

    $postid = $_GET['postid'];

    $query = "SELECT music FROM post WHERE postid='$postid'";
    $result = mysqli_query($dbc, $query)
    or die("Error Querying database.");

    $row = mysqli_fetch_row($result);

    echo $row[0];

    mysqli_free_result($result);
    mysqli_close($dbc);
?>