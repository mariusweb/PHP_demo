<?php

session_start();
require 'classes.php';

$dataArray = array();
$newPublicationsDate = array();
$newPublications = array();
$shortPublications = array();
$photoPublications = array();

$articles = mysqli_connect('localhost', 'root', '', 'article');
if (mysqli_connect_errno()) {
    $errors = mysqli_connect_error();
}

// Function for geting all articles
function sendArticles($articles)
{

    $sql = 'SELECT id, author, shortContent, content, publishDate, type, title, preview, addDate FROM articles ORDER BY publishDate DESC, addDate DESC';

    $result = mysqli_query($articles, $sql);

    while ($row = mysqli_fetch_array($result)) {

        $dataArray[] = $row;
    }

    foreach ($dataArray as $article) {
        // Adding articles by type then by date

        if ($article['type'] == 'NewsArticle') {
            $newPublications[] = new $article['type']($article);
        }
        if ($article['type'] == 'ShortArticle') {
            $shortPublications[] = new $article['type']($article);
        }
        if ($article['type'] == 'PhotoArticle') {
            $photoPublications[] = new $article['type']($article);
        }

    }
    $_SESSION['dataArray'] = $dataArray;

    // Merge first NewsArticles second ShortArticles therd PhotoArticles
    $publications = array_merge($newPublications, $shortPublications, $photoPublications);
    return $publications;
}
// Array of sorted article objects that are used in view.php
$publications = sendArticles($articles);

// Starting selecting article topics and images
$sqlImage = 'SELECT article_id, images.image FROM images, articles WHERE images.article_id=articles.id';
$sqlTopic = 'SELECT articles.id, topics.topic FROM topics '
    . 'LEFT JOIN artocle_topics ON topics.id=artocle_topics.topic_id '
    . 'LEFT JOIN articles ON artocle_topics.article_id=articles.id';

$articleImages = mysqli_query($articles, $sqlImage);
$articleTopics = mysqli_query($articles, $sqlTopic);

// Array that is used in view.php
$imageArray = array();
$topicArray = array();

while ($rowImage = mysqli_fetch_array($articleImages)) {
    $imageArray[] = $rowImage;
}

while ($rowTopic = mysqli_fetch_array($articleTopics)) {
    $topicArray[] = $rowTopic;
}

// Login check
$isBlocked = true;
$userExist = true;
$userArray = array();
$userArrayForAdmin = array();

if (isset($_POST['loginForm']) || isset($_POST['refreshUserDelete'])) {
    $sqlLogin = "SELECT id, fullname, role, pass, access FROM users;";
    $loginUser = mysqli_query($articles, $sqlLogin);

    while ($rowUser = mysqli_fetch_array($loginUser)) {
        $userArrayForAdmin[] = $rowUser;
        if (isset($_POST['loginForm'])) {
            // If password and user name OK then get users all data
            if ($rowUser['pass'] == $_POST['pass'] && $rowUser['fullname'] == $_POST['userName']) {
                $userArray['pass'] = $rowUser['pass'];
                $userArray['fullname'] = $rowUser['fullname'];
                $userArray['role'] = $rowUser['role'];
                $userArray['access'] = $rowUser['access'];
                $userArray['id'] = $rowUser['id'];
            }
        }

    }

    if (isset($_POST['loginForm'])) {
        // Check if user exist
        if (empty($userArray)) {
            $userExist = false;
        }
        if (!empty($userArray) && $userArray['pass'] == $_POST['pass'] && $userArray['access'] != false) {
            // Add user data to session
            $_SESSION["logged_user"] = $userArray;
            $_SESSION["access"] = $userArray['access'];
            $_SESSION['logged_time'] = time();
        } elseif (!empty($userArray) && $userArray['access'] == false) {
            // Don't let user to login
            $isBlocked = false;
        }
    }
    // Add users to session for admin using
    if (isset($_SESSION["logged_user"]) && $_SESSION["logged_user"]['role'] == 'admin') {
        $_SESSION['adminUserControl'] = $userArrayForAdmin;
    }

    if (isset($_SESSION["logged_user"]) && $_SESSION["logged_user"]['role'] != 'admin') {
        unset($_SESSION['adminUserControl']);
    }
}

