<?php

class UpsApiTable
{
    public function plugin_activation()
    {
        global $wpdb;
        global $jal_db_version;

        $table_name = $wpdb->prefix . 'ups';

        $sql = "CREATE TABLE $table_name  (
          id int(11) unsigned NOT NULL AUTO_INCREMENT,
          shipment_no varchar(255) DEFAULT NULL,
          shiptment_name varchar(255) DEFAULT NULL,
          shipment_attention_name varchar(255) DEFAULT NULL,
          shipment_address varchar(255) DEFAULT NULL,
          shipment_postal_code varchar(255) DEFAULT NULL,
          shipment_city varchar(255) DEFAULT NULL,
          shipment_province_code varchar(255) DEFAULT NULL,
          shipment_email_address varchar(255) DEFAULT NULL,
          shipment_phone_number varchar(255) DEFAULT NULL,
          to_address_one varchar(255) DEFAULT NULL,
          to_address_postal_code varchar(255) DEFAULT NULL,
          to_address_city varchar(255) DEFAULT NULL,
          to_address_province_code varchar(255) DEFAULT NULL,
          to_address_countyr_code varchar(255) DEFAULT NULL,
          to_company_name varchar(255) DEFAULT NULL,
          to_address_attention_name varchar(255) DEFAULT NULL,
          to_address_email varchar(255) DEFAULT NULL,
          to_address_phone_number varchar(255) DEFAULT NULL,
          sold_address_one varchar(255) DEFAULT NULL,
          sold_address_postal_code varchar(255) DEFAULT NULL,
          sold_address_city varchar(255) DEFAULT NULL,
          sold_address_country_code varchar(255) DEFAULT NULL,
          sold_address_province_code varchar(255) DEFAULT NULL,
          sold_address_attention_name varchar(255) DEFAULT NULL,
          sold_address_email_address varchar(255) DEFAULT NULL,
          sold_address_phone_number varchar(255) DEFAULT NULL,
          from_address_one varchar(255) DEFAULT NULL,
          from_address_postal_code varchar(255) DEFAULT NULL,
          from_address_city varchar(255) DEFAULT NULL,
          from_address_province_code varchar(255) DEFAULT NULL,
          from_address_country_code varchar(255) DEFAULT NULL,
          from_address_company_name varchar(255) DEFAULT NULL,
          from_address_email_address varchar(255) DEFAULT NULL,
          from_address_phone_number varchar(255) DEFAULT NULL,
          order_id varchar(255) DEFAULT NULL,
          datetime_created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
          PRIMARY KEY (id)
        ) $wpdb->get_charset_collate();";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
        add_option( 'jal_db_version', $jal_db_version );
    }

    public function plugin_deactivation()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ups';
        $sql = "DROP TABLE IF EXISTS $table_name";
        $wpdb->query($sql);
    }
}