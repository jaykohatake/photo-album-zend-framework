<?php

 namespace Imagen\Model;

 class ImagenxAlbum
 {
     private $idImagen;
     private $idAlbum;
     private $numeroOrden;

     public function exchangeArray($data)
     {
         $this->idImagen = (isset($data['idImagen'])) ? $data['idImagen'] : null;
         $this->idAlbum  = (isset($data['idAlbum'])) ? $data['idAlbum'] : null;
         $this->numeroOrden  = (isset($data['numeroOrden'])) ? $data['numeroOrden'] : null;
     }
     
     public function getArrayCopy()
     {
         return get_object_vars($this);
     }
     
     public function getIdImagen(){
         return $this->idImagen;
     }
     
     public function getIdAlbum(){
         return $this->idAlbum;
     }
     
     public function getNumeroOrden(){
         return $this->numeroOrden;
     }
 }

