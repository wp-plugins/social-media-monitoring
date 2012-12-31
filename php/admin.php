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
			$devloungeAdminOptions = array('keyword' => '', credits => '', 'shq_c_b' => 'CCCCCC', 'shq_c_i_b' => 'CCCCCC', 'shq_c_f' => 'arial,sans-serif', 'shq_c_h_c' => '3F6EBA', 'shq_c_f_c' => '000000', 'shq_c_bg' => 'ffffff', 'w_shq_c_b' => 'CCCCCC', 'w_shq_c_i_b' => 'CCCCCC', 'w_shq_c_f' => 'arial, sans_serif', 'w_shq_c_h_c' => '3F6EBA', 'w_shq_c_f_c' => '000000', 'w_shq_c_bg' => 'ffffff', 'shq_po' => 3);
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

                        if (isset($_POST['devloungeShowBorder'])) {
                                $devOptions['shq_c_b'] = apply_filters('keyword_save_pre', $_POST['devloungeShowBorder']);
                        }
                        if (isset($_POST['devloungeInnerBorder'])) {
                                $devOptions['shq_c_i_b'] = apply_filters('keyword_save_pre', $_POST['devloungeInnerBorder']);
                        }
                        if (isset($_POST['devloungeFontType'])) {
                                $devOptions['shq_c_f'] = apply_filters('keyword_save_pre', $_POST['devloungeFontType']);
                        }
                        if (isset($_POST['devloungeHeaderColor'])) {
                                $devOptions['shq_c_h_c'] = apply_filters('keyword_save_pre', $_POST['devloungeHeaderColor']);
                        }
                        if (isset($_POST['devloungeBackgroundColor'])) {
                                $devOptions['shq_c_bg'] = apply_filters('keyword_save_pre', $_POST['devloungeBackgroundColor']);
                        }
                        if (isset($_POST['devloungeFontColor'])) {
                                $devOptions['shq_c_f_c'] = apply_filters('keyword_save_pre', $_POST['devloungeFontColor']);
                        }
                        if (isset($_POST['devloungePosts'])) {
                                $devOptions['shq_c_po'] = apply_filters('keyword_save_pre', $_POST['devloungePosts']);
                        }

                        if (isset($_POST['devloungeShowBorder'])) {
                                $devOptions['w_shq_c_b'] = apply_filters('keyword_save_pre', $_POST['devloungeWShowBorder']);
                        }
                        if (isset($_POST['devloungeInnerBorder'])) {
                                $devOptions['w_shq_c_i_b'] = apply_filters('keyword_save_pre', $_POST['devloungeWInnerBorder']);
                        }
                        if (isset($_POST['devloungeFontType'])) {
                                $devOptions['w_shq_c_f'] = apply_filters('keyword_save_pre', $_POST['devloungeWFontType']);
                        }
                        if (isset($_POST['devloungeHeaderColor'])) {
                                $devOptions['w_shq_c_h_c'] = apply_filters('keyword_save_pre', $_POST['devloungeWHeaderColor']);
                        }
                        if (isset($_POST['devloungeBackgroundColor'])) {
                                $devOptions['w_shq_c_bg'] = apply_filters('keyword_save_pre', $_POST['devloungeWBackgroundColor']);
                        }
                        if (isset($_POST['devloungeFontColor'])) {
                                $devOptions['w_shq_c_f_c'] = apply_filters('keyword_save_pre', $_POST['devloungeWFontColor']);
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

                        <style>

                            .wrap h3{float: left;width:400px;margin:10px 10px 0 0;font-weight:normal}
                            .wrap p{float: left; max-width:300px;margin:0}
                            .wrap small{float: left; width:100%;margin:0}
                            .wrap .input_color{width:200px}
                            .wrap .input_kwd{width:200px; margin-left:10px;}
                            .wrap .row{float:left;width:100%; margin:10px 0;}
                            .wrap .title{font-weight:bold;margin:20px 0}
                            .wrap .input_font{margin-left:10px; width:200px}
                            .wrap .che{margin:0px; -webkit-border-radius:0px  !important;-moz-border-radius:0px  !important;border-radius:0px !important; }
                            .wrap p input{background-color: #ffffff;
                                          border: 1px solid #cccccc;
                                          -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
                                          -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
                                          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
                                          -webkit-transition: border linear .2s, box-shadow linear .2s;
                                          -moz-transition: border linear .2s, box-shadow linear .2s;
                                          -o-transition: border linear .2s, box-shadow linear .2s;
                                          transition: border linear .2s, box-shadow linear .2s; margin-top:5px; -webkit-border-radius:10px;
                                        -moz-border-radius:10px;border-radius:10px;
                                        }
                            .wrap p input:hover{border-color: rgba(82, 168, 236, 0.8);
                              outline: 0;
                              outline: thin dotted \9;
                              /* IE6-9 */

                              -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(82,168,236,.6);
                              -moz-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(82,168,236,.6);
                              box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(82,168,236,.6);
                            }

                            .btn-primary {
                              color: #ffffff !important;
                              text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25) !important;
                              background-color: #006dcc !important;
                              background-image: -moz-linear-gradient(top, #0088cc, #0044cc)!important;
                              background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0044cc))!important;
                              background-image: -webkit-linear-gradient(top, #0088cc, #0044cc)!important;
                              background-image: -o-linear-gradient(top, #0088cc, #0044cc)!important;
                              background-image: linear-gradient(to bottom, #0088cc, #0044cc)!important;
                              background-repeat: repeat-x;
                              filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff0088cc', endColorstr='#ff0044cc', GradientType=0);
                              border-color: #0044cc #0044cc #002a80 !important;
                              border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25)!important;
                              *background-color: #0044cc !important;
                              /* Darken IE7 buttons by default so they stand out more given they won't have borders */

                              filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);-webkit-border-radius:10px;-moz-border-radius:10px;border-radius:10px;
                            }
                            .btn-primary:hover{
                             color: #ffffff !important;
                              background-color: #0044cc !important; }



                        </style>
                        <div class="wrap">
                            <div style="float:left;width:60%">
                                <form method="post" action="/wp-admin/admin.php?page=monitoring-menu-id">

                                <h2>Admin Panel for Monitoring Plugin</h2>
                                
                                <div class="row">
                                <h3>Enter Keywords that you want to track across the web</h3>
                                <p><input name="devloungeContent" class="input_kwd" value="<?php echo $devOptions['keyword'] ?>"></p>
                                </div>
                                <div class="row">
                                <h3>Enter Email Address</h3>
                                <p><input name="devloungeEmail" class="input_kwd" value="<?php echo get_option('admin_email') ?>"></p>
                                <small>You can use this email to access raw data collected for keywords on SocialAppsHQ</small>
                                </div>
                                <div class="row">

                                <h3 class="title">Configure Look and Feel of Sidebar Widget</h3>
                                </div>
                                <div class="row">

                                <h3>Color of Border</h3>
                                <p>#<input name="devloungeShowBorder" class="input_color" value="<?php echo $devOptions['shq_c_b'] ?>"></p>
                                <small>Enter Color hexcode without #. You can enter 0 for hiding border.</small>
                                </div>
                                <div class="row">
                                
                                <h3>Color of Inner Lines</h3>
                                <p>#<input name="devloungeInnerBorder" class="input_color" value="<?php echo $devOptions['shq_c_i_b'] ?>"></p>
                                </div>
                                <div class="row">
                                <h3>Font Type</h3>
                                <p><input name="devloungeFontType" class="input_font" value="<?php echo $devOptions['shq_c_f'] ?>"></p>
                                </div>
                                <div class="row">
                                <h3>Header Font Color</h3>
                                <p>#<input name="devloungeHeaderColor" class="input_color" value="<?php echo $devOptions['shq_c_h_c'] ?>"></p>
                                </div>
                                <div class="row">
                                <h3>Background Color</h3>
                                <p>#<input name="devloungeBackgroundColor" class="input_color" value="<?php echo $devOptions['shq_c_bg'] ?>"></p>
                                </div>
                                <div class="row">
                                <h3>Font Color</h3>
                                <p>#<input name="devloungeFontColor" class="input_color" value="<?php echo $devOptions['shq_c_f_c'] ?>"></p>
                                </div>
                                <div class="row">
                                <h3>Number of Posts</h3>
                                <p>#<input name="devloungePosts" class="input_color" value="<?php echo $devOptions['shq_c_po'] ?>"></p>
                                <small>Number of posts to show in sidebar. Allowed range is between 2 to 10.</small>
                                </div>

                                <div class="row">
                                <h3 class="title">Configure Look and Feel of Widget below Posts</h3>
                                </div>
                                <div class="row">
                                <h3>Color of Border</h3>
                                <p>#<input name="devloungeWShowBorder" class="input_color" value="<?php echo $devOptions['w_shq_c_b'] ?>"></p>
                                <small>Enter Color hexcode without #. You can enter 0 for hiding border.</small>
                                </div>
                                <div class="row">

                                <h3>Color of Inner Lines</h3>
                                <p>#<input name="devloungeWInnerBorder" class="input_color" value="<?php echo $devOptions['w_shq_c_i_b'] ?>"></p>
                                </div>
                                <div class="row">
                                <h3>Font Type</h3>
                                <p><input name="devloungeWFontType" class="input_font" value="<?php echo $devOptions['w_shq_c_f'] ?>"></p>
                                </div>
                                <div class="row">
                                <h3>Header Font Color</h3>
                                <p>#<input name="devloungeWHeaderColor" class="input_color" value="<?php echo $devOptions['w_shq_c_h_c'] ?>"></p>
                                </div>
                                <div class="row">
                                <h3>Background Color</h3>
                                <p>#<input name="devloungeWBackgroundColor" class="input_color" value="<?php echo $devOptions['w_shq_c_bg'] ?>"></p>
                                </div>
                                <div class="row">
                                <h3>Font Color</h3>
                                <p>#<input name="devloungeWFontColor" class="input_color" value="<?php echo $devOptions['w_shq_c_f_c'] ?>"></p>
                                </div>

                                <div class="row">
                                <p style="float: left; width:100%;clear: both;margin-top:10px">                                    
                                    <input type="checkbox" name="devloungeCredits" class="che" value="1" checked="checked"  /> Show Credits
                                </p>
                                </div>
                                <div class="row">
                                <div class="submit" style="clear: both;">
                                <input type="submit" name="update_devloungePluginSeriesSettings" value="Update Settings" class="btn-primary">
                                </div>
                                
                                </div>

                                </form>
                                <div style="float:left;">Next, <a href="/wp-admin/widgets.php"><strong>Choose location of Monitoring Widget</strong></a></div>
                            </div>
                            <div style="float:left;width:35%">
                                <p style="font-size: 18px; width: 300px; height: 250px; float: left; margin-top: 20px;">Mockup of Widget<br><br>
                                <img src="/wp-content/plugins/social-media-monitoring/images/mockup.png"></p
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
          <br/><a href='/wp-admin/admin.php?page=monitoring-menu-configuration'><img src='/wp-content/plugins/social-media-monitoring/images/configure.png'></img></a>
          </p></div>\n";
}

// admin panel
function my_monitoring_menu() {
    	add_menu_page( 'Configure Social Media Monitoring', 'Monitoring', 'manage_options', 'monitoring-menu-id', 'my_monitoring_options', '/wp-content/plugins/social-media-monitoring/images/favicon.ico');
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