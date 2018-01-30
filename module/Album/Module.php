<?php
 
namespace Album;

 use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
 use Zend\ModuleManager\Feature\ConfigProviderInterface;
 //se añade para el TableGateway
 use Album\Model\Album;
 use Album\Model\AlbumTable;
 use Usuario\Model\Persona;
 use Usuario\Model\PersonaTable;
 use Usuario\Model\Usuario;
 use Usuario\Model\UsuarioTable;
 use Imagen\Model\Imagen;
 use Imagen\Model\ImagenTable;
 use Imagen\Model\ImagenxAlbum;
 use Imagen\Model\ImagenxAlbumTable;
 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;


 class Module implements AutoloaderProviderInterface, ConfigProviderInterface
 {
     public function getAutoloaderConfig()
     {
         return array(
             'Zend\Loader\ClassMapAutoloader' => array(
                 __DIR__ . '/autoload_classmap.php',
             ),
             'Zend\Loader\StandardAutoloader' => array(
                 'namespaces' => array(
                     __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                     'Persona' => __DIR__ . '/src/Persona',
                     'Usuario' => __DIR__ . '/src/Usuario',
                     'Imagen' => __DIR__ . '/src/Imagen',
                     'ImagenxAlbum' => __DIR__ . '/src/ImagenxAlbum',
                 ),
             ),
         );
     }

     public function getConfig()
     {
         return include __DIR__ . '/config/module.config.php';
     }
     
     //este instancia AlbumTable
     public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Album\Model\AlbumTable' =>  function($sm) {
                     //le pide al service manager que le devuelva un AlbumTableGateway
                     $tableGateway = $sm->get('AlbumTableGateway');
                     //instancia el AlbumTable con el tablegateway devuelto
                     $table = new AlbumTable($tableGateway);
                     return $table;
                 },
                 'AlbumTableGateway' => function ($sm) {
                     //le pide al service manager el adapter de la base de datos (mysql, oracle...)
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     //se crea un conjunto para el resultado de las consultas
                     $resultSetPrototype = new ResultSet();                  
                     //se dice que será un conjunto de objetos tipo album
                     $resultSetPrototype->setArrayObjectPrototype(new Album());
                     //se devuelve el tablegateway con el nombre de la tabla, el adaptador de bd, features, y el conjunto que almacenará las "tuplas"
                     return new TableGateway('Album', $dbAdapter, null, $resultSetPrototype);
                 },
                 'Usuario\Model\PersonaTable' =>  function($sm) {
                     $tableGateway = $sm->get('PersonaTableGateway');
                     $table = new PersonaTable($tableGateway);
                     return $table;
                 },
                 'PersonaTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();                     
                     $resultSetPrototype->setArrayObjectPrototype(new Persona());
                     return new TableGateway('Persona', $dbAdapter, null, $resultSetPrototype);
                 },
                 'Usuario\Model\UsuarioTable' =>  function($sm) {
                     $tableGateway = $sm->get('UsuarioTableGateway');
                     $table = new UsuarioTable($tableGateway);
                     return $table;
                 },
                 'UsuarioTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();                     
                     $resultSetPrototype->setArrayObjectPrototype(new Usuario());
                     return new TableGateway('Usuario', $dbAdapter, null, $resultSetPrototype);
                 },
                 'Imagen\Model\ImagenTable' =>  function($sm) {
                     $tableGateway = $sm->get('ImagenTableGateway');
                     $table = new ImagenTable($tableGateway);
                     return $table;
                 },
                 'ImagenTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();                     
                     $resultSetPrototype->setArrayObjectPrototype(new Imagen());
                     return new TableGateway('Imagen', $dbAdapter, null, $resultSetPrototype);
                 },
                 'Imagen\Model\ImagenxAlbumTable' =>  function($sm) {
                     $tableGateway = $sm->get('ImagenxAlbumTableGateway');
                     $table = new ImagenxAlbumTable($tableGateway);
                     return $table;
                 },
                 'ImagenxAlbumTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();                     
                     $resultSetPrototype->setArrayObjectPrototype(new ImagenxAlbum());
                     return new TableGateway('ImagenxAlbum', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }

 }