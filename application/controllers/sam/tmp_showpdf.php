<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Showpdf extends CI_Controller {

    
    public function index($uuid='missed', $version='missed')
    {
        
        if($this->validate_params($uuid, $version) == false)
        {
            $data['heading'] = "Error";
            $data['message'] = "Invalid Request";
            $this->load->view('sam/showerror_view', $data);
            return;
        }
                
        $this->load->helper('url');
        $this->load->library('flexrest/flexrest_class');
        
        $success = $this->flexrest_class->processClientCredentialToken();
        if(!$success)
        {
            $data['heading'] = "Error";
            $data['message'] = $this->flexrest_class->error;
            $this->load->view('sam/showerror_view', $data);
            return;
        }    
        
        $success = $this->flexrest_class->getItem($uuid, $version, $response);
        if(!$success)
        {
            $data['heading'] = "Error";
            $data['message'] = $this->flexrest_class->error;
            $this->load->view('sam/showerror_view', $data);
            return;
        }    
        
        #echo'<pre>';
        #print_r($response);
        #
        #echo (string)$response['metadata'];
        #echo'</pre>';
        #
        
        $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']));
        $sam_array = $this->samXml2Array($this->xmlwrapper);
        /*
        if($this->xmlwrapper->nodefound === false)
        {
            $data['heading'] = "Error";
            $data['message'] = "Metadata missing";
            $this->load->view('sam/showerror_view', $data);
            return;
        }*/
        
        #echo'<pre>';
        #print_r($sam_array);
        #echo'</pre>';
        
        ob_start();
        
        $data = array('sam_array' => $sam_array, 'sam_string' => (string)$response['metadata']);
        
        $this->load->view('sam/showsam_view', $data);
        
        $html = ob_get_contents();
        
        ob_end_clean();
        
        #echo $html;
        
        $this->load->library('pdf/pdf_class'); 

        #$this->pdf_class->SetDisplayMode('fullpage');

        $this->pdf_class->WriteHTML($html);
        $this->pdf_class->Output();
        
        
        
        #array_walk_recursive($sam_array, '$this->verify_metadata');
    }
    
    function samXml2Array($itemXml='') 
    { 

        $topicCode = '/xml/item/uni/topic/used_in/topics/code';
        $topicTitle = '/xml/item/uni/topic/used_in/topics/title';
        $topicUnits = '/xml/item/uni/topic/used_in/topics/units';
        $topicSchool = '/xml/item/uni/topic/used_in/topics/school';

        $approval = '/xml/item/uni/topic/assessment/distributed';

        $samsArray['metadata']['tcode'] = $itemXml->nodeValue($topicCode);
        $samsArray['metadata']['topicTitle'] = $itemXml->nodeValue($topicTitle);
        $samsArray['metadata']['topicUnits'] = $itemXml->nodeValue($topicUnits);
        $samsArray['metadata']['topicSchool'] = $itemXml->nodeValue($topicSchool);

        $samsArray['metadata']['approval'] = $itemXml->nodeValue($approval);

        // get availabilities information
        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/uni/topic/used_in/availabilities/availability'); $j++) 
        {

            $avYear = '/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/year';
            $avDuration = '/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/duration';
            $avLocation = '/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/location';
            $avCoordName = '/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/coordinators/coordinators/coordinator/name';
            $avCoordPhone = '/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/coordinators/coordinators/coordinator/phone';
            $avCoordLocation = '/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/coordinators/coordinators/coordinator/location';


            $samsArray['metadata']['availability'][$j]['avYear'] = $itemXml->nodeValue($avYear);
            $samsArray['metadata']['availability'][$j]['avDuration'] = $itemXml->nodeValue($avDuration);
            $samsArray['metadata']['availability'][$j]['avLocation'] = $itemXml->nodeValue($avLocation);
            $samsArray['metadata']['availability'][$j]['avCoordName'] = $itemXml->nodeValue($avCoordName);
            $samsArray['metadata']['availability'][$j]['avCoordPhone'] = $itemXml->nodeValue($avCoordPhone);
            $samsArray['metadata']['availability'][$j]['avCoordLocation'] = $itemXml->nodeValue($avCoordLocation);

        }


        // assessable tasks
        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/uni/topic/outcomes/outcome'); $j++) 
        {

            $name = '/xml/item/uni/topic/outcomes/outcome['.$j.']/name';
            $samsArray['metadata']['topicalign'][$j]['name'] = $itemXml->nodeValue($name);


            for ($k = 1; $k <= $itemXml->numNodes('/xml/item/uni/topic/outcomes/outcome['.$j.']/assessments/assessment'); $k++) 
            {

                    $assessment = '/xml/item/uni/topic/outcomes/outcome['.$j.']/assessments/assessment['.$k.']';
                    //$samsArray['metadata']['topicalign'][$j]['assessment'][$k] ='text'; 

                    $samsArray['metadata']['topicalign'][$j]['assessment'][$k] = $itemXml->nodeValue($assessment); 

            }

                //$samsArray['metadata']['topicalign'][$j]['numItems'] = [$k]; 

        }

        // graduate qualities
        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/uni/course/grad_attributes/grad_attribute'); $j++) 
        {

            $name = '/xml/item/uni/course/grad_attributes/grad_attribute['.$j.']/name';
            $code = '/xml/item/uni/course/grad_attributes/grad_attribute['.$j.']/code';
            $samsArray['metadata']['gradattribute'][$j]['name'] = $itemXml->nodeValue($name);
            $samsArray['metadata']['gradattribute'][$j]['code'] = $itemXml->nodeValue($code);


            for ($k = 1; $k <= $itemXml->numNodes('/xml/item/uni/course/grad_attributes/grad_attribute['.$j.']/assessments/assessment'); $k++) {

                    $assessment = '/xml/item/uni/course/grad_attributes/grad_attribute['.$j.']/assessments/assessment['.$k.']';
                    //$samsArray['metadata']['topicalign'][$j]['assessment'][$k] ='text'; 

                    $samsArray['metadata']['gradattribute'][$j]['assessment'][$k] = $itemXml->nodeValue($assessment); 

            }

                //$samsArray['metadata']['topicalign'][$j]['numItems'] = [$k]; 

        }

        // topic alignment
        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/uni/topic/assessment/items/item'); $j++) 
        {

            $name = '/xml/item/uni/topic/assessment/items/item['.$j.']/name';
            $proportion = '/xml/item/uni/topic/assessment/items/item['.$j.']/proportion';
            $deadline = '/xml/item/uni/topic/assessment/items/item['.$j.']/deadline';
            $penalties = '/xml/item/uni/topic/assessment/items/item['.$j.']/penalties';
            $return = '/xml/item/uni/topic/assessment/items/item['.$j.']/return_date';



            $samsArray['metadata']['assessment'][$j]['name'] = $itemXml->nodeValue($name);
            $samsArray['metadata']['assessment'][$j]['proportion'] = $itemXml->nodeValue($proportion);
            $samsArray['metadata']['assessment'][$j]['deadline'] = $itemXml->nodeValue($deadline);
            $samsArray['metadata']['assessment'][$j]['penalties'] = $itemXml->nodeValue($penalties);
            $samsArray['metadata']['assessment'][$j]['return'] = $itemXml->nodeValue($return);

        }

        $resubmissionPermitted = '/xml/item/uni/topic/assessment/resubmission/permitted';
        $resubmissionDetail = '/xml/item/uni/topic/assessment/resubmission/detail';

        $academicIntegrity = '/xml/item/uni/topic/assessment/integrity'; ####

        $pass = '/xml/item/uni/topic/assessment/pass';

        $consideration = '/xml/item/uni/topic/assessment/special_contact';

        $samsArray['metadata']['pass'] = $itemXml->nodeValue($pass);
        $samsArray['metadata']['consideration'] = $itemXml->nodeValue($consideration);

        $samsArray['metadata']['resubmissionPermitted'] = $itemXml->nodeValue($resubmissionPermitted);
        
        if(strnatcasecmp($samsArray['metadata']['resubmissionPermitted'], 'Yes') == 0)
            $samsArray['metadata']['resubmissionDetail'] = $itemXml->nodeValue($resubmissionDetail);
        else
            $samsArray['metadata']['resubmissionDetail'] = '';

        $samsArray['metadata']['academicIntegrity'] = $itemXml->nodeValue($academicIntegrity);		

        return $samsArray;

    }
    
    protected function validate_params($uuid, $version)
    {
        if(strcmp($uuid, 'missed')==0 || strlen($uuid) != 36)
            return false;
        
        if(strcmp($version, 'missed')==0 || !is_numeric($version))
            return false;
        
        return true;
    }
    	
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */