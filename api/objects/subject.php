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
    
    // Update 
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

    // Delete
    function delete()
    {
        // Delete query 
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?"; 

        // Prepare query 
        $stmt = $this->conn->prepare($query); 

        // Sanitize
        $this->id=htmlspecialchars(strip_tags($this->id)); 

        // Bind id of record to delete 
        $stmt->bindParam(1,$this->id); 

        // Execute query
        if($stmt->execute())
        {
            return true; 
        }

        return false; 
    }

    // Search
    function search($keywords)
    {
        // Select all query 
        $query = "SELECT 
                    id, subject_desc 
                FROM 
                " . $this->table_name . " 
                WHERE subject_desc LIKE ?"; 
        
        // Prepare query statment 
        $stmt = $this->conn->prepare($query); 

        // Sanitize 
        $keywords=htmlspecialchars(strip_tags($keywords)); 
        $keywords = "%{$keywords}%"; 

        // Bind 
        $stmt->bindParam(1, $keywords); 

        // Execute query
        $stmt->execute(); 

        return $stmt; 
    }

    // Read Paging 
    function readPaging($from_record_num, $records_per_page)
    {
        // Select query
        $query = "SELECT 
                    id, subject_desc
                FROM 
                " . $this->table_name . "
                LIMIT ?,?"; 
        
        // Prepare query statement 
        $stmt = $this->conn->prepare($query); 

        // bind 
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT); 
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
        
        // Execute query
        $stmt->execute(); 

        // Return values from database
        return $stmt; 

    }

    // Used for paging subjects 
    public function count()
    {
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . ""; 

        $stmt = $this->conn->prepare($query); 
        $stmt->execute(); 
        $row = $stmt->fetch(PDO::FETCH_ASSOC); 

        return $row['total_rows']; 
    }
}
?> 