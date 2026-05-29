<?php

namespace App\Services\CTB;


class HouseCandidates
{


    protected $candidateTables = [
        2018 => 'nufec18_cn',
        2016 => 'nufec_cn',
        2014 => 'nufec_cn_14',
        2012 => 'nufec_cn_12',
        2010 => 'nufec_cn_10',
        2008 => 'nufec_cn_08',
        2006 => 'nufec_cn_06',
    ];

    protected  $financialTables = [
        2018 => 'nufec18_weball',
        2016 => 'nufec_weball',
        2014 => 'nufec_weball_14',
        2012 => 'nufec_weball_12',
        2010 => 'nufec_weball_10',
        2008 => 'nufec_weball_08',
        2006 => 'nufec_weball_06',
    ];

    protected $roles = [
        'I' => 'Incumbent',
        'C' => 'Challenger',
        'O' => 'Open Seat',
    ];


    public function getByYear($year) {

        $table = $this->candidateTables[$year];
        $financeTable = $this->financialTables[$year];

        return \CTBDB::table($table)
            ->select([
                "$table.CAND_NAME", "$table.CAND_PTY_AFFILIATION", "$table.CAND_ID",
                "$table.CAND_OFFICE", "$table.CAND_OFFICE_ST", "$table.CAND_OFFICE_DISTRICT",
                "$table.CAND_ICI", "$table.CAND_PCC", "$table.CAND_CITY", "$table.CAND_ST", "$table.CAND_ZIP",

                "$financeTable.TTL_RECEIPTS", "$financeTable.TTL_DISB",
            ])
            ->where([
                ['CAND_ELECTION_YR', '=', $year],
                ['CAND_OFFICE', '!=', 'P'],
            ])
            ->join($financeTable, "$table.CAND_ID", '=', "$financeTable.CAND_ID")
            ->orderBy("$table.CAND_OFFICE_ST")
            ->orderBy("$table.CAND_OFFICE_DISTRICT")
            ->get()
            ->map(function ($cand) {
                if ($cand->CAND_OFFICE === "H") {
                    $cand->fourcode = $cand->CAND_OFFICE_ST . $cand->CAND_OFFICE_DISTRICT;
                } elseif ($cand->CAND_OFFICE === "S") {
                    $cand->fourcode = $cand->CAND_OFFICE_ST . "SEN";
                }

                $cand->role = $this->roles[$cand->CAND_ICI];
                $cand->raised = $cand->TTL_RECEIPTS;
                $cand->spent = $cand->TTL_DISB;
                $cand->address = $cand->CAND_CITY . ", " . $cand->CAND_ST . " " . $cand->CAND_ZIP;

               return $cand;
            });
    }

}