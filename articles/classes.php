<?php

class Article
{
    // For article
    protected $id;
    protected $author;
    protected $shortContent;
    protected $content;
    protected $publishDate;
    protected $type;
    protected $title;
    protected $date;
    protected $image;
    // For all images article
    protected $idArticleImages;
    protected $articleImage;
    // For topics
    protected $topicId;
    protected $topic;
    // For user status
    protected $role;
    protected $userName;
    // For counting comments
    private $commentNumber = 0;

    // For article
    public function __construct($row)
    {
        $this->id = $row['id'];
        $this->author = $row['author'];
        $this->content = $row['content'];
        $this->publishDate = $row['publishDate'];
        $this->shortContent = $row['shortContent'];
        $this->type = $row['type'];
        $this->title = $row['title'];
        $this->date = $row['addDate'];
        $this->image = $row['preview'];
    }
    // For showing where comments start
    public function printCommentTitle()
    {
        if (isset($_GET['name']) && $_GET['name'] == "info" . $this->id) {
            echo "<h4>Comments</h4>";
        }
    }

    public function commentButton($userRow)
    {
        $this->userName = $userRow['fullname'];
        $this->role = $userRow['role'];
        if (!isset($_GET['name'])) {
            // If Admin print delete button next to articles in main page
            if ($this->role == "admin") {
                echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='POST'>"
                . "<input type='submit' name='submit' value='Delete'><br>"
                . "<input type='hidden' name='" . $this->userName . "' value='delete'><br>"
                . "<input type='hidden' name='" . $this->id . "-delete' value='delete'><br>"
                    . "</form>";
            }
        } elseif (isset($_GET['name']) && $_GET['name'] == "info" . $this->id) {
            if ($this->role == "author" || $this->role == "standart") {
                // If user is author or standart and comment button is cliked then show textarea whit send button
                if (isset($_POST[$this->id . "-startComment"]) && !isset($_POST[$this->id . "-comment"])) {
                    echo "<form action='" . $_SERVER['PHP_SELF'] . "?name=info" . $this->id . "' method='POST'>"
                    . "<textarea name='" . $this->id . "-text' ></textarea>"
                    . "<input type='submit' name='submit' value='Siųsti'><br>"
                    . "<input type='hidden' name='" . $this->id . "-comment' value='submitComment'><br>"
                        . "</form>";
                }
                // If loged user is author and article author name is the same then don't print comment button
                // if not admin print comment button
                if ($this->userName !== $this->author) {
                    echo "<form action='" . $_SERVER['PHP_SELF'] . "?name=info" . $this->id . "' method='POST'>"
                    . "<input type='submit' name='submit' value='Comment'><br>"
                    . "<input type='hidden' name='" . $this->userName . "' value='commentButton'><br>"
                    . "<input type='hidden' name='" . $this->id . "-startComment' value='commentButton'><br>"
                        . "</form>";
                }
                // If user is admin then print Delete inside article info page
            } elseif ($this->role == "admin") {
                echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='POST'>"
                . "<input type='submit' name='submit' value='Delete'><br>"
                . "<input type='hidden' name='" . $this->userName . "' value='delete'><br>"
                . "<input type='hidden' name='" . $this->id . "-delete' value='delete'><br>"
                    . "</form>";
            }
        }
    }
    // To go back when to articles when in print image page
    public function printImagesBack()
    {
        if (isset($_GET['name']) && $_GET['name'] == "img" . $this->id) {
            echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='POST'>"
                . "<input type='submit' name='submit' value='Go back'><br>"
                . "</form>";
        }
    }
    public function printComment($commentsRow)
    {
        // Count comments
        if ($commentsRow['article_id'] == $this->id) {
            $this->commentNumber += 1;
        }
        // Print comments when article info href is clicked
        if (isset($_GET['name']) && $_GET['name'] == "info" . $this->id) {
            if ($commentsRow['article_id'] == $this->id) {
                echo "<p>" . $commentsRow['comment_area'] . "</p>";
            }
        }
    }
    // Print comment number
    public function printCommentNumber()
    {
        if (!isset($_GET['name'])) {
            echo "<p>" . $this->commentNumber . " comments</p>";
        }

    }

}

