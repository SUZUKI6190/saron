<?php
class CustomMetaTable {
	//プラグインのテーブル名
	var $table_name;
	public function __construct()
	{
		global $wpdb;
		//接頭辞（wp_）を付けてテーブル名を設定
		$this->table_name = $wpdb->prefix . 'ex_meta';
		//プラグイン有効かしたとき実行
		register_activation_hook (__FILE__, array($this, 'cmt_activate'));
	}

	function cmt_activate(){
		global $wpdb;
		$cmt_db_version = '1.0';
		$installed_ver = get_option('cmt_meta_version');
		if($installed_ver != $cmt_db_version){
			$sql = "CREATE TABLE " . $this->table_name." (
					meta_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
					post_id bigint(20) UNSIGNED DEFAULT '0' NOT NULL,
					item_name text,
					price int(11),
					UNIQUE KEY meta_id (meta_id)
					)
					CHARACTER SET 'utf8';";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
			update_option('cmt_meta_version', $cmt_db_version);
		}
		
	}
}
$exmeta = new CustomMetaTable;
?>