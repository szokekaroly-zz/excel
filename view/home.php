<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>My Excel</title>
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <script src="js/jquery-2.1.4.min.js"></script>
        <script src="js/app.js"></script>
    </head>
    <body>
        <h1>My Excel</h1>
        <nav>
            <ul>
                <li id="add-col"><span class="fa fa-plus-circle fa-lg" title="Extend the table with new column"></span> Add column</li>
                <li id="add-row"><span class="fa fa-plus-circle fa-lg" title="Extend the table with new row"></span> Add row</li>
                <li id="remove-selected"><span class="fa fa-minus-circle fa-lg" title="Remove selection"></span> Remove</li>
            </ul>
        </nav>
        <table>
        <?php
        for ($i = 0; $i <= $maxrow; $i++) {
            $line = '<tr>';
            for ($j = 0; $j <= $maxcol; $j++) {
                if ($i == 0) {
                    if ($j == 0) {
                        $line .= '<th></th>';
                    } else {
                        $line .= '<th class="cols col_' . $j . '">' . chr(64 + $j) . '</th>';
                    }
                } else {
                    if ($j == 0) {
                        $line .= '<td class="rows row_' . $i . '">' . $i . '</td>';
                    } else {
                        $line .= '<td id="' . chr(64 + $j) . $i .
                                '" class="cell col_' . $j . ' row_' . $i . (($i == 1 && $j == 1? ' selected' : '' )) . '"></td>';
                    }
                }
            }
            $line .= '</tr>';
            echo $line;
        }
        ?>
        </table>
        <script>
            settings = {
                maxCol : <?php echo $maxcol; ?>,
                maxRow : <?php echo $maxrow; ?>
            }
        </script>
    </body>
</html>
