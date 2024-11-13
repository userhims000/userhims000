<?php


namespace WPCWV;

if( ! defined( 'ABSPATH' ) ) { die('Let\'s not do this');}

/* This is just all queries on one page for quick access, no abstration or anything :-) */

class criticalfiles{

	public static function createTable(){
		global $wpdb;
		$table_name_wp_cwv_files = $wpdb->prefix . 'cwv_criticalfiles';

		$sql = "CREATE TABLE $table_name_wp_cwv_files (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			url varchar(255) NOT NULL,
			hash varchar(255) NOT NULL,
			pagetype varchar(255) NOT NULL,
			templateslug varchar(255) DEFAULT '' NOT NULL,
			posttype varchar(255) DEFAULT '' NOT NULL,
			status varchar(255) DEFAULT '' NOT NULL,
			PRIMARY KEY  (id)
		);";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

	}

	public static function getCount(){
		global $wpdb;
		$c = $wpdb->get_var('SELECT COUNT(*) FROM '.$wpdb->prefix.'cwv_criticalfiles');
    	return (int)$c;
	}
	public static function findOne($data,$key){
		global $wpdb;
		return $wpdb->get_row( 'SELECT id FROM '.$wpdb->prefix.'cwv_criticalfiles WHERE hash="'.$data[$key].'"' );
	}


	public static function findAll(){
		global $wpdb;
		$rows = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cwv_criticalfiles' );
		return (is_array($rows))?$rows:[];


	}



	public static function insert($data){
		global $wpdb;
		$table = $wpdb->prefix.'cwv_criticalfiles';
		$format = ['%s','%s','%s','%s','%s','%s'];
		return  $wpdb->insert($table,$data,$format);

	}



}

class criticalrules{


	public static function createTable(){

		global $wpdb;
		$table_name_wp_cwv_rules = $wpdb->prefix . 'cwv_criticalrules';

		$sql = "CREATE TABLE $table_name_wp_cwv_rules ( 
			id INT NOT NULL AUTO_INCREMENT ,
			rule varchar(255) NOT NULL,
			PRIMARY KEY (id)
		);";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}


	public static function findOne($data,$key){
		global $wpdb;
		return $wpdb->get_row( 'SELECT id FROM '.$wpdb->prefix.'cwv_criticalfiles WHERE hash="'.$data[$key].'"' );

	}


	public static function findAll(){
		global $wpdb;
		$rows = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cwv_criticalrules' );
		return (is_array($rows))?$rows:[];
	}



	public static function insert($data){
		global $wpdb;
		$table = $wpdb->prefix.'cwv_criticalrules';
		$format = ['%s'];
		return  $wpdb->insert($table,['rule'=>$data['rule']],$format);

	}

	public static function delete($id){
		global $wpdb;
		$table = $wpdb->prefix.'cwv_criticalrules';
		return  $wpdb->delete($table,['id'=>(int)$id]);

	}

	public static function update($data,$id){
		global $wpdb;
		$table = $wpdb->prefix.'cwv_criticalrules';
		return  $wpdb->update($table,['rule'=>$data['rule']],['id'=>(int)$id]);

	}
}


class scriptrules{


	public static function createTable(){

		global $wpdb;
		$table_name_wp_cwv_rules = $wpdb->prefix . 'cwv_scriptrules';

		$sql = "CREATE TABLE $table_name_wp_cwv_rules ( 
			id INT NOT NULL AUTO_INCREMENT ,
			scriptregex varchar(255) NOT NULL,
			scripttrigger varchar(255) NOT NULL,
			scriptselector varchar(255) NOT NULL,
			PRIMARY KEY (id)
		);";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}


	public static function findOne($data,$key){
		global $wpdb;
		return $wpdb->get_row( 'SELECT id FROM '.$wpdb->prefix.'cwv_scriptrules WHERE hash="'.$data[$key].'"' );

	}


	public static function findAll(){
		global $wpdb;
		$rows = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cwv_scriptrules' );
		return (is_array($rows))?$rows:[];
	}



	public static function insert($data){
		global $wpdb;
		$table = $wpdb->prefix.'cwv_scriptrules';
		$format = ['%s','%s','%s'];
		return $wpdb->insert($table,['scriptregex'=>$data['scriptregex'],'scripttrigger'=>$data['scripttrigger'],'scriptselector'=>$data['scriptselector']],$format);

	}

	public static function delete($id){
		global $wpdb;
		$table = $wpdb->prefix.'cwv_scriptrules';
		return  $wpdb->delete($table,['id'=>(int)$id]);

	}

	public static function update($data,$id){

		global $wpdb;
		$table = $wpdb->prefix.'cwv_scriptrules';
		return  $wpdb->update($table,['scriptregex'=>$data['scriptregex'],'scripttrigger'=>$data['scripttrigger'],'scriptselector'=>$data['scriptselector']],['id'=>(int)$id]);

	}
}