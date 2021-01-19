<?php

$serverName = "localhost";
$serverUser = "root";
$serverPassword = "";
$dbName = "parduotuve";
$errors = array();

if (isset($_POST['prisijungimoForm'])) {
    $user = array();
    $slaptazodis = $_POST['password'];
    $vardas = $_POST['vartotojoVardas'];
    try {
        $connectionDb = new PDO("mysql:host=$serverName; dbname=$dbName", $serverUser, $serverPassword);
        $connectionDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $seleckUsers = $connectionDb->prepare("SELECT id, vardas, pavarde, slaptazodis FROM vartotojai "
                . " WHERE vardas = :vardas "
                . " AND slaptazodis = SHA1( :slaptazodis ) LIMIT 1;");
        $seleckUsers->bindValue(":vardas", $vardas, PDO::PARAM_STR);
        $seleckUsers->bindValue(":slaptazodis", $slaptazodis, PDO::PARAM_STR);
        $seleckUsers->execute();
        $seleckUsers->setFetchMode(PDO::FETCH_ASSOC);
        $printUsers = $seleckUsers->fetchAll();
        if (!empty($printUsers)) {
            foreach ($printUsers as $row) {
                if ($row['vardas'] === $_POST['vartotojoVardas'] && $row['slaptazodis'] === sha1($_POST['password'])) {
                    $user['id'] = $row['id'];
                    $user['vardas'] = $row['vardas'];
                    $user['pavarde'] = $row['pavarde'];
                } elseif ($row['vardas'] !== $_POST['vartotojoVardas']) {
                    
                } elseif ($row['slaptazodis'] !== sha1($_POST['password'])) {
                    array_push($errors, "Neteisingas slaptažodis.");
                }
            }
        }else{
            array_push($errors, "Neteisingas vartotojo vardas arba slaptažodis.");
        }
        if (!empty($user)) {
            echo "Sucssess";
            $userJson = json_encode($user);
            setcookie('vartotojas', $userJson, time() + 60 * 60 * 4);
            header('Location: vidus.php');
            exit();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


