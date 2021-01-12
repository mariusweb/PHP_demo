<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>

    </head>
    <body>
        <?php if (count($errors) > 0) : ?>
            <div class="error">
                <?php foreach ($errors as $error) : ?>
                    <p><?php echo $error ?></p>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </body>
</html>

