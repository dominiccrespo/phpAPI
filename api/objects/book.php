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

    // Read By ID 
    public function readById()
    {
        // Query to read 
        $query = "SELECT 
                    id, subject_id, book_desc, grade_level
                FROM " . $this->table_name . " 
                WHERE id = ?
                LIMIT 0,1"; 
        
        // Prepare 
        $stmt = $this->conn->prepare($query); 

        // Bind 
        $stmt->bindParam(1, $this->id); 

        // Execute 
        $stmt->execute(); 

        // Get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC); 

        // Set values to object properties 
        $this->id = $row['id']; 
        $this->book_desc = $row['book_desc'];
        $this->subject_id = $row['subject_id']; 
        $this->grade_level = $row['grade_level'];  
    }

    // Read by subject ID 
    public function readBySubjectId()
    {
        // Query to read 
        $query = "SELECT 
                    id, subject_id, book_desc, grade_level
                FROM " . $this->table_name . " 
                WHERE subject_id = ? 
                ORDER BY id"; 
        
        // Prepare 
        $stmt = $this->conn->prepare($query); 

        // Bind 
        $stmt->bindParam(1, $this->subject_id); 

        // Execute 
        $stmt->execute(); 

        return $stmt; 
    }

     // Update 
     function update()
     { 
        $setUpdate = array(); 

        if($this->book_desc != -1)
        {
            array_push($setUpdate, "book_desc"); 
        }
        if($this->grade_level != -1)
        {
            array_push($setUpdate, "grade_level"); 
        }
        if($this->subject_id != -1)
        {
            array_push($setUpdate, "subject_id"); 
        }
        if(count($setUpdate) == 0)
        {
            return false; 
        }
        $updateString = ""; 

        for($i = 0; $i < count($setUpdate); $i++)
        {
            if($i == count($setUpdate)-1)
                $updateString .= $setUpdate[$i] . "= :". $setUpdate[$i]; 
            else
                $updateString .= $setUpdate[$i] . "= :". $setUpdate[$i].","; 
        } 
         // Update query
         $query = "UPDATE
                     ". $this->table_name ."
                 SET ".
                    $updateString
                 ." WHERE
                     id = :id";
         // Prepare query
         $stmt = $this->conn->prepare($query); 
 
        // Sanitize 
        if($this->book_desc != -1)
        {
            $this->book_desc = htmlspecialchars(strip_tags($this->book_desc)); 
            $stmt->bindParam(':book_desc', $this->book_desc);  
        }
        if($this->grade_level != -1)
        {
            $this->grade_level = htmlspecialchars(strip_tags($this->grade_level)); 
            $stmt->bindParam(':grade_level', $this->grade_level);  
        }
        if($this->subject_id != -1)
        {
            $this->subject_id = htmlspecialchars(strip_tags($this->subject_id)); 
            $stmt->bindParam(':subject_id', $this->subject_id);  
        }
         $stmt->bindParam(':id', $this->id);
        
 
         // Execute the query
         if($stmt->execute())
         {
             return true; 
         }
         
         return false; 
     }
}
?> 