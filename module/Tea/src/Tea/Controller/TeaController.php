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
            $album = $this->getAlbumTable()->getAlbum($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('tea', array(
                'action' => 'index'
            ));
        }

        $form  = new AlbumForm();
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getAlbumTable()->saveAlbum($album);

                // Redirect to list of albums
                return $this->redirect()->toRoute('album');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
    }
       
}
?>