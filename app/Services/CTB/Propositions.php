<?php

namespace App\Services\CTB;

class Propositions
{
    public function getAllProps() {
        $past = \CTBDB::table('ctb_ca_props')
            ->where([
                ['prop_no', '!=', ''],
                ['prop_session', '>', 2003],
            ])
            ->orderBy('prop_no', 'asc')
            ->orderBy('prop_id', 'asc')
            ->get();

        //PROPOSITIONS 2020+
        $pending[2020] = \CTBDB::table('ctb_ca_props_pending')
            ->where([

                  ['prop_status', '>', 0],
                  ['session', '=', 2019],
           ])
                ->orderBy('ballot_no', 'asc')
                ->orderBy('prop_id', 'asc')
                ->get()
                ->toArray();


        $pending[2022] = \CTBDB::table('ctb_ca_props_pending')
            ->where([

                  ['prop_status', '>', 0],
                  ['session', '=', 2021],
           ])
               ->orderBy('ballot_no', 'asc')
                ->orderBy('prop_id', 'asc')
                ->get()
                ->toArray();

        $pending[2024] = \CTBDB::table('ctb_ca_props_pending')
            ->where([

                  ['prop_status', '>', 0],
                  ['session', '=', 2023],
           ])
               ->orderBy('ballot_no', 'asc')
               ->orderBy('prop_id', 'asc')
               ->get()
               ->toArray();

        $pending[2026] = \CTBDB::table('ctb_ca_props_pending')
            ->where([

                  ['prop_status', '>', 0],
                  ['session', '=', 2025],
           ])
               ->orderBy('ballot_no', 'asc')
               ->orderBy('prop_id', 'asc')
               ->get()
               ->toArray();


        $props = Array(
        //'2020' => $pending[2020],
        //'2022' => $pending[2022],
        '2024' => $pending[2024],
	'2026' => $pending[2026]
        );

        $past->each(function ($prop) use (&$props) {
            $prop->isPast = true;
            $el = $prop->prop_session + 1;
            if (!isset($props[$el])) {
                $props[$el] = [];
            }
            array_push($props[$el], $prop);
        });

        ksort($props);
        $props = array_reverse($props, true);

    foreach ($props as &$propGroup) {
        foreach ($propGroup as &$prop) {
            if (empty($prop->session) && !empty($prop->prop_session)) {
                $prop->session = $prop->prop_session;
            }
            if (empty($prop->prop_session) && !empty($prop->session)) {
                $prop->prop_session = $prop->session;
            }
        }
    }        

        return $props;
    }

    public function getVotesFor($prop) {
        $shortYear = $this->getYear($prop) - 2000;
        $propNo = $this->getNumber($prop);
        $records = \CTBDB::table('ctb_county_results')
            ->where([
                ['racekey', 'like', "PR_$propNo%"],
                ['election', 'like', "%$shortYear"]
            ])
            ->orderBy('county', 'asc')
            ->get()
            ->reduce(function ($counties, $row) {
                $countyCode = str_pad($row->county, 3, '0', STR_PAD_LEFT);
                if (!isset($counties[$countyCode])) {
                    $counties[$countyCode] = [
                        'yes' => 0,
                        'no' => 0,
                        'total' => 0,
                    ];
                }
                if (str_ends_with($row->racekey, 'Y')) {
                    $counties[$countyCode]['yes'] += $row->votes;
                } else {
                    $counties[$countyCode]['no'] += $row->votes;
                }

                $counties[$countyCode]['total'] += $row->votes;

                return $counties;
            }, []);

        $totals = collect($records)->reduce(function ($sums, $row) {
            $sums['yes'] += $row['yes'];
            $sums['no'] += $row['no'];
            $sums['total'] += $row['total'];
            return $sums;
        }, ['yes' => 0, 'no' => 0, 'total' => 0]);

        $votes = [
            'totals' => $totals,
            'counties' => $records,
        ];

        return $votes;
    }


    /**
     * Get surrounding propositions for pagination
     *
     * @param $prop
     * @return array
     */
    public function getSurrounding($prop) {
        $props = $this->getAllProps();
        $currentIndex=0;
        $yr = $this->getYear($prop);

        foreach ($props[$yr] as $i => $p) {
            if ($p->id === $prop->id) {
                $currentIndex = $i;
            }
        }

        $years = array_keys($props);

        if (isset($props[$yr][$currentIndex + 1])) {
            $next = $props[$yr][$currentIndex + 1];
        } else {
            $nextYr = $years[array_search($yr, $years) + 1 % count($years)];
            $next = $props[$nextYr][0];
        }
        if (isset($props[$yr][$currentIndex - 1])) {
            $prev = $props[$yr][$currentIndex - 1];
        } else {
            $prevYr = $years[(array_search($yr, $years) - 1 + count($years)) % count($years)];
            $prev = end($props[$prevYr]);
        }

        return [
            'next' => $next,
            'prev' => $prev,
        ];
    }



