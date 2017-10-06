<?php

// this needs to access my creds somewhere

class entrance {

	protected $accessToken = '';
	protected $clientID = '';
	protected $clientSecret = '';
	protected $redirectURI = '';
	protected $refreshToken = '';
	protected $request = null;

	public function __construct ($clientID, $clientSecret, $redirectURI = '', $request = null) {
		$this -> setClientID ($clientIDd);
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