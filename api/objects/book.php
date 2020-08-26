<?php 
class Book{
    // Database connection and table name
    private $conn; 
    private $table_name = "books"; 

    // Object properties
    public $id; 
    public $subject_id; 
    public $book_desc;
    public $grade_level; 

    // Constuctor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db; 
    }

    // Create 
    public function create() 
    {
        // Query to insert 
        $query = "INSERT INTO 
                " . $this->table_name . "
                SET 
                    subject_id=:subject_id, book_desc=:book_desc, grade_level=:grade_level"; 
        
        // Prepare 
        $stmt = $this->conn->prepare($query); 

        // Santize 
        $this->subject_id = htmlspecialchars(strip_tags($this->subject_id)); 
        $this->book_desc = htmlspecialchars(strip_tags($this->book_desc)); 
        $this->grade_level = htmlspecialchars(strip_tags($this->grade_level)); 
        
        // Bind 
        $stmt->bindParam(':subject_id', $this->subject_id); 
        $stmt->bindParam(':book_desc', $this->book_desc); 
        $stmt->bindParam(':grade_level', $this->grade_level); 

        // Execute 
        if($stmt->execute())
            return true; 

        return false; 
    }

    // Read (All books)
    public function read()
    {
        // Query to read 
        $query = "SELECT 
                    id, subject_id, book_desc, grade_level
                FROM " . $this->table_name . ""; 

        // Prepare 
        $stmt = $this->conn->prepare($query); 

        // Execute 
        $stmt->execute(); 

        return $stmt; 
    }
}
?> 