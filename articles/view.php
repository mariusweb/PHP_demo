
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
require 'data.php';
?>

        <?php

$loginForm = "<form action='" . $_SERVER['PHP_SELF'] . "' method='POST'>
        <input type='text' name='userName' required>User full name<br>
        <input type='password' name='pass' required>Password<br>
        <input type='submit' name='submit' value='Login'><br>
        <input type='hidden' name='loginForm' value='loginForm'><br>
        <input type='reset' name='reset' value='reset'><br>
        <br>
    </form>";
// Print Login form if user is not loged
if (!isset($_SESSION["logged_user"])) {
    echo $loginForm;

} else {
    // Print Logout form if user is loged
    echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='POST'>
                <input type='submit' name='submit' value='Logout'><br>
            <input type='hidden' name='logoutForm' value='logoutForm'><br>
        </form>";
}
// Form for creating new article
echo "<form action='newArticle.php' method='POST'>
                <input type='submit' name='submit' value='Add new article'><br>
            <input type='hidden' name='newArticle' value='newArticle'><br>
        </form>";

// Errors if Login input data doesn't match or user is blocked
if ($isBlocked == false) {
    echo "<h3>You are blocked</h3>";
} elseif ($userExist == false) {
    echo "<h3>User doesn't exist</h3>";
}
// For admin to go back to articles from control panel
if (isset($_GET["name"]) && $_GET["name"] == "controladmin") {
    echo "<br><a href='" . $_SERVER['PHP_SELF'] . "'>Go back</a><br>";
}
// For admin to go to control panel
if (isset($_SESSION["logged_user"]) && $_SESSION["logged_user"]['role'] == "admin") {
    echo "<br><a href='" . $_SERVER['PHP_SELF'] . "?name=control" . $_SESSION["logged_user"]['role'] . "'>Control Panel</a><br>";
}
// Check for errors
if (isset($errors)) {
    echo $errors;
    exit();
    die();
}
// Print users inside control panel
foreach ($adminUsersArray as $adminClass) {
    $adminClass->usersList();
}
// Print all articles
foreach ($publications as $items) {
    $items->printArticle();
    // Print topics of article
    foreach ($topicArray as $topicOfArticle) {
        $items->printTopics($topicOfArticle);
    }
    // Print info and image links
    $items->link();
    // Print main image
    $items->printImagesBack();
    // All images
    foreach ($imageArray as $imageOfArticle) {

        $items->printImages($imageOfArticle);
    }
    // If user is loged then print comment button or delete button
    if (!empty($_SESSION["logged_user"])) {
        $items->commentButton($_SESSION["logged_user"]);
    }
    // Just for printing h4 Comments name to know where comments start
    $items->printCommentTitle();
    // For printing all comments
    foreach ($commentsArray as $commentRow) {

        $items->printComment($commentRow);
    }
    // For printing number of Comments
    $items->printCommentNumber();
}
?>

    </body>
</html>

