<?php

    if (!class_exists("MonitoringAdmin")) {
	class MonitoringAdmin {
		var $adminOptionsName = "MonitoringAdminAdminOptions";
		function MonitoringAdmin() { //constructor

		}
		function init() {
			$this->getAdminOptions();
		}
		//Returns an array of admin options
		function getAdminOptions() {
			$devloungeAdminOptions = array('keyword' => '', credits => '');
			$devOptions = get_option($this->adminOptionsName);
			if (!empty($devOptions)) {
				foreach ($devOptions as $key => $option)
					$devloungeAdminOptions[$key] = $option;
			}
			update_option($this->adminOptionsName, $devloungeAdminOptions);
                        remove_action( 'admin_notices', 'monitoring_admin_notices' );
			return $devloungeAdminOptions;
		}

		function addContent($keyword = '') {
			$devOptions = $this->getAdminOptions();
			if ($devOptions['add_content'] == "true") {
				$keyword .= $devOptions['keyword'];
			}
			return $keyword;
		}
		
		//Prints out the admin page
		function printAdminPage() {
                    $devOptions = $this->getAdminOptions();

                    if (isset($_POST['update_devloungePluginSeriesSettings'])) {

                        if (isset($_POST['devloungeContent'])) {
                                $devOptions['keyword'] = apply_filters('keyword_save_pre', $_POST['devloungeContent']);
                        }
                        if (isset($_POST['devloungeEmail'])) {
                                $devOptions['email'] = apply_filters('keyword_save_pre', $_POST['devloungeEmail']);
                        }
                        if ((isset($_POST['devloungeCredits'])) && (1==$_POST['devloungeCredits'])) {
                            $devOptions['show_socialapp_link'] = 1;
                        } else {
                            $devOptions['show_socialapp_link'] = 0;
                        }

                        update_option($this->adminOptionsName, $devOptions);

                        ?>
                        <div class="updated"><p><strong><?php _e("Settings Updated.", "MonitoringAdmin");?></strong></p></div>
                        <?php
                        } ?>

                        <div class="wrap">
                            <div style="float:left;width:60%">
                                <form method="post" action="/wp-admin/admin.php?page=monitoring-menu-id">

                                <h2>Admin Panel for Monitoring Plugin</h2>
                                <h3 style="float: left; width:100%;">Enter Keywords that you want to track across the web</h3>
                                <p style="float: left; width:100%;clear: both;margin:0">You can enter comma separated keywords below</p>
                                <p style="float: left; clear: both;margin:0"><input name="devloungeContent" style="width: 500px; float:left" value="<?php echo $devOptions['keyword'] ?>"></p>
                                <br/>
                                <h3 style="float: left; width:100%;">Enter Email Address</h3>
                                <p style="float: left; width:100%;clear: both;margin:0">You can use this email to access raw data collected for keywords on SocialAppsHQ</p>
                                <p style="float: left; clear: both;margin:0"><input name="devloungeEmail" style="width: 500px; float:left" value="<?php echo get_option('admin_email') ?>"></p>
                                <br/>
                                <p style="float: left; width:100%;clear: both;margin-top:10px">                                    
                                    <input type="checkbox" name="devloungeCredits" value="1" <?php if(isset($_POST['devloungeCredits'])){  ?>checked="checked"<? }php ?>  /> Show Credits                                    
                                </p>
                                
                                <div class="submit" style="clear: both;">
                                <input type="submit" name="update_devloungePluginSeriesSettings" value="Update Settings">
                                </div>

                                </form>
                                <div style="float:left;">Next, <a href="/wp-admin/widgets.php">Choose location of Monitoring Widget</a></div>
                            </div>
                            <div style="float:left;width:35%">
                                <p style="font-size: 18px; width: 300px; height: 250px; float: left; margin-top: 20px;">Mockup of Widget<br><br>
                                <img src="images/mockup.png"></p
                            </div>
                        </div>

                    <?php
            }//End function printAdminPage()

	}

} //End Class MonitoringAdmin

if (class_exists("MonitoringAdmin")) {
	$dl_pluginSeries = new MonitoringAdmin();
}


// notice to ping users to come and configure plugin
function monitoring_admin_notices() {
    echo "<div id='notice' class='updated fade'><p><h2>Social Media Monitoring is not configured yet. Please do it now.</h2>
          <br/><a href='/wp-admin/admin.php?page=monitoring-menu-configuration'><img src='images/configure.png'></img></a>
          </p></div>\n";
}

// admin panel
function my_monitoring_menu() {
    	add_menu_page( 'Configure Social Media Monitoring', 'Monitoring', 'manage_options', 'monitoring-menu-id', 'my_monitoring_options', 'images/icon.gif');
	add_options_page( 'Configure Social Media Monitoring', 'Social Media Monitoring', 'manage_options', 'monitoring-menu-configuration', 'my_monitoring_options' );
}

function my_monitoring_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

        global $dl_pluginSeries;
        if (!isset($dl_pluginSeries)) {
                return;
        }


        $dl_pluginSeries->printAdminPage();

        // Current page is options page for our plugin, so do not display notice
	// (remove hook responsible for this)
	remove_action( 'admin_notices', 'monitoring_admin_notices' );
}

?>