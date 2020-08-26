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
                    id = ? 
                LIMIT
                    0,1"; 
        // Prepare query statement 
        $stmt = $this->conn->prepare($query); 

        // Bind
        $stmt->bindParam(1, $this->id); 
        
        // Execute
        $stmt->execute(); 

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC); 

        // set values to object properties 
        $this->id = $row['id']; 
        $this->subject_desc = $row['subject_desc']; 
    }
    
    //Update 
    function update()
    {
        // Update query
        $query = "UPDATE
                    ". $this->table_name ."
                SET
                    subject_desc = :subject_desc
                WHERE
                    id = :id";
        // Prepare query
        $stmt = $this->conn->prepare($query); 

        // Sanitize
        $this->subject_desc = htmlspecialchars(strip_tags($this->subject_desc)); 

        // Bind new values 
        $stmt->bindParam(':subject_desc', $this->subject_desc); 
        $stmt->bindParam(':id', $this->id); 

        // Execute the query
        if($stmt->execute())
        {
            return true; 
        }
        
        return false; 
    }

    //Delete
}
?> 