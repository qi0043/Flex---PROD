<?php

	function outcomesLevelByTopic($searchResultsXml='') 
	{ 
	
		$outcomesArray = outcomesAsArray($searchResultsXml);

		$resultsArray = array();
		$numTopics = count($outcomesArray);
		$numGroups = 0;
		
		foreach ($outcomesArray as $tCode => $tArray)
		{
			$numGroups += 1;
			$resultsArray['topics'][$tCode] = 'Add to function';
			
			foreach ($tArray as $grpArray)
			{
				$grpCode = $grpArray['grpCode'];	
				$resultsArray['groups'][$grpCode]['name'] = $grpArray['grpName'];	
				
				$numOutcomes = 0;
				foreach ($grpArray['outcomes'] as $outcomeArray)
				{
					$numOutcomes += 1;
					$oCode = $outcomeArray['code'];	
					$resultsArray['groups'][$grpCode]['outcomes'][$oCode]['name'] = $outcomeArray['name'];	
					$resultsArray['groups'][$grpCode]['outcomes'][$oCode]['levels'][$tCode] = $outcomeArray['level'];	
				}
				$resultsArray['count']['outcomes'][$grpCode] = $numOutcomes;
			}
		}	
		$resultsArray['count']['topics'] = $numTopics;
		$resultsArray['count']['groups'] = $numGroups;
		return $resultsArray;
	}


	function outcomesAsTable($searchResultsXml='') 
	{ 
	
		$outcomesArray = outcomesAsArray($searchResultsXml);

		$resultsArray = array();
		$rowArray = array();
		
		foreach ($outcomesArray as $tCode => $tArray)
		{
			foreach ($tArray as $grpArray)
			{
	
				foreach ($grpArray['outcomes'] as $outcomeArray)
				{
					$rowArray = array();
					$rowArray['tCode'] = $tCode;	
					$rowArray['grpCode'] = $grpArray['grpCode'];	
					$rowArray['grpName'] = $grpArray['grpName'];	
					$rowArray['code'] = $outcomeArray['code'];	
					$rowArray['name'] = $outcomeArray['name'];	
					$rowArray['level'] = $outcomeArray['level'];	
					$resultsArray['rows'][] = $rowArray;	
				}
			}
		}	
		return $resultsArray;
	}

	function outcomesAsArray($searchResultsXml='') 
	{ 
	
		$resultsArray = array();
		$grpArray = array();
		$outcomeArray = array();
		
		for ($i = 1; $i <= $searchResultsXml->numNodes('/results/result'); $i++) 
		{
			$tCodePath = '/results/result['.$i.']/xml/item/uni/topic/specs/code';
			$tCode = $searchResultsXml->nodeValue($tCodePath);
			
			for ($j = 1; $j <= $searchResultsXml->numNodes('/results/result['.$i.']/xml/item/uni/course/outcomes/outcome_grps/outcome_grp'); $j++) 
			{
				$oGrpPath = '/results/result['.$i.']/xml/item/uni/course/outcomes/outcome_grps/outcome_grp['.$j.']';
				$oGrpCodePath = $oGrpPath . '/code';
				$oGrpNamePath = $oGrpPath . '/name';
				
				$grpArray = array();
				$grpArray['grpCode'] = $searchResultsXml->nodeValue($oGrpCodePath);
				$grpArray['grpName'] = $searchResultsXml->nodeValue($oGrpNamePath);
				
				for ($k = 1; $k <= $searchResultsXml->numNodes('/results/result['.$i.']/xml/item/uni/course/outcomes/outcome_grps/outcome_grp['.$j.']/outcomes/outcome'); $k++) 
				{
			
					$oPath = '/results/result['.$i.']/xml/item/uni/course/outcomes/outcome_grps/outcome_grp['.$j.']/outcomes/outcome['.$k.']';
					$oCodePath = $oPath . '/code';
					$oNamePath = $oPath . '/name';
					$oLevelPath = $oPath . '/level';
					
					$outcomeArray = array();
					$outcomeArray['code'] = $searchResultsXml->nodeValue($oCodePath);
					$outcomeArray['name'] = $searchResultsXml->nodeValue($oNamePath);
					$outcomeArray['level'] = $searchResultsXml->nodeValue($oLevelPath);
	
					$grpArray['outcomes'][] = $outcomeArray;
	
				}	
				$resultsArray[$tCode][] = $grpArray;
			}	
		}	
		return $resultsArray;
	}


