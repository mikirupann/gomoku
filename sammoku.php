<?php
define("boardsize", 9);
define("line", 8);
session_start();
$state = array(1, 1, 1, 1, 1, 1, 1, 1, 1);
$gamestate = 0;
function checkwinner($state, $gamestate)
{
    if (
        $state[0] == 2 and $state[1] == 2 and $state[2] == 2 or
        $state[3] == 2 and $state[4] == 2 and $state[5] == 2 or
        $state[6] == 2 and $state[7] == 2 and $state[8] == 2 or
        $state[0] == 2 and $state[3] == 2 and $state[6] == 2 or
        $state[1] == 2 and $state[4] == 2 and $state[7] == 2 or
        $state[2] == 2 and $state[5] == 2 and $state[8] == 2 or
        $state[0] == 2 and $state[4] == 2 and $state[8] == 2 or
        $state[2] == 2 and $state[4] == 2 and $state[6] == 2
    ) {
        return 1;
    } elseif (
        $state[0] == 3 and $state[1] == 3 and $state[2] == 3 or
        $state[3] == 3 and $state[4] == 3 and $state[5] == 3 or
        $state[6] == 3 and $state[7] == 3 and $state[8] == 3 or
        $state[0] == 3 and $state[3] == 3 and $state[6] == 3 or
        $state[1] == 3 and $state[4] == 3 and $state[7] == 3 or
        $state[2] == 3 and $state[5] == 3 and $state[8] == 3 or
        $state[0] == 3 and $state[4] == 3 and $state[8] == 3 or
        $state[2] == 3 and $state[4] == 3 and $state[6] == 3
    ) {
        return 2;
    } else {
        return 0;
    }
}
function showboard($state)
{
    for ($i = 0; $i < boardsize; $i++) {
        switch ($state[$i]) {
            case 0:
                break;
            case 1:
                echo " " . $i . " ";
                break;
            case 2:
                echo "〇";
                break;
            case 3:
                echo "●";
                break;
            default:
                break;
        }
        if ($i < 8 and ($i + 1) % 3 == 0) {
            echo "<br>";
        }
    }
    echo "<br>";
}

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
        echo "〇 win";
        session_destroy();
        echo "<form action=sammoku.php method=GET>
<button>もう一度対戦!</button></form>";
    } else if ($gamestate == 2) {
        echo "● win";
        session_destroy();
        echo "<form action=sammoku.php method=GET>
      <button>もう一度対戦!</button></form>";
    } else if ($gamestate == 0 and $_SESSION['count'] == 9) {
        echo "引き分け";
        session_destroy();
    }
}

?>
<form action="sammoku_session.php" method="POST">
    <select name='cellnumber'>
        <?php for ($i = 0; $i < boardsize; $i++) {
            echo "<option value=" . $i . ">" . $i . "</option>";
        } ?>
    </select>
    <button>打つ</button>
</form>