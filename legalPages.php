<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if ( !class_exists('legalPages') ) :
	class legalPages
	{
		var $plugin_url;
		var $plugin_image_url;
		var $tablename;
		var $popuptable;
		 function __construct()
		{
			global $table_prefix;
			//$this->plugin_url = trailingslashit( WP_PLUGIN_URL.'/'.dirname( plugin_basename(__FILE__) ));
			//$this->plugin_image_url = trailingslashit( WP_PLUGIN_URL.'/'.dirname( plugin_basename(__FILE__) )).'images/';
			$this->tablename = $table_prefix . "legal_pages";
			$this->popuptable = $table_prefix . "lp_popups";
			add_action('admin_menu', array($this, 'admin_menu'));
			add_action( 'init', array( $this, 'admin_css' ) );
			add_filter('the_content', array($this,'lpShortcode'));
			add_filter('the_excerpt', array($this,'lpShortcode'));
		}

		function admin_menu()
		{
			add_menu_page(__('Legal Pages','legal-pages'), 'Legal Pages', 'manage_options', 'legal-pages', array($this, 'adminSetting'));
			$terms = get_option('lp_accept_terms');
			if($terms == 1){
				add_submenu_page(__('legal-pages','legal-pages'), 'Settings', 'Settings', 'manage_options', 'legal-pages', array($this, 'adminSetting'));
				add_submenu_page(__('legal-pages','legal-pages'), 'Legal Pages', 'Legal Pages', 'manage_options', 'showpages', array($this, 'showpages'));
				add_submenu_page(__('legal-pages','legal-pages'), 'Create Page', 'Create Page', 'manage_options', 'lp-create', array($this, 'createPage'));
			}
		}

		function admin_css() {
		  if (isset($_GET['page'])) {
            if ($_GET['page'] == "lp-create" ||$_GET['page'] == "legal-pages") {
               wp_enqueue_style('legalpagecss',WP_PLUGIN_URL."/WP-Legal-Pages/style.css" );
               wp_enqueue_style('legalpagecss');
             }
		  }
		}

		function createPage()
		{       require_once( 'legalPages.php' );
			include_once('admin/createPage.php');
		}

	    function showpages()
		{
                        require_once( 'legalPages.php' );
			include_once('admin/showpages.php');
		}

		function adminSetting()
		{
                        require_once( 'legalPages.php' );
			include_once("admin/adminSetting.php");
		}

		function deactivate()
		{
			delete_option('lp_accept_terms');
		}

		function lpShortcode($content)
		{
			$lp_find = array("[Domain]","[Business Name]","[Phone]","[Street]","[City, State, Zip code]","[Country]","[Email]","[Address]","[Niche]");
			$lp_general = get_option('lp_general');
			$cont = str_replace($lp_find,$lp_general,stripslashes($content));
			return $cont;
		}
		function install()
		{
			global $wpdb;

			//echo dirname(__FILE__) . '/templates/Terms.php';exit;
			$terms_forced = file_get_contents(dirname(__FILE__) . '/templates/Terms-latest.php');
			$terms = file_get_contents(dirname(__FILE__) . '/templates/Terms.html');
			$privacy = file_get_contents(dirname(__FILE__) . '/templates/privacy.html');
			$earnings = '<div style="text-align: center; font-weight: bold;">Earnings Disclaimer<br></div><br><br>EVERY EFFORT HAS BEEN MADE TO ACCURATELY REPRESENT THIS PRODUCT AND IT\'S POTENTIAL. EVEN THOUGH THIS INDUSTRY IS ONE OF THE FEW WHERE ONE CAN WRITE THEIR OWN CHECK IN TERMS OF EARNINGS, THERE IS NO GUARANTEE THAT YOU WILL EARN ANY MONEY USING THE TECHNIQUES AND IDEAS IN THESE MATERIALS. EXAMPLES IN THESE MATERIALS ARE NOT TO BE INTERPRETED AS A PROMISE OR GUARANTEE OF EARNINGS. EARNING POTENTIAL IS ENTIRELY DEPENDENT ON THE PERSON USING OUR PRODUCT, IDEAS AND TECHNIQUES. WE DO NOT PURPORT THIS AS A "GET RICH SCHEME."<br> <br> ANY CLAIMS MADE OF ACTUAL EARNINGS OR EXAMPLES OF ACTUAL RESULTS CAN BE VERIFIED UPON REQUEST. YOUR LEVEL OF SUCCESS IN ATTAINING THE RESULTS CLAIMED IN OUR MATERIALS DEPENDS ON THE TIME YOU DEVOTE TO THE PROGRAM, IDEAS AND TECHNIQUES MENTIONED, YOUR FINANCES, KNOWLEDGE AND VARIOUS SKILLS. SINCE THESE FACTORS DIFFER ACCORDING TO INDIVIDUALS, WE CANNOT GUARANTEE YOUR SUCCESS OR INCOME LEVEL. NOR ARE WE RESPONSIBLE FOR ANY OF YOUR ACTIONS.<br> <br> MATERIALS IN OUR PRODUCT AND OUR WEBSITE MAY CONTAIN INFORMATION THAT INCLUDES OR IS BASED UPON FORWARD-LOOKING STATEMENTS WITHIN THE MEANING OF THE SECURITIES LITIGATION REFORM ACT OF 1995. FORWARD-LOOKING STATEMENTS GIVE OUR EXPECTATIONS OR FORECASTS OF FUTURE EVENTS. YOU CAN IDENTIFY THESE STATEMENTS BY THE FACT THAT THEY DO NOT RELATE STRICTLY TO HISTORICAL OR CURRENT FACTS. THEY USE WORDS SUCH AS "ANTICIPATE," "ESTIMATE," "EXPECT," "PROJECT," "INTEND," "PLAN," "BELIEVE," AND OTHER WORDS AND TERMS OF SIMILAR MEANING IN CONNECTION WITH A DESCRIPTION OF POTENTIAL EARNINGS OR FINANCIAL PERFORMANCE.<br> <br> ANY AND ALL FORWARD LOOKING STATEMENTS HERE OR ON ANY OF OUR SALES MATERIAL ARE INTENDED TO EXPRESS OUR OPINION OF EARNINGS POTENTIAL. MANY FACTORS WILL BE IMPORTANT IN DETERMINING YOUR ACTUAL RESULTS AND NO GUARANTEES ARE MADE THAT YOU WILL ACHIEVE RESULTS SIMILAR TO OURS OR ANYBODY ELSES, IN FACT NO GUARANTEES ARE MADE THAT YOU WILL ACHIEVE ANY RESULTS FROM OUR IDEAS AND TECHNIQUES IN OUR MATERIAL.<br>  <br> The author and publisher disclaim any warranties (express or implied), merchantability, or fitness for any particular purpose. The author and publisher shall in no event be held liable to any party for any direct, indirect, punitive, special, incidental or other consequential damages arising directly or indirectly from any use of this material, which is provided "as is", and without warranties.<br> <br> As always, the advice of a competent legal, tax, accounting or other  professional should be sought.<br> <br> [Domain] does not warrant the performance, effectiveness or applicability of any sites listed or linked to on [Domain]<br> <br> All links are for information purposes only and are not warranted for content, accuracy or any other implied or explicit purpose.<br> <br>';

			$external = file_get_contents(dirname(__FILE__) . '/templates/external-links.html');

			$about_us = file_get_contents(dirname(__FILE__) . '/templates/about-us.html');
			$dmca = file_get_contents(dirname(__FILE__) . '/templates/dmca.html');


			add_option('lp_excludePage','true');
			add_option('lp_general', '');
			add_option('lp_accept_terms','0');
			add_option('lp_eu_cookie_title','A note to our visitors');
			$message_body="This website has updated its privacy policy in compliance with EU Cookie legislation. Please read this to review the updates about which cookies we use and what information we collect on our site. By continuing to use this site, you are agreeing to our updated privacy policy.";
			add_option('lp_eu_cookie_message',htmlentities($message_body));
			add_option('lp_eu_cookie_enable','OFF');
			add_option('lp_eu_box_color','#DCDCDC');
			add_option('lp_eu_button_color','#24890d');
			add_option('lp_eu_button_text_color','#333333');
			add_option('lp_eu_text_color','#333333');

			$sql = "CREATE TABLE IF NOT EXISTS `$this->tablename` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `title` text NOT NULL,
					  `content` longtext NOT NULL,
					  `notes` text NOT NULL,
					  `contentfor` varchar(200) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM;";
			$sqlpopup = "CREATE TABLE IF NOT EXISTS `$this->popuptable` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `popupName` text NOT NULL,
					  `content` longtext NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM;";
			$wpdb->query($sql);
			$wpdb->query($sqlpopup);
			$template_count = $wpdb->get_var( "SELECT COUNT(*) FROM `$this->tablename` WHERE title='Privacy Policy'" );
			if($template_count==0){
				$wpdb->insert($this->tablename,array('title'=>'Privacy Policy','content'=>$privacy,'contentfor'=>'1a2b3c4d5e6f7g8h9i'),array('%s','%s','%s'));
			}
			$template_count = $wpdb->get_var( "SELECT COUNT(*) FROM `$this->tablename` WHERE title='DMCA'" );
			if($template_count==0){
				$wpdb->insert($this->tablename,array('title'=>'DMCA','content'=>$dmca,'contentfor'=>'10j'),array('%s','%s','%s'));
			}

		}
		function lp_enqueue_editor()
		{
			wp_enqueue_script('common');
			wp_enqueue_script('jquery-affect');
			wp_admin_css('thickbox');
			wp_enqueue_script('post');
			wp_enqueue_script('media-upload');
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('jquery-ui-tabs');
			wp_enqueue_script('tiny_mce');
			wp_enqueue_script('editor');
			wp_enqueue_script('editor-functions');
      		wp_print_scripts('wplink');
			wp_print_styles('wplink');
			add_action('tiny_mce_preload_dialogs', 'wp_link_dialog');

			//self bootstrap style sheet
			wp_enqueue_style('bootstrap-min',$this->plugin_url. '/wp-content/plugins/WP-Legal-Pages/admin/css/bootstrap.min.css');

			//self style sheet
			wp_enqueue_style('style',$this->plugin_url. '/wp-content/plugins/WP-Legal-Pages/admin/css/style.css');

			add_thickbox();

			wp_admin_css();
			wp_enqueue_script('utils');
			do_action("admin_print_styles-post-php");
			do_action('admin_print_styles');

		}
	}
else :
	exit ("Class legalPages already declared!");
endif;
?>
