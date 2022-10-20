<?php
class Post {

    private $conn;
    private $table = 'posts';

    public $id;
    public $title;
    public $body;
    public $author;
    public $category_id;
    public $category_name;
    public $created_ad;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read() {
        $query = 'SELECT
        p.id,
        p.title,
        p.body,
        p.author,
        p.category_id,
        c.name AS category_name,
        p.created_at
        FROM '. $this->table .
        ' p LEFT JOIN categories c
        ON p.category_id = c.id
        ORDER BY
        p.created_at DESC';

        $statement = $this->conn->prepare($query);

        $statement->execute();

        return $statement;
    }

}
?>