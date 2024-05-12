<?php
class IndexPage extends AbstractClass
{
    public $templateName = 'index';
    public function execute()
    {
        $sql = "SELECT * FROM resursi";
        $result = AppCore::getDB()->sendquery($sql);
        $resursi = [];
        while ($row = AppCore::getDB()->fetchArray($result)) {
            $resursi[$row['resursID']] = $row;
        }
        $sql = "SELECT * FROM meals";
        $result = AppCore::getDB()->sendquery($sql);
        $meals = [];
        while ($row = AppCore::getDB()->fetchArray($result)) {
            $meals[$row['id']] = $row;
        }
        //assing variable to template
        $this->data = [
            'resursi' => $resursi,
            'meals' => $meals,
        ];
        
    }
    
}
