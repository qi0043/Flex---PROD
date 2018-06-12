<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Showtest extends CI_Controller {

    protected $metadataxml = '<xml itemdefid="07da6b70-1f79-488c-9fc6-45a1318ba3f9"><item version="1"><uni><topic type="SAM"><assessment><approval><approved>Approved</approved></approval><items><item><name>Assignment 1</name><proportion>10</proportion><deadline>8/4/2013</deadline><penalties>See Section 7.2 of Topic Information Book</penalties><return_date>2 weeks after submission</return_date></item><item><name>Assignment 2</name><proportion>15</proportion><deadline>13/5/2013</deadline><penalties>See Section 7.2 of Topic Information Book</penalties><return_date>2 weeks after submission</return_date></item><item><name>Assignment 3</name><proportion>15</proportion><deadline>3/6/2013</deadline><penalties>See Section 7.2 of Topic Information Book</penalties><return_date>2 weeks after submission</return_date></item><item><name>Examination</name><proportion>60</proportion><deadline>Semester 1 examination period</deadline><penalties>See Section 7.3 of Topic Information Book</penalties><return_date>In accordance with University policy</return_date></item></items><integrity><text_matching_used>No</text_matching_used></integrity><scaling><used>No</used></scaling><resubmission><permitted>No</permitted></resubmission><distributed>2013-03-06</distributed><pass>&lt;p&gt;&lt;strong&gt;A cumulative mark of 50% or greater for the year&lt;/strong&gt;&lt;/p&gt;n</pass><special_contact>&lt;p&gt;&lt;strong&gt;Extension of the due dates for any of the 3 assignments&lt;/strong&gt; will be granted on medical / compassionate grounds only, and the following procedure must be followed:&lt;/p&gt;n&lt;p&gt;Contact a topic coordinator &#x2013; Students who believe that their ability to satisfy the assignment submission deadlines for this topic has been or will be affected due to medical, compassionate or other special circumstances may apply to a topic coordinator for consideration of an extension. The preferred method of application is email (&lt;a shape=&quot;rect&quot; href=&quot;mailto:karen.lower@flinders.edu.au&quot;&gt;karen.lower@flinders.edu.au&lt;/a&gt;).&lt;/p&gt;n&lt;p&gt;Extensions may be granted where the following criteria apply:&lt;/p&gt;n&lt;ul&gt;&lt;li&gt;the student has made a written request for an extension prior to the due date for the assessment item; and&lt;/li&gt;&lt;li&gt;the student has justified the request on the basis of unforeseen individual circumstances that are reasonably likely to prevent completion of the assessment by the specified due date.&lt;/li&gt;&lt;/ul&gt;n&lt;p&gt;Any extension granted will specify in writing a new due date for submission of the assessment item, by which date the student can submit the work without a penalty being applied.&lt;/p&gt;n&lt;p&gt;&lt;strong&gt;Where extensions are granted beyond the end of the semester,&lt;/strong&gt; the &#x201c;Application for Supplementary Assessment or Extension on Medical or Compassionate Grounds&#x201d; form must be completed in full. A sample of the form is available online at: &lt;a shape=&quot;rect&quot; href=&quot;http://www.flinders.edu.au/current-students/exams-assess-results/examinations/examination-forms.cfm&quot; target=&quot;_blank&quot;&gt;http://www.flinders.edu.au/current-students/exams-assess-results/examinations/examination-forms.cfm&lt;/a&gt;&lt;/p&gt;n</special_contact></assessment><used_in><topics><uuid>0f4dd9b3-a837-4e67-940a-1ff96a9929bc</uuid><code>MMED2934</code><title>Introduction to Human Molecular Genetics</title><units>4.5</units><school>School of Medicine</school><eq_topic>3086f481-fb9a-4b34-8070-8a931b8b8820</eq_topic></topics><availabilities><eq_availability>15d185b9-353c-4a66-86e5-e44508f046ca</eq_availability><availability><uuid>ca976dcf-fa55-4a94-b6e7-fba1444f53ef</uuid><name>MMED2934: 2013, Semester 1</name><year>2013</year><duration>Semester 1</duration><other/><location/><coordinators><coordinators><coordinator><fan>lowe0022</fan><name>Dr Karen Lower</name><phone>8204 6563</phone><location/></coordinator><coordinator><fan>syke0019</fan><name>Prof Pam Sykes</name><phone>8204 4379</phone><location/></coordinator></coordinators></coordinators></availability></availabilities></used_in><outcomes><outcome><name>a broad knowledge of human molecular genetics</name><assessments><assessment>Assignment 1</assessment><assessment>Assignment 2</assessment><assessment>Assignment 3</assessment><assessment>Examination</assessment></assessments></outcome><outcome><name>a detailed understanding of the applications of genetic techniques to human disease</name><assessments><assessment>Assignment 1</assessment><assessment>Assignment 2</assessment><assessment>Assignment 3</assessment><assessment>Examination</assessment></assessments></outcome><outcome><name>a knowledge of contemporary issues in human genetics</name><assessments><assessment>Assignment 1</assessment><assessment>Assignment 2</assessment><assessment>Examination</assessment></assessments></outcome><outcome><name>an application of knowledge to problem solving in human genetics</name><assessments><assessment>Assignment 1</assessment><assessment>Assignment 2</assessment><assessment>Assignment 3</assessment><assessment>Examination</assessment></assessments></outcome></outcomes></topic><course><grad_attributes><grad_attribute><code>GQ1</code><name>Are knowledgeable</name><assessments><assessment>Assignment 1</assessment><assessment>Assignment 2</assessment><assessment>Assignment 3</assessment><assessment>Examination</assessment></assessments></grad_attribute><grad_attribute><code>GQ2</code><name>Can apply their knowledge</name><assessments><assessment>Assignment 1</assessment><assessment>Assignment 2</assessment><assessment>Assignment 3</assessment><assessment>Examination</assessment></assessments></grad_attribute><grad_attribute><code>GQ3</code><name>Communicate effectively</name><assessments><assessment>Assignment 1</assessment><assessment>Assignment 2</assessment><assessment>Examination</assessment></assessments></grad_attribute><grad_attribute><code>GQ4</code><name>Can work independently</name><assessments><assessment>Assignment 1</assessment><assessment>Assignment 2</assessment><assessment>Assignment 3</assessment><assessment>Examination</assessment></assessments></grad_attribute><grad_attribute><code>GQ5</code><name>Are collaborative</name><assessments/></grad_attribute><grad_attribute><code>GQ6</code><name>Value ethical behaviour</name><assessments><assessment>Assignment 1</assessment><assessment>Assignment 2</assessment><assessment>Assignment 3</assessment><assessment>Examination</assessment></assessments></grad_attribute><grad_attribute><code>GQ7</code><name>Connect across boundaries</name><assessments><assessment>Assignment 2</assessment><assessment>Examination</assessment></assessments></grad_attribute></grad_attributes></course></uni><itembody><name>SAM for MMED2934 Introduction to Human Molecular Genetics</name></itembody><rating/><badurls><url message="This host has been blocked. If you own this device and believe that this is an error, please contact the ITS Help Desk at Flinders University." status="403" tries="25" url="http://www.flinders.edu.au/current-students/exams-assess-results/examinations/examination-forms.cfm"/></badurls><history><contributed applies="false" date="2013-05-15T09:25:23+0930" state="draft" user="couc0005">couc0005</contributed><edit applies="false" date="2013-05-15T09:25:23+0930" state="draft" user="couc0005">couc0005</edit><statechange applies="false" date="2013-05-15T09:25:23+0930" state="live" user="couc0005">couc0005</statechange></history><moderation><liveapprovaldate>2013-05-15T09:25:23+0930</liveapprovaldate></moderation></item></xml>';
    
    public function index()
    {
        $this->load->helper('url');

        $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => $this->metadataxml));
        $sam_array = $this->samXml2Array($this->xmlwrapper);
        
        $data = array('sam_array' => $sam_array);
        $this->load->view('sam/showtest_view', $data);
    }
    
    function samXml2Array($itemXml='') 
    { 

        $topicCode = '/xml/item/uni/topic/used_in/topics/code';
        $topicTitle = '/xml/item/uni/topic/used_in/topics/title';
        $topicUnits = '/xml/item/uni/topic/used_in/topics/units';
        $topicSchool = '/xml/item/uni/topic/used_in/topics/school';

        $approval = '/xml/item/uni/topic/assessment/distributed';

        $samsArray['metadata']['tcode'] = $itemXml->nodeValue($topicCode);
        $samsArray['metadata']['topicTitle'] = $itemXml->nodeValue($topicTitle);
        $samsArray['metadata']['topicUnits'] = $itemXml->nodeValue($topicUnits);
        $samsArray['metadata']['topicSchool'] = $itemXml->nodeValue($topicSchool);

        $samsArray['metadata']['approval'] = $itemXml->nodeValue($approval);

        // get availabilities information
        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/uni/topic/used_in/availabilities/availability'); $j++) 
        {

            $avYear = '/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/year';
            $avDuration = '/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/duration';
            $avLocation = '/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/location';
            $avCoordName = '/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/coordinators/coordinators/coordinator/name';
            $avCoordPhone = '/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/coordinators/coordinators/coordinator/phone';
            $avCoordLocation = '/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/coordinators/coordinators/coordinator/location';


            $samsArray['metadata']['availability'][$j]['avYear'] = $itemXml->nodeValue($avYear);
            $samsArray['metadata']['availability'][$j]['avDuration'] = $itemXml->nodeValue($avDuration);
            $samsArray['metadata']['availability'][$j]['avLocation'] = $itemXml->nodeValue($avLocation);
            $samsArray['metadata']['availability'][$j]['avCoordName'] = $itemXml->nodeValue($avCoordName);
            $samsArray['metadata']['availability'][$j]['avCoordPhone'] = $itemXml->nodeValue($avCoordPhone);
            $samsArray['metadata']['availability'][$j]['avCoordLocation'] = $itemXml->nodeValue($avCoordLocation);

        }


        // assessable tasks
        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/uni/topic/outcomes/outcome'); $j++) 
        {

            $name = '/xml/item/uni/topic/outcomes/outcome['.$j.']/name';
            $samsArray['metadata']['topicalign'][$j]['name'] = $itemXml->nodeValue($name);


            for ($k = 1; $k <= $itemXml->numNodes('/xml/item/uni/topic/outcomes/outcome['.$j.']/assessments/assessment'); $k++) 
            {

                    $assessment = '/xml/item/uni/topic/outcomes/outcome['.$j.']/assessments/assessment['.$k.']';
                    //$samsArray['metadata']['topicalign'][$j]['assessment'][$k] ='text'; 

                    $samsArray['metadata']['topicalign'][$j]['assessment'][$k] = $itemXml->nodeValue($assessment); 

            }

                //$samsArray['metadata']['topicalign'][$j]['numItems'] = [$k]; 

        }

        // graduate qualities
        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/uni/course/grad_attributes/grad_attribute'); $j++) 
        {

            $name = '/xml/item/uni/course/grad_attributes/grad_attribute['.$j.']/name';
            $code = '/xml/item/uni/course/grad_attributes/grad_attribute['.$j.']/code';
            $samsArray['metadata']['gradattribute'][$j]['name'] = $itemXml->nodeValue($name);
            $samsArray['metadata']['gradattribute'][$j]['code'] = $itemXml->nodeValue($code);


            for ($k = 1; $k <= $itemXml->numNodes('/xml/item/uni/course/grad_attributes/grad_attribute['.$j.']/assessments/assessment'); $k++) {

                    $assessment = '/xml/item/uni/course/grad_attributes/grad_attribute['.$j.']/assessments/assessment['.$k.']';
                    //$samsArray['metadata']['topicalign'][$j]['assessment'][$k] ='text'; 

                    $samsArray['metadata']['gradattribute'][$j]['assessment'][$k] = $itemXml->nodeValue($assessment); 

            }

                //$samsArray['metadata']['topicalign'][$j]['numItems'] = [$k]; 

        }

        // topic alignment
        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/uni/topic/assessment/items/item'); $j++) 
        {

            $name = '/xml/item/uni/topic/assessment/items/item['.$j.']/name';
            $proportion = '/xml/item/uni/topic/assessment/items/item['.$j.']/proportion';
            $deadline = '/xml/item/uni/topic/assessment/items/item['.$j.']/deadline';
            $penalties = '/xml/item/uni/topic/assessment/items/item['.$j.']/penalties';
            $return = '/xml/item/uni/topic/assessment/items/item['.$j.']/return_date';



            $samsArray['metadata']['assessment'][$j]['name'] = $itemXml->nodeValue($name);
            $samsArray['metadata']['assessment'][$j]['proportion'] = $itemXml->nodeValue($proportion);
            $samsArray['metadata']['assessment'][$j]['deadline'] = $itemXml->nodeValue($deadline);
            $samsArray['metadata']['assessment'][$j]['penalties'] = $itemXml->nodeValue($penalties);
            $samsArray['metadata']['assessment'][$j]['return'] = $itemXml->nodeValue($return);

        }

        $resubmissionPermitted = '/xml/item/uni/topic/assessment/resubmission/permitted';
        $resubmissionDetail = '/xml/item/uni/topic/assessment/resubmission/detail';

        $academicIntegrity = '/xml/item/uni/topic/assessment/integrity';

        $pass = '/xml/item/uni/topic/assessment/pass';

        $consideration = '/xml/item/uni/topic/assessment/special_contact';

        $samsArray['metadata']['pass'] = $itemXml->nodeValue($pass);
        $samsArray['metadata']['consideration'] = $itemXml->nodeValue($consideration);

        $samsArray['metadata']['resubmissionPermitted'] = $itemXml->nodeValue($resubmissionPermitted);
        $samsArray['metadata']['resubmissionDetail'] = $itemXml->nodeValue($resubmissionDetail);

        $samsArray['metadata']['academicIntegrity'] = $itemXml->nodeValue($academicIntegrity);		

        return $samsArray;

    }
    
    	
        
}
