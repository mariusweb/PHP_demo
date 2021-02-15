<?php
require 'data.php';

$addNewArticleArray = array();

if (isset($_POST['addNewArticle'])) {
    if (isset($_POST['newAuthor']) &&
        isset($_POST['newShort']) &&
        isset($_POST['newContent']) &&
        isset($_POST['newType']) &&
        isset($_POST['newTitle']) &&
        isset($_POST['newImage'])) {
        mysqli_begin_transaction($articles);
        $authorShortArray = array();

        $sqlSelectArticleCheck = 'SELECT author, shortContent FROM articles';
        $selectArticleCheck = mysqli_query($articles, $sqlSelectArticleCheck);
        while ($row = mysqli_fetch_array($selectArticleCheck)) {
            $authorShortArray[] = $row;
        }

        $_SESSION['authorNew'] = false;
        // Check if new article has the same article
        foreach ($authorShortArray as $authorShort) {
            if ($authorShort['shortContent'] == $_POST['newShort']) {
                $_SESSION['shortContent'] = 'Short content exist!';
                mysqli_rollback($articles);
                header('Location: newArticle.php');
                exit();
            } else {
                unset($_SESSION['shortContent']);
            }
        }
        if (mysqli_errno($articles)) {
            mysqli_rollback($articles);
        }
        mysqli_commit($articles);

        mysqli_begin_transaction($articles);
        $authorArray = array();
        $sqlSelectUserCheck = 'SELECT fullname FROM users;';
        $selectUserCheck = mysqli_query($articles, $sqlSelectUserCheck);
        while ($rowUsers = mysqli_fetch_array($selectUserCheck)) {
            $authorArray[] = $rowUsers;
        }
        // Checking if author exist
        foreach ($authorArray as $authorCheckFor) {
            if ($authorCheckFor['fullname'] == $_POST['newAuthor']) {
                $_SESSION['authorNew'] = true;
            }
        }

        if (mysqli_errno($articles)) {
            mysqli_rollback($articles);
        }
        mysqli_commit($articles);
    } else {
        header('Location: newArticle.php');
        exit();
    }
    // If author exist add only article
    if (isset($_SESSION['authorNew']) && $_SESSION['authorNew'] == true) {
        $addNewArticleArray = ['newAuthor' => $_POST['newAuthor'],
            'newShort' => $_POST['newShort'],
            'newContent' => $_POST['newContent'],
            'newDate' => date("Y-m-d"),
            'newType' => $_POST['newType'],
            'newTitle' => $_POST['newTitle'],
            'newImage' => $_POST['newImage']];
        $_SESSION['addNewArticleArray'] = $addNewArticleArray;
        unset($_SESSION['authorNew']);
    }
    // If author doesn't exist then add new author and article
    if (isset($_SESSION['authorNew']) && $_SESSION['authorNew'] == false) {
        $addNewArticleArray = ['newAuthor' => $_POST['newAuthor'],
            'newShort' => $_POST['newShort'],
            'newContent' => $_POST['newContent'],
            'newDate' => date("Y-m-d"),
            'newType' => $_POST['newType'],
            'newTitle' => $_POST['newTitle'],
            'newImage' => $_POST['newImage']];
        echo "<h3>Add new author as user " . $_POST['newAuthor'] . " </h3>";
        echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='POST'>
            <input type='password' id='pass' name='newPassword' required><label for='password'>New Password for a new author</label><br>
            <input type='submit' name='addNewUser' value='Add new user'>
            <input type='hidden' name='addNewUser' value='AddNewUser'>
            </form>";

    }
    $_SESSION['addNewArticleArray'] = $addNewArticleArray;
}

// If adding new author
if (isset($_POST['addNewUser'])) {
    $_SESSION['passIsTrue'] = true;
    mysqli_begin_transaction($articles);
    $arrayOfPass = array();
    $sqlSelectUserPass = 'SELECT pass FROM users;';
    $selectUserPass = mysqli_query($articles, $sqlSelectUserPass);
    while ($row = mysqli_fetch_array($selectUserPass)) {
        $arrayOfPass[] = $row;
    }
    // Check if new author pass is unique
    foreach ($arrayOfPass as $pass) {
        if ($pass['pass'] == $_POST['newPassword']) {
            $_SESSION['passIsTrue'] = false;
        }
    }
    // If not unique then type new password
    if (isset($_SESSION['passIsTrue']) && $_SESSION['passIsTrue'] == false) {
        echo "<h2>Type again password exist.</h2>";
        echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='POST'>
    <input type='password' id='pass' name='newPassword' required><label for='password'>New Password for a new author</label><br>
    <input type='submit' name='addNewUser' value='Add new user'>
    <input type='hidden' name='addNewUser' value='AddNewUser'>
    </form>";
    } elseif (isset($_SESSION['passIsTrue']) && $_SESSION['passIsTrue'] == true) {
        // If password unique then add to new article data session
        $_SESSION['addNewArticleArray']['newPassword'] = $_POST['newPassword'];
    }

    if (mysqli_errno($articles)) {
        mysqli_rollback($articles);
    }
    mysqli_commit($articles);

}

