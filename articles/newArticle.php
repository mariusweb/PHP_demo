<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
    <?php
require 'dataNewArticle.php';
if (isset($_SESSION['shortContent'])) {
    echo "<h2>" . $_SESSION['shortContent'] . "</h2>";
}
?>
        <form action="<?php $_SERVER['PHP_SELF']?>" method='POST'>

            <h3>New article</h3>
            <input type="text" name="newAuthor" required><label for="newAuthor">Author</label> <br>
            <input type="text" name="newShort"  required><label for="newShort">Short Content</label><br>
            <input type="text" name="newContent"  required><label for="newContent">Content</label><br>
            <select id="newType" name="newType">
                <option value="NewsArticle">News Article</option>
                <option value="ShortArticle">Short Article</option>
                <option value="PhotoArticle">Photo Article</option>
            </select>
            <input type="text" name="newTitle"  required><label for="newTitle">Title</label><br>
            <input type="text" name="newImage"  required><label for="newImage">Main image URL</label><br>
            <input type='submit' name='addNewArticle' value='Add new article'>
            <input type='hidden' name='addNewArticle' value='AddNewArticle'>
        </form>
        <form action="<?php $_SERVER['PHP_SELF']?>" method='POST'>
        <input type='submit' name='backArticle' value='Go back to articles'>
            <input type='hidden' name='backArticle' value='AddNewArticle'>
        </form>
        <?php

?>
    </body>
</html>
