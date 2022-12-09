<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Task (TaskController)
 * Task Class to control task related operations.
 * @author : Kishor Mali
 * @version : 1.5
 * @since : 19 Jun 2022
 */
class Banner extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('Banner_model', 'bn');
        $this->isLoggedIn();
        $this->module = 'Banner';
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        redirect('banner/bannerListing');
    }
    
    /**
     * This function is used to load the task list
     */
    function bannerListing()
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
            
            $count = $this->bn->bannerListingCount($searchText);

			$returns = $this->paginationCompress ( "bannerListing/", $count, 10 );
            
            $data['records'] = $this->bn->bannerListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : Banner';
            
            $this->loadViews("banner/list", $this->global, $data, NULL);
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
            $this->global['pageTitle'] = 'CodeInsect : Add New Banner';

            $this->loadViews("banner/add", $this->global, NULL, NULL);
        }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewbanner()
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        {
                $h5 = $this->security->xss_clean($this->input->post('h5'));
                $h1 = $this->security->xss_clean($this->input->post('h1'));
                $p = $this->security->xss_clean($this->input->post('p'));
                
                $bannerInfo = array('h5'=>$h5, 'h1'=>$h1,'p'=>$p,'img'=>$namafile, 'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->bn->addNewbanner($bannerInfo);
                
                if($result > 0) {
                    $this->session->set_flashdata('success', 'New Banner created successfully');
                } else {
                    $this->session->set_flashdata('error', 'Banner creation failed');
                }
                
                redirect('banner/bannerListing');
            }
    }

    
    /**
     * This function is used load task edit information
     * @param number $taskId : Optional : This is task id
     */
    function edit($bannerId = NULL)
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($bannerId == null)
            {
                redirect('banner/bannerListing');
            }
            
            $data['bannerInfo'] = $this->bn->getBannerInfo($bannerId);

            $this->global['pageTitle'] = 'CodeInsect : Edit Banner';
            
            $this->loadViews("banner/edit", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editBanner()
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
                    // $ambilnama=$this->bn->getBannerInfo($taskId);                 
                    // $namafile = $ambilnama->img;
                    echo $this->upload->display_errors();
                } else {
                    $uploaded_data = $this->upload->data();
                    $namafile = $uploaded_data['file_name'];
                }

                $h5 = $this->security->xss_clean($this->input->post('h5'));
                $h1 = $this->security->xss_clean($this->input->post('h1'));
                $p = $this->security->xss_clean($this->input->post('p'));
                
                $bannerInfo = array('h5'=>$h5, 'h1'=>$h1,'p'=>$p,'img'=>$namafile, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->bn->editBanner($bannerInfo, $taskId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Banner updated successfully');
                    // $this->session->set_flashdata('success', $this->upload->display_errors().$config['upload_path']);
                }
                else
                {
                    $this->session->set_flashdata('error', 'Banner updation failed');
                }
                
                redirect('banner/bannerListing');
        }
    }
}

?>