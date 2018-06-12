<?php

	function samsForTopic($searchResultsXml='') 
	{ 
	
	for ($i = 1; $i <= $searchResultsXml->numNodes('/results/result'); $i++) {
			
			
			$topicCode = '/results/result['.$i.']/xml/item/uni/topic/used_in/topics/code';
			$topicTitle = '/results/result['.$i.']/xml/item/uni/topic/used_in/topics/title';
			$topicUnits = '/results/result['.$i.']/xml/item/uni/topic/used_in/topics/units';
			$topicSchool = '/results/result['.$i.']/xml/item/uni/topic/used_in/topics/school';
			
			
			
			
			$approval = '/results/result['.$i.']/xml/item/uni/topic/assessment/distributed';
			
			
			
			
			$samsArray[$i]['tcode'] = $searchResultsXml->nodeValue($topicCode);
			$samsArray[$i]['topicTitle'] = $searchResultsXml->nodeValue($topicTitle);
			$samsArray[$i]['topicUnits'] = $searchResultsXml->nodeValue($topicUnits);
			$samsArray[$i]['topicSchool'] = $searchResultsXml->nodeValue($topicSchool);
			
			
			
			$samsArray[$i]['approval'] = $searchResultsXml->nodeValue($approval);
			

		
			
			
				// get availabilities information
			for ($j = 1; $j <= $searchResultsXml->numNodes('/results/result['.$i.']/xml/item/uni/topic/used_in/availabilities/availability'); $j++) {
			
				$avYear = '/results/result['.$i.']/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/year';
				$avDuration = '/results/result['.$i.']/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/duration';
				$avLocation = '/results/result['.$i.']/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/location';
				$avCoordName = '/results/result['.$i.']/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/coordinators/coordinators/coordinator/name';
				$avCoordPhone = '/results/result['.$i.']/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/coordinators/coordinators/coordinator/phone';
				$avCoordLocation = '/results/result['.$i.']/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/coordinators/coordinators/coordinator/location';
			

				$samsArray[$i]['availability'][$j]['avYear'] = $searchResultsXml->nodeValue($avYear);
				$samsArray[$i]['availability'][$j]['avDuration'] = $searchResultsXml->nodeValue($avDuration);
				$samsArray[$i]['availability'][$j]['avLocation'] = $searchResultsXml->nodeValue($avLocation);
				$samsArray[$i]['availability'][$j]['avCoordName'] = $searchResultsXml->nodeValue($avCoordName);
				$samsArray[$i]['availability'][$j]['avCoordPhone'] = $searchResultsXml->nodeValue($avCoordPhone);
				$samsArray[$i]['availability'][$j]['avCoordLocation'] = $searchResultsXml->nodeValue($avCoordLocation);
				
				

			}
			
			
				// assessable tasks
				for ($j = 1; $j <= $searchResultsXml->numNodes('/results/result['.$i.']/xml/item/uni/topic/outcomes/outcome'); $j++) {
			
				$name = '/results/result['.$i.']/xml/item/uni/topic/outcomes/outcome['.$j.']/name';
				$samsArray[$i]['topicalign'][$j]['name'] = $searchResultsXml->nodeValue($name);
				
				
				for ($k = 1; $k <= $searchResultsXml->numNodes('/results/result['.$i.']/xml/item/uni/topic/outcomes/outcome['.$j.']/assessments/assessment'); $k++) {
					
					$assessment = '/results/result['.$i.']/xml/item/uni/topic/outcomes/outcome['.$j.']/assessments/assessment['.$k.']';
					//$samsArray[$i]['topicalign'][$j]['assessment'][$k] ='text'; 
					
					$samsArray[$i]['topicalign'][$j]['assessment'][$k] = $searchResultsXml->nodeValue($assessment); 
					
				}
				
				//$samsArray[$i]['topicalign'][$j]['numItems'] = [$k]; 

			}
	
				// graduate qualities
				for ($j = 1; $j <= $searchResultsXml->numNodes('/results/result['.$i.']/xml/item/uni/course/grad_attributes/grad_attribute'); $j++) {
			
				$name = '/results/result['.$i.']/xml/item/uni/course/grad_attributes/grad_attribute['.$j.']/name';
				$code = '/results/result['.$i.']/xml/item/uni/course/grad_attributes/grad_attribute['.$j.']/code';
				$samsArray[$i]['gradattribute'][$j]['name'] = $searchResultsXml->nodeValue($name);
				$samsArray[$i]['gradattribute'][$j]['code'] = $searchResultsXml->nodeValue($code);
				
				
				for ($k = 1; $k <= $searchResultsXml->numNodes('/results/result['.$i.']/xml/item/uni/course/grad_attributes/grad_attribute['.$j.']/assessments/assessment'); $k++) {
					
					$assessment = '/results/result['.$i.']/xml/item/uni/course/grad_attributes/grad_attribute['.$j.']/assessments/assessment['.$k.']';
					//$samsArray[$i]['topicalign'][$j]['assessment'][$k] ='text'; 
					
					$samsArray[$i]['gradattribute'][$j]['assessment'][$k] = $searchResultsXml->nodeValue($assessment); 
					
				}
				
				//$samsArray[$i]['topicalign'][$j]['numItems'] = [$k]; 

			}
			
	
			
			// topic alignment
				for ($j = 1; $j <= $searchResultsXml->numNodes('/results/result['.$i.']/xml/item/uni/topic/assessment/items/item'); $j++) {
			
				$name = '/results/result['.$i.']/xml/item/uni/topic/assessment/items/item['.$j.']/name';
				$proportion = '/results/result['.$i.']/xml/item/uni/topic/assessment/items/item['.$j.']/proportion';
				$deadline = '/results/result['.$i.']/xml/item/uni/topic/assessment/items/item['.$j.']/deadline';
				$penalties = '/results/result['.$i.']/xml/item/uni/topic/assessment/items/item['.$j.']/penalties';
				$return = '/results/result['.$i.']/xml/item/uni/topic/assessment/items/item['.$j.']/return_date';
			
			

				$samsArray[$i]['assessment'][$j]['name'] = $searchResultsXml->nodeValue($name);
				$samsArray[$i]['assessment'][$j]['proportion'] = $searchResultsXml->nodeValue($proportion);
				$samsArray[$i]['assessment'][$j]['deadline'] = $searchResultsXml->nodeValue($deadline);
				$samsArray[$i]['assessment'][$j]['penalties'] = $searchResultsXml->nodeValue($penalties);
				$samsArray[$i]['assessment'][$j]['return'] = $searchResultsXml->nodeValue($return);

			}
			
			$resubmissionPermitted = '/results/result['.$i.']/xml/item/uni/topic/assessment/resubmission/permitted';
			$resubmissionDetail = '/results/result['.$i.']/xml/item/uni/topic/assessment/resubmission/detail';
			
			$academicIntegrity = '/results/result['.$i.']/xml/item/uni/topic/assessment/integrity';
			
			$pass = '/results/result['.$i.']/xml/item/uni/topic/assessment/pass';
			
			$consideration = '/results/result['.$i.']/xml/item/uni/topic/assessment/special_contact';

			
			
			
			$samsArray[$i]['pass'] = $searchResultsXml->nodeValue($pass);
			$samsArray[$i]['consideration'] = $searchResultsXml->nodeValue($consideration);
			
			$samsArray[$i]['resubmissionPermitted'] = $searchResultsXml->nodeValue($resubmissionPermitted);
			$samsArray[$i]['resubmissionDetail'] = $searchResultsXml->nodeValue($resubmissionDetail);
			
			$samsArray[$i]['academicIntegrity'] = $searchResultsXml->nodeValue($academicIntegrity);
			
			
			
			
			
			
			

		return $samsArray;
	}
	}
?>