// If there is article data, there is need for creating new user and password is unique for new author
if (isset($_SESSION['addNewArticleArray']) &&
    isset($_SESSION['authorNew']) &&
    isset($_SESSION['passIsTrue']) &&
    $_SESSION['passIsTrue'] == true) {
    // First add new user so article could have foreign key
    mysqli_begin_transaction($articles);
    $sqlInsertUser = "INSERT INTO users (fullname, role, pass, access) "
        . " VALUES('" . $_SESSION['addNewArticleArray']['newAuthor'] . "', 'author', '" . $_SESSION['addNewArticleArray']['newPassword'] . "', true)";
    mysqli_query($articles, $sqlInsertUser);
    if (mysqli_errno($articles)) {
        print_r(mysqli_error($articles));
        mysqli_rollback($articles);
    }
    mysqli_commit($articles);
    // Then add new article
    mysqli_begin_transaction($articles);
    $sqlInsertArticle = "INSERT INTO articles (author, shortContent, content, publishDate, type, title, preview, user_id) "
        . " VALUES('" . $_SESSION['addNewArticleArray']['newAuthor'] . "',"
        . " '" . $_SESSION['addNewArticleArray']['newShort'] . "', "
        . " '" . $_SESSION['addNewArticleArray']['newContent'] . "', "
        . " '" . $_SESSION['addNewArticleArray']['newDate'] . "', "
        . " '" . $_SESSION['addNewArticleArray']['newType'] . "', "
        . " '" . $_SESSION['addNewArticleArray']['newTitle'] . "', "
        . " '" . $_SESSION['addNewArticleArray']['newImage'] . "', "
        . "(SELECT id FROM users WHERE fullname='" . $_SESSION['addNewArticleArray']['newAuthor'] . "'));";
    mysqli_query($articles, $sqlInsertArticle);
    if (mysqli_errno($articles)) {
        print_r(mysqli_error($articles));
        mysqli_rollback($articles);
    }
    // Unset everything that related with new user create and new article create
    mysqli_commit($articles);
    unset($_SESSION['shortContent']);
    unset($_SESSION['addNewArticleArray']);
    unset($_SESSION['authorNew']);
    unset($_SESSION['passIsTrue']);
    $addNewArticleArray = array();
    // Refresh articles inside view.php and go to view.php
    $publications = sendArticles($articles);
    header('Location: view.php');
    exit();

    // If only create new article with existing author or standart user
} elseif (isset($_SESSION['addNewArticleArray']) &&
    !isset($_SESSION['authorNew']) &&
    !isset($_SESSION['passIsTrue'])) {
    // Then add new article
    mysqli_begin_transaction($articles);
    $sqlInsertArticle = "INSERT INTO articles (author, shortContent, content, publishDate, type, title, preview, user_id) "
        . " VALUES('" . $_SESSION['addNewArticleArray']['newAuthor'] . "', "
        . " '" . $_SESSION['addNewArticleArray']['newShort'] . "', "
        . " '" . $_SESSION['addNewArticleArray']['newContent'] . "', "
        . " '" . $_SESSION['addNewArticleArray']['newDate'] . "', "
        . " '" . $_SESSION['addNewArticleArray']['newType'] . "', "
        . " '" . $_SESSION['addNewArticleArray']['newTitle'] . "', "
        . " '" . $_SESSION['addNewArticleArray']['newImage'] . "', "
        . "(SELECT id FROM users WHERE fullname='" . $_SESSION['addNewArticleArray']['newAuthor'] . "'));";
    mysqli_query($articles, $sqlInsertArticle);

    if (mysqli_errno($articles)) {
        print_r(mysqli_error($articles));
        mysqli_rollback($articles);
    }
    // Unset everything that related with new article create
    mysqli_commit($articles);
    unset($_SESSION['shortContent']);
    unset($_SESSION['addNewArticleArray']);
    unset($_SESSION['authorNew']);
    $addNewArticleArray = array();
    // Refresh articles inside view.php and go to view.php
    $publications = sendArticles($articles);
    header('Location: view.php');
    exit();

}

// If Go back to view.php cliked
if (isset($_POST['backArticle'])) {
    // Unset all data that was added to session inside dataNewArticle.php
    unset($_SESSION['addNewArticleArray']);
    unset($_SESSION['shortContent']);
    unset($_SESSION['authorNew']);
    unset($_SESSION['passIsTrue']);
    // Refresh articles inside view.php and go to view.php
    $addNewArticleArray = array();
    header('Location: view.php');
    exit();
}
