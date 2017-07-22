<?php

class PluginController
{
    private function __construct(){}
    const SettingGroup = "YoyakuSettingGroup";
    const UrlName = 'YoyakuUrlName';

    private static function get_option_inner($opname)
    {
        return get_option($opname);
    }

    /** ステップ1 */
    public static function my_plugin_menu() {
        add_options_page( 'My Plugin Options', 'My Plugin', 'manage_options', 'my-unique-identifier', 'PluginController::my_plugin_options' );
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
        add_menu_page('予約システム管理', '予約システム管理', 'level_8', __FILE__, 'PluginController::view_setup', 'dashicons-upload',26);
    }
    
   //プラグインの表示
    public static function view_setup(){
?>

<form method="post" action="options.php">
<?php 
settings_fields(self::SettingGroup);
do_settings_sections(self::SettingGroup);
?>
<?php submit_button(); ?>
    <div>
        <span>予約システムの先頭URL名:<span>
        <input type='text' name='<?php echo self::UrlName; ?>' value='<?php echo get_option(self::UrlName); ?>'>
    <div>
</form>

    <?php
    }

    public static function register_settings() {
        register_setting( self::SettingGroup , self::UrlName );
    }

    public static function run()
    {
        add_action('admin_init', 'PluginController::register_settings' );
    
        /** 上のテキストのステップ2 */
        add_action('admin_menu', 'PluginController::my_plugin_menu' );
     
        // 管理メニューに追加するフック
        add_action('admin_menu', 'PluginController::add_pages');

    }
}


?>