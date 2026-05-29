
<div class="row">
    <div class="ctb-directory-column">
        <ul class="nav nav-pills mb-3 general-pill-tab" id="pills-tab" >
            <li class="nav-item active">
                <a class="nav-link" data-toggle="pill" href="#pills-now"> 2024</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#pills-state"> State</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#pills-federal">Federal</a>
            </li>
        </ul>
    </div>
    <div class="ctb-directory-column">
        <div class="tab-content" id="pills-tabContent">

            <!--BEGIN MAIN TAB-->
            <div class="tab-pane active fade in" id="pills-now">
                <!--ALL - LIST VIEW -->
                <div v-if="!verboseMode">            
                    <li>
                        <a class="text-decoration-none" href="/book/e24_finances">
                            2024 CA Candidate Finance Summaries
                        </a>
                    </li>
                    <li>
                        <a class="text-decoration-none" href="/book/e24_props">
                            2024 Ballot Measure Finance Summaries
                        </a>
                    </li>
                    <li>
                        <a class="text-decoration-none" href='/book/ca_ielist_p24'>
                            2024 Primary Election IEs (State)
                        </a>
                    </li>
                    <li>
                        <a class="text-decoration-none" href='/book/ca_ielist_fed_p24'>
                            2024 Primary Election IEs (Federal)
                        </a>
                    </li>
                    <li>
                        <a class="text-decoration-none" href="/book/e24_finances_t">
                            2024 Fed Candidate Finance Summaries
                        </a>
                    </li>
                    <li>
                        <a class="text-decoration-none" href="/book/realtime_month">
                            Live FPPC / FEC Filings (Last 30 Days)
                        </a>
                    </li>
                </div>
                <!--END LIST VIEW -->

                <!--BEGIN DETAIL VIEW -->
                <div v-if="verboseMode">
                    <div class="row d-flex text-justify">

                        <div class="card">
                            <a class="text-decoration-none" href="/book/e24_finances">
                                <div class='card-head fs-5 fw-bold'>
                                    2024 CA Candidate Finance Summaries
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Assembly / State Senate Candidates</li>
                                            <ul class="bullet-square">
                                                <li>Raised, Raised Last Period, Raised Since, Spent, Loans, Debt, Last Cash on Hand<, Last Report End Date</li>
                                                <li>Links to FPPC Candidate Finance Detail Reports</li>
                                            </ul>
                                            <li>US House / US Senate Candidates</li>
                                            <ul class="bullet-square">
                                                <li>Election Cycle Raised, Election Cycle Spent, Candidate Loans, Last Cash on Hand, Last Report End Date</li>
                                                <li>Links to FEC Candidate Finance Detail Reports</li>
                                            </ul>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="card">
                            <a class="text-decoration-none" href="/book/e24_props">
                                <div class='card-head fs-5 fw-bold'>
                                    2024 Proposition Finance Summaries
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Total Support / Oppose Spending by Prop</li>
                                            <li>Support / Oppose Committee Finance Summaries (Raised, Spent, Last Cash on Hand)</li>
                                            <li>Committee Summaries by Initiative Qualification Status</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>


                        <div class="card">
                            <a class="text-decoration-none" href="/book/ca_ielist_p24">
                                <div class='card-head fs-5 fw-bold'>
                                    FPPC Independent Expenditure Reports
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>FPPC IE Reports by Election, Cycle, or Date Range</li>
                                            <li>Spending Summaries by Race, Candidates, and Independent Expenditure Committees</li>
                                            <li>Committee Spending by Race and Candidate</li>
                                            <li>Complete List of Each IE Transaction Within Selected Range</li>
                                            <li>Independent Expenditure Committee Top Donors</li>
                                            <li>Independent Expenditure Overview by Date</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="card">
                            <a class="text-decoration-none" href="/book/ca_ielist_fed_p24">
                                <div class='card-head fs-5 fw-bold'>
                                    FEC Independent Expenditure Report (California)
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>FEC Independent Expenditure Summaries by Race, Committee, and Candidate</li>
                                            <li>Independent Expenditure Transaction Details, Links to FEC Filings</li>
                                            <li>Committee Spending by Race and Candidate</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>                        

                        <div class="card">
                            <a class="text-decoration-none" href="/book/e24_finances_t">
                                <div class='card-head fs-5 fw-bold'>
                                    2024 FEC Candidate Finance Summaries (Nationwide)
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>   

                        <div class="card">
                            <a class="text-decoration-none" href="/book/realtime_month">
                                <div class='card-head fs-5 fw-bold'>
                                    Live FPPC / FEC Filings (Last 30 Days)
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>   

                    </div>

                </div>
                <!--END DETAIL VIEW-->
            </div>
            <!--END MAIN TAB-->

            <!--BEGIN STATE TAB-->
                
            <div class="tab-pane fade" id="pills-state">
                <div v-if="!verboseMode">            
                    <ul>
                        <li>
                            <a class="text-decoration-none" href="/book/realtime_month">
                                FPPC Filings - Live Feed
                            </a>
                        </li>

                        <li>
                            <a class="text-decoration-none" href="/book/f497">
                                FPPC Late Contributions Made/Received (Last 7 Days)
                            </a>
                        </li>

                        <h6 class="px-0 pb-2">CA Independent Expenditure Filings</h6>
                        
                        <li>
                            <a class="text-decoration-none" href='/book/ca_ielist_g20'>
                                FPPC IE Filings by Election, Cycle, or Date Range
                            </a>
                        </li>

                        <li>
                            <a class="text-decoration-none" href="/book/cal_ie_hist">
                                IE Filings Directory
                            </a>
                        </li>

                        
                        <h6 class="px-0 pb-2">FPPC Information</h6>

                        <li>
                            <a class="text-decoration-none" href="/book/e22_finances">
                                2022 Campaign Finance Summaries
                            </a>
                        </li>

                        <li>
                            <a href="/book/fppc_lobby_2023">
                                2023 Top Lobbyist Employers/Firms
                            </a>
                        </li>

                        <li>    
                            <a href="/book/fppc_lobby_2022">
                                2022 Top Lobbyist Employers/Firms
                            </a>
                        </li>

                        <li>
                            <a href="/book/fppc_lobby_2021">
                                2021 Top Lobbyist Employers/Firms
                            </a>
                        </li>

                        <li>
                            <a class="text-decoration-none" href="/book/fppc_top_cmtes">
                                FPPC Summaries by Report End Date
                            </a>
                        </li>

                        <li>
                            <a class="text-decoration-none" href="/book/fppc_top_lobby">
                                FPPC Top Lobbying Payments by Year
                            </a>
                        </li>

                        <li>
                            <a class="text-decoration-none" href="/book/party_spend">
                                State/County Party Spending in Targeted Races (2020 General)
                            </a>
                        </li>

                        <li>
                            <a class="text-decoration-none" href="/book/ca_e20_finance_summary">
                                2020 Campaign Finance Summaries
                            </a>
                        </li>


                        <li>
                            <a class="text-decoration-none" href="/book/ca_candidates_e18_summary">
                                2018 Campaign Finance Summaries
                            </a>
                        </li>
                        <li>
                            <a class="text-decoration-none" href="/book/fppc_legislator_ballot_cmtes">
                                CA Ballot Measure Committees
                            </a>
                        </li>
                        <li>
                            <a class="text-decoration-none" href="/book/fppc_county_party">
                                County Political Party Committees
                            </a>
                        </li>

                        <h6 class="px-0 pb-2">Proposition Spending</h6>

                        <li>
                            <a class="text-decoration-none" href='/book/e20_prop_financials'>
                                2020 Propositions Financials
                            </a>
                        <li>
                        <a class="text-decoration-none" href="/book/fppc_past_prop_spending">
                            Past Spending on Propositions
                        </a>
                        </li>
                    </ul>
                </div>
                <!--END LIST VIEW-->

                <!--BEGIN DETAIL VIEW-->
                 <div v-if="verboseMode">
                    <div class="row d-flex text-justify">

                        <div class="card">
                            <a class="text-decoration-none" href="/book/realtime_month">
                                <div class='card-head fs-5 fw-bold'>
                                    FPPC Filings - Live Feed
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="card">
                            <a class="text-decoration-none" href="/book/f497">
                                <div class='card-head fs-5 fw-bold'>
                                    FPPC Late Contributions Made/Received (Last 7 Days)
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="card">
                            <a class="text-decoration-none" href='/book/ca_ielist_g20'>
                                <div class='card-head fs-5 fw-bold'>
                                    FPPC IE Filings by Election, Cycle, or Date Range
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="card">
                            <a class="text-decoration-none" href="/book/cal_ie_hist">
                                <div class='card-head fs-5 fw-bold'>
                                    IE Filings Directory
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>                        

                        <div class="card">
                            <a class="text-decoration-none" href="/book/e22_finances">
                                <div class='card-head fs-5 fw-bold'>
                                    2022 Campaign Finance Summaries
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>   

                        <div class="card">
                            <a class="text-decoration-none" href="/book/fppc_lobby_2023">
                                <div class='card-head fs-5 fw-bold'>
                                    2023 Top Lobbyist Employers/Firms
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>   

                        <div class="card">
                            <a class="text-decoration-none" href="/book/fppc_lobby_2022">
                                <div class='card-head fs-5 fw-bold'>
                                    2022 Top Lobbyist Employers/Firms
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="card">
                            <a class="text-decoration-none" href="/book/fppc_lobby_2021">
                                <div class='card-head fs-5 fw-bold'>
                                    2021 Top Lobbyist Employers/Firms
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div> 

                        <div class="card">
                            <a class="text-decoration-none" href="/book/fppc_top_cmtes">
                                <div class='card-head fs-5 fw-bold'>
                                    FPPC Summaries by Report End Date
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div> 

                        <div class="card">
                            <a class="text-decoration-none" href="/book/fppc_top_lobby">
                                <div class='card-head fs-5 fw-bold'>
                                    FPPC Top Lobbying Payments by Year
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div> 

                        <div class="card">
                            <a class="text-decoration-none" href="/book/party_spend">
                                <div class='card-head fs-5 fw-bold'>
                                    State/County Party Spending in Targeted Races (2020 General)
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div> 

                        <div class="card">
                            <a class="text-decoration-none" href="/book/ca_e20_finance_summary">
                                <div class='card-head fs-5 fw-bold'>
                                    2020 Campaign Finance Summaries
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div> 

                        <div class="card">
                            <a class="text-decoration-none" href="/book/ca_candidates_e18_summary">
                                <div class='card-head fs-5 fw-bold'>
                                    2018 Campaign Finance Summaries
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div> 

                        <div class="card">
                            <a class="text-decoration-none" href="/book/fppc_legislator_ballot_cmtes">
                                <div class='card-head fs-5 fw-bold'>
                                    CA Ballot Measure Committees
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div> 

                        <div class="card">
                            <a class="text-decoration-none" href="/book/fppc_county_party">
                                <div class='card-head fs-5 fw-bold'>
                                    County Political Party Committees
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>   

                        <div class="card">
                            <a class="text-decoration-none" href="/book/e20_prop_financials">
                                <div class='card-head fs-5 fw-bold'>
                                    2020 Propositions Financials
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>   

                        <div class="card">
                            <a class="text-decoration-none" href="/book/fppc_past_prop_spending">
                                <div class='card-head fs-5 fw-bold'>
                                    Past Spending on Propositions
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>   

                    </div>
                </div>
                <!--END DETAIL VIEW-->
            </div>
            <!--END STATE TAB-->


            <!--BEGIN FEDERAL TAB-->
            <div class="tab-pane fade" id="pills-federal">
                <div v-if="!verboseMode">            
                    <ul>
                        <li>
                            <a class="text-decoration-none" href="/book/realtime_month">
                                FEC Filings - Live Feed
                            </a>
                        </li>
                        <li>
                            <a class="text-decoration-none" href="/book/f496">
                                FEC IE Filings - Last 7 Days
                            </a>
                        </li>

                        <li>
                            <a class="text-decoration-none" href='/book/ca_ielist_fed_g20'>
                                FEC IE Filings - All
                            </a>
                        </li>

                        <h6 class="px-0 pb-2">FEC Information</h6>

                        <li>
                            <a class="text-decoration-none" href='/book/e22_finances_t'>
                                2022 Campaign Finance Summaries
                            </a>
                        </li>

                        <li>
                            <a class="text-decoration-none" href='/book/party_spend_t'>
                                National Party Spending (Targeted Races) - 2022 General
                            </a>
                        </li>

                        <li>
                            <a class="text-decoration-none" href='/book/party_spend_t_g20'>
                                National Party Spending (Targeted Races) - 2020 General
                            </a>
                        </li>

                        <li>
                            <a class="text-decoration-none" href='/book/e20_finances_t'>
                                2020 Campaign Finance Summaries
                            </a>
                        </li>
                    </ul>
                </div>
                <!--END LIST VIEW-->

                <!--BEGIN DETAIL VIEW-->
                <div v-if="verboseMode">
                    <div class="row d-flex text-justify">

                        <div class="card">
                            <a class="text-decoration-none" href="/book/realtime_month">
                                <div class='card-head fs-5 fw-bold'>
                                    FEC Filings - Live Feed
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="card">
                            <a class="text-decoration-none" href="/book/f496">
                                <div class='card-head fs-5 fw-bold'>
                                    FEC IE Filings - Last 7 Days
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="card">
                            <a class="text-decoration-none" href='/book/ca_ielist_fed_g20'>
                                <div class='card-head fs-5 fw-bold'>
                                    FEC IE Filings - All
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="card">
                            <a class="text-decoration-none" href='/book/e22_finances_t'>
                                <div class='card-head fs-5 fw-bold'>
                                    2022 Campaign Finance Summaries
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="card">
                            <a class="text-decoration-none" href='/book/party_spend_t'>
                                <div class='card-head fs-5 fw-bold'>
                                    National Party Spending (Targeted Races) - 2022 General
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="card">
                            <a class="text-decoration-none" href='/book/party_spend_t_g20'>
                                <div class='card-head fs-5 fw-bold'>
                                    National Party Spending (Targeted Races) - 2020 General
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="card">
                            <a class="text-decoration-none" href='/book/e20_finances_t'>
                                <div class='card-head fs-5 fw-bold'>
                                    2020 Campaign Finance Summaries
                                </div>
                                <div class="card-body">
                                    <div class="small text-justify">
                                        <ul class='bullet-square'>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!--END DETAIL VIEW-->
            </div>
            <!--END FEDERAL TAB-->
        </div>
    </div>
</div>