    /**
     * Campaign Finance Activity By Committees Supporting/Opposing This Proposition
     *
     * @param $prop
     * @return mixed
     */
    public function getFinanceActivity($prop) {

        $totals = [
            'oppose_raised' => 0,
            'oppose_spent' => 0,
            'support_raised' => 0,
            'support_spent' => 0,
        ];




        $committees = $this->getCommittees($prop)
            ->map(function ($cmte) use ($prop, &$totals) {

        if(!property_exists($prop, 'prop_session')) {
            $prop->prop_session = 2017;

            $prop_id = $prop->prop_id;
            if ($prop_id >200000 && $prop_id < 230000) {
            $prop->prop_session = 2021;
            } elseif ($prop_id > 1402758 || $prop_id == '1401393') {
            $prop->prop_session = 2019;
            } elseif ($prop_id > 1386783 &&( $prop_id > 1399108 && $prop_id < 1402759) ) {
            $prop->prop_session = 2017;
            }
        } elseif(isset($prop->session) && !isset($prop->prop_session)) {
            $prop->prop_session = $prop->session;
        }


        $prop_id = $prop->prop_id;


        $cns = $this->get_cal_consultants($cmte->cmte_id);
        $summary = $this->get_cmte_summary($cmte->cmte_id, $prop->prop_session);
        $totalRaised = 0; $totalSpent = 0; $raisedSince=0;

        if (is_array($summary)) {
            $raisedSince = $this->getRaisedSince($cmte->cmte_id, $summary['last_end']??'');
            $totalRaised = $summary['rcpt_total'] + $raisedSince;
            $totalSpent = $summary['expn_total'];
        }

        $pos = strtolower($cmte->cmte_position);
        $totals["${pos}_raised"] += $totalRaised;
        $totals["${pos}_spent"] += $totalSpent;

        return [
                    'id' => $cmte->cmte_id,
                    'name' => ucwords(strtolower($cmte->cmte_nm)),
                    'position' => $cmte->cmte_position,
                    'raised_last_period' => $summary['last_rcpt']??'',
                    'raised_since' => $raisedSince,
                    'total_raised' => $totalRaised,
                    'total_spent' => $totalSpent,
                    'cash_on_hand' => $summary['last_coh']??'',
                    'consultants' => $cns,
                ];
            })
            ->toArray();


        return [
            'committees' => $committees,
            'totals' => $totals,
        ];
    }

    /**
     * Get Amount raised since a date
     *
     * Grabs F497's for a committee
     */
    private function getRaisedSince($committeeId, $sinceDate = 0) {
        $filings = \CTBDB::table('calaccess_raw_FILER_FILINGS_CD')
            ->where([
                ['FILER_ID', '=', $committeeId],
                ['FILING_TYPE', '<>', '0'],
                ['RPT_END', '>', $sinceDate ?? 0]
            ])
            ->orderBy('FILING_ID', 'DESC')
            ->orderBy('FILING_SEQUENCE', 'DESC')
            ->get()
            ->unique('FILING_ID');

        $contributions = \CTBDB::table('calaccess_raw_S497_CD')
//                        ->select(\DB::raw('SUM(AMOUNT) as contribution'))
            ->select(['CMTE_ID', 'AMOUNT', 'FILING_ID', 'AMEND_ID', 'LINE_ITEM', 'CTRIB_DATE'])
            ->whereIn('FILING_ID', $filings->pluck('FILING_ID'))
            ->where([
                ['FORM_TYPE', '=', 'F497P1'],
                ['CTRIB_DATE', '>', $sinceDate ?? 0],
            ])
            ->orderBy('FILING_ID')
            ->orderBy('LINE_ITEM', 'asc')
            ->orderBy('AMEND_ID', 'desc')
            ->get()
            ->unique(function ($cont) {
                return $cont->FILING_ID . $cont->LINE_ITEM;
            });


        return $contributions->sum('AMOUNT');
    }

    private function getLastF460($committee, $year) {
        return \CTBDB::table('calaccess_raw_FILER_FILINGS_CD')
            ->select(['FILING_ID', 'RPT_END'])
            ->where([
                ['FILER_ID', '=', $committee],
                ['FORM_ID', '=', 'F460'],
                ['FILING_TYPE', '<>', '0'],
                ['RPT_END', 'like', "$year%"]
            ])
            ->orderBy('RPT_END', 'DESC')
            ->orderBy('FILING_SEQUENCE', 'DESC')
            ->first();
    }

