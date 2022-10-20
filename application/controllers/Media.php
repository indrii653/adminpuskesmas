<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Task (TaskController)
 * Task Class to control task related operations.
 * @author : Kishor Mali
 * @version : 1.5
 * @since : 19 Jun 2022
 */
class Media extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('media_model', 'md');
        $this->isLoggedIn();
        $this->module = 'media';
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        redirect('media/mediaListing');
    }
    
    /**
     * This function is used to load the task list
     */
    function mediaListing()
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
            
            $count = $this->md->mediaListingCount($searchText);

			$returns = $this->paginationCompress ( "mediaListing/", $count, 10 );
            
            $data['records'] = $this->md->mediaListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : Media';
            
            $this->loadViews("media/list", $this->global, $data, NULL);
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
            $this->global['pageTitle'] = 'CodeInsect : Add New Media';

            $this->loadViews("media/add", $this->global, NULL, NULL);
        }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewmedia()
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('facebook','Facebook','trim|required|max_length[256]');
            $this->form_validation->set_rules('instagram','Instagram','trim|required|max_length[256]');
            $this->form_validation->set_rules('youtube','Youtube','trim|required|max_length[256]');
            $this->form_validation->set_rules('kantor','Nomor Kantor','trim|required|max_length[256]');
            $this->form_validation->set_rules('layanan','Layanan Pengaduan','trim|required|max_length[256]');
            $this->form_validation->set_rules('website','Website','trim|required|max_length[256]');
           
            
            if($this->form_validation->run() == FALSE)
            {
                $this->add();
            }
            else
            {
                $facebook = $this->security->xss_clean($this->input->post('facebook'));
                $instagram = $this->security->xss_clean($this->input->post('instagram'));
                $youtube = $this->security->xss_clean($this->input->post('youtube'));
                $kantor = $this->security->xss_clean($this->input->post('kantor'));
                $layanan = $this->security->xss_clean($this->input->post('layanan'));
                $email = $this->security->xss_clean($this->input->post('email'));
                $website = $this->security->xss_clean($this->input->post('website'));
                
                $mediaInfo = array('facebook'=>$facebook,'instagram'=>$instagram,'youtube'=>$youtube,'kantor'=>$kantor, 'layanan'=>$layanan, 'email'=>$email,'website'=>$website,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));         
                $result = $this->md->addNewmedia($mediaInfo);
                
                if($result > 0) {
                    $this->session->set_flashdata('success', 'New Media created successfully');
                } else {
                    $this->session->set_flashdata('error', 'Media creation failed');
                }
                
                redirect('media/mediaListing');
            }
        }
    }

    
    /**
     * This function is used load task edit information
     * @param number $taskId : Optional : This is task id
     */
    function edit($mediaId = NULL)
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($mediaId == null)
            {
                redirect('media/mediaListing');
            }
            
            $data['mediaInfo'] = $this->md->getmediaInfo($mediaId);

            $this->global['pageTitle'] = 'CodeInsect : Edit Media';
            
            $this->loadViews("media/edit", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editmedia()
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $taskId = $this->input->post('id');
            
            $this->form_validation->set_rules('facebook','Facebook','trim|required|max_length[256]');
            $this->form_validation->set_rules('instagram','Instagram','trim|required|max_length[256]');
            $this->form_validation->set_rules('youtube','Youtube','trim|required|max_length[256]');
            $this->form_validation->set_rules('kantor','Nomor Kantor','trim|required|max_length[256]');
            $this->form_validation->set_rules('layanan','Layanan Pengaduan','trim|required|max_length[256]');
            $this->form_validation->set_rules('website','Website','trim|required|max_length[256]');
            
            
            if($this->form_validation->run() == FALSE)
            {
                $this->edit($taskId);
            }
            else
            {
                $facebook = $this->security->xss_clean($this->input->post('facebook'));
                $instagram = $this->security->xss_clean($this->input->post('instagram'));
                $youtube = $this->security->xss_clean($this->input->post('youtube'));
                $kantor = $this->security->xss_clean($this->input->post('kantor'));
                $layanan = $this->security->xss_clean($this->input->post('layanan'));
                $email = $this->security->xss_clean($this->input->post('email'));
                $website = $this->security->xss_clean($this->input->post('website'));
                
                $mediaInfo = array('facebook'=>$facebook,'instagram'=>$instagram,'youtube'=>$youtube,'kantor'=>$kantor, 'layanan'=>$layanan, 'email'=>$email,'website'=>$website,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                $result = $this->md->editmedia($mediaInfo, $taskId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Media updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Media updation failed');
                }
                
                redirect('media/mediaListing');
            }
        }
    }
}

?>