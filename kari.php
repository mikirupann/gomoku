<?php

require_once __DIR__ . '/functions.php';

$dbh = connect_db();

session_start();
$state = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];
$gamestate = 0;

if (!isset($_SESSION['state'])) {
    $_SESSION['state'] = $state;
    $_SESSION['nowturn'] = 0;
    $_SESSION['count'] = 0;
    showboard($state);
} else if (isset($_SESSION['state'])) {
    showboard($_SESSION['state']);
    $gamestate = checkwinner($_SESSION['state'], $gamestate);
    if ($_SESSION['count'] % 2 == 0 and $gamestate == 0) {
        echo "〇 の番です!!<br>";
    } else if ($_SESSION['count'] % 2 == 1 and $gamestate == 0) {
        echo "● の番です!!<br>";
    }
    if ($gamestate == 1) {
        echo "〇 win!!";
        session_destroy();
        echo "<form action=kari.php method=GET>
<button>もう一度対戦!</button></form>";
    } else if ($gamestate == 2) {
        echo "● win!!";
        session_destroy();
        echo "<form action=kari.php method=GET>
      <button>もう一度対戦!</button></form>";
    } else if ($gamestate == 0 and $_SESSION['count'] == 24) {
        echo "引き分け";
        session_destroy();
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/_header.html' ?>

<body>
    <form action="gomoku_session.php" method="POST">
        <select name='cellnumber'>
            <div class="pulldown">
                <option hidden>エリア指定</option>
                <?php for ($i = 0; $i < boardsize; $i++) : ?>
                    <?php echo "<option value=" . $i . ">" . sprintf("%02d", $i) . "</option>" ?>
                <?php endfor; ?>
            </div>
        </select>
        <button>打つ</button>
    </form>
</body>

</html>