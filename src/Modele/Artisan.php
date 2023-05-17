<?php

namespace App\Modele;

class Artisan{

    private $nom;
    private $prenom;
    private $metier;
   
    public function __construct($nom, $prenom, $metier){
        $this -> nom = $nom;
        $this -> prenom = $prenom;
        $this -> metier = $metier;
    }

    public function getPrenom(){
        return $this -> prenom;
    }
    
    public function getNom(){
        return $this -> nom;
    }
    
    public function getMetier(){
        return $this -> metier;
    }


}