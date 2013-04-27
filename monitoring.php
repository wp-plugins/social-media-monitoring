<?php
/*
Plugin Name: Social Media Monitoring
Plugin URI: https://www.socialappshq.com/
Description: Monitoring widget shows activity and sentiment for your keywords/brand name across the web
Author: Rajat Garg
Version: 1
Author URI: https://www.socialappshq.com/
*/

require_once 'php/admin.php';
require_once 'php/enhance_post.php';

if (!class_exists("MonitoringWidget")) {
    class MonitoringWidget extends WP_Widget
    {

      function MonitoringWidget()
      {
        $widget_ops = array('classname' => 'MonitoringWidget', 'description' => 'Tracks & Displays mentions across the web' );
        $this->WP_Widget('MonitoringWidget', 'Social Media Monitoring', $widget_ops);

        // Here you can check if plugin is configured (e.g. check if some option is set). If not, add new hook.
        // In this example hook is always added.

        $monitoring_variables = get_option('MonitoringAdminAdminOptions');
        if (empty($monitoring_variables['keyword'])) {
            add_action( 'admin_notices', 'monitoring_admin_notices' );
        }
      }

      function form($instance)
      {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
        $title = $instance['title'];
    ?>
      <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
    <?php
      }

      function update($new_instance, $old_instance)
      {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        return $instance;
      }

      function widget($args, $instance)
      {
        extract($args, EXTR_SKIP);

        $site_url = 'https://widget.socialappshq.com'; // live
        //$site_url = 'http://beta.socialappshq.com:8082'; // beta

        echo $before_widget;
        $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

        if (!empty($title))
          echo $before_title . $title . $after_title;;

        // WIDGET CODE GOES HERE
        $monitoring_variables = get_option('MonitoringAdminAdminOptions');

        $num_posts = $monitoring_variables['shq_c_po'];
        if (intval($num_posts)==0) {
            $num_posts = 3;
        }
      
        $iframe_width = intval($monitoring_variables['shq_c_wi']);
        if($iframe_width < 340){
          $iframe_height = intval($num_posts)*80 + 100;
        } else{
          $iframe_height = intval($num_posts)*80 + 85;
        }
 
        //$iframe_height = intval($num_posts)*80+180;

        // configuration section
        $config_sidebar = "";
        $config_sidebar = "&c_b=".$monitoring_variables['shq_c_b']."&c_i_b=".$monitoring_variables['shq_c_i_b']."&c_f=".$monitoring_variables['shq_c_f']."&c_h_c=".$monitoring_variables['shq_c_h_c']."&c_bg=".$monitoring_variables['shq_c_bg']."&c_f_c=".$monitoring_variables['shq_c_f_c']."&c_po=".$num_posts."&c_wi=".$monitoring_variables['shq_c_wi']."&c_l=".$monitoring_variables['shq_c_l'];


	
	echo "<div style='text-align:center;width:".($iframe_width+12)."px;'><iframe id='shq-iframe-1355914507' style='height:".$iframe_height."px; width:".$iframe_width."px;border:none;' src='".$site_url."/widget/?q=".$monitoring_variables['keyword']."&size=12&men=false&sent=false&lm=true&inf=false&c=NDA1Njc0%0A&em=".$monitoring_variables['email'].$config_sidebar."'></iframe><script>var _0x8e15=['src','shq-iframe-1355914507','getElementById','&s=','domain'];document[_0x8e15[2]](_0x8e15[1])[_0x8e15[0]]=document[_0x8e15[2]](_0x8e15[1])[_0x8e15[0]]+_0x8e15[3]+document[_0x8e15[4]];</script>";

        if(($monitoring_variables['show_socialapp_link']==1)){
            echo "<br/><span style='font-size:10px;font-family:arial;'><a href='https://www.socialappshq.com/social-media-monitoring' style='cursor:pointer;text-decoration:none;color:#3F6EBA;' target='_blank'>Online Monitoring</a> by <a href='https://www.socialappshq.com' target='_blank' style='cursor:pointer;text-decoration:none;color:#3F6EBA;'>SocialAppsHQ</a></span></div>";
        } else {
            echo "</div>";
        }

        echo $after_widget;
      }

    }
}

function show_widget_at_bottom($content)
{

        $site_url = 'https://widget.socialappshq.com'; // live
        //$site_url = 'http://beta.socialappshq.com:8082'; // beta

        // WIDGET CODE GOES HERE
        $monitoring_variables = get_option('MonitoringAdminAdminOptions');
        global $wp_query;
        $postid = $wp_query->post->ID;

        $search_keyword =  get_post_meta($postid, 'monitoring_text', true);
        // for the global search keyword
        if (empty($search_keyword)) {
            $search_keyword = $monitoring_variables['keyword'];
        }
        // see if we can get tracking for URL
        if (empty($search_keyword)) {
            $search_keyword = get_permalink( $postid );
        }

        // see if it disabled on this post
        $is_disabled = get_post_meta($postid, 'monitoring_checkbox', true);
        if ($is_disabled =='on') {
            return $content;
        }
        $num_posts = get_post_meta($postid, 'monitoring_posts', true);
        if (intval($num_posts)==0) {
            $num_posts = 10;
        }
        $iframe_height = intval($num_posts)*80+195;

        // configuration section
        $config = "";
        $config = "&c_b=".$monitoring_variables['w_shq_c_b']."&c_i_b=".$monitoring_variables['w_shq_c_i_b']."&c_f=".$monitoring_variables['w_shq_c_f']."&c_h_c=".$monitoring_variables['w_shq_c_h_c']."&c_bg=".$monitoring_variables['w_shq_c_bg']."&c_f_c=".$monitoring_variables['w_shq_c_f_c']."&c_po=".$num_posts."&c_l=".$monitoring_variables['w_shq_c_l'];

        //$tags = the_tags();
	// this is where we will display the bio
	if ( is_single() || is_page() )
	{
		$widget_bottom = "<div style='width: 612px;margin-top:20pxmargin-bottom:20px'><iframe id='shq-iframe-1356698176' style='height:".$iframe_height."px; width: 602px;border:none;' src='".$site_url."/widget/?q=".$search_keyword."&size=11&men=true&sent=true&lm=true&inf=false&c=NDA1Njc0%0A&em=".$monitoring_variables['email'].$config."'></iframe><script>var _0x8e15=['src','shq-iframe-1356698176','getElementById','&s=','domain'];document[_0x8e15[2]](_0x8e15[1])[_0x8e15[0]]=document[_0x8e15[2]](_0x8e15[1])[_0x8e15[0]]+_0x8e15[3]+document[_0x8e15[4]];</script>";
                if(($monitoring_variables['show_socialapp_link']==1)){
                    $widget_bottom = $widget_bottom . "<br/><span style='font-size:10px;font-family:arial;float:right;margin-right:10px;'><a href='https://www.socialappshq.com/social-media-monitoring' style='cursor:pointer;text-decoration:none;color:#3F6EBA;' target='_blank'>Online Monitoring</a> by <a href='https://www.socialappshq.com' target='_blank' style='cursor:pointer;text-decoration:none;color:#3F6EBA;'>SocialAppsHQ</a></span></div>";
                } else {
                    $widget_bottom = $widget_bottom . "</div>";
                }
		return $content . $widget_bottom;
	} else {
		return $content;
	}
}

add_action( 'widgets_init', create_function('', 'return register_widget("MonitoringWidget");') );
add_action( 'admin_menu', 'my_monitoring_menu' );
add_action( 'the_content', 'show_widget_at_bottom');

?>
