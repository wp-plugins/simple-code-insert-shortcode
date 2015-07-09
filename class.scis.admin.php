<?php

class Scis_Admin{

	private static $initiated = false;	

	public static function init() {
		if ( ! self::$initiated ) {
			self::init_hooks();
		}
	}

	public static function init_hooks() {

		self::$initiated = true;

		add_action( 'admin_menu', array( 'Scis_Admin', 'admin_menu' ));
		add_action( 'admin_enqueue_scripts', array( 'Scis_Admin', 'load_resources' ));
		add_action('wp_print_scripts', array('Scis_Admin','scis_ajax_load_request'));
		add_action('wp_ajax_scis_process', array('Scis_Admin','process_ajax_request'));
	}

	public static function admin_menu() {
		self::load_menu();
	}

	public static function load_menu() {
		$hook = add_options_page( __('SCI Shortcode', 'scis'), __('SCI Shortcode', 'scis'), 'manage_options', 'simple-code-insert-shortcode', array( 'Scis_Admin', 'display_page' ) );		
	}

	public static function load_resources() {
		
		wp_register_style( 'scis.css', SCIS_PLUGIN_URL .'_inc/scis.css', false, SCIS_VERSION );
		wp_enqueue_style( 'scis.css');

		wp_register_script( 'scis.js', SCIS_PLUGIN_URL . '_inc/scis.js', array('jquery'), SCIS_VERSION );
		wp_enqueue_script( 'scis.js' );

	}

	public static function scis_ajax_load_request(){
		wp_localize_script( 'scis.js', 'scis_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}

	public static function process_ajax_request() {
		
		global $wpdb;

		$_POST = array_map( 'stripslashes_deep', $_POST );

		$response = "";

		switch ($_POST['post_type']) {

			case 'add':

				$post_cname = $_POST['post_cname'];
				$post_cdata = $_POST['post_cdata'];

				if(($post_cname && $post_cdata) == ''){
					$response = '<div class="scis-alert scis-alert-danger">All fields required.</div>';
				}
				else{
					$wpdb->insert( 
						$wpdb->prefix.SCIS_TABLE_NAME, 
						array( 
						    'id' => '', 
						    'code_name' => self::scis_clean_string($post_cname),
						    'code_data' => $post_cdata
						), 
						array( 
							'%d',
						    '%s', 
						    '%s' 
						) 
					);

					$response = '<div class="scis-alert scis-alert-success">New shortcode successfully added.</div>';
				}

				break;
			case 'edit':

				$scis_data = self::scis_get_shortcode($_POST['post_id']);

				$response = '
					<h2>Edit Shortcode ID#'.$scis_data->id.'</h2><br />					
					<form method="post" class="scis_form_modify" action="javascript:void(0)">
						<input type="hidden" id="mid" value="'.$scis_data->id.'"/>
						<input type="hidden" id="mtype" value="modify"/>						
						<label for="codename">Name</label><br /><input type="text" id="mcode_name" maxlength="50" style="width: 100%;" value="'.$scis_data->code_name.'"/><br /><br />
					
						<label for="codedata">Code Data</label><br /><textarea id="mcode_data" style="width: 100%;height: 110px !important;">'.$scis_data->code_data.'</textarea><br /><br />
					
						<input type="submit" id="ModifyBtn" name="Save" value="Save" class="button button-primary" />						
					</form>
				';
				break;
			case 'delete':
				
				$wpdb->delete( 
					$wpdb->prefix.SCIS_TABLE_NAME, 
					array( 
						'id' => $_POST['post_id'],						
					), 
					array( 				
						'%d'				
					) 
				);

				$response = 'Shortcode ID '.$_POST['post_id'].' successfully deleted.';
				break;

			case 'modify':

				$post_cname = self::scis_clean_string($_POST['post_cname']);
				$post_cdata = $_POST['post_cdata'];

				if(($post_cname && $post_cdata) == ''){
					$response = '<div class="scis-alert scis-alert-danger">All fields required.</div>';
				}
				else{

					$wpdb->update( 
						$wpdb->prefix.SCIS_TABLE_NAME, 
						array( 
					        'id' => $_POST['post_id'], 
						    'code_name' => $post_cname,
							'code_data' => $post_cdata
						), 
						array( 'id' => $_POST['post_id'] ), 
						array( 
					        
					        '%d',
						    '%s', 
						    '%s'  
						),
						array( '%d' )
					);

					$response = '<div class="scis-alert scis-alert-success">Shortcode ID '.$_POST['post_id'].' successfully modified.</div>';
				}
				break;			
			default:
				
				break;
		}

		echo $response;
		wp_die();
	}
	

	public static function display_page() {		
		self::display_dashboard();
	}	

	public static function display_dashboard(){
		
		echo '<h2 class="scis-header">'.esc_html__('Simple Code Insert Shortcode', 'scis').'</h2>';

		require_once( SCIS_PLUGIN_DIR . 'views/dashboard.php' );
	}

	public static function scis_all(){
    	
    	global $wpdb;

    	$data = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.SCIS_TABLE_NAME.'', OBJECT );

    	return $data;
    }  

    public static function scis_get_shortcode($id){

    	global $wpdb;

    	$scis_row = $wpdb->get_row( "SELECT * FROM $wpdb->prefix".SCIS_TABLE_NAME." WHERE id = $id");

    	return $scis_row;
    }

    private static function scis_clean_string($string)
	{
		$string = strtolower($string);
	    $str_data = preg_replace('/[^a-z0-9 -]+/', '', $string);
	    return $str_data; 
	}

}