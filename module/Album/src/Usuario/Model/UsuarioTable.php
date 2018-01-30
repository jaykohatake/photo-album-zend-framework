<?php

namespace Usuario\Model;

use Zend\Db\TableGateway\TableGateway;
//
use Zend\Db\ResultSet\ResultSet;

class UsuarioTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $sqlSelect = $this->tableGateway->getSql()->select();
//        $sqlSelect->columns(array('nickName','avatar','contrasena','documento'));
        $sqlSelect->join('Persona', 'Persona.documento = Usuario.documento', array('documento' => 'documento', 'nombre' => 'nombre'));
        $resultSet = $this->tableGateway->selectWith($sqlSelect);
        return $resultSet;
    }

    public function getUsuario($id) {
        $id = (int) $id;
        $sqlSelect = $this->tableGateway->getSql()->select();
        //$sqlSelect->columns(array('column_name'));
        $sqlSelect->join('Persona', 'Persona.documento = Usuario.documento', array('documento' => 'documento', 'nombre' => 'nombre'))
                ->where(array('Usuario.documento' => $id));

        $rowset = $this->tableGateway->selectWith($sqlSelect);
        $row = $rowset->current();
        return $row;
    }

    public function saveUsuario(Usuario $usuario, $documento_ant = null) {
        if(isset($usuario->getAvatar()['tmp_name'])){
            $avatar = 'avatar' . $usuario->getNickName() . '.png';
            move_uploaded_file($usuario->getAvatar()['tmp_name'], 'public/img/user-avatar/' . $avatar);
        }
        
        //REVISAR!!!
//           if (!$usuario->getDocumento())
//               throw Exception
//           else if(!$documento_ant){
//               insert persona
//               insert usuario
//           }else{
//               insert persona nuevo documento
//               edit usuario
//               delete persona viejo documento
//           }
//           
//           
        $data = array(
            'documento' => $usuario->getDocumento(),
            'nickName' => $usuario->getNickName(),
            'contrasena' => $usuario->getContrasena(),
            'avatar' => $avatar,
        );

        //se crea un nuevo objeto personatable
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Persona());
        $tg = new TableGateway('Persona', $this->tableGateway->getAdapter(), null, $resultSetPrototype);
        $personaTable = new PersonaTable($tg);

        if (!$usuario->getDocumento()) {
            throw new \Exception('El id del usuario no existe');
        } else if (!($documento_ant)) { //no hay documento anterior, se hace insert en las dos tablas
            //se instancia la persona que se guardara en la bd
            $persona = new Persona();
            $persona->exchangeArray(array('documento' => $usuario->getDocumento(), 'nombre' => $usuario->getNombre()));
            $personaTable->savePersona($persona);

            //ahora se inserta el usuario
            $this->tableGateway->insert($data);
        } else { //existe documento anterior, es un update
            //se instancia la persona que se guardara en la bd, con el documento actual
            $persona = new Persona();
            $persona->exchangeArray(array('documento' => $usuario->getDocumento(), 'nombre' => $usuario->getNombre()));
            $personaTable->savePersona($persona);

            //se edita el usuario con el nuevo documento
            $this->tableGateway->update($data, array('documento' => $documento_ant));
            
            //si el documento actual es diferente al anterior, se elimina la persona con documento anterior
            if($documento_ant != $usuario->getDocumento()){
                $personaTable->deletePersona($documento_ant);
            }
        }

        //
//         $id = (int) $usuario->documento;
//         if ($id != 0) {//validar que el id si exista en la tabla Persona, luego insertar
//             $this->tableGateway->insert($data);
//         } else {
//             if ($this->getUsuario($id)) {
//                 $this->tableGateway->update($data, array('documento' => $id));
//             } else {
//                 throw new \Exception('El id del usuario no existe');
//             }
//         }
    }

    public function deleteUsuario($id) {
        $this->tableGateway->delete(array('documento' => (int) $id));
    }

}
