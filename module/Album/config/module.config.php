<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Album\Controller\Album' => 'Album\Controller\AlbumController',
            'Usuario\Controller\Usuario' => 'Usuario\Controller\UsuarioController',
            'Imagen\Controller\Imagen' => 'Imagen\Controller\ImagenController',
        ),
    ),
    //se agrega la ruta para el controlador Album
    'router' => array(
        'routes' => array(
            'album' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/album[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Album\Controller\Album',
                        'action' => 'index',
                    ),
                ),
            ),
            'usuario' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/usuario[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Usuario\Controller\Usuario',
                        'action' => 'index',
                    ),
                ),
            ),
            'imagen' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/imagen[/][:action][/:id][/:nombre]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
//                        'nombre' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Imagen\Controller\Imagen',
                        'action' => 'index',
                    ),
                ),
            ),            
        ),
    ),
    //ubica las vistas del modulo Album
    'view_manager' => array(
        'template_path_stack' => array(
            'album' => __DIR__ . '/../view',
        ),
    ),
);
