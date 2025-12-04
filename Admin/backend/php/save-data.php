<?php
//////////////////////////////////////////////////////////////////////////////////////

include("./saveData.php");

$marque = html_entity_decode(htmlspecialchars($_POST['marque']));
$description = $_POST['description'];

// 1. Convert HTML special chars safely
$description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');

// 2. Preserve line breaks
$description = nl2br($description);

// 3. Preserve tabs & multiple spaces
$description = str_replace(
    ["\t", "  "],
    ["&nbsp;&nbsp;&nbsp;&nbsp;", "&nbsp;&nbsp;"],
    $description
);


/////////////////////////////////////////////////////////////////////////////////////////////////////////
// SEO friendly URL
$seo_f_url = html_entity_decode($marque);

// Replace any non-alphanumeric characters (except spaces and dashes) with nothing
// Step 1: Decode HTML entities
$seo_url1 = html_entity_decode($seo_f_url, ENT_QUOTES, 'UTF-8');
// Step 2: Convert accented characters to ASCII equivalents
$seo_url2 = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $seo_url1);
// Step 3: Remove quotes (straight and smart quotes)
$seo_url3 = preg_replace('/[\"\'“”‘’]+/u', '', $seo_url2);
// Step 4: Remove non-alphanumeric characters except spaces and dashes
$seo_url4 = preg_replace('/[^A-Za-z0-9\s-]/u', '', $seo_url3);
// Step 5: Replace spaces (and multiple dashes) with a single dash
$seo_url5 = preg_replace('/[\s\-]+/', '-', $seo_url4);
// Step 6: Convert to lowercase
$seo_url6 = mb_strtolower($seo_url5, 'UTF-8');
// Step 7: Trim dashes from beginning and end
$seo_url = trim($seo_url6, '-');

//////////////////////////////////////////////////////////////////////////////////////////////////////

$unique_id = rand(100000, 1000000);

// check if the fields are not empty
if (!empty($marque) && !empty($description)) {

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        // fetch the image file from the fom
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];

        // Get the file extension
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp']; // Allowed image types

        // Check file extension
        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
            die('Error: Only .jpg, .jpeg, .png, and .gif files are allowed.');
            echo 'Error: Only .jpg, .jpeg, .png, and .gif files are allowed.';
        }

        // Check if the file size is within limits (max 5MB here)
        if ($fileSize > 5 * 1024 * 1024) {
            die('Error: File size should be less than 5MB.');
            echo 'Error: File size should be less than 5MB.';
        }

        // Set the target directory where the image will be uploaded
        /* $uploadDir = '../uploads/'; // Make sure this folder is writable
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
        } */

        $uploadDir = '../../uploads/';

        // Call the function to convert the uploaded image to WebP before saving it
        /* $newFileName = uniqid() . '.webp'; // Unique name for the WebP image */
        $newFileName = $seo_url . '-' . $unique_id . '.jpeg';
        $save_seo_url = $seo_url . '-' . $unique_id;

        $outputFilePath = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $outputFilePath)) {
            $save = new saveData();
            $save->InsertData("{$unique_id}", "{$marque}", "{$description}", "{$newFileName}", "{$save_seo_url}");
        }
    }
} else {
    echo "Remplissez tous les champs s'il vous plaît!";
}
