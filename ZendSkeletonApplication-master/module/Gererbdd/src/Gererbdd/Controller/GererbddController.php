<?php
 namespace Gererbdd\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Gererbdd\Model\Gererbdd;
 use Gererbdd\Form\GererbddForm;


 class GererbddController extends AbstractActionController
 {
	 protected $gererbddTable;
     // module/Gererbdd/src/Gererbdd/Controller/GererbddController.php:
     public function indexAction()
     {
         return new ViewModel(array(
             'gererbdds' => $this->getGererbddTable()->fetchAll(),
         ));
     }
	 // ...

	public function addAction()
     {
         $form = new GererbddForm();
         $form->get('submit')->setValue('Ajouter');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $gererbdd = new Gererbdd();
             $form->setInputFilter($gererbdd->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $gererbdd->exchangeArray($form->getData());
                 $this->getGererbddTable()->saveGererbdd($gererbdd);

                 // Redirect to list of gererbdds
                 return $this->redirect()->toRoute('gererbdd');
             }
         }
         return array('form' => $form);
     }

     
	 public function editAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('gererbdd', array(
                 'action' => 'add'
             ));
         }

         // Get the Gererbdd with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
         try {
             $gererbdd = $this->getGererbddTable()->getGererbdd($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('gererbdd', array(
                 'action' => 'index'
             ));
         }

         $form  = new GererbddForm();
         $form->bind($gererbdd);
         $form->get('submit')->setAttribute('value', 'Editer');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($gererbdd->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getGererbddTable()->saveGererbdd($gererbdd);

                 // Redirect to list of gererbdds
                 return $this->redirect()->toRoute('gererbdd');
             }
         }

         return array(
             'id' => $id,
             'form' => $form,
         );
     }
	 
	 
	 // Add content to the following method:
     public function deleteAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('gererbdd');
         }

         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'Non');

             if ($del == 'Oui') {
                 $id = (int) $request->getPost('id');
                 $this->getGererbddTable()->deleteGererbdd($id);
             }

             // Redirect to list of gererbdds
             return $this->redirect()->toRoute('gererbdd');
         }

         return array(
             'id'    => $id,
             'gererbdd' => $this->getGererbddTable()->getGererbdd($id)
         );
     }
	 
	 public function getGererbddTable()
     {
         if (!$this->gererbddTable) {
             $sm = $this->getServiceLocator();
             $this->gererbddTable = $sm->get('Gererbdd\Model\GererbddTable');
         }
         return $this->gererbddTable;
     }

 }
 
?>