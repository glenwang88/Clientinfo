<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

    }

   /**
    * REST GET interface to search for client information.
    * Searching parameters in GET format.
    *
    * @param first_name    First Name, can be null or partial.
    * @param last_name     Last Name, can be null or partial.
    * @param phone_number  Phone Number, can be null or partial.
    * @param expire_check  Membership expiring in 30 days.
    *
    * @return JSON of records matching search criterias.
    */
    public function search_clients_info()
    {
        /*
         * Header information.
         * Endpoint/user validation can be added when needed.
         */
        header('Access-Control-Allow-Origin: *'); 
        if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('Access-Control-Allow-Methods: GET, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type');
            exit;
        }

        /*
         * Get searching parameters
         */
        $first_name = $this->input->get("first_name"); 
        $last_name = $this->input->get("last_name"); 
        $phone_number = $this->input->get("phone_number"); 
        $expire_check = $this->input->get("expire_check"); 

        /*
         * Parameters can be null, could add other validations if needed.
         */

        /*
         * Search clients information in database
         */
        try {
            $this->load->model('client_model');            
            $results = $this->client_model->get_clients_from_params($first_name, $last_name, $phone_number, $expire_check );

            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode($results);

        } catch (Exception $e) {
            log_message('error', 'Caught exception: ' .  $e->getMessage());
            // set response code - 503 service unavailable
            http_response_code(503);
        }

    }

   /**
    * REST POST interface to add new client information.
    * Client information in JSON format.
    *
    * @param first_name    First Name
    * @param last_name     Last Name
    * @param phone_number  Phone Number
    * @param address       Address
    * @param mailing_address  Mailing Address
    * @param member_type   Membership Type
    * @param expiry_date   Membership expiry date
    *
    * @return JSON "status" of "Success" or "Failed".
    */
    public function create_new_client()
    {
        /*
         * Header information.
         * Endpoint/user validation can be added when needed.
         */
        header('Access-Control-Allow-Origin: *'); //for test
        if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('Access-Control-Allow-Methods: POST, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type');
            exit;
        }
        header('Content-Type: application/json');

        $result["status"] = "";
        $maxStringLen = 300; 

        /*
         * Get input new client information
         */
        $data = json_decode( file_get_contents( 'php://input' ), true );
        $first_name = $data["first_name"];
        $last_name = $data["last_name"];
        $phone_number = $data["phone_number"];
        $address = $data["address"];
        $mailing_address = $data["mailing_address"];
        $member_type = $data["member_type"];
        $expiry_date = $data["expiry_date"];
        if ($this->IsNullOrEmpty($member_type))
        {
            $expiry_date = null;
        }
        
        /*
         * Validate the mandatory fields.
         */
        if ($this->IsNullOrEmpty($first_name) || $this->IsNullOrEmpty($last_name) || $this->IsNullOrEmpty($address))
        {
            $result["status"] = "Failed";
            $result["message"] = "Missing mandatory fields.";
            // set response code - 400 bad request
            http_response_code(400);
            echo json_encode($result);
            return;
        }

        /*
         * Validate the maximum length, could add other validations if needed.
         */
        if (strlen($first_name) > $maxStringLen || strlen($last_name) > $maxStringLen || 
            strlen($phone_number) > $maxStringLen || strlen($address) > $maxStringLen ||
            strlen($mailing_address) > $maxStringLen || strlen($member_type) > $maxStringLen ||
            strlen($expiry_date) > $maxStringLen )
        {
            $result["status"] = "Failed";
            $result["message"] = "Data validation error.";
            // set response code - 400 bad request
            http_response_code(400);
            echo json_encode($result);
            return;
        }

        try {
            /*
             * Insert new client in database
             */
            $this->load->model('client_model');
            $query_res = $this->client_model->create_new_client($first_name, $last_name, $phone_number, $address, $mailing_address, $member_type, $expiry_date);

            /*
             * Check insert operation result
             */
            if ($query_res == 1)
            {
                $result["status"] = "Success";
                $result["message"] = "Client was created.";
                // set response code - 201 created
                http_response_code(201);
                echo json_encode($result);
            }
            else
            {
                $result["status"] = "Failed";
                $result["message"] = "Unable to create client.";
                // set response code - 503 service unavailable
                http_response_code(503);
                echo json_encode($result);
            }
        } catch (Exception $e) {

            log_message('error', 'Caught exception: ' .  $e->getMessage());
            $result["status"] = "Failed";
            $result["message"] = "Unable to create client.";
            // set response code - 503 service unavailable
            http_response_code(503);
            echo json_encode($result);
        }

    }

    /**
    * Function for basic field validation (present and neither empty nor only white space
    *
    * @param str    String to validate
    *
    * @return Boolean, whether is null or empty
    */
    private function IsNullOrEmpty($str)
    {
        return (!isset($str) || trim($str) === '');
    }
        
}
