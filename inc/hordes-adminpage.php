<?php
/**
 * Hordes admin setting page
 * @since 1.0.5
 */  
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'admin_menu', 'hordes_add_admin_menu' );
add_action( 'admin_init', 'hordes_settings_init' );

function hordes_add_admin_menu() {

    add_submenu_page( 
        'edit.php?post_type=hordes', 
    __( 'Settings', 'hordes'), 
    __( 'Hordes Settings', 'hordes'),
    'manage_options', 
    'hordes', 
    'hordes_options_page' 
    );

}

//settings and the options for admin
function hordes_settings_init( ) {

    register_setting( 'adminPage', 'hordes_settings' );

    add_settings_section(
        'hordes_adminPage_section',
        __( 'Hordes Curated List', 'hordes' ),
        'hordes_settings_section_callback',
        'adminPage'
    );
    add_settings_field(
        'hordes_use_formpage',
        __( 'Check to remove favicons.', 'hordes' ),
        'hordes_use_formpage_render',
        'adminPage',
        'hordes_adminPage_section'
    );
    add_settings_field(
        'hordes_checkbox_1',
        __( 'Check to use Short list.', 'hordes' ),
        'hordes_checkbox_1_render',
        'adminPage',
        'hordes_adminPage_section'
    );
    add_settings_field(
        'hordes_color_field_3',
         __( 'Color for List Title', 'hordes' ),
        'hordes_color_field_3_render',
        'adminPage',
        'hordes_adminPage_section'
    );
    add_settings_field(
        'hordes_color_field_4',
         __( 'Color for List Links', 'hordes' ),
        'hordes_color_field_4_render',
        'adminPage',
        'hordes_adminPage_section'
    ); 
    add_settings_field(
        'hordes_color_field_5',
         __( 'Color for Main Background', 'hordes' ),
        'hordes_color_field_5_render',
        'adminPage',
        'hordes_adminPage_section'
    ); 
    add_settings_field(
        'hordes_color_field_6',
         __( 'Color for Custom Sidebar', 'hordes' ),
        'hordes_color_field_6_render',
        'adminPage',
        'hordes_adminPage_section'
    ); 
    add_settings_field(
        'hordes_text_field_0',
        __( 'What Page is shortcode &#39;hordes_list&#39; on?', 'hordes' ),
        'hordes_text_field_0_render',
        'adminPage',
        'hordes_adminPage_section'
    ); 
    //rediradmin_dropdown
    add_settings_field(
        'hordes_rediradmin_dropdown',
        __( 'What Page is shortcode &#39;hordes_submit_post&#39; on?', 'hordes' ),
        'hordes_rediradmin_dropdown_render',
        'adminPage',
        'hordes_adminPage_section'
    ); 
    add_settings_field(
        'hordes_checkbox_rediradmin',
        __( 'Redirect on Login', 'hordes' ),
        'hordes_checkbox_rediradmin_render',
        'adminPage',
        'hordes_adminPage_section'
    ); 
    //hordes_checkbox_alphaqwerty
    add_settings_field(
        'hordes_checkbox_alphaqwerty',
        __( 'Set QWERTY Search', 'hordes' ),
        'hordes_checkbox_alphaqwerty_render',
        'adminPage',
        'hordes_adminPage_section'
    ); 
    //hordes_checkbox_alphaqwerty
    add_settings_field(
        'hordes_icons_alphaqwerty',
        __( 'Set Position of letters', 'hordes' ),
        'hordes_icons_alphaqwerty_render',
        'adminPage',
        'hordes_adminPage_section'
    ); 

}

/**
 * Render the branding colors option
 * @string $def = default color
 * @since  1.0.3
 */
function hordes_color_field_3_render() 
{ 
    
    $def = "#002e63";
    $options = get_option('hordes_settings'); 
    $hordes_color_3 = (empty( $options['hordes_color_field_3'] ) ) ?  
    $hordes_color_3 = $def : 
    $hordes_color_3 = $options['hordes_color_field_3'];
    ?>
    <label class="olmin">
        <?php esc_html_e( 'Select color for title.', 'hordes'  ); ?></label>
    <input type="text" 
           id="color_wrap" 
           name="hordes_settings[hordes_color_field_3]"
           class="hordes-color-field" data-default-color="#002e63"
           value="<?php echo esc_attr( $hordes_color_3 ); ?>"><br>
<?php     
}
/**
 * Render the branding colors option
 * @string $def = default color
 * @since  1.0.3
 */
