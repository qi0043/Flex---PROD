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
     * 
     * E.g. configuration:
     * $config['ocf_ldap_groups'] = array(
     *   "som-staff" => array(
     *	        0 => "md"
     *       ),
     *   "nursing-staff" => array(
     *  	0 => "bmid"
     *       ),
     *   "flextra" => array(
     *   	0 => "bspth",
     *   	1 => "baud",
     *          2 => "md",
     *          3 => "bmid"
     *       )
     *   );
     * 
     */
    public function get_ocf_permission($fan)
    {
	if(session_id() == '')
            session_start();
        if(isset($_SESSION['ocf_validgrouplist']))
             return $_SESSION['ocf_validgrouplist'];
        
	#LDAP groups.
        $this->CI =& get_instance();
		$this->CI->load->config('flex');
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
	#if(empty($result_permissions) && $config_ocf_chk_flex_groups == true)
	
	if($config_ocf_chk_flex_groups == true) // check in FLEX to pick up users in irregular LDAP groups, eg David Hunter
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
    

    /*
     *  OCF management groups, search FAN in collection of 'OCF groups'
     *  to see if user in:
     *        * course (MD)
     *        * topic (MMED8302)
     *        * management (AS-LIFT)
     */
    public function get_ocf_mgm_groups($fan)
    {
	if(session_id() == '')
            session_start();
	
        #if(isset($_SESSION['ocf_usr_mgm_groups']))
        #     return $_SESSION['ocf_usr_mgm_groups'];
	
	$this->CI =& get_instance();
	$this->CI->load->library('flexrest/flexrest');
	$success = $this->CI->flexrest->processClientCredentialToken();
	if(!$success)
	{
	    $this->success = false;
	    $errdata['message'] = $this->CI->flexrest->error;
	    log_message('error', 'Failed to access flex: ' . $errdata['message']);
	    #$this->load->view('reading_listmgr/showerror_view', $errdata);
	    return false;
	}

	$success = $this->CI->flexrest->listGroups($response0, $fan);
	if(!$success)
	{
	    $this->success = false;
	    log_message('error', 'Failed to get permission of OCF, (listGroups) ' . ', error: ' . $this->CI->flexrest->error);
	    return false;
	}
	
	$groups['user_groups'] = $response0['results'];
	for($i=0; $i<count($groups['user_groups']); $i++)
	{
	    unset($groups['user_groups'][$i]['links']);
	}    
	#$ci =& get_instance();
	$this->CI->load->config('flex');
	$ocf_groups_collection = $this->CI->config->item('ocf_groups_collection');

	#$institute_url = $ci->config->item('institute_url');
	#echo $institute_url;exit();
	$q = '';
	$start = 0;
	$length = 10;
	$order = 'modified';
	$reverse = false;
	$info = 'all';
	$showall = true;
	#$where = "/xml/item/curriculum/assessment/SAMs/files/file/@ref='$avail_ref'";

	$where = "/xml/item/restrictions/management/manage/fans/fan='$fan'";
	$where .= " AND /xml/item/@itemstatus='live'";
	$where = urlencode($where);
	#Search in FLEX

	$searchsuccess = $this->CI->flexrest->search($response, $q, $ocf_groups_collection, $where, $start, $length, $order, $reverse, $info, $showall);
	if(!$searchsuccess)
	{
	    $this->success = false;
	    log_message('error', 'Failed to search fan in OCF groups collection: ' . $this->flexrest->error);
	    #$this->error_info('Failed to search discipline in subject areas collection.');
	    return;
	}
	#echo '<pre>';print_r($response);echo '<pre>';exit();
	$count_items = (int)intval($response['available']);
	$group_names = array();
	for($i=0; $i<$count_items; $i++)
	{
	    $group_names[] = $response['results'][$i]['name'];
	}
	$groups['mgm_groups'] = $group_names;
	#$_SESSION['ocf_usr_mgm_groups'] = $groups;
	
	return $groups;
    }
    
    /**********************************************************************
     * OCF learning activity update privilege
     * 
     * IF user in group of EQ ADMIN
     *    THEN  has_privilege = Yes
     * 
     * ELSE IF user in group of TAA Contributor
     *    THEN search FAN in collection of 'OCF groups' to see if user in:
     *        * course (MD)
     *        * topic (MMED8302)
     *        * management (AS-LIFT)
     *        IF user is in one of them and it it is also in activity item
     *        THEN has_privilege = Yes
     * 
     * Item LOCKS are checked to see if modifications are allowed for:
     *        * item name
     *        * item description
     *        * linked activities
     * 
     **********************************************************************/
    
    public function get_ocf_activity_upd_privilege($fan, $uuid, $version)
    {
	if(session_id() == '')
	    session_start();

        $fan = strtolower($fan);
	$ocf_usr_mgm_groups = $this->get_ocf_mgm_groups($fan);
	if(!isset($ocf_usr_mgm_groups['mgm_groups']))
	{
	    $this->success = false;
	    return false;
	}    
	$ocf_mgm_groups = $ocf_usr_mgm_groups['mgm_groups'];
	$ocf_user_groups = $ocf_usr_mgm_groups['user_groups'];
	
	$this->CI =& get_instance();
	$this->CI->load->config('flex');
	
	$this->CI->load->library('flexrest/flexrest');
	$success = $this->CI->flexrest->processClientCredentialToken();
	if(!$success)
	{
	    $this->success = false;
	    log_message('error', 'Failed to access flex: ' . $this->CI->flexrest->error);
	    return false;
	}
	
	$ocf_taa_contributor_grpid = $this->CI->config->item('TAA contributor grp');
	$ocf_eqadmin_grpid = $this->CI->config->item('EQ admin grp');
	$is_contributor = false;
	$is_eqadmin = false;
	foreach($ocf_user_groups as $user_grp)
	{
	    if($user_grp['id'] == $ocf_taa_contributor_grpid)
		$is_contributor = true;
	    if($user_grp['id'] == $ocf_eqadmin_grpid)
		$is_eqadmin = true;
	}
	$success = $this->CI->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
	    $this->success = false;
            log_message('error', 'OCF: Failed to get Item: uuid: ' . $uuid . ', error: ' . $this->CI->flexrest->error);
            return false;
	}
	
	$xmlwrapper_name = 'xmlwrapper1';
	$this->CI->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']), $xmlwrapper_name);
	
	$topics = array();
	$count_topics = $this->CI->$xmlwrapper_name->numNodes('/xml/item/curriculum/topics/topic/code');
	for ($i = 1; $i <= $count_topics; $i++) 
	{
	    $topics[] = $this->CI->$xmlwrapper_name->nodeValue('/xml/item/curriculum/topics/topic/code['.$i.']');
	}
	#var_dump($topics);
	$courses = array();
	$count_courses = $this->CI->$xmlwrapper_name->numNodes('/xml/item/curriculum/courses/course/code');
	for ($i = 1; $i <= $count_topics; $i++) 
	{
	    $courses[] = $this->CI->$xmlwrapper_name->nodeValue('/xml/item/curriculum/courses/course/code['.$i.']');
	}
	#$courses[] = 'MD'; #temp hard code
        #$courses[] = 'MD2017'; #temp hard code
	#MD, MD2017, etc.
	$tmp_ocf_id_value = $this->CI->$xmlwrapper_name->nodeValue('/xml/item/restrictions/management/manage/@ocf_id');
	if($tmp_ocf_id_value != '')
	{
            $courses[] = $tmp_ocf_id_value;
	}
	
	$managements = array();
	$count_managements = $this->CI->$xmlwrapper_name->numNodes('/xml/item/restrictions/management/manage');
	for ($i = 1; $i <= $count_managements; $i++) 
	{
	    $managements[] = $this->CI->$xmlwrapper_name->nodeValue('/xml/item/restrictions/management/manage['.$i.']/@id');
	}
	
	$locks['item_name'] = $this->CI->$xmlwrapper_name->nodeValue('/xml/item/restrictions/locked/locks/item_name');
	$locks['item_description'] = $this->CI->$xmlwrapper_name->nodeValue('/xml/item/restrictions/locked/locks/item_description');
	$locks['activities'] = $this->CI->$xmlwrapper_name->nodeValue('/xml/item/restrictions/locked/locks/activities');
	
	$upd_privilege = array();
	$upd_privilege['locks'] = $locks;
	$upd_privilege['mgmgrps'] = array_filter(array_merge((array)$courses, (array)$topics, (array)$managements));
	#echo '<pre>';print_r($upd_privilege['mgmgrps']);echo '</pre>';exit();
	$upd_privilege['has_privilege'] = 'No';
	for($i=0; $i<count($ocf_mgm_groups); $i++)
	{
	    $mgm_grp = $ocf_mgm_groups[$i];
	    if(in_array($mgm_grp, $courses) || in_array($mgm_grp, $topics) || in_array($mgm_grp, $managements))
            {
		$upd_privilege['has_privilege'] = 'Yes';
		break;
	    }
	}
	
	if($is_contributor == false)
	    $upd_privilege['has_privilege'] = 'No';
	if($is_eqadmin == true)
	    $upd_privilege['has_privilege'] = 'Yes';
	
	$upd_privilege['is_contributor'] = ($is_contributor == true ? 'Yes' : 'No');
	$upd_privilege['is_eqadmin'] = ($is_eqadmin == true ? 'Yes' : 'No');
	
	return $upd_privilege;
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
