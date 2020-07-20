<?php 

class Subject{
    // Database connection and table name 

    private $conn; 
    private $table_name = "subjects";
    // Object properties 
    public $id; 
    public $subject_desc; 

    // Constuctor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db; 
    }

    // Create 
    function create()
    {
        // Query to insert 
        $query = "INSERT INTO 
                    ". $this->table_name."
                SET
                    subject_desc=:subject_desc"; 
        $stmt = $this->conn->prepare($query); 
        
        //Sanitize 
        $this->subject_desc = htmlspecialchars(strip_tags($this->subject_desc)); 
        
        //Bind
        $stmt->bindParam(':subject_desc', $this->subject_desc);

        //Execute
        if($stmt->execute())
            return true; 

        return false; 
        
    }
    
    // Read 
    function read()
    {
        // Query to read
        $query = "SELECT 
                    id, subject_desc 
                FROM 
                    ".$this->table_name; 
        // Prepare 
        $stmt = $this->conn->prepare($query); 

        // Execute
        $stmt->execute(); 

        return $stmt; 
    }

    // Read by id
    function readById()
    {
        // Query to read
        $query = "SELECT 
                    id, subject_desc
                FROM 
                    ".$this->table_name."
                WHERE 
                    id = :id"; 
        // Prepare query statement 
        $stmt = $this->conn->prepare($query); 

        // Sanitize 
        $this->id = htmlspecialchars(strip_tags($this->id)); 

        // Bind
        $stmt->bindParam(':id', $this->id); 
        
        // Execute
        $stmt->execute(); 

        return $stmt; 
    }
    
    //Update 

    //Delete
}
?> 