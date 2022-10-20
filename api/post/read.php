<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

$database = new Database();

$db = $database->connect();

$post = new Post($db);

$result = $post->read();

$row_numb = $result->rowCount();

if ($row_numb > 0) {
    $post_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name,
            'created_at' => $created_at
        );

        array_push($post_arr, $post_item);
    }

    echo json_encode($post_arr);
} else {
    echo json_encode(
        array('message' => 'No post found')
    );
}
?>