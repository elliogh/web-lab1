<?php

$x = isset($_POST['x']) ? intval($_POST['x']) : null;
$y = isset($_POST['y']) ? floatval($_POST['y']) : null;
$r = isset($_POST['r']) ? floatval($_POST['r']) : null;

session_start();

date_default_timezone_set('Europe/Moscow');
$current_time = date("H:i:s:ms");

if (!check_values($x, $y, $r)) {
    http_response_code(412);
    echo ("x={$x}, y={$y}, r={$r}");
    return;
}

$result = check_area($x, $y, $r) ? "<span class='successful'>Попадание</span>" : "<span class='missed'>Мимо</span>";

$exec_time = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];

$_SESSION['results'][] = [$x, $y, $r, $current_time, $exec_time, $result];

function check_area($x, $y, $r)
{
    return ($x >= 0 and $x <= $r/2 and $y <= 0 and $y >= -$r) or
        ($x >= 0 and $y <= -0.5 * $x + $r/2 and $y >= 0) or
        ($x <= 0 and $y <= 0 and pow($x, 2) + pow($y, 2) <= pow($r/2, 2));
}

function check_values($x, $y, $r)
{
    return in_array($x, [-5, -4, -3, -2, -1, 0, 1, 2, 3])
            and (is_numeric($y) and $y > -3 and $y < 5)
            and in_array($r, [1, 1.5, 2, 2.5, 3]);
}

foreach ($_SESSION['results'] as $resp) {
    $table .= "<tr>";
    $table .= "<td>" . $resp[0] . "</td>";
    $table .= "<td>" . $resp[1] . "</td>";
    $table .= "<td>" . $resp[2] . "</td>";
    $table .= "<td>" . $resp[3] . "</td>";
    $table .= "<td>" . $resp[4] . "</td>";
    $table .= "<td>" . $resp[5] . "</td>";
    $table .= "</tr>";
}

?>
    <thead>
    <tr>
        <th>X</th>
        <th>Y</th>
        <th>R</th>
        <th>Время запуска</th>
        <th>Время работы</th>
        <th>Результат</th>
    </tr>
    </thead>
<?php echo $table ?>

