<?php 
require_once __DIR__.'/../vendor/autoload.php';

use Google\Cloud\Firestore\FirestoreClient;


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST["number"]) && isset($_POST["status"]) && $_POST["status"] != "")
    {
        $db = new FirestoreClient([
            'projectId' => 'ece-firebase',
        ]); 
    
        $data = [
            'number' => $_POST["number"],
            'status' => $_POST["status"],
            'date' =>  date('d-m-Y H:i:s')
        ];
    
        $addedDocRef = $db->collection('factures')->add($data);

        header('Location: index.php?msg=Facture Added');
    }

    
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add facture PHP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>
<body>
    <div class="container">
        <h1>Ajouter une Facture</h1>
        <form method="POST">
            <input type="number" name="number" placeholder="Number" aria-label="Number">
            <select name="status" aria-label="Select your favorite cuisine..." required>
                <option selected disabled value="">
                    Select status...
                </option>
                <option value="A payer">A payer</option>
                <option value="Payé">Payé</option>
            </select>
            <input type="submit" value="Ajouter"/>
            <a href="./index.php">Retour</a>
        </form>
    </div>
</body>
</html>