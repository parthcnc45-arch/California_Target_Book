<?php

namespace App\Services\CTB;

class Util
{

    private $states = [
        'AL'=>'Alabama',
        'AK'=>'Alaska',
        'AZ'=>'Arizona',
        'AR'=>'Arkansas',
        'CA'=>'California',
        'CO'=>'Colorado',
        'CT'=>'Connecticut',
        'DE'=>'Delaware',
        'FL'=>'Florida',
        'GA'=>'Georgia',
        'HI'=>'Hawaii',
        'ID'=>'Idaho',
        'IL'=>'Illinois',
        'IN'=>'Indiana',
        'IA'=>'Iowa',
        'KS'=>'Kansas',
        'KY'=>'Kentucky',
        'LA'=>'Louisiana',
        'ME'=>'Maine',
        'MD'=>'Maryland',
        'MA'=>'Massachusetts',
        'MI'=>'Michigan',
        'MN'=>'Minnesota',
        'MS'=>'Mississippi',
        'MO'=>'Missouri',
        'MT'=>'Montana',
        'NE'=>'Nebraska',
        'NV'=>'Nevada',
        'NH'=>'New Hampshire',
        'NJ'=>'New Jersey',
        'NM'=>'New Mexico',
        'NY'=>'New York',
        'NC'=>'North Carolina',
        'ND'=>'North Dakota',
        'OH'=>'Ohio',
        'OK'=>'Oklahoma',
        'OR'=>'Oregon',
        'PA'=>'Pennsylvania',
        'RI'=>'Rhode Island',
        'SC'=>'South Carolina',
        'SD'=>'South Dakota',
        'TN'=>'Tennessee',
        'TX'=>'Texas',
        'UT'=>'Utah',
        'VT'=>'Vermont',
        'VA'=>'Virginia',
        'WA'=>'Washington',
        'WV'=>'West Virginia',
        'WI'=>'Wisconsin',
        'WY'=>'Wyoming',
    ];

    private $counties = [
        "001" => "Alameda",
        "003" => "Alpine",
        "005" => "Amador",
        "007" => "Butte",
        "009" => "Calaveras",
        "011" => "Colusa",
        "013" => "Contra Costa",
        "015" => "Del Norte",
        "017" => "El Dorado",
        "019" => "Fresno",
        "021" => "Glenn",
        "023" => "Humboldt",
        "025" => "Imperial",
        "027" => "Inyo",
        "029" => "Kern",
        "031" => "Kings",
        "033" => "Lake",
        "035" => "Lassen",
        "037" => "Los Angeles",
        "039" => "Madera",
        "041" => "Marin",
        "043" => "Mariposa",
        "045" => "Mendocino",
        "047" => "Merced",
        "049" => "Modoc",
        "051" => "Mono",
        "053" => "Monterey",
        "055" => "Napa",
        "057" => "Nevada",
        "059" => "Orange",
        "061" => "Placer",
        "063" => "Plumas",
        "065" => "Riverside",
        "067" => "Sacramento",
        "069" => "San Benito",
        "071" => "San Bernardino",
        "073" => "San Diego",
        "075" => "San Francisco",
        "077" => "San Joaquin",
        "079" => "San Luis Obispo",
        "081" => "San Mateo",
        "083" => "Santa Barbara",
        "085" => "Santa Clara",
        "087" => "Santa Cruz",
        "089" => "Shasta",
        "091" => "Sierra",
        "093" => "Siskiyou",
        "095" => "Solano",
        "097" => "Sonoma",
        "099" => "Stanislaus",
        "101" => "Sutter",
        "103" => "Tehama",
        "105" => "Trinity",
        "107" => "Tulare",
        "109" => "Tuolumne",
        "111" => "Ventura",
        "113" => "Yolo",
        "115" => "Yuba",
    ];

    public function formatState($st) {
        return $this->states[$st];
    }

    public function getCounties() {
        return array_values($this->counties);
    }

    public function getCounty($countyId) {
        if (isset($this->counties[$countyId])) {
            return $this->counties[$countyId];
        } else {
            return "Alameda";
        }
        return $this->counties[$countyId];
    }

    public function percentFormat($numerator, $denominator) {
        if ($denominator === 0) {
            $denominator=1;
        }
        return ((int)(($numerator / $denominator) * 10000)) / 100;
    }

}
