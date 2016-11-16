<?php
/*************************************************************************************************
 * Utilities class that provides commonly used functionality
 ************************************************************************************************/
class PrimaryCategory_Utils extends PrimaryCategory {
				function __construct(){

				}
				
				function __destruct(){
								
				}
				
				/*******************************************************************************
				 * Allows our views to access our functions
				 ******************************************************************************/
				public static function get_instance(){
        //Create an instance of this object and return it
        return NULL === self::$instance and self::$instance = new self;
    }
				
				/**********************************************************************************************
				 * Logs an object, array, or anything else to the specificed error log
				 *********************************************************************************************/
				public function log_obj($obj, $log_file = null){
								//Make sure we have a valid log file name
								$log_file = (empty($log_file) ? plugin_dir_path( __FILE__ ).'../../log/log' : $log_file);
								//$log_file = (strstr($log_file, '/')<1 && strstr($log_file, '\\')<1 ? plugin_dir_path(__FILE__).'../log/'.$log_file : $log_file);

								//Reset the umask. This allows us to chmod the mkdir
								$old = umask(0);
								
								//Make the directory if it does not already exist
								@mkdir(dirname($log_file), '0755', true);
								
								//Reset the umask back to what it was
								umask($old);
								
								//Output the contents of the object to the file in append mode
								return file_put_contents($log_file, (is_string($obj) ? $obj : print_r($obj, true))."\r\n\r\n", FILE_APPEND | LOCK_EX);
				}
				
				/**********************************************************************************************
				 * Wrapper for log_obj function to just log a string
				 *********************************************************************************************/
				public function log_str($str, $log_file = null){
								return $this->log_obj($str, $log_file);
				}
				
				/**********************************************************************************************
				 * Removes commas and other characters and replaces spaces with underscores to make text
				 * clean for a URL or hashtag
				 *********************************************************************************************/
				public function clean_text($string){
								return strtolower(str_replace(Array(',', '\'', '/', '"', '&', '?', '!', '*', '(', ')', '^', '%', '$', '#', '@', '{', '}', '[', ']', '|', ':', ';', '<', '>', '.', '~', '`', '+', '='), '', str_replace(' ', '_', $string)));
				}
				
				/**********************************************************************************************
				 * Truncates a string, allowing for adding an ellipsis and truncating only to the next whole
				 * word
				 *********************************************************************************************/
				public function strtrunc($string, $length = 0, $findlastword = true, $trails = false){
								if ((strlen($string)>$length) && (strlen($string)>1)){ //Makes sure string is at least as long as $length
												//If we are finding last word before cutoff then we find where the first whitespace is starting from the end of $length
												$whitespacepos = ($findlastword ? strpos($string, ' ', $length) : 0);
												
												$whitespacepos = ($whitespacepos ? strlen($string) > $length ? 25 : strlen($string) : $whitespacepos);
												$string = substr($string, 0, $whitespacepos);
												$string = ($trails ? $string.'&hellip;' : $string);
								}
								
								return $string;
				}
				
				/**********************************************************************************************
				 * Like in_array but searches recursively for needle in the array
				 * Used for multidimensional arrays
				 *********************************************************************************************/
				public function in_array_recursive($needle, $haystack, $strict = false) {
								foreach ($haystack as $item) {
												if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
													
																return true;
												}
								}

								return false;
				}
				
				/**********************************************************************************************
				 * Converts a timestamp to GMT time
				 *********************************************************************************************/
				public function convert_timestamp_to_gmt($timestamp){
								$second = gmdate('s', $timestamp);
								$minute = gmdate('i', $timestamp);
								$hour   = gmdate('H', $timestamp);
								$day    = gmdate('d', $timestamp);
								$month  = gmdate('m', $timestamp);
								$year   = gmdate('Y', $timestamp);
								return mktime($hour, $minute, $second, $month, $day, $year);
				}
				
				/**********************************************************************************************
				 * Converts a timestamp from GMT time to another timezone
				 *********************************************************************************************/
				public function convert_timestamp_from_gmt($timestamp, $tz = 'EST'){
								$date = new DateTime(date(DATE_MYSQL, $timestamp), new DateTimeZone('UTC'));
								$date->setTimezone(new DateTimeZone($tz));
								
								return $date->getTimestamp();
				}
				
				/**********************************************************************************************
				 * Converts days into milliseconds
				 *********************************************************************************************/
				public function daysToMS($days = 1){
								return $days * 24 * 60 * 60 * 1000;
				}
				
				/**********************************************************************************************
				 * Converts milliseconds into days
				 *********************************************************************************************/
				public function msToDays($ms = 86400000){
								return (((($ms / 1000) / 60) / 60) / 24);
				}
}
?>
