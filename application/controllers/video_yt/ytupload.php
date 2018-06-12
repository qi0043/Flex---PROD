<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller to download video from Flex item, then upload to Youtube,
 * get the URL to youtube video and attach it to Flex item.
 */
class Ytupload extends CI_Controller 
{
    public function sdkj874HG3kjid7mj($uuid="missed", $version="missed"){
	
	if(strcmp($uuid, 'missed')==0 || strlen($uuid) != 36)
		return false;

	if(strcmp($version, 'missed')==0 || !is_numeric($version))
	    return false;
	#phpinfo();exit();
	session_start();
	// Ignore connection-closing by the client/user
        ignore_user_abort(true);
        $content = 'good';         // Get the content of the output buffer
        #ob_end_clean();                     // Close current output buffer
	$len = strlen($content);             
	header('Content-Type: text/html; charset=UTF-8');
	header('Content-Encoding: none;');
        header('Connection: close');         // Tell the client to close connection
        header("Content-Length: $len");      // Close connection after $size characters
	echo $content;                       // Output content
	ob_flush();
        flush();                             // Force php-output-cache to flush to flex.
                                             
	ob_end_flush();
	
	sleep (5);
	set_time_limit(3600);
	ini_set('memory_limit', '2500M');
	// Call set_include_path() as needed to point to your client library.
	//
	require_once 'autoload.php';
	#set_include_path('google/apiclient/src/');

	require_once 'google/apiclient/src/Google/Client.php';
	require_once 'google/apiclient/src/Google/Service.php';
	require_once 'google/apiclient/src/Google/Model.php';
	require_once 'google/apiclient/src/Google/Collection.php';

	require_once 'google/apiclient/src/Google/Service/Resource.php';
	require_once 'google/apiclient/src/Google/Service/YouTube.php';

	/*
	 * You can acquire an OAuth 2.0 client ID and client secret from the
	 * {{ Google Cloud Console }} <{{ https://cloud.google.com/console }}>
	 * For more information about using OAuth 2.0 to access Google APIs, please see:
	 * <https://developers.google.com/youtube/v3/guides/authentication>
	 * Please ensure that you have enabled the YouTube Data API for your project.
	 */
	$ci =& get_instance();
	$ci->load->config('flex');
	$OAUTH2_CLIENT_ID = $ci->config->item('google_oauth2_client_id');
	$OAUTH2_CLIENT_SECRET = $ci->config->item('google_oauth2_client_secret');
	$key = $ci->config->item('google_oauth2_client_key');
	$htmlBody = '';
	#$OAUTH2_CLIENT_ID = '643418898119-30eda321onv1fs2lss9vmue1397pe9p9.apps.googleusercontent.com';
	#$OAUTH2_CLIENT_SECRET = 'cK5x1YKO9ajtPnrF-4Kk47aL';

	#$key = file_get_contents('application/controllers/test/the_key.txt');

	$client = new Google_Client();
	$client->setClientId($OAUTH2_CLIENT_ID);
	$client->setClientSecret($OAUTH2_CLIENT_SECRET);
	#$client->setScopes('https://www.googleapis.com/auth/youtube');
	$scopes = array("https://www.googleapis.com/auth/youtube", "https://www.googleapis.com/auth/youtube.force-ssl");
        $client->setScopes($scopes);
	$client->setAccessType("offline");
	$client->setAccessToken($key);

	$redirect = filter_var('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],
	    FILTER_SANITIZE_URL);
	$client->setRedirectUri($redirect);

	// Define an object that will be used to make all API requests.
	$youtube = new Google_Service_YouTube($client);

	#$token1 = '{"access_token":"ya29.OQKLdZ8VmdpJfE6ljERoBqR4f6WTKgXaYV0Te7yxyN4JJbuZKsXzsgjpMpKi-VX5jjw1","token_type":"Bearer","expires_in":3600,"refresh_token":"1\/nOGtKNskF6k7_JYX0VXEbqR0L2Rw3yO8v6Y6rlzuoc1IgOrJDtdun6zK6XiATCKT","created":1448595620}';


	$this->load->library('flexrest/flexrest');
	$success = $this->flexrest->processClientCredentialToken();	
	if(!$success)
	{
	    echo 'Error: Failed to connect to FLEX';
	    $tmp_msg = 'Uploading video to Youtube, failed with exception: Failed to connect to FLEX. Item uuid: ' . $uuid;
	    log_message('error', $tmp_msg);
	    #$this->email_to_flex_support($tmp_msg);
	    return;
	}
       
	$success = $this->flexrest->getItemAll($uuid, $version, $response_parent);  
	if(!$success)
	{
	    #$this->flexrest->deleteLock($parent_uuid, $parent_version, $response1);
	    echo 'Error: Failed to get item information from FLEX';
	    $tmp_msg = 'Uploading video to Youtube, failed with exception: Failed to get item info from FLEX. Item uuid: ' . $uuid;
	    log_message('error', $tmp_msg);
	    #$this->email_to_flex_support($tmp_msg);
	    return;
	}
	$parent_item_bean = $response_parent;
	unset($parent_item_bean['headers']);
	$xmlwrapper_name = 'xmlwrapper11';
	$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$parent_item_bean['metadata']), $xmlwrapper_name);
	
	#$youtube_link_node = $this->$xmlwrapper_name->createNodeFromXPath("/xml/item/temp_values/temp9");
	#$this->$xmlwrapper_name->createTextNode($youtube_link_node, $tmp_youtube_link_value);
	$xpath_item_title = '/xml/item/resources/resource/title';
	$item_title = $this->$xmlwrapper_name->nodeValue($xpath_item_title);
	#$xpath_eqvideo = '/xml/item/temp_values/temp8';
	$xpath_eqvideo = '/xml/item/resources/resource/attachments/attachment/source_uuid';
        $uuid_eqvideo = $this->$xmlwrapper_name->nodeValue($xpath_eqvideo);
	#$xpath_eqcaption = '/xml/item/temp_values/temp6';
	$xpath_eqcaption = '/xml/item/resources/resource/attachments/attachment/caption_uuid';
        $uuid_eqcaption = $this->$xmlwrapper_name->nodeValue($xpath_eqcaption);
	#$xpath_tags = '/xml/item/temp_values/temp4';
	$xpath_tags = '/xml/item/resources/resource/tags/tag';
	#$xpath_access = '/xml/item/itembody/access';
	$xpath_access = '/xml/item/resources/resource/access/@category';

	$access_type = 'open-unlisted';
	$access_type = $this->$xmlwrapper_name->nodeValue($xpath_access);
	
	if($access_type != 'open' && $access_type != 'open-unlisted')
	    return;
	
	$tags = array();
	for ($j = 1; $j <= $this->$xmlwrapper_name->numNodes($xpath_tags); $j++) 
        {
            $xpath_tag = $xpath_tags . '['.$j.']';
	    $tag = $this->$xmlwrapper_name->nodeValue($xpath_tag);
	    $tags[] = $tag;
	}
	
	if(!isset($uuid_eqvideo) || strlen($uuid_eqvideo) != 36)
	{
	    echo 'Error: Video not found in item.';
	    $tmp_msg = 'Uploading video to Youtube, failed with exception: Video not found in item. Item uuid: ' . $uuid;
	    log_message('error', $tmp_msg);
	    #$this->email_to_flex_support($tmp_msg);
	    return;
	}

	$existing_attachments = $parent_item_bean['attachments'];
	$num_attachments = count($existing_attachments );
	
	$file_path_video = '';
	for($i=0; $i<$num_attachments; $i++)
	{
	    if($existing_attachments[$i]['type'] == 'file' && $existing_attachments[$i]['uuid'] == $uuid_eqvideo)
	    {
		$file_path_video = $existing_attachments[$i]['filename'];
		break;
	    }
	    
	}
	if($file_path_video == '')
	{
	    echo 'Error: Video not found in item.';
	    $tmp_msg = 'Uploading video to Youtube, failed with exception: Video not found in item. Item uuid: ' . $uuid;
	    log_message('error', $tmp_msg);
	    #$this->email_to_flex_support($tmp_msg);
	    return;
	}
	
	$file_caption = '';
	if(isset($uuid_eqcaption) && strlen($uuid_eqcaption) == 36)
	for($i=0; $i<$num_attachments; $i++)
	{
	    if($existing_attachments[$i]['type'] == 'file' && $existing_attachments[$i]['uuid'] == $uuid_eqcaption)
	    {
		$file_caption = $existing_attachments[$i]['filename'];
		break;
	    }
	    
	}

	$success = $this->flexrest->filesCopy($uuid, $version, $response1);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'video upload failed (filesCopy), item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        if(!isset($response1['headers']['location']))
        {
            $errdata['message'] = 'No Location header in response to copy files REST call.';
            log_message('error', 'video upload failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        $location = $response1['headers']['location'];
        $filearea_uuid = substr($location, strpos($location, 'file')+5, 36);
	
	$success = $this->flexrest->fileDownload($filearea_uuid, $file_path_video, $response_file_video);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'video upload failed (fileDownload), item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
	#unset($response_file_video['headers']);
	
	#echo($response_file_video);
	$file_size_video = strlen((string)$response_file_video);
	
	#Caption file
	$response_file_caption = "";
	$file_size_caption = 0;
	if(isset($uuid_eqcaption) && strlen($uuid_eqcaption) == 36 && $file_caption != "")
	{
	    $success = $this->flexrest->fileDownload($filearea_uuid, $file_caption, $response_file_caption);
	    if(!$success)
	    {
		$tmpmsg = 'video caption file upload failed (fileDownload from FLEX), item uuid: ' . $uuid . ', error: ' . $this->flexrest->error;
		log_message('error', $tmpmsg);
		echo $tmpmsg;
		#return;
	    }
	    $file_size_caption = strlen((string)$response_file_caption);
	}
    
    if (!$client->getAccessToken()) {
	
      #$authUrl = $client->createAuthUrl();
      $htmlBody = "
      <p>authorization needed before proceeding.<p>
       ";
      
      $tmp_msg = 'Uploading video to Youtube, failed with exception: ' . $htmlBody . ' Item uuid: ' . $uuid;
      log_message('error', $tmp_msg);
      $this->email_to_flex_support($tmp_msg);
    
    }
    
    $videoId = "";
    
    try{

	// Create a snippet with title, description, tags and category ID
	// Create an asset resource and set its snippet metadata and type.
	// This example sets the video's title, description, keyword tags, and
	// video category.
	$snippet = new Google_Service_YouTube_VideoSnippet();
	if($item_title == "")
		$item_title = $file_path_video;
	$snippet->setTitle($item_title);
	$snippet->setDescription($item_title);
	if(count($tags) > 0)
	    $snippet->setTags($tags);

	// Numeric video category. See
	// https://developers.google.com/youtube/v3/docs/videoCategories/list 
	#$snippet->setCategoryId("22");

	// Set the video's status to "public". Valid statuses are "public",
	// "private" and "unlisted".
	$status = new Google_Service_YouTube_VideoStatus();
	
	if($access_type == 'open-unlisted')
	    $status->privacyStatus = "unlisted";
	else if($access_type == 'open')
	    $status->privacyStatus = "public";
	else
	    return;

	// Associate the snippet and status objects with a new video resource.
	$video = new Google_Service_YouTube_Video();
	$video->setSnippet($snippet);
	$video->setStatus($status);

	// Specify the size of each chunk of data, in bytes. Set a higher value for
	// reliable connection as fewer chunks lead to faster uploads. Set a lower
	// value for better recovery on less reliable connections.
	$chunkSizeBytes = 400 * 1024 * 1024;

	// Setting the defer flag to true tells the client to return a request which can be calledput set_time_limit(120);
	// with ->execute(); instead of making the API call immediately.
	$client->setDefer(true);

	// Create a request for the API's videos.insert method to create and upload the video.
	$insertRequest = $youtube->videos->insert("status,snippet,player", $video);

    #$data1 = file_get_contents($videoPath); #error_log($data1); echo $data1; return;
	// Create a MediaFileUpload object for resumable uploads.
	$media = new Google_Http_MediaFileUpload(
	    $client,
	    $insertRequest,
	    'video/*',
	    #$data1,
	    #false,
	    #false
	    null,
	    true,
	    $chunkSizeBytes
	);
	#$media->setFileSize(filesize($videoPath));
	#$media->setFileSize($this->curl_get_file_size($videoPath));
	$media->setFileSize($file_size_video);

	// Read the media file and upload it chunk by chunk.
	/*$status = false;
	$handle = fopen($videoPath, "rb");
	while (!$status && !feof($handle)) {
	  $chunk = fread($handle, $chunkSizeBytes);
	  $status = $media->nextChunk($chunk);
	}

	fclose($handle);*/
        $status = false;
        $start = 0;
        #log_message('error', 'in while, file_size = '. $file_size_video);
        while (!$status && $start < $file_size_video) {
          #log_message('error', 'in while, start = '. $start);
	  $len = $chunkSizeBytes;
	  if($len > $file_size_video - $start)
	      $len = $file_size_video - $start;
	  $chunk = substr((string)$response_file_video, $start, $len);
	  #log_message('error', 'a chunk');
	  $status = $media->nextChunk($chunk);
	  $start += $chunkSizeBytes;
	}
        #log_message('error', 'ccc');
	// If you want to make other calls after the file upload, set setDefer back to false
	$client->setDefer(false);

	$htmlBody = '';
	$htmlBody .= "<h3>Video Uploaded</h3><ul>";
	$htmlBody .= sprintf('<li>%s (%s)</li>',
	    $status['snippet']['title'],
	    $status['id']);
        #echo '<pre>'; print_r($status);  echo '</pre>';
	$htmlBody .= '</ul>';
	
	$videoId = $status['id'];
	$title = $status['snippet']['title'] . ' - Youtube';
	$publishedAt = $status['snippet']['publishedAt'];
	
	$embeded_html = $status['player']['embedHtml'];
	#log_message('error', 'Youtube link: ' . $tmp_youtube_link_value);
        
	#Create new attachment UUID
	#$existing_attachments = $parent_item_bean['attachments'];
	#$num_attachments = count($existing_attachments );

	$parent_uuid_first32 = substr($uuid, 0, 32);
	$uuid_suffix = 1000;
	for($i=0; $i<$num_attachments; $i++)
	{
	    $tmp_uuid = $existing_attachments[$i]['uuid'];
	    $tmp_first32 = substr($tmp_uuid, 0, 32);
	    if($tmp_first32 == $parent_uuid_first32)
	    {    
		$tmp_last4 = substr($tmp_uuid, -4);
		if(is_numeric($tmp_last4))
		{
		    $int_last4 = (int)(intval($tmp_last4));
		    if($int_last4 >= $uuid_suffix)
			$uuid_suffix = (int)$int_last4 + 1;
		}
	    }
	}
	
	$new_attachment_uuid = $parent_uuid_first32 . sprintf("%04d", $uuid_suffix);
	#log_message('error', 'eee');
	$linked_video_xpath = "/xml/item/resources/resource/attachments/attachment/uuid";
	$node_linked_video = $this->$xmlwrapper_name->createNodeFromXPath($linked_video_xpath);
	#$node_linked_video_uuid = $this->$xmlwrapper_name->createNode($node_linked_video, "uuid");
	$node_linked_video->nodeValue = $new_attachment_uuid;
	
	$linked_video_xpath1 = "/xml/item/resources/resource/attachments/attachment/youtube_uuid";
	$node_linked_video1 = $this->$xmlwrapper_name->createNodeFromXPath($linked_video_xpath1);
	#$node_linked_video_uuid = $this->$xmlwrapper_name->createNode($node_linked_video, "uuid");
	$node_linked_video1->nodeValue = $new_attachment_uuid;
	
	$embed_xpath = "/xml/item/resources/resource/attachments/attachment/embed_codes/embed";
	$this->$xmlwrapper_name->deleteNodeFromXPath($embed_xpath);
	$node_embed = $this->$xmlwrapper_name->createNodeFromXPath($embed_xpath);
	
	$node_embed_code = $this->$xmlwrapper_name->createNode($node_embed, "code");
	$this->$xmlwrapper_name->createTextNode($node_embed_code, $embeded_html);
	#$node_embed_code->nodeValue = $embeded_html;
	$node_embed_id = $this->$xmlwrapper_name->createNode($node_embed, "id");
	$node_embed_id->nodeValue = $videoId;
        $node_embed_type = $this->$xmlwrapper_name->createAttribute($node_embed, "type");
	$node_embed_type->nodeValue = 'Youtube';
	
	#Remove the youtube attachment if there is already one
	for($i=0; $i<$num_attachments; $i++)
	{
	    if($existing_attachments[$i]['type'] == 'youtube')
	    {
		unset($existing_attachments[$i]);
		break;
	    }
	    
	}
	$num_attachments = count($existing_attachments);
	
	$new_attachment[$num_attachments] = array('type'=>'youtube','uuid'=>$new_attachment_uuid, 'description'=>$title,
		'videoId'=>$videoId,'thumbUrl'=>'https://i.ytimg.com/vi/' . $videoId .'/default.jpg',
                'uploadedDate'=> $publishedAt);

	$parent_item_bean['attachments'] = array_merge($existing_attachments, $new_attachment);
	
	#log_message('error', 'fff');
	$parent_item_bean['metadata'] = $this->$xmlwrapper_name ->__tostring();
	#echo '<pre>'; print_r($parent_item_bean);echo '</pre>';exit();
	$updateparentsuccess = $this->flexrest->editItem($uuid, $version, $parent_item_bean, $updateresponse);
	#$this->flexrest->deleteLock($parent_uuid, $parent_version, $response1);
	if(!$updateparentsuccess)
	{
		    $tmp_msg = 'Uploading video to Youtube, file uploaded but failed to edit Flex item. Item uuid: ' . $uuid . ' Error: ' . $this->flexrest->error;
		    echo $tmp_msg;
		    log_message('error', $tmp_msg);
		    $this->email_to_flex_support($tmp_msg);
		    return;
	}

	echo 'Added Youtube link to FLEX item.<br>';
	
	#Upload the caption file
	if($file_size_caption > 0 && $file_caption != "" && $videoId != "")
	{
    
            $captionLanguage = 'en';
	    $captionSnippet = new Google_Service_YouTube_CaptionSnippet();
	    $captionSnippet->setVideoId($videoId);
	    $captionSnippet->setLanguage($captionLanguage);
	    $captionSnippet->setName($file_caption);

	    # Create a caption with snippet.
	    $caption = new Google_Service_YouTube_Caption();
	    $caption->setSnippet($captionSnippet);

	    // Specify the size of each chunk of data, in bytes. Set a higher value for
	    // reliable connection as fewer chunks lead to faster uploads. Set a lower
	    // value for better recovery on less reliable connections.
	    $chunkSizeBytes = 400 * 1024 * 1024;

	    // Setting the defer flag to true tells the client to return a request which can be called
	    // with ->execute(); instead of making the API call immediately.
	    $client->setDefer(true);

	    // Create a request for the API's captions.insert method to create and upload a caption.
	    $insertRequest = $youtube->captions->insert("snippet", $caption);

	    // Create a MediaFileUpload object for resumable uploads.
	    $media = new Google_Http_MediaFileUpload(
		$client,
		$insertRequest,
		'*/*',
		null,
		true,
		$chunkSizeBytes
	    );
	    $media->setFileSize($file_size_caption);

	    $status = false;
	    $start = 0;
	    #log_message('error', 'in while, file_size = '. $file_size_video);
	    while (!$status && $start < $file_size_caption) {
	      #log_message('error', 'in while, start = '. $start);
	      $len = $chunkSizeBytes;
	      if($len > $file_size_caption - $start)
		  $len = $file_size_caption - $start;
	      $chunk = substr((string)$response_file_caption, $start, $len);
	      #log_message('error', 'a chunk');
	      $status = $media->nextChunk($chunk);
	      $start += $chunkSizeBytes;
	    }

	    // If you want to make other calls after the file upload, set setDefer back to false
	    $client->setDefer(false);

	    $htmlBody .= "<h2>Inserted video caption track for</h2><ul>";
	    $captionSnippet = $status['snippet'];
	    $htmlBody .= sprintf('<li>%s(%s) in %s language, %s status.</li>',
		$captionSnippet['name'], $status['id'], $captionSnippet['language'],
		$captionSnippet['status']);
	    $htmlBody .= '</ul>';
	}
	
      } catch (Google_Service_Exception $e) {
	    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
	        htmlspecialchars($e->getMessage()));
	    $tmp_msg = 'Uploading video to Youtube, failed with exception: ' . $htmlBody . ' Item uuid: ' . $uuid;
	    log_message('error', $tmp_msg);
	    $this->email_to_flex_support($tmp_msg);
	    #return;
      } catch (Google_Exception $e) {
	    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
	        htmlspecialchars($e->getMessage()));
	    $tmp_msg = 'Uploading video to Youtube, failed with exception: ' . $htmlBody . ' Item uuid: ' . $uuid;
	    log_message('error', $tmp_msg);
	    $this->email_to_flex_support($tmp_msg);
	    #return;
      }

     echo $htmlBody;
} 

