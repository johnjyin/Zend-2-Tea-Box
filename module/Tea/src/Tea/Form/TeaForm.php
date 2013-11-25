<?php
namespace Tea\Form;

use Zend\Form\Form;

class TeaForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('tea');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'brand',
            'type' => 'Text',
            'options' => array(
                'label' => 'Brand',
            ),
			'attributes' => array(
				'class' => 'form-control',
			),
        ));
        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Name',
            ),
			'attributes' => array(
				'class' => 'form-control',
			),
        ));
		$this->add(array(
            'name' => 'serving',
            'type' => 'Text',
            'options' => array(
                'label' => 'Serving',
            ),
			'attributes' => array(
				'class' => 'form-control',
			),
        ));
		$this->add(array(
            'name' => 'servings',
            'type' => 'Number',
            'options' => array(
                'label' => 'Servings',
            ),
			'attributes' => array(
				'class' => 'form-control',
			),
        ));
		$this->add(array(
            'name' => 'ingredients',
            'type' => 'Textarea',
            'options' => array(
                'label' => 'Ingredients',
            ),
			'attributes' => array(
				'class' => 'form-control',
			),
        ));
		$this->add(array(
            'name' => 'description',
            'type' => 'Textarea',
            'options' => array(
                'label' => 'Description',
            ),
			'attributes' => array(
				'class' => 'form-control',
			),
        ));
		$this->add(array(
            'name' => 'picture',
            'type' => 'Text',
            'options' => array(
                'label' => 'Picture',
            ),
			'attributes' => array(
				'class' => 'form-control',
			),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}
?>