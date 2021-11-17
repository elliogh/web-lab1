<?php
session_start();
if (isset($_SESSION['results'])) {
    unset($_SESSION['results']);
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