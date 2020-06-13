<?php

class Apotek_Models extends CI_Model{
  
  public function __construct() {
    
  }
  
  public function get_data($table){
    return $this->db->get($table)->result();
  }
  
  public function get_data_query($query){
    return $this->db->query($query);
  }
}

?>