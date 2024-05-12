<?php
class CreatePage extends AbstractClass
{
    public $templateName = 'Data';
    function execute()
    {
        try {
            $nazivJela = $_GET['naziv'] ?? null;
            $opisJela = $_GET['opis'] ?? null;
            $ingredients = $_GET['sastojak'] ?? null;
            
            $vrijeme = date('Y-m-d H:i:s');

            if ($nazivJela === "" || $nazivJela === null || $opisJela === "" || $opisJela === null || $ingredients === "" || $ingredients === null) {
                // Ispisujem iz baze radi provjere unesenih podataka
                $sql = "SELECT * FROM meals";
                $result = AppCore::getDB()->sendQuery($sql);
                $meals = [];

                while ($row = AppCore::getDB()->fetchArray($result)) {
                    if (isset($row['id'])) {
                        $meals[$row['id']] = $row;
                        header('Content-Type: application/json');
                    }
                }

                $this->data = [
                    'meals' => $meals
                ];
            } else {
                if ($nazivJela === null) {
                    throw new Exception("ID jela nije pronađen");
                }

                // Dohvaćanje category_ID na temelju naziva kategorije
                $categorySlug = $_GET['category'];
                $categoryID = null;

                $categorySQL = "SELECT id FROM category WHERE slug = '$categorySlug'";
                $categoryResult = AppCore::getDB()->sendQuery($categorySQL);

                if ($categoryResult->num_rows > 0) {
                    $categoryRow = AppCore::getDB()->fetchArray($categoryResult);
                    $categoryID = $categoryRow['id'];
                }
                $tags = $_GET['tags'] ?? null;
                $tagsID = null;

                $tagsSQL = "SELECT id FROM tags WHERE slug = '$tags'";
                $tagsResult = AppCore::getDB()->sendQuery($tagsSQL);

                if ($tagsResult->num_rows > 0) {
                    $tagsRow = AppCore::getDB()->fetchArray($tagsResult);
                    $tagsID = $tagsRow['id'];
                }
                // Unos podataka u tablicu meals s odgovarajućim category_ID
                $sql = "INSERT INTO meals (title, description,ingredients_title,category_ID,tags_ID, diff_time)
                        VALUES ('$nazivJela', '$opisJela','$ingredients', '$categoryID','$tagsID','$vrijeme')";

                $result = AppCore::getDB()->sendQuery($sql);

                if ($result == true) {
                    $this->data = "Uspješno kreirano jelo";
                } else {
                    throw new Exception("Neuspješno kreiranje jela");
                }
            }
        } catch (Exception $e) {
            $this->data = "Greška: " . $e->getMessage();
        }
    }
}
