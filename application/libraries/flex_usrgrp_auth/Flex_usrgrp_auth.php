<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


/**
 * Check whether a user is in certain preconfigured FLEX user groups.
 * 
 *  Provision example:
 * 
 *  $config['flex_usrgrp_auth'] = array(
 *    'map_md' => array(
 *       0 => 'SOM-MD viewer grp',
 *       1 => 'EQ viewer grp'
 *     ),
 *    'ereading' => array(
 *       0 => 'LIB eReadings grp',
 *       1 => 'LIB Flextra grp'
 *      )
 *  );
 */

class Flex_usrgrp_auth
{
    
    function authorized($application, $userid=null)
    {
        $ci =& get_instance();
        $ci->load->config('flex');
        $flex_usrgrp_auth = $ci->config->item('flex_usrgrp_auth');
        
        if(!isset($flex_usrgrp_auth[$application]) || !is_array($flex_usrgrp_auth[$application]))
            return false;
        $configured_groups = $flex_usrgrp_auth[$application];
            
        if(session_id() == '')
            session_start();
        
        $session_var_name = 'flex_auth_' . $application;
        
        if(isset($_SESSION[$session_var_name]) && $_SESSION[$session_var_name]=='success')
            return true;

        if(isset($_SESSION[$session_var_name]) && $_SESSION[$session_var_name]=='failed')
        {
            return false;
        }

        $_SESSION[$session_var_name] = 'failed';

        if($userid == null)
        {
            if(!isset($_SERVER['REMOTE_USER']))
            {
                return false;
            }
            $userid = $_SERVER['REMOTE_USER'];
        }
        
        $ci->load->library('flexsoap/flexsoap');
        if(!$ci->flexsoap->success)
        {
            log_message('error', $this->flexsoap->error_info);
            return false;
        }

        $groups = $ci->flexsoap->getGroupsByUser($userid);
        if(!$ci->flexsoap->success)
        {
            log_message('error', $this->flexsoap->error_info);
            return false;
        }

        #must in one of the user groups to proceed.
        for($i=0; $i<count($configured_groups); $i++)
        {
            if(strpos($groups, $configured_groups[$i]) === false)
            {
                $_SESSION[$session_var_name] = 'failed';
                continue;
            }
            else
            {
                $_SESSION[$session_var_name] = 'success';
                return true;
            }
        }
        return false;
    }
}

?>
