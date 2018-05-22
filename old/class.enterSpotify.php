<?php

// based it on Session.php from spotify-web-api-php

// GET https://accounts.spotify.com/authorize/?client_id=5fe01282e44241328a84e7c5cc169165&response_type=code&redirect_uri=https%3A%2F%2Fexample.com%2Fcallback&scope=user-read-private%20user-read-email&state=34fFs29kd09

// BREAKING DOWN THE ABOVE ... what are each of these?

// GET https://accounts.spotify.com/authorize/

// ?client_id=5fe01282e44241328a84e7c5cc169165

// &response_type=code

// &redirect_uri=https%3A%2F%2Fexample.com%2Fcallback

// &scope=user-read-private%20user-read-email

// &state=34fFs29kd09

// AUTHORIZATION CODE FLOW (my side aka client side)

// 1. REQUEST AUTHORIZATION with clientID, response_type, redirect_uri, state, scope
// step 1 uses URL above
// uses SESSION file
// returns code, state and it looks like this 
// https://www.roxorsoxor.com/poprock/poprock.htm?code=SomethingGoesHere&state=AndSomethingElseGoesHere

// 2. REQUEST ACCESS AND REFRESH TOKENS with clientID, client_secret, grant_type, code, redirect_uri
// When the authorization code has been received (above), you will need to exchange it with an access token by making a POST request to the Spotify Accounts service, this time to its /api/token endpoint using something like this
// POST https://accounts.spotify.com/api/token
// grant_type=authorization_code
// uses REQUEST file
// returns access_token, token_type, expires_in, refresh_token

// 3. USE ACCESS TOKENS IN REQUESTS TO WEB API with access_token
// uses SPOTIFYWEBAPI file
// returns JSON object

// 4. REQUEST REFRESHED ACCESS TOKEN with clientID, client_secret, grant_type, code, refresh_token
// returns access token

// go back to step 3

var $baseURL = 'https://accounts.spotify.com/authorize/';


// also require database access file

class entrance {

	require_once 'spotifySecrets.php';
	protected $expirationTime = 0;
	protected $accessToken = '';
	protected $refreshToken = '';
	protected $request = null;

	// need a basic URL for this to add to

	public function __construct ($clientID, $clientSecret, $redirectURI = '') {

		// where does it get base URL from?

		$this -> setClientID ($clientID);
		$this -> setClientSecret ($clientSecret);
		$this -> setRedirectURI ($redirectURI);

		// I don't understand this next line
		// OK, I understand it but am unfamiliar with language and structure
		$this->request = $request ?: new Request();
	}

	function set_artistID ($new_artistID) {
		$this -> artistID = $new_artistID;
	}

	function get_artistID () {
		return $this -> artistID;
	}

	function set_artistName ($new_artistName) {
		$this -> artistName = $new_artistName;
	}

	function get_artistName () {
		return $this -> artistName;
	}


}

?>