function hordes_color_field_4_render() 
{ 
    
    $def = "#3388bb";
    $options = get_option('hordes_settings'); 
    $hordes_color_4 = (empty( $options['hordes_color_field_4'] ) ) ?  
    $hordes_color_4 = $def : 
    $hordes_color_4 = $options['hordes_color_field_4'];
    ?>
    <label class="olmin">
        <?php esc_html_e( 'Select color for link.', 'hordes'  ); ?></label>
    <input type="text" 
           id="color_wrap" 
           name="hordes_settings[hordes_color_field_4]"
           class="hordes-color-field" data-default-color="#3388bb"
           value="<?php echo esc_attr( $hordes_color_4 ); ?>"><br>
<?php     
}
/**
 * Render the branding colors option
 * @string $def = default color
 * @since  1.0.3
 */
function hordes_color_field_5_render() 
{ 
    
    $def = "#fafafa";
    $options = get_option('hordes_settings'); 
    $hordes_color_5 = (empty( $options['hordes_color_field_5'] ) ) ?  
    $hordes_color_5 = $def : 
    $hordes_color_5 = $options['hordes_color_field_5'];
    ?>
    <label class="olmin">
        <?php esc_html_e( 'Select color', 'hordes'  ); ?></label>
    <input type="text" 
           id="color_wrap" 
           name="hordes_settings[hordes_color_field_5]"
           class="hordes-color-field" data-default-color="#fafafa"
           value="<?php echo esc_attr( $hordes_color_5 ); ?>">
           <small><?php esc_html_e( '(Effects both content of single and content of list page)', 
           'hordes' ); ?></small>
<?php     
}
/**
 * Render the branding colors option
 * @string $def = default color
 * @since  1.0.3
 */
function hordes_color_field_6_render() 
{ 
    
    $def = "#fafafa";
    $options = get_option('hordes_settings'); 
    $hordes_color_6 = (empty( $options['hordes_color_field_6'] ) ) ?  
    $hordes_color_6 = $def : 
    $hordes_color_6 = $options['hordes_color_field_6'];
    ?>
    <label class="olmin">
        <?php esc_html_e( 'Select color', 'hordes'  ); ?></label>
    <input type="text" 
           id="color_wrap" 
           name="hordes_settings[hordes_color_field_6]"
           class="hordes-color-field" data-default-color="#fafafa"
           value="<?php echo esc_attr( $hordes_color_6 ); ?>"><br>
<?php     
}
/**
 * checkbox for 'use shortcode' field
 * @since 1.0.1
 */
function hordes_use_formpage_render() {
    $options = get_option('hordes_settings'); 
    $hordes_use_formpage = (empty($options['hordes_use_formpage'] )) 
                          ? 0 : $options['hordes_use_formpage']; ?>
 <p><input type="hidden" 
           name="hordes_settings[hordes_use_formpage]" 
           value="0" />
    <input name="hordes_settings[hordes_use_formpage]" 
           value="1" 
           type="checkbox" <?php echo esc_attr( 
           checked( 1, $hordes_use_formpage, true ) ); ?> /> 	
    <?php esc_html_e( 'Check to not show favicons in the Tall list (Optional)', 'hordes' ); ?></p>
    <small><?php esc_html_e( 'By removing favicons in your list it saves some bandwidth*', 
    'hordes' ); ?> </small>
    <?php  
} 
/**
 * checkbox for 'excerpts height' field
 * @since 1.0.1
 */
function hordes_checkbox_1_render() {
    $options = get_option('hordes_settings'); 
    $hordes_checkbox_1 = (empty($options['hordes_checkbox_1'] )) 
                          ? 0 : $options['hordes_checkbox_1']; ?>
 <p><input type="hidden" 
           name="hordes_settings[hordes_checkbox_1]" 
           value="0" />
    <input name="hordes_settings[hordes_checkbox_1]" 
           value="1" 
           type="checkbox" <?php echo esc_attr( 
           checked( 1, $hordes_checkbox_1, true ) ); ?> /> 	
    <?php esc_html_e( 'Check to Show a lower profile list of links.', 'hordes' ); ?></p>
    <small><?php esc_html_e( 'Shorter list displays only the title and the link.', 
    'hordes' ); ?> </small>
    <?php  
}

/**
 * Retrieve or display list of pages as a dropdown (select list).
 * 
 * @uses wp_dropdown_pages
 */
