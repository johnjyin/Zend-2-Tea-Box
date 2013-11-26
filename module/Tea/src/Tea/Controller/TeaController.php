<?php
namespace Tea\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Tea\Model\Tea;
use Tea\Form\TeaForm; 


class TeaController extends AbstractActionController
{
	protected $teaTable;
	
    public function getTeaTable()
    {
        if (!$this->teaTable) {
            $sm = $this->getServiceLocator();
            $this->teaTable = $sm->get('Tea\Model\TeaTable');
        }
		return $this->teaTable;
	}
	
    public function indexAction()
    {
	    return new ViewModel(array(
            'teas' => $this->getTeaTable()->fetchAll(),
        ));
    }

    public function addAction()
    {
		$form = new TeaForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $tea = new Tea();
            $form->setInputFilter($tea->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $tea->exchangeArray($form->getData());
                $this->getTeaTable()->saveTea($tea);

                // Redirect to list of teas
                return $this->redirect()->toRoute('tea');
			}
        }
        return array('form' => $form);	
    }

    public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('tea', array(
                'action' => 'add'
            ));
        }

        // Get the Tea with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $tea = $this->getTeaTable()->getTea($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('tea', array(
                'action' => 'index'
            ));
        }

        $form  = new TeaForm();
		/** The form¡¯s bind() method attaches the model to the form.
			This is used in two ways:
			- When displaying the form, the initial values for each 
			  element are extracted from the model.
			- After successful validation in isValid(), the data from 
			  the form is put back into the model.
			These operations are done using a hydrator object. The default 
			hydrator is Zend\Stdlib\Hydrator\ArraySerializable which expects
			to find two methods in the model: getArrayCopy() and exchangeArray().
		 **/
        $form->bind($tea);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($tea->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getTeaTable()->saveTea($tea);

                // Redirect to list of teas
                return $this->redirect()->toRoute('tea');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('tea');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getTeaTable()->deleteTea($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('tea');
        }

        return array(
            'id'    => $id,
            'tea' => $this->getTeaTable()->getTea($id)
        );
    }
       
}
?>