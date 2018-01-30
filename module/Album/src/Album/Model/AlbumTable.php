<?php

namespace Album\Model;

 use Zend\Db\TableGateway\TableGateway;

 class AlbumTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll($nickName)
     {
         $resultSet = $this->tableGateway->select(array('nickName' => $nickName));
         return $resultSet;
     }

     public function getAlbum($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('idAlbum' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("No existe el album con id: $id");
         }
         return $row;
     }

     public function saveAlbum(Album $album)
     {
         $data = array(
             'nickName' => $album->getNickName(),
             'nombre'  => $album->getNombre(),
             'descripcion' => $album->getDescripcion()
         );

         $id = (int) $album->getIdAlbum();
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getAlbum($id)) {
                 $this->tableGateway->update($data, array('idAlbum' => $id));
             } else {
                 throw new \Exception('El id del album no existe');
             }
         }
     }

     public function deleteAlbum($id)
     {
         $this->tableGateway->delete(array('idAlbum' => (int) $id));
     }
 }

