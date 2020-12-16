<?php

require 'Nbrb.php';

class Convertor {
    private $defaultIso = "BYN";
    private $reverseRate = false;
    private $rates = array();

    private function validRateIso($iso) {
        return strlen($iso) === 3;
    }

    private function getRates($fromIso, $toIso) {
        $nbrb = new Nbrb();

        if(!is_null($fromIso)) {
            $this->rates[$fromIso] = $nbrb->getRate($fromIso);
        }

        $this->rates[$toIso] = $nbrb->getRate($toIso);

        return $this->rates;
    }

    private function formatResultFromDefault($toIso) {
        if($this->reverseRate) {
            $rate = number_format(1/$this->rates[$toIso]->rate, 2);
        } else {
            $rate = number_format($this->rates[$toIso]->rate, 2);
        }
        $result = $this->defaultIso . '/' .$toIso . '=' . $rate;

        return $result;
    }

    private function formatResult($fromIso, $toIso) {
        $rate = number_format($this->rates[$fromIso]->rate/$this->rates[$toIso]->rate, 2);
        $result = $fromIso . '/' .$toIso . '=' . $rate;

        return $result;
    }

    public function convert($fromIso, $toIso) {
        if ($toIso == $this->defaultIso) {
            $this->reverseRate = true;
            $toIso = $fromIso;
            $fromIso = null;
        }
        if ($fromIso == $this->defaultIso) {
            $fromIso = null;
        }
        $this->getRates($fromIso, $toIso);
        if(is_null($fromIso)) {
            $result = $this->formatResultFromDefault($toIso);
        } else {
            $result = $this->formatResult($fromIso, $toIso);
        }

        return $result;
    }
}