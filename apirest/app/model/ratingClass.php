<?php


class RatingClass
{

    public function setRate($rate)
    {

        $jsonArray = json_decode($rate['data']);

        $file = $jsonArray->url;

        $file .= date("Y-m-d_h-i-s");

        $file .= ".json";

        $json = $rate['data'];

        if ($rate['rate'] == 'positive') :

            $file = fopen(__DIR__ . '/../../../assets/jsons/positive/' . $file, 'w');


        elseif ($rate['rate'] == 'negative') :

            $file = fopen(__DIR__ . '/../../../assets/jsons/negative/' . $file, 'w');

        endif;

        fwrite($file, $json);

        fclose($file);
    }
}
