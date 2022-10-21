<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();

$db = $database->connect();

$category = new Category($db);

$result = $category->get_categories();

$row_numb = $result->rowCount();

if ($row_numb > 0) {
    $categories_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $category_item = array(
            'id' => $id,
            'name' => $name,
            'created_at' => $created_at
        );

        array_push($categories_arr, $category_item);
    }

    echo json_encode($categories_arr);
} else {
    echo json_encode(
        array('message' => 'No category found')
    );
}
?>