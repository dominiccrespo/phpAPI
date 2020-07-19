<?php 

class Subject{
    // Database connection and table name 

    private $conn; 
    private $table_name = "subjects";
    // object properties 
    public $id; 
    public $subject_desc; 

    // constuctor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db; 
    }

    //Create 
    function create()
    {
        //query to insert 
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
    //Read 

    //Update 

    //Delete
}