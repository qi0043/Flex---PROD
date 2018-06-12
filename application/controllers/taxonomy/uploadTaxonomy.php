<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class uploadTaxonomy extends CI_Controller {

		protected $logger_taxonomies;
        protected $soapusername;
        protected $soappassword;
        protected $soapparams;
	   
		
        public function __construct()
        {
            parent::__construct();
            $ci =& get_instance();
			
			//load config file
            $ci->load->config('flex');
			
			//logs
            $loggings = $ci->config->item('taxonomyLog');
            $this->load->library('logging/logging',$loggings);
			$this->logger_taxonomies = $this->logging->get_logger('taxonomies');
			
			//get login paramsters 
            $this->soapusername = $ci->config->item('soap_username');
            $this->soappassword = $ci->config->item('soap_password');
            $this->soapparams = array('username'=>$this->soapusername, 'password'=>$this->soappassword);
			
			//log to soap services
			$flexsoapname = 'flexsoap';
            $this->load->library('flexsoap/flexsoap',$this->soapparams, $flexsoapname);
            if(!$this->$flexsoapname->success)
            {
				$this->logger_taxonomies->error($this->$flexsoapname->error_info);
                $errdata['message'] = $this->$flexsoapname->error_info;
                $errdata['heading'] = "Internal error";
                $this->load->view('taxonomy/showerror_view', $errdata);
                $this->output->_display();
                exit();
				
            }
        }
     		  
        /**
         * Get availabilities 
         *
         * 
         */
        public function getavails()
		{
			try{
			echo 'get availabilities';
            $this->load->model('taxonomy/taxonomy_model');
                
            $avails = $this->taxonomy_model->db_get_all_terms('avails');
			
            
            if($avails == false )
            {
                $error_data = array('error_info'=>'database error: No availability found. ');
                $this->load->view('taxonomy/showerror_view', $error_data);
                exit;
            }
			echo '<pre>';
            print_r($avails);
            echo '</pre>';
			#$data = array("avails"=>$avails);
			
            #$this->load->view('taxonomy/avails_view', $data);	
			}
			catch(Exception $e) {
   		    	echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
        }
		
		public function test_db_function($view_name, $status, $msg)
		{
			#function db_set_last_imported_timestamp($view_name, $current_timestamp, $update_status, $message)
			try
			{
				$this->load->model('taxonomy/taxonomy_model');
            	//$timestamp = date(DATE, mktime(0,0,0, 10, 21, 2014));//date("Y-m-d H:i:s");
				$timestamp = date("Y-m-d H:i:s");
           		$avails = $this->taxonomy_model->db_set_last_imported_timestamp($view_name,$timestamp, $status, $msg);
			}
			catch(Exception $e) {
   		    	echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
		}
		
		 /**
         * Get topics
         *
         * 
         */
        public function gettopics()
		{
			echo '<pre>';
			echo 'get topics';
		    echo '</pre>';
            $this->load->model('taxonomy/taxonomy_model');
                
            $topics = $this->taxonomy_model->db_get_all_terms('topics');
            
            if($topics === false )
            {
                $error_data = array('error_info'=>'database error: No topics found. ');
                $this->load->view('taxonomy/showerror_view', $error_data);
                exit;
            }
			
			echo '<pre>';
            print_r($topics);
            echo '</pre>';
			
			$data = array("topics"=>$topics);
            $this->load->view('taxonomy/topics_view', $data);	
        }
		
		
	    /*************** update availability taxonomy ********************************************/
		/********** STEP 1: get recently updated terms from database view ****************/
		/********** STEP 2: get current terms from taxonomy ****************/
		/********** STEP 3: update taxonomy according to return result from STEP 1 ****************/
		/********** STEP 4: get all valid term data (including recently updated and hasn't updated recently data) from database view ****************/
		/********** STEP 5: compare current taxonomy with return result from STEP 3, DELETE terms that NOT EXIST in return result from SETP 3 ****************/
		/********** STEP 7: call database function to set timestamp ******************************/
		/********** STEP 8: email administrator update error information ******************************/
		/********** Parameters: 
		              1. taxon_name: avails_taxonomy or topics_taxonomy ********************/
		
		public function updateTaxonomy($taxon_name)
		{
			try{
				
				/**** system variables *****/
				$error_array = array(); //set up error_array for collecting all of the error information during the process
				$created_items_count = 0;
				$updated_items_count = 0;
				$deleted_items_count = 0;
				$update_status = 'E'; //E: error. S: success. PS: partly success
				
				$currentTime = date("Y-m-d H:i:s"); //currentTime for setting 'last_imported' term value
				
				/********loading config file and database model*********/
				$ci =& get_instance();
				$ci->load->config('flex');
				//get taxonomy uuid from config file
				$taxonID = $ci->config->item($taxon_name);
				$this->load->model('taxonomy/taxonomy_model');
				
				//formate taxonomy name
				$taxon_name_index = stripos($taxon_name, "_");
				$taxon_name = substr($taxon_name, 0, $taxon_name_index);
				
					
				/********** STEP 1: get recently updated terms from database view ****************/
				echo 'getting updated '.$taxon_name.' terms from database <br/>';
				
				try
				{
					$avails = $this->taxonomy_model-> db_get_updated_terms($taxon_name);   

					$avail_count = count($avails);
					echo 'STEP 1: <br/>';
					
					if($avails!= false)
					{
						echo 'There are ' . $avail_count . ' terms will be updated in '.$taxon_name.' taxonomy <br/>';
					    /********** STEP 2: get current terms from taxonomy ****************/
					
						// get already existed terms list 
						//Returns: An array of immediate child terms
						echo 'STEP 2: getting existing terms from '.$taxon_name.' taxonomy <br/>';
						$term_list = $this->flexsoap->listTerms($taxonID, ""); //it actually returns an object, need to transfter it to an associate array
						$term_list_array =  (array)$term_list;
						
						//if cannot get existing terms from taxonomy, raise an error
						if(!$this->flexsoap->success)
						{
							$this->logger_taxonomies->error("list terms Error: " . $this->flexsoap->error_info . "\n");
							array_push($error_array, 'time '. date("Y-m-d H:i:s") . 'error message: ' . "list terms Error: " . $this->flexsoap->error_info);
							/********** call database function to set timestamp ******************************/
							/********** email administrator update error information ******************************/
							$this->auto_email($error_array,$created_items_count,$updated_items_count,$deleted_items_count,$update_status, $taxon_name);
							
							$msg = 'Incompleted: '. $created_items_count .' terms created '. $updated_items_count . ' terms updated' .$deleted_items_count .' terms deleted, ' . count($error_array) . 'errors' ;
							$this->taxonomy_model->db_set_last_imported_timestamp($taxon_name,date("Y-m-d H:i:s"), $update_status, $msg);
							exit;
						}
						
						//print out current count of terms in taxonomy
						echo '<pre>';
							if(isset($term_list_array['string']))
							echo 'There are : '. count($term_list_array['string']). ' items in '.$taxon_name.' taxonomy <br/>';
						echo '</pre>';	
						
						// lock taxonomy for uploading
						echo 'unlocking taxonomy ..';
						$this->unlockTaxonomy($taxonID, true);
						if(!$this->flexsoap->success)
						{
							$this->logger_taxonomies->error("unable to unlock taxonomy Error: " . $this->flexsoap->error_info);
							array_push($error_array, 'time '. date("Y-m-d H:i:s") . 'unable to unlock taxonomy Error: ' . $this->flexsoap->error_info);
							echo "unable to unclock taxonomy Error: ".$this->flexsoap->error_info  . '<br>';
						}
						
						#$this->flexsoap ->lockTaxonomyForEditing($taxonID); 
						/*if(!$this->flexsoap->success)
						{
							$this->logger_taxonomies->error("locking taxonomy Error: " . $this->flexsoap->error_info . "\n");
							echo $this->flexsoap->error_info . '<br>';
							array_push($error_array, 'time '. date("Y-m-d H:i:s") . 'locking taxonomy Error: ' . $this->flexsoap->error_info );
							exit;
						}
						else
						{
							echo 'locking taxonomy <br>';
						}*/
					
					
					
					/********** STEP 3: update taxonomy according to return result from STEP 1 ****************/
                  
					
					//if count($avail) < 0, means no term has been updated since the last imported date(this date timestamp was set in the database at STEP7 when this function was run last time)
						echo 'STEP3:  <br/>';
					    echo 'uploading '.$taxon_name.' taxonomy ..... <br/>';
						for($i=0; $i<$avail_count; $i++)  //iterate array that retrieve from database
						{
							$avail_ref = $avails[$i]['node'];
							echo $i . '. '.'avail_ref: ' . $avail_ref .'<br>';
							$flag = false; 
							 
							/*****relog in to flexsoap every 10 uploads to avoid soap cannot connect the host issue******/
							if($i%10 == 0)
							{
								if($i >= 10) 
								{
									echo '<strong>relog in</strong><br/>';
									unset($this->$flexsoapname);
									echo 'unset flexsoapname';
								}
								$flexsoapname = 'flexsoap'.$i;
								//log to soap services
								$this->load->library('flexsoap/flexsoap',$this->soapparams, $flexsoapname);
								if(!$this->$flexsoapname->success)
								{
									$this->logger_taxonomies->error($this->$flexsoapname->error_info);
									array_push($error_array, 'time '. date("Y-m-d H:i:s") . 'locking taxonomy Error: ' . $this->$flexsoapname->error_info );
									echo 'relog in failed, system exit!';
									$msg = 'Incompleted: '. $created_items_count .' terms created '. $updated_items_count . ' terms updated' .$deleted_items_count .' terms deleted, ' . count($error_array) . 'errors' ;
									$this->taxonomy_model->db_set_last_imported_timestamp($taxon_name,date("Y-m-d H:i:s"), $update_status, $msg);
									$this->auto_email($error_array,$created_items_count,$updated_items_count,$deleted_items_count,$update_status, $taxon_name);
									exit();
								}
							}
								
							if(isset($term_list_array['string'])){
								for($j=0; $j<count($term_list_array['string']); $j++)
								{
									$term_avail_ref = $term_list_array['string'][$j];
									if($avail_ref == $term_avail_ref)
									{
										//found term in the taxonomy, edit it
										$flag = true;
										echo 'found term in taxonomy, setting term values... <br>';
										echo 'flexsoapname ' . $flexsoapname .'<br/>';
										try
										{ 
											$termFullPath = $term_avail_ref;
											$index = 0;
											foreach($avails[$i] as $x => $x_value)
											{
												if($index >0) //$index = 0 is the avail_ref value
												{
													if($index&1)  //odd indexes ares the datakeys
													{
														$key = $x_value;
													}
													else
													{
														//even indexes are the data values
														if($x_value != '')
														{
															echo 'setting '. $key .' to ' .$x_value.'.<br/>';
															$this->$flexsoapname->setTermData($taxonID, $termFullPath, $key, $x_value);
														}
														else
														{
															echo 'setting '. $key .' to NULL .<br/>';
															$this->$flexsoapname->setTermData($taxonID, $termFullPath, $key, 'NULL');
														}
														unset($key);
													}
												}
												$index ++;
											}
											//add last_imported
											echo 'setting last_imported to ' . $currentTime . '<br/>';
											$this->$flexsoapname->setTermData($taxonID, $termFullPath, 'last_imported', $currentTime);
											$updated_items_count++;
										}
										catch(Exception $e) {
											$this->logger_taxonomies->error("edit term Error: " . $this->$flexsoapname->error_info . "\n");
											echo 'Caught exception: ',  $e->getMessage(), "\n";
											array_push($error_array, 'time '. date("Y-m-d H:i:s") . 'edit term Error: ' . $this->$flexsoapname->error_info );
											$this->unlockTaxonomy($taxonID, true);
											break;
										}
										break;
									}
								}
							}
							
							if($flag == false) //not found, add a new term
							{
								echo 'term not found in taxonomy, adding a new term ... <br>';
								try
								{
									$termFullPath = $avail_ref;
									$addTerm = $this -> addTerm($taxonID, '', $avail_ref, -1, $flexsoapname); // add the term to the end of the taxonomy
									if($addTerm) //if successfully add a new term to the taxonomy
									{
										echo 'flexsoapname ' . $flexsoapname .'<br/>';
										$index = 0;
										foreach($avails[$i] as $x => $x_value)
										{
											if($index >0) //$index = 0 is the avail_ref value
											{
												if($index&1)  //odd indexes: datakeys
												{
													$key = $x_value;
												}
												else
												{
													//even indexes: data values
													if($x_value != '')
													{
														echo 'setting '. $key .' to ' .$x_value.'.<br/>';
														$this->$flexsoapname->setTermData($taxonID, $termFullPath, $key, $x_value);
													}
													else
													{
														echo 'setting '. $key .' to NULL .<br/>';
														$this->$flexsoapname->setTermData($taxonID, $termFullPath, $key, 'NULL');
													}
													unset($key);
												}
												
											}
											
											$index ++;
										}
										//add last_imported
										echo 'setting last_imported to ' . $currentTime . '<br/>';
										$this->$flexsoapname->setTermData($taxonID, $termFullPath, 'last_imported', $currentTime);
										$created_items_count ++;
									}
									else
									{
										$this->logger_taxonomies->error("add new term Error: " . $this->$flexsoapname->error_info . "\n");
										echo ' add new term Error:',  $this->$flexsoapname->error_info, "\n";
										array_push($error_array, 'time '. date("Y-m-d H:i:s") . 'add new term Error: ' . $this->$flexsoapname->error_info );
									}
								}
								
								catch(Exception $e) {
									$this->logger_taxonomies->error("add new term Error: " . $this->$flexsoapname->error_info . "\n");
									echo 'Caught exception: ',  $e->getMessage(), "\n";
									array_push($error_array, 'time '. date("Y-m-d H:i:s") . 'add new term Error: ' . $this->$flexsoapname->error_info);
									$this->unlockTaxonomy($taxonID, true);
									break;
								}
						    }
						}
						echo $taxon_name .  ' taxonomy upload completed <br/>';
					}
					else
					{
						echo 'No term needs to be uploaded, system will skip to STEP 4<br/>';
					}

					/********** STEP 4: get all valid term data (including recently updated and hasn't updated recently data) from database view ****************/
					//get existing terms from taxonomy
					echo 'STEP 4 <br/>';
					echo 'getting existing terms from '.$taxon_name.' taxonomy <br/>';
					$taxon_term_list = $this->flexsoap->listTerms($taxonID, ""); //it actually returns an object, need to transfter it to an associate array
					$taxon_term_list_array =  (array)$taxon_term_list; //terms from taxononmy
			
					if(!$this->flexsoap->success)
					{
						$this->logger_taxonomies->error("list terms Error: " . $this->flexsoap->error_info . "\n");
						echo $this->flexsoap->error_info;
						array_push($error_array, 'time '. date("Y-m-d H:i:s") . ' error message: ' . $this->flexsoap->error_info);
						$this->auto_email($error_array,$created_items_count,$updated_items_count,$deleted_items_count,$update_status, $taxon_name);
						$update_status = 'PS';
						$msg = 'Incompleted: '. $created_items_count .' terms created '. $updated_items_count . ' terms updated' .$deleted_items_count .' terms deleted, ' . count($error_array) . 'errors' ;
						$this->taxonomy_model->db_set_last_imported_timestamp($taxon_name,date("Y-m-d H:i:s"), $update_status, $msg);
						exit;
					}
					
					if(isset($taxon_term_list_array['string']) && count($taxon_term_list_array['string'])> 0 )  
					{
						echo 'there are ' . count($taxon_term_list_array['string']) . ' terms existing in taxonomy <br/>';
						
						//get terms from database
						echo 'getting all valid terms from database <br/>';
						$db_terms = $this->taxonomy_model->db_get_all_terms($taxon_name);    //terms from database
						$terms_count = count($db_terms); 
						echo 'there are ' . $terms_count . ' valid terms get from db_get_all_terms query <br/>';
						if($db_terms)
						{
							/********** STEP 5: compare current taxonomy with return result from STEP 3, DELETE terms that NOT EXIST in return result from SETP 3 ****************/
							echo 'STEP 5 <br/>';
								for($j=0; $j<count($taxon_term_list_array['string']); $j++) //iterate taxonomy terms
								#for($j=0; $j<5; $j++) //iterate taxonomy terms
								{
									$taxon_term_ref = trim($taxon_term_list_array['string'][$j]);
									$taxon_term_index = $j + 1;
									echo $taxon_term_index . ' ' . $taxon_term_ref . '<br/>';
									$flag = false; 
									
									//iterate database terms
									for($i=0; $i<$terms_count; $i++) 
									{
										$db_term_ref = $db_terms[$i]['node'];
										
										
										if($taxon_term_ref  == $db_term_ref)
										{
											//found term in the taxonomy, edit it
											$flag = true;
											echo 'found term in database <br>';
											break;
										}
									}
									
									if(!$flag)
									{
										echo 'term not found in database, delete it from taxonomy... <br>';
										$this->flexsoap->deleteTerm($taxonID, $taxon_term_ref);
										if(!$this->flexsoap->success)
										{
											$this->logger_taxonomies->error("deleting term ". $taxon_term_ref ." Error: " . $this->flexsoap->error_info . "\n");
											echo $this->flexsoap->error_info . '<br>';
											///$this->unlockTaxonomy($taxonID,true);
											//echo 'unlocking taxonomy <br/>';
											array_push($error_array, 'time '. date("Y-m-d H:i:s") . 'error message: ' . $this->flexsoap->error_info);
											$update_status = 'PS';
											$msg = 'Incompleted: '. $created_items_count .' terms created '. $updated_items_count . ' terms updated' .$deleted_items_count .' terms deleted, ' . count($error_array) . 'errors' ;
											$this->taxonomy_model->db_set_last_imported_timestamp($taxon_name,date("Y-m-d H:i:s"), $update_status, $msg);
											$this->auto_email($error_array,$created_items_count,$updated_items_count,$deleted_items_count,$update_status, $taxon_name);
											break;
										    //sleep(1);
										}
										else
										{
											$deleted_items_count ++;
										}
									}
								}
								/**************************************************
									call database function to setup timestamp here
								***************************************************/
								
								echo 'update job completed <br/>';
								$update_status = 'S';
								
							$msg = 'Completed: '. $created_items_count .' terms created '. $updated_items_count . ' terms updated' .$deleted_items_count .' terms deleted, ' . count($error_array) . 'errors' ;
								$this->taxonomy_model->db_set_last_imported_timestamp($taxon_name,date("Y-m-d H:i:s"), $update_status, $msg);
								$this->auto_email($error_array,$created_items_count,$updated_items_count,$deleted_items_count,$update_status, $taxon_name, $taxon_name);
						}
						else //if no data from database, raise an error and exit
						{
								
								$error_data = 'database error: No terms found from db_get_all_terms query.';
								array_push($error_array, 'time '. date("Y-m-d H:i:s") . 'error message: ' . $error_data);
								$update_status = 'PS';
								$msg = 'Incompleted: '. $created_items_count .' terms created '. $updated_items_count . ' terms updated' .$deleted_items_count .' terms deleted, ' . count($error_array) . 'errors' ;
								$this->taxonomy_model->db_set_last_imported_timestamp($taxon_name,date("Y-m-d H:i:s"), $update_status, $msg);
								$this->auto_email($error_array,$created_items_count,$updated_items_count,$deleted_items_count,$update_status, $taxon_name);
						}
				   }
				  else // if there is no terms in taxonmy
				  {
					  $error_data = array('error_info'=>'database error: No terms found in taxonomy.');
					  array_push($error_array, 'time '. date("Y-m-d H:i:s") . 'error message: ' . $error_data);
					  $update_status = 'PS';
					  $msg = 'Incompleted: '. $created_items_count .' terms created '. $updated_items_count . ' terms updated' .$deleted_items_count .' terms deleted, ' . count($error_array) . 'errors' ;
					  $this->taxonomy_model->db_set_last_imported_timestamp($taxon_name,date("Y-m-d H:i:s"), $update_status, $msg);
					  $this->auto_email($error_array,$created_items_count,$updated_items_count,$deleted_items_count,$update_status, $taxon_name);
					  exit;
				  }
				}
				catch (Exception $e) {
   		    	echo 'Caught exception: ',  $e->getMessage(), "\n";
				array_push($error_array, 'time '. date("Y-m-d H:i:s") . 'error message: ' .  $e->getMessage());
				$msg = 'Incompleted: '. $created_items_count .' terms created '. $updated_items_count . ' terms updated' .$deleted_items_count .' terms deleted, ' . count($error_array) . 'errors' ;
				$this->taxonomy_model->db_set_last_imported_timestamp($taxon_name,date("Y-m-d H:i:s"), $update_status, $msg);
				$this->auto_email($error_array,$created_items_count,$updated_items_count,$deleted_items_count,$update_status, $taxon_name);
				exit;
				}
				
			}
			catch(Exception $e) 
			{
				$this->logger_taxonomies->error("Error: " . $this->$flexsoapname->error_info);
				echo 'Caught exception: ',  $e->getMessage(), "\n";
				array_push($error_array, 'time '. date("Y-m-d H:i:s") . 'error message: ' .  $e->getMessage());
				$update_status = 'PS';
				$msg = 'Incompleted: '. $created_items_count .' terms created '. $updated_items_count . ' terms updated' .$deleted_items_count .' terms deleted, ' . count($error_array) . 'errors' ;
				$this->taxonomy_model->db_set_last_imported_timestamp($taxon_name,date("Y-m-d H:i:s"), $update_status, $msg);
				$this->auto_email($error_array,$created_items_count,$updated_items_count,$deleted_items_count,$update_status, $taxon_name);
				
				exit;
			}
			
		}
		
		
/*********************************************************************
     	        	Clear Taxonomy
			
**********************************************************************/		

		public function clearTaxonomy($taxon_name)
		{
			try{
				$ci =& get_instance();
				$ci->load->config('flex');
				//get taxonomy uuid from config file
            	$taxonID = $ci->config->item($taxon_name);
				
				echo 'getting terms from taxonomy<br/>';
				$term_list = $this->$flexsoapname ->listTerms($taxonID, "", $flexsoapname); //it actually returns an object, need to transfter it to an associate array
				$term_list_array =  (array)$term_list;
				
				if(!$this->$flexsoapname->success)
				{
					$this->logger_taxonomies->error("list terms Error: " . $this->$flexsoapname->error_info . "\n");
					echo $this->$flexsoapname->error_info;
					exit;
				}
				if(isset($term_list_array['string']))
				{
					echo 'There are '.count($term_list_array['string']) . ' terms in the ' . $taxon_name . '<br>';
				}
				else
				{
					echo 'There is no term in this taxonomy!<br/>';
					exit;
				}
				
				
				echo 'unlocking taxonomy ..<br>';
				
				$unlock_return = $this->unlockTaxonomy($taxonID, false);
				if(!$unlock_return)
				{
					echo 'taxonomy locked, force to unlock? <br>';
					$unlock_return = $this->unlockTaxonomy($taxonID, true);
					if(!$unlock_return)
					{
						$this->logger_taxonomies->error("unable to unclock taxonomy Error: " . $this->$flexsoapname->error_info);
						echo "unable to unclock taxonomy Error: ".$this->$flexsoapname->error_info  . '<br>';
						exit;
					}
				}
					
				echo 'locking taxonomy ...<br>';
				$lock_return = $this->lockTaxonomyForEditing($taxonID); //lock taxonomy;
				if(!$lock_return)
				{
					$this->logger_taxonomies->error("locking taxonomy Error: " . $this->flexsoap->error_info . "\n");
					echo $this->flexsoap->error_info . '<br>';
					exit;
				}
				else
				{
					echo 'Taxonomy locked ! <br>';
				}
				
			    if(isset($term_list_array['string']))
				{
					for($j=0; $j<count($term_list_array['string']); $j++)
					{
						$termFullPath = $term_list_array['string'][$j];
						echo 'deleting '.$termFullPath.'...<br>';
						$this->deleteTerm($taxonID, $termFullPath);
						if(!$this->flexsoap->success)
						{
							$this->logger_taxonomies->error("deleting taxonomy Error: " . $this->flexsoap->error_info . "\n");
							echo $this->flexsoap->error_info . '<br>';
							exit;
						}
					}
				}
				
				$term_list = $this->flexsoap->listTerms($taxonID, ""); //it actually returns an object, need to transfter it to an associate array
				$term_list_array =  (array)$term_list;
				
				if(!$this->flexsoap->success)
				{
					$this->logger_taxonomies->error("list terms Error: " . $this->flexsoap->error_info . "\n");
					echo $this->flexsoap->error_info;
					exit;
				}
				if(isset($term_list_array['string']))
					echo 'There are '. count($term_list_array['string']) . 'terms in the ' . $taxon_name . '<br>';
				echo $taxon_name . ' clearing job completed';
				echo 'unlocking taxonomy ..<br>';
				$unlock_return = $this->unlockTaxonomy($taxonID, false);
				exit;
				
			}
			catch (Exception $e) {
   		    	echo 'Caught exception: ',  $e->getMessage(), "\n";
				$this->unlockTaxonomy($taxonID, false);
				exit;
			}
		}
		
		
  
 /*********************************************************************
     	        	//Private functions 
			
**********************************************************************/		
 	  
	 
	 	private function lockTaxonomyForEditing($taxonID)
		{
			$this ->flexsoap -> lockTaxonomyForEditing($taxonID);
			if($this->flexsoap->success)
            {
				return true;
			}
			else
			{
				$this->logger_taxonomies->error($term. "lock taxonomy Error: " . $this->flexsoap->error_info . '<br>');
				echo $term. "lock taxonomy Error: ". $this->flexsoap->error_info .'<br>';
				return false;
			}
		}
		
		
		private function unlockTaxonomy($taxonID, $force) 
		{
			$this ->flexsoap ->unlockTaxonomy($taxonID, $force);
			if($this->flexsoap->success)
            {
				return true;
			}
			else
			{
				$this->logger_taxonomies->error( "unlock taxonomy Error: " . $this->flexsoap->error_info . '<br>');
				echo "unlock taxonomy Error: ". $this->flexsoap->error_info .'<br>';
				return false;
			}
			
		}
		
		
	  private function addTerm($taxonID, $parentFullPath, $term, $index, $flexsoapname)
	  {
		  $this->$flexsoapname->insertTerm($taxonID, $parentFullPath, $term, $index);
		  if($this->$flexsoapname->success)
		  {
			  return true;
		  }
		  else
		  {
			  $this->logger_taxonomies->error($term. "addTerm Error: " . $this->$flexsoapname->error_info);
			  echo $term. "addTerm Error: ". $this->$flexsoapname->error_info .'<br>';
			  return false;
		  }
	  }

	  private function deleteTerm($taxonID, $termFullPath, $flexsoapname)
	  {
		  $this->$flexsoapname->deleteTerm($taxonID, $termFullPath);
		  if(!$this->$flexsoapname->success)
		  {
			  $this->logger_taxonomies->error($termFullPath. "deleteTerm Error: " . $this->$flexsoapname->error_info);
			  echo  $termFullPath. "deleteTerm Error: " . $this->$flexsoapname->error_info . "<br>";
			  return false;
		  }
		  return true;
	  }
			
	//send email to .... after every cron job completed  
	 private function auto_email($error_array,$created_items_count,$updated_items_count,$deleted_items_count,$update_status, $taxon_name)
    {
		$current_timestamp = date("Y-m-d H:i:sa"); 
		$this->load->library('email');
		$msg = '';
		
		for($i = 0; $i < count($error_array); $i++)
		{
			$msg = $msg . '  ' . $error_array[$i];
		}

		$this->email->from('DoNotReply@flinders.edu.au', 'DoNotReply@flinders.edu.au');
		$this->email->to('flex.help@flinders.edu.au'); 
		$this->email->subject('Taxonomy update notification');
		$mes = 'The '. $taxon_name .' taxonomy update on ' .$current_timestamp.' was ' . $update_status .'. There were '. $created_items_count. ' terms created, '
		 .$updated_items_count . ' terms updated and ' . $deleted_items_count . ' terms deleted from this taxonomy. <br/>  Count of Error: ' . count($error_array) .
		   ' Error List: ' .$msg . '';

		$this->email->message($mes);	
		$this->email->send();
	 }
	  
}