<?php

namespace business\facade;

function init_db()
{
	global $wpdb;
	dbDelta(<<<SQL
		CREATE TABLE customer (
			id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			tanto_id bigint(20) UNSIGNED,
			name_kanji_last varbinary(100),
			name_kanji_first varbinary(100),
			name_kana_last varbinary(100),
			name_kana_first varbinary(100),
			sex varbinary(20),	
			old varbinary(20),
			birthday varbinary(20),
			last_visit_date varbinary(20),
			phone_number varbinary(30),
			address varbinary(500),
			occupation varbinary(100),
			number_of_visit bigint(10),
			email varbinary(200),
			enable_dm TINYINT UNSIGNED,
			next_visit_reservation_date varbinary(200),
			reservation_route varbinary(500),
			remarks varbinary(500),
			PRIMARY KEY(id)
		)
SQL
		);

	dbDelta(<<<SQL
		CREATE TABLE staff (
			id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			name_last varchar(100) character set utf8,
			name_first varchar(100) character set utf8,
			tell int UNSIGNED,
			email varchar(100),
			PRIMARY KEY(id)
		)
SQL
		);
	dbDelta(<<<SQL
		CREATE TABLE customer_interval_setting (
			id bigint(20) UNSIGNED NOT NULL,
			value int(20) UNSIGNED NOT NULL,
			PRIMARY KEY(id)
		)
SQL
		);
	dbDelta(<<<SQL
		CREATE TABLE menu (
			id int UNSIGNED NOT NULL AUTO_INCREMENT,
			name varchar(100)  character set utf8,
			price int UNSIGNED,
			description text character set utf8,
			enable_reservation tinyint UNSIGNED,
			time_required tinyint UNSIGNED,
			PRIMARY KEY(id)
		)
SQL
		);

	dbDelta(<<<SQL
		CREATE TABLE menu_course (
			id int UNSIGNED NOT NULL AUTO_INCREMENT,
			menu_id int UNSIGNED NOT NULL,
			name varchar(100) character set utf8,
			price int UNSIGNED,
			time_required tinyint UNSIGNED,
			PRIMARY KEY(id, menu_id)
		)
SQL
		);
		
	dbDelta(<<<SQL
		CREATE TABLE sending_message (
			id int UNSIGNED NOT NULL AUTO_INCREMENT,
			title varchar(100),
			birth  int UNSIGNED NOT NULL,
			last_visit int UNSIGNED NOT NULL,
			next_visit int UNSIGNED NOT NULL,
			enable_dm tinyint UNSIGNED,
			sending_mail varchar(100),
			confirm_mail varchar(100),
			message_text text character set utf8,
			sex varbinary(10),
			visit_num int UNSIGNED NOT NULL,
			staff_id int UNSIGNED NOT NULL,
			PRIMARY KEY(id, menu_id)
		)
SQL
		);
}
?>