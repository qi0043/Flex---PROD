<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class to support course management: 
 *   
 *   Upload the courses to FLEX to have the up to date information e.g. the number of students of an availability
 *   There is a weekly CRON job calling this function.
 */
class Courses extends CI_Controller {

	#protected $logger_rollover;
        #protected $logger_activation;
        protected $soapusername;
        protected $soappassword;
        protected $soapparams;
	
        public function bulkImportCourses()
	{
            if($this->input->is_cli_request() == false)
            {
                    exit();
            }
            
            $this->load->model('reading_course/course_model');
                
            $courses = $this->course_model->db_get_courses();
            #echo $courseCsv;exit();
            if($courses === false)
                return;
            
            $ci =& get_instance();
            $ci->load->config('flex');
            #$loggings = $ci->config->item('rolloverlog');

            $this->soapusername = $ci->config->item('soap_coursemgt_username');
            $this->soappassword = $ci->config->item('soap_coursemgt_password');
            $this->soapparams = array('username'=>$this->soapusername, 'password'=>$this->soappassword);
            
            $this->load->library('flexsoap/flexsoap',$this->soapparams);
            if(!$this->flexsoap->success)
            {
                log_message('error', 'bulkImportCourses with error: ' . $this->flexsoap->error_info);
                $message = 'Error: failed to connect to FLEX: ' . $this->flexsoap->error_info;
                $this->course_model->db_set_importe_log('E', $message);
                $errdata['message'] = $this->flexsoap->error_info;
                $errdata['heading'] = "Internal error";
                $this->load->view('reading_rollover/showerror_view', $errdata);
                $this->output->_display();
                exit();
                
            }
            
            $course_csv_head = '"Name","Description","Code","Citation","Start","End","Students","Type","DepartmentName"' . "\n";
            $batch = 40;
            $count = count($courses);
            $loops = (int)($count/$batch);
            $remain = $count % $batch;
            #echo 'count='. $count .' loops='.$loops. ' remain='.$remain;exit();
            for($i=0; $i<=$loops; $i++)
            {
                $course_csv_content = '';
                
                if($i==$loops)
                    $size = $remain;
                else
                    $size = $batch;
                
                for ($j=0; $j<$size; $j++)
                {
                    $row = $courses[$i*$batch+$j];
                    #echo ($i*$batch+$j) . '<br>';
                    $course_csv_content .= '"' . $row['Name'] . '"' . ','
                                   . '"' . $row['Description'] . '"' . ','
                                   . '"' . $row['Code'] . '"' . ','
                                   . '"' . $row['Citation'] . '"' . ','
                                   . '"' . $row['Start'] . '"' . ','
                                   . '"' . $row['End'] . '"' . ','
                                   . '"' . $row['Students'] . '"' . ','
                                   . '"' . $row['Type'] . '"' . ','
                                   . '"' . $row['DepartmentName'] . '"' . "\n";

                }

                if($course_csv_content != '')
                {
                    $this->flexsoap->bulkImportCourses($course_csv_head . $course_csv_content);
                    if(!$this->flexsoap->success)
                    {
                        log_message('error', 'bulkImportCourses with error: ' . $this->flexsoap->error_info);
                        $message = 'Error: bulkImportCourses with error: ' . $this->flexsoap->error_info;
                        $this->course_model->db_set_importe_log('E', $message);
                        $errdata['message'] = $this->flexsoap->error_info;
                        $errdata['heading'] = "Internal error";
                        $this->load->view('reading_rollover/showerror_view', $errdata);
                        $this->output->_display();
                        exit();        
                    }

                    #echo 'Imported ' . $size. ' courses, i=' . $i . '<br>';
                    #echo $courseCsv;
                }
            }
            $message = 'Completed: bulk uploaded courses: ' . $count;
            $this->course_model->db_set_importe_log('S', $message);
	}
}  