#Not used
protected function upload_caption(Google_Service_YouTube $youtube, Google_Client $client, $videoId,
    $captionFile, $captionName, $captionLanguage, &$htmlBody)
{
    $captionSnippet = new Google_Service_YouTube_CaptionSnippet();
    $captionSnippet->setVideoId($videoId);
    $captionSnippet->setLanguage($captionLanguage);
    $captionSnippet->setName($captionName);

    # Create a caption with snippet.
    $caption = new Google_Service_YouTube_Caption();
    $caption->setSnippet($captionSnippet);
    
    // Specify the size of each chunk of data, in bytes. Set a higher value for
    // reliable connection as fewer chunks lead to faster uploads. Set a lower
    // value for better recovery on less reliable connections.
    $chunkSizeBytes = 300 * 1024 * 1024;

    // Setting the defer flag to true tells the client to return a request which can be called
    // with ->execute(); instead of making the API call immediately.
    $client->setDefer(true);

    // Create a request for the API's captions.insert method to create and upload a caption.
    $insertRequest = $youtube->captions->insert("snippet", $caption);

    // Create a MediaFileUpload object for resumable uploads.
    $media = new Google_Http_MediaFileUpload(
        $client,
        $insertRequest,
        '*/*',
        null,
        true,
        $chunkSizeBytes
    );
    $media->setFileSize(filesize($captionFile));
    
    // Read the caption file and upload it chunk by chunk.
    $status = false;
    $handle = fopen($captionFile, "rb");
    while (!$status && !feof($handle)) {
      $chunk = fread($handle, $chunkSizeBytes);
      $status = $media->nextChunk($chunk);
    }

    fclose($handle);

    // If you want to make other calls after the file upload, set setDefer back to false
    $client->setDefer(false);

    $htmlBody .= "<h2>Inserted video caption track for</h2><ul>";
    $captionSnippet = $status['snippet'];
    $htmlBody .= sprintf('<li>%s(%s) in %s language, %s status.</li>',
        $captionSnippet['name'], $status['id'], $captionSnippet['language'],
        $captionSnippet['status']);
    $htmlBody .= '</ul>';


}

