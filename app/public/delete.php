<?php 
require_once __DIR__.'/../vendor/autoload.php';

use Google\Cloud\Firestore\FirestoreClient;


if(isset($_GET['id']) && $_GET['id'] != ""){
    $db = new FirestoreClient([
        'projectId' => 'ece-firebase',
    ]);

    $db->collection('factures')->document($_GET['id'])->delete();

    echo $_GET['id'] . "Successfully deleted";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Facture PHP</title>
</head>
<body>
   
</body>
</html>