<?php

 namespace Usuario\Model;

 class Persona
 {
     protected $documento;
     protected $nombre;

     public function exchangeArray($data)
     {
         $this->documento = (isset($data['documento'])) ? $data['documento'] : null;
         $this->nombre  = (isset($data['nombre'])) ? $data['nombre'] : null;
     }
     
          //getters y setters
     public function getDocumento(){
         return $this->documento;
     }
     
     public function getNombre(){
         return $this->nombre;
     }
     
     public function setDocumento($documento){
         $this->documento = $documento;
     }
     
     public function setNombre($nombre){
         $this->nombre = $nombre;
     }
 }