function topicContentAsArray($searchResultsXml='') {
	
	//$contentArray = array();
	
	for ($i = 1; $i <= $searchResultsXml->numNodes('/results/result'); $i++) {
		
		//$contentArray['id']
		$contentTitle = '/results/result['.$i.']/xml/item/itembody/name';
		$activityType = '/results/result['.$i.']/xml/item/som/activities/activity/@type';
		$description = '/results/result['.$i.']/xml/item/som/description';
		$activityOutcomesStem = '/results/result['.$i.']/xml/item/som/activities/activity/activityoutcomes/stem';
		$topicUUID = '/results/result['.$i.']/xml/item/som/activities/activity/activityoutcomes/outcomes';
		$parentLink = '/results/result['.$i.']/xml/item/@id';
		
		
		
		
		$contentArray[$i]['title'] = $searchResultsXml->nodeValue($contentTitle);
		$contentArray[$i]['activitytype'] = $searchResultsXml->nodeValue($activityType);
		$contentArray[$i]['description'] = $searchResultsXml->nodeValue($description);
		
		$contentArray[$i]['topicUUID'] = $searchResultsXml->nodeValue($topicUUID);
		$contentArray[$i]['parentLink'] = $searchResultsXml->nodeValue($parentLink);
		
		
		$contentArray[$i]['activityOutcomesStem'] = $searchResultsXml->nodeValue($activityOutcomesStem);
		
		$contentArray[$i]['outcomes'] = array();
		
		
		for ($j = 1; $j <= $searchResultsXml->numNodes('/results/result['.$i.']/xml/item/som/activities/activity/activityoutcomes/outcomes/outcome'); $j++) {
			
			$outcomeValue = '/results/result['.$i.']/xml/item/som/activities/activity/activityoutcomes/outcomes['.$j.']/outcome';

			$contentArray[$i]['outcomes'][$j] = $searchResultsXml->nodeValue($outcomeValue);
			
		}
		
		
		//echo $i;
		//"<br />";
		
		
	}
	return $contentArray;
	
}


