<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class sMap extends CI_Controller 
{
	 public function __construct()
     {
		parent::__construct();
		$ci =& get_instance();
		$ci->load->config('flex');
		$this->load->helper('url');
		$this->load->library('flexrest/flexrest');
		$this->load->model('ocf/ocf_model');
	 }
	 
	 public function getStaticMap($courseCode)
	 {
		$courseCode = strtoupper($courseCode);
		if(!$this->validate_params($courseCode))
		{
			$errdata['message'] = 'Invalid course code';
            $this->load->view('ocf/showerror_view', $errdata);
            return;
		}    
		
		#check down time before authentication through FLEX
		$down_notice = false;
		$down_notice = $this->ocf_model->db_chk_notice();
		if($down_notice != false)
		{
			#$this->error_info($down_notice['message']);
			if ($down_notice['message'] == '')
				$down_notice['message'] = 'Online Curriculum Framework is temporarily unavailable, please try again later.';
			#echo $down_notice['message'];
			$errdata['message'] = $down_notice['message'];
			//$errdata['heading'] = "Notice";
			$this->load->view('ocf/showerror_view', $errdata);
			$this->output->_display();
			return;
		}
		
		#check course code
		$check_course_code = $this->ocf_model->db_get_courseInfo($courseCode);
		if(!$check_course_code)
		{
			$errdata['message'] = 'course code not valid';
			$this->load->view('ocf/showerror_view', $errdata);
			return;
		}
		$course_year = $check_course_code[0]['course_total_year'];
		//echo $course_year .'<br/>';
		$course=array();
		$data = array('course' =>$this->getStaticTopics($courseCode, (int)$course_year, $course, 1));
		unset($course);
		/*echo 'data: <pre>';
		print_r($data);
		echo '</pre>';*/
		$this->load->view('ocf/sMap_view', $data);
		
		 
	 }
	 
	 private function getStaticTopics($courseCode, $year_level, $course, $current_depth)
	 {
		while($current_depth <= $year_level)
		{
			 $db_topics = $this->ocf_model->db_get_static_topics_html($current_depth, $courseCode);
			 for($i=0; $i<count($db_topics); $i++)
			 {
				 $course[$current_depth][$i+1] = $db_topics[$i];
			 }
			 $current_depth++;
			 $this->getStaticTopics($courseCode, $year_level, $course, $current_depth);	 
		 }
		 $course['course_code'] = $courseCode;
		 return $course;
		 
	 }
	 /**
     * Validate incoming parameters
     *
     * @param string $coursecode
     */
    private function validate_params($courseCode)
    {
        if(strcmp($courseCode, 'missed')==0 ||is_numeric($courseCode) )
		{
            return false;
		}
        return true;
    }
}