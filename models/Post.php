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

    public function read_single() {
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
        WHERE p.id = ?
        LIMIT 0,1';

        $statement = $this->conn->prepare($query);

        $statement->bindParam(1, $this->id);

        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
        $this->created_ad = $row['created_at'];
        
    }

    public function create_post() {
        $query = 'INSERT INTO '.
        $this->table . ' SET
        title = :title,
        body = :body,
        author = :author,
        category_id = :category_id';

        $statement = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        
        $statement->bindParam(':title', $this->title);
        $statement->bindParam(':body', $this->body);
        $statement->bindParam(':author', $this->author);
        $statement->bindParam(':category_id', $this->category_id);

        if ($statement->execute()) {
            return true;
        }

        printf('Error :%s \n', $statement->error);
        return false;
    }

}
?>