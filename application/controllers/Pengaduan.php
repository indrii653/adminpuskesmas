<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Task (TaskController)
 * Task Class to control task related operations.
 * @author : Kishor Mali
 * @version : 1.5
 * @since : 19 Jun 2022
 */
class Pengaduan extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('Pengaduan_model', 'p');
        $this->isLoggedIn();
        $this->module = 'Pengaduan';
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        redirect('pengaduan/pengaduanListing');
    }
    
    /**
     * This function is used to load the task list
     */
    function pengaduanListing()
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
            
            $count = $this->p->pengaduanListingCount($searchText);

			$returns = $this->paginationCompress ( "pengaduanListing/", $count, 10 );
            
            $data['records'] = $this->p->pengaduanListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : Pengaduan';
            
            $this->loadViews("pengaduan/list", $this->global, $data, NULL);
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
            $this->global['pageTitle'] = 'CodeInsect : Add New Pengaduan';

            $this->loadViews("pengaduan/add", $this->global, NULL, NULL);
        }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewpengaduan()
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        {       
            $this->load->library('form_validation');
            
            $taskId = $this->input->post('taskId');
            $config['upload_path']          = './../public_html/img/blog/';
            $config['allowed_types']        = 'gif|jpg|jpeg|png';
            $config['file_name']            = md5(date('Y-m-d H:i:s:u'));
            $config['overwrite']            = true;
            $config['max_size']             = 1024; // 1MB

            $this->load->library('upload', $config);                
            $this->upload->initialize($config);

            $data['error'] = $this->upload->display_errors();

            if (!$this->upload->do_upload('img')) {
                // $ambilnama=$this->p->getpengaduanInfo($taskId);                 
                // $namafile = $ambilnamp->img;
                echo $this->upload->display_errors();
            } else {
                $uploaded_data = $this->upload->data();
                $namafile = $uploaded_data['file_name'];
            }
            
            $pengaduanInfo = array('banner1'=>$namafile,'banner2'=>$namafile,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            $result = $this->p->addNewpengaduan($pengaduanInfo);
            
            if($result == true)
            {
                $this->session->set_flashdata('success', 'Pengaduan updated successfully');
                // $this->session->set_flashdata('success', $this->upload->display_errors().$config['upload_path']);
            }
            else
            {
                $this->session->set_flashdata('error', 'Pengaduan updation failed');
            }
            
            redirect('pengaduan/pengaduanListing');
            }
    }

    
    /**
     * This function is used load task edit information
     * @param number $taskId : Optional : This is task id
     */
    function edit($pengaduanId = NULL)
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($pengaduanId == null)
            {
                redirect('pengaduan/pengaduanListing');
            }
            
            $data['pengaduanInfo'] = $this->p->getpengaduanInfo($pengaduanId);

            $this->global['pageTitle'] = 'CodeInsect : Edit Pengaduan';
            
            $this->loadViews("pengaduan/edit", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editpengaduan()
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
                $taskId = $this->input->post('taskId');
                $config['upload_path']          = './../public_html/img/blog/';
                $config['allowed_types']        = 'gif|jpg|jpeg|png';
                $config['file_name']            = md5(date('Y-m-d H:i:s:u'));
                $config['overwrite']            = true;
                $config['max_size']             = 1024; // 1MB

                $this->load->library('upload', $config);                
                $this->upload->initialize($config);

                $data['error'] = $this->upload->display_errors();

                if (!$this->upload->do_upload('img')) {
                    // $ambilnama=$this->p->getpengaduanInfo($taskId);                 
                    // $namafile = $ambilnamp->img;
                    echo $this->upload->display_errors();
                } else {
                    $uploaded_data = $this->upload->data();
                    $namafile = $uploaded_data['file_name'];
                }
                
                $pengaduanInfo = array('banner1'=>$namafile,'banner2'=>$namafile,'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                $result = $this->p->editpengaduan($pengaduanInfo, $taskId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Pengaduan updated successfully');
                    // $this->session->set_flashdata('success', $this->upload->display_errors().$config['upload_path']);
                }
                else
                {
                    $this->session->set_flashdata('error', 'Pengaduan updation failed');
                }
                
                redirect('pengaduan/pengaduanListing');
        }
    }
}

?>