// User login only 15 min
if (isset($_SESSION['logged_time']) && (time() - $_SESSION['logged_time'] > 300) || isset($_POST['logoutForm'])) {

    session_unset();
    session_destroy();
}

// For adding comments
$sqlAddComment = "";
$sqlSelectComments = "";
$sqlDelete = "";
// If all articles selected and are inside session
if (isset($_SESSION['dataArray'])) {

    foreach ($_SESSION['dataArray'] as $article) {
        // If user loged and comment of article clicked insert
        if (isset($_POST[$article['id'] . "-comment"]) && isset($_SESSION["logged_user"])) {
            $textPost = $article['id'] . "-text";
            $sqlAddComment = "INSERT INTO comments (article_id, comment_area, user_id) "
                . " VALUES (" . $article['id'] . ", '" . $_POST[$textPost] . "', " . $_SESSION['logged_user']['id'] . ");";
            mysqli_query($articles, $sqlAddComment);
        }
        // If admin loged and delete button clicked delete article
        if (isset($_POST[$article['id'] . "-delete"])) {
            $sqlDelete = "DELETE articles, comments, images FROM articles
                LEFT JOIN comments ON articles.id=comments.article_id
                LEFT JOIN images ON articles.id=images.article_id
                WHERE articles.id=" . $article['id'] . ";";
            mysqli_query($articles, $sqlDelete);
            $publications = sendArticles($articles);
        }

    }
}

// Selecting comments for printing in view.php
$commentsArray = array();
$sqlSelectComments = "SELECT article_id, comment_area FROM comments";
$commentData = mysqli_query($articles, $sqlSelectComments);
while ($rowComment = mysqli_fetch_array($commentData)) {
    $commentsArray[] = $rowComment;
}

$adminUsersArray = array();

// Admin control querys
if (isset($_SESSION["logged_user"]['role']) && $_SESSION["logged_user"]['role'] == "admin" && isset($_SESSION['adminUserControl'])) {
    foreach ($_SESSION['adminUserControl'] as $value) {
        $adminUsersArray[] = new Admin($value);
        if (isset($_POST['block' . $value['id']])) {
            $sqlBlock = "UPDATE users SET access = false WHERE id = " . $value['id'] . ";";
            mysqli_query($articles, $sqlBlock);
            $publications = sendArticles($articles);
        }
        if (isset($_POST['unblock' . $value['id']])) {
            $sqlBlock = "UPDATE users SET access = true WHERE id = " . $value['id'] . ";";
            mysqli_query($articles, $sqlBlock);
            $publications = sendArticles($articles);
        }
        if (isset($_POST['deleteUser' . $value['id']])) {
            $sqlOnlyUser = "DELETE FROM users WHERE id = " . $value['id'] . ";";
            mysqli_query($articles, $sqlOnlyUser);
            $publications = sendArticles($articles);
        }
        if (isset($_POST['deleteUserCommets' . $value['id']])) {
            $sqlDeleteUserComments = "DELETE FROM comments WHERE user_id = " . $value['id'] . ";";
            mysqli_query($articles, $sqlDeleteUserComments);
            $publications = sendArticles($articles);
        }
        if (isset($_POST['deleteUserArticles' . $value['id']])) {
            $sqlDeleteUserArticles = "DELETE articles, images FROM articles
            LEFT JOIN images ON articles.id=images.article_id
            WHERE articles.user_id=" . $value['id'] . ";";
            mysqli_query($articles, $sqlDeleteUserArticles);
            $publications = sendArticles($articles);
        }
        if (isset($_POST['deleteUserEvrithing' . $value['id']])) {
            $sqlDeleteUserArticles = "DELETE articles, images FROM articles
            LEFT JOIN images ON articles.id=images.article_id
            WHERE articles.user_id=" . $value['id'] . ";";
            mysqli_query($articles, $sqlDeleteUserArticles);
            $sqlDeleteUserAll = "DELETE FROM users WHERE users.id=" . $value['id'] . ";";

            mysqli_query($articles, $sqlDeleteUserAll);
            $publications = sendArticles($articles);
        }
    }

}
