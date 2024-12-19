<?php 
require_once __DIR__.'/../vendor/autoload.php';

use Google\Cloud\Firestore\FirestoreClient;


if(isset($_GET['id']) && $_GET['id'] != ""){

    $db = new FirestoreClient([
        'projectId' => 'ece-firebase',
    ]); 

    $docRef = $db->collection('factures')->document($_GET['id']);
    $snapshot = $docRef->snapshot();

    if ($snapshot->exists()) {
        $facture_number = $snapshot->data()["number"];
        $facture_status = $snapshot->data()["status"];
    } else {
        echo "Doc INVALID";
    }

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
        
            $db->collection('factures')->document($_GET['id'])->set($data);
    
            header('Location: index.php?msg=Facture Edited');
        }
    
        
    }
}





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit facture PHP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>
<body>
    <div class="container">
        <h1>Editer une Facture</h1>
        <form method="POST">
            <input type="number" name="number" placeholder="Number" aria-label="Number" value="<?php echo $facture_number;?>">
            <select name="status" aria-label="Select your favorite cuisine..." required>
                <option disabled value="">
                    Select status...
                </option>
                <option <?php echo $facture_status == "A payer" ? "selected" : "" ?> value="A payer">A payer</option>
                <option value="Payé" <?php echo $facture_status == "Payé" ? "selected" : "" ?>>Payé</option>
            </select>
            <input type="submit" value="Editer"/>
            <a href="./index.php">Retour</a>
        </form>
    </div>
</body>
</html>