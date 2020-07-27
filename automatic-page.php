<?php
/*
Plugin Name: Automatic Page Generator
Plugin URI: http://dumketo.github.io/Resume/
Version: Current Version
Author: Hasan Ahmed Jobayer
Description: Automatic Page Generator Developed By Hasan Ahmed Jobayer
*/

class AutomaticPageGenerator {
	private $capability = 'manage_options';
	private $screen = 'automatic-page-genarator';
	private $admin_page = 'themes.php?page=automatic-page-genarator';

	public function __construct() {
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'add_plugin_actions_links' ) );
		add_action( 'admin_menu', array( $this, 'add_admin_menu_page' ) );
	}	
	public function add_admin_menu_page() {
		add_theme_page(
			__( 'Automatic Page Generator', 'automatic-page-genarator' ),
			__( 'Automatic Page Generator', 'automatic-page-genarator' ),
			$this->capability,
			'automatic-page-genarator',
			array( $this, 'show_settings_page' )
		);
	}
	public function show_settings_page() { ?>
		<?php 
		global $pagegenarator;
		$pagegenarator = $_POST['page-genarator'];
		if ( isset( $_REQUEST[ 'submit' ] ) ) { 
			$page = explode ( ",", $pagegenarator ); 
			foreach( $page as $page_name ) {
			    $page = array(
				    'post_title'     =>  $page_name,
				    'post_status'    =>  'publish',
				    'post_type'      =>  'page',
				    'post_author'    =>   1,
			    );
			    $create_page =  wp_insert_post( $page );
			}
		}
		?>
		<div class="wrap">
			<h2>Automatic Page Generator</h2>
			<?php if ( isset( $_REQUEST[ 'submit' ] ) ) { ?>
				<div id="message" class="updated">
					<p><strong><?php _e('Page Created Successfully.') ?></strong></p>
				</div>
			<?php } ?>

			<form method="post" action="">
				<table class="form-table">
					<tr valign="top">
						<th scope="row">Page Name List</th>
						<td><textarea name="page-genarator" id="page-genarator" cols="30" rows="10" style="width: 50%;"><?php echo esc_attr( get_option('page-genarator') ); ?></textarea>
						<p>page name separated by comma</p>
						</td>

					</tr>
				</table>
				<p class="submit"><?php echo get_submit_button( 'Automatic Page Generator', 'secondary large', 'submit', false ); ?></p>
			</form>
		</div>
	<?php }
	public function add_plugin_actions_links( $links ) {
		return array_merge(
			array( '<a href="' . admin_url( $this->admin_page ) . '">Settings</a>' ),
			$links
		);
	}
}
new AutomaticPageGenerator;