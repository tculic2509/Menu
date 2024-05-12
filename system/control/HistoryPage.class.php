<?php
class HistoryPage extends AbstractClass
{
    public $templateName = 'Read';
    public function execute()
    {
        try {
            $datum = $_GET['datum'] ?? null;
            

            if ($datum == "" || $datum == null) {
                $this->data = "Nije unesen datum";
            } else {
                $dateCondition = date('Y-m-d', strtotime($datum));
                // Retrieve dishes for the specified date
                $sql = "SELECT * FROM meals WHERE DATE(diff_time) = '$dateCondition'";
                $result = AppCore::getDB()->sendquery($sql);
                $meals = [];
                while ($row = AppCore::getDB()->fetchArray($result)) {
                    $meals[] = $row;
                    header('Content-Type: application/json');
                }
                // Retrieve junk for the specified date
                $sql = "SELECT * FROM junk WHERE DATE(diff_time) = '$dateCondition'";
                $result = AppCore::getDB()->sendquery($sql);
                $junk = [];
                while ($row = AppCore::getDB()->fetchArray($result)) {
                    $junk[] = $row;
                    header('Content-Type: application/json');
                }

                // Assign variables to the template
                if (empty($meals) && empty($junk)) {
                    $this->data = "Nema podataka za taj datum";
                } else {
                    // Assign variables to the template
                    $this->data = [
                        'meals' => $meals,
                        'junk' => $junk
                    ];
                }
            }
        } catch (Exception $e) {
            throw new Exception("Greska: " . $e->getMessage());
        }
    }
}
