<?php

require_once '_connec.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = array_map('trim', $_POST);
    $errors = [];

    if(!isset($data['firstname']) || empty($data['firstname']))
        $errors[] = 'Le prénom est obligatoire';

    if(!isset($data['lastname']) || empty($data['lastname']))
        $errors[] = 'Le nom est obligatoire';
    
    if(count($errors) === 0) {
        $pdo = new PDO(DSN, USER, PASS);

        $query = "INSERT INTO friend (firstname, lastname)
        VALUES (:firstname, :lastname);";

        $statement = $pdo->prepare($query);
        $statement->bindValue(':firstname', $data['firstname'], PDO::PARAM_STR);
        $statement->bindValue(':lastname', $data['lastname'], PDO::PARAM_STR);
        $statement->execute();

        header('Location: index.php');
        die();
    } 
    var_dump($errors);
}

$pdo = new \PDO(DSN, USER, PASS);

$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends</title>
</head>

<body>
<h1>Mes potos</h1>

<form method="post">
    <p>
        <label for="firstname">Prénom : </label>
        <input type="text" name="firstname" id="firstname">
    </p>

    <p>
        <label for="lastname">Nom : </label>
        <input type="text" name="lastname" id="lastname">
    </p>

    <p>
        <input type="submit" value="Ajoute ton ami !">
    </p>
</form>

<h1>Liste de mes vrais amis</h1>

<ul>
<?php
    foreach($friends as $friend) {
        echo '<li>'. $friend['firstname']. ' '. $friend['lastname'].'</li>';
    }
?>
</ul>
</body>

</html>