<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            th, td {
                border: 1px solid black;

            }
            table{
                border-collapse: collapse;
            }
            .border-none{
                border: none;
            }
        </style>
    </head>
    <body>
        <?php require 'vidusServer.php'; ?>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='POST'>
            <?php
            if (!isset($_POST['Baigti'])) {
                testForm($klausimai, $userCookie, $connectionDb);
            }
            ?>

        </form>
        
            <table>
                <?php
                if (!isset($_POST['Baigti'])) {
                    if (!isset($_POST['testas'])) {
                        shopping($prekes, $userCookie, $connectionDb);
                    }
                }
                ?>
            </table>

        
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='POST'>
            <?php finishShopping($asocGoods, $userCookie, $connectionDb); ?>
        </form>

    </body>
</html>
