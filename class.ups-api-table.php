<?php

class UpsApiTable
{
    public function plugin_activation()
    {
        global $wpdb;
        global $jal_db_version;

        $table_name = $wpdb->prefix . 'ups_shipment';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name  (
          id int(11) unsigned NOT NULL AUTO_INCREMENT,
          to_address_one varchar(255) DEFAULT NULL,
          to_address_postal_code varchar(255) DEFAULT NULL,
          to_address_city varchar(255) DEFAULT NULL,
          to_address_province_code varchar(255) DEFAULT NULL,
          to_address_countyr_code varchar(255) DEFAULT NULL,
          to_company_name varchar(255) DEFAULT NULL,
          to_company_attention_name varchar(255) DEFAULT NULL,
          to_company_email varchar(255) DEFAULT NULL,
          to_company_phone_number varchar(255) DEFAULT NULL,
          shipment_identification_no varchar(255) DEFAULT NULL,
          ups_label varchar(255) DEFAULT NULL,
          datetime_created datetime  DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        add_option('jal_db_version', $jal_db_version);
    }

    public function plugin_deactivation()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ups_shipment';
        $sql = "DROP TABLE IF EXISTS $table_name";
        $wpdb->query($sql);
    }
}
