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

//    Get all federal districts, grouped by state
    public function getFed() {
        return \Cache::rememberForever('ctb.districts-fed', function () {
            $states = \CTBDB::table('ctb2016_e22_fed')
                ->select(['DIST', 'NAML', 'PARTY'])
                ->orderBy('DIST', 'ASC')
                ->get()
                // Group by state
                ->reduce(function ($carry, $dist) {
                    $st = substr($dist->DIST, 0, 2);

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
