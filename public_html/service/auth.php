<?php
namespace CTI;

require_once './model/user.php';
use \Auth0\SDK\JWTVerifier;
use \Auth0\SDK\Exception\CoreException;
use \Auth0\SDK\Exception\InvalidTokenException;
use \Auth0\SDK\Helpers\JWKFetcher;

class AuthService {
	private $client;
	
	function __construct() {
		$this->client = new \GuzzleHttp\Client([
            'base_uri' => 'http://auth:8080',
            'timeout' => 2.0
        ]);
	}
	
	public function currentUser() : User {
		$username = '?';
		$firstname = '?';
		$lastname = '?';

		$decoded_token;
		$success = $this->decodeToken($decoded_token);

		if ($success) {
			$username = $decoded_token->{'preferred_username'};
			$firstname = $decoded_token->{'given_name'};
			$lastname = $decoded_token->{'family_name'};
		}
		return new User($username, $firstname, $lastname);
	}

	public function verifyToken($role) {
		$decoded_token;
		$success = $this->decodeToken($decoded_token);
		if ($success) {
        	$roles = $decoded_token->{'realm_access'}->{'roles'};
        	return in_array($role, $roles);
		}
        return false;
   }

   private function decodeToken(&$decoded_token) : bool {
		if (!isset($_COOKIE['ACCESS_TOKEN'])) {
           error_log("Cookie not set");
           return false;
		}

       $response = $this->client->request(
           'GET',
           'auth/realms/cti/protocol/openid-connect/certs'
        );

        if ($response->getStatusCode() != 200) {
            error_log("Cannot retrieve public api key! Status-Code: ".$response->getStatusCode());
            return false;
        }

        $parsed = json_decode($response->getBody());
        if ($parsed->{'keys'}[0]->{'alg'} !== "RS256") {
            error_log("Unsupported token algorithm: ".$parsed->{'alg'});
            return false;
        }

        $fetcher = new JWKKeycloakFetcher('http://auth:8080/auth/realms/cti/protocol/openid-connect/certs');

        $config = [
            'supported_algs' => [$parsed->{'keys'}[0]->{'alg'}],
            'valid_audiences' => ['account'],
            'authorized_iss' => ['http://localhost:90/auth/realms/cti'],
            'jwks_path' => ['protocol/openid-connect/certs']
        ];

        $verifier = new JWTVerifier($config, $fetcher);
        $decoded_token = $verifier->verifyAndDecode($_COOKIE['ACCESS_TOKEN']);
		return true;
   }
}

class JWKKeycloakFetcher extends JWKFetcher {
    private $url;

    function __construct($url) {
        JWKFetcher::__construct();
        $this->url = $url;
    }

    public function getKeys($jwks_url) {
        return JWKFetcher::getKeys($this->url);
    }
}
?>