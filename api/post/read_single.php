<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

require '../../vendor/autoload.php';

Predis\Autoloader::register();
$client = new Predis\Client();

$database = new Database();

$db = $database->connect();

$post = new Post($db);

$post->id = isset($_GET['id'])? $_GET['id'] : die();

if ($res = $client->get('Post-'. $post->id)) {
    print_r($res);
} else {
    $post->read_single();

    $result_post = array(
    'id' => $post->id,
    'title' => $post->title,
    'body' => $post->body,
    'author' => $post->author,
    'category_id' => $post->category_id,
    'category_name' => $post->category_name,
    'created_at' => $post->created_ad
    );

    $client->set('Post-'. $post->id, json_encode($result_post), 'EX', 120);
    print_r(json_encode($result_post));
}
?>