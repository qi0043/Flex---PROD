<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Codeigniter's error logging hooked up with set_error_handler, and php will fire handler 
 * whatever the error_reporting value is.
 * CI just logs everything that comes in if CI's internal error level demands logging. (the 
 * log_threshold config value 1, see the function called by php error handler.)
 * 
 * This class adds conditions to determine whether to generate PHP ERR logs.
 */

// ------------------------------------------------------------------------


class MY_Exceptions extends CI_Exceptions 
{
    /**
     * Exception Logger
     *
     * This function logs PHP generated error messages
     *
     * @access	private
     * @param	string	the error severity
     * @param	string	the error string
     * @param	string	the error filepath
     * @param	string	the error line number
     * @return	string
     */
    function log_exception($severity, $message, $filepath, $line) 
    {
        #$current_reporting = error_reporting();
        #$should_report = $current_reporting & $serverity;
        #
        #$should_report = isset($_SESSION['GEN_PHPERR_LOGS']) ? $_SESSION['GEN_PHPERR_LOGS'] : true;
        //
        //mPDF generates lots of PHP ERR logs, disable the logs here.
        if (substr_count($filepath, 'pdf/mpdf') > 0)
                return;

        #if ($shoud_report) 
        {
            $severity = ( ! isset($this->levels[$severity])) ? $severity : $this->levels[$severity];
            log_message('error', 'Severity: '.$severity.'  --> '.$message. ' '.$filepath.' '.$line, TRUE);
        }
    }
}

