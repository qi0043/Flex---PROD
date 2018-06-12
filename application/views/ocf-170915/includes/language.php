<?php



switch(strtolower($courses['code'])) {
	
	
	case 'md':
		$title = "MD Curriculum Framework";
		$coursestring = "Medical Graduate Outcomes";
		$coursestringlong = "Flinders Medical Graduate Outcomes";
		$coursestringsingle = "Flinders Medical Graduate Outcome";
		$profstring = "AMC Graduate Outcomes";
		$profstringsingle = "AMC Graduate Outcome";
		$profstringlong = "Australian Medical Council Graduate Outcomes";
		
		
		$profdomain[1]['code'] = "SS";
		$profdomain[1]['name'] = "Science and Scholarship";
		$profdomain[1]['number'] = 6;
		$profdomain[1]['start'] = 1;
		$profdomain[1]['class'] = "bg-info";

		$profdomain[2]['code'] = "CP";
		$profdomain[2]['name'] = "Clinical Practice";
		$profdomain[2]['number'] = 15;
		$profdomain[2]['start'] = 7;
		$profdomain[2]['class'] = "bg-warning";
		
		$profdomain[3]['code'] = "HS";
		$profdomain[3]['name'] = "Health and Society";
		$profdomain[3]['number'] = 9;
		$profdomain[3]['start'] = 22;
		$profdomain[3]['class'] = "bg-success";
		
		$profdomain[4]['code'] = "PL";
		$profdomain[4]['name'] = "Professionalism and Leadership";
		$profdomain[4]['number'] = 10;
		$profdomain[4]['start'] = 31;
		$profdomain[4]['class'] = "bg-danger";
		
		
		$coursedomain[1]['code'] = "SS";
		$coursedomain[1]['name'] = "Science and Scholarship";
		$coursedomain[1]['number'] = 1;
		$coursedomain[1]['class'] = "bg-info";

		$coursedomain[2]['code'] = "CP";
		$coursedomain[2]['name'] = "Clinical Practice";
		$coursedomain[2]['number'] = 3;
		$coursedomain[2]['class'] = "bg-warning";
		
		$coursedomain[3]['code'] = "HS";
		$coursedomain[3]['name'] = "Health and Society";
		$coursedomain[3]['number'] = 1;
		$coursedomain[3]['class'] = "bg-success";
		
		$coursedomain[4]['code'] = "PL";
		$coursedomain[4]['name'] = "Professionalism and Leadership";
		$coursedomain[4]['number'] = 3;
		$coursedomain[4]['class'] = "bg-danger";
		
		break;
	
	
	
	case 'bmid':
		$title = "B Midwifery Curriculum Framework";
		$coursestring = "B Midwifery Course Outcomes";
		$coursestringlong = "Flinders B Midwifery Course Outcomes";
		$coursestringsingle = "Flinders B Midwifery Course Outcome";
		$profstring = "ANMC National Competency Standards";
		$profstringsingle = "ANMC National Competency Standard";
		$profstringlong = "Australian Nursing and Midwifery Council National Competency Standards (2006)";
		
		$profdomain = array();
		
		$profdomain[1]['code'] = "LP";
		$profdomain[1]['name'] = "Legal and professional practice";
		$profdomain[1]['number'] = 24;
		$profdomain[1]['start'] = 1;
		$profdomain[1]['class'] = "bg-info";

		
		$profdomain[2]['code'] = "KP";
		$profdomain[2]['name'] = "Midwifery knowledge and practice";
		$profdomain[2]['number'] = 40;
		$profdomain[2]['start'] = 25;
		$profdomain[2]['class'] = "bg-warning";
		
		$profdomain[3]['code'] = "PHC";
		$profdomain[3]['name'] = "Midwifery as primary health care";
		$profdomain[3]['number'] = 23;
		$profdomain[3]['start'] = 65;
		$profdomain[3]['class'] = "bg-success";
		
		$profdomain[4]['code'] = "REP";
		$profdomain[4]['name'] = "Reflective and ethical practice";
		$profdomain[4]['number'] = 27;
		$profdomain[4]['start'] = 88;
		$profdomain[4]['class'] = "bg-danger";
		
		$coursedomain[1]['code'] = "&nbsp;";
		$coursedomain[1]['name'] = "&nbsp;";
		$coursedomain[1]['number'] = 7;
		$coursedomain[1]['class'] = "bg-info";
		
		break;
}


?>