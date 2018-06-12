<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


/**
 * Check user permssions.
 * 
 */

class Permission
{
    protected $CI;
    public   $success=true, $error_info='', $ret_val = '';
    
    /**
     * Check user permssions for OCF application.
     * Check LDAP user groups and FLEX internal groups if necessary.
     */
    public function get_ocf_permission($fan)
    {
	if(session_id() == '')
            session_start();
        if(isset($_SESSION['ocf_validgrouplist']))
             return $_SESSION['ocf_validgrouplist'];
        
	#LDAP groups.
        $this->CI =& get_instance();
        $this->CI->load->library('ldap/ldap');
        if(!$this->CI->ldap->success)
        {    
            $this->success = false;
            $this->error_info = 'LDAP error!';
            return;
        }
		
		$ldap_user = $this->CI->ldap->get_attributes($fan);
		
		$_SESSION['username'] = $ldap_user['name'];
		
	
        $ldap_groups = $this->CI->ldap->get_groups_of_member($fan);
        if(!$this->CI->ldap->success)
        {    
            $this->success = false;
            $this->error_info = 'LDAP error!';
            return;
        }
        
        #$ldap_groups = $ldap_info['groups'];
        #$ldap_ou = $ldap_info['ou'];
        #$flindersPersonType = $ldap_info['flindersPersonType'];
        $result_permissions = array();
        
        $config_ldap_groups = $this->CI->config->item('ocf_ldap_groups');
        foreach($config_ldap_groups as $key1 => $cfg_permission)
        {
            foreach($ldap_groups as $ldap_grp)
            {
                if(strpos($ldap_grp, 'cn='.$key1) !== false)
                {
                    $result_permissions = array_unique (array_merge ($result_permissions, $cfg_permission));
                    break;
                }
            }  
        }    
            
	#FLEX internal groups.
	$config_ocf_chk_flex_groups = $this->CI->config->item('ocf_chk_flex_groups');
	
	#if($config_ocf_chk_flex_groups == true) // check in FLEX to pick up users in irregular LDAP groups, eg David Hunter
	if(empty($result_permissions) && $config_ocf_chk_flex_groups == true)
	{
	    $config_flex_groups = $this->CI->config->item('ocf_flex_groups');
	    $this->CI->load->library('flexrest/flexrest');
	    $success = $this->CI->flexrest->processClientCredentialToken();
	    if(!$success)
	    {
		$this->success = false;
		$this->error_info = $this->CI->flexrest->error;
		log_message('error', 'Failed to get permission of OCF' . ', error: ' . $this->error_info);
		return;
	    }
	    $success = $this->CI->flexrest->listGroups($response, $fan);
	    if(!$success)
	    {
		$this->success = false;
		$this->error_info = $this->CI->flexrest->error;
		log_message('error', 'Failed to get permission of OCF' . ', error: ' . $this->error_info);
		return;
	    }
	    $group_count = intval($response['available']);
	    #echo '<pre>';print_r($response);echo '</pre>';
	    if($group_count > 0)
	    {
		foreach($config_flex_groups as $key1 => $cfg_permission)
		{
		    foreach($response['results'] as $flex_group)
		    {
			if(strpos($flex_group['name'], $key1) !== false)
			{
			    $result_permissions = array_unique (array_merge ($result_permissions, $cfg_permission));
			    break;
			}
		    }  
		} 
	    }
	}
        
        $_SESSION['ocf_validgrouplist'] = $result_permissions;
		$_SESSION['ocf_ldapauth'] = true;
        
        return $result_permissions;

    }
    
    
    #Unused
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
