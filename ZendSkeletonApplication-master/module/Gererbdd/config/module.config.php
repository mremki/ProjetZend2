<?php

return array(
     'controllers' => array(
         'invokables' => array(
             'Gererbdd\Controller\Gererbdd' => 'Gererbdd\Controller\GererbddController',
         ),
     ),
	 // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'gererbdd' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/gererbdd[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Gererbdd\Controller\Gererbdd',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),
	 
     'view_manager' => array(
         'template_path_stack' => array(
             'gererbdd' => __DIR__ . '/../view',
         ),
     ),
 );

?>