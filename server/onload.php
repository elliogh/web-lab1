<?php
session_start();
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
<?php if (isset($_SESSION["results"])) foreach ($_SESSION["results"] as $res) {
    echo <<<HTML
    <tr>
        <td>$res[0]</td>
        <td>$res[1]</td>
        <td>$res[2]</td>
        <td>$res[3]</td>
        <td>$res[4]</td>
        <td>$res[5]</td>
    </tr>
HTML;
} ?>