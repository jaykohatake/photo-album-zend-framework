<?php

namespace Imagen\Model;

 use Zend\Db\TableGateway\TableGateway;

 class ImagenxAlbumTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function getImagenxAlbum($idImagen, $idAlbum)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('idImagen' => $idImagen,'idAlbum' => $idAlbum));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $idImagen, $idAlbum");
         }
         return $row;
     }

     public function saveImagenxAlbum(ImagenxAlbum $imagenxalbum)
     {
         $data = array(
             'idImagen' => $imagenxalbum->getIdImagen(),
             'idAlbum'  => $imagenxalbum->getIdAlbum(),
             'numeroOrden'  => $imagenxalbum->getNumeroOrden(),
         );

         //REVISAR!!!
//         $idImagen = (int) $imagenxalbum->idImagen;
//         $idAlbum = (int) $imagenxalbum->idAlbum;
//         if ($idImagen == 0 && $idAlbum == 0) {
             $this->tableGateway->insert($data);
//         } else {
//             if ($this->getImagenxAlbum($idImagen, $idAlbum)) {
//                 $this->tableGateway->update($data, array('idImagen' => $idImagen, 'idAlbum' => $idAlbum));
//             } else {
//                 throw new \Exception('El id de la imagen no existe en el album');
//             }
//         }
         return true;
     }

     public function deleteImagen($idImagen, $idAlbum)
     {
         $this->tableGateway->delete(array('idImagen' => (int) $idImagen,'idAlbum' => (int) $idAlbum));
     }
 }

