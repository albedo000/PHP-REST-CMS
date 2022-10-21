<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();

$db = $database->connect();

$category = new Category($db);

$category->id = isset($_GET['id'])? $_GET['id'] : die();

$category->get_category();

$result_category = array(
    'id' => $category->id,
    'name' => $category->name,
    'created_at' => $category->created_ad
);

print_r(json_encode($result_category));
?>