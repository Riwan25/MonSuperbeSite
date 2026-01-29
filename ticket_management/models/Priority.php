<?php
class Priority {
    private ?int $id;
    private string $name;
    private int $value;

    public function __construct($name, $value, ?int $id = null) { 
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
    }

    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getValue(){
        return $this->value;
    }

    public function setId($id){
        $this->id = $id;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function setValue($value){
        $this->value = $value;
    }

}