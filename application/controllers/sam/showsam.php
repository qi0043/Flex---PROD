<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller to show SAM in HTML or PDF format
 */
class Showsam extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $ci =& get_instance();
        $ci->load->config('flex');
        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');
        $this->load->library('uuid/uuid');

        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
          log_message('error', 'REST processClientCredentialToken controller error');
          exit;
        }
    }

    /**
     * Display a SAM in HTML or PDF format
     *
     * @param string $format, html/pdf
     * @param array $uuid, item UUID
     * @param array $version, item Version
     */
    public function index($format='html', $uuid='missed', $version='missed', $avail_ref='missed', $avail_ver='missed')
    {
        #$this->output->enable_profiler(TRUE);
        $errdata['heading'] = "Error";

        if($this->validate_params($format, $uuid, $version) == false)
        {
            $errdata['message'] = "Invalid Request";
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }

        $this->load->helper('url');

        #Check system down time.
        $this->load->model('sam/sam_model');
        $down_notice = false;
        $down_notice = $this->sam_model->db_chk_notice();
        if($down_notice != false)
        {
            #$this->error_info($down_notice['message']);
            if ($down_notice['message'] == '')
                $down_notice['message'] = 'SAM is temporarily unavailable, please try again later.';
            #echo $down_notice['message'];
            $data['view'] = 'sam/flo/notice_info';
            $data['page_title'] = 'Statement of Assessment Methods';
            $data['notice_info'] = $down_notice['message'];
            $this->load->view('sam/flo/layout', $data);
            $this->output->_display();
            exit();
        }

        $this->load->library('flexrest/flexrest');
        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }

        $success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }

        #echo "<pre>";
        #print_r($response);
        #echo "</pre>";
        #log_message('error', htmlentities($response['metadata']));

        $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']));

        if(!$this->itemIsSam($this->xmlwrapper))
        {
            $errdata['message'] = "Item is not SAM";
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }

        $sam_array = $this->samXml2Array($this->xmlwrapper);

        $sam_array['status'] = $response['status'];
        #log_message('error', $response['status']);

        #echo'<pre>';
        #echo 'response================<br>';
        #print_r($response);
        #echo 'sam-array===============<br>';
        #print_r($sam_array);
        #echo 'responsemetadata========<br>';
        #echo (string)$response['metadata'];
        #echo'</pre><br><hr/>';

        /*
        if($this->xmlwrapper->num_node_notfound > 7)
        {
            $errdata['message'] = "Metadata missing";
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        */
        $data = array('sam_array' => $sam_array);

        /* Set the variables from the metadata */

        /*$data['sam_array']['avail_ref'] = $data['sam_array']['metadata']['availability'][1]['avRef'];
        $data['sam_array']['avail_ver'] = $data['sam_array']['metadata']['availability'][1]['avVersion'];
        $data['sam_array']['avail_year'] = $data['sam_array']['metadata']['availability'][1]['avYear'];*/

        //Han fixed location display error 07/09/2018
        $data['sam_array']['avail_ref'] = $avail_ref;
        foreach($data['sam_array']['metadata']['availability'] as $avails)
        {
          if($avails['avRef'] == $avail_ref)
          {
            $data['sam_array']['avail_year'] = $avails['avYear'];
            $data['sam_array']['avail_ver'] = $avails['avVersion'];
            break;
          }
        }

        /*
         *
         * Dynamically set the view to display the correct SAM template for the designated year
         *
         *
         */
        $sam_for_delivery = 'sam/showsam_view_' . $data['sam_array']['avail_year'];

        if($format=='html')
        {
            $data['sam_array']['format'] = 'html';

            $this->load->view($sam_for_delivery, $data);
        }
        else if($format=='pdf')
        {
            $data['sam_array']['format'] = 'pdf';
            $data['sam_array']['uuid'] = $uuid; #item uuid
            $data['sam_array']['version'] = $version; #item version number


            $sam_for_delivery = 'sam/showsam_view_' . $data['sam_array']['avail_year'] . 'p';

            /*
            if($data['sam_array']['metadata']['approved'] == 'Yes' && isset($response['attachments']) && isset($response['attachments'][0]))
            {
		    //if a = b, means this attachment is the signature image
		    if($response['attachments'][0]['uuid'] == $data['sam_array']['metadata']['signature_Uuid'])
            { //attachment uuid
                  $data['sam_array']['attachments_name'] = $response['attachments'][0]['filename']; //attachment file name

                  #generate a token for OAuth user to be able to see digital signature for 30 mintues.
                  $data['sam_array']['url'] = $this->generateToken();
		    }

                    $ci =& get_instance();
                    $ci->load->config('flex');
                    $institute_url = $ci->config->item('institute_url');
                    $data['sam_array']['institute_url'] = $institute_url;
            }
            */
            if(isset($data['sam_array']['metadata']['availability_name']))
                $pdffilename = 'SAM ' . $data['sam_array']['metadata']['availability_name'] . " ";
            else
                $pdffilename = 'SAM ';

            $pdffilename .= date("Y-m-d") . ".pdf";


            ob_start();
            $this->load->view($sam_for_delivery, $data);

            #exit;

            #sleep(2);

            $html = ob_get_contents();
            ob_end_clean();

            //mPDF generates lots of PHP ERR logs, disable the logs here.
            #$errorlevel=error_reporting();
            #error_reporting(0);
            //See class MY_Exceptions
            #$_SESSION['GEN_PHPERR_LOGS'] = false;

            $this->load->library('pdf/pdf_class');
            #$this->pdf_class->SetDisplayMode('fullpage');
            $this->pdf_class->setFooter('{PAGENO} / {nb}');
            #$this->pdf_class->setHeader('|STATEMENT OF ASSESSMENT METHODS – 2016|');
            #$this->pdf_class->SetAutoFont();
            $this->pdf_class->WriteHTML($html,0);

            #sleep(2);
            $this->pdf_class->Output($pdffilename, 'I');

            #error_reporting($errorlevel);
            #$_SESSION['GEN_PHPERR_LOGS'] = true;
        }




    }

    /**
     * Check whether the item has a type of SAM
     *
     * @param xmlwrapper $itemXml
     */
    protected function itemIsSam($itemXml)
    {
        $type = '/xml/item/curriculum/@item_type';
        $itemissam = $itemXml->nodeValue($type);
        $itemissam = 'SAM';
        if(isset($itemissam) && $itemissam == 'SAM')
            return true;
        return false;
    }

    /**
     * Attach SAM PDF to ITEM
     *   More detailed comments in line
     *
     * @param string $uuid, item UUID
     * @param string $version, item Version
     */
    public function generate_pdf($uuid='missed', $version='missed')
    {
      if($this->validate_params('pdf', $uuid, $version) == false)
      {
          log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . 'Invalid input params.');
          exit;
      }

      //$this->load->helper('url');
      //$this->load->library('flexrest/flexrest');
      //$this->load->library('uuid/uuid');

      /*$success = $this->flexrest->processClientCredentialToken();
      if(!$success)
      {
          $errdata['message'] = $this->flexrest->error;
          log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
          exit;
        //  $this->load->view('sam/showerror_view', $errdata);
          //return;
      }*/

      //clean up previou files subtrees

      $success = $this->clean_previous_files($uuid,$version);

      if(!$success)
      {
        log_message('error', 'clean SAMs previous files failed, item uuid: ' . $uuid);
        exit;
      }

      //log_message('error', '~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~');
      //only edit not locked item
      $lock = $this->flexrest->getLock($uuid, $version, $lock_response);
      if($lock)
      {
        log_message('error', 'Generate pdf error: Item locked for editing, item uuid: ' . $uuid);
        exit;
      }

      //lock item for editing
      $new_lock = $this->flexrest->createLock($uuid, $version, $new_lock_response);

      if(!$new_lock)
      {
        log_message('error', 'Generate SAM pdf error: Falied to create lock for item:' . $uuid);
        exit;
      }

      //get lock uuid
      $lock_uuid = $new_lock_response['uuid'];

      $success = $this->flexrest->getItem($uuid, $version, $response);
      if(!$success)
      {
          $errdata['message'] = $this->flexrest->error;
          log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
          exit;
      }

      unset($response['headers']);
      $item_bean = $response;

      $xmlwrapper_name = 'sam_item_'.$uuid . '_' . $version;
      //load xml wrapper from the library
      $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']), $xmlwrapper_name);

    //  $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']));

      $sam_array = $this->samXml2Array($this->$xmlwrapper_name);
      $sam_array['status'] = $response['status'];
      $data = array('sam_array' => $sam_array);
      #$data['sam_array']['avail_ref'] = $avail_ref;
      #$data['sam_array']['avail_ver'] = $avail_ver;
      $data['sam_array']['format'] = 'pdf';
      $data['sam_array']['uuid'] = $uuid; #item uuid
      $data['sam_array']['version'] = $version; #item version number

      /*echo "<br>=====================================";
      echo "<pre>";
      print_r($data);
      echo "</pre>";
      exit;*/

      /* format approval date **/
      $approve_date =  $data['sam_array']['metadata']['approved'];
      $tmp_date =  $data['sam_array']['metadata']['approvalDate'];
      if($approve_date == null)
      {
          #$errdata['message'] = '/xml/item/curriculum/assessment/approval/approved is null';
          log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . 'approved date is null');
          exit;
      }

      $tmp_time = substr($approve_date, strpos($approve_date, 'T')+1, 8);
      $tmp_time = str_replace(':', '-', $tmp_time);
      $tmp_date_time = $tmp_date . 'T' . $tmp_time. '_' . time();
      echo $tmp_date_time.'<br/>';

      ob_start();

      //copy current attachments to filearea and return file area uuid
      $success = $this->flexrest->filesCopy($uuid, $version, $file_copy_response);
      if(!$success)
      {
          $errdata['message'] = $this->flexrest->error;
          log_message('error', 'Attaching SAM pdf failed (filesCopy), item uuid: ' . $uuid . ', error: ' . $errdata['message']);
          exit;
      }
      if(!isset($file_copy_response['headers']['location']))
      {
          $errdata['message'] = 'No Location header in response to copy files REST call.';
          log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
          exit;
      }

      $location = $file_copy_response['headers']['location'];
      $filearea_uuid = substr($location, strpos($location, 'file')+5, 36);
    //  echo 'filearea uuid:' . $filearea_uuid . '<br/>';

      if(!isset($item_bean['attachments']))
          $item_bean['attachments'] = array();

      $existing_attachments = $item_bean['attachments'];
      $new_attachments = array();

      $xpath_files = '/xml/item/curriculum/assessment/SAMs/files';
      $xpath_files_first_file = $xpath_files . '/file[1]/uuid';
      $first_files_uuid = $this->$xmlwrapper_name->nodeValue($xpath_files_first_file);
    //  echo 'first_file_uuid: ' . $first_files_uuid. '<br/>';

      $old_files_exist = $first_files_uuid == null ? false : true;
      $count_old_files = $this->$xmlwrapper_name->numNodes($xpath_files . '/file');
      //echo  'count old files: '. $count_old_files. '<br/>';

      if(!$old_files_exist && $count_old_files > 1)
      {
          $old_files_exist = true;
          //echo 'old_files_exist: ' . $old_files_exist. '<br/>';
      }

      /****************************************************************
       * copy all the <files> to <previous_files>
       ****************************************************************/
       if($old_files_exist) //IF the current SAMs has already had PDF attachments
       {
            //copy all files/file uuids, ref and distributed data to /xml/item/curriculum/assessment/SAMs/previous_files
            $node_files = null;
            $xpath_previous_files = '/xml/item/curriculum/assessment/SAMs/previous_files';

            if(!$this->$xmlwrapper_name->nodeExists($xpath_previous_files)) //xml/item/curriculum/assessment/SAMs/previous_files
            {
              $node_files = $this->$xmlwrapper_name->createNodeFromXPath($xpath_previous_files);
            }
            else
            {
              $node_files = $this->$xmlwrapper_name->node($xpath_previous_files);
            }

            for($i=1; $i<=count($count_old_files); $i++)
            {
              $node_file = $this->$xmlwrapper_name->createNode($node_files, "file");

              $xpath_file_uuid = $xpath_files . '/file['.$i.']/uuid';
              $node_uuid = $this->$xmlwrapper_name->createNode($node_file, "uuid");
              $node_uuid->nodeValue = $this->$xmlwrapper_name->nodeValue($xpath_file_uuid);

              $xpath_file_ref = $xpath_files . '/file['.$i.']/@ref';
              $node_ref = $this->$xmlwrapper_name->createAttribute($node_file, "ref");
              $node_ref->nodeValue = $this->$xmlwrapper_name->nodeValue($xpath_file_ref);

              $xpath_file_dis = $xpath_files . '/file['.$i.']/@distributed';
              $node_distri = $this->$xmlwrapper_name->createAttribute($node_file, "distributed");
              $node_distri->nodeValue = $this->$xmlwrapper_name->nodeValue($xpath_file_dis);
            }
        }

      /****************************************************************
       * create new  <files/file> subtrees
       ****************************************************************/
      $this->$xmlwrapper_name->deleteNodeFromXPath($xpath_files); ///xml/item/curriculum/assessment/SAMs/files
      $node_files = $this->$xmlwrapper_name->createNodeFromXPath($xpath_files);


      $multiple_attachment = null;
      if(count($data['sam_array']['metadata']['availability']) > 1)
      {
        if($data['sam_array']['metadata']['multiple'] == 'yes')
        {
            $multiple_attachment = true;
        }
        else
        {
           $multiple_attachment = false;
        }
      }

      $avail_ref = null;
      $sam_template = null;
      $file_uuid = null;
      $filename = '';

      if(count($data['sam_array']['metadata']['availability']) == 1)
      {
          $file_uuid = $this->uuid->v4(); //generate a new attachment
          $sam_template = 'sam/showsam_view_' . $data['sam_array']['metadata']['availability'][1]['avYear'] . 'p';
          $avail_ref = $data['sam_array']['metadata']['availability'][1]['avRef'];
          $data['sam_array']['avail_ref'] = $avail_ref;
          $data['sam_array']['avail_ver'] = $data['sam_array']['metadata']['availability'][1]['avVersion'];
          //log_message('error', 'generate pdf for item uuid: ' . $uuid . 'avail_ref:'.$avail_ref.' file_uuid:'.  $file_uuid.'<br/>');
          /*** create a new pdf attachment ****/
          ob_start();
          $this->load->view($sam_template, $data);
          $html = ob_get_contents();
          ob_end_clean();
          $pdfclsname = 'pdf_class'.$avail_ref;
          $this->load->library('pdf/pdf_class', null, $pdfclsname);
          $this->$pdfclsname->setFooter('{PAGENO} / {nb}');
          $this->$pdfclsname->WriteHTML($html);

          $filename = $avail_ref . '_' . $tmp_date_time . '.pdf';

          $pdf_content = $this->$pdfclsname->Output($filename, 'S');
          $success = $this->flexrest->fileUpload($filearea_uuid, $filename, $pdf_content, $file_upload_response);

          if(!$success)
          {
              log_message('error', 'Attaching SAM pdf failed (fileUpload), item uuid: ' . $uuid . ', error: ' . $this->flexrest->error);
              exit;
          }

          $new_attachments[0] = array('type'=>'file','filename'=>$filename,'description'=>$filename,'uuid'=>$file_uuid);

          /*** create new file subtree on xml ****/
          $node_file = $this->$xmlwrapper_name->createNode($node_files, "file");
          $node_uuid = $this->$xmlwrapper_name->createNode($node_file, "uuid");
          $node_uuid->nodeValue = $file_uuid;
          $node_ref = $this->$xmlwrapper_name->createAttribute($node_file, "ref");
          $node_ref->nodeValue = $avail_ref;
          $node_distri = $this->$xmlwrapper_name->createAttribute($node_file, "distributed");
          $node_distri->nodeValue = $approve_date;

      }
      elseif(count($data['sam_array']['metadata']['availability']) > 1) //multiple availbilities
      {
        if($data['sam_array']['metadata']['multiple'] == 'yes') //generate one pdf for each avail
        {
          $attachment_count = 0;
          foreach($data['sam_array']['metadata']['availability'] as $avail)
          {
            $file_uuid = $this->uuid->v4(); //generate a new attachment
            $avail_ref = $avail['avRef'];
            $data['sam_array']['avail_ref'] = $avail_ref;
            $data['sam_array']['avail_ver'] = $avail['avVersion'];

            $sam_template = 'sam/showsam_view_' . $avail['avYear'] . 'p';
            //log_message('error', '##'.$attachment_count.'generate pdf for item uuid: ' . $uuid . 'avail_ref:'.$data['sam_array']['avail_ref'].' file_uuid:'.  $file_uuid.'<br/>');
            /*** create a new pdf attachment ****/
            ob_start();
            $this->load->view($sam_template, $data);
            $html = ob_get_contents();
            ob_end_clean();
            $pdfclsname = 'pdf_class'.$avail_ref.$attachment_count;
            $this->load->library('pdf/pdf_class', null, $pdfclsname);
            $this->$pdfclsname->setFooter('{PAGENO} / {nb}');
            $this->$pdfclsname->WriteHTML($html);

            $filename = $avail_ref . '_' . $tmp_date_time . '.pdf';

            $pdf_content = $this->$pdfclsname->Output($filename, 'S');
            $success = $this->flexrest->fileUpload($filearea_uuid, $filename, $pdf_content, $file_upload_response);

            if(!$success)
            {
                log_message('error', 'Attaching SAM pdf failed (fileUpload), item uuid: ' . $uuid . ', error: ' . $this->flexrest->error);
                exit;
            }

            $new_attachments[$attachment_count] = array('type'=>'file','filename'=>$filename,'description'=>$filename,'uuid'=>$file_uuid);

            /*** create new file subtree on xml ****/
            $node_file = $this->$xmlwrapper_name->createNode($node_files, "file");
            $node_uuid = $this->$xmlwrapper_name->createNode($node_file, "uuid");
            $node_uuid->nodeValue = $file_uuid;
            $node_ref = $this->$xmlwrapper_name->createAttribute($node_file, "ref");
            $node_ref->nodeValue = $avail_ref;
            $node_distri = $this->$xmlwrapper_name->createAttribute($node_file, "distributed");
            $node_distri->nodeValue = $approve_date;
            $attachment_count++;

            //echo 'new attachment uuid:' . $file_uuid . '<br/>';
            //echo 'new attachment name:' . $filename . '<br/>';
          }
        }
        elseif ($data['sam_array']['metadata']['multiple'] == '' || $data['sam_array']['metadata']['multiple'] == 'no') //generate combined attachment for multiple avails
        {
            ob_start();
            $file_uuid = $this->uuid->v4(); //generate a new attachment uuid
            $sam_template = 'sam/showsam_view_' . $data['sam_array']['metadata']['availability'][1]['avYear'] . 'p';
            $data['sam_array']['avail_ref'] = $data['sam_array']['metadata']['availability'][1]['avRef'];
            $data['sam_array']['avail_ver'] = $data['sam_array']['metadata']['availability'][1]['avVersion'];
            log_message('error', 'generate pdf for item uuid: ' . $uuid . 'avail_ref:'.$data['sam_array']['avail_ref'].' file_uuid:'.  $file_uuid.'<br/>');

            $this->load->view($sam_template, $data);
            $html = ob_get_contents();
            ob_end_clean();
            $pdfclsname = 'pdf_class'.$avail_ref;
            $this->load->library('pdf/pdf_class', null, $pdfclsname);
            $this->$pdfclsname->setFooter('{PAGENO} / {nb}');
            $this->$pdfclsname->WriteHTML($html);
            $filename = $data['sam_array']['metadata']['availability_name'];
            if(substr($filename, -2) == '. ')
                $filename = substr($filename, 0, strlen($filename)-2);
            if(substr($filename, -1) == '.')
                $filename = substr($filename, 0, strlen($filename)-1);
            $filename = str_replace('.', ' ', $filename);
            $filename = str_replace('(', ' ', $filename);
            $filename = str_replace(')', ' ', $filename);
            $filename = str_replace('/', ' ', $filename);
            $filename = str_replace(',', ' ', $filename);
            $filename = str_replace(':', ' ', $filename);
            $filename = str_replace('[', ' ', $filename);
            $filename = str_replace(']', ' ', $filename);
            $filename = preg_replace('/\s+/', ' ', $filename);
            if(strlen($filename) > 70)
                $filename = substr($filename, 0, 70);
            if(substr($filename, -1) == ' ')
                $filename = substr($filename, 0, strlen($filename)-1);
            $filename = str_replace(' ', '_', $filename);
            $filename = $filename . '_' . $tmp_date_time . '.pdf';

          #echo 'new attachment name:' . $filename . '<br/>';

          $pdf_content = $this->$pdfclsname->Output($filename, 'S');
          $success = $this->flexrest->fileUpload($filearea_uuid, $filename, $pdf_content, $file_upload_response);

          if(!$success)
          {
              log_message('error', 'Attaching SAM pdf failed (fileUpload), item uuid: ' . $uuid . ', error: ' . $this->flexrest->error);
              exit;
          }

          $new_attachments[0] = array('type'=>'file','filename'=>$filename,'description'=>$filename,'uuid'=>$file_uuid);

          /*** create new file subtree on xml ****/
          foreach($data['sam_array']['metadata']['availability'] as $avail)
          {
              $node_file = $this->$xmlwrapper_name->createNode($node_files, "file");
              $node_uuid = $this->$xmlwrapper_name->createNode($node_file, "uuid");
              $node_uuid->nodeValue = $file_uuid;
              $node_ref = $this->$xmlwrapper_name->createAttribute($node_file, "ref");
              $node_ref->nodeValue = $avail['avRef'];
              $node_distri = $this->$xmlwrapper_name->createAttribute($node_file, "distributed");
              $node_distri->nodeValue = $approve_date;
          }
        }
      }

      $item_bean['attachments'] = array_merge($new_attachments, $existing_attachments);
      $item_bean['metadata'] = $this->$xmlwrapper_name->__toString();
      //echo 'edit lock item attachment<br/>';
      $success = $this->flexrest->editLockedItemAttachment($uuid, $version, $item_bean, $lock_uuid, $edit_response, $filearea_uuid);
      //$success = $this->flexrest->editItem($uuid, $version, $item_bean, $edit_response, $filearea_uuid);
      if(!$success)
      {
          log_message('error', 'Attaching SAM pdf failed (editItem), item uuid: ' . $uuid . ', error: ' . $this->flexrest->error);
          exit;
      }

      //echo 'remove lock<br/>';
      $remove_lock = $this->flexrest->deleteLock($uuid, $version, $delete_lock_response);

      if(!$remove_lock)
      {
        log_message('error', 'Generate SAM pdf error: failed to remove lock for item: ' . $uuid);
        exit;
      }

      echo 'pdf upload completed<br/>';
      exit;
  }

    private function clean_previous_files($item_uuid='missed', $item_version='missed')
    {
        //echo 'Start to clean previous files XML .... <br/>';
        /*  $this->load->helper('url');
        $this->load->library('flexrest/flexrest');
        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            log_message('error', 'SAM process client credentail tenken failed, item uuid: ' . $item_uuid . ', error: ' . $this->flexrest->error);
            return false;
        }*/

        //only edit not locked item
        $lock = $this->flexrest->getLock($item_uuid, $item_version, $lock_response);
        if($lock)
        {
          log_message('error', 'Cleaning previous files error: Item locked for editing, item uuid: ' . $item_uuid);
          return false;
        }
        //lock item for editing
        $new_lock = $this->flexrest->createLock($item_uuid, $item_version, $new_lock_response);

        if(!$new_lock)
        {
          log_message('error', 'Cleaning previous files error: Falied to create lock for item:' . $item_uuid);
          return false;
        }
        $lock_uuid = $new_lock_response['uuid'];

        $success = $this->flexrest->getItem($item_uuid, $item_version, $response);

        if(!$success) // getItem
        {
            log_message('error', 'Getting SAM failed, item uuid: ' . $item_uuid . ', error: ' . $this->flexrest->error);
            return false;
        }

        unset($response['headers']);
        $item_bean = $response;
        /*echo '<pre>';
        print_r($item_bean);
        echo '</pre>';*/

        //IMPORTANT: each xml item needs to be assigned a unique xml wrapper name
        $xmlwrapper_name = 'sam' . $item_uuid . '_' . $item_version;
        //load xml wrapper from the library
        $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']), $xmlwrapper_name);

        $xpath_previous_files = '/xml/item/curriculum/assessment/SAMs/previous_files';
        $xpath_previous_files_first_file = $xpath_previous_files . '/file[1]/uuid';
        $first_previous_files_uuid = $this->$xmlwrapper_name->nodeValue($xpath_previous_files_first_file);

        $previous_files_exist = $first_previous_files_uuid == null ? false : true;
        $count_previous_files = $this->$xmlwrapper_name->numNodes($xpath_previous_files . '/file');

        if(!$previous_files_exist && $count_previous_files > 1)
        {
          $previous_files_exist = true;
        }

        if($previous_files_exist)
        {
            $change_made = false; //variable to store if any previous file has been changed

            //get filearea_uuid
            $s = $this->flexrest->filesCopy($item_uuid, $item_version, $r);
            if(!$s)
            {
                log_message('error', 'Clean SAM previous files failed (filesCopy), item uuid: ' . $item_uuid . ', error: ' . $this->flexrest->error);
                return false;
            }

            if(!isset($r['headers']['location']))
            {
                log_message('error', 'Clean SAM previous files failed (filesCopy_no location), item uuid: ' . $item_uuid . ', error: ' . 'No Location header in response to copy files REST call.');
                return false;
            }

            $location = $r['headers']['location'];
            $filearea_uuid = substr($location, strpos($location, 'file')+5, 36);

            //get all attachments
            $existing_attachments = $item_bean['attachments'];
            /*echo 'attachments: <pre>';
            print_r($existing_attachments);
            echo '</pre>';*/
            //store all previous_files parameters in an array: uuid, ref, distributed date
            $previous_files_array = array();
            for ($o = 1; $o <= $count_previous_files; $o++)
            {
               $previous_file_uuid_xpath = $xpath_previous_files. '/file['.$o.']/uuid';
               $previous_file_ref_xpath = $xpath_previous_files. '/file['.$o.']/@ref';
               $previous_file_distributed_xpath = $xpath_previous_files. '/file['.$o.']/@distributed';
               $previous_files_array[$o-1]['uuid'] = $this->$xmlwrapper_name->nodeValue($previous_file_uuid_xpath);
               $previous_files_array[$o-1]['ref'] = $this->$xmlwrapper_name->nodeValue($previous_file_ref_xpath);
               $previous_files_array[$o-1]['distributed'] = $this->$xmlwrapper_name->nodeValue($previous_file_distributed_xpath);
            }


            $current_files_array = array();
            $xpath_files = '/xml/item/curriculum/assessment/SAMs/files';
            $count_current_files = $this->$xmlwrapper_name->numNodes($xpath_files . '/file');
            for($i=1; $i <= $count_current_files; $i++)
            {
                $current_file_uuid = $xpath_files. '/file['.$i.']/uuid';
                $current_files_array[$i-1]['uuid'] = $this->$xmlwrapper_name->nodeValue($current_file_uuid);
                $current_file_ref = $xpath_files. '/file['.$i.']/@ref';
                $current_files_array[$i-1]['ref'] = $this->$xmlwrapper_name->nodeValue($current_file_ref);
                $current_file_distributed = $xpath_files. '/file['.$i.']/@distributed';
                $current_files_array[$i-1]['distributed'] = $this->$xmlwrapper_name->nodeValue($current_file_distributed);
            }

          /*  echo 'Current SAMs files array: <pre>';
            print_r($current_files_array);
            echo '</pre>';
            echo 'Previous SAMs files array: <pre>';
            print_r($previous_files_array);
            echo '</pre>';*/

            $count = count($previous_files_array);
            $temp_array = array();
            $temp_uuid_array = array();
            while($count > 0)
            {
                //echo '~~~~~~~~~~~~~~~~~~~~~~current previous file uuid:' . $previous_files_array[$count-1]['uuid'].'<br/>';
                if($previous_files_array[$count-1]['uuid'] != '' && !in_array($previous_files_array[$count-1]['uuid'],$temp_uuid_array))
                {
                    #echo 'previou_file_uuid:'.$previous_files_array[$count-1]['uuid'].'<br/>';
                    $uuid_duplicate = false;
                    foreach($current_files_array as $current_file)
                    {
                      //echo '#########################################current file uuid:' . $current_file['uuid'].'<br/>';
                      if($current_file['uuid'] == $previous_files_array[$count-1]['uuid'])
                      {
                          $uuid_duplicate = true;
                          //echo 'This previous file uuid duplicated with current file uuid. this uuid will be removed from the previous files xml.<br/>';
                          break;
                      }
                    }

                  //search in attachments see if the file uuid exits
                  if(!$uuid_duplicate)
                  {
                      $attachment_exists = false;
                      foreach($existing_attachments as $attachment)
                      {
                          $attachment_uuid = $attachment['uuid'];
                          //echo 'attachment_uuid:'.$attachment_uuid.'<br/>';

                          if($previous_files_array[$count-1]['uuid'] == $attachment_uuid)
                          {
                            array_push($temp_uuid_array, $previous_files_array[$count-1]['uuid']);
                            $temp_array[] = $previous_files_array[$count-1];
                            $attachment_exists = true;
                            break;
                          }
                      }
                      /* if(!$attachment_exists)
                      {
                          echo 'This previous file uuid is not found from the attachment list. It will be removed from the previous files xml.<br/>';
                      }*/
                  }
                }
                $count--;
            }

            /*foreach($current_files_array as $current_file)
            {
              $temp_array[] = $current_file;
              array_push($temp_uuid_array, $current_file['uuid']);

            }*/

          /*  echo 'New previous files array<pre>';
            print_r($temp_array);
            echo '</pre>';
            echo 'temp uuid files array<pre>';
            print_r($temp_uuid_array);
            echo '</pre>';*/


            if(count($temp_uuid_array)>0)
            {
                //$xpath_previous_files
                $this->$xmlwrapper_name->deleteNodeFromXPath($xpath_previous_files);
                $node_files = $this->$xmlwrapper_name->createNodeFromXPath($xpath_previous_files);
                foreach($temp_array as $file_item)
                {
                  $node_file = $this->$xmlwrapper_name->createNode($node_files, "file");
                  $node_uuid = $this->$xmlwrapper_name->createNode($node_file, "uuid");
                  $node_uuid->nodeValue = $file_item['uuid'];
                  $node_ref = $this->$xmlwrapper_name->createAttribute($node_file, "ref");
                  $node_ref->nodeValue = $file_item['ref'];
                  $node_distri = $this->$xmlwrapper_name->createAttribute($node_file, "distributed");
                  $node_distri->nodeValue = $file_item['distributed'];
                }


                $item_bean['metadata'] = $this->$xmlwrapper_name->__toString();

                //$success = $this->flexrest->editItem($item_uuid, $item_version, $item_bean, $edit_response, $filearea_uuid);
                $success = $this->flexrest->editLockedItemAttachment($item_uuid, $item_version, $item_bean, $lock_uuid, $edit_response, $filearea_uuid);
                if(!$success)
                {
                  log_message('error', 'Clean SAM previous files failed (edit item), item uuid: ' . $item_uuid . ', error: ' . 'No Location header in response to copy files REST call.');
                  return false;
                }
            }
            elseif (count($previous_files_array) > 0)
            {
                $this->$xmlwrapper_name->deleteNodeFromXPath($xpath_previous_files);
                $item_bean['metadata'] = $this->$xmlwrapper_name->__toString();
                //$success = $this->flexrest->editItem($item_uuid, $item_version, $item_bean, $edit_response, $filearea_uuid);
                $success = $this->flexrest->editLockedItemAttachment($item_uuid, $item_version, $item_bean, $lock_uuid, $edit_response, $filearea_uuid);

                if(!$success)
                {
                  log_message('error', 'Clean SAM previous files failed (edit item), item uuid: ' . $item_uuid . ', error: ' . 'No Location header in response to copy files REST call.');
                  return false;
                }
            }
        }

        //remove lock from item
        $remove_lock = $this->flexrest->deleteLock($item_uuid, $item_version, $delete_lock_response);
        if(!$remove_lock)
        {
          log_message('error', 'Cleaning previous files error: falsed to remove lock for item: ' . $item_uuid);
          return false;
        }
        //echo 'END clean previous files XML .... <br/>';
        return true;
    }

    /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function samXml2Array($itemXml)
    {

        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/topics/topic'); $j++)
        {
            $topicCode = '/xml/item/curriculum/topics/topic['.$j.']/code';
            $topicTitle = '/xml/item/curriculum/topics/topic['.$j.']/name';
            $topicUnits = '/xml/item/curriculum/topics/topic['.$j.']/units';
            $topicSchool = '/xml/item/curriculum/topics/topic['.$j.']/school';
            $work_load = '/xml/item/curriculum/topics/topic['.$j.']/workload';

            $samsArray['metadata']['topics'][$j]['tcode'] = $itemXml->nodeValue($topicCode);
            $samsArray['metadata']['topics'][$j]['topicTitle'] = $itemXml->nodeValue($topicTitle);
            $samsArray['metadata']['topics'][$j]['topicUnits'] = $itemXml->nodeValue($topicUnits);
            $samsArray['metadata']['topics'][$j]['topicSchool'] = trim($itemXml->nodeValue($topicSchool));
            $samsArray['metadata']['topics'][$j]['work_load'] = $itemXml->nodeValue($work_load);
        }
        #$topicLocation = '/xml/item/curriculum/avails/avail/location_code';
        $version_definition = '/xml/item/curriculum/assessment/SAMs/version_definition';
        $approval = '/xml/item/curriculum/assessment/SAMs/distributed';
        $grad_quals = '/xml/item/curriculum/topics/topic/ugrad';

        $assess_workload = '/xml/item/curriculum/assessment/workload';
        $assess_workload_hour = '/xml/item/curriculum/assessment/workload/hour';
        $assess_workload_unit = '/xml/item/curriculum/assessment/workload/unit';

        $approved = '/xml/item/curriculum/assessment/approval/approved'; #boolean yes/no
        $approvalDate = '/xml/item/curriculum/assessment/approval/date';
        $approvalPerson = '/xml/item/curriculum/assessment/approval/name_display';
        $approvalFan = '/xml/item/curriculum/assessment/approval/fan';

        $attachment_uuid = '/xml/item/curriculum/assessment/approval/signature_file';
        $availability_name = '/xml/item/itembody/name';

        $samsArray['metadata']['approval'] = $itemXml->nodeValue($approval);
        $samsArray['metadata']['grad_quals'] = $itemXml->nodeValue($grad_quals);


        $samsArray['metadata']['assess_workload'] = $itemXml->nodeValue($assess_workload);
        $samsArray['metadata']['assess_workload_hour'] = $itemXml->nodeValue($assess_workload_hour);
        $samsArray['metadata']['assess_workload_unit'] = $itemXml->nodeValue($assess_workload_unit);

        #$samsArray['metadata']['work_load'] = $itemXml->nodeValue($work_load);
        $samsArray['metadata']['approvalDate'] = $itemXml->nodeValue($approvalDate);
        $samsArray['metadata']['approvalPerson'] = $itemXml->nodeValue($approvalPerson);
        $samsArray['metadata']['approvalFan'] = $itemXml->nodeValue($approvalFan);
        $samsArray['metadata']['approved'] = $itemXml->nodeValue($approved);

        $samsArray['metadata']['availability_name'] = $itemXml->nodeValue($availability_name);
        $samsArray['metadata']['attachment_uuid'] = $itemXml->nodeValue($attachment_uuid);
        #log_message('error', 'attachment_uuid: '.$samsArray['metadata']['attachment_uuid']);
        $samsArray['metadata']['version_definition'] = $itemXml->nodeValue($version_definition);
        // get availabilities information

        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/avails/avail'); $j++)
        {
            $avYear = '/xml/item/curriculum/avails/avail['.$j.']/year';
            $avDuration = '/xml/item/curriculum/avails/avail['.$j.']/period_display';
            $avDuration_code = '/xml/item/curriculum/avails/avail['.$j.']/period_code';
            $avLocation = '/xml/item/curriculum/avails/avail['.$j.']/location_display';
            $avLocation_code = '/xml/item/curriculum/avails/avail['.$j.']/location_code';
            $av_version = '/xml/item/curriculum/avails/avail['.$j.']/version';
            $av_ref = '/xml/item/curriculum/avails/avail['.$j.']/@avail_ref';
            $av_topic_code = '/xml/item/curriculum/avails/avail['.$j.']/topic_code';
            $av_topic_name = '/xml/item/curriculum/avails/avail['.$j.']/topic_name';
            $samsArray['metadata']['availability'][$j]['avYear'] = $itemXml->nodeValue($avYear);
            $samsArray['metadata']['availability'][$j]['avDuration'] = $itemXml->nodeValue($avDuration);
            $samsArray['metadata']['availability'][$j]['avDuration_code'] = $itemXml->nodeValue($avDuration_code);
            $samsArray['metadata']['availability'][$j]['avLocation'] = $itemXml->nodeValue($avLocation);
            $samsArray['metadata']['availability'][$j]['avLocation_code'] = $itemXml->nodeValue($avLocation_code);
            $samsArray['metadata']['availability'][$j]['avVersion'] = $itemXml->nodeValue($av_version);
            $samsArray['metadata']['availability'][$j]['avRef'] = $itemXml->nodeValue($av_ref);
            $samsArray['metadata']['availability'][$j]['topic_code'] = $itemXml->nodeValue($av_topic_code);
            $samsArray['metadata']['availability'][$j]['topic_name'] = $itemXml->nodeValue($av_topic_name);
        }

        //get course coordinators
        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/people/coords/coord'); $j++)
        {
            $coord_type = '/xml/item/curriculum/people/coords/coord['.$j.']/@type';
            $coord_fan = '/xml/item/curriculum/people/coords/coord['.$j.']/fan';
            $coord_name = '/xml/item/curriculum/people/coords/coord['.$j.']/name';
            $coord_name_display = '/xml/item/curriculum/people/coords/coord['.$j.']/name_display';
            $coord_phone = '/xml/item/curriculum/people/coords/coord['.$j.']/phone';
            $coord_location = '/xml/item/curriculum/people/coords/coord['.$j.']/location';

            $samsArray['metadata']['coordinators'][$j]['coord_type'] = $itemXml->nodeValue($coord_type);
            $samsArray['metadata']['coordinators'][$j]['coord_fan'] = $itemXml->nodeValue($coord_fan);
            $samsArray['metadata']['coordinators'][$j]['coord_name'] = $itemXml->nodeValue($coord_name);
            $samsArray['metadata']['coordinators'][$j]['coord_name_display'] = $itemXml->nodeValue($coord_name_display);
            $samsArray['metadata']['coordinators'][$j]['coord_phone'] = $itemXml->nodeValue($coord_phone);
            $samsArray['metadata']['coordinators'][$j]['coord_location'] = $itemXml->nodeValue($coord_location);
        }


        // Alignment: topic outcomes
        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo'); $j++)
        {
            $name = '/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/name';
            $code = '/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/code';
            $level = '/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/level';

            $samsArray['metadata']['topicalign'][$j]['name'] = $itemXml->nodeValue($name);
            $samsArray['metadata']['topicalign'][$j]['code'] = $itemXml->nodeValue($code);
            $samsArray['metadata']['topicalign'][$j]['level'] = $itemXml->nodeValue($level);

            for ($k = 1; $k <= $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/aligned/a_items/a_item'); $k++)
            {
                $assessment = '/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/aligned/a_items/a_item['.$k.']/name';
                $assessment_id = '/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/aligned/a_items/a_item['.$k.']/@sys_id';
                //$samsArray['metadata']['topicalign'][$j]['assessment'][$k] ='text';
                //$samsArray['metadata']['topicalign'][$j]['assessment'][$k] = $itemXml->nodeValue($assessment);
                $samsArray['metadata']['topicalign'][$j]['assessment'][$k] = $itemXml->nodeValue($assessment_id);
            }
            //$samsArray['metadata']['topicalign'][$j]['numItems'] = [$k];
        }
        // graduate qualities
        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/outcomes/grad_quals/los/lo'); $j++)
        {
            $name = '/xml/item/curriculum/outcomes/grad_quals/los/lo['.$j.']/name';
            $code = '/xml/item/curriculum/outcomes/grad_quals/los/lo['.$j.']/code';
            $samsArray['metadata']['gradattribute'][$j]['name'] = $itemXml->nodeValue($name);
            $samsArray['metadata']['gradattribute'][$j]['code'] = $itemXml->nodeValue($code);
            for ($k = 1; $k <= $itemXml->numNodes('/xml/item/curriculum/outcomes/grad_quals/los/lo['.$j.']/aligned/a_items/a_item'); $k++) {
                //$assessment = '/xml/item/uni/course/grad_attributes/grad_attribute['.$j.']/assessments/assessment['.$k.']/name';
                $assessment_id = '/xml/item/curriculum/outcomes/grad_quals/los/lo['.$j.']/aligned/a_items/a_item['.$k.']/@sys_id';
                //$samsArray['metadata']['topicalign'][$j]['assessment'][$k] ='text';
                $samsArray['metadata']['gradattribute'][$j]['assessment'][$k] = $itemXml->nodeValue($assessment_id);
            }
            //$samsArray['metadata']['topicalign'][$j]['numItems'] = [$k];
        }
        // topic alignment
        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/assessment/a_items/a_item'); $j++)
        {
            $name = '/xml/item/curriculum/assessment/a_items/a_item['.$j.']/name';
            $format = '/xml/item/curriculum/assessment/a_items/a_item['.$j.']/format';
            $proportion = '/xml/item/curriculum/assessment/a_items/a_item['.$j.']/proportion';
            $deadline = '/xml/item/curriculum/assessment/a_items/a_item['.$j.']/deadline';
            $penalties = '/xml/item/curriculum/assessment/a_items/a_item['.$j.']/penalties';
            $return = '/xml/item/curriculum/assessment/a_items/a_item['.$j.']/return_date';
            $id = '/xml/item/curriculum/assessment/a_items/a_item['.$j.']/@sys_id';
            $samsArray['metadata']['assessment'][$j]['name'] = $itemXml->nodeValue($name);
            $samsArray['metadata']['assessment'][$j]['format'] = $itemXml->nodeValue($format);
            $samsArray['metadata']['assessment'][$j]['proportion'] = $itemXml->nodeValue($proportion);
            $samsArray['metadata']['assessment'][$j]['deadline'] = $itemXml->nodeValue($deadline);
            $samsArray['metadata']['assessment'][$j]['penalties'] = $itemXml->nodeValue($penalties);
            $samsArray['metadata']['assessment'][$j]['return'] = $itemXml->nodeValue($return);
            $samsArray['metadata']['assessment'][$j]['id'] = $itemXml->nodeValue($id);

        }

        $multiple = '/xml/item/curriculum/assessment/SAMs/multiple';
        $scaling = '/xml/item/curriculum/assessment/scaling/used';
        $scalingDetail = '/xml/item/curriculum/assessment/scaling/detail';
        $resubmissionPermitted = '/xml/item/curriculum/assessment/resubmit/permitted';
        $resubmissionDetail = '/xml/item/curriculum/assessment/resubmit/conditions';
        $academicIntegrity = '/xml/item/curriculum/assessment/text_matching/used';
        $exemptions = '/xml/item/curriculum/assessment/text_matching/exemptions';
        $exemption_details = '/xml/item/curriculum/assessment/text_matching/exemption_details';
        $pass = '/xml/item/curriculum/assessment/pass';
        $consideration = '/xml/item/curriculum/assessment/special/contact';
        $samsArray['metadata']['multiple'] = $itemXml->nodeValue($multiple);
        $samsArray['metadata']['pass'] = $itemXml->nodeValue($pass);
        $samsArray['metadata']['consideration'] = $itemXml->nodeValue($consideration);
        $samsArray['metadata']['scaling'] = $itemXml->nodeValue($scaling);
        $samsArray['metadata']['scalingDetail'] = $itemXml->nodeValue($scalingDetail);
        $samsArray['metadata']['resubmissionPermitted'] = $itemXml->nodeValue($resubmissionPermitted);

        if(strnatcasecmp($samsArray['metadata']['resubmissionPermitted'], 'Yes') == 0)
            $samsArray['metadata']['resubmissionDetail'] = $itemXml->nodeValue($resubmissionDetail);
        else
            $samsArray['metadata']['resubmissionDetail'] = '';
        $samsArray['metadata']['academicIntegrity'] = $itemXml->nodeValue($academicIntegrity);

        $samsArray['metadata']['exemptions'] = $itemXml->nodeValue($exemptions);
        if(strnatcasecmp($samsArray['metadata']['exemptions'], 'Yes') == 0)
        {
            $samsArray['metadata']['exemption_details'] = $itemXml->nodeValue($exemption_details);
        }
        else
        {
            $samsArray['metadata']['exemption_details'] = '';
        }
        return $samsArray;
    }

    /**
     * Validate incoming parameters
     *
     * @param string $format, html/pdf
     * @param array $uuid, item UUID
     * @param array $version, item Version
     */
    protected function validate_params($format, $uuid, $version)
    {
        if($format!='html' && $format!='pdf')
            return false;
        if(strcmp($uuid, 'missed')==0 || strlen($uuid) != 36)
            return false;

        if(strcmp($version, 'missed')==0 || !is_numeric($version))
            return false;

        return true;
    }

    /**
    Generates a token that is valid for 30 minutes.  This should be appended to URLs so that users are not forced to log in to view content.
    E.g.
    $itemURL = "http://MYSERVER/myinst/items/619722b1-22f8-391a-2bcf-46cfaab36265/1/?token=" . generateToken("fred.smith", "IntegSecret", "squirrel");

    In the example above, if fred.smith is a valid username on the EQUELLA server he will be automatically logged into the system so that he can view
    item 619722b1-22f8-391a-2bcf-46cfaab36265/1 (provided he has the permissions to do so).

    Note that to use this functionality, the Shared Secrets user management plugin must be enabled (see User Management in the EQUELLA Administration Console)
    and a shared secret must be configured.

    @param username :The username of the user to log in as
    @param sharedSecretId :The ID of the shared secret
    @param sharedSecretValue :The value of the shared secret
    @return : A token that can be directly appended to a URL (i.e. it is already URL encoded)   E.g.  $URL = $URL . "?token=" . generateToken(x,y,z);
     */
    private function generateToken()
    {
        $ci =& get_instance();
        $ci->load->config('flex');
        $username = $ci->config->item('sam_shared_secret_username');
        $sharedSecretId = $ci->config->item('sam_shared_secret_id');
        $sharedSecretValue = $ci->config->item('sam_shared_secret_value');

        $time = mktime() . '000';
        /*return urlencode ($username) . ':' . urlencode($sharedSecretId) . ':' .  $time . ':' .
                        urlencode(base64_encode (pack ('H*', md5 ($username . $sharedSecretId . $time . $sharedSecretValue))));*/
        return urlencode($username) . ':' . urlencode($sharedSecretId) . ':' .  $time . ':' .
            urlencode(base64_encode (pack ('H*', md5 ($username . $sharedSecretId . $time . $sharedSecretValue))));

    }


        /**
     * Attach SAM PDF to ITEM
     *   More detailed comments in line
     *
     * @param string $uuid, item UUID
     * @param string $version, item Version
     */
    public function attach_pdf_lx9n3h2($uuid='missed', $version='missed')
    {
        #$this->output->enable_profiler(TRUE);
        $errdata['heading'] = "Error";

        if($this->validate_params('pdf', $uuid, $version) == false)
        {
            $errdata['message'] = "Invalid Request";
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . 'Invalid input params.');
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');

        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }

        #ob_end_flush();
        #log_message('error', 'ob_get_level ():');
        #log_message('error', ob_get_level ());
        #ob_start();
        #echo 'good';
        /****************************************************************
         * Important: Respond to Equella so that its workflow can finish
         * Otherwise the editItem will fail.
         *
         * Script goes on after flushing to equella.
         ****************************************************************/

        // Ignore connection-closing by the client/user
        ignore_user_abort(true);
        // Set your timelimit to a length long enough for your script to run,
        // but not so long it will bog down your server in case multiple versions run
        // or this script get's in an endless loop.
        $content = 'good';         // Get the content of the output buffer
        ob_end_clean();                     // Close current output buffer
        $len = strlen($content);
        header('Content-Type: text/html; charset=UTF-8');
        header('Content-Encoding: none;');
        header('Connection: close');         // Tell the client to close connection
        header("Content-Length: $len");      // Close connection after $size characters
        #echo $content;                       // Output content
        ob_flush();
        flush();                             // Force php-output-cache to flush to flex.

        ob_end_flush();

        #exit;

        // Optional: kill all other output buffering
        #while (ob_get_level() > 0) {
        #    ob_end_clean();
        #}

        #make sure sam work flow completely finishes
        sleep (5);


        $success = $this->flexrest->getItem($uuid, $version, $response);


        /*  --------------------------
        echo "<pre>";
        echo "<h3>getItem Response</h3>";
        print_r($response);
        echo "</pre>";

        */





        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }

        unset($response['headers']);
        $item_bean = $response;

        /*  --------------------------
        echo "<pre>";
        echo "<h3>Item Bean</h3>";
        print_r($response);
        echo "</pre>";

        */




        $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']));

        if(!$this->itemIsSam($this->xmlwrapper))
        {
            $errdata['message'] = "Item is not SAM";
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }

        /*  --------------------------
        echo "<pre>";
        echo "Item is SAM<br />";
        #print_r($response);
        echo "</pre>";

        */

        $sam_array = $this->samXml2Array($this->xmlwrapper);

        /*  --------------------------
        echo "<pre>";
        echo "<h3>SAM Array</h3>";
        print_r($sam_array);
        echo "</pre>";

        */



        $sam_array['status'] = $response['status'];
        $data = array('sam_array' => $sam_array);

        /*  --------------------------
        echo "<pre>";
        echo "<h3>Data</h3>";
        print_r($data);
        echo "</pre>";

        */



        #$data['sam_array']['avail_ref'] = $avail_ref;
        #$data['sam_array']['avail_ver'] = $avail_ver;
        $data['sam_array']['format'] = 'pdf';
        $data['sam_array']['uuid'] = $uuid; #item uuid
        $data['sam_array']['version'] = $version; #item version number

        $approve_date =  $data['sam_array']['metadata']['approved'];


        /*  --------------------------
        echo "<pre>";
        echo "<h3>Var approve_date</h3>";
        echo $approve_date . "<br />";
        echo "</pre>";
         */



        $tmp_date =  $data['sam_array']['metadata']['approvalDate'];
        if($approve_date == null)
        {
            #$errdata['message'] = '/xml/item/curriculum/assessment/approval/approved is null';
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . 'approved date is null');
            #$this->load->view('sam/showerror_view', $errdata);
            return;
        }
        $tmp_time = substr($approve_date, strpos($approve_date, 'T')+1, 8);
        $tmp_time = str_replace(':', '-', $tmp_time);
        $tmp_date_time = $tmp_date . 'T' . $tmp_time;

        /*  --------------------------
        echo "<pre>";
        echo "<h3>Var tmp_date_time</h3>";
        echo $tmp_date . "<br />";
        echo "</pre>";

        */




        #log_message('error', 'ob_get_level ():');
        #log_message('error', ob_get_level ());
        ob_start();
        #log_message('error', 'ob_get_level ():');
        #log_message('error', ob_get_level ());

        $success = $this->flexrest->filesCopy($uuid, $version, $response1);


        /*  --------------------------
        echo "<pre>";
        echo "<h3>filesCopy Response</h3>";
        print_r($response1);
        echo "</pre>";


        #exit;

        */



        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed (filesCopy), item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        if(!isset($response1['headers']['location']))
        {
            $errdata['message'] = 'No Location header in response to copy files REST call.';
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        $location = $response1['headers']['location'];
        $filearea_uuid = substr($location, strpos($location, 'file')+5, 36);

        /***************************************************************
         * Check whther there are exiting files, if yes, move them to
         * previous_files and change uuid.
         *
         * <files>
         *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4730C_2014_S2">
         *        <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc000</uuid>
         *    </file>
         * </files>
         *
         * <previous_files>
         *    <file distributed="2014-08-28T14:34:18+09:30" ref="COMP4730C_2014_S2">
         *        <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc100</uuid>
         *    </file>
         * </previous_files>
         ****************************************************************/

        /***************************************************************
         * Muiltiple files for each availability
         *
         * <files>
         *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4730C_2014_S2">
         *        <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc000</uuid>
         *    </file>
         *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4730D_2014_S2">
         *        <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc001</uuid>
         *    </file>
         * </files>
         *
         * Single file for all availabilities
         * <files>
         *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4730C_2014_S2">
         *        <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc000</uuid>
         *    </file>
         *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4730D_2014_S2">
         *        <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc000</uuid>
         *    </file>
         * </files>
         ****************************************************************/

        if(!isset($item_bean['attachments']))
            $item_bean['attachments'] = array();
        #$attachment_count = count($item_bean['attachments']);
        $existing_attachments = $item_bean['attachments'];
        $new_attachments = array();

        $xpath_files = '/xml/item/curriculum/assessment/SAMs/files';

        $node_previous_files = null;
        $xpath_previous_files = '/xml/item/curriculum/assessment/SAMs/previous_files';
        $xpath_files_first_file = $xpath_files . '/file[1]/uuid';

        $xpath_previous_files_first_file = $xpath_previous_files . '/file[1]/uuid';
        $first_files_uuid = $this->xmlwrapper->nodeValue($xpath_files_first_file);
        $first_previous_files_uuid = $this->xmlwrapper->nodeValue($xpath_previous_files_first_file);

        $old_files_exist = $first_files_uuid == null ? false : true;
        $previous_files_exist = $first_previous_files_uuid == null ? false : true;

        $count_old_files = $this->xmlwrapper->numNodes($xpath_files . '/file');
        $count_previous_files = $this->xmlwrapper->numNodes($xpath_previous_files . '/file');
        #echo $old_files_exist . ' dd '; echo $count_old_files; exit();

        $old_file_array = array();
        $previous_file_uuid_suffix = 200;
        $next_previous_file_uuid = '';
        $old_one_file_multi_avails = false;
        $old_avails = array();

        /****************************************************************
         * copy all the <files> to <previous_files>
         ****************************************************************/
        ####

        /*log_message('error', 'Attaching SAM pdf, count_old_files: '.$count_old_files);
        if($old_files_exist == true)
            log_message('error', 'Attaching SAM pdf, old_files_exist: true ');
        else
            log_message('error', 'Attaching SAM pdf, old_files_exist: false ');*/

        /*if($count_old_files > 0 && $old_files_exist == false)
        {
            log_message('error', 'Attaching SAM pdf, $count_old_files > 0 && $old_files_exist == false, item uuid: ' . $uuid);
            exit();
        }*/

        #if($old_files_exist)
        if($count_old_files > 0)
        {
            $node_previous_files = $this->xmlwrapper->createNodeFromXPath($xpath_previous_files);
            #if($previous_files_exist)
            if($count_previous_files > 0)
                $previous_file_uuid_suffix += $count_previous_files;

            $next_previous_file_uuid = substr($uuid, 0, 33) . sprintf("%03d", $previous_file_uuid_suffix);
            #echo $next_previous_file_uuid; exit();

            for ($j = 1; $j <= $count_old_files; $j++)
            {
                $tmp_xpath_file_uuid = $xpath_files . '/file['.$j.']/uuid';
                $tmp_xpath_file_ref = $xpath_files . '/file['.$j.']/@ref';
                $tmp_xpath_file_distributed = $xpath_files . '/file['.$j.']/@distributed';

                $tmp_file_uuid = $this->xmlwrapper->nodeValue($tmp_xpath_file_uuid);
                $tmp_file_ref = $this->xmlwrapper->nodeValue($tmp_xpath_file_ref);
                $tmp_file_distributed = $this->xmlwrapper->nodeValue($tmp_xpath_file_distributed);

                $old_file_array[$j-1]['uuid'] = $tmp_file_uuid;
                $old_file_array[$j-1]['ref'] = $tmp_file_ref;
                $old_file_array[$j-1]['dist'] = $tmp_file_distributed;

                $old_avails[$j-1] = $tmp_file_ref;
            }

            if($count_old_files > 1 &&
                $old_file_array[0]['uuid'] == $old_file_array[1]['uuid'] &&
                $old_file_array[0]['uuid'] == $old_file_array[$count_old_files-1]['uuid'])
                $old_one_file_multi_avails = true;
            else
                $old_one_file_multi_avails = false;

            #Append the files to previous_files subtree, change uuid
            for ($j = 0; $j < $count_old_files; $j++)
            {
                $tmp_node_previous_file = $this->xmlwrapper->createNode($node_previous_files, "file");
                $tmp_node_previous_file_uuid = $this->xmlwrapper->createNode($tmp_node_previous_file, "uuid");
                $tmp_node_previous_file_ref = $this->xmlwrapper->createAttribute($tmp_node_previous_file, "ref");
                $tmp_node_previous_file_distri = $this->xmlwrapper->createAttribute($tmp_node_previous_file, "distributed");

                $tmp_node_previous_file_ref->nodeValue = $old_file_array[$j]['ref'];
                $tmp_node_previous_file_distri->nodeValue = $old_file_array[$j]['dist'];

                $tmp_node_previous_file_uuid->nodeValue = $next_previous_file_uuid;
                for($i=0; $i<count($existing_attachments); $i++)
                {
                    if($existing_attachments[$i]['uuid'] == $old_file_array[$j]['uuid'])
                        $existing_attachments[$i]['uuid'] = $next_previous_file_uuid;
                }
                if($count_old_files>1 && $old_one_file_multi_avails == false)
                {
                    $previous_file_uuid_suffix ++;
                    $next_previous_file_uuid = substr($uuid, 0, 33) . sprintf("%03d", $previous_file_uuid_suffix);
                }
            }
        }

        #print_r(simplexml_import_dom($node_previous_files)->asXML());exit();


        $this->xmlwrapper->deleteNodeFromXPath($xpath_files);
        $node_files = $this->xmlwrapper->createNodeFromXPath($xpath_files);
        #$distributed = $approve_date; #new DateTime("now");
        #$approve_time = $distributed->format('c');
        #$item_bean['attachments'] = null;
        $file_uuid = $uuid;
        $largest_suffix_number = 0;

        #find out the largest suffix number in uuid (last three chars)
        for ($j = 0; $j < $count_old_files; $j++)
        {
            $file_suffix_number = intval(substr($old_file_array[$j]['uuid'], 33, 3));
            if($file_suffix_number > $largest_suffix_number)
                $largest_suffix_number = $file_suffix_number;
        }

        $new_one_file_multi_avails = false;
        $new_avails = array();
        $i = 0;
        foreach ($data['sam_array']['metadata']['availability'] as $availdata  )
        {
            $new_avails[$i] = $availdata['avRef'];
            $i ++;
        }
        if($data['sam_array']['metadata']['multiple'] != 'yes' && count($new_avails) > 1)
            $new_one_file_multi_avails = true;

        $attachment_count = 0;
        foreach ($data['sam_array']['metadata']['availability'] as $availdata  )
        {
            $data['sam_array']['avail_ref'] = $availdata['avRef'];
            $data['sam_array']['avail_ver'] = $availdata['avVersion'];
            $data['sam_array']['avail_year'] = $availdata['avYear'];

            /*
             *
             * Dynamically set the view to display the correct SAM template for the designated year
             *
             *
             */
            $sam_for_delivery = 'sam/showsam_view_' . $data['sam_array']['avail_year'] . 'p';


            if($data['sam_array']['metadata']['multiple'] == 'yes' || $attachment_count == 0)
            {
                ob_start();
                $this->load->view($sam_for_delivery, $data);
                $html = ob_get_contents();
                ob_end_clean();
                $pdfclsname = 'pdf_class'.$attachment_count;
                $this->load->library('pdf/pdf_class', null, $pdfclsname);
                #$this->pdf_class->SetDisplayMode('fullpage');
                $this->$pdfclsname->setFooter('{PAGENO} / {nb}');
                $this->$pdfclsname->WriteHTML($html);
                if($data['sam_array']['metadata']['multiple'] == 'yes' || count($data['sam_array']['metadata']['availability']) === 1)
                {
                    $filename = $data['sam_array']['avail_ref'] . '_' . $tmp_date_time . '.pdf';
                }
                else
                {
                    $filename = $data['sam_array']['metadata']['availability_name'];
                    if(substr($filename, -2) == '. ')
                        $filename = substr($filename, 0, strlen($filename)-2);
                    if(substr($filename, -1) == '.')
                        $filename = substr($filename, 0, strlen($filename)-1);
                    $filename = str_replace('.', ' ', $filename);
                    $filename = str_replace('(', ' ', $filename);
                    $filename = str_replace(')', ' ', $filename);
                    $filename = str_replace('/', ' ', $filename);
                    $filename = str_replace(',', ' ', $filename);
                    $filename = str_replace(':', ' ', $filename);
                    $filename = str_replace('[', ' ', $filename);
                    $filename = str_replace(']', ' ', $filename);
                    $filename = preg_replace('/\s+/', ' ', $filename);
                    if(strlen($filename) > 70)
                        $filename = substr($filename, 0, 70);
                    if(substr($filename, -1) == ' ')
                        $filename = substr($filename, 0, strlen($filename)-1);
                    $filename = str_replace(' ', '_', $filename);
                    $filename = $filename . '_' . $tmp_date_time . '.pdf';
                }
                $pdf_content = $this->$pdfclsname->Output($filename, 'S');
                $success = $this->flexrest->fileUpload($filearea_uuid, $filename, $pdf_content, $response2);

                /* -----------------------------

                echo "<pre>";
                echo "<h3>File upload response</h3>";
                print_r($response2);
                echo "</pre>";



                #exit;


                */




                sleep(2);
                if(!$success)
                {
                    $errdata['message'] = $this->flexrest->error;
                    log_message('error', 'Attaching SAM pdf failed (fileUpload), item uuid: ' . $uuid . ', error: ' . $errdata['message']);
                    $this->load->view('sam/showerror_view', $errdata);
                    return;
                }
                /***************************************************************
                 * Determine the file uuid,
                 *    - reuse exiting uuid if topic availability is the same
                 *    - otherwise generate new file uuid
                 *
                 ***************************************************************/

                if($count_old_files > 0)
                {
                    $file_uuid = null;
                    #$largest_suffix_number = 0;
                }
                else
                {
                    #No old attachments, generagte new file uuid
                    $file_uuid = sprintf("%03d", $attachment_count);
                    $file_uuid = substr($uuid, 0, 33) . $file_uuid;
                }

                $reuse_old_file_uuid = true;
                /***************************************************************
                 * Old avails:
                 *   A_B_C   1 file uuid-1
                 * New avails:
                 *   A_B_C_D 1 file uuid-1 (reuse exiting uuid)
                 *
                 * Old avails:
                 *   A_B_C   1 file uuid-1
                 * New avails:
                 *   B_C     1 file uuid-2 (generate new uuid)
                 ***************************************************************/
                if($old_one_file_multi_avails == true && $new_one_file_multi_avails == true)
                {
                    if(count(array_diff($old_avails, $new_avails)) > 0)
                    {
                        #There is new availability added in, generate new file uuid
                        $reuse_old_file_uuid = false;
                    }
                    else
                    {
                        $reuse_old_file_uuid = true;
                        $file_uuid = $old_file_array[0]['uuid'];
                    }
                }

                /*
                echo '<pre>';
                echo '$old_one_file_multi_avails ' . $old_one_file_multi_avails;echo '<br>';
                echo '$new_one_file_multi_avails ' . $new_one_file_multi_avails;echo '<br>';
                echo '$file_uuid ' . $file_uuid;echo '<br>';
                print_r($old_avails);echo '<br>';
                print_r($new_avails);echo '<br>';
                echo '</pre>';exit();
                */

                /***************************************************************
                 * Old avails:
                 *   A_B 1 file uuid-1
                 * New avails:
                 *   A   1 file uuid-2
                 *   B   1 file uuid-3
                 ***************************************************************/
                if($old_one_file_multi_avails == true && $new_one_file_multi_avails == false)
                {
                    #generate new file uuid
                    $reuse_old_file_uuid = false;
                }

                /***************************************************************
                 * Old avails:
                 *   A   1 file uuid-1
                 *   B   1 file uuid-2
                 * New avails:
                 *   B_C 1 file uuid-2 (reuse uuid of common avail, generate new one if no common avail )
                 ***************************************************************/
                if($old_one_file_multi_avails == false && $new_one_file_multi_avails == true)
                {
                    #
                    $reuse_old_file_uuid = true;
                    for ($j = 0; $j < $count_old_files; $j++)
                    {
                        for($i = 0; $i < count($new_avails); $i++)
                        {
                            if($new_avails[$i] == $old_file_array[$j]['ref'])
                                $file_uuid = $old_file_array[$j]['uuid'];
                            break;
                        }
                        if($file_uuid != null)
                            break;
                    }
                }

                /***************************************************************
                 * Old avails:
                 *   A   1 file uuid-1
                 *   B   1 file uuid-2
                 * New avails:
                 *   A   1 file uuid-1
                 *   C   1 file uuid-3
                 *
                 * Example:
                 * <previous_files>
                 *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4700A_2014_S2">
                 *       <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc200</uuid>
                 *    </file>
                 *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4700B_2014_S2">
                 *      <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc201</uuid>
                 *    </file>
                 *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4700C_2014_S2">
                 *      <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc202</uuid>
                 *    </file>
                 *  </previous_files>
                 *  <files>
                 *    <file distributed="2014-07-23T13:59:44+0930" ref="COMP4700A_2014_S2">
                 *      <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc000</uuid>
                 *    </file>
                 *    <file distributed="2014-07-23T13:59:44+0930" ref="COMP4700D_2014_S2">
                 *      <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc003</uuid>
                 *    </file>
                 *    <file distributed="2014-07-23T13:59:44+0930" ref="COMP4700C_2014_S2">
                 *      <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc002</uuid>
                 *    </file>
                 *  </files>
                 ***************************************************************/
                #Reuse exiting file uuid
                if($file_uuid === null && $reuse_old_file_uuid == true)
                {
                    for ($j = 0; $j < $count_old_files; $j++)
                    {
                        #For the same avilability, the uuid must remain the same
                        if($data['sam_array']['avail_ref'] == $old_file_array[$j]['ref'])
                        {
                            $file_uuid = $old_file_array[$j]['uuid'];
                            #echo '111 ' . $file_uuid; exit();
                            #if(intval(substr($file_uuid, 32, 3)) > $largest_suffix_number)
                            #    $largest_suffix_number = intval(substr($file_uuid, 32, 3));
                            break;
                        }
                    }
                }
                #the availability is new so it is not found in the exiting files, so assign new uuid to it
                if($file_uuid === null)
                {
                    $largest_suffix_number ++;
                    $file_uuid = substr($uuid, 0, 33) . sprintf("%03d", $largest_suffix_number);
                }
                $new_attachments[$attachment_count] = array('type'=>'file',
                    'filename'=>$filename,
                    'description'=>$filename,
                    'uuid'=>$file_uuid);
                #$item_bean['attachments'][$attachment_count] = array('type'=>'file',
                #                              'filename'=>$filename,
                #                              'description'=>$filename,
                #                              'uuid'=>$file_uuid);
            }
            $node_file = $this->xmlwrapper->createNode($node_files, "file");
            $node_uuid = $this->xmlwrapper->createNode($node_file, "uuid");
            $node_ref = $this->xmlwrapper->createAttribute($node_file, "ref");
            $node_distri = $this->xmlwrapper->createAttribute($node_file, "distributed");
            $node_uuid->nodeValue = $file_uuid;
            $node_ref->nodeValue = $data['sam_array']['avail_ref'];
            #$node_distri->nodeValue = $distributed->format('c');
            $node_distri->nodeValue = $approve_date;
            $attachment_count ++;
        }


        $item_bean['attachments'] = array_merge($new_attachments, $existing_attachments);
        $item_bean['metadata'] = $this->xmlwrapper->__toString();

        /* ----------------------------------
        echo '<pre>';
        #print_r($new_attachments);echo '<br>';
        #print_r($existing_attachments);echo '<br>';
        echo $item_bean['metadata']; echo '<br>';
        #print_r(json_decode(json_encode($item_bean['metadata']), true));echo '<br>';
        print_r($item_bean['attachments']);
        log_message('error', $item_bean['metadata']);
        echo '</pre>';
        exit();

        */
        /*  -------------------------   */

        // Get the lock status of the item

        $s = $this->flexrest->getLock($uuid, $version, $r);
		if($s) // item is locked
		{

            /* -----------------------------

            echo "<pre>";
            echo "<h3>Initial lock status</h3>";
            print_r($r);
            echo "</pre>";
            */

            $lock_uuid = $r['uuid'];



		} else { //item is unlocked, should be the status

            // lock the item
            $item_lock = $this->flexrest->createLock($uuid, $version, $r);

            // Get the lock status. Array element uuid is the lock uuid used in the edit API
            $s1 = $this->flexrest->getLock($uuid, $version, $r1);

            /* -----------------------------

            echo "<pre>";
            echo "<h3>Lock status</h3>";
            print_r($r1);
            echo "</pre>";

            */


            $lock_uuid = $r1['uuid'];


            // Edit the locked item here
            $success = $this->flexrest->editLockedItemAttachment($uuid, $version, $item_bean, $lock_uuid, $response3, $filearea_uuid);

            /* -----------------------------

            echo "<pre>";
            echo "<h3>Edit locked item response</h3>";
            print_r($response3);
            echo "</pre>"

            */


            // unlock the item
            $item_unlock = $this->flexrest->deleteLock($uuid, $version, $r);


            //Final lock status check, should return NULL
            $s2 = $this->flexrest->getLock($uuid, $version, $r2);

            /* -----------------------------

            echo "<pre>";
            echo "<h3>Lock status after unlock</h3>";
            print_r($r2);
            echo "</pre>";

            */

        }



        #$success = $this->flexrest->editItem($uuid, $version, $item_bean, $response3, $filearea_uuid);

              if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed (editItem), item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        #log_message('error', htmlentities($response['metadata']));
        /*
        echo "<br>=====================================";
        echo "<pre>";
        print_r($response3);
	echo "</pre>";
	 */
    }


    /**
     * Attach SAM PDF to ITEM
     *   More detailed comments in line
     *
     * @param string $uuid, item UUID
     * @param string $version, item Version
     */
    public function attach_pdf_lx9n3h2_OLD_VERSION($uuid='missed', $version='missed')
    {
        #$this->output->enable_profiler(TRUE);
        $errdata['heading'] = "Error";

        if($this->validate_params('pdf', $uuid, $version) == false)
        {
            $errdata['message'] = "Invalid Request";
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . 'Invalid input params.');
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');

        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }

        #ob_end_flush();
        #log_message('error', 'ob_get_level ():');
        #log_message('error', ob_get_level ());
        #ob_start();
        #echo 'good';
        /****************************************************************
         * Important: Respond to Equella so that its workflow can finish
         * Otherwise the editItem will fail.
         *
         * Script goes on after flushing to equella.
         ****************************************************************/

        // Ignore connection-closing by the client/user
        ignore_user_abort(true);
        // Set your timelimit to a length long enough for your script to run,
        // but not so long it will bog down your server in case multiple versions run
        // or this script get's in an endless loop.
        $content = 'good';         // Get the content of the output buffer
        #ob_end_clean();                     // Close current output buffer
        $len = strlen($content);
        header('Content-Type: text/html; charset=UTF-8');
        header('Content-Encoding: none;');
        header('Connection: close');         // Tell the client to close connection
        header("Content-Length: $len");      // Close connection after $size characters
        #echo $content;                       // Output content
        ob_flush();
        flush();                             // Force php-output-cache to flush to flex.

        ob_end_flush();

        // Optional: kill all other output buffering
        #while (ob_get_level() > 0) {
        #    ob_end_clean();
        #}

        #make sure sam work flow completely finishes
        sleep (5);
        $success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }

        unset($response['headers']);
        $item_bean = $response;
        /*
        echo "<br>=====================================";
        echo "<pre>";
        print_r($response);
        echo "</pre>";
	 */
        $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']));

        if(!$this->itemIsSam($this->xmlwrapper))
        {
            $errdata['message'] = "Item is not SAM";
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }

        $sam_array = $this->samXml2Array($this->xmlwrapper);
        $sam_array['status'] = $response['status'];
        $data = array('sam_array' => $sam_array);
        #$data['sam_array']['avail_ref'] = $avail_ref;
        #$data['sam_array']['avail_ver'] = $avail_ver;
        $data['sam_array']['format'] = 'pdf';
        $data['sam_array']['uuid'] = $uuid; #item uuid
        $data['sam_array']['version'] = $version; #item version number

        $approve_date =  $data['sam_array']['metadata']['approved'];
        $tmp_date =  $data['sam_array']['metadata']['approvalDate'];
        if($approve_date == null)
        {
            #$errdata['message'] = '/xml/item/curriculum/assessment/approval/approved is null';
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . 'approved date is null');
            #$this->load->view('sam/showerror_view', $errdata);
            return;
        }
        $tmp_time = substr($approve_date, strpos($approve_date, 'T')+1, 8);
        $tmp_time = str_replace(':', '-', $tmp_time);
        $tmp_date_time = $tmp_date . 'T' . $tmp_time;


        #log_message('error', 'ob_get_level ():');
        #log_message('error', ob_get_level ());
        ob_start();
        #log_message('error', 'ob_get_level ():');
        #log_message('error', ob_get_level ());

        $success = $this->flexrest->filesCopy($uuid, $version, $response1);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed (filesCopy), item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        if(!isset($response1['headers']['location']))
        {
            $errdata['message'] = 'No Location header in response to copy files REST call.';
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        $location = $response1['headers']['location'];
        $filearea_uuid = substr($location, strpos($location, 'file')+5, 36);

        /***************************************************************
         * Check whther there are exiting files, if yes, move them to
         * previous_files and change uuid.
         *
         * <files>
         *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4730C_2014_S2">
         *        <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc000</uuid>
         *    </file>
         * </files>
         *
         * <previous_files>
         *    <file distributed="2014-08-28T14:34:18+09:30" ref="COMP4730C_2014_S2">
         *        <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc100</uuid>
         *    </file>
         * </previous_files>
         ****************************************************************/

        /***************************************************************
         * Muiltiple files for each availability
         *
         * <files>
         *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4730C_2014_S2">
         *        <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc000</uuid>
         *    </file>
         *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4730D_2014_S2">
         *        <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc001</uuid>
         *    </file>
         * </files>
         *
         * Single file for all availabilities
         * <files>
         *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4730C_2014_S2">
         *        <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc000</uuid>
         *    </file>
         *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4730D_2014_S2">
         *        <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc000</uuid>
         *    </file>
         * </files>
         ****************************************************************/

        if(!isset($item_bean['attachments']))
            $item_bean['attachments'] = array();
        #$attachment_count = count($item_bean['attachments']);
        $existing_attachments = $item_bean['attachments'];
        $new_attachments = array();

        $xpath_files = '/xml/item/curriculum/assessment/SAMs/files';

        $node_previous_files = null;
        $xpath_previous_files = '/xml/item/curriculum/assessment/SAMs/previous_files';
        $xpath_files_first_file = $xpath_files . '/file[1]/uuid';

        $xpath_previous_files_first_file = $xpath_previous_files . '/file[1]/uuid';
        $first_files_uuid = $this->xmlwrapper->nodeValue($xpath_files_first_file);
        $first_previous_files_uuid = $this->xmlwrapper->nodeValue($xpath_previous_files_first_file);

        $old_files_exist = $first_files_uuid == null ? false : true;
        $previous_files_exist = $first_previous_files_uuid == null ? false : true;

        $count_old_files = $this->xmlwrapper->numNodes($xpath_files . '/file');
        $count_previous_files = $this->xmlwrapper->numNodes($xpath_previous_files . '/file');
        #echo $old_files_exist . ' dd '; echo $count_old_files; exit();

        $old_file_array = array();
        $previous_file_uuid_suffix = 200;
        $next_previous_file_uuid = '';
        $old_one_file_multi_avails = false;
        $old_avails = array();

        /****************************************************************
         * copy all the <files> to <previous_files>
         ****************************************************************/
        ####

        /*log_message('error', 'Attaching SAM pdf, count_old_files: '.$count_old_files);
        if($old_files_exist == true)
            log_message('error', 'Attaching SAM pdf, old_files_exist: true ');
        else
            log_message('error', 'Attaching SAM pdf, old_files_exist: false ');*/

        /*if($count_old_files > 0 && $old_files_exist == false)
        {
            log_message('error', 'Attaching SAM pdf, $count_old_files > 0 && $old_files_exist == false, item uuid: ' . $uuid);
            exit();
        }*/

        #if($old_files_exist)
        if($count_old_files > 0)
        {
            $node_previous_files = $this->xmlwrapper->createNodeFromXPath($xpath_previous_files);
            #if($previous_files_exist)
            if($count_previous_files > 0)
                $previous_file_uuid_suffix += $count_previous_files;

            $next_previous_file_uuid = substr($uuid, 0, 33) . sprintf("%03d", $previous_file_uuid_suffix);
            #echo $next_previous_file_uuid; exit();

            for ($j = 1; $j <= $count_old_files; $j++)
            {
                $tmp_xpath_file_uuid = $xpath_files . '/file['.$j.']/uuid';
                $tmp_xpath_file_ref = $xpath_files . '/file['.$j.']/@ref';
                $tmp_xpath_file_distributed = $xpath_files . '/file['.$j.']/@distributed';

                $tmp_file_uuid = $this->xmlwrapper->nodeValue($tmp_xpath_file_uuid);
                $tmp_file_ref = $this->xmlwrapper->nodeValue($tmp_xpath_file_ref);
                $tmp_file_distributed = $this->xmlwrapper->nodeValue($tmp_xpath_file_distributed);

                $old_file_array[$j-1]['uuid'] = $tmp_file_uuid;
                $old_file_array[$j-1]['ref'] = $tmp_file_ref;
                $old_file_array[$j-1]['dist'] = $tmp_file_distributed;

                $old_avails[$j-1] = $tmp_file_ref;
            }

            if($count_old_files > 1 &&
                $old_file_array[0]['uuid'] == $old_file_array[1]['uuid'] &&
                $old_file_array[0]['uuid'] == $old_file_array[$count_old_files-1]['uuid'])
                $old_one_file_multi_avails = true;
            else
                $old_one_file_multi_avails = false;

            #Append the files to previous_files subtree, change uuid
            for ($j = 0; $j < $count_old_files; $j++)
            {
                $tmp_node_previous_file = $this->xmlwrapper->createNode($node_previous_files, "file");
                $tmp_node_previous_file_uuid = $this->xmlwrapper->createNode($tmp_node_previous_file, "uuid");
                $tmp_node_previous_file_ref = $this->xmlwrapper->createAttribute($tmp_node_previous_file, "ref");
                $tmp_node_previous_file_distri = $this->xmlwrapper->createAttribute($tmp_node_previous_file, "distributed");

                $tmp_node_previous_file_ref->nodeValue = $old_file_array[$j]['ref'];
                $tmp_node_previous_file_distri->nodeValue = $old_file_array[$j]['dist'];

                $tmp_node_previous_file_uuid->nodeValue = $next_previous_file_uuid;
                for($i=0; $i<count($existing_attachments); $i++)
                {
                    if($existing_attachments[$i]['uuid'] == $old_file_array[$j]['uuid'])
                        $existing_attachments[$i]['uuid'] = $next_previous_file_uuid;
                }
                if($count_old_files>1 && $old_one_file_multi_avails == false)
                {
                    $previous_file_uuid_suffix ++;
                    $next_previous_file_uuid = substr($uuid, 0, 33) . sprintf("%03d", $previous_file_uuid_suffix);
                }
            }
        }

        #print_r(simplexml_import_dom($node_previous_files)->asXML());exit();


        $this->xmlwrapper->deleteNodeFromXPath($xpath_files);
        $node_files = $this->xmlwrapper->createNodeFromXPath($xpath_files);
        #$distributed = $approve_date; #new DateTime("now");
        #$approve_time = $distributed->format('c');
        #$item_bean['attachments'] = null;
        $file_uuid = $uuid;
        $largest_suffix_number = 0;

        #find out the largest suffix number in uuid (last three chars)
        for ($j = 0; $j < $count_old_files; $j++)
        {
            $file_suffix_number = intval(substr($old_file_array[$j]['uuid'], 33, 3));
            if($file_suffix_number > $largest_suffix_number)
                $largest_suffix_number = $file_suffix_number;
        }

        $new_one_file_multi_avails = false;
        $new_avails = array();
        $i = 0;
        foreach ($data['sam_array']['metadata']['availability'] as $availdata  )
        {
            $new_avails[$i] = $availdata['avRef'];
            $i ++;
        }
        if($data['sam_array']['metadata']['multiple'] != 'yes' && count($new_avails) > 1)
            $new_one_file_multi_avails = true;

        $attachment_count = 0;
        foreach ($data['sam_array']['metadata']['availability'] as $availdata  )
        {
            $data['sam_array']['avail_ref'] = $availdata['avRef'];
            $data['sam_array']['avail_ver'] = $availdata['avVersion'];
            $data['sam_array']['avail_year'] = $availdata['avYear'];

            /*
             *
             * Dynamically set the view to display the correct SAM template for the designated year
             *
             *
             */
            $sam_for_delivery = 'sam/showsam_view_' . $data['sam_array']['avail_year'] . 'p';


            if($data['sam_array']['metadata']['multiple'] == 'yes' || $attachment_count == 0)
            {
                ob_start();
                $this->load->view($sam_for_delivery, $data);
                $html = ob_get_contents();
                ob_end_clean();
                $pdfclsname = 'pdf_class'.$attachment_count;
                $this->load->library('pdf/pdf_class', null, $pdfclsname);
                #$this->pdf_class->SetDisplayMode('fullpage');
                $this->$pdfclsname->setFooter('{PAGENO} / {nb}');
                $this->$pdfclsname->WriteHTML($html);
                if($data['sam_array']['metadata']['multiple'] == 'yes' || count($data['sam_array']['metadata']['availability']) === 1)
                {
                    $filename = $data['sam_array']['avail_ref'] . '_' . $tmp_date_time . '.pdf';
                }
                else
                {
                    $filename = $data['sam_array']['metadata']['availability_name'];
                    if(substr($filename, -2) == '. ')
                        $filename = substr($filename, 0, strlen($filename)-2);
                    if(substr($filename, -1) == '.')
                        $filename = substr($filename, 0, strlen($filename)-1);
                    $filename = str_replace('.', ' ', $filename);
                    $filename = str_replace('(', ' ', $filename);
                    $filename = str_replace(')', ' ', $filename);
                    $filename = str_replace('/', ' ', $filename);
                    $filename = str_replace(',', ' ', $filename);
                    $filename = str_replace(':', ' ', $filename);
                    $filename = str_replace('[', ' ', $filename);
                    $filename = str_replace(']', ' ', $filename);
                    $filename = preg_replace('/\s+/', ' ', $filename);
                    if(strlen($filename) > 70)
                        $filename = substr($filename, 0, 70);
                    if(substr($filename, -1) == ' ')
                        $filename = substr($filename, 0, strlen($filename)-1);
                    $filename = str_replace(' ', '_', $filename);
                    $filename = $filename . '_' . $tmp_date_time . '.pdf';
                }
                $pdf_content = $this->$pdfclsname->Output($filename, 'S');
                $success = $this->flexrest->fileUpload($filearea_uuid, $filename, $pdf_content, $response2);
                if(!$success)
                {
                    $errdata['message'] = $this->flexrest->error;
                    log_message('error', 'Attaching SAM pdf failed (fileUpload), item uuid: ' . $uuid . ', error: ' . $errdata['message']);
                    $this->load->view('sam/showerror_view', $errdata);
                    return;
                }
                /***************************************************************
                 * Determine the file uuid,
                 *    - reuse exiting uuid if topic availability is the same
                 *    - otherwise generate new file uuid
                 *
                 ***************************************************************/

                if($count_old_files > 0)
                {
                    $file_uuid = null;
                    #$largest_suffix_number = 0;
                }
                else
                {
                    #No old attachments, generagte new file uuid
                    $file_uuid = sprintf("%03d", $attachment_count);
                    $file_uuid = substr($uuid, 0, 33) . $file_uuid;
                }

                $reuse_old_file_uuid = true;
                /***************************************************************
                 * Old avails:
                 *   A_B_C   1 file uuid-1
                 * New avails:
                 *   A_B_C_D 1 file uuid-1 (reuse exiting uuid)
                 *
                 * Old avails:
                 *   A_B_C   1 file uuid-1
                 * New avails:
                 *   B_C     1 file uuid-2 (generate new uuid)
                 ***************************************************************/
                if($old_one_file_multi_avails == true && $new_one_file_multi_avails == true)
                {
                    if(count(array_diff($old_avails, $new_avails)) > 0)
                    {
                        #There is new availability added in, generate new file uuid
                        $reuse_old_file_uuid = false;
                    }
                    else
                    {
                        $reuse_old_file_uuid = true;
                        $file_uuid = $old_file_array[0]['uuid'];
                    }
                }

                /*
                echo '<pre>';
                echo '$old_one_file_multi_avails ' . $old_one_file_multi_avails;echo '<br>';
                echo '$new_one_file_multi_avails ' . $new_one_file_multi_avails;echo '<br>';
                echo '$file_uuid ' . $file_uuid;echo '<br>';
                print_r($old_avails);echo '<br>';
                print_r($new_avails);echo '<br>';
                echo '</pre>';exit();
                */

                /***************************************************************
                 * Old avails:
                 *   A_B 1 file uuid-1
                 * New avails:
                 *   A   1 file uuid-2
                 *   B   1 file uuid-3
                 ***************************************************************/
                if($old_one_file_multi_avails == true && $new_one_file_multi_avails == false)
                {
                    #generate new file uuid
                    $reuse_old_file_uuid = false;
                }

                /***************************************************************
                 * Old avails:
                 *   A   1 file uuid-1
                 *   B   1 file uuid-2
                 * New avails:
                 *   B_C 1 file uuid-2 (reuse uuid of common avail, generate new one if no common avail )
                 ***************************************************************/
                if($old_one_file_multi_avails == false && $new_one_file_multi_avails == true)
                {
                    #
                    $reuse_old_file_uuid = true;
                    for ($j = 0; $j < $count_old_files; $j++)
                    {
                        for($i = 0; $i < count($new_avails); $i++)
                        {
                            if($new_avails[$i] == $old_file_array[$j]['ref'])
                                $file_uuid = $old_file_array[$j]['uuid'];
                            break;
                        }
                        if($file_uuid != null)
                            break;
                    }
                }

                /***************************************************************
                 * Old avails:
                 *   A   1 file uuid-1
                 *   B   1 file uuid-2
                 * New avails:
                 *   A   1 file uuid-1
                 *   C   1 file uuid-3
                 *
                 * Example:
                 * <previous_files>
                 *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4700A_2014_S2">
                 *       <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc200</uuid>
                 *    </file>
                 *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4700B_2014_S2">
                 *      <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc201</uuid>
                 *    </file>
                 *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4700C_2014_S2">
                 *      <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc202</uuid>
                 *    </file>
                 *  </previous_files>
                 *  <files>
                 *    <file distributed="2014-07-23T13:59:44+0930" ref="COMP4700A_2014_S2">
                 *      <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc000</uuid>
                 *    </file>
                 *    <file distributed="2014-07-23T13:59:44+0930" ref="COMP4700D_2014_S2">
                 *      <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc003</uuid>
                 *    </file>
                 *    <file distributed="2014-07-23T13:59:44+0930" ref="COMP4700C_2014_S2">
                 *      <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc002</uuid>
                 *    </file>
                 *  </files>
                 ***************************************************************/
                #Reuse exiting file uuid
                if($file_uuid === null && $reuse_old_file_uuid == true)
                {
                    for ($j = 0; $j < $count_old_files; $j++)
                    {
                        #For the same avilability, the uuid must remain the same
                        if($data['sam_array']['avail_ref'] == $old_file_array[$j]['ref'])
                        {
                            $file_uuid = $old_file_array[$j]['uuid'];
                            #echo '111 ' . $file_uuid; exit();
                            #if(intval(substr($file_uuid, 32, 3)) > $largest_suffix_number)
                            #    $largest_suffix_number = intval(substr($file_uuid, 32, 3));
                            break;
                        }
                    }
                }
                #the availability is new so it is not found in the exiting files, so assign new uuid to it
                if($file_uuid === null)
                {
                    $largest_suffix_number ++;
                    $file_uuid = substr($uuid, 0, 33) . sprintf("%03d", $largest_suffix_number);
                }
                $new_attachments[$attachment_count] = array('type'=>'file',
                    'filename'=>$filename,
                    'description'=>$filename,
                    'uuid'=>$file_uuid);
                #$item_bean['attachments'][$attachment_count] = array('type'=>'file',
                #                              'filename'=>$filename,
                #                              'description'=>$filename,
                #                              'uuid'=>$file_uuid);
            }
            $node_file = $this->xmlwrapper->createNode($node_files, "file");
            $node_uuid = $this->xmlwrapper->createNode($node_file, "uuid");
            $node_ref = $this->xmlwrapper->createAttribute($node_file, "ref");
            $node_distri = $this->xmlwrapper->createAttribute($node_file, "distributed");
            $node_uuid->nodeValue = $file_uuid;
            $node_ref->nodeValue = $data['sam_array']['avail_ref'];
            #$node_distri->nodeValue = $distributed->format('c');
            $node_distri->nodeValue = $approve_date;
            $attachment_count ++;
        }


        $item_bean['attachments'] = array_merge($new_attachments, $existing_attachments);
        $item_bean['metadata'] = $this->xmlwrapper->__toString();

        /*
        echo '<pre>';
        #print_r($new_attachments);echo '<br>';
        #print_r($existing_attachments);echo '<br>';
        echo $item_bean['metadata']; echo '<br>';
        #print_r(json_decode(json_encode($item_bean['metadata']), true));echo '<br>';
        print_r($item_bean['attachments']);
        log_message('error', $item_bean['metadata']);
        echo '</pre>';
        exit();
        */

        $success = $this->flexrest->editItem($uuid, $version, $item_bean, $response3, $filearea_uuid);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed (editItem), item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        #log_message('error', htmlentities($response['metadata']));
        /*
        echo "<br>=====================================";
        echo "<pre>";
        print_r($response3);
	echo "</pre>";
	 */
    }




    /**
     * Attach SAM PDF to ITEM
     *
     * @param string $uuid, item UUID
     * @param string $version, item Version
     */
    public function attach_pdf_old_lx9n3h2_old($uuid='missed', $version='missed')
    {
        #$this->output->enable_profiler(TRUE);
        $errdata['heading'] = "Error";

        if($this->validate_params('pdf', $uuid, $version) == false)
        {
            $errdata['message'] = "Invalid Request";
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . 'Invalid input params.');
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');

        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }

        #ob_end_flush();
        #log_message('error', 'ob_get_level ():');
        #log_message('error', ob_get_level ());
        #ob_start();
        #echo 'good';
        // Ignore connection-closing by the client/user
        ignore_user_abort(true);
        // Set your timelimit to a length long enough for your script to run,
        // but not so long it will bog down your server in case multiple versions run
        // or this script get's in an endless loop.
        /*if (
             !ini_get('safe_mode')
             && strpos(ini_get('disable_functions'), 'set_time_limit') === FALSE
        ){
            set_time_limit(60);
        }*/
        // Get your output and send it to the client
        $content = 'good';         // Get the content of the output buffer
        #ob_end_clean();                     // Close current output buffer
        $len = strlen($content);
        header('Content-Type: text/html; charset=UTF-8');
        header('Content-Encoding: none;');
        header('Connection: close');         // Tell the client to close connection
        header("Content-Length: $len");      // Close connection after $size characters
        echo $content;                       // Output content
        ob_flush();
        flush();                             // Force php-output-cache to flush to flex.

        ob_end_flush();

        // Optional: kill all other output buffering
        #while (ob_get_level() > 0) {
        #    ob_end_clean();
        #}

        #make sure sam work flow completely finishes
        sleep (5);
        $success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }

        unset($response['headers']);
        $item_bean = $response;
        /*
        echo "<br>=====================================";
        echo "<pre>";
        print_r($response);
        echo "</pre>";
	 */
        $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']));

        if(!$this->itemIsSam($this->xmlwrapper))
        {
            $errdata['message'] = "Item is not SAM";
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }

        $sam_array = $this->samXml2Array($this->xmlwrapper);
        $sam_array['status'] = $response['status'];
        $data = array('sam_array' => $sam_array);
        #$data['sam_array']['avail_ref'] = $avail_ref;
        #$data['sam_array']['avail_ver'] = $avail_ver;
        $data['sam_array']['format'] = 'pdf';
        $data['sam_array']['uuid'] = $uuid; #item uuid
        $data['sam_array']['version'] = $version; #item version number
        #log_message('error', 'ob_get_level ():');
        #log_message('error', ob_get_level ());
        ob_start();
        #log_message('error', 'ob_get_level ():');
        #log_message('error', ob_get_level ());

        $success = $this->flexrest->filesCopy($uuid, $version, $response1);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        if(!isset($response1['headers']['location']))
        {
            $errdata['message'] = 'No Location header in response to copy files REST call.';
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        $location = $response1['headers']['location'];
        $filearea_uuid = substr($location, strpos($location, 'file')+5, 36);

        $xpath_files = '/xml/item/curriculum/assessment/SAMs/files';
        #$xpath_uuid = '/xml/item/curriculum/files/file/uuid';
        #$this->xmlwrapper->deleteNodeFromXPath('/xml/item/curriculum/SAMs');
        $this->xmlwrapper->deleteNodeFromXPath($xpath_files);
        $node_files = $this->xmlwrapper->createNodeFromXPath($xpath_files);
        $distributed = new DateTime("now");
        $item_bean['attachments'] = null;
        $file_uuid = $uuid;

        #if($data['sam_array']['metadata']['multiple'] == 'yes')
        {
            $attachment_count = 0;
            foreach ($data['sam_array']['metadata']['availability'] as $availdata  )
            {
                $data['sam_array']['avail_ref'] = $availdata['avRef'];
                $data['sam_array']['avail_ver'] = $availdata['avVersion'];

                if($data['sam_array']['metadata']['multiple'] == 'yes' || $attachment_count == 0)
                {
                    ob_start();
                    $this->load->view('sam/showsam_view', $data);
                    $html = ob_get_contents();
                    ob_end_clean();
                    $pdfclsname = 'pdf_class'.$attachment_count;
                    $this->load->library('pdf/pdf_class', null, $pdfclsname);
                    #$this->pdf_class->SetDisplayMode('fullpage');
                    $this->$pdfclsname->setFooter('{PAGENO} / {nb}');
                    $this->$pdfclsname->WriteHTML($html);
                    if($data['sam_array']['metadata']['multiple'] == 'yes')
                        $filename = $data['sam_array']['avail_ref'] . '.pdf';
                    else
                    {
                        $filename = $data['sam_array']['metadata']['availability_name'];
                        if(substr($filename, -2) == '. ')
                            $filename = substr($filename, 0, strlen($filename)-2);
                        $filename = str_replace('. ', '_', $filename);
                        $filename .= '.pdf';
                    }

                    $pdf_content = $this->$pdfclsname->Output($filename, 'S');
                    $success = $this->flexrest->fileUpload($filearea_uuid, $filename, $pdf_content, $response2);
                    if(!$success)
                    {
                        $errdata['message'] = $this->flexrest->error;
                        log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
                        $this->load->view('sam/showerror_view', $errdata);
                        return;
                    }
                    $file_uuid = sprintf("%03d", $attachment_count);
                    $file_uuid = substr($uuid, 0, 33) . $file_uuid;
                    $item_bean['attachments'][$attachment_count] = array('type'=>'file',
                        'filename'=>$filename,
                        'description'=>$filename,
                        'uuid'=>$file_uuid);
                }
                $node_file = $this->xmlwrapper->createNode($node_files, "file");
                $node_uuid = $this->xmlwrapper->createNode($node_file, "uuid");
                $node_ref = $this->xmlwrapper->createAttribute($node_file, "ref");
                $node_distri = $this->xmlwrapper->createAttribute($node_file, "distributed");
                $node_uuid->nodeValue = $file_uuid;
                $node_ref->nodeValue = $data['sam_array']['avail_ref'];
                $node_distri->nodeValue = $distributed->format('c');

                $attachment_count ++;
            }
        }


        $item_bean['metadata'] = $this->xmlwrapper->__toString();
        $success = $this->flexrest->editItem($uuid, $version, $item_bean, $response3, $filearea_uuid);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        #log_message('error', htmlentities($response['metadata']));
        /*
        echo "<br>=====================================";
        echo "<pre>";
        print_r($response3);
	echo "</pre>";
	 */
    }

    /**
     * Attach SAM PDF to ITEM
     *
     * @param string $uuid, item UUID
     * @param string $version, item Version
     */
    public function attach_pdf_temp_klk398wd($uuid='missed', $version='missed')
    {
        #$filename_encode = 'kk   kk kk';
        #$filename_encode = rawurlencode($filename_encode);
        #echo $filename_encode;
        #exit();

        #$this->output->enable_profiler(TRUE);
        $errdata['heading'] = "Error";

        if($this->validate_params('pdf', $uuid, $version) == false)
        {
            $errdata['message'] = "Invalid Request";
            log_message('error', 'Attaching SAM pdf failed (validate_params), item uuid: ' . $uuid . ', error: ' . 'Invalid input params.');
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');

        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }

        #ob_end_flush();
        #log_message('error', 'ob_get_level ():');
        #log_message('error', ob_get_level ());
        #ob_start();
        #echo 'good';
        // Ignore connection-closing by the client/user
        ignore_user_abort(true);
        // Set your timelimit to a length long enough for your script to run,
        // but not so long it will bog down your server in case multiple versions run
        // or this script get's in an endless loop.
        /*if (
             !ini_get('safe_mode')
             && strpos(ini_get('disable_functions'), 'set_time_limit') === FALSE
        ){
            set_time_limit(60);
        }*/
        /*
        // Get your output and send it to the client
        $content = 'good';         // Get the content of the output buffer
	$len = strlen($content);
	header('Content-Type: text/html; charset=UTF-8');
	header('Content-Encoding: none;');
        header('Connection: close');         // Tell the client to close connection
        header("Content-Length: $len");      // Close connection after $size characters
	echo $content;                       // Output content
	ob_flush();
        flush();                             // Force php-output-cache to flush to flex.

	ob_end_flush();
	*/
        // Optional: kill all other output buffering
        #while (ob_get_level() > 0) {
        #    ob_end_clean();
        #}

        #make sure sam work flow completely finishes
        #sleep (5);
        $success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed (getItem), item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }

        unset($response['headers']);
        $item_bean = $response;
        /*
        echo "<br>=====================================";
        echo "<pre>";
        print_r($response);
        echo "</pre>";
	exit();
        */
        $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']));

        if(!$this->itemIsSam($this->xmlwrapper))
        {
            $errdata['message'] = "Item is not SAM";
            log_message('error', 'Attaching SAM pdf failed (itemIsSam), item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }

        $xpath_files = '/xml/item/curriculum/assessment/SAMs/files';
        #$xpath_uuid = '/xml/item/curriculum/files/file/uuid';
        #$this->xmlwrapper->deleteNodeFromXPath('/xml/item/curriculum/SAMs');
        $xpath_files_first_file = $xpath_files . '/file[1]/@distributed';
        $approve_date_old = $this->xmlwrapper->nodeValue($xpath_files_first_file);

        $xpath_approved = '/xml/item/curriculum/assessment/approval/approved';
        $xpath_approval_date = '/xml/item/curriculum/assessment/approval/date';
        #$xpath_distributed_date = '/xml/item/curriculum/assessment/SAMs/distributed';

        $approve_date = $this->xmlwrapper->nodeValue($xpath_approved);
        $tmp_date = $this->xmlwrapper->nodeValue($xpath_approval_date);

        if($approve_date == null)
        {
            $errdata['message'] = '/xml/item/curriculum/assessment/approval/approved is null';
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        #$this->xmlwrapper->setNodeValue($xpath_distributed_date, $tmp_date);
        #$this->xmlwrapper->setNodeValue($xpath_approved, $approve_date);
        #$this->xmlwrapper->setNodeValue($xpath_approval_date, substr($approve_date, 0, 10));
        $tmp_time = substr($approve_date, strpos($approve_date, 'T')+1, 8);
        $tmp_time = str_replace(':', '-', $tmp_time);
        $tmp_date_time = $tmp_date . 'T' . $tmp_time;
        #echo $tmp_time; exit();

        $sam_array = $this->samXml2Array($this->xmlwrapper);
        $sam_array['status'] = $response['status'];
        $data = array('sam_array' => $sam_array);
        #$data['sam_array']['avail_ref'] = $avail_ref;
        #$data['sam_array']['avail_ver'] = $avail_ver;
        $data['sam_array']['format'] = 'pdf';
        $data['sam_array']['uuid'] = $uuid; #item uuid
        $data['sam_array']['version'] = $version; #item version number
        #log_message('error', 'ob_get_level ():');
        #log_message('error', ob_get_level ());
        ob_start();
        #log_message('error', 'ob_get_level ():');
        #log_message('error', ob_get_level ());

        $success = $this->flexrest->filesCopy($uuid, $version, $response1);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed, item uuid (filesCopy): ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        if(!isset($response1['headers']['location']))
        {
            $errdata['message'] = 'No Location header in response to copy files REST call.';
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        $location = $response1['headers']['location'];
        $filearea_uuid = substr($location, strpos($location, 'file')+5, 36);



        $this->xmlwrapper->deleteNodeFromXPath($xpath_files);
        $node_files = $this->xmlwrapper->createNodeFromXPath($xpath_files);


        #echo $approve_date; echo 'kkk'; exit();

        ##$xpath_approvedate = '/xml/item/moderation/liveapprovaldate';
        ##$approve_date = $this->xmlwrapper->nodeValue($xpath_approvedate) . '111';
        #echo $approve_date; exit();
        #$distributed = new DateTime("now");
        $distributed = $approve_date;
        $item_bean['attachments'] = null;
        $file_uuid = $uuid;

        #if($data['sam_array']['metadata']['multiple'] == 'yes')
        {
            $attachment_count = 0;
            foreach ($data['sam_array']['metadata']['availability'] as $availdata  )
            {
                $data['sam_array']['avail_ref'] = $availdata['avRef'];
                $data['sam_array']['avail_ver'] = $availdata['avVersion'];

                if($data['sam_array']['metadata']['multiple'] == 'yes' || $attachment_count == 0)
                {
                    ob_start();
                    $this->load->view('sam/showsam_view', $data);
                    $html = ob_get_contents();
                    ob_end_clean();
                    $pdfclsname = 'pdf_class'.$attachment_count;
                    $this->load->library('pdf/pdf_class', null, $pdfclsname);
                    #$this->pdf_class->SetDisplayMode('fullpage');
                    $this->$pdfclsname->setFooter('{PAGENO} / {nb}');
                    $this->$pdfclsname->WriteHTML($html);
                    if($data['sam_array']['metadata']['multiple'] == 'yes')
                    {
                        #$filename = $data['sam_array']['avail_ref'] . '.pdf';
                        #$filename_date = $data['sam_array']['avail_ref'] . '_' . $approve_date . '.pdf';

                        $filename = $data['sam_array']['avail_ref'] . '_' . $approve_date_old . '.pdf';
                        $filename_new = $data['sam_array']['avail_ref'] . '_' . $tmp_date_time . '.pdf';
                    }
                    else
                    {
                        $filename = $data['sam_array']['metadata']['availability_name'];
                        if(substr($filename, -2) == '. ')
                            $filename = substr($filename, 0, strlen($filename)-2);
                        $filename = str_replace('. ', '_', $filename);
                        $filename = $filename . '_' . $approve_date_old . '.pdf';

                        if(count($data['sam_array']['metadata']['availability']) === 1)
                        {
                            $filename_new = $data['sam_array']['avail_ref'] . '_' . $tmp_date_time . '.pdf';
                        }
                        else
                        {
                            $filename_new = $data['sam_array']['metadata']['availability_name'];
                            if(substr($filename_new, -2) == '. ')
                                $filename_new = substr($filename_new, 0, strlen($filename_new)-2);
                            if(substr($filename_new, -1) == '.')
                                $filename_new = substr($filename_new, 0, strlen($filename_new)-1);
                            $filename_new = str_replace('.', ' ', $filename_new);
                            $filename_new = str_replace('(', ' ', $filename_new);
                            $filename_new = str_replace(')', ' ', $filename_new);
                            $filename_new = str_replace('/', ' ', $filename_new);
                            $filename_new = str_replace(',', ' ', $filename_new);
                            $filename_new = str_replace(':', ' ', $filename_new);
                            $filename_new = str_replace('[', ' ', $filename_new);
                            $filename_new = str_replace(']', ' ', $filename_new);
                            $filename_new = preg_replace('/\s+/', ' ', $filename_new);
                            $filename_new = str_replace(' ', '_', $filename_new);
                            $filename_new = $filename_new . '_' . $tmp_date_time . '.pdf';
                        }
                    }

                    $filename_encode = rawurlencode($filename);
                    $success = $this->flexrest->fileDelete($filearea_uuid, $filename_encode, $response2);
                    if(!$success)
                    {
                        $errdata['message'] = $this->flexrest->error;
                        #log_message('error', 'Attaching SAM pdf failed (fileDelete), item uuid: ' . $uuid . ', error: ' . $errdata['message'] . ' file name: ' . $filename_encode);
                        #$this->load->view('sam/showerror_view', $errdata);
                        #return;
                        $filename_encode = str_replace('14%20S2', '14%20%20%20S2', $filename_encode);
                        $success = $this->flexrest->fileDelete($filearea_uuid, $filename_encode, $response2);
                        if(!$success)
                        {
                            #$errdata['message'] = $this->flexrest->error;
                            log_message('error', 'Attaching SAM pdf failed (fileDelete), item uuid: ' . $uuid . ', error: ' . $errdata['message'] . ' file name: ' . $filename_encode);
                            #$this->load->view('sam/showerror_view', $errdata);
                            #exit();
                            echo 'failed to delete old file<br>';
                        }
                        #echo "Changed to 3 spaces and file deleted!";
                    }
                    #echo 'Old file deleted<br>';
                    echo 'new file:' . $filename_new . '<br>';

                    $pdf_content = $this->$pdfclsname->Output($filename_new, 'S');
                    $success = $this->flexrest->fileUpload($filearea_uuid, $filename_new, $pdf_content, $response3);
                    #echo 'after fileUpload<br>';
                    if(!$success)
                    {
                        $errdata['message'] = $this->flexrest->error;
                        log_message('error', 'Attaching SAM pdf failed (fileUpload), item uuid: ' . $uuid . ', error: ' . $errdata['message']);
                        $this->load->view('sam/showerror_view', $errdata);
                        return;
                    }
                    echo 'fileUpload success<br>';
                    $file_uuid = sprintf("%03d", $attachment_count);
                    $file_uuid = substr($uuid, 0, 33) . $file_uuid;
                    $item_bean['attachments'][$attachment_count] = array('type'=>'file',
                        'filename'=>$filename_new,
                        'description'=>$filename_new,
                        'uuid'=>$file_uuid);
                    #echo 'after setting $item_bean[attachments][$attachment_count]<br>';
                }
                $node_file = $this->xmlwrapper->createNode($node_files, "file");
                $node_uuid = $this->xmlwrapper->createNode($node_file, "uuid");
                $node_ref = $this->xmlwrapper->createAttribute($node_file, "ref");
                $node_distri = $this->xmlwrapper->createAttribute($node_file, "distributed");
                $node_uuid->nodeValue = $file_uuid;
                $node_ref->nodeValue = $data['sam_array']['avail_ref'];
                $node_distri->nodeValue = $distributed;

                $attachment_count ++;
            }
        }


        $item_bean['metadata'] = $this->xmlwrapper->__toString();
        $success = $this->flexrest->editItem($uuid, $version, $item_bean, $response4, $filearea_uuid);
        #echo 'after editItem<br>';
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed (editItem), item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        echo 'editItem success<br>';
        #log_message('error', htmlentities($response['metadata']));
        /*
        echo "<br>=====================================";
        echo "<pre>";
        print_r($response3);
	echo "</pre>";
	 */
    }

    /**
     * Attach SAM PDF to ITEM
     *   More detailed comments in line
     *
     * @param string $uuid, item UUID
     * @param string $version, item Version
     */
    public function attach_pdf_temp_manual_f9dj4k56($uuid='missed', $version='missed')
    {
        #$this->output->enable_profiler(TRUE);
        $errdata['heading'] = "Error";

        if($this->validate_params('pdf', $uuid, $version) == false)
        {
            $errdata['message'] = "Invalid Request";
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . 'Invalid input params.');
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');

        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }

        #ob_end_flush();
        #log_message('error', 'ob_get_level ():');
        #log_message('error', ob_get_level ());
        #ob_start();
        #echo 'good';
        /****************************************************************
         * Important: Respond to Equella so that its workflow can finish
         * Otherwise the editItem will fail.
         *
         * Script goes on after flushing to equella.
         ****************************************************************/

        // Ignore connection-closing by the client/user
        ignore_user_abort(true);
        // Set your timelimit to a length long enough for your script to run,
        // but not so long it will bog down your server in case multiple versions run
        // or this script get's in an endless loop.
        /*
        $content = 'good';         // Get the content of the output buffer

	$len = strlen($content);
	header('Content-Type: text/html; charset=UTF-8');
	header('Content-Encoding: none;');
        header('Connection: close');         // Tell the client to close connection
        header("Content-Length: $len");      // Close connection after $size characters
	echo $content;                       // Output content
	ob_flush();
        flush();                             // Force php-output-cache to flush to flex.

	ob_end_flush();

        sleep (5);
        */
        $success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        echo '<br><br>Finish getItem.';

        unset($response['headers']);
        $item_bean = $response;
        /*
        echo "<br>=====================================";
        echo "<pre>";
        print_r($response);
        echo "</pre>";
	 */
        $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']));

        if(!$this->itemIsSam($this->xmlwrapper))
        {
            $errdata['message'] = "Item is not SAM";
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }

        $sam_array = $this->samXml2Array($this->xmlwrapper);
        $sam_array['status'] = $response['status'];
        $data = array('sam_array' => $sam_array);
        #$data['sam_array']['avail_ref'] = $avail_ref;
        #$data['sam_array']['avail_ver'] = $avail_ver;
        $data['sam_array']['format'] = 'pdf';
        $data['sam_array']['uuid'] = $uuid; #item uuid
        $data['sam_array']['version'] = $version; #item version number

        $approve_date =  $data['sam_array']['metadata']['approved'];
        $tmp_date =  $data['sam_array']['metadata']['approvalDate'];
        if($approve_date == null)
        {
            #$errdata['message'] = '/xml/item/curriculum/assessment/approval/approved is null';
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . 'approved date is null');
            #$this->load->view('sam/showerror_view', $errdata);
            return;
        }
        #$tmp_time = substr($approve_date, strpos($approve_date, 'T')+1, 8);
        #$tmp_time = str_replace(':', '-', $tmp_time);
        #$tmp_date_time = $tmp_date . 'T' . $tmp_time;
        $tmp_date_time = $tmp_date;####
        $tmp_distributed = $data['sam_array']['metadata']['approval'];####

        #log_message('error', 'ob_get_level ():');
        #log_message('error', ob_get_level ());
        ob_start();
        #log_message('error', 'ob_get_level ():');
        #log_message('error', ob_get_level ());

        $success = $this->flexrest->filesCopy($uuid, $version, $response1);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed (filesCopy), item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        echo '<br><br>Finish filesCopy.';

        if(!isset($response1['headers']['location']))
        {
            $errdata['message'] = 'No Location header in response to copy files REST call.';
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        $location = $response1['headers']['location'];
        $filearea_uuid = substr($location, strpos($location, 'file')+5, 36);

        /***************************************************************
         * Check whther there are exiting files, if yes, move them to
         * previous_files and change uuid.
         *
         * <files>
         *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4730C_2014_S2">
         *        <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc000</uuid>
         *    </file>
         * </files>
         *
         * <previous_files>
         *    <file distributed="2014-08-28T14:34:18+09:30" ref="COMP4730C_2014_S2">
         *        <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc100</uuid>
         *    </file>
         * </previous_files>
         ****************************************************************/

        /***************************************************************
         * Muiltiple files for each availability
         *
         * <files>
         *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4730C_2014_S2">
         *        <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc000</uuid>
         *    </file>
         *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4730D_2014_S2">
         *        <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc001</uuid>
         *    </file>
         * </files>
         *
         * Single file for all availabilities
         * <files>
         *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4730C_2014_S2">
         *        <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc000</uuid>
         *    </file>
         *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4730D_2014_S2">
         *        <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc000</uuid>
         *    </file>
         * </files>
         ****************************************************************/

        if(!isset($item_bean['attachments']))
            $item_bean['attachments'] = array();
        #$attachment_count = count($item_bean['attachments']);
        $existing_attachments = $item_bean['attachments'];
        $new_attachments = array();

        $xpath_files = '/xml/item/curriculum/assessment/SAMs/files';

        $node_previous_files = null;
        $xpath_previous_files = '/xml/item/curriculum/assessment/SAMs/previous_files';
        $xpath_files_first_file = $xpath_files . '/file[1]/uuid';

        $xpath_previous_files_first_file = $xpath_previous_files . '/file[1]/uuid';
        $first_files_uuid = $this->xmlwrapper->nodeValue($xpath_files_first_file);
        $first_previous_files_uuid = $this->xmlwrapper->nodeValue($xpath_previous_files_first_file);

        $old_files_exist = $first_files_uuid == null ? false : true;
        $previous_files_exist = $first_previous_files_uuid == null ? false : true;

        $count_old_files = $this->xmlwrapper->numNodes($xpath_files . '/file');
        $count_previous_files = $this->xmlwrapper->numNodes($xpath_previous_files . '/file');
        #echo $old_files_exist . ' dd '; echo $count_old_files; exit();

        $old_file_array = array();
        $previous_file_uuid_suffix = 200;
        $next_previous_file_uuid = '';
        $old_one_file_multi_avails = false;
        $old_avails = array();

        /****************************************************************
         * copy all the <files> to <previous_files>
         ****************************************************************/
        if($old_files_exist)
        {
            $node_previous_files = $this->xmlwrapper->createNodeFromXPath($xpath_previous_files);
            if($previous_files_exist)
                $previous_file_uuid_suffix += $count_previous_files;

            $next_previous_file_uuid = substr($uuid, 0, 33) . sprintf("%03d", $previous_file_uuid_suffix);
            #echo $next_previous_file_uuid; exit();

            for ($j = 1; $j <= $count_old_files; $j++)
            {
                $tmp_xpath_file_uuid = $xpath_files . '/file['.$j.']/uuid';
                $tmp_xpath_file_ref = $xpath_files . '/file['.$j.']/@ref';
                $tmp_xpath_file_distributed = $xpath_files . '/file['.$j.']/@distributed';

                $tmp_file_uuid = $this->xmlwrapper->nodeValue($tmp_xpath_file_uuid);
                $tmp_file_ref = $this->xmlwrapper->nodeValue($tmp_xpath_file_ref);
                $tmp_file_distributed = $this->xmlwrapper->nodeValue($tmp_xpath_file_distributed);

                $old_file_array[$j-1]['uuid'] = $tmp_file_uuid;
                $old_file_array[$j-1]['ref'] = $tmp_file_ref;
                $old_file_array[$j-1]['dist'] = $tmp_file_distributed;

                $old_avails[$j-1] = $tmp_file_ref;
            }

            if($count_old_files > 1 &&
                $old_file_array[0]['uuid'] == $old_file_array[1]['uuid'] &&
                $old_file_array[0]['uuid'] == $old_file_array[$count_old_files-1]['uuid'])
                $old_one_file_multi_avails = true;
            else
                $old_one_file_multi_avails = false;

            #Append the files to previous_files subtree, change uuid
            for ($j = 0; $j < $count_old_files; $j++)
            {
                $tmp_node_previous_file = $this->xmlwrapper->createNode($node_previous_files, "file");
                $tmp_node_previous_file_uuid = $this->xmlwrapper->createNode($tmp_node_previous_file, "uuid");
                $tmp_node_previous_file_ref = $this->xmlwrapper->createAttribute($tmp_node_previous_file, "ref");
                $tmp_node_previous_file_distri = $this->xmlwrapper->createAttribute($tmp_node_previous_file, "distributed");

                $tmp_node_previous_file_ref->nodeValue = $old_file_array[$j]['ref'];
                $tmp_node_previous_file_distri->nodeValue = $old_file_array[$j]['dist'];

                $tmp_node_previous_file_uuid->nodeValue = $next_previous_file_uuid;
                for($i=0; $i<count($existing_attachments); $i++)
                {
                    if($existing_attachments[$i]['uuid'] == $old_file_array[$j]['uuid'])
                        $existing_attachments[$i]['uuid'] = $next_previous_file_uuid;
                }
                if($count_old_files>1 && $old_one_file_multi_avails == false)
                {
                    $previous_file_uuid_suffix ++;
                    $next_previous_file_uuid = substr($uuid, 0, 33) . sprintf("%03d", $previous_file_uuid_suffix);
                }
            }
        }

        #print_r(simplexml_import_dom($node_previous_files)->asXML());exit();


        $this->xmlwrapper->deleteNodeFromXPath($xpath_files);
        $node_files = $this->xmlwrapper->createNodeFromXPath($xpath_files);
        #$distributed = $approve_date; #new DateTime("now");
        #$approve_time = $distributed->format('c');
        #$item_bean['attachments'] = null;
        $file_uuid = $uuid;
        $largest_suffix_number = 0;

        #find out the largest suffix number in uuid (last three chars)
        for ($j = 0; $j < $count_old_files; $j++)
        {
            $file_suffix_number = intval(substr($old_file_array[$j]['uuid'], 33, 3));
            if($file_suffix_number > $largest_suffix_number)
                $largest_suffix_number = $file_suffix_number;
        }

        $new_one_file_multi_avails = false;
        $new_avails = array();
        $i = 0;
        foreach ($data['sam_array']['metadata']['availability'] as $availdata  )
        {
            $new_avails[$i] = $availdata['avRef'];
            $i ++;
        }
        if($data['sam_array']['metadata']['multiple'] != 'yes' && count($new_avails) > 1)
            $new_one_file_multi_avails = true;

        $attachment_count = 0;
        foreach ($data['sam_array']['metadata']['availability'] as $availdata  )
        {
            $data['sam_array']['avail_ref'] = $availdata['avRef'];
            $data['sam_array']['avail_ver'] = $availdata['avVersion'];
            if($data['sam_array']['metadata']['multiple'] == 'yes' || $attachment_count == 0)
            {
                ob_start();
                $this->load->view('sam/showsam_view', $data);
                $html = ob_get_contents();
                ob_end_clean();
                $pdfclsname = 'pdf_class'.$attachment_count;
                $this->load->library('pdf/pdf_class', null, $pdfclsname);
                #$this->pdf_class->SetDisplayMode('fullpage');
                $this->$pdfclsname->setFooter('{PAGENO} / {nb}');
                $this->$pdfclsname->WriteHTML($html);
                if($data['sam_array']['metadata']['multiple'] == 'yes' || count($data['sam_array']['metadata']['availability']) === 1)
                {
                    $filename = $data['sam_array']['avail_ref'] . '_' . $tmp_date_time . '.pdf';
                }
                else
                {
                    $filename = $data['sam_array']['metadata']['availability_name'];
                    if(substr($filename, -2) == '. ')
                        $filename = substr($filename, 0, strlen($filename)-2);
                    if(substr($filename, -1) == '.')
                        $filename = substr($filename, 0, strlen($filename)-1);
                    $filename = str_replace('.', ' ', $filename);
                    $filename = str_replace('(', ' ', $filename);
                    $filename = str_replace(')', ' ', $filename);
                    $filename = str_replace('/', ' ', $filename);
                    $filename = str_replace(',', ' ', $filename);
                    $filename = str_replace(':', ' ', $filename);
                    $filename = str_replace('[', ' ', $filename);
                    $filename = str_replace(']', ' ', $filename);
                    $filename = preg_replace('/\s+/', ' ', $filename);
                    if(strlen($filename) > 70)
                        $filename = substr($filename, 0, 70);
                    if(substr($filename, -1) == ' ')
                        $filename = substr($filename, 0, strlen($filename)-1);
                    $filename = str_replace(' ', '_', $filename);
                    $filename = $filename . '_' . $tmp_date_time . '.pdf';
                }
                $pdf_content = $this->$pdfclsname->Output($filename, 'S');
                $success = $this->flexrest->fileUpload($filearea_uuid, $filename, $pdf_content, $response2);
                if(!$success)
                {
                    $errdata['message'] = $this->flexrest->error;
                    log_message('error', 'Attaching SAM pdf failed (fileUpload), item uuid: ' . $uuid . ', error: ' . $errdata['message']);
                    $this->load->view('sam/showerror_view', $errdata);
                    return;
                }
                echo '<br><br>Finish fileUpload!';
                /***************************************************************
                 * Determine the file uuid,
                 *    - reuse exiting uuid if topic availability is the same
                 *    - otherwise generate new file uuid
                 *
                 ***************************************************************/

                if($count_old_files > 0)
                {
                    $file_uuid = null;
                    #$largest_suffix_number = 0;
                }
                else
                {
                    #No old attachments, generagte new file uuid
                    $file_uuid = sprintf("%03d", $attachment_count);
                    $file_uuid = substr($uuid, 0, 33) . $file_uuid;
                }

                $reuse_old_file_uuid = true;
                /***************************************************************
                 * Old avails:
                 *   A_B_C   1 file uuid-1
                 * New avails:
                 *   A_B_C_D 1 file uuid-1 (reuse exiting uuid)
                 *
                 * Old avails:
                 *   A_B_C   1 file uuid-1
                 * New avails:
                 *   B_C     1 file uuid-2 (generate new uuid)
                 ***************************************************************/
                if($old_one_file_multi_avails == true && $new_one_file_multi_avails == true)
                {
                    if(count(array_diff($old_avails, $new_avails)) > 0)
                    {
                        #There is new availability added in, generate new file uuid
                        $reuse_old_file_uuid = false;
                    }
                    else
                    {
                        $reuse_old_file_uuid = true;
                        $file_uuid = $old_file_array[0]['uuid'];
                    }
                }

                /*
                echo '<pre>';
                echo '$old_one_file_multi_avails ' . $old_one_file_multi_avails;echo '<br>';
                echo '$new_one_file_multi_avails ' . $new_one_file_multi_avails;echo '<br>';
                echo '$file_uuid ' . $file_uuid;echo '<br>';
                print_r($old_avails);echo '<br>';
                print_r($new_avails);echo '<br>';
                echo '</pre>';exit();
                */

                /***************************************************************
                 * Old avails:
                 *   A_B 1 file uuid-1
                 * New avails:
                 *   A   1 file uuid-2
                 *   B   1 file uuid-3
                 ***************************************************************/
                if($old_one_file_multi_avails == true && $new_one_file_multi_avails == false)
                {
                    #generate new file uuid
                    $reuse_old_file_uuid = false;
                }

                /***************************************************************
                 * Old avails:
                 *   A   1 file uuid-1
                 *   B   1 file uuid-2
                 * New avails:
                 *   B_C 1 file uuid-2 (reuse uuid of common avail, generate new one if no common avail )
                 ***************************************************************/
                if($old_one_file_multi_avails == false && $new_one_file_multi_avails == true)
                {
                    #
                    $reuse_old_file_uuid = true;
                    for ($j = 0; $j < $count_old_files; $j++)
                    {
                        for($i = 0; $i < count($new_avails); $i++)
                        {
                            if($new_avails[$i] == $old_file_array[$j]['ref'])
                                $file_uuid = $old_file_array[$j]['uuid'];
                            break;
                        }
                        if($file_uuid != null)
                            break;
                    }
                }

                /***************************************************************
                 * Old avails:
                 *   A   1 file uuid-1
                 *   B   1 file uuid-2
                 * New avails:
                 *   A   1 file uuid-1
                 *   C   1 file uuid-3
                 *
                 * Example:
                 * <previous_files>
                 *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4700A_2014_S2">
                 *       <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc200</uuid>
                 *    </file>
                 *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4700B_2014_S2">
                 *      <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc201</uuid>
                 *    </file>
                 *    <file distributed="2014-07-22T13:59:44+0930" ref="COMP4700C_2014_S2">
                 *      <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc202</uuid>
                 *    </file>
                 *  </previous_files>
                 *  <files>
                 *    <file distributed="2014-07-23T13:59:44+0930" ref="COMP4700A_2014_S2">
                 *      <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc000</uuid>
                 *    </file>
                 *    <file distributed="2014-07-23T13:59:44+0930" ref="COMP4700D_2014_S2">
                 *      <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc003</uuid>
                 *    </file>
                 *    <file distributed="2014-07-23T13:59:44+0930" ref="COMP4700C_2014_S2">
                 *      <uuid>dd96fbba-b720-4b00-9180-bfeeab3dc002</uuid>
                 *    </file>
                 *  </files>
                 ***************************************************************/
                #Reuse exiting file uuid
                if($file_uuid === null && $reuse_old_file_uuid == true)
                {
                    for ($j = 0; $j < $count_old_files; $j++)
                    {
                        #For the same avilability, the uuid must remain the same
                        if($data['sam_array']['avail_ref'] == $old_file_array[$j]['ref'])
                        {
                            $file_uuid = $old_file_array[$j]['uuid'];
                            #echo '111 ' . $file_uuid; exit();
                            #if(intval(substr($file_uuid, 32, 3)) > $largest_suffix_number)
                            #    $largest_suffix_number = intval(substr($file_uuid, 32, 3));
                            break;
                        }
                    }
                }
                #the availability is new so it is not found in the exiting files, so assign new uuid to it
                if($file_uuid === null)
                {
                    $largest_suffix_number ++;
                    $file_uuid = substr($uuid, 0, 33) . sprintf("%03d", $largest_suffix_number);
                }
                $new_attachments[$attachment_count] = array('type'=>'file',
                    'filename'=>$filename,
                    'description'=>$filename,
                    'uuid'=>$file_uuid);
                #$item_bean['attachments'][$attachment_count] = array('type'=>'file',
                #                              'filename'=>$filename,
                #                              'description'=>$filename,
                #                              'uuid'=>$file_uuid);
            }
            $node_file = $this->xmlwrapper->createNode($node_files, "file");
            $node_uuid = $this->xmlwrapper->createNode($node_file, "uuid");
            $node_ref = $this->xmlwrapper->createAttribute($node_file, "ref");
            $node_distri = $this->xmlwrapper->createAttribute($node_file, "distributed");
            $node_uuid->nodeValue = $file_uuid;
            $node_ref->nodeValue = $data['sam_array']['avail_ref'];
            #$node_distri->nodeValue = $distributed->format('c');
            $node_distri->nodeValue = $tmp_distributed; ####$approve_date;
            $attachment_count ++;
        }


        $item_bean['attachments'] = array_merge($new_attachments, $existing_attachments);
        $item_bean['metadata'] = $this->xmlwrapper->__toString();

        /*
        echo '<pre>';
        #print_r($new_attachments);echo '<br>';
        #print_r($existing_attachments);echo '<br>';
        echo $item_bean['metadata']; echo '<br>';
        #print_r(json_decode(json_encode($item_bean['metadata']), true));echo '<br>';
        print_r($item_bean['attachments']);
        log_message('error', $item_bean['metadata']);
        echo '</pre>';
        exit();
        */

        $success = $this->flexrest->editItem($uuid, $version, $item_bean, $response3, $filearea_uuid);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed (editItem), item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        echo '<br><br>Finish Edit Item!';
        echo '<br><br>Completed!';
        #log_message('error', htmlentities($response['metadata']));
        /*
        echo "<br>=====================================";
        echo "<pre>";
        print_r($response3);
	echo "</pre>";
	 */
    }

    #testing
    public function test16yt7i()
    {
        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');

        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        $uuid = 'c58d96a2-2541-4679-8dca-a264d2b4fbd6';
        $success = $this->flexrest->getItem($uuid, $version=1, $response);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }

        echo "<pre>";
        print_r($response);
        echo "</pre>";
        #log_message('error', htmlentities($response['metadata']));

        $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']));

        $sam_array = $this->samXml2Array($this->xmlwrapper);
        echo "<pre>";
        print_r($sam_array);
        echo "</pre>";
        exit();
        unset($response['headers']);
        $item_bean = $response;
        #unset($item_bean["uuid"] );
        #unset($item_bean["version"] );
        #unset($item_bean["drm"] );
        $item_bean["attachments"] = null;
        $success = $this->flexrest->editItem($uuid, 1, $item_bean, $response1);
        #$success = $this->flexrest->createItem($item_bean, $response1, null, 'true');
        if(!$success)
        {
            #$errdata['message'] = $this->flexrest->error;
            #log_message('error', ' createItem failed' . ', error: ' . $errdata['message']);
            #log_message('error', 'Metadata: ' . $item_bean['metadata']);
            #$this->load->view('reading_listmgr/showerror_view', $errdata);
            $result['error_info'] = $this->flexrest->error;
            echo "<pre>";
            print_r($result);
            print_r($response1);
            echo "</pre>";
            return;
        }
        exit();
        echo "<pre>";
        print_r($response);
        echo "</pre>";
        log_message('error', htmlentities($response['metadata']));

        $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']));

        if(!$this->itemIsSam($this->xmlwrapper))
        {
            $errdata['message'] = "Item is not SAM";
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }

        $sam_array = $this->samXml2Array($this->xmlwrapper);
        echo "<pre>";
        print_r($sam_array);
        echo "</pre>";
    }
}
/* End of file */
