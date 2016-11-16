<?php
/*************************************************************************************************
 * Constants class that namespaces our constants to avoid compatibility issues with other plugins
 ************************************************************************************************/
class PrimaryCategory_Constants extends PrimaryCategory {
				//Plugin Specific Constants
				const PLUGIN_NAME = 'PrimaryCategory';
				const PLUGIN_SLUG = 'primarycategory';
				const DEFAULT_CAPABILITY = 'edit_posts';
				
				//String Constants
				const STR_LENGTH_ELLIPSIS = 100;
				
				//Date Constants
				const DATETIME_MYSQL = 'Y-m-d h:i:s';
				const DATE_MYSQL = 'Y-m-d h:i:s';
				const TIME_MYSQL = 'h:i:s';
				const DATE_USER = 'M jS, Y';
    
    //Arrays
    public $notices = array(
        'updated' => 'The message has been successfully updated!',
        'deleted' => 'The message has been successfully deleted.',
        'added' => 'The message has been successfully added!'
    );
				
				/*******************************************************************************
				 * Allows our views to access our functions
				 ******************************************************************************/
				public static function get_instance(){
        //Create an instance of this object and return it
        return NULL === self::$instance and self::$instance = new self;
    }
}
?>