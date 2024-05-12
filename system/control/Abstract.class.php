<?php
abstract class AbstractClass
{
    public $data = null;
    public $templateName = null;
    function __construct()
    {
        $this->execute();
        $this->show();
    }

    function show()
    {
        $templateName = $this->templateName;
        $data = $this->data ?? [];
        include_once('system/view/' . $templateName . '.tpl.php');
    }
    
    
}
