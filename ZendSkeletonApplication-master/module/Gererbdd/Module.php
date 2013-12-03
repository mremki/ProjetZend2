<?php
 namespace Gererbdd;

 // Add these import statements:
 use Gererbdd\Model\Gererbdd;
 use Gererbdd\Model\GererbddTable;
 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;

 
 class Module
 {
	// getAutoloaderConfig() and getConfig() methods here
     public function getAutoloaderConfig()
     {
         return array(
             'Zend\Loader\ClassMapAutoloader' => array(
                 __DIR__ . '/autoload_classmap.php',
             ),
             'Zend\Loader\StandardAutoloader' => array(
                 'namespaces' => array(
                     __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                 ),
             ),
         );
     }

     public function getConfig()
     {
         return include __DIR__ . '/config/module.config.php';
     }

     
     // Add this method:
     public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Gererbdd\Model\GererbddTable' =>  function($sm) {
                     $tableGateway = $sm->get('GererbddTableGateway');
                     $table = new GererbddTable($tableGateway);
                     return $table;
                 },
                 'GererbddTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Gererbdd());
                     return new TableGateway('gererbdd', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }
 }
 

 ?>