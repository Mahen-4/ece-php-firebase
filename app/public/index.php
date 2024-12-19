<?php 
require_once __DIR__.'/../vendor/autoload.php';

use Google\Cloud\Firestore\FirestoreClient;

if(isset($_GET['msg']) && $_GET['msg'] != ""){
    echo '<h5>Last Action : ' .$_GET['msg']. '</h5>';
}


$db = new FirestoreClient([
    'projectId' => 'ece-firebase',
]);


//get facture collection
$collectionReference = $db->collection('factures');

$sort = "number";
$order = "ASC";

if(isset($_GET['sort']) && $_GET['sort'] != ""  && isset($_GET['order']) && $_GET['order'] != ""){
    $sort = $_GET['sort'];
    $order = $_GET['order'];

    $query = $collectionReference->orderBy($sort, $order);

    //get all documents
    $documents = $query->documents();
    
    
}else{

    $query = $collectionReference->orderBy("number", "DESC");

    //get all documents
    $documents = $collectionReference->documents();
}
if(isset($_GET['search']) && $_GET['search'] != ""){

    $query = $collectionReference->where('ID', 'in', [$_GET['search']]);
    //get all documents
    $documents = $query->documents();
}


?>
<html>
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    </head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 1rem;
            font-family: Arial, sans-serif;
            text-align: left;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:nth-child(odd) {
            background-color: #ffffff;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
        /* Style des boutons */
        button {
            padding: 8px 12px;
            margin: 0 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
        }

        button:first-child {
            background-color: #4CAF50;
            color: white;
        }

        button:first-child:hover {
            background-color: #45a049;
        }

        button:last-child {
            background-color: #f44336;
            color: white;
        }

        button:last-child:hover {
            background-color: #d32f2f;
        }
    </style>
    <body>
        <div class="container">
            <a href="./add.php">GO ADD Facture</a>
            <form>
                <input type="text" id="myText" value="Mickey">
                <a href="index.php" onclick="this.href = this.href +'?search=' + document.getElementById('myText').value;">search</a>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th><a href="./index.php?sort=number&order=<?php echo $order == 'ASC' ? 'DESC' : 'ASC' ?>">Number</a></th>
                        <th><a href="./index.php?sort=status&order=<?php echo $order == 'ASC' ? 'DESC' : 'ASC' ?>">Status</a></th>
                        <th><a href="./index.php?sort=date&order=<?php echo $order == 'ASC' ? 'DESC' : 'ASC' ?>">Date</a></th>
                        <th>Actions</th>
                    </tr>    
                </thead>
                <tbody>
                    <?php
                    //loop trough the documents
                    foreach ($documents as $document) {
                        //if exist print ID of doc  //PHP_EOL -> PHP_EndOfLine 
                        if($document->exists()){
                            $date = new DateTime($document->data()["date"]);
                            $formattedDate = $date->format('d-m-Y H:i:s');
                            ?>
                            <tr>
                                <td><?php echo $document->id(); ?> </td>
                                <td><?php echo $document->data()["number"]; ?></td>
                                <td><?php echo $document->data()["status"]; ?></td>
                                <td><?php echo $formattedDate; ?></td>
                                <td><button><a href="./edit.php?id=<?php echo $document->id(); ?>">Edit</a></button><button><a href="./delete.php?id=<?php echo $document->id(); ?>">Delete</a></button></td>
                            </tr>                                                           
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
