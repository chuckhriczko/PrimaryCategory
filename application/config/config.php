<?php
/*************************************************************************************************
 * Configuration class that holds all of our config information
 ************************************************************************************************/
class PrimaryCategory_Config extends PrimaryCategory {		
				public function __construct(){
								$this->init();
				}
				
				public function __destruct(){
								
				}
				
				/*******************************************************************************
				 * Allows our views to access our functions
				 ******************************************************************************/
				public static function get_instance(){
        //Create an instance of this object and return it
        return NULL === self::$instance and self::$instance = new self;
    }
				
				public function init(){
								
				}
}
?>