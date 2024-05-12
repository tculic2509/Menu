<?php
class ReadPage extends AbstractClass
{
    public $templateName = 'Read';
    public function execute()
    {
        $lang = $_GET['lang'] ?? null;
        $ing = $_GET['ing'] ?? null;

        if ($lang === null) {
            // Language parameter is missing, handle the error accordingly
            $sql = "SELECT * FROM meals";
            $result = AppCore::getDB()->sendquery($sql);
            $meals = [];
            while ($row = AppCore::getDB()->fetchArray($result)) {
                $meals[$row['id']] = $row;
                header('Content-Type: application/json');
            }
            //assing variable to template

            if ($ing !== null) {

                $sql = "SELECT meals.id, meals.title, meals.description, meals.ingredients_title AS ingredient_name
                FROM meals
                INNER JOIN ingredients ON meals.ingredients_title = ingredients.title
                WHERE ingredients.title = '$ing'";

                $result = AppCore::getDB()->sendquery($sql);
                $meals = [];
                while ($row = AppCore::getDB()->fetchArray($result)) {
                    $meals[$row['ingredient_name']] = $row;
                    header('Content-Type: application/json');
                }
            } else {
                $sql = "SELECT * FROM meals";
                $result = AppCore::getDB()->sendquery($sql);
                $meals = [];
                while ($row = AppCore::getDB()->fetchArray($result)) {
                    $meals[$row['id']] = $row;
                }
            }

            // Assign variable to template
            $this->data = [
                'meals' => $meals
            ];
        } else {
            $tableName = '';
            switch ($lang) {
                case 'french':
                    $tableName = 'french';
                    break;
                case 'spanish':
                    $tableName = 'spanish';
                    break;
                case 'italian':
                    $tableName = 'italian';
                    break;
                default:
                    header('HTTP/1.1 400 Bad Request');
                    echo "Unsupported language";
                    exit;
            }
            $sql = "SELECT * FROM $tableName";
            $result = AppCore::getDB()->sendQuery($sql);

            $ispis = [];
            while ($row = AppCore::getDB()->fetchArray($result)) {
                $ispis[$row['id']] = $row;
                header('Content-Type: application/json');
            }
            $this->data = [
                $tableName => $ispis,

            ];
        }
    }
}
