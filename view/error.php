<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Error in page</title>
    </head>
    <body>
        <h1>
            Error in page
        </h1>
        <p>
            <?php
            echo 'Error message: ' . $exc->getMessage() . '<br /> Stack trace: ' .
                    $exc->getTraceAsString();
            ?>
        </p>
    </body>
</html>
