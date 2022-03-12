<?php

require_once __DIR__ . '/functions.php';

$dbh = connect_db();

session_start();
$state = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];
$gamestate = 0;
$msg = '';

if (!isset($_SESSION['state'])) {
    $_SESSION['state'] = $state;
    $_SESSION['nowturn'] = 0;
    $_SESSION['count'] = 0;
    //showboard($state);
} else {
    $state = $_SESSION['state'];
    //showboard($_SESSION['state']);
    $gamestate = checkwinner($_SESSION['state'], $gamestate);
    if ($_SESSION['count'] % 2 == 0 and $gamestate == 0) {
        $msg = "〇 の番です!!<br>";
    } else if ($_SESSION['count'] % 2 == 1 and $gamestate == 0) {
        $msg = "● の番です!!<br>";
    }
    if ($gamestate == 1) {
        //echo "<hr>";
        $msg1 = "〇 win!!";
        session_destroy();
    } elseif ($gamestate == 2) {
        $msg1 = "● win!!";
        session_destroy();
    } else if ($gamestate == 0 and $_SESSION['count'] == 225) {
        echo "引き分け";
        session_destroy();
    }
}
// session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/_header.html' ?>

<body>
    <table border="1">
        <tbody>
            <?php
            if (!isset($_SESSION['state'])) {
                showboard($state);
            } else {
                showboard($state);
            }
            ?>
        </tbody>
    </table>
    <?php if (isset($_SESSION['state'])) :  ?>
        <hr>
    <?php endif; ?>
    <?= $msg ?>
    <?php if ($gamestate == 1) : ?>
        <?= $msg1 ?>
        <form action="index.php" method="GET">
            <button>もう一度対戦!</button>
        </form>
    <?php endif; ?>
    <?php if ($gamestate == 2) : ?>
        <?= $msg1 ?>
        <form action="index.php" method="GET">
            <button>もう一度対戦!</button>
        </form>
    <?php endif; ?>
    <form action="gomoku_session.php" method="POST">
        <select name='cellnumber'>
            <div class="pulldown">
                <option hidden>エリア指定</option>
                <?php for ($i = 0; $i < boardsize; $i++) : ?>
                    <?php echo "<option value=" . $i . ">" . sprintf("%03d", $i) . "</option>" ?>
                <?php endfor; ?>
            </div>
        </select>
        <button>打つ</button>
    </form>
</body>

</html>