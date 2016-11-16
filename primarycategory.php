<?php
/*******************************************************************************
 * Obligatory WordPress plugin information
 ******************************************************************************/
/*
Plugin Name: PrimaryCategory
Plugin URI: http://objectunoriented.com/code/primarycategory
Description: Allows user to choose which category will be the primary one as well as an action that will display whichever primary category is chosen for that specific post
Version: 1.0
Author: Charles Hriczko
Author URI: http://objectunoriented.com
License: GPLv2
*/
/*******************************************************************************
 * Define our initial class
 ******************************************************************************/
class PrimaryCategory {
				//Instantiate our public variables
				public $config, $constants, $utils, $modelMain, $controllerMain, $plugin_path;
				
				//Instantiate our protected variables
				protected static $instance = NULL;
				
				/*******************************************************************************
				 * Instantiate our constructor
				 ******************************************************************************/
				public function __construct(){
								//Get the directory where this file exists
								//This is the base path for the plugin
								$this->plugin_path = plugin_dir_url(__FILE__);
				}
				
				/*******************************************************************************
				 * Allows our views to access our functions
				 ******************************************************************************/
				public static function get_instance(){
        //Create an instance of this object and return it
        return NULL === self::$instance and self::$instance = new self;
    }
				
				/*******************************************************************************
				 * Perform initialization functions
				 ******************************************************************************/
				public function init(){
								//Enqueue styles
								add_action('wp_enqueue_scripts', array(&$this, 'wp_enqueue_scripts'));
								
								//Add primarycategory action
								add_action('primarycategory_display', array(&$this->controllerMain, 'action_primarycategory_display'));
								
								//Add primarycategory get category action
								add_action('primarycategory_get_category', array(&$this->controllerMain, 'action_primarycategory_get_category'));
								
								//Add to add_meta_boxes hook to create our metabox
								add_action('add_meta_boxes', array(&$this, 'add_meta_boxes'));
								
								//Add action for saving meta box data
								add_action('save_post', array(&$this->controllerMain, 'save_post'));
				}
				
				/*******************************************************************************
				 * Adds meta boxes to post editor page
				 ******************************************************************************/
				public function add_meta_boxes(){
								//Add the meta box to the posts admin page
								add_meta_box(PrimaryCategory_Constants::PLUGIN_SLUG, PrimaryCategory_Constants::PLUGIN_NAME, array($this->controllerMain, 'render_meta_box'), 'post', 'side', 'core');
								add_meta_box(PrimaryCategory_Constants::PLUGIN_SLUG, PrimaryCategory_Constants::PLUGIN_NAME, array($this->controllerMain, 'render_meta_box'), 'page', 'side', 'core');
								add_meta_box(PrimaryCategory_Constants::PLUGIN_SLUG, PrimaryCategory_Constants::PLUGIN_NAME, array($this->controllerMain, 'render_meta_box'), 'article', 'side', 'core');
				}
				
				/*******************************************************************************
				 * Enqueues any scripts or styles this plugin may use
				 ******************************************************************************/
				public function wp_enqueue_scripts(){
								//Make sure we are not in the admin section of the site
								if (!is_admin()){
												//Register styles
												wp_register_style('primarycategory_css', $this->plugin_path.'/assets/css/primarycategory.css');
												
												//Enqueue styles
												wp_enqueue_style('primarycategory_css');
								}
				}
				
				/*******************************************************************************
				 * Instantiate our destructor
				 ******************************************************************************/
				public function __destruct(){

				}
}

/*******************************************************************************
 * Require our child class definitions
 ******************************************************************************/
require_once('application/config/constants.php');
require_once('application/config/config.php');
require_once('application/lib/utils.class.php');
require_once('application/lib/view.class.php');
require_once('application/controllers/controller-main.php');

/*******************************************************************************
 * Instantiate our other classes
 ******************************************************************************/
$primarycategory = new PrimaryCategory(); //Initialize the PrimaryCategory class
$primarycategory->config = new PrimaryCategory_Config(); //Create an instance of our configuration class
$primarycategory->constants = new PrimaryCategory_Constants(); //Create an instance of our configuration class
$primarycategory->utils = new PrimaryCategory_Utils(); //Create an instance of our utilities class
$primarycategory->view = new PrimaryCategory_View(); //Create an instance of our views class
$primarycategory->controllerMain = new PrimaryCategory_Controller_Main(); //Create an instance of our controller class

/*******************************************************************************
 * Call the init function
 ******************************************************************************/
$primarycategory->init();

/*******************************************************************************
* Instantiate the primarycategory template tag
******************************************************************************/
function primarycategory($post_id){
				global $primarycategory;
				
				//Call the action and return it's results
				return $primarycategory->controllerMain->action_primarycategory_get_category(array('post_id' => $post_id));
}
?>