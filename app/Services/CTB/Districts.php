<?php

namespace App\Services\CTB;

class Districts
{

    private function getDistricts() {
        return \Cache::rememberForever('ctb.districts', function () {
            return \CTBDB::table('ctb2016_e22_incumbent')
                ->orderBy('DIST', 'ASC')
                ->get();
        });
    }


    private function getDistricts2() {
        return \Cache::rememberForever('ctb.districts2', function () {
            return \CTBDB::table('ctb2016_e26_incumbent')
                ->orderBy('DIST', 'ASC')
                ->get();
        });
    }


    

//    Get all federal districts, grouped by state
   public function getFed() {
    return \Cache::rememberForever('ctb.districts-fed', function () {
        $states = \CTBDB::table('ctb2016_e26_fed')
            ->select(['DIST', 'NAMF', 'NAML', 'PARTY', 'PRSREP_24', 'PRSDEM_24', 'PRSREP_20', 'PRSDEM_20', 'PRSREP_16', 'PRSDEM_16'])
            ->orderBy('DIST', 'ASC')
            ->get()
            // Group by state and add presidential results
            ->reduce(function ($carry, $dist) {
                $st = substr($dist->DIST, 0, 2);

                // Calculate PRS_20
                $rep20 = $dist->PRSREP_20;
                $dem20 = $dist->PRSDEM_20;
                if ($rep20 > $dem20) {
                    $dist->PRS_20 = 'Trump +' . number_format($rep20 - $dem20, 1) . '%';
                } else {
                    $dist->PRS_20 = 'Biden +' . number_format($dem20 - $rep20, 1) . '%';
                }

                // Calculate PRS_24
                $rep24 = $dist->PRSREP_24;
                $dem24 = $dist->PRSDEM_24;
                if ($rep24 > $dem24) {
                    $dist->PRS_24 = 'Trump +' . number_format($rep24 - $dem24, 1) . '%';
                } else {
                    $dist->PRS_24 = 'Harris +' . number_format($dem24 - $rep24, 1) . '%';
                }


                // Calculate PRS_16
                $rep16 = $dist->PRSREP_16;
                $dem16 = $dist->PRSDEM_16;
                if ($rep16 > $dem16) {
                    $dist->PRS_16 = 'Trump +' . number_format($rep16 - $dem16, 1) . '%';
                } else {
                    $dist->PRS_16 = 'Clinton +' . number_format($dem16 - $rep16, 1) . '%';
                }

                if (!isset($carry[$st])) {
                    $carry[$st] = [];
                }
                array_push($carry[$st], $dist);
                return $carry;
            }, []);

        ksort($states);
        return $states;
    });
   }
    /**
     * Find a district by type
     *  e.g. "AD", "SD", etc.
     * @param $type
     * @return mixed - collection
     */
    public function find($type) {
        return self::getDistricts()
            ->filter(function ($dist) use ($type) {
                return str_contains($dist->DIST, $type);
            });
    }

    public function find2($type) {
        return self::getDistricts2()
            ->filter(function ($dist) use ($type) {
                return str_contains($dist->DIST, $type);
            });
    }


    public function parseNumber($dist) {
        return (int) preg_replace('~\D~', '', $dist);
    }
    public function getParty($party) {
        $p = strtolower($party);
        switch ($p) {
            case 'r':
            case 'rep':
                return 'republican';
            case 'd':
            case 'dem':
                return 'democrat';
            case 'g':
            case 'grn':
                return 'green';
            case 'l':
            case 'lib':
                return 'libertarian';
            case 'i':
            case 'ind':
                return 'independent';
            default:
                return $party;
        }
    }

}