#Email to flex support
public function email_to_flex_support($message, $subject="Flextra application exception message")
{
    $CI =& get_instance();
    $CI->load->library('email');
    $CI->load->config('flex');
    $config1 = array (
     'mailtype' => 'html',
     'charset'  => 'utf-8',
     'priority' => '3'
    );
    $email_from = 'DoNotReply@flinders.edu.au'; #$CI->config->item('email_from')
    $email_from_title = ''; #$CI->config->item('email_from_title')
    #$email_flex_support = 'flex.support@flinders.edu.au'; #$CI->config->item('email_flex_support')
    $email_flex_support = 'glen.wang@flinders.edu.au';
    
    $this->email->initialize($config1);
    $this->email->from($email_from, $email_from_title);
    $this->email->to($email_flex_support);
    $currentDate = ' - ' .date("d-M-Y") . ' ' . date("H:i:s");
    $message = "<html><body>Dear FLEX Support:<br><br>" . $message . "<br><br>Flextra System</body></html>";
    #$this->email->subject('A New Assignment Extension Request is received - ' .$data['request']['topic'].' '.$data['assignment']['name']  .$currentDate);
    $this->email->subject($subject . $currentDate);
    $this->email->set_mailtype("html");
    $this->email->message($message);	
    $this->email->send();
}

