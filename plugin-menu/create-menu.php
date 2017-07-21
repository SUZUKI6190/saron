<?php

class PluginConroller
{
    private function __construct(){}
 
    /** ステップ1 */
    public static function my_plugin_menu() {
        add_options_page( 'My Plugin Options', 'My Plugin', 'manage_options', 'my-unique-identifier', 'PluginConroller::my_plugin_options' );
    }
    
    /** ステップ3 */
    public static function my_plugin_options() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        echo '<div class="wrap">';
        echo '<p>オプション用のフォームをここに表示する。</p>';
        echo '</div>';
    }

    //管理画面にメニューを追加
    public static function add_pages(){
        add_menu_page('予約システム管理', '予約システム管理', 'level_8', __FILE__, 'PluginConroller::csv_upload', 'dashicons-upload',26);
    }
    
   //プラグインの表示
    public static function csv_upload(){
    ?>
    <?php
    }

    public static function run()
    {
        /** 上のテキストのステップ2 */
        add_action( 'admin_menu', 'PluginConroller::my_plugin_menu' );
     
        // 管理メニューに追加するフック
        add_action('admin_menu', 'PluginConroller::add_pages');

    }
}


?>