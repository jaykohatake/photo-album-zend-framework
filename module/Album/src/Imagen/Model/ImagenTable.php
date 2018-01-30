<?php

namespace Imagen\Model;

 use Zend\Db\TableGateway\TableGateway;

 class ImagenTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll($id)
     {
        $sqlSelect = $this->tableGateway->getSql()->select();
//        $sqlSelect->columns(array('nickName','avatar','contrasena','documento'));
        $sqlSelect->join('ImagenxAlbum', 'ImagenxAlbum.idImagen = Imagen.idImagen', array('numeroOrden' => 'numeroOrden'))
                ->where(array('idAlbum' => $id));
        $resultSet = $this->tableGateway->selectWith($sqlSelect);
        return $resultSet;
     }

     public function getImagen($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('idImagen' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveImagen(Imagen $imagen, $usuario)
     {
        if(isset($imagen->getfoto()['tmp_name'])){
            move_uploaded_file($imagen->getfoto()['tmp_name'], 'public/img/'.$usuario.'/'. $imagen->getfoto()['name']);
        }
         
         $data = array(
             'foto' => $imagen->getfoto()['name'],
             'descripcion'  => $imagen->getDescripcion(),
             'titulo'  => $imagen->getTitulo(),
             'comentario'  => $imagen->getComentario(),
         );

         $id = (int) $imagen->getIdImagen();
         if ($id == 0) {
             $this->tableGateway->insert($data);
             $id = $this->tableGateway->lastInsertValue;
         } else {
             if ($this->getImagen($id)) {
                 $this->tableGateway->update($data, array('idImagen' => $id));
             } else {
                 throw new \Exception('El id de la imagen no existe');
             }
         }
         
         return $id;
     }

     public function deleteImagen($id)
     {
         $this->tableGateway->delete(array('idImagen' => (int) $id));
     }
 }