function topicOverviewAsArray($searchResultsXml='') {
	
	//$contentArray = array();
	
	for ($i = 1; $i <= $searchResultsXml->numNodes('/results/result'); $i++) {
		
		//$contentArray['id']
		
		$topicCode = '/results/result['.$i.']/xml/item/uni/topic/specs/code';
		$topicTitle = '/results/result['.$i.']/xml/item/uni/topic/specs/title';
		
		$description = '/results/result['.$i.']/xml/item/uni/topic/specs/description';
		$aims = '/results/result['.$i.']/xml/item/uni/topic/specs/aims';
		$prerequisites = '/results/result['.$i.']/xml/item/uni/topic/specs/prereqs';
		$units = '/results/result['.$i.']/xml/item/uni/topic/specs/units';
		$workload = '/results/result['.$i.']/xml/item/uni/topic/specs/workload';
		$assessment = '/results/result['.$i.']/xml/item/uni/topic/assessment/overview';
		
		$topicUUID = '/results/result['.$i.']/xml/item/@id';
		
		
		$outcomesStem = '/results/result['.$i.']/xml/item/uni/topic/outcomes_stem';
	
		
		
		
		$contentArray[$i]['tcode'] = $searchResultsXml->nodeValue($topicCode);
		$contentArray[$i]['topicTitle'] = $searchResultsXml->nodeValue($topicTitle);
		//$contentArray[$i]['activitytype'] = $searchResultsXml->nodeValue($activityType);
		$contentArray[$i]['description'] = $searchResultsXml->nodeValue($description);
		$contentArray[$i]['aims'] = $searchResultsXml->nodeValue($aims);
		$contentArray[$i]['prerequisites'] = $searchResultsXml->nodeValue($prerequisites);
		$contentArray[$i]['units'] = $searchResultsXml->nodeValue($units);
		$contentArray[$i]['workload'] = $searchResultsXml->nodeValue($workload);
		$contentArray[$i]['assessment'] = $searchResultsXml->nodeValue($assessment);
		
		$contentArray[$i]['topicUUID'] = $searchResultsXml->nodeValue($topicUUID);
		
		$contentArray[$i]['outcomesStem'] = $searchResultsXml->nodeValue($outcomesStem);
		
		
		for ($j = 1; $j <= $searchResultsXml->numNodes('/results/result['.$i.']/xml/item/uni/topic/outcomes/outcome'); $j++) {
			
			$outcomeValue = '/results/result['.$i.']/xml/item/uni/topic/outcomes/outcome['.$j.']/name';

			$contentArray[$i]['outcomes'][$j] = $searchResultsXml->nodeValue($outcomeValue);
			
		}
		
		
		
		//$contentArray[$i]['outcomes'] = array();
		
		
		//for ($j = 1; $j <= $searchResultsXml->numNodes('/results/result['.$i.']/xml/item/som/activities/activity/activityoutcomes/outcomes/outcome'); $j++) {
			
			//$outcomeValue = '/results/result['.$i.']/xml/item/som/activities/activity/activityoutcomes/outcomes['.$j.']/outcome';

		//	$contentArray[$i]['outcomes'][$j] = $searchResultsXml->nodeValue($outcomeValue);
			
	//	}
		
		
		//echo $i;
		//"<br />";
		
		
	}
	return $contentArray;
	
}


function topicActivitiesAsArray($searchResultsXml='') {
	
	//$activitiesArray = array();
	
	for ($i = 1; $i <= $searchResultsXml->numNodes('/results/result'); $i++) {
		
		//$contentArray['id']
		$itemID = '/results/result['.$i.']/xml/item/@id';
		$activityTitle = '/results/result['.$i.']/xml/item/itembody/name';
		$activityType = '/results/result['.$i.']/xml/item/som/activities/activity/@type';
		$outcomesStem = '/results/result['.$i.']/xml/item/som/activities/activity/activityoutcomes/stem';
		
		
		
		
		/*

		$description = '/results/result['.$i.']/xml/item/uni/topic/specs/description';
		$aims = '/results/result['.$i.']/xml/item/uni/topic/specs/aims';
		$prerequisites = '/results/result['.$i.']/xml/item/uni/topic/specs/prereqs';
		$units = '/results/result['.$i.']/xml/item/uni/topic/specs/units';
		$workload = '/results/result['.$i.']/xml/item/uni/topic/specs/workload';
		$assessment = '/results/result['.$i.']/xml/item/uni/topic/assessment/overview';
		
		$topicUUID = '/results/result['.$i.']/xml/item/@id';
		
		
		
	
		*/
		
		
		$activitiesArray[$i]['itemID'] = $searchResultsXml->nodeValue($itemID);
		$activitiesArray[$i]['title'] = $searchResultsXml->nodeValue($activityTitle);
		$activitiesArray[$i]['activitytype'] = $searchResultsXml->nodeValue($activityType);
		
		/*
		//$
		$activitiesArray[$i]['description'] = $searchResultsXml->nodeValue($description);
		$activitiesArray[$i]['aims'] = $searchResultsXml->nodeValue($aims);
		$activitiesArray[$i]['prerequisites'] = $searchResultsXml->nodeValue($prerequisites);
		$activitiesArray[$i]['units'] = $searchResultsXml->nodeValue($units);
		$activitiesArray[$i]['workload'] = $searchResultsXml->nodeValue($workload);
		$activitiesArray[$i]['assessment'] = $searchResultsXml->nodeValue($assessment);
		
		$activitiesArray[$i]['topicUUID'] = $searchResultsXml->nodeValue($topicUUID);
		
		
		
		
		for ($j = 1; $j <= $searchResultsXml->numNodes('/results/result['.$i.']/xml/item/uni/topic/outcomes/outcome'); $j++) {
			
			$outcomeValue = '/results/result['.$i.']/xml/item/uni/topic/outcomes/outcome['.$j.']/name';

			$activitiesArray[$i]['outcomes'][$j] = $searchResultsXml->nodeValue($outcomeValue);
			
		}
		*/
		
		$activitiesArray[$i]['outcomesStem'] = $searchResultsXml->nodeValue($outcomesStem);
		$activitiesArray[$i]['outcomes'] = array();
		
		
		for ($j = 1; $j <= $searchResultsXml->numNodes('/results/result['.$i.']/xml/item/som/activities/activity/activityoutcomes/outcomes'); $j++) {
			
			$outcomeValue = '/results/result['.$i.']/xml/item/som/activities/activity/activityoutcomes/outcomes['.$j.']/outcome';

			$activitiesArray[$i]['outcomes'][$j] = $searchResultsXml->nodeValue($outcomeValue);
			
		}
		
		
		//echo $i;
		//"<br />";
		
		
	}
	return $activitiesArray;
	
}



