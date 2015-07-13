<?php

/**
 * Plugin Name: ListenHire Widget.
 * Description: The Good Jobs ListenHire Widget.
 * Version: 1.0.0
 * Author: The Good Jobs
 * Author URI: https://thegoodjobs.com
 * License: GPL2
 */
/**
 * Adds Foo_Widget widget.
 */
class Listenhire_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'listenhire_widget', // Base ID
			__( 'ListenHire Widget', 'text_domain' ), // Name
			array( 'description' => __( 'ListenHire Widget', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
	
     	        echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		
		$a = array(
        	'hash' => get_option('lh_hash'),
        	'vert' => get_option('lh_vert'),
			'overlay' => get_option('lh_overlay'),
			'stack' => get_option('lh_stack'),
			'size' => get_option('lh_size'),
			'resp' => get_option('lh_resp'),
			'width' => get_option('lh_width'),
			'title' => get_option('lh_title'),
			'font_weight' => get_option('lh_font_weight'),
			'text_align' => get_option('lh_text_align'),
			'margin_top' => get_option('lh_margin_top'),
			'margin_bottom' => get_option('lh_margin_bottom'),
			'url' => get_option('lh_url'),
			'id' => get_option('lh_id'),
			'gray' => get_option('lh_gray'),
   		 );
		
		$widget = $this->get_widget($a);
		
		echo __($widget, 'text_domain' );
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
     	        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
	
	public function get_widget($atts){
	
		$a = shortcode_atts( array(
        	'hash' => get_option('lh_hash'),
        	'vert' => get_option('lh_vert'),
			'overlay' => get_option('lh_overlay'),
			'stack' => get_option('lh_stack'),
			'size' => get_option('lh_size'),
			'resp' => get_option('lh_resp'),
			'width' => get_option('lh_width'),
			'title' => get_option('lh_title'),
			'font_weight' => get_option('lh_font_weight'),
			'text_align' => get_option('lh_text_align'),
			'margin_top' => get_option('lh_margin_top'),
			'margin_bottom' => get_option('lh_margin_bottom'),
			'url' => get_option('lh_url'),
			'id' => get_option('lh_id'),
			'gray' => get_option('lh_gray'),
   		 ), $atts );
		
			
		if($a['width'] != 'auto'){
			$width = $a['width'] . 'px';	
		}
	 
	 if($a['margin_top']){
		$margin_top = $a['margin_top'] . 'px';	 
	 }else{
		$margin_top = 'auto'; 
	 }
	 
	 if($a['margin_bottom']){
		$margin_bottom = $a['margin_bottom'] . 'px';	 
	 }else{
		$margin_bottom = 'auto'; 
	 }
	 
	 if($a['title']){
		$title = '<div style="margin-top:' . $margin_top . ';margin-bottom:10px;text-align:'. $a['text_align'] .';font-weight:' . $a['font_weight'] . '">' . $a['title'] . '</div>';
		
		$margin_top = 'auto';
		 
	 }else{
		$title = NULL; 
	 }
	 
	 if($a['id']){
		$id = $a['id'];
	 }else{
		$id = 'tgj-badges-container';	 
	 }
	 
	 $gray = $a['gray'] == 'true' ? 'true' : 'false';
 
	 $listenHire = $title . '<div id="'.$id.'" style="' . $a['width'] . ';margin-top:'.$margin_top.';margin-bottom:'.$margin_bottom.';"></div><script src="https://thegoodjobs.com/widget/badges_js/' . $a['hash'] . '?overlay=' . $a['overlay'] . '&vert=' . $a['vert'] . '&stack=' . $a['stack'] . '&size=' . $a['size'] . '&resp=' . $a['resp'] . '&width=' . $a['width'] . '&url='.$a['url'] . '&id='.$a['id'].'&gray='.$gray.'" type="text/javascript"></script>';
	 
	 return $listenHire;
 
	}

} // class Listenhire_Widget

add_shortcode( 'listenhire', array( 'Listenhire_Widget', 'get_widget'));



// register Listenhire_Widget widget
function register_listenhire_widget() {
    register_widget( 'Listenhire_Widget' );
}
add_action( 'widgets_init', 'register_listenhire_widget' );





// create Listenhire_Widget plugin settings menu
add_action('admin_menu', 'lh_create_menu');

function lh_create_menu() {

	//create new top-level menu
	add_menu_page('ListenHire Widget Settings', 'ListenHire Widget Settings', 'administrator', __FILE__, 'lh_settings_page');

	//call register settings function
	add_action( 'admin_init', 'register_lh_settings' );
}


function register_lh_settings() {
	//register our settings
	register_setting( 'lh-settings-group', 'lh_hash' );
	register_setting( 'lh-settings-group', 'lh_vert' );
	register_setting( 'lh-settings-group', 'lh_overlay' );
	register_setting( 'lh-settings-group', 'lh_stack' );
	register_setting( 'lh-settings-group', 'lh_size' );
	register_setting( 'lh-settings-group', 'lh_resp' );
	register_setting( 'lh-settings-group', 'lh_width' );
	register_setting( 'lh-settings-group', 'lh_title' );
	register_setting( 'lh-settings-group', 'lh_font_weight' );
	register_setting( 'lh-settings-group', 'lh_text_align' );
	register_setting( 'lh-settings-group', 'lh_margin_top' );
	register_setting( 'lh-settings-group', 'lh_margin_bottom' );
	register_setting( 'lh-settings-group', 'lh_url' );
	register_setting( 'lh-settings-group', 'lh_id' );
	register_setting( 'lh-settings-group', 'lh_gray' );
}

function lh_settings_page() {
?>
<div class="wrap">
<h2>The Good Jobs - ListenHire Widget</h2>
<p>Configure your ListenHire Widget using the options below.  If you need more than once instance of the ListenHire Widget, you can always use the shortcode version and add any attributes you would like to override.</p>

<p>Shortcode: <code>[listenhire]</code></p>

<p><h3>Shortcode Options</h3>
	<ul>
    	<li><code>hash="your_company_hash"</code> <i>(string)</i> You can find this by navigating to your Dashboard -> Embed Codes & Media -> ListenHire Widget at https://thegoodjobs.com</li>
        <li><code>vert="true_or_false"</code> <i>(bool)</i> Whether you want the Culture Badges to appear vertically or horizontally.</li>
        <li><code>overlay="true_or_false"</code> <i>(bool)</i> Produces a semi-transparent overlay over your site when a Culture Badge is clicked.</li>
        <li><code>stack="true_or_false"</code> <i>(bool)</i> If you have 5 Culture Badges or more, you can choose to display them on 2 separate rows. (<code>vert="false"</code> only)</li>
        <li><code>size="small_medium_large"</code> <i>(string)</i> Select the size of the Culture Badges to display.  You can choose <code>small</code>, <code>medium</code>, or <code>large</code>.</li>
        <li><code>resp="true_false"</code> <i>(bool)</i> Select if you would like your ListenHire Widget to be responsive.</li>
        <li><code>width="container_width"</code> <i>(number)</i> Set a determined container width.</li>
        <li><code>title="your_widget_title"</code> <i>(string)</i> Add an optional tag line or title above your ListenHire Widget</li>
        <li><code>font_weight="normal_or_bold"</code> <i>(string)</i> Select whether you would like your title text to be bold.</li>
        <li><code>text_align="left_right_center"</code> <i>(string)</i> Select the justification of your title text.</li>
        <li><code>margin_top="margin_above_widget"</code> <i>(number)</i> Add a margin above the ListenHire Widget container. Example: <code>[listenhire margin_top="20"]</code> Add 20px of margin above the container.</li>
        <li><code>margin_bottom="margin_below_widget"</code> <i>(number)</i> Add a margin below the ListenHire Widget container. </li>
        <li><code>url="url"</code> <i>(url)</i> Add a custom url to The Good Jobs logo. </li>
        <li><code>id="unique_id"</code> <i>(string)</i> Add a unique ID to the div container if you would like to display more than one ListenHire Widget per page.</li>
        <li><code>gray="true_false"</code> <i>(bool)</i> Set to "True" if you would like the unearned Culture Badges you applied for to be displayed.</li>
    </ul>
</p>

<form method="post" action="options.php">
    <?php settings_fields( 'lh-settings-group' ); ?>
    <?php do_settings_sections( 'lh-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Your Company Hash</th>
        <td><input type="text" name="lh_hash" value="<?php echo esc_attr( get_option('lh_hash') ); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Container ID</th>
        <td><input type="text" name="lh_id" value="<?php echo esc_attr( get_option('lh_id') ); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Title</th>
        <td><input type="text" name="lh_title" value="<?php echo esc_attr( get_option('lh_title') ); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Title Font Weight</th>
        <td>
        	<select name="lh_font_weight">
            	<option <? echo esc_attr( get_option('lh_font_weight') ) == 'normal' ? 'selected' : '';  ?> value="normal">Normal</option>
                <option <? echo esc_attr( get_option('lh_font_weight') ) == 'bold' ? 'selected' : '';  ?> value="bold">Bold</option>
            </select>
        </td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Title Text Alignment</th>
        <td>
        	<select name="lh_text_align">
            	<option <? echo esc_attr( get_option('lh_text_align') ) == 'left' ? 'selected' : '';  ?> value="left">Left</option>
                <option <? echo esc_attr( get_option('lh_text_align') ) == 'center' ? 'selected' : '';  ?> value="center">Center</option>
                <option <? echo esc_attr( get_option('lh_text_align') ) == 'right' ? 'selected' : '';  ?> value="right">Right</option>
            </select>
        </td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Orientation</th>
        <td>
        	<select name="lh_vert">
            	<option <? echo esc_attr( get_option('lh_vert') ) == 'false' ? 'selected' : '';  ?> value="false">Horizontal</option>
                <option <? echo esc_attr( get_option('lh_vert') ) == 'true' ? 'selected' : '';  ?> value="true">Vertical</option>
            </select>
        </td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Overlay</th>
        <td>
        	<select name="lh_overlay">
            	<option <? echo esc_attr( get_option('lh_overlay') ) == 'false' ? 'selected' : '';  ?> value="false">False</option>
                <option <? echo esc_attr( get_option('lh_overlay') ) == 'true' ? 'selected' : '';  ?> value="true">True</option>
            </select>
        </td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Stack</th>
        <td>
        	<select name="lh_stack">
            	<option <? echo esc_attr( get_option('lh_stack') ) == 'false' ? 'selected' : '';  ?> value="false">False</option>
                <option <? echo esc_attr( get_option('lh_stack') ) == 'true' ? 'selected' : '';  ?> value="true">True</option>
            </select>
        </td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Badge Size</th>
        <td>
        	<select name="lh_size">
            	<option <? echo esc_attr( get_option('lh_size') ) == 'small' ? 'selected' : '';  ?> value="small">Small</option>
                <option <? echo esc_attr( get_option('lh_size') ) == 'medium' ? 'selected' : '';  ?> value="medium">Medium</option>
                <option <? echo esc_attr( get_option('lh_size') ) == 'large' ? 'selected' : '';  ?> value="large">Large</option>
            </select>
        </td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Responsive</th>
        <td>
        	<select name="lh_resp">
            	<option <? echo esc_attr( get_option('lh_resp') ) == 'false' ? 'selected' : '';  ?> value="false">False</option>
                <option <? echo esc_attr( get_option('lh_resp') ) == 'true' ? 'selected' : '';  ?> value="true">True</option>
            </select>
        </td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Width Of Container</th>
        <td><input type="text" name="lh_width" value="<?php echo esc_attr( get_option('lh_width') ) ? esc_attr( get_option('lh_width') ) : 'auto'; ?>" /> px</td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Top Margin</th>
        <td><input type="number" name="lh_margin_top" value="<?php echo esc_attr( get_option('lh_margin_top') ) ? esc_attr( get_option('lh_margin_top') ) : 'auto'; ?>" /> px</td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Bottom Margin</th>
        <td><input type="number" name="lh_margin_bottom" value="<?php echo esc_attr( get_option('lh_margin_bottom') ) ? esc_attr( get_option('lh_margin_bottom') ) : 'auto'; ?>" /> px</td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Custom URL</th>
        <td><input type="text" name="lh_url" value="<?php echo esc_attr( get_option('lh_url') ); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Show Gray Badges</th>
        <td>
        	<select name="lh_gray">
            	<option <? echo esc_attr( get_option('lh_gray') ) == 'false' ? 'selected' : '';  ?> value="false">False</option>
                <option <? echo esc_attr( get_option('lh_gray') ) == 'true' ? 'selected' : '';  ?> value="true">True</option>
            </select>
        </td>
        </tr>
         
        
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php } ?>