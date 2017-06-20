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
			email varbinary(200) UNIQUE NOT NULL,
			enable_dm TINYINT UNSIGNED,
			next_visit_reservation_date varbinary(200),
			reservation_route varbinary(50),
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
			`imgdat` MEDIUMBLOB,
			`mime` VARCHAR(64),
			introduce_page_url text character set utf8,
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
			description text character set utf8,
			enable_reservation tinyint UNSIGNED,
			updated_at timestamp not null default current_timestamp on update current_timestamp,
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
			sequence_no  int UNSIGNED,
			first_discount int UNSIGNED,
			time_required tinyint UNSIGNED,
			PRIMARY KEY(id)
		)
SQL
		);
		
	dbDelta(<<<SQL
		CREATE TABLE sending_message (
			id int UNSIGNED NOT NULL AUTO_INCREMENT,
			title text character set utf8,
			birth  int,
			last_visit int,
			next_visit int,
			enable_dm tinyint UNSIGNED,
			sending_mail varchar(100),
			confirm_mail varchar(100),
			message_text text character set utf8,
			sex varchar(10),
			visit_num_more int UNSIGNED,
			visit_num_less int UNSIGNED,
			staff_id int UNSIGNED,
			occupation text character set utf8,
			reservation_route tinyint UNSIGNED,
			PRIMARY KEY(id)
		)
SQL
		);
		
	dbDelta(<<<SQL
		CREATE TABLE sales (
			day DATE NOT NULL,
			amount_of_sales BIGINT UNSIGNED,
			per_customer_price BIGINT UNSIGNED,
			number_of_customers_new int UNSIGNED,
			number_of_customers_repeater int UNSIGNED,
			PRIMARY KEY(day)
		)
SQL
		);
		
	dbDelta(<<<SQL
		CREATE TABLE weekly_yoyaku (
			from_time TIME NOT NULL,
			to_time TIME NOT NULL,
			is_regular_holiday tinyint UNSIGNED,
			week_kbn tinyint UNSIGNED,
			PRIMARY KEY(week_kbn)
		)
SQL
		);

	dbDelta(<<<SQL
		CREATE TABLE yoyaku_registration (
			id int UNSIGNED NOT NULL AUTO_INCREMENT,
			staff_id int UNSIGNED,
			customer_id int UNSIGNED,
			start_time DATETIME not null,
			course_id_list text,
			schedule_division int UNSIGNED,
			consultation text,
			PRIMARY KEY(id)
		)
SQL
		);


	dbDelta(<<<SQL
		CREATE TABLE yoyaku_schedule (
			id int UNSIGNED NOT NULL AUTO_INCREMENT,
			staff_id int UNSIGNED,
			start_time DATETIME not null,
			minutes int UNSIGNED not null,
			schedule_division int  UNSIGNED NOT NULL,
			name text,
			data text,
			PRIMARY KEY(id)
		)
SQL
		);


	dbDelta(<<<SQL
		CREATE TABLE yoyaku_config (
			id int UNSIGNED NOT NULL,
			value text,
			PRIMARY KEY(id)
		)
SQL
		);

}


?>