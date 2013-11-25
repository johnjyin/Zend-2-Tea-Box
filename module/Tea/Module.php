<?php
namespace Tea;

use Tea\Model\Tea;
use Tea\Model\TeaTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    /** The ModuleManager's AutoloaderListener checks 
	    each module to see if it has implemented 
		Zend\ModuleManager\Feature\AutoloaderProviderInterface
		or simply defined the getAutoloaderConfig() method. 
		If so, it calls the getAutoloaderConfig() method 
		on the module class and passes the returned array 
		to Zend\Loader\AutoloaderFactory.
	*/
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

	/** 
	   This method simply loads the config/module.config.php file.
	 **/
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
	
    public function getServiceConfig()
    {
		/** Tell Service Manager how to create TeaTableGateway 
		    and how to create one TeaTable instance 
		    with injected TeaTableGateway
		 **/
        return array(
            'factories' => array(
                'Tea\Model\TeaTable' =>  function($sm) {
                    $tableGateway = $sm->get('TeaTableGateway');
                    $table = new TeaTable($tableGateway);
                    return $table;
                },
                'TeaTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Tea());
                    return new TableGateway('tb_tbl_tea', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}
?>