function hordes_text_field_0_render()
{

    global $post;
    $label    = '';
    $shrtpage = (empty ( get_option('hordes_settings')['hordes_text_field_0'] )) ? '0' : get_option('hordes_settings')['hordes_text_field_0'];
    $dropdown = wp_dropdown_pages( array(
        'post_type'        => 'page', 
        'selected'         => esc_attr( $shrtpage ), 
        'name'             => 'hordes_settings[hordes_text_field_0]', 
        'show_option_none' => '-- Select Page --', 
        'option_none_value' => '0',
        'sort_column'      => 'menu_order, post_title', 
        'echo'             => 0 
    ) ); 
    $dropdown = str_replace('<select', '<select ' . $shrtpage, $dropdown);
    printf('<label class="form-control-select"><span 
        class="form-control-title">%s</span> %s</label>', 
        $label,                         // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        $dropdown                       // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    );
    printf( '<p><small>%s </small>%s</p>',
    esc_html__( 'This must be set if you want a Return Link on the form success message.', 'hordes' ),
    '' ); //add $shrtpage to debug
}

/**
 * Retrieve or display list of pages as a dropdown (select list).
 * 
 * @uses wp_dropdown_pages
 */
function hordes_rediradmin_dropdown_render()
{

    $label    = '';
    $shrtpage = (empty (get_option('hordes_settings')['hordes_rediradmin_dropdown'] )) ? '0' : get_option('hordes_settings')['hordes_rediradmin_dropdown'];
    $dropdown = wp_dropdown_pages( array(
        'post_type'        => 'page', 
        'selected'         => esc_attr( $shrtpage ), 
        'name'             => 'hordes_settings[hordes_rediradmin_dropdown]', 
        'show_option_none' => '-- Select Page --', 
        'option_none_value' => '0',
        'sort_column'      => 'menu_order, post_title', 
        'echo'             => 0 
    ) ); 
    $dropdown = str_replace('<select', '<select ' . $shrtpage, $dropdown);
    printf('<label class="form-control-select"><span 
        class="form-control-title">%s</span> %s</label>', 
        $label,                             // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        $dropdown                           // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    );
    printf( '<p><small>%s </small>%s</p>',
    esc_html__( 'Set page to be redirected upon login. Turn on or off below.', 'hordes' ),
    '' ); //add $shrtpage to debug
}
/**
 * checkbox for 'redir admin' field
 * @since 1.0.1
 */
function hordes_checkbox_rediradmin_render() {
    $options = get_option('hordes_settings'); 
    $hordes_checkbox_rediradmin = (empty($options['hordes_checkbox_rediradmin'] )) 
                          ? 0 : $options['hordes_checkbox_rediradmin']; ?>
    <p><input type="hidden" 
           name="hordes_settings[hordes_checkbox_rediradmin]" 
           value="0" />
    <input name="hordes_settings[hordes_checkbox_rediradmin]" 
           value="1" 
           type="checkbox" <?php echo esc_attr( 
           checked( 1, $hordes_checkbox_rediradmin, true ) ); ?> /> 	
    <?php esc_html_e( 'Check to Redirect directly to Form Submit Page', 'hordes' ); ?></p>
    <small><?php esc_html_e( 'Only works for logged In Administrators.', 
    'hordes' ); ?> </small>
    <?php  
}
/**
 * checkbox for 'alphaqwerty' field
 * @since 1.0.1
 * @input checkbox
 */
function hordes_checkbox_alphaqwerty_render() {
    $options = get_option('hordes_settings'); 
    $hordes_checkbox_alphaqwerty = (empty($options['hordes_checkbox_alphaqwerty'] )) 
                          ? 0 : $options['hordes_checkbox_alphaqwerty']; ?>
 <p><input type="hidden" 
           name="hordes_settings[hordes_checkbox_alphaqwerty]" 
           value="0" />
    <input name="hordes_settings[hordes_checkbox_alphaqwerty]" 
           value="1" 
           type="checkbox" <?php echo esc_attr( 
           checked( 1, $hordes_checkbox_alphaqwerty, true ) ); ?> /> 	
    <?php esc_html_e( 'Check to change Alphabetic search to Keyboard style ', 'hordes' ); ?></p>
    <small><?php esc_html_e( 'Change if search looks funny on phones.', 'hordes' ); ?> </small>
    <?php  
}
/**
 * position of icons field
 * @since 1.0.0
 */
function hordes_icons_alphaqwerty_render()
{
    $options = get_option('hordes_settings');
    $val     = ( empty ( $options['hordes_icons_alphaqwerty'] )) 
               ? '6' : $options['hordes_icons_alphaqwerty']; ?>
    <label class="olmin"><?php esc_html_e( 'Set position of letters in the search widget.', 
        'hordes' ); ?></label>
    <input type="number" name="hordes_settings[hordes_icons_alphaqwerty]" 
           value="<?php echo esc_attr( $val ); ?>"
           min="-9999" max="9999" /> <br>
    <small><?php esc_html_e( 'Set accordingly if theme changed or looks out of line.', 
        'hordes' ); ?></small>
    <?php
} 
//render section
function hordes_settings_section_callback()
{
    echo '<div class="hrds-clearfix"></div>';
}


//create page
function hordes_options_page() 
{
    // check user capabilities
    //if ( ! current_user_can( 'manage_options' ) ) return;
    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        // add settings saved message with the class of "updated"
        add_settings_error( 'hordes_messages', 'hordes_message', 
                        __( 'Settings Saved', 'hordes' ), 'updated' );
    }
    // show error/update messages
    settings_errors( 'hordes_messages' ); ?>
    <?php
    //$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'adminPg';
    ?>
    <div class="hordes_wrap wrap">

        <h2><?php esc_html_e( 'Plugin Options Page', 'hordes' ); ?></h2>
  
    <form action="options.php" method="post">
        <?php 
        settings_fields( 'adminPage' );
        do_settings_sections( 'adminPage' );
        submit_button(); 
        ?>
    </form>

<?php 
 
/**
 * documentation render
 */

ob_start(); 
?>
<div style="max-width:749px;word-wrap:break-word">
<table class="form-table"><tbody style="background: #fdfdfd;">
    <tr><td><h2><?php esc_html_e( 'Instructions', 'hordes' ); ?></h2></td></tr>
    <tr><td><h4><?php esc_html_e( 'Show List', 'hordes' ); ?></h4>
<p><?php esc_html_e( 'The shortcode to add inside of a page to show list is: ', 'hordes' ); ?> [hordes_list&#93;</p>
<p>*<small><?php esc_html_e( 'Favicons are loaded from the Google favicons generator. More info at: https://www.labnol.org/internet/get-favicon-image-of-websites-with-google/4404/', 'hordes' ); ?></small></p>
<p><?php esc_html_e( 'What is a favicon? ', 'hordes' ); ?> <small><?php esc_html_e( 'An icon associated with a URL that is variously displayed, as in a browser&#39;s address bar or next to the site name in a bookmark list.', 'hordes' ); ?></small></p></td></tr>
<tr><td><h4><?php esc_html_e( 'Show Alpha Checkbox Search Bar', 'hordes' ); ?></h4>
<p><?php esc_html_e( 'The shortcode to add inside of your post or page to show a custom alphabetic search bar is:  ', 'hordes' ); ?> [hordes_search_bar&#93;</p>
*<small><?php esc_html_e( 'Works for categories as well as links and titles.', 'hordes' ); ?></small></td></tr>

<tr><td><h4><?php esc_html_e( 'Front Side Submit Form', 'hordes' ); ?></h4>
<p><?php esc_html_e( 'To add a front end form to a page use shortcode: [hordes_submit_post&#93; ', 'hordes' ); ?></p>
<small><?php esc_html_e( 'The form will allow you to add title, link and tags to your post, but, only Administrators and Editors will see the form on the public side of your Website. A Featured Image maybe added to every listing but you will need to do this from the editor so that you can control the assets for each picture.', 'hordes' ); ?></small> </td></tr>
<tr><td><p><img src="<?php echo esc_url( HORDES_FORMS_URL ) . 'css/tswlogo.png'; ?>" alt="Hordes" title="Website Development by Tradesouthwest" width="40" /></h2>
<em>Hordes - by Tradesouthwest =|=</em><?php esc_html_e( 'Support at ', 'hordes' ); ?> <a href="https://themes.tradesouthwest.com/support/" title="online presence" target="_blank">themes.tradesouthwest.com/support </a> <small><?php esc_html_e( '(Opens in new window.)', 'hordes' ); ?></small></p></td></tr>
</tbody></table>

</div>
    <hr><div class="hrds-clearfix"></div>

<div style="max-width:749px;word-wrap:break-word;height: 100%;"> 
    <h2><?php esc_html_e( 'Helpful Information to get you started', 'hordes' ); ?></h2>
<dl>
 	<dt><b><?php esc_html_e( 'Login Options', 'hordes' ); ?></b></dt>
 	<dd><strong><span style="color: #000000;"><span class="info"><?php esc_html_e( 'Upon install of Hordes you may want to set the option to redirect upon login so that you can go directly to the form page each time you login.', 'hordes' ); ?></span><sup>*</sup></span></strong></dd>
 	<dd></dd>
 	<dt><b><?php esc_html_e( 'Setup', 'hordes' ); ?></b></dt>
 	<dd><?php esc_html_e( 'This section describes how to install the plugin and get it working.', 'hordes' ); ?></dd>
 	<dd><?php esc_html_e( '1. The shortcode to add inside of your post or page to show list is: ', 'hordes' ); ?><br> [hordes_list&#93; </dd>
 	<dd><?php esc_html_e( '2. The shortcode to add inside of your post or page to show a custom alphabetic search bar is: ', 'hordes' ); ?><br> [hordes_search_bar] </dd>
 	<dd><?php esc_html_e( '3. To add a front end form to a page use shortcode: ', 'hordes' ); ?><br> [hordes_submit_post&#93; </dd>
 	<dd><?php esc_html_e( '4. Go through all options in Hordes Settings to activate what you want to use.', 'hordes' ); ?></dd>
    <dd><img src="<?php echo esc_url( HORDES_FORMS_URL ) . 'docs/imgs/hordes-editor-shortcode.png'; ?>" alt="Hordes" width="380" />
    <figcaption><?php esc_attr_e( 'Where to place a shortcode on page. This example includes Search Bar above List.', 'hordes' ); ?></figcaption></dd>
    <dd></dd>
    <dt><b><?php esc_html_e( 'Check to not show favicons in the Tall list (Optional)', 'hordes' ); ?></b></dt>
 	<dd><?php esc_html_e( 'By removing favicons in your list it saves some bandwidth. Favicons are loaded from the Google favicons generator. More info at: ', 'hordes' ); ?> https://www.labnol.org/internet/get-favicon-image-of-websites-with-google/4404/</dd>
    <dd></dd> 
    <dt><b><?php esc_html_e( 'Check to Show a lower profile list of links.', 'hordes' ); ?></b></dt>
 	<dd><?php esc_html_e( 'Shorter list displays only the title and the link.', 'hordes' ); ?></dd>
 	<dt><b><?php esc_html_e( 'Color for List Title', 'hordes' ); ?></b></dt>
 	<dd><?php esc_html_e( 'If field is left unchanged then the titles will stay the same as the theme default titles color.', 'hordes' ); ?></dd>
 	<dt><b><?php esc_html_e( 'Color for List Links', 'hordes' ); ?></b></dt>
 	<dd><?php esc_html_e( 'Colors can be set to help brand your page to match your theme.', 'hordes' ); ?></dd>
 	<dt><b><?php esc_html_e( 'What Page is shortcode &#39;hordes_list&#39; on?', 'hordes' ); ?></b></dt>
 	<dd><?php esc_html_e( 'This must be set if you want a link on the form page. The link will show on the popup "Success" message after submitting your new link.', 'hordes' ); ?></dd>
 	<dt><b><?php esc_html_e( 'What Page is shortcode &#39;hordes_submit_post&#39; on?', 'hordes' ); ?></b></dt>
 	<dd><?php esc_html_e( 'Set page to be redirected upon login. Turn on or off Using the next setting below.', 'hordes' ); ?></a></dd>
 	<dd><small><?php esc_html_e( 'This is only a convenience to administrators to save time when you are in a hurry to add links.', 'hordes' ); ?></small></dd>
 	<dt><b><?php esc_html_e( 'Redirect on Login', 'hordes' ); ?></b></dt>
 	<dd><?php esc_html_e( 'Check to Redirect directly to Form Submit Page. Only works for logged In Administrators.', 'hordes' ); ?></dd>
 	<dt><b><?php esc_html_e( 'Front Side Submit Form', 'hordes' ); ?></b></dt>
 	<dd><?php esc_html_e( 'The form will allow you to add title, link and tags to your post, but, only Administrators and Editors will see the form on the public side of your Website. A Featured Image maybe added to every listing but you will need to do this from the editor so that you can control the assets for each picture. To add a front end form to a page use shortcode: ', 'hordes' ); ?> [hordes_submit_post&#93; <br></dd>
 	<dt><b><?php esc_html_e( 'Show Alpha Checkbox Search Bar', 'hordes' ); ?></b></dt>
 	<dd><?php esc_html_e( 'The shortcode to add inside of your post or page to show a custom alphabetic search bar is: ', 'hordes' ); ?> [hordes_search_bar&#93; <br><?php esc_html_e( 'Works for categories as well as links and titles.', 'hordes' ); ?></dd>
</dl> <div class="hrds-clearfix"></div> 
</div>
</div><br>
<?php 
echo wp_kses_post( ob_get_clean() );
} 