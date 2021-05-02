<?php

 if($_SERVER['REQUEST_METHOD'] === "POST"){ 

    $data = array_map('trim', $_POST);
    $errors = [];
    
    $uploadDir = 'public/uploads/';
    $uploadFile = $uploadDir . basename($_FILES['imageUpload']['name']);

    $extension = pathinfo($_FILES['imageUpload']['name'], PATHINFO_EXTENSION);
    $extensions_allowed = ['jpg', 'webp', 'gif', 'png'];
    $maxFileSize = 100000;

     // Validation des champs du form
        if (empty($data['name'])) {
        $errors[] = 'Merci de rentrer votre nom !';
        }

        $lastnameLength = 20;
        if (strlen($data['name']) > $lastnameLength) {
        $errors[] = 'votre nom doit faire moins de ' . $lastnameLength . '  caractères';
        }

        if (empty($data['firstname'])) {
        $errors[] = 'Merci de rentrer votre prénom !';
        }

        $firstnameLength = 20;
        if (strlen($data['firstname']) > $firstnameLength) {
        $errors[] = 'votre prénom doit faire moins de ' . $firstnameLength . ' caractères';
        }

        if (empty($data['age'])) {
            $errors[] = 'Merci de rentrer votre âge !';
        }
    
        // Vérification Si l'extension est autorisée 
        if (!in_array($extension, $extensions_allowed)) {
        $errors[] = 'Veuillez sélectionner une image de type jpg, wepb, gif ou png !';
        }

        // On vérifie si l'image existe et si le poids est moins de 1MO 
        if (file_exists($_FILES['imageUpload']['tmp_name']) && filesize($_FILES['imageUpload']['tmp_name']) > $maxFileSize) {
        $errors[] = "Votre fichier doit faire moins de 1 M0 !";
        }
        
        if (empty($errors)){
            $fileName = uniqid() . $_FILES['imageUpload']['name'];
            move_uploaded_file($_FILES['imageUpload']['tmp_name'], $uploadFile);
        }
    }


        // bouton Delete permettant de supprimer le fichier avec fonction "unlink"
        if(isset($_POST['delete']) && !empty($_POST['delete'])){
            if( file_exists($_FILES['imageUpload']['tmp_name']) && filesize($_FILES['imageUpload']['tmp_name']) <= $maxFileSize)
            {
            
            unlink($_FILES['imageUpload']['tmp_name']);
            } else {
            echo $_POST['delete']." n'est pas possible car pas d'image téléchargée!";
            }

        var_dump($_FILES);
        }


    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>File upload</title>
    </head>
    <body>
            <form action="" method="post" enctype="multipart/form-data">

                <?php if (!empty($errors)) : ?>
                <ul class="error">
                    <?php foreach ($errors as $error) : ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>

            <div>
                <label for="name">Nom :</label>
                <input type="text" id="name" name="name" value = " " required>
            </div>
            <div>
                <label for="firstname">Prénom :</label>
                <input type="text" id="firstname" name="firstname" value = " " required>
            </div>
            <div>
                <label for="age">Age :</label>
                <input type="text" id="age" name="age" value = " "  required>
            </div>
            <label for="imageUpload">Choisis une photo de profil: </label>
            <input type="file" name="imageUpload" id="imageUpload">

            <button name="send">Envoyer</button>
            <input type="submit" name="delete" id="delete" value="supprimer">  
        </form>
    </body>
</html>
