<?php 

require_once 'models/Order.php';
require_once 'models/OrderManager.php';

require_once 'models/Tea.php';
require_once 'models/TeaManager.php';

class AdminController {    
    
    public function __construct()
    {
        if (!empty($_POST) && isset($_POST['orderId'])) {
            $this->updateStatus($_POST['orderId'], $_POST['status']);
        }
    }


    public function display() {
        $manager = new OrderManager();
        $orders = $manager->getAllOrders();
        
        $teaManager = new TeaManager();
        $teas = $teaManager->getAllTeas();
        $cats = $teaManager->getAllCategories();

        $template = "admin.phtml";
        require_once "views/layout.phtml";
    }


    public function updateStatus($orderId, $status){
        $manager = new OrderManager();
        // $status = $manager
    }

    /* ADD TEA */
    public function addTea($ref, $name, $subtitle, $description, $target_file, $cat, $stock, $isFavorite, $formatPrices, $formatConditionings) {

        $teaManager = new TeaManager();
        $success = $teaManager->addTea($ref, $name, $subtitle, $description, $target_file, $cat, $stock, $isFavorite, $formatPrices, $formatConditionings);

        return $success;




// $target_dir = "uploads/"; // Assurez-vous que ce dossier existe et est accessible en écriture.
// $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
// $uploadOk = 1;
// $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Vérifiez si le fichier est une image réelle ou une fausse image
// if(isset($_POST["submit"])) {
//     $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
//     if($check !== false) {
//         echo "Le fichier est une image - " . $check["mime"] . ".";
//         $uploadOk = 1;
//     } else {
//         echo "Le fichier n'est pas une image.";
//         $uploadOk = 0;
//     }
// }

// // Vérifiez si le fichier existe déjà
// if (file_exists($target_file)) {
//     echo "Désolé, le fichier existe déjà.";
//     $uploadOk = 0;
// }

// Vérifiez la taille du fichier
// if ($_FILES["fileToUpload"]["size"] > 500000) { // 500 KB pour cet exemple
//     echo "Désolé, votre fichier est trop volumineux.";
//     $uploadOk = 0;
// }

// Autoriser certains formats de fichier
// if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
// && $imageFileType != "gif" ) {
//     echo "Désolé, seuls les fichiers JPG, JPEG, PNG & GIF sont autorisés.";
//     $uploadOk = 0;
// }

// Vérifiez si $uploadOk est défini sur 0 par une erreur
// if ($uploadOk == 0) {
//     echo "Désolé, votre fichier n'a pas été téléchargé.";
// // si tout est ok, essayez de télécharger le fichier
// } else {
    // if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        // echo "Le fichier ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " a été téléchargé.";

        // Ici, ajoutez le code pour enregistrer le chemin du fichier dans votre base de données.
        // $filePath = $target_file; // Chemin à enregistrer dans la base de données.

    // } else {
    //     echo "Désolé, il y a eu une erreur lors du téléchargement de votre fichier.";
    // }



        // Redirect or display a success message

    }

    public function addFormat($teaId, $price, $conditioning) {

        $teaManager = new TeaManager();
        $error = $teaManager->addFormat($teaId, $price, $conditioning);

        return $error;
    }

}
