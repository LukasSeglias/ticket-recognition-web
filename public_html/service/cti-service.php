<?php

namespace CTI;
use GuzzleHttp\Exception\GuzzleException;

require_once './model/cti-template.php';

    class CtiService {

        private $authService;

        public function __construct($authService) {
            $this->authService = $authService;
        }

        public function uploadTemplate(CtiTemplate $template, $file, $accessToken) {
            try {
                $response = $this->client()->request('POST',
                    'java/ticket-recognition/rest/images/' . $template->getFileName(),
                    [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $accessToken
                        ],
                        'body' => fopen($file, 'r'),
                    ]);
                if ($response->getStatusCode() == 204) {
                    $response = $this->client()->request('POST',
                        'java/ticket-recognition/rest/templates/',
                        [
                            'headers' => [
                                'Authorization' => 'Bearer ' . $accessToken
                            ],
                            'json' => $template->jsonSerialize(),
                        ]);
                } else {
                    error_log("Error uploading file!");
                }
            } catch (GuzzleException $e) {
                error_log("guzzle exc");
            }
        }

        public function match($file, $fileExtension, $accessToken) {
            $response = $this->client()->request('POST',
                'java/ticket-recognition/rest/tickets/',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                        'TypeOfFile' => $fileExtension
                    ],
                    'body' => fopen($file, 'r'),
                ]);

            if ($response->getStatusCode() == 200) {
                $array = json_decode($response->getBody());
                return $array;
            }
        }

        private function client() {
            $issuer = $this->authService->issuer();
            $url = parse_url($issuer);
            $url2 =  $url['scheme'] . '://' . $url['host'] . ':' . $url['port'];
            $client = new \GuzzleHttp\Client([
                'base_uri' => $url2,
                'timeout' => 10.0
            ]);
            return $client;
        }
    }
?>