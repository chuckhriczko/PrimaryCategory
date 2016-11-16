<?php
//Require the model
require_once(plugin_dir_path(__FILE__).'../models/model-main.php');

/*************************************************************************************************
 * Primary controller class, used for backend processing and routing data to views
 ************************************************************************************************/
class PrimaryCategory_Controller_Main extends PrimaryCategory {
				public $modelMain; //Instantiate the model object
				public $view; //Instantiate the view object
				
				public function __construct(){
								//Set the modelMain object's value
								$this->modelMain = new PrimaryCategory_Model_Main();
								
								//Set the view object
								$this->view = new PrimaryCategory_View();
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
				
				/*******************************************************************************
				 * Renders the metabox
				 ******************************************************************************/
				public function render_meta_box($post, $box){
								global $wpdb;
								?>
								<label for="<?php echo PrimaryCategory_Constants::PLUGIN_SLUG; ?>-category">Select which category should be primary</label>
								<br />
								<?php
								wp_dropdown_categories(array(
												'hide_empty' => false,
												'name' => PrimaryCategory_Constants::PLUGIN_SLUG.'-category',
												'id' => PrimaryCategory_Constants::PLUGIN_SLUG.'-category',
												'hierarchical' => true,
												'selected' => get_post_meta($post->ID, PrimaryCategory_Constants::PLUGIN_SLUG.'_category', true)
								));
				}
				
				/*******************************************************************************
				 * Saves metabox data when the publish or update post button is pressed
				 ******************************************************************************/
				public function save_post($post_id){
								//Now we save the data
								update_post_meta($post_id, PrimaryCategory_Constants::PLUGIN_SLUG.'_category', (isset($_POST[PrimaryCategory_Constants::PLUGIN_SLUG.'-category']) ? $_POST[PrimaryCategory_Constants::PLUGIN_SLUG.'-category'] : 0));
				}
				
				/*******************************************************************************
				 * Retrieves the the primary category and displays the HTML
				 ******************************************************************************/
				public function action_primarycategory_display($args = array('post_id' => 0, 'echo' => true, 'classname' => 'primarycategory', 'open' => '<h3', 'close' => '</h3>')){
								//Extract the arguments from the array
								extract($args);
								
								//Get the category object for this post ID, looking for our PrimaryCategory first
								$cat_id = $this->action_primarycategory_get_category(array('post_id' => $post_id));
								
								//Generate the HTML
								$html = $open.' class="'.$classname.'"><a href="/?cat='.$cat[0]->term_id.'">'.$cat[0]->name.'</a>'.$close;
								
								//Echo or return, depending on passed argument
								if ($echo) echo $html; else return $html;
				}
				
				/*******************************************************************************
				 * Retrieves the the primary category object and returns it
				 ******************************************************************************/
				public function action_primarycategory_get_category($args = array('post_id' => 0)){
								//Extract the arguments from the array
								extract($args);
								
								//Get the primary category associated with the passed post ID
								$cat_id = get_post_meta($post_id, PrimaryCategory_Constants::PLUGIN_SLUG.'_category', true);
								//If the user has not provided a PrimaryCategory then we use the first category
								if (empty($cat_id)){
												//Get the categories based on the post ID
												$cat = get_the_category($post_id);
												
												//Get the first category in the categories list
												$cat_id = isset($cat[0]) ? isset($cat[0]->term_id) ? $cat[0]->term_id : 0 : 0;
								}
								
								//Return the category object
								return get_category($cat_id);
				}
}
?>