function activityContentAsArray($searchResultsXml='') {
	
	for ($i = 1; $i <= $searchResultsXml->numNodes('/results/result'); $i++) {
		
		
		// get node values from XML
		$itemID = '/results/result['.$i.']/xml/item/@id';
		$activityTitle = '/results/result['.$i.']/xml/item/itembody/name';
		
		
		$activity = '/results/result['.$i.']/xml/item/som/activities/activity/@type';
		
		
		$activitytype = '/results/result['.$i.']/xml/item/som/activities/activity/@activitytype';
		
		$outcomesStem = '/results/result['.$i.']/xml/item/som/activities/activity/activityoutcomes/stem';
		$parentUUID = '/results/result['.$i.']/xml/item/som/topic/parentUUID';
		$topicCode = '/results/result['.$i.']/xml/item/som/topic/code';
		$topicName = '/results/result['.$i.']/xml/item/som/topic/title';
		
		$description = '/results/result['.$i.']/xml/item/som/description';
		
		$parentlink = '/results/result['.$i.']/xml/item/som/activities/activity/parentlink';
		$parentname = '/results/result['.$i.']/xml/item/som/activities/activity/parentname';
		
		
		
		
		
		
		//write the data to an array
		$activitiesArray[$i]['itemID'] = $searchResultsXml->nodeValue($itemID);
		$activitiesArray[$i]['title'] = $searchResultsXml->nodeValue($activityTitle);
		$activitiesArray[$i]['activity'] = $searchResultsXml->nodeValue($activity);
		if($searchResultsXml->nodeValue($activity) == "Integrated Topic") {
			$activitiesArray[$i]['activitytype'] = $searchResultsXml->nodeValue($activity);
		} else {
			$activitiesArray[$i]['activitytype'] = $searchResultsXml->nodeValue($activitytype);
		}
		$activitiesArray[$i]['parentUUID'] = $searchResultsXml->nodeValue($parentUUID);
		$activitiesArray[$i]['parentlink'] = $searchResultsXml->nodeValue($parentlink);
		$activitiesArray[$i]['parentname'] = $searchResultsXml->nodeValue($parentname);
		$activitiesArray[$i]['topicCode'] = $searchResultsXml->nodeValue($topicCode);
		$activitiesArray[$i]['topicName'] = $searchResultsXml->nodeValue($topicName);
		
		
		$activitiesArray[$i]['description'] = $searchResultsXml->nodeValue($description);
		
		// get responsible people
		for ($j = 1; $j <= $searchResultsXml->numNodes('/results/result['.$i.']/xml/item/som/activities/activity/people/person'); $j++) {
			
			$personName = '/results/result['.$i.']/xml/item/som/activities/activity/people/person['.$j.']/name';
			$personRole = '/results/result['.$i.']/xml/item/som/activities/activity/people/person['.$j.']/role';

			$activitiesArray[$i]['people'][$j]['name'] = $searchResultsXml->nodeValue($personName);
			$activitiesArray[$i]['people'][$j]['role'] = $searchResultsXml->nodeValue($personRole);
			
			
			
		}
		
		
		$activitiesArray[$i]['numOutcomes'] = $searchResultsXml->numNodes('/results/result['.$i.']/xml/item/som/activities/activity/activityoutcomes/outcomes');
		
		// outcomes stem
		
		$activitiesArray[$i]['outcomesStem'] = $searchResultsXml->nodeValue($outcomesStem);
		$ctr = 0;
		
		// get activity outcomes
		for ($j = 1; $j <= $searchResultsXml->numNodes('/results/result['.$i.']/xml/item/som/activities/activity/activityoutcomes/outcomes'); $j++) {
			
			
			
			$outcomeValue = '/results/result['.$i.']/xml/item/som/activities/activity/activityoutcomes/outcomes['.$j.']/outcome';
			$outcomeApplies = '/results/result['.$i.']/xml/item/som/activities/activity/activityoutcomes/outcomes['.$j.']/applicable';

			$activitiesArray[$i]['outcomes'][$j] = $searchResultsXml->nodeValue($outcomeValue);
			$activitiesArray[$i]['applies'][$j] = $searchResultsXml->nodeValue($outcomeApplies);
			if ($activitiesArray[$i]['applies'][$j] == 1) {
				
				$ctr++;
				$activitiesArray[$i]['applicable'][$j]['counter'] = $j;
				$activitiesArray[$i]['applicable'][$j]['outcomevalue'] = $searchResultsXml->nodeValue($outcomeValue);
				
				}
		
			$activitiesArray[$i]['numberApplicable'] = $ctr;
		}
		
		
		
	}
	


	return $activitiesArray;
	
}


