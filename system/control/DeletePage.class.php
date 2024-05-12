<?php
class DeletePage extends AbstractClass
{
    public $templateName = 'Data';
    function execute()
    {

        try {
            $title = $_GET['title'] ?? null;
            
            if ($title == "" || $title == null) {
                $this->data = "Nije unesen title";
            } else {
                // Check if the ID exists in the meals table
                $sql = "SELECT * FROM meals WHERE title='$title'";
                $result = AppCore::getDB()->sendQuery($sql);
        
                if ($result->num_rows > 0) {
                    // Move the row to the junk table using a DELETE statement
                    $sqlDelete = "DELETE FROM meals WHERE title='$title'";
                    $resultDelete = AppCore::getDB()->sendQuery($sqlDelete);
        
                    if ($resultDelete == true) {
                        $this->data = "Redak uspješno premješten u tabelu junk";
                    } else {
                        $error = AppCore::getDB()->error(); // Get the error message
                        throw new Exception("Neuspješno brisanje iz tabele meals: " . $error);
                    }
                } else {
                    // The ID does not exist in the meals table
                    $this->data = "Ne postoji taj title u tabeli meals";
                }
            }
        } catch (Exception $e) {
            // Handle the exception
            $this->data = $e->getMessage();
        }
        
        
    }
}