#get oauth token
public function get_oauth_token()
{
 
    require_once 'autoload.php';
	#set_include_path('google/apiclient/src/');

    require_once 'google/apiclient/src/Google/Client.php';
    require_once 'google/apiclient/src/Google/Service.php';
    require_once 'google/apiclient/src/Google/Model.php';
    require_once 'google/apiclient/src/Google/Collection.php';

    require_once 'google/apiclient/src/Google/Service/Resource.php';
    require_once 'google/apiclient/src/Google/Service/YouTube.php';

    session_start();

    /*
     * You can acquire an OAuth 2.0 client ID and client secret from the
     * {{ Google Cloud Console }} <{{ https://cloud.google.com/console }}>
     * For more information about using OAuth 2.0 to access Google APIs, please see:
     * <https://developers.google.com/youtube/v3/guides/authentication>
     * Please ensure that you have enabled the YouTube Data API for your project.
     */
    $ci =& get_instance();
    $ci->load->config('flex');
    $OAUTH2_CLIENT_ID = $ci->config->item('google_oauth2_client_id');
    $OAUTH2_CLIENT_SECRET = $ci->config->item('google_oauth2_client_secret');
    $key = $ci->config->item('google_oauth2_client_key');
    $htmlBody = '';
    $redirect = filter_var('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],
	    FILTER_SANITIZE_URL);

    /*
     * You can acquire an OAuth 2.0 client ID and client secret from the
     * {{ Google Cloud Console }} <{{ https://cloud.google.com/console }}>
     * For more information about using OAuth 2.0 to access Google APIs, please see:
     * <https://developers.google.com/youtube/v3/guides/authentication>
     * Please ensure that you have enabled the YouTube Data API for your project.
     */
    #$OAUTH2_CLIENT_ID = 'XXXXXXX.apps.googleusercontent.com';
    #$OAUTH2_CLIENT_SECRET = 'XXXXXXXXXX';
    $REDIRECT = $redirect;
    #$REDIRECT = 'http://localhost/oauth2callback.php';
    $APPNAME = "Flextra video";


    $client = new Google_Client();
    $client->setClientId($OAUTH2_CLIENT_ID);
    $client->setClientSecret($OAUTH2_CLIENT_SECRET);
    $scopes = array("https://www.googleapis.com/auth/youtube", "https://www.googleapis.com/auth/youtube.force-ssl");
    $client->setScopes($scopes);
    $client->setRedirectUri($REDIRECT);
    $client->setApplicationName($APPNAME);
    $client->setAccessType('offline');


    // Define an object that will be used to make all API requests.
    $youtube = new Google_Service_YouTube($client);

    if (isset($_GET['code'])) {
	if (strval($_SESSION['state']) !== strval($_GET['state'])) {
	    die('The session state did not match.');
	}

	$client->authenticate($_GET['code']);
	$_SESSION['token'] = $client->getAccessToken();

    }

    if (isset($_SESSION['token'])) {
	$client->setAccessToken($_SESSION['token']);
	echo '<code>' . $_SESSION['token'] . '</code>';
    }

    // Check to ensure that the access token was successfully acquired.
    if ($client->getAccessToken()) {
	try {
	    // Call the channels.list method to retrieve information about the
	    // currently authenticated user's channel.
	    $channelsResponse = $youtube->channels->listChannels('contentDetails', array(
		'mine' => 'true',
	    ));

	    $htmlBody = '';
	    foreach ($channelsResponse['items'] as $channel) {
		// Extract the unique playlist ID that identifies the list of videos
		// uploaded to the channel, and then call the playlistItems.list method
		// to retrieve that list.
		$uploadsListId = $channel['contentDetails']['relatedPlaylists']['uploads'];

		$playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', array(
		    'playlistId' => $uploadsListId,
		    'maxResults' => 50
		));

		$htmlBody .= "<h3>Videos in list $uploadsListId</h3><ul>";
		foreach ($playlistItemsResponse['items'] as $playlistItem) {
		    $htmlBody .= sprintf('<li>%s (%s)</li>', $playlistItem['snippet']['title'],
			$playlistItem['snippet']['resourceId']['videoId']);
		}
		$htmlBody .= '</ul>';
	    }
	} catch (Google_ServiceException $e) {
	    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
		htmlspecialchars($e->getMessage()));
	} catch (Google_Exception $e) {
	    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
		htmlspecialchars($e->getMessage()));
	}

	$_SESSION['token'] = $client->getAccessToken();
    } else {
	$state = mt_rand();
	$client->setState($state);
	$_SESSION['state'] = $state;

	$authUrl = $client->createAuthUrl();
	$htmlBody = "
      <h3>Authorization Required</h3>
      <p>You need to <a href='$authUrl'>authorise access</a> before proceeding.<p>
      ";
    }
    
    echo "
    <!doctype html>
    <html>
    <head>
	<title>My Uploads</title>
    </head>
    <body>
    $htmlBody
    </body>
    </html>";
}

