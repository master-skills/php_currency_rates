<?php

class Nbrb {
    private $client;
    private $apiHost = "https://www.nbrb.by/";
    private $apiRoute = "api/exrates/rates/";
    private $defaultParammode = 2;

    public function __construct() {
        $this->client = new GuzzleHttp\Client();
    }

    private function apiUrl($currIso) {
        $url = $this->apiHost . $this->apiRoute . $currIso;

        $queryParams = '?';
        $queryParams .= 'parammode=' . $this->defaultParammode;

        return $url . $queryParams;
    }

    public function getRate($currIso) {
        $url = $this->apiUrl($currIso);

        $curr = new stdClass();
        $curr->iso = $currIso;
        $curr->rate = 0;

        $response = $this->client->request('GET', $url);

        try {
            if ($response->getStatusCode() == 200) {
                $rate = json_decode($response->getBody());
                $curr->rate = $rate->Cur_OfficialRate / $rate->Cur_Scale;
            }
        } catch (Exception $e) {

        }

        return $curr;
    }
}