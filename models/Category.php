<?php
Class Category {

    private $conn;
    private $table = 'categories';

    public $id;
    public $name;
    public $created_ad;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function get_categories() {
        $query = 'SELECT * FROM '
        . $this->table;

        $statement = $this->conn->prepare($query);

        $statement->execute();
        
        return $statement;
    }

    public function get_category() {
        $query = 'SELECT * FROM '
        . $this->table .
        ' WHERE id = :id';

        $statement = $this->conn->prepare($query);
        
        $statement->bindParam(':id', $this->id);

        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
        $this->created_ad = $row['created_at'];
    }

    public function create_category() {
        $query = 'INSERT INTO '
        . $this->table .
        ' SET 
        name = :name';

        $statement = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));

        $statement->bindParam(':name', $this->name);

        if ($statement->execute()) {
            return true;
        }

        printf('Error :%s \n', $statement->error);
        return false;
    }

    public function edit_category() {
        $query = 'UPDATE '
        . $this->table .
        ' SET 
        name = :name
        WHERE id = :id';

        $statement = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));

        $statement->bindParam(':id', $this->id);
        $statement->bindParam(':name', $this->name);

        if ($statement->execute()) {
            return true;
        }

        printf('Error :%s \n', $statement->error);
        return false;
    }

    public function delete_category() {
        $query = 'DELETE FROM '
        . $this->table .
        ' WHERE id = :id';

        $statement = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $statement->bindParam(':id', $this->id);

        if ($statement->execute()) {
            return true;
        }

        printf('Error :%s \n', $statement->error);
        return false;
    }
}
?>