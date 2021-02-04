<?php

session_start();

$serverName = "localhost";
$serverUser = "root";
$serverPassword = "";
$dbName = "parduotuve";

$prekes = array(
    'Laisvalaikis' => array(
        'Powerbankas', 'Ausinės'
    ),
    'Maisto prekės' => array(
        'Šaldytos' => array(
            'Koldunai', 'Picos'
        ),
        'Šviežios' => array(
            'Kibinai', 'Submarinai'
        )
    ),
    'Statybinės' => array(
        'Cementas', 'Betonas'
    )
);
$asocGoods = [];
array_walk_recursive($prekes, function ($val) use (&$asocGoods) {
    $asocGoods[] = $val;
});

$klausimai = array(
    '1. Ar kokybiškos prekės?' => '1 - Visai nekokybiškos, 5 - Labai kokybiškos.',
    '2. Ar prekės atlieka savo funkcionaluma?' => '1 - Visai neatliko, 5 - Labai gerai atliko.',
    '3. Ar rekomenduotumėte elektroninę parduotuvę?' => '1 - Ne niekam nerekomenduočiau, 5 - Taip rekomenduočiau.',
    '4. Ar dažnai lankotes elektroninėje parduotuvėję?' => '1 - Visai nesilankau, 5 - Labai dažnai lankausi.',
    '5. Ar greitai pristatytomos prekės?' => '1 - Labai negreitai, 5 - Labai greitai.'
);