    private function get_filing_consultants($filing) {

        return \CTBDB::table('calaccess_raw_EXPN_CD')
             ->select(['AMOUNT', 'EXPN_CODE', 'PAYEE_NAMF', 'PAYEE_NAML'])
             ->where([
                ['FILING_ID', '=', $filing],
                ['EXPN_CODE', '=', 'CNS'],

                ])
             ->get();
    }

    private function get_filing_pollsters($filing) {

        return \CTBDB::table('calaccess_raw_EXPN_CD')
             ->select(['AMOUNT', 'EXPN_CODE', 'PAYEE_NAMF', 'PAYEE_NAML'])
             ->where([
                ['FILING_ID', '=', $filing],
                ['EXPN_CODE', '=', 'POL'],
                ])
             ->get();
    }

        public function get_cal_consultants($cmte_id)
        {
            $consultants=$polling='';

            $filings = $this->get_all_filings($cmte_id);

            foreach ($filings as $f) {
                $filing = $f->FILING_ID;


                $tmp = $this->get_filing_consultants($filing);
                foreach($tmp as $row) {
                    $amt = $row->AMOUNT;
                    $code = $row->EXPN_CODE;
                    if ($row->PAYEE_NAMF) {
                        $name = $row->PAYEE_NAMF . " " . $row->PAYEE_NAML;
                    } else {
                        $name = $row->PAYEE_NAML;
                    }
                    $cns[$code][$name]['name'] = $name;
                   if(array_key_exists('amount' , $cns[$code][$name])){
                        $cns[$code][$name]['amount'] += $amt;
                    }

                }

                $tmp = $this->get_filing_pollsters($filing);
                foreach($tmp as $row) {
                    $amt = $row->AMOUNT;
                    $code = $row->EXPN_CODE;
                    if ($row->PAYEE_NAMF) {
                        $name = $row->PAYEE_NAMF . " " . $row->PAYEE_NAML;
                    } else {
                        $name = $row->PAYEE_NAML;
                    }

                    $cns[$code][$name]['name'] = $name;
                    if(array_key_exists('amount' , $cns[$code][$name])){
                        $cns[$code][$name]['amount'] += $amt;
                    }
                }
            }

            if (isset($cns['CNS'])) {
                // uasort($cns['CNS'], $this->amountsort);
                foreach ($cns['CNS'] as $key => $value) {
                    if (array_key_exists('amount' , $value) && $value['amount'] > 1000) {
                        if (!$consultants) {
                            $consultants = "\nCampaign Consultants: " . $value['name'];
                        } else {
                            $consultants .= ", " . $value['name'];
                        }
                    }
                }
            }

            if (isset($cns['POL'])) {
                // uasort($cns['POL'], $this->amountsort);
                foreach ($cns['POL'] as $key => $value) {
                    if (array_key_exists('amount' , $value) && $value['amount'] > 1000) {
                        if (!$polling) {
                            $polling = "\nPolling: " . $value['name'];
                        } else {
                            $polling .= ", " . $value['name'];
                        }
                    }
                }
            }

            if($consultants || $polling) {
                $retval = $consultants . $polling;
            } else {
                $retval = '';
            }


            return $retval;

        }
     private function get_all_filings($cmte_id)
     {

        return \CTBDB::table('calaccess_raw_FILER_FILINGS_CD')
            ->select(['FILING_ID'])
            ->where([
                ['FILER_ID', '=', $cmte_id],
                ['FORM_ID', '=', 'F460']
                ])
            ->orderBy('RPT_END', 'desc')
            ->get();
    }

