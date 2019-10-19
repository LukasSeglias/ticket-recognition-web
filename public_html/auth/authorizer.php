<?php
// https://packagist.org/packages/pviojo/oauth2-keycloak
namespace CTI;

use \Auth0\SDK\JWTVerifier;
use \Auth0\SDK\Exception\CoreException;
use \Auth0\SDK\Exception\InvalidTokenException;
use \Auth0\SDK\Helpers\JWKFetcher;

class Authorizer {
    private $client;

    function __construct() {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => 'http://auth:8080',
            'timeout' => 2.0
        ]);
    }

   public function verifyToken($role) {
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
        
        $roles = $decoded_token->{'realm_access'}->{'roles'};
        return in_array($role, $roles);
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