function contentActivitiesAsArray($searchResultsXml='') {
	
	for ($i = 1; $i <= $searchResultsXml->numNodes('/results/result'); $i++) {
		
		
		// get node values from XML
		
		//$contentArray['id']
		$itemID = '/results/result['.$i.']/xml/item/@id';
		$activityTitle = '/results/result['.$i.']/xml/item/itembody/name';
		$activityType = '/results/result['.$i.']/xml/item/som/activities/activity/@activitytype';
		
		
		$contentActivitiesArray[$i]['itemID'] = $searchResultsXml->nodeValue($itemID);
		$contentActivitiesArray[$i]['title'] = $searchResultsXml->nodeValue($activityTitle);
		$contentActivitiesArray[$i]['activitytype'] = $searchResultsXml->nodeValue($activityType);

	}


	return $contentActivitiesArray;
	
}


function availabilityCoords($searchResultsXml='') {
	
	
	
	
	for ($i = 1; $i <= $searchResultsXml->numNodes('/results/result/'); $i++) {

		for ($j = 1; $j <= $searchResultsXml->numNodes('/results/result['.$i.']/xml/item/uni/topic/availabilities/availability/coordinators/coordinator'); $j++) {
		
		
		$name = '/results/result['.$i.']/xml/item/uni/topic/availabilities/availability/coordinators/coordinator['.$j.']/name';

		$coordsArray[$i]['coordinators'][$j]['name'] = $searchResultsXml->nodeValue($name);
		
		}
		
	}
	
	

return $coordsArray;
	
}

?>