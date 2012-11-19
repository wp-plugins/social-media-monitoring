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

        echo $before_widget;
        $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

        if (!empty($title))
          echo $before_title . $title . $after_title;;

        // WIDGET CODE GOES HERE
        $monitoring_variables = get_option('MonitoringAdminAdminOptions');

        echo "<div style='text-align:center;width: 260px;'><iframe id='shq-iframe-1351519771' style='height: 252px; width: 260px;' src='https://widget.socialappshq.com/widget/?q=".$monitoring_variables['keyword']."&size=5&men=true&sent=true&lm=false&inf=false&c=MTIzODMw%0A&em=".$monitoring_variables['email']."'></iframe><script>var _0x8e15=['src','shq-iframe-1351519771','getElementById','&s=','domain'];document[_0x8e15[2]](_0x8e15[1])[_0x8e15[0]]=document[_0x8e15[2]](_0x8e15[1])[_0x8e15[0]]+_0x8e15[3]+document[_0x8e15[4]];</script>";

        if(($monitoring_variables['show_socialapp_link']==1)){
            echo "<br/><span style='font-size:12px;font-family:arial;'><a href='https://widget.socialappshq.com/widget/landing' style='cursor:pointer;text-decoration:none;color:#3F6EBA;' target='_blank'>Monitoring</a> by <a href='https://www.socialappshq.com' target='_blank' style='cursor:pointer;text-decoration:none;color:#3F6EBA;'>SocialAppsHQ</a></span></div>";
        }

        echo $after_widget;
      }

    }
}

add_action( 'widgets_init', create_function('', 'return register_widget("MonitoringWidget");') );
add_action( 'admin_menu', 'my_monitoring_menu' );

?>