<?php
function upload_img($img)
{
    $targetDir = '../upload/';
    $imageFileType = strtolower(pathinfo($img["name"], PATHINFO_EXTENSION));
    $file_name = time() . '.' . $imageFileType;
    // Check if image file is a actual image or fake image
    $check = getimagesize($img["tmp_name"]);
    if ($check === false) {
        http_response_code(400);
        echo json_encode(["message" => "File is not an image"]);
        return false;
    } else {
        $val_type = ["jpg", "jpeg", "png", "gif"];
        if (in_array($imageFileType, $val_type)) { // check if img is supported
            if (!move_uploaded_file($img["tmp_name"], $targetDir . $file_name)) {
                http_response_code(400);
                echo json_encode(["message" => "Sorry there was an error uploading your file"]);
                return false;
            } else {
                return true;
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed."]);
            return false;
        }
    }
}