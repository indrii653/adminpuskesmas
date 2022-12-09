<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Task (TaskController)
 * Task Class to control task related operations.
 * @author : Kishor Mali
 * @version : 1.5
 * @since : 19 Jun 2022
 */
class Maklumat extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('Maklumat_model', 'm');
        $this->isLoggedIn();
        $this->module = 'Maklumat';
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        redirect('maklumat/maklumatListing');
    }
    
    /**
     * This function is used to load the task list
     */
    function maklumatListing()
    {
        if(!$this->hasListAccess())
        {
            $this->loadThis();
        }
        else
        {        
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->m->maklumatListingCount($searchText);

			$returns = $this->paginationCompress ( "maklumatListing/", $count, 10 );
            
            $data['records'] = $this->m->maklumatListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : maklumat';
            
            $this->loadViews("maklumat/list", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function add()
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->global['pageTitle'] = 'CodeInsect : Add New Maklumat';

            $this->loadViews("maklumat/add", $this->global, NULL, NULL);
        }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewmaklumat()
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        {
                
            $this->load->library('form_validation');
            
            $taskId = $this->input->post('taskId');
            $config['upload_path']          = './../public_html/img';
            $config['allowed_types']        = 'gif|jpg|jpeg|png';
            $config['file_name']            = md5(date('Y-m-d H:i:s:u'));
            $config['overwrite']            = true;
            $config['max_size']             = 1024; // 1MB

            $this->load->library('upload', $config);                
            $this->upload->initialize($config);

            $data['error'] = $this->upload->display_errors();

            if (!$this->upload->do_upload('img')) {
                // $ambilnama=$this->m->getmaklumatInfo($taskId);                 
                // $namafile = $ambilnama->img;
                echo $this->upload->display_errors();
            } else {
                $uploaded_data = $this->upload->data();
                $namafile = $uploaded_data['file_name'];
            }

            
            $maklumatInfo = array('maklumat'=>$namafile, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->m->editmaklumat($maklumatInfo, $taskId);
            
            if($result == true)
            {
                $this->session->set_flashdata('success', 'Maklumat updated successfully');
                // $this->session->set_flashdata('success', $this->upload->display_errors().$config['upload_path']);
            }
            else
            {
                $this->session->set_flashdata('error', 'Maklumat updation failed');
            }
            
            redirect('maklumat/maklumatListing');
        }
    }

    
    /**
     * This function is used load task edit information
     * @param number $taskId : Optional : This is task id
     */
    function edit($maklumatId = NULL)
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($maklumatId == null)
            {
                redirect('maklumat/maklumatListing');
            }
            
            $data['maklumatInfo'] = $this->m->getmaklumatInfo($maklumatId);

            $this->global['pageTitle'] = 'CodeInsect : Edit Maklumat';
            
            $this->loadViews("maklumat/edit", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editmaklumat()
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
                $taskId = $this->input->post('taskId');
                $config['upload_path']          = './../public_html/img';
                $config['allowed_types']        = 'gif|jpg|jpeg|png';
                $config['file_name']            = md5(date('Y-m-d H:i:s:u'));
                $config['overwrite']            = true;
                $config['max_size']             = 1024; // 1MB

                $this->load->library('upload', $config);                
                $this->upload->initialize($config);

                $data['error'] = $this->upload->display_errors();

                if (!$this->upload->do_upload('img')) {
                    // $ambilnama=$this->m->getmaklumatInfo($taskId);                 
                    // $namafile = $ambilnama->img;
                    echo $this->upload->display_errors();
                } else {
                    $uploaded_data = $this->upload->data();
                    $namafile = $uploaded_data['file_name'];
                }

                
                $maklumatInfo = array('maklumat'=>$namafile, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->m->editmaklumat($maklumatInfo, $taskId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Maklumat updated successfully');
                    // $this->session->set_flashdata('success', $this->upload->display_errors().$config['upload_path']);
                }
                else
                {
                    $this->session->set_flashdata('error', 'Maklumat updation failed');
                }
                
                redirect('maklumat/maklumatListing');
        }
    }
}

?>