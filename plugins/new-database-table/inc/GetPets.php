<?php
class GetPets {
    function __construct() {
        global $wpdb;
        $tablename = $wpdb->prefix . 'pets';
        $this->args = $this->getArgs();
        $countQuery = "SELECT count(*) FROM $tablename ";
        $countQuery .= $this->queryBuilder();
        $query = "SELECT * FROM $tablename ";
        $query .= $this->queryBuilder();
        $query .= " LIMIT 100";
        //$ourQuery = $wpdb->prepare("SELECT * FROM $tablename WHERE species = %s LIMIT 100", array($_GET['species']));

        $this->count = $wpdb->get_var($wpdb->prepare($countQuery, $this->args));
        $this->pets = $wpdb->get_results($wpdb->prepare($query, $this->args));
        $this->test = $query;
    }

    function getArgs() {
        $temp = [];
     
        if (isset($_GET['favcolor'])) $temp['favcolor'] = sanitize_text_field($_GET['favcolor']);
        if (isset($_GET['species'])) $temp['species'] = sanitize_text_field($_GET['species']);
        if (isset($_GET['minyear'])) $temp['minyear'] = sanitize_text_field($_GET['minyear']);
        if (isset($_GET['maxyear'])) $temp['maxyear'] = sanitize_text_field($_GET['maxyear']);
        if (isset($_GET['minweight'])) $temp['minweight'] = sanitize_text_field($_GET['minweight']);
        if (isset($_GET['maxweight'])) $temp['maxweight'] = sanitize_text_field($_GET['maxweight']);
        if (isset($_GET['favhobby'])) $temp['favhobby'] = sanitize_text_field($_GET['favhobby']);
        if (isset($_GET['favfood'])) $temp['favfood'] = sanitize_text_field($_GET['favfood']);
     
        return $temp;
     
      }

    function queryBuilder() {
        $whereQuery = "";

        if (count($this->args)) {
            $whereQuery = "WHERE ";
        }
        
        $control = 0;
        foreach($this->args as $index => $item) {
            $whereQuery .= $this->queryHelper($index);
            if ($control != count($this->args) -1) {
                $whereQuery .= " AND ";
            }
            $control++;
        }

        return $whereQuery;
    }

    function queryHelper($index) {
        switch ($index) {
            case "minweight":
                return "petweight >= %d";
            case "maxweight":
                return "petweight <= %d";
            case "minyear":
                return "birthyear >= %d";
            case "maxyear":
                return "birthyear <= %d";
            default:
                return $index . " = %s";

        }
    }
}
  ?>