$userCookie = array();
if (isset($_COOKIE['vartotojas'])) {
    $cookie = $_COOKIE['vartotojas'];
    $cookie = stripslashes($cookie);
    $userCookie = json_decode($cookie, true);
} else {
    header('Location: prisijungimas.php');
    exit();
}
try {
    $connectionDb = new PDO("mysql:host=$serverName; dbname=$dbName", $serverUser, $serverPassword);
    $connectionDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

function testForm($questionsArr, $cookieArray, $connectionDb) {
    $onlyQuestionsArr = array_keys($questionsArr);
    $answers = array();
    if (!isset($_POST["testas"])) {
        session_unset();
        echo "<input type='submit' name='submit' value='Testas'><br>";
        echo "<input type='hidden' name='testas0' value='testas0'><br>";
        echo "<input type='hidden' name='testas' value='testas'><br>";
    } else {

        foreach ($onlyQuestionsArr as $key => $question) {
            if (isset($_POST["testas" . $key . ""])) {
                echo "<br><label for='radio'>$onlyQuestionsArr[$key]</label><br>"
                . "<br><label for='radio'>$questionsArr[$question]</label><br>"
                . "<input type='radio' name='radio' value='1' required> 1<br>"
                . "<input type='radio' name='radio' value='2'> 2<br>"
                . "<input type='radio' name='radio' value='3'> 3<br>"
                . "<input type='radio' name='radio' value='4'> 4<br>"
                . "<input type='radio' name='radio' value='5'> 5<br>";
                echo "<input type='submit' name='radioSubmit' value='Pateikti'>";
                $next = intval($key) + 1;
                echo "<input type='hidden' name='testas" . $next . "' value='testas" . $next . "'>";
                echo "<input type='hidden' name='testas' value='testas'><br>";
            }
        }
    }

    foreach ($onlyQuestionsArr as $key => $question) {
        $keyOfQuestion = $key + 1;
        if (isset($_POST["testas" . $keyOfQuestion . ""])) {
            if (isset($_POST['radio'])) {
                $_SESSION[$question] = $_POST['radio'];
            }
        }
        if (isset($_SESSION[$question])) {
            $answers[$question] = $_SESSION[$question];
        }
    }

    if (isset($_POST["testas5"])) {
        $avgAnswers = round((array_sum($answers) / count($answers)), 1);
        echo "Jūsų vidurkis yra $avgAnswers";
        try {

            $insertRatingData = $connectionDb->prepare("INSERT INTO vertinimas () "
                    . " VALUES((SELECT id FROM vartotojai WHERE id = :id), :avg)");
            $insertRatingData->bindValue(":id", $cookieArray['id'], PDO::PARAM_INT);
            $insertRatingData->bindValue(":avg", $avgAnswers, PDO::PARAM_STR);
            $insertRatingData->execute();
        } catch (PDOException $e) {
            echo "<br>" . $e->getMessage();
        }
        echo "<input type='submit' name='submit' value='Vidus'><br>";
        echo "<input type='hidden' name='gryzti' value='Vidus'><br>";
    }
}

class CheckArray {

    public function checkForArray($checkArray) {
        foreach ($checkArray as $value) {
            if (is_array($value)) {
                return 2;
            } else {
                return 0;
            }
        }
    }

    public function insertSubmitButtion($googs) {
        echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='POST'>";
        echo "<input type='submit' name='submit' value='Pirkti'><br>";
        echo "<input type='hidden' name='" . $googs . "' value='" . $googs . "'><br>";
        echo "<input type='hidden' name='iKrepseli' value='iKrepseli'><br>";
        echo "</form>";
    }

}

function shopping($goods, $cookieArray, $connectionDb) {
    $colspan = 0;
    $getTypesOfArray = new CheckArray();
    echo "<tr>";
    foreach ($goods as $goodsType => $goodsTypeArray) {
        $colspan = count($goodsTypeArray);
        $nuberOfArrays = $getTypesOfArray->checkForArray($goodsTypeArray);
        echo "<th colspan='" . ($colspan + $nuberOfArrays) . "'>";
        echo "$goodsType";
        echo "</th>";
    }
    echo "</tr>";
    echo "<tr>";
    foreach ($goods as $goodsType => $goodsTypeArray) {
        foreach ($goodsTypeArray as $goodsType1 => $typeGoods) {
            if (is_array($typeGoods)) {
                $colspan = count($typeGoods);
                echo "<th colspan='" . $colspan . "'>";
                echo "$goodsType1";
                echo "</th>";
            } else {
                echo "<td>";
                echo "$typeGoods";
                $getTypesOfArray->insertSubmitButtion($typeGoods);
                echo "</td>";
            }
        }
    }
    echo "</tr>";
    echo "<tr>";
    foreach ($goods as $goodsType => $goodsTypeArray) {
        foreach ($goodsTypeArray as $goodsType1 => $typeGoods) {
            if (is_array($typeGoods)) {
                foreach ($typeGoods as $justGoods) {
                    echo "<td>";
                    echo "$justGoods";
                    $getTypesOfArray->insertSubmitButtion($justGoods);
                    echo "</td>";
                }
            } else {
                echo "<td class='border-none' >";
                echo "</td>";
            }
        }
    }
    echo "</tr>";
}

function finishShopping($goodsOnly, $cookieArray, $connectionDb) {

    if (isset($_POST['iKrepseli'])) {
        foreach ($goodsOnly as $key => $good) {
            if (isset($_POST[$good])) {
                try {

                    $insertGoodsData = $connectionDb->prepare("INSERT INTO cart_userid () "
                            . " VALUES((SELECT id FROM vartotojai WHERE id = :id), :good)");
                    $insertGoodsData->bindValue(":id", $cookieArray['id'], PDO::PARAM_INT);
                    $insertGoodsData->bindValue(":good", $good, PDO::PARAM_STR);
                    $insertGoodsData->execute();
                } catch (PDOException $e) {
                    echo "<br>" . $e->getMessage();
                }
            }
        }

        echo "<input type='submit' name='submit' value='Baigti'><br>";
        echo "<input type='hidden' name='Baigti' value='Baigti'><br>";
    }
    if (isset($_POST['Baigti'])) {
        $selectShoppingCart = $connectionDb->prepare("SELECT preke FROM cart_userid "
                . " WHERE vartotojo_id = :id ");
        $selectShoppingCart->bindValue(":id", $cookieArray['id'], PDO::PARAM_INT);
        $selectShoppingCart->execute();
        $selectShoppingCart->setFetchMode(PDO::FETCH_ASSOC);
        $printGoods = $selectShoppingCart->fetchAll();
        if (!empty($printGoods)) {
            $arrayOfGoods = [];
            foreach ($printGoods as $row) {
                foreach ($row as $value) {
                    $arrayOfGoods[] = $value;
                }
            }
            $countGoods = array_count_values($arrayOfGoods);
            echo "<div>";
            foreach ($countGoods as $good => $quantity) {
                echo "<h3>Prekė $good, kiekis $quantity.</h3>";
            }
            echo "</div>";
            echo "<input type='submit' name='submit' value='Vidus'><br>";
            echo "<input type='hidden' name='gryzti1' value='Vidus'><br>";
            
        }
    }
    if (isset($_POST['gryzti1'])) {
        $deleteShoppingCart = $connectionDb->prepare("DELETE FROM cart_userid "
                . " WHERE vartotojo_id = :id ");
        $deleteShoppingCart->bindValue(":id", $cookieArray['id'], PDO::PARAM_INT);
        $deleteShoppingCart->execute();
    }
}
