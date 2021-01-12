<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php require('prisijungimasServer.php'); ?>
        <?php // printArray($prekes); ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='POST'>
            <?php require('errors.php'); ?>
            <input type="text" name="vartotojoVardas" required>Iveskite vartotjo vardą<br>
            <input type="password" name="password" required>Iveskite slaptažodį<br>
            <input type="submit" name="submit" value="pateiktiu"><br>
            <input type="hidden" name="prisijungimoForm" value="prisijungimoForm"><br>
            <input type="reset" name="reset" value="reset"><br>
            <br>
        </form>
    </body>
</html>
