<?php
	/**
	* @access public
	* @param mixed $class_name
	* @return void
	*/
	function autoload_classes ($class_name)
	{
		$class_location = str_replace('payvision_', '', strtolower($class_name));
		$class_location = str_replace('_', '/', $class_location);

		if (file_exists(__DIR__ . '/../' . $class_location . '.php'))
		{
			require_once(__DIR__ . '/../' . $class_location . '.php');
		}
		else
		{
			die("Class not found '{$class_name}'" . PHP_EOL);
		}
	}

	spl_autoload_register('autoload_classes');