<?php
namespace App\Entity;

class Exercicesearch{
    private  ?string $motsearch=null;

    public function getMotsearch():?string{
       return $this->motsearch;
    }

    public function setMotsearch(string $motsearch):static{
        $this->motsearch=$motsearch;
        return $this;
    }
}