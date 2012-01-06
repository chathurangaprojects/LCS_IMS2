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
        $this->load->model(array('PurchaseOrder/DepartmentModel','PurchaseOrder/DepartmentService','Priviledge/MasterPriviledgeModel','Priviledge/MasterPriviledgeService','Priviledge/SubPriviledgeModel','Priviledge/SubPriviledgeService','Priviledge/MasterAndSubPriviledgeModel'));

    }//construct



    function index(){

        echo "Priviledge Administration Controller";

    }//function index


/* display the level change view */

    function displayChangeLevelPriviledges(){


        if($this->session->userdata('logged_in'))
        {

            $userService = new UserService();

            $isSuperAdmin = $userService->isSuperAdministrator($this->session->userdata('emp_id'));

            if($isSuperAdmin){

                //user has the privileges


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




    }//displayChangeLevelPriviledges



    /* change the level */

    function changeLevelPriviledges(){

        if($this->session->userdata('logged_in'))
        {

            $userService = new UserService();

            $isSuperAdmin = $userService->isSuperAdministrator($this->session->userdata('emp_id'));

            if($isSuperAdmin){

                //user has the privileges


                //retrieving all Master Privileges
                $masterPrivilegeService = new MasterPriviledgeService();

                $masterPrivilegeModelArray = $masterPrivilegeService->retrieveAllMasterPriviledges();


                $subPrivilegeService = new SubPriviledgeService();


                //the following data array will be passed to the view
                $priviledgeDataArray = array();


                //retrieving each sub priviledge under the master priviledge
                for($index=0;$index<sizeof($masterPrivilegeModelArray);$index++){

                    $subPriviledgeModel= $subPrivilegeService->retrieveSubPrivilegeBasedOnMasterPriviledge($masterPrivilegeModelArray[$index]);

                    $masterAndSubModel = new MasterAndSubPriviledgeModel();

                    $masterAndSubModel->setMasterPriviledge($masterPrivilegeModelArray[$index]);
                    $masterAndSubModel->setSubPriviledge($subPriviledgeModel);

                    //set up the retrieved data to the array

                    $priviledgeDataArray[$index] = $masterAndSubModel;

                }//for


                $data=array('priviledgeDataArray'=>$priviledgeDataArray);

                $this->template->setTitles('', '', 'Level Privileges', 'Assign/Change Privileges');

                $this->template->load('template', 'levelPriviledges',$data);


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








    /* retrieve assigned  priviledegs for the given department and level */


    function departmentLevelPriviledges(){

        if($this->session->userdata('logged_in'))
        {

            $userService = new UserService();

            $isSuperAdmin = $userService->isSuperAdministrator($this->session->userdata('emp_id'));

            if($isSuperAdmin){

                //user has the privileges


                //retrieving all Master Privileges
                $masterPrivilegeService = new MasterPriviledgeService();

                $masterPrivilegeModelArray = $masterPrivilegeService->retrieveAllMasterPriviledges();


                $subPrivilegeService = new SubPriviledgeService();


                //the following data array will be passed to the view
                $priviledgeDataArray = array();


                //retrieving each sub priviledge under the master priviledge
                for($index=0;$index<sizeof($masterPrivilegeModelArray);$index++){

                    $subPriviledgeModel= $subPrivilegeService->retrieveSubPrivilegeBasedOnMasterPriviledge($masterPrivilegeModelArray[$index]);

                    $masterAndSubModel = new MasterAndSubPriviledgeModel();

                    $masterAndSubModel->setMasterPriviledge($masterPrivilegeModelArray[$index]);
                    $masterAndSubModel->setSubPriviledge($subPriviledgeModel);

                    //set up the retrieved data to the array

                    $priviledgeDataArray[$index] = $masterAndSubModel;

                }//for



                //echo "department level priviledges";

                //start



                $string='';

                for($index=0;$index<sizeof($priviledgeDataArray);$index++){

                    $MasterAndSubPriviledgeModel = $priviledgeDataArray[$index];

                    $masterPriviledgeModel = $MasterAndSubPriviledgeModel->getMasterPriviledge();

                    //$subPriviledgeModel contains an array
                    $subPriviledgeModel =  $MasterAndSubPriviledgeModel->getSubPriviledge();




                    $string=$string.'<h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" role="tab" aria-expanded="false" aria-selected="false" tabindex="-1">
            <span class="ui-icon ui-icon-triangle-1-e"></span>

            <a href="#" tabindex="-1">'.$masterPriviledgeModel->getMaster_Privilege().'</a>
        </h3>

        <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="height: 300px; overflow: auto; padding-top: 11.2px; padding-bottom: 11.2px;" role="tabpanel">';


                    //display the sub priviledges
                    for($ind=0;sizeof($subPriviledgeModel)>$ind;$ind++){

                        $string=$string.$subPriviledgeModel[$ind]->getPrivilege().'<br/>';

                    }

                    $string = $string.'</div>';


                }//for


                echo $string;

                //ends



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

    }//departmentLevelPriviledges




}//class

?>
