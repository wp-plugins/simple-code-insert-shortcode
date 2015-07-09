<?php

class Scis {

	private static $initiated = false;

	public static function init() {
		if ( ! self::$initiated ) {
			self::init_hooks();
		}
	}

	private static function init_hooks() {
		self::$initiated = true;		
	}

	public static function plugin_activation(){
		self::scis_create_db();
	}

	public static function plugin_deactivation(){
	
	}

	private static function scis_create_db() {
		
		global $wpdb;

		$table_name = $wpdb->prefix.SCIS_TABLE_NAME;

		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		    $charset_collate = $wpdb->get_charset_collate();

			$sql = "CREATE TABLE $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,		 		  	
			  	code_name text NOT NULL,	
			  	code_data text NOT NULL,	  	
			  	UNIQUE KEY id (id)
			) $charset_collate;";			
			$wpdb->query($sql);
		}
		else{}
	}

	public static function scis_plugin($atts){
	
		global $wpdb;	
		
		if(is_page() || is_single()){
			
			$data = shortcode_atts( array(
				'id' => '',
				'align' => ''
			), $atts );

			$scis_id = $data['id'];
			$scis_align = $data['align'];
			
			$scis_row = $wpdb->get_results( "SELECT * FROM $wpdb->prefix".SCIS_TABLE_NAME." WHERE id=$scis_id" );
			$rowCount = $wpdb->num_rows;
			if($rowCount > 0){		
				foreach($scis_row as $resultData)
				{		
					$result = stripslashes_deep($resultData->code_data);
				}

				switch ($scis_align) {
				case "left":
					$printData = '<div style="float:'.$scis_align.';padding:5px">'.$result.'</div>';
					break;
				case "right":
					$printData = '<div style="float:'.$scis_align.';padding:5px">'.$result.'</div>';
					break;
				case "center":
					$printData = '<center>'.$result.'</center><br />';
					break;
				default:
					$printData  = $result;
					break;
				}
				return $printData;
			}else{}
		}
		else{}
	}
}