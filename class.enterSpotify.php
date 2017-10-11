<?php

require spotifySecrets.php;
// also require database access file

class entrance {

	protected $accessToken = '';
	protected $refreshToken = '';
	protected $request = null;
	// need a basic URL for this to add to

	public function __construct ($clientID, $clientSecret, $redirectURI = '', $request = null) {
		$this -> setClientID ($clientID);
		$this -> setClientSecret ($clientSecret);
		$this -> setRedirectURI ($redirectURI);

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