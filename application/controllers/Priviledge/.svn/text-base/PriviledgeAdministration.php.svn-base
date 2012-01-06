<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class PriviledgeAdministration extends CI_Controller
    {
        function __construct()
        {
            parent::__construct();

            $this->load->model('UserModel');
            $this->load->model('UserService');
            $this->load->model('UserModerationModel');
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->model(array('PurchaseOrder/DepartmentModel','PurchaseOrder/DepartmentService'));

        }//construct



        function index(){

            echo "Priviledge Administration Controller";

        }//function index




        function changeLevelPriviledges(){

            if($this->session->userdata('logged_in'))
            {

            $userService = new UserService();

            $isSuperAdmin = $userService->isSuperAdministrator($this->session->userdata('emp_id'));

            if($isSuperAdmin){

                //user has the priviledges

                $this->template->setTitles('', '', 'Level Privileges', 'Assign/Change Privileges');

                $this->template->load('template', 'levelPriviledges');


            }
            else{

                //Access Denied

                $this->template->setTitles('Access Denied', 'You are not allowed to access this page.', 'You are not allowed to access this page.', 'Please Contact Administrator...');

                $this->template->load('template', 'errorPage');

            }

            }//if user logged
            else{

                redirect(base_url().'index.php');
            }

        }//changeLevelPriviledges











    }//class

?>
