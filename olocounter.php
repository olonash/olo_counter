
<?php
/*
Plugin Name: Olo Counter
Plugin URI: http://
Description: Conpteur de visite pour wordpress
Version: 1.0.0
Author: Nasolo Randianina
Author URI: http://
License: GPL2
*/

//use Olocounter\Counter ;
include_once('Counter.php');

class olocounter
{
    /**
     * 10 minute session  life time
     */
    const SESSION_LIFE_TIME = 10;
    public function __construct()
    {

        new Counter(self::SESSION_LIFE_TIME);
        //add_filter( 'get_header', array($this, 'my_custom_redirect'), 1000);
        add_action('admin_menu', array($this, 'test_plugin_setup_menu'));

        //include js file
        wp_enqueue_script('jqueryvectorMap', plugin_dir_url(__FILE__) . 'jvectormap/jquery-jvectormap-1.2.2.min.js', array('jquery'));
        wp_enqueue_script('world_mill_en', plugin_dir_url(__FILE__) . 'jvectormap/jquery-jvectormap-world-mill-en.js', array('jquery'));


        //import css
        wp_enqueue_style( 'jqueryvectorMap', plugin_dir_url(__FILE__) . 'jvectormap/jquery-jvectormap-1.2.2.css' );

    }

    /*public function my_custom_redirect () {
        die('dsfsdfsdfsdf');
    }*/


    //admin panel


    function test_plugin_setup_menu(){
        add_menu_page( 'Olo Counter', 'Olo Counter', 'manage_options', 'olocounter_admin_index', array($this, 'olocounter_admin_index') );
    }

    function olocounter_admin_index(){
        echo '

                <div class="wrap">
                    <h1>Admin - olocounter</h1>
                </div>
                <div id="dashboard-widgets-wrap">
	                <div id="dashboard-widgets" class="metabox-holder">
                        <div id="postbox-container-1" class="" style="width:25%; display: inline-block">
	                        <div id="normal-sortables" class="meta-box-sortables ui-sortable"><div id="dashboard_right_now" class="postbox">
                                <button type="button" class="handlediv button-link" aria-expanded="true">
                                    <span class="screen-reader-text">Ouvrir/fermer le bloc D’un coup d’œil</span>
                                    <span class="toggle-indicator" aria-hidden="true"></span>
                                </button>
                                <h2 class="hndle ui-sortable-handle"><span>Résumé des visiteurs</span></h2>
                                <div class="inside">
	                                <div class="main">
	                                    <ul>
                                            <li class="post-count"><a href="edit.php?post_type=post">1 Visiteurs Total</a></li>
                                            <li class="page-count"><a href="edit.php?post_type=page">1 Visiteur du jour</a></li>
                                            <li class="comment-count"><a href="edit-comments.php">1 Visiteur connecté</a></li>
				                            <li class="comment-mod-count hidden"><a href="edit-comments.php?comment_status=moderated" aria-label="0 commentaire en modération">0 en attente de validation</a></li>
			                            </ul>
	                                    <!--p id="wp-version-message">
	                                        <span id="wp-version">WordPress 4.6.1 avec le thème <a href="themes.php">Twenty Sixteen</a>.</span>
	                                    </p-->
	                                </div>
	                            </div>
                            </div>
						</div>
						</div>
						<div id="postbox-container-2" class="" style="width:75%; display: inline-block"">
	                        <div id="normal-sortables" class="meta-box-sortables ui-sortable"><div id="dashboard_right_now" class="postbox">
                                <button type="button" class="handlediv button-link" aria-expanded="true">
                                    <span class="screen-reader-text">Ouvrir/fermer le bloc D’un coup d’œil</span>
                                    <span class="toggle-indicator" aria-hidden="true"></span>
                                </button>
                                <h2 class="hndle ui-sortable-handle"><span>Carte de repartition des visiteurs</span></h2>
                                <div class="inside">
	                                <div class="main">
	                                Carte google map
	                                <div id="map1" style="width: 600px; height: 400px"></div>
	                                    <!--ul>
                                            <li class="post-count"><a href="edit.php?post_type=post">1 articles</a></li>
                                            <li class="page-count"><a href="edit.php?post_type=page">1 page</a></li>
                                            <li class="comment-count"><a href="edit-comments.php">1 commentaire</a></li>
				                            <li class="comment-mod-count hidden"><a href="edit-comments.php?comment_status=moderated" aria-label="0 commentaire en modération">0 en attente de validation</a></li>
			                            </ul>
	                                    <p id="wp-version-message"><span id="wp-version">WordPress 4.6.1 avec le thème <a href="themes.php">Twenty Sixteen</a>.</span></p-->
	                                </div>
	                            </div>
                            </div>
						</div>

                    </div>
                </div>

            ';

    }

}

new olocounter();


