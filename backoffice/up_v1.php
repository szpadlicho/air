<?php
    public function fileUpload()
    {
        $target_dir = 'data/';
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $fileCount = count(@$_FILES['img']['tmp_name']);
        for ($i=0; $i<$fileCount; $i++) {
            $target_file = $target_dir . basename(@$_FILES['img']['name'][$i]);
            $file_name = basename(@$_FILES['img']['name'][$i]);
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            $target_file_id = $target_dir . $this->__getNextId().".".$imageFileType;
            $uploadOk = 1;
            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES['img']['tmp_name'][$i]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["img"]["size"][$i] > 5000000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["img"]["tmp_name"][$i], $target_file_id)) {
                    echo "  The file ". basename( $_FILES["img"]["name"][$i]). " has been uploaded.";
                    echo '<br />';
                    //var_dump ($check);
                    //echo '<br />';
                    //var_dump ($imageFileType);
                    $this->addRec($file_name, $imageFileType, $_FILES["img"]["size"][$i]);
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    }