<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_model extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

   /**
    * Search for client information.
    *
    * @param first_name    First Name, can be null or partial.
    * @param last_name     Last Name, can be null or partial.
    * @param phone_number  Phone Number, can be null or partial.
    * @param expire_check  Membership expiring in 30 days.
    *
    * @return Records matching search criterias.
    */
    public function get_clients_from_params($first_name=null, $last_name=null, $phone_number=null, $expire_check=null)
    {
        $sql = "SELECT id, first_name, last_name, address, mailing_address, phone_number, membership_type, membership_expiry_date, CASE (DATEDIFF(membership_expiry_date, NOW()) < 30) WHEN 1 THEN 'YES' ELSE '' END AS 'expire30days' FROM client WHERE 1=1  ";
                
        $param_array = array();

        if (isset($first_name) && !empty($first_name))  
        {
            $sql .= " AND first_name LIKE ?";
            $param_array[] = array('%'.$first_name.'%');    
          
        }

        if (isset($last_name) && !empty($last_name))    
        {
            $sql .= " AND last_name LIKE ?";
            $param_array[] = array('%'.$last_name.'%'); 
          
        }

        if (isset($phone_number) && !empty($phone_number))  
        {
            $sql .= " AND phone_number LIKE ?";
            $param_array[] = array('%'.$phone_number.'%');  
          
        }

        if (isset($expire_check) && (strtoupper($expire_check) == "TRUE"))  
        {
            $sql .= " AND (DATEDIFF(membership_expiry_date, NOW()) < 30) = 1";
        }

        $query = $this->db->query($sql, $param_array);
        return $query->result_array();
   
    }

   /**
    * Insert new client information.
    *
    * @param first_name    First Name
    * @param last_name     Last Name
    * @param phone_number  Phone Number
    * @param address       Address
    * @param mailing_address  Mailing Address
    * @param member_type   Membership Type
    * @param expiry_date   Membership expiry date
    *
    * @return 1 for success and others for failure.
    */
    public function create_new_client($first_name=null, $last_name=null, $phone_number=null, $address=null, $mailing_address=null, $member_type=null, $expiry_date=null)
    {
        $sql = "INSERT INTO client (first_name, last_name, phone_number, address, mailing_address, membership_type, membership_expiry_date) VALUES (?, ?, ?, ?, ?, ?, ?)  ";

        $param_array = array($first_name, $last_name, $phone_number, $address, $mailing_address, $member_type, $expiry_date);

        $query = $this->db->query($sql, $param_array);
        return $query;
    }
        
}
