<?php
/** The config information is passed to the relevant components 
    by the ServiceManager.
    - The controllers provides a list of all the controllers 
	provided by the module.
	- The view_manager will allow to find the view scripts for the module.
 **/
return array(
    'controllers' => array(
        'invokables' => array(
		    /** an array of service name/class name pairs. 
			    The class name should be class that may be directly 
				instantiated without any constructor arguments.
			 **/
            'Tea\Controller\Tea' => 'Tea\Controller\TeaController',
        ),
    ),

	/** The mapping of a URL to a particular action is done using 
	    routes that are defined in the module¡¯s module.config.php file.
	 **/
    'router' => array(
        'routes' => array(
            'tea' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/tea[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Tea\Controller\Tea',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
	
    'view_manager' => array(
        'template_path_stack' => array(
            'tea' => __DIR__ . '/../view',
        ),
    ),
);
?>