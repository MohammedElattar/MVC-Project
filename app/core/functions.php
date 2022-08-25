<?php
class checkInputsClass
{
    private $val;
    private bool $is_string;
    private bool $is_numeric;
    private bool $is_image;
    public array $res;

    function __construct($val, bool $is_string = false, bool $is_image = false, bool $is_numeric = false, )
    {
        $this->val = $val;
        $this->is_string = $is_string;
        $this->is_image = $is_image;
        $this->is_numeric = $is_numeric;
        if ($this->is_string)
            $this->check_is_string();
        if ($this->is_numeric)
            $this->check_is_numeric();
        if ($this->is_image)
            $this->check_is_image();
    }
    private function check_is_string()
    {
        $val = $this->val;
        $val = htmlspecialchars($val);
    }
    private function check_is_numeric()
    {
    }
    private function check_is_image()
    {
    }
}
function checkInputs(array $inputs)
{
    $res = [];
    $tmp = [];
    foreach ($inputs as $i) {
        $val = $i['value'];
    }
}
