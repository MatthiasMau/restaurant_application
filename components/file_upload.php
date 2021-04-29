<?php 
    function file_upload($picture){
        $result = new stdClass();
        $result->fileName = 'avatar.jpg';
        $result->error = 1;
        $fileName = $picture['name'];
        $fileType = $picture['type'];
        $fileTmpName = $picture['tmp_name'];
        $fileError = $picture['error'];
        $fileSize = $picture['size'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $filesAllowed = ['png', 'jpg', 'jpeg', 'jfif'];
        if ($fileError == 4){
            $result->ErrorMessage = "No picture was chosen. It can be done later";
            return $result;
        } else {
            if (in_array($fileExtension, $filesAllowed)){
                if ($fileError === 0){
                    if ($fileSize < 500000){
                        $fileNewName = uniqid(''). "." . $fileExtension;
                        $destination = "pictures/$fileNewName";
                        if (move_uploaded_file($fileTmpName, $destination)){
                            $result->error = 0;
                            $result->fileName = $fileNewName;
                            return $result;
                        } else {
                            $result->ErrorMessage = "There was an error uploading";
                            return $result;
                            }
                        } else {
                            $result->ErrorMessage = "This picture is bigger than limit, choose smaller one";
                            return $result;
                            }
                        } else {
                            $result->ErrorMessage = "There was an error uploading, $fileError.";
                            return $result;
                            }
                        } else {
                            $result->ErrorMessage = "Wrong file type";
                            return $result;
                    }
                }
            }

?>