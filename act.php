<?php
session_start();
date_default_timezone_set('Europe/Moscow');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <style type="text/css">
    td{
        text-align: center;
    }
</style>
</head>
<body>

    <table>
        <tr>
            <th>
                X
            </th>
            <th>
                Y
            </th>
            <th>
                R
            </th>
            <th>
                Попадание
            </th>
            <th>
                Время
            </th>
            <th>
                Время работы скрипта
            </th>
        </tr>
        <?php

        $start_time = microtime(true);
        $x = $_POST["X"];
        $y = $_POST["Y"];
        $r = $_POST["R"];
        if (is_numeric($x) and is_numeric($y) and is_numeric($r)) {
            $correct = true;
        } else {
            $correct = false;
        }
        function checkQuater($x, $y)
        {
            if ($x >= 0 and $y >= 0) {
                return '1';
            } elseif ($x <= 0 and $y >= 0) {
                return '2';
            } elseif ($x <= 0 and $y <= 0) {
                return '3';
            } else return '4';
        }

        function countRegion($res)
        {
            global $x, $y, $r;
            switch (intval($res)) {
                case 1:
                if ($x <= ($r / 2) and $y <= $r) {
                    return true;
                } else return false;
                break;
                case 2:
                if (($y - $x) <= $r) {
                    return true;
                } else return false;
                break;
                case 3:
                if (($x * $x + $y * $y) <= $r) {
                    return true;
                } else return false;
                break;
                case 4:
                return false;
                default:
                return false;
                break;
            }

        }
        $res = checkQuater($x, $y);
        $fits = countRegion($res);
        $curr_time = date("G:i:s");
        $stop_time = microtime(true);
        $work_time = round(1000000*($stop_time - $start_time), 1).' мкс';
        $new_row = array($x, $y, $r, $fits, $curr_time, $work_time);

        if (!isset($_SESSION['rows'])){
            $_SESSION['rows'] = array();
        }

        array_push($_SESSION['rows'], $new_row);

        foreach ($_SESSION['rows'] as $row) {
            if (is_numeric($row[0]) and is_numeric($row[1]) and is_numeric($row[2])){
                $correct = true;
            } else {
                $correct = false;
            }
            ?>
            <tr>
                <td>
                    <?php if($correct) {
                        echo $row[0];
                    } else {
                        echo "данные";
                    } ?>
                </td>
                <td>
                    <?php if($correct) {
                        echo $row[1];
                    } else {
                        echo "введены";
                    } ?>
                </td>
                <td>
                    <?php if($correct) {
                        echo $row[2];
                    } else {
                        echo "некорректно";
                    } ?>
                </td>
                <td>
                    <?php if($correct){
                        if($row[3]){
                            echo "✓";
                        } else {
                            echo "не попадает";
                        }
                    } else {
                        echo "-----";
                    }?>

                    </td>
                    <td>
                        <?php echo $row[4] ?>
                    </td>
                    <td>
                        <?php echo $row[5] ?>
                    </td>
                </tr>
                <?php
            }
            ?>

        </table>



    </body>
    </html>