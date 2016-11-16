<?php
/*************************************************************************************************
 * View class contains functions for displaying views to the user
 ************************************************************************************************/
class PrimaryCategory_View extends PrimaryCategory {
				public function __construct(){
								//Create custom hooks for the view class
								add_action(PrimaryCategory_Constants::PLUGIN_SLUG.'_load', array(&$this, 'load')); //Load custom template
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
				 * Loads a view
				 ******************************************************************************/
				public function load($view_name = NULL, $data = array()){
								//Initialize the return value
								$retVal = false;
								
								//Make sure a view name has been passed
								if (!is_null($view_name)){
												//Generate the theme and plugin paths for the view
												$theme_path = get_template_directory().'/'.PrimaryCategory_Constants::PLUGIN_SLUG.'/views/'.$view_name.(strstr($view_name, '.php') ? '' : '.php');
												$plugin_path = plugin_dir_path(__FILE__).'../views/'.$view_name.(strstr($view_name, '.php') ? '' : '.php');
												
												//Set the path we are going to use
												$retVal = $abs_path = (file_exists($theme_path) ? $theme_path : $plugin_path);
												
												//If the file exists, include it. If not, set the return value to false
												if (file_exists($abs_path)){
																//Extract the data array, if passed, so the view has access to the variables
																extract($data);
																
																//Start the output buffer
																if (!is_admin()) ob_start(); 
																
																//Include the view
																@include($abs_path);
																
																//Get the contents of the output buffer
																$retVal = (is_admin() ? true : ob_get_contents());
																
																//Close and clean the output buffer
																if (!is_admin()) ob_end_clean();
												} else {
																$retVal = false;
												}
								} else {
												//If the view name is null, set the return value to false
												$retVal = false;
								}
								
								//Return proper value
								return $retVal;
				}
				
				/**********************************************************************************************
				 * Parses a template by replacing template tags with associated strings
				 *********************************************************************************************/
				public function parse_template($tpl_filename = '', $data = array()){
								//Init template variables
								$from = '';
								$from_name = '';
								$from_email = '';
								$subject = '';
								$content = '';
								
								//Determine the template file path
								$theme_path = get_template_directory().'/'.PrimaryCategory_Constants::PLUGIN_SLUG.'/views/tpls/'.$tpl_filename.(strstr($tpl_filename, '.php') ? '' : '.php');
								$plugin_path = plugin_dir_path(__FILE__).'../views/tpls/'.$tpl_filename.(strstr($tpl_filename, '.php') ? '' : '.php');
								
								//Get the content from the correct file
								$content = file_get_contents(file_exists($theme_path) ? $theme_path : $plugin_path);
								
								//Loop through the data
								foreach($data as $key=>$item){
												$content = str_replace('['.$key.']', $item, $content);
								}
								
								//Extract the email metadata from the content
								$metadata = array();
								preg_match_all(PrimaryCategory_Constants::REGEX_HTML_COMMENTS, $content, $metadata);
								$metadata = $metadata[0][0];
								
								//If there were any matches
								if ($metadata){
												//Get the subject
												preg_match('/Subject:.*/', $metadata, $subject);
												$subject = str_replace('Subject: ', '', $subject[0]);
												
												//Get the from information
												preg_match('/From:.*/', $metadata, $from);
												$from = str_replace('From: ', '', $from[0]);
												
												//Separate from name and the from email
												$from = explode(' ', $from);
												
												//Get the last item, which is the email and pop the last item off the array
												$from_email = str_replace(array('<', '>'), '', array_pop($from));
												
												//Loop through the rest of the array to get the from name
												foreach($from as $name){
																$from_name .= $name.' ';
												}
												
												//Remove metadata from content
												$content = str_replace($metadata, '', $content);
								}
								
								//Return the parsed string
								return array(
												'from_name' 	=> $from_name,
												'from_email' => $from_email,
												'subject' 			=> $subject,
												'content' 			=> $content
								);
				}
}
?>
