<?php
 // ini_set('display_errors', 1);
 // ini_set('display_startup_errors', 1);
 // error_reporting(E_ALL);
/*
Plugin Name:  Prudent hubspot sync
Plugin URI:   http://d-olsen.com
Description:  Plugin to sync user action with hubspot account.
Version:      20160911
Author:       David Olsen
Author URI:   http://d-olsen.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  prudent-sync
Domain Path:  /languages
*/

define( 'PLUGIN_NAME_VERSION', '1.0.0' );

require_once 'class-synchronize.php';

class HubspotSync{

	public function init()
	{
		$encoded_data = file_get_contents('php://input');
		if( $encoded_data != '' ){
			$data = json_decode($encoded_data);
			$this->perform_action($data);
		}


	}

	private function perform_action($data)
	{
		$synchronize 	= new Synchronize();
		$this->debug($data);
		$synchronize->perform_sync($data);
		unset($synchronize);
	}


	private function debug($debug_data)
	{
		$log_time = date('Y-m-d h:i:sa');
		$this->wh_log("************** Start Log For Day : '" . $log_time . "'**********");
		$this->wh_log($debug_data);
		$this->wh_log("************** END Log For Day : '" . $log_time . "'**********");
		 
	}

	private function wh_log($debug_data)
	{
	    $log_filename = "HubspotSync_log";
	    if (!file_exists($log_filename)) 
	    {
	        // create directory/folder uploads.
	        mkdir($log_filename, 0777, true);
	    }
	    $log_file_data = $log_filename.'/log_' . date('d-M-Y') . '.log';
	    file_put_contents($log_file_data, print_r($debug_data, TRUE) . "\n", FILE_APPEND);
	}

}

$sync = new HubspotSync();
$sync->init();
unset($sync);