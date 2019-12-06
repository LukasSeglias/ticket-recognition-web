<?php
namespace CTI;

require_once './model/user.php';
use \Auth0\SDK\JWTVerifier;
use \Auth0\SDK\Exception\CoreException;
use \Auth0\SDK\Exception\InvalidTokenException;
use \Auth0\SDK\Helpers\JWKFetcher;
use Firebase\JWT\JWT;

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

   public function issuer() {
       $decoded_token;
       $success = $this->decodeToken($decoded_token);
       if ($success) {
           return $decoded_token->{'iss'};
       }
       return '';
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

        try {
            $fetcher = new JWKKeycloakFetcher('http://auth:8080/auth/realms/cti/protocol/openid-connect/certs');
            $token = $_COOKIE['ACCESS_TOKEN'];
            $tks = explode('.', $token);
            if (count($tks) !== 3) {
                throw new InvalidTokenException('Wrong number of segments');
            }
            $body = JWT::jsonDecode(JWT::urlsafeB64Decode($tks[1]));
            
            $config = [
                'supported_algs' => [$parsed->{'keys'}[0]->{'alg'}],
                'valid_audiences' => ['account'],
                'authorized_iss' => [$body->iss],
                'jwks_path' => ['protocol/openid-connect/certs']
            ];

            $verifier = new JWTVerifier($config, $fetcher);
            $decoded_token = $verifier->verifyAndDecode($token);
        } catch(CoreException $e) {
            error_log("Exception verifying jwt-token: " . $e);
            return false;
        } catch(InvalidTokenException $e) {
            error_log("Exception verifying jwt-token: " . $e);
            return false;
        }

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