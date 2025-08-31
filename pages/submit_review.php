<?php
include '../db/db_connect.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $product_id = intval($_POST['product_id']);
    $user_name = $conn->real_escape_string($_POST['user_name']);
    $rating = intval($_POST['rating']);
    $review_text = $conn->real_escape_string($_POST['review_text']);
    $review_image = null;

    // Handle image upload
    if(isset($_FILES['review_image']) && $_FILES['review_image']['error'] == 0){
        $ext = pathinfo($_FILES['review_image']['name'], PATHINFO_EXTENSION);
        $filename = 'uploads/review_'.time().'.'.$ext;
        move_uploaded_file($_FILES['review_image']['tmp_name'], '../'.$filename);
        $review_image = $filename;
    }

    $sql = "INSERT INTO reviews (product_id, user_name, rating, review_text, review_image) 
            VALUES ($product_id, '$user_name', $rating, '$review_text', ".($review_image ? "'$review_image'" : "NULL").")";

    if($conn->query($sql)){
        header("Location: product_detail.php?id=$product_id");
        exit;
    } else {
        echo "Error submitting review: " . $conn->error;
    }
}
?>
