<?php
namespace Tea\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Tea implements InputFilterAwareInterface
{
    public $id;
    public $brand;
	public $name;
	public $serving;
	public $ingredients;
	public $description;
	public $picture;
    protected $inputFilter;                       // <-- Add for TeaForm
    
	/**  In order to work with Zend\Db¡¯s TableGateway class, 
	     we need to implement the exchangeArray() method.
	 **/
    public function exchangeArray($data)
    {
        $this->id      = (isset($data['id']))      ? $data['id']      : null;
        $this->brand   = (isset($data['brand']))   ? $data['brand']   : null;
        $this->name    = (isset($data['name']))    ? $data['name']    : null;
		$this->serving = (isset($data['serving'])) ? $data['serving'] : null;
		$this->servings    = (isset($data['servings']))     ? $data['servings']     : null;
		$this->ingredients = (isset($data['ingredients'])) ? $data['ingredients'] : null;
		$this->description = (isset($data['description'])) ? $data['description'] : null;
		$this->picture     = (isset($data['picture']))     ? $data['picture']     : null;
    }
	
	/** hydrator method used when Edit Tea **/
	public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    // Add content to these methods:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'brand',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 50,
                        ),
                    ),
                ),
            ));
			
            $inputFilter->add(array(
                'name'     => 'name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'serving',
				'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 50,
                        ),
                    ),
                ),
            ));
			
            $inputFilter->add(array(
                'name'     => 'servings',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}
?>