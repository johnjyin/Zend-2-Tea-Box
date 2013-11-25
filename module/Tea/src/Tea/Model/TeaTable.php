<?php
namespace Tea\Model;

use Zend\Db\TableGateway\TableGateway;

class TeaTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
		$resultSet->buffer();
		//$resultSet->getDataSource()->buffer(); 
        return $resultSet;
    }

    public function getTea($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveTea(Tea $tea)
    {
        $data = array(
            'brand'    => $tea->brand,
            'name'     => $tea->name,
			'serving'  => $tea->serving,
			'servings' => $tea->servings,
			'ingredients'  => $tea->ingredients,
			'description'  => $tea->description,
			'picture'  => $tea->picture,
        );

        $id = (int)$tea->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getTea($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Tea id does not exist');
            }
        }
    }

    public function deleteTea($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}
?>