                private function get_highest_amend_id($f)
                {
                    $conn = Util::get_ctb_conn();
                    $sql = "SELECT AMEND_ID FROM calaccess_raw_CVR_CAMPAIGN_DISCLOSURE_CD WHERE FILING_ID = '$f' ORDER BY AMEND_ID DESC LIMIT 1";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $retval = $row['AMEND_ID'];
                        }
                    }

                    return $retval;
                }


    private function getFilingSummary($filingId) {
        if (empty($filingId)) return [];

        // Line item ids
        $line_items = [
            'contributions' => '5',
            'expenditures' => '11',
            'cash_on_hand' => '16',
            'loans' => '2',
            'debts' => '19',
        ];

        $rows = \CTBDB::table('calaccess_raw_SMRY_CD')
            ->select(['AMOUNT_A', 'AMOUNT_B', 'LINE_ITEM'])
            ->where([
                ['FILING_ID', '=', $filingId],
                ['rec_type', '=', 'SMRY'],
            ])
            ->get();

        return [
            'contributions' => $rows->firstWhere('LINE_ITEM', $line_items['contributions'])->AMOUNT_A,
            'contributions_ytd' => $rows->firstWhere('LINE_ITEM', $line_items['contributions'])->AMOUNT_B,
            'expenditures' => $rows->firstWhere('LINE_ITEM', $line_items['expenditures'])->AMOUNT_A,
            'expenditures_ytd' => $rows->firstWhere('LINE_ITEM', $line_items['expenditures'])->AMOUNT_B,
            'cash_on_hand' => $rows->firstWhere('LINE_ITEM', $line_items['cash_on_hand'])->AMOUNT_A,
            'loans' => $rows->firstWhere('LINE_ITEM', $line_items['loans'])->AMOUNT_B,
            'debts' => $rows->firstWhere('LINE_ITEM', $line_items['debts'])->AMOUNT_A,
        ];
    }

    public function getAnalysis($prop)
        {

                $analysis = \CTBDB::table('ctb_analysis')->select('text')->where('dist', $prop)->orderBy('id', 'desc')->first();
                $text = ($analysis !== null) ?  $analysis->text:'';

            return $text;


        }
    public function hasAds($prop)
        {
            $ads = \CTBDB::table('ctb_ads_e18')->select('url')->where('fourcode', $prop)->first();
            if ($ads !== null) {
                $url = isset($ads->url) ? $ads->url : null;
            } else {
                $url=$ads;
            }
            return $url;

        }
    public function amountsort($a, $b)
                {

                    if ($a['amount'] < $b['amount']) {
                        return 1;
                    } elseif ($a['amount'] > $b['amount']) {
                        return -1;
                    } else {
                        return 0;
                    }
                }

    private function getCommittees($prop) {
        $t = $this->isCmtePending($prop) ? 'ctb_ca_props_pending_ccl' : 'ctb_ca_props_ccl';
        return \CTBDB::table($t)
            ->where('prop_id', $prop->prop_id)
            ->orderBy('cmte_position', 'desc')
            ->get();
    }

    public function isCmtePending($prop) {
        return $this->getYear($prop) >= 2017;
    }


    public function getLinkFor($prop) {
        return route('book.propositions.show', ['id' => $prop->prop_id]);
    }



    public function getName($prop) {
        if(!empty($prop->prop_no)) {
            if(strlen($prop->prop_no) > 0) {
                return "Prop " . $prop->prop_no;
            }
        } elseif(!empty($prop->ballot_no)) {
            if(strlen($prop->ballot_no) > 0) {
                return "Prop " . $prop->ballot_no;
            }
        }elseif(isset($prop->ag_id)) {
            if(strlen($prop->ag_id) > 0) {
                return "AG #" . $prop->ag_id;
            }       
        }
    }

    public function getNumber($prop) {
        if(!isset($prop->prop_no) && !empty($prop->ballot_no)) {
            return trim($prop->ballot_no);
        }elseif(!empty($prop->prop_no)) {
            return trim(str_replace('Prop', '', $prop->prop_no));
        }
        
    }

    public function getYear($prop) {

        $prop_id = $prop->prop_id;

    if(($prop_id > 220000 && $prop_id < 1000000 && $prop_id != 229999) || $prop_id == 210022 || $prop_id == 210027 || $prop_id == 210039 || $prop_id == 210042 || $prop_id == 210043) {
        return 2024;
    }elseif(($prop_id > 200000 && $prop_id < 220000) || $prop_id == 1423948 || $prop_id == 1424850 || $prop_id > 1427741 || $prop_id == 229999) {
            return 2022;
        } elseif ($prop_id > 1402758 || $prop_id == '1401393' || $prop_id == '1419509' || $prop_id == '1401133') {
            return 2020;
        } elseif ($prop_id > 1386783 &&( $prop_id > 1399108 && $prop_id < 1402759) ) {
            return 2018;
        } elseif (isset($prop->prop_session)) {
            return $prop->prop_session + 1;
        } elseif (isset($prop->session)) {
        return $prop->session + 1;
    }

    }

    /**
     * Get Status of a pending proposition
     */
    public function getStatus($prop) {
        $statusMap = [
            '1' => 'Cleared for Circulation',
        '2' => 'Submitted to AG',
            '25' => '25% Signatures Threshold Met',
            '50' => 'Signatures Submitted, Undergoing Verification',
        '96' => 'Qualified for Primary Ballot',
            '100' => 'Qualified for Ballot',
            '0' => 'Withdrawn/Failed to Qualify',
        ];
        if(isset($prop->prop_status)){
            return $statusMap[$prop->prop_status];
        }
        return 'not found';
    }

    // Check if prop is pending or has already been voted on
    public function isPending($prop) {
        return $this->getYear($prop) >= 2020;
    }

    public function getVotingGuideURL($prop) {
        if (!empty($prop->filename)) {
            return "/docs/Props/$prop->filename";
        }
    if(!empty($prop->ag_id)) {
            return "/docs/Props/Pending_2018/$prop->ag_id.pdf";
    }
    return '/docs/Props/Pending_2018/empty.pdf';
    }

    public function get_cmte_summary($cmte_id, $start_year)
    {
        $ps = $start_year . "-01-01";
        $pe   = ($start_year + 1) . "12-31";
        $last_filing='';
        $last_rpt= $retval=$filings=[];



        $arr = \CTBDB::table('calaccess_raw_FILER_FILINGS_CD')
                        ->where([
                            ['FILER_ID', '=', $cmte_id],
                            ['PERIOD_ID', '!=', 0],
                            ['RPT_END', '<=', $pe],
                            ['RPT_START', '>=', $ps],
                            ['FORM_ID', '=', 'F460']
                            ])
                        ->orderBy('FILING_ID')
                        ->orderBy('FILING_SEQUENCE', 'desc')
                        ->get()
                        ->toArray();

        $arr2 = json_decode(json_encode($arr), true);


        foreach($arr2 as $key => $row) {
                $this_filing = $row['FILING_ID'];
                if($this_filing == $last_filing) {
                    continue;
                }
                $tmp['FILING_ID'] = $row['FILING_ID'];
                $tmp['AMEND_ID']  = $row['FILING_SEQUENCE'];
                $tmp['RPT_START'] = $row['RPT_START'];
                $tmp['RPT_END']   = $row['RPT_END'];
                $filings[$this_filing] = $tmp;
                $last_filing = $this_filing;

                if(array_key_exists('RPT_END' , $row) && array_key_exists('RPT_END' , $last_rpt) && $row['RPT_END'] >= $last_rpt['RPT_END']) {

                    $last_rpt['RPT_END'] = $row['RPT_END'];
                    $last_rpt['FILING_ID'] = $this_filing;
                }
        }

        $query = "(";
            foreach($filings as $f) {
                $query .= " (FILING_ID = " . $f['FILING_ID'] . " && AMEND_ID = " . $f['AMEND_ID'] . ") ||";
            }
            $query = substr($query, 0, -2);

        $query .= ")";
        $query .= " && FORM_TYPE = \"F460\" && (LINE_ITEM = 5 || LINE_ITEM = 11 || LINE_ITEM = 16 || LINE_ITEM = 2 || LINE_ITEM = 19)";

        if($filings) {
            $arr = \CTBDB::table('calaccess_raw_SMRY_CD')
                ->whereRaw($query)
                ->get()
                ->toArray();
            //echo("<br>$cmte_id<br>");
            //echo("<br>LAST<br>");
            //var_dump($last_rpt);
            //var_dump($arr);
        } else {
            return FALSE;
        }
        $arr3 = json_decode(json_encode($arr), true);

        foreach($arr3 as $key => $row) {
                $this_filing = $row['FILING_ID'];
                $this_line   = $row['LINE_ITEM'];
                if(array_key_exists('FILING_ID' , $last_rpt) && $this_filing == $last_rpt['FILING_ID']) {
                    $retval['last_filing'] = $this_filing;
                    $retval['last_end']    = $last_rpt['RPT_END'];
                    if($this_line == 16) {
                    $retval['last_coh'] = $row['AMOUNT_A'];
                    } elseif($this_line == 5) {
                        $retval['last_rcpt'] = $row['AMOUNT_A'];
                    }
                }

                if($this_line == 5) {
                    if(array_key_exists('rcpt_total' , $retval)){
                        $retval['rcpt_total'] += $row['AMOUNT_A'];
                    }else{
                        $retval['rcpt_total'] = $row['AMOUNT_A'];
                    }
                } elseif($this_line == 11) {
                    if(array_key_exists('expn_total' , $retval)){
                        $retval['expn_total'] += $row['AMOUNT_A'];
                    }else{
                        $retval['expn_total'] = $row['AMOUNT_A'];
                    }
                }
        }
        //var_dump($retval);
        return $retval;
    }
}
