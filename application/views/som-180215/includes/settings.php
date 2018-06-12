<?php
# endpoint is of the format:
# http://MYSERVER/MYINSTITUTION/services/SoapService51
$endpoint = 'http://flex-dev.flinders.edu.au/services/SoapService51';

$username = 'flex.designer';
$password = 'flex2012';

# Proxies
$proxyHost = null;
$proxyPort = 0;
$proxyUsername = null;
$proxyPassword = null;

# You can specify useTokens = true to append a single-sign-on token to the results of the search result URLs.  
# Note that to use this functionality, the Shared Secrets user management plugin must be enabled (see User Management in the EQUELLA Administration Console)
# and a shared secret must be configured.
$useTokens = true;
$tokenUser = '';
$sharedSecretId = '';
$sharedSecretValue = '';

#required for shared secret token generation.  You will need to set this to the server's own timezone
date_default_timezone_set( 'Australia/Adelaide' );

?>