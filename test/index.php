<?php
class Test {
    private $name;
    function __construct($name = "World") {
        $this->name = $name;
    }
    function __tostring() {
        return $this->name;
    }
}

$test = new Test("PHP/test");
$test2 = explode("/", $test);
echo $test;
echo ($test2[0]);
