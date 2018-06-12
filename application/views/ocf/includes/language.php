<?php


if(isset($courses['code']))
{
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


			case 'mspp':
			$title = "M Speech Pathology Curriculum Framework";
			$coursestring = NULL;
			//$coursestringlong = "Flinders Medical Graduate Outcomes";
			//$coursestringsingle = "Flinders Medical Graduate Outcome";
			$profstring = "Competency-based Occupational Standards ";
			$profstringsingle = "CBOS";
			$profstringlong = "Competency-based Occupational Standards for Speech Pathologists";


			$profdomain[1]['code'] = "LaPd";
			$profdomain[1]['name'] = "Language: Paediatric";
			$profdomain[1]['number'] = 11;
			$profdomain[1]['start'] = 1;
			$profdomain[1]['class'] = "bg-info";


			$profdomain[2]['code'] = "LaA";
			$profdomain[2]['name'] = "Language: Adult";
			$profdomain[2]['number'] = 11;
			$profdomain[2]['start'] = 12;
			$profdomain[2]['class'] = "bg-warning";


			$profdomain[3]['code'] = "SpPd";
			$profdomain[3]['name'] = "Speech: Paediatric";
			$profdomain[3]['number'] = 11;
			$profdomain[3]['start'] = 23;
			$profdomain[3]['class'] = "bg-info";

			$profdomain[4]['code'] = "SpA";
			$profdomain[4]['name'] = "Speech: Adult";
			$profdomain[4]['number'] = 11;
			$profdomain[4]['start'] = 34;
			$profdomain[4]['class'] = "bg-warning";

			$profdomain[5]['code'] = "SwPd";
			$profdomain[5]['name'] = "Swallowing: Paediatric";
			$profdomain[5]['number'] = 11;
			$profdomain[5]['start'] = 45;
			$profdomain[5]['class'] = "bg-info";

			$profdomain[6]['code'] = "SwA";
			$profdomain[6]['name'] = "Swallowing: Adult";
			$profdomain[6]['number'] = 11;
			$profdomain[6]['start'] = 56;
			$profdomain[6]['class'] = "bg-warning";

			$profdomain[7]['code'] = "VoPd";
			$profdomain[7]['name'] = "Voice: Paediatric";
			$profdomain[7]['number'] = 11;
			$profdomain[7]['start'] = 67;
			$profdomain[7]['class'] = "bg-info";

			$profdomain[8]['code'] = "VoA";
			$profdomain[8]['name'] = "Voice: Adult";
			$profdomain[8]['number'] = 11;
			$profdomain[8]['start'] = 78;
			$profdomain[8]['class'] = "bg-warning";

			$profdomain[9]['code'] = "FlPd";
			$profdomain[9]['name'] = "Fluency: Paediatric";
			$profdomain[9]['number'] = 11;
			$profdomain[9]['start'] = 89;
			$profdomain[9]['class'] = "bg-info";

			$profdomain[10]['code'] = "FlA";
			$profdomain[10]['name'] = "Fluency: Adult";
			$profdomain[10]['number'] = 11;
			$profdomain[10]['start'] = 100;
			$profdomain[10]['class'] = "bg-warning";

			$profdomain[11]['code'] = "MuPd";
			$profdomain[11]['name'] = "Multi-modal Communication: Paediatric";
			$profdomain[11]['number'] = 11;
			$profdomain[11]['start'] = 111;
			$profdomain[11]['class'] = "bg-info";

			$profdomain[12]['code'] = "MuA";
			$profdomain[12]['name'] = "Multi-modal Communication: Adult";
			$profdomain[12]['number'] = 11;
			$profdomain[12]['start'] = 122;
			$profdomain[12]['class'] = "bg-warning";






			break;

			case 'bspp':
			$title =  "B Speech Pathology Curriculum Framework";
			$coursestring = NULL;
			//$coursestringlong = "Flinders Medical Graduate Outcomes";
			//$coursestringsingle = "Flinders Medical Graduate Outcome";
			$profstring = "Competency-based Occupational Standards ";
			$profstringsingle = "CBOS";
			$profstringlong = "Competency-based Occupational Standards for Speech Pathologists";


			$profdomain[1]['code'] = "LaPd";
			$profdomain[1]['name'] = "Language: Paediatric";
			$profdomain[1]['number'] = 11;
			$profdomain[1]['start'] = 1;
			$profdomain[1]['class'] = "bg-info";


			$profdomain[2]['code'] = "LaA";
			$profdomain[2]['name'] = "Language: Adult";
			$profdomain[2]['number'] = 11;
			$profdomain[2]['start'] = 12;
			$profdomain[2]['class'] = "bg-warning";


			$profdomain[3]['code'] = "SpPd";
			$profdomain[3]['name'] = "Speech: Paediatric";
			$profdomain[3]['number'] = 11;
			$profdomain[3]['start'] = 23;
			$profdomain[3]['class'] = "bg-info";

			$profdomain[4]['code'] = "SpA";
			$profdomain[4]['name'] = "Speech: Adult";
			$profdomain[4]['number'] = 11;
			$profdomain[4]['start'] = 34;
			$profdomain[4]['class'] = "bg-warning";

			$profdomain[5]['code'] = "SwPd";
			$profdomain[5]['name'] = "Swallowing: Paediatric";
			$profdomain[5]['number'] = 11;
			$profdomain[5]['start'] = 45;
			$profdomain[5]['class'] = "bg-info";

			$profdomain[6]['code'] = "SwA";
			$profdomain[6]['name'] = "Swallowing: Adult";
			$profdomain[6]['number'] = 11;
			$profdomain[6]['start'] = 56;
			$profdomain[6]['class'] = "bg-warning";

			$profdomain[7]['code'] = "VoPd";
			$profdomain[7]['name'] = "Voice: Paediatric";
			$profdomain[7]['number'] = 11;
			$profdomain[7]['start'] = 67;
			$profdomain[7]['class'] = "bg-info";

			$profdomain[8]['code'] = "VoA";
			$profdomain[8]['name'] = "Voice: Adult";
			$profdomain[8]['number'] = 11;
			$profdomain[8]['start'] = 78;
			$profdomain[8]['class'] = "bg-warning";

			$profdomain[9]['code'] = "FlPd";
			$profdomain[9]['name'] = "Fluency: Paediatric";
			$profdomain[9]['number'] = 11;
			$profdomain[9]['start'] = 89;
			$profdomain[9]['class'] = "bg-info";

			$profdomain[10]['code'] = "FlA";
			$profdomain[10]['name'] = "Fluency: Adult";
			$profdomain[10]['number'] = 11;
			$profdomain[10]['start'] = 100;
			$profdomain[10]['class'] = "bg-warning";

			$profdomain[11]['code'] = "MuPd";
			$profdomain[11]['name'] = "Multi-modal Communication: Paediatric";
			$profdomain[11]['number'] = 11;
			$profdomain[11]['start'] = 111;
			$profdomain[11]['class'] = "bg-info";

			$profdomain[12]['code'] = "MuA";
			$profdomain[12]['name'] = "Multi-modal Communication: Adult";
			$profdomain[12]['number'] = 11;
			$profdomain[12]['start'] = 122;
			$profdomain[12]['class'] = "bg-warning";

			break;


			case 'md2017':
			$title = "MD2017 Curriculum Framework";
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

			case 'md2018':
            $title = "MD2018 Curriculum Framework";
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
	}
}


?>