class NewsArticle extends Article
{
    // Print links to images and info pages of every article
    public function link()
    {
        // If link not cliked then print
        if (!isset($_GET['name'])) {
            echo "<br><a href='" . $_SERVER['PHP_SELF'] . "?name=info" . $this->id . "'>Info</a>";
            echo "<br><a href='" . $_SERVER['PHP_SELF'] . "?name=img" . $this->id . "'>Images</a>";

        }
    }
    // Print articles
    public function printArticle()
    {
        // Print if not clicked info href
        if (!isset($_GET['name'])) {
            echo '<hr>';
            echo "<h2>" . $this->title . "</h2>";
            echo "<h4>Updated: " . $this->date . "</h4>";
            echo "<p>" . $this->type . "</p>";
            echo "<h4>" . $this->author . "</h4>";
            echo "<p>" . $this->content . "</p>";
            // Print if clicked info href
        } elseif (isset($_GET['name']) && $_GET['name'] == "info" . $this->id) {
            echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='POST'>"
                . "<input type='submit' name='submit' value='Go back'><br>"
                . "</form>";
            echo "<h2>" . $this->title . "</h2>";
            echo "<h4>Updated: " . $this->date . "</h4>";
            echo "<p>" . $this->type . "</p>";
            echo "<h4>" . $this->author . "</h4>";
            echo "<img src='" . $this->image . "' >";
            echo "<p>" . $this->content . "</p>";
        }

    }
    // Print if clicked images href
    public function printImages($imageRow)
    {

        if (isset($_GET['name']) && $_GET['name'] == "img" . $this->id || isset($_GET['name']) && $_GET['name'] == "info" . $this->id) {
            $this->idArticleImages = $imageRow['article_id'];
            $this->articleImage = $imageRow['image'];
            if ($this->idArticleImages == $this->id) {
                echo "<br><img src='" . $this->articleImage . "' alt='" . $this->title . "' width='200' height='200'>";
            }
        }
    }
// Print topics if clicked info href
    public function printTopics($topicRow)
    {
        if (isset($_GET['name']) && $_GET['name'] == "info" . $this->id) {
            $this->topic = $topicRow['topic'];
            $this->topicId = $topicRow['id'];
            if ($this->topicId == $this->id) {
                echo "<h5>" . $this->topic . "</h5>";
            }
        }
    }

}

class ShortArticle extends Article
{

    // Print links to images and info pages of every article
    public function link()
    {
        // If link not cliked then print
        if (!isset($_GET['name'])) {
            echo "<br><a href='" . $_SERVER['PHP_SELF'] . "?name=info" . $this->id . "'>Info</a>";
            echo "<br><a href='" . $_SERVER['PHP_SELF'] . "?name=img" . $this->id . "'>Images</a>";

        }
    }
// Print articles
    public function printArticle()
    {
        // Print if not clicked info href
        if (!isset($_GET['name'])) {
            echo '<hr>';
            echo "<h2>" . $this->title . "</h2>";
            echo "<h4>Updated: " . $this->date . "</h4>";
            echo "<p>" . $this->type . "</p>";
            echo "<h4>" . $this->author . "</h4>";
            echo "<p>" . $this->shortContent . "</p>";
            // Print if clicked info href
        } elseif (isset($_GET['name']) && $_GET['name'] == "info" . $this->id) {
            echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='POST'>"
                . "<input type='submit' name='submit' value='Go back'><br>"
                . "</form>";
            echo "<h2>" . $this->title . "</h2>";
            echo "<h4>Updated: " . $this->date . "</h4>";
            echo "<p>" . $this->type . "</p>";
            echo "<h4>" . $this->author . "</h4>";
            echo "<img src='" . $this->image . "' >";
            echo "<p>" . $this->content . "</p>";
        }
    }
// Print if clicked images href
    public function printImages($imageRow)
    {
        if (isset($_GET['name']) && $_GET['name'] == "img" . $this->id || isset($_GET['name']) && $_GET['name'] == "info" . $this->id) {
            $this->idArticleImages = $imageRow['article_id'];
            $this->articleImage = $imageRow['image'];
            if ($this->idArticleImages == $this->id) {
                echo "<br><img src='" . $this->articleImage . "' alt='" . $this->title . "' width='200' height='200'>";
            }
        }
    }
// Print topics if clicked info href
    public function printTopics($topicRow)
    {
        if (isset($_GET['name']) && $_GET['name'] == "info" . $this->id) {
            $this->topic = $topicRow['topic'];
            $this->topicId = $topicRow['id'];
            if ($this->topicId == $this->id) {
                echo "<h5>" . $this->topic . "</h5>";
            }
        }
    }

}

class PhotoArticle extends Article
{

