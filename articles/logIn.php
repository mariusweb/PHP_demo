<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
         <?php require('data.php'); ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='POST'>
            
            <input type="text" name="userName" required>Iveskite vartotjo vardą<br>
            <input type="password" name="pass" required>Iveskite slaptažodį<br>
            <input type="submit" name="submit" value="pateiktiu"><br>
            <input type="hidden" name="loginForm" value="loginForm"><br>
            <input type="reset" name="reset" value="reset"><br>
            <br>
        </form>
    </body>
</html>