/**Not used
 * Returns the size of a file without downloading it, or -1 if the file
 * size could not be determined.
 *
 * @param $url - The location of the remote file to download. Cannot
 * be null or empty.
 *
 * @return The size of the file referenced by $url, or -1 if the size
 * could not be determined.
 */
 function curl_get_file_size( $url ) {
  // Assume failure.
  $result = -1;
  log_message('error', 'inside curl 1');
  $curl = curl_init( $url );

  // Issue a HEAD request and follow any redirects.
  curl_setopt( $curl, CURLOPT_NOBODY, true );
  curl_setopt( $curl, CURLOPT_HEADER, true );
  curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
  curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
  #curl_setopt( $curl, CURLOPT_USERAGENT, get_user_agent_string() );

  $data = curl_exec( $curl );
    $size = curl_getinfo($curl, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
  curl_close( $curl );
    return $size;

  if( $data ) {
    $content_length = "unknown";
    $status = "unknown";

    if( preg_match( "/^HTTP\/1\.[01] (\d\d\d)/", $data, $matches ) ) {
      $status = (int)$matches[1];
    }

    if( preg_match( "/Content-Length: (\d+)/", $data, $matches ) ) {
      $content_length = (int)$matches[1];
    }

    // http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
    if( $status == 200 || ($status > 300 && $status <= 308) ) {
      $result = $content_length;
    }
  }

  return $result;
}


   
}