    // Print links to images and info pages of every article
    public function link()
    {
        // If link not cliked then print
        if (!isset($_GET['name'])) {
            echo "<br><a href='" . $_SERVER['PHP_SELF'] . "?name=info" . $this->id . "'>Info</a>";
            echo "<br><a href='" . $_SERVER['PHP_SELF'] . "?name=img" . $this->id . "'>Images</a>";

        }
    }
// Print articles
    public function printArticle()
    {
        // Print if not clicked info href
        if (!isset($_GET['name'])) {
            echo '<hr>';
            echo "<h2>" . $this->title . "</h2>";
            echo "<h4>Updated: " . $this->date . "</h4>";
            echo "<p>" . $this->type . "</p>";
            echo "<h4>" . $this->author . "</h4>";
            echo "<br>" . $this->publishDate;
            echo "<br><img src='" . $this->image . "' alt='" . $this->title . "' width='200' height='200'>";
            // Print if clicked info href
        } elseif (isset($_GET['name']) && $_GET['name'] == "info" . $this->id) {
            echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='POST'>"
                . "<input type='submit' name='submit' value='Go back'><br>"
                . "</form>";
            echo "<h2>" . $this->title . "</h2>";
            echo "<h4>Updated: " . $this->date . "</h4>";
            echo "<p>" . $this->type . "</p>";
            echo "<h4>" . $this->author . "</h4>";
            echo "<img src='" . $this->image . "' >";
            echo "<p>" . $this->content . "</p>";
        }
    }
// Print if clicked images href
    public function printImages($imageRow)
    {
        if (isset($_GET['name']) && $_GET['name'] == "img" . $this->id || isset($_GET['name']) && $_GET['name'] == "info" . $this->id) {
            $this->idArticleImages = $imageRow['article_id'];
            $this->articleImage = $imageRow['image'];
            if ($this->idArticleImages == $this->id) {
                echo "<br><img src='" . $this->articleImage . "' alt='" . $this->title . "' width='200' height='200'>";
            }
        }
    }
// Print topics if clicked info href
    public function printTopics($topicRow)
    {
        if (isset($_GET['name']) && $_GET['name'] == "info" . $this->id) {
            $this->topic = $topicRow['topic'];
            $this->topicId = $topicRow['id'];
            if ($this->topicId == $this->id) {
                echo "<h5>" . $this->topic . "</h5>";
            }
        }
    }

}
// Class for controling users as admin
class Admin
{
    private $userFullName;
    private $userId;
    private $userPass;
    private $userRole;
    private $access;
    public function __construct($usersTable)
    {
        $this->userFullName = $usersTable['fullname'];
        $this->userId = $usersTable['id'];
        $this->userPass = $usersTable['pass'];
        $this->userRole = $usersTable['role'];
        $this->access = $usersTable['access'];
    }
    // If control panel clicked open all users
    public function usersList()
    {
        // All users href exept admin
        if (isset($_GET["name"]) && $_GET["name"] == "controladmin") {
            if ($this->userRole !== 'admin') {
                echo "<br><a href='" . $_SERVER['PHP_SELF'] . "?user=id" . $this->userId . "'>" . $this->userFullName . "</a>";
            }

        }
        // Buttons for clicked user href control
        if (isset($_GET["user"]) && $_GET["user"] == "id" . $this->userId) {
            echo "<h3>$this->userFullName</h3>";

            echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='POST'>"
            . "<input type='submit' name='submit' value='Block user'><br>"
            . "<input type='hidden' name='block" . $this->userId . "' value='block'><br>"
                . "</form>";
            echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='POST'>"
            . "<input type='submit' name='submit' value='Unblock user'><br>"
            . "<input type='hidden' name='unblock" . $this->userId . "' value='block'><br>"
                . "</form>";
            echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='POST'>"
            . "<input type='submit' name='submit' value='Delete only user'><br>"
            . "<input type='hidden' name='deleteUser" . $this->userId . "' value='deleteUser'><br>"
                . "</form>";
            echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='POST'>"
            . "<input type='submit' name='submit' value='Delete user comments'><br>"
            . "<input type='hidden' name='deleteUserCommets" . $this->userId . "' value='deleteUserCommets'><br>"
                . "</form>";
            echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='POST'>"
            . "<input type='submit' name='submit' value='Delete user articles'><br>"
            . "<input type='hidden' name='deleteUserArticles" . $this->userId . "' value='deleteUserArticles'><br>"
                . "<input type='hidden' name='refreshUserDelete' value='deleteUserEvrithing'><br>"
                . "</form>";
            echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='POST'>"
            . "<input type='submit' name='submit' value='Delete user with user articles, comments'><br>"
            . "<input type='hidden' name='deleteUserEvrithing" . $this->userId . "' value='deleteUserEvrithing'><br>"
                . "<input type='hidden' name='refreshUserDelete' value='deleteUserEvrithing'><br>"
                . "</form>";
        }
    }
}
