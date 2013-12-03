<?php
namespace Gererbdd\Model;

 use Zend\Db\TableGateway\TableGateway;

 class GererbddTable
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

     public function getGererbdd($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveGererbdd(Gererbdd $gererbdd)
     {
         $data = array(
             'prenom' => $gererbdd->prenom,
             'nom'  => $gererbdd->nom,
         );

         $id = (int) $gererbdd->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getGererbdd($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Gererbdd id does not exist');
             }
         }
     }

     public function deleteGererbdd($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }
 
?>