<?php
error_log("In File");
if ( ! defined( 'ABSPATH' ) ) exit;
require_once( 'class-wp-legal-pages-admin.php' );
global $wpdb;
$lpObj = new WP_Legal_Pages();
//$lpObj->lp_enqueue_editor();

if(!empty($_POST) && isset($_POST['lp-submit'])){
	if(isset($_POST['lp_eu_status']))
	update_option('lp_eu_cookie_enable',sanitize_text_field($_POST['lp_eu_status']));
	else
	update_option('lp_eu_cookie_enable','off');
	update_option('lp_eu_cookie_title',addslashes(sanitize_text_field($_POST['lp_eu_title'])));
	update_option('lp_eu_cookie_message',htmlentities(sanitize_text_field($_POST['lp_eu_message'])));
	update_option('lp_eu_box_color',sanitize_text_field($_POST['lp_eu_box_color']));
	update_option('lp_eu_button_color',sanitize_text_field($_POST['lp_eu_button_color']));
	update_option('lp_eu_button_text_color',sanitize_text_field($_POST['lp_eu_button_text_color']));
	update_option('lp_eu_text_color',sanitize_text_field($_POST['lp_eu_text_color']));

	update_option('lp_eu_button_text',sanitize_text_field($_POST['lp_eu_button_text']));
	update_option('lp_eu_link_text',sanitize_text_field($_POST['lp_eu_link_text']));
	update_option('lp_eu_link_url',sanitize_text_field($_POST['lp_eu_link_url']));
	update_option('lp_eu_text_size',sanitize_text_field($_POST['lp_eu_text_size']));
		update_option('lp_eu_link_color',sanitize_text_field($_POST['lp_eu_link_color']));
}

$lp_eu_get_visibility=get_option('lp_eu_cookie_enable');
$lp_eu_title=get_option('lp_eu_cookie_title');
$lp_eu_message=get_option('lp_eu_cookie_message');
$lp_eu_box_color=get_option('lp_eu_box_color');
$lp_eu_button_color=get_option('lp_eu_button_color');
$lp_eu_button_text_color=get_option('lp_eu_button_text_color');
$lp_eu_text_color=get_option('lp_eu_text_color');


$lp_eu_button_text=get_option('lp_eu_button_text');
$lp_eu_link_text=get_option('lp_eu_link_text');
$lp_eu_link_url=get_option('lp_eu_link_url');
$lp_eu_text_size=get_option('lp_eu_text_size');
$lp_eu_link_color=get_option('lp_eu_link_color');

wp_enqueue_script( 'jquery-minicolor',  $this->plugin_url. '/wp-content/plugins/wp-legal-pages/admin/js/jquery.miniColors.min.js', array('jquery') );
wp_enqueue_style('jquery-miniColor',$this->plugin_url. '/wp-content/plugins/wp-legal-pages/admin/css/minicolor/jquery.miniColors.css');

//Form validation library file
wp_enqueue_script('jquery-validation-plugin', $this->plugin_url.'/wp-content/plugins/wp-legal-pages/admin/js/jquery.validate.min.js', array('jquery'));

?>
    <h2 class="title-head"> EU Cookies </h2>
    <div style="clear:both;"></div>
    <div class="wrap">
        <div class="postbox all_pad">
            <form id="lp_eu_cookies_form" enctype="multipart/form-data" method="post" action="" name="terms">
                <div class="row">
                    <div class="col-md-9">
                        <label class="field_title"> Cookie Bar : </label>
                        <label class="switch">
                            <input type="checkbox" <?php if($lp_eu_get_visibility=='ON' ) echo 'checked'; ?> name="lp_eu_status" value="ON" >
                            <div class="slider round"></div>
                        </label>
                        <p class="top_pad">
                            <label class="field_title"> Cookie Title : </label>
                            <input type="text" value="<?php echo stripslashes($lp_eu_title); ?>" style="width:50%;" id="lp-title" name="lp_eu_title"> </p>
                        <div class="row">
                            <label class="field_title left_pad"> Cookie Message Body : </label>
                            <div id="poststuff">
                                <div id="<?php echo user_can_richedit() ? 'postdivrich' : 'postdiv'; ?>">
                                    <?php wp_editor(stripslashes(html_entity_decode($lp_eu_message)),'content'); ?>
                                </div>
                                <script type="text/javascript">
                                    jQuery(document).ready(function () {
                                        jQuery(".lp_eu_colors").miniColors({
                                            change: function (hex, rgb) {}
                                        });

                                    // Form validation        
                                    jQuery("#lp_eu_cookies_form").validate();    
                                    });

									function sp_content_save() {
                                            var obj = document.getElementById('lp-content');
	                                        var content = document.getElementById('content');
	                                        tinyMCE.triggerSave(0, 1);
	                                        obj.value = content.value;
                                    }
                                </script>
                                <textarea id="lp-content" name="lp_eu_message" value="5" style="display:none" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="field_title"> Box Background Color : </label>
                        <br>
                        <input type="text" class="lp_eu_colors" name="lp_eu_box_color" value="<?php echo $lp_eu_box_color; ?>" />
                        <br>
                        <label class="field_title top_pad"> Box Text Color : </label>
                        <br>
                        <input type="text" class="lp_eu_colors" name="lp_eu_text_color" value="<?php echo $lp_eu_text_color; ?>" />
                        <br>
                        <label class="field_title top_pad"> Button Background Color : </label>
                        <br>
                        <input type="text" class="lp_eu_colors" name="lp_eu_button_color" value="<?php echo $lp_eu_button_color; ?>" />
                        <br>
                        <label class="field_title top_pad"> Button Text Color : </label>
                        <br>
                        <input type="text" class="lp_eu_colors" name="lp_eu_button_text_color" value="<?php echo $lp_eu_button_text_color; ?>" />
                        <br>
                        <label class="field_title top_pad"> Link Color : </label>
                        <br>
                        <input type="text" class="lp_eu_colors" name="lp_eu_link_color" value="<?php echo $lp_eu_link_color; ?>" />
                        <br>
                        <label class="field_title top_pad"> Button Text : </label>
                        <br>
                        <input type="text" id='lp_eu_button_text' name="lp_eu_button_text" value="<?php echo (isset($lp_eu_button_text) && !empty($lp_eu_button_text) ) ? $lp_eu_button_text : 'I agree'; ?>" required />
                        <br>
                        <label class="field_title top_pad"> Link Text : </label>
                        <br>
                        <input type="text" name="lp_eu_link_text" value="<?php echo $lp_eu_link_text; ?>" />
                        <br>
                        <label class="field_title top_pad"> Link URL : </label>
                        <br>
                        <input type="text" name="lp_eu_link_url" value="<?php echo $lp_eu_link_url; ?>" />
                        <br>
                        <label class="field_title top_pad"> Text Size : </label>
                        <br>
                        <select name="lp_eu_text_size" style="width:100px;">
                            <?php
							// This loop is for font-size
							for($i=10; $i<32; $i++)
							{ ?>
                                <option value="<?php echo $i; ?>" <?php if($lp_eu_text_size== $i)echo "selected"; ?>>
                                    <?php echo $i; ?>
                                </option>
                                <?php $i++; }
							?>
                        </select>
                        <br>
                        <p class="top_pad">
                            <input type="submit" class="btn btn-primary" onclick="sp_content_save();" name="lp-submit" value="Update" /> </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
