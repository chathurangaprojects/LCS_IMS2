<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class ItemPropertyManagement extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
		
			if(!$this->session->userdata('logged_in'))
			{
				redirect(base_url() . 'index.php/login');
			}
		
			$this->load->model('ItemProperty/ItemPropertyModel');
			$this->load->model('ItemProperty/ItemPropertyService');
		}
        
        /** 
         * Developed By: A.M.Roomi
         * Date: 03-01-2012
         * Purpose: Get all the properties based on the given ItemTypeID
         */
        public function getPropertyByItemTypeID()
        {
            $itemPropertyModel = new ItemPropertyModel();
            $itemPropertyService = new ItemPropertyService();
            
            $itemPropertyModel->setProperty_Code(trim($this->input->post('ItemTypeID', TRUE)));
            
            $propertyArray = $itemPropertyService->getPropertyByItemTypeID($itemPropertyModel);
            
            echo '<div class="other-box yellow-box ui-corner-all ui-corner-all" style="padding:5px;"><h3>Existing Item Properties</h3>';
            
            for($index = 0; $index < sizeof($propertyArray); $index++)
            {
                echo '<b>' . ($index + 1) . '. </b>' . $propertyArray[$index]->getProperty() . '<br/>';
            }
            
            echo '</div>';
        }
        
        /** 
         * Developed By: A.M.Roomi
         * Date: 04-01-2012
         * Purpose: Insert Property for the given Item Type
         */
         public function insertNewItemProperty()
         {
            echo 'aaaaaaaaaaaaaaaaaaaaaaaaa';
            return;
            $itemPropertyModel = new ItemPropertyModel();
            $itemPropertyService = new ItemPropertyService();
            
            $itemPropertyModel->setType_Code(trim($this->input->post('Item_Type_For_Property_Hidden', TRUE)));
            $itemPropertyModel->setProperty(trim($this->input->post('Item_Property', TRUE)));
            $itemPropertyModel->setProperty_Description(trim($this->input->post('Property_Description', TRUE)));
            
            echo $itemPropertyService->insertNewItemProperty($itemPropertyModel);
         }
	}
?>