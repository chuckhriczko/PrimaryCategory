<?php
/*************************************************************************************************
 * Primary model class used for accessing the DB
 ************************************************************************************************/
class PrimaryCategory_Model_Main extends PrimaryCategory {				
				public function __construct(){

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
}
?>