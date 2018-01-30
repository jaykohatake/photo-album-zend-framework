<?php

namespace Usuario\Model;

 use Zend\Db\TableGateway\TableGateway;

 class PersonaTable
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

     public function getPersona($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('documento' => $id));
         $row = $rowset->current();
//         if (!$row) {
//             throw new \Exception("Could not find row $id");
//         }
         return $row;
     }

     public function savePersona(Persona $persona)
     {
         $data = array(
             'documento' => $persona->getDocumento(),
             'nombre'  => $persona->getNombre(),
         );

//         $id = (int) $persona->documento;
//         if ($id == 0) {
//             $this->tableGateway->insert($data);
//         } else {
//             if ($this->getPersona($id)) {
//                 $this->tableGateway->update($data, array('documento' => $id));
//             } else {
//                 throw new \Exception('El id de la persona no existe');
//             }
//         }
         //si existe el id es un update, en caso contrario se trata de un insert
        
         $doc = $persona->getDocumento();
        if ($this->getPersona($doc)) {
            $this->tableGateway->update($data, array('documento' => $doc));
        } else {
            $this->tableGateway->insert($data);
        }
    }

     public function deletePersona($id)
     {
         $this->tableGateway->delete(array('documento' => (int) $id));
     }
 }

