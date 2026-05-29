
<li class="dropdown"  data-submenu="state" >
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
            @click="setSubMenu('state')">
        State
        <div v-show="subMenus.finance !== 'state'" class="material-icons pull-right">expand_more</div>
        <div v-show="subMenus.finance === 'state'" class="material-icons pull-right">expand_less</div>
    </a>
    <ul v-show="subMenus.finance === 'state'" class="dropdown-menu">
        <li>
            <a href="/book/realtime_month">
                FPPC Filings - Live Feed
            </a>
        </li>

        <li>
            <a href="/book/f497">
                FPPC Late Contributions Made/Received (Last 7 Days)
            </a>
        </li>


        <li>
            <h6>CA Independent Expenditure Filings</h6>
        </li>

	<li>
	    <a href='/book/ca_ielist_g20'>
		2020 General Election IE Filings
	    </a>
	</li>


	<li>
	    <a href='/book/ca_ielist_p20'>
		2020 Primary Election IE Filings
	    </a>
	</li>


	<li>
	    <a href='/book/ca_ielist_g18'>
		2018 General Election IE Filings
	    </a>
	</li>


	<li>
	    <a href='/book/ca_ielist_p18'>
		2018 Primary Election IE Filings
	    </a>
	</li>
        <li>
            <a href="/book/ca_ielist_s17">
                2017 Off-Year IE Filings
            </a>
        </li>
        <li>
            <a href="/book/ca_ielist_g16">
                2016 General Election IE Filings
            </a>
        </li>
        <li>
            <a href="/book/ca_ielist_p16.php">
                2016 Primary Election IE Filings
            </a>
        </li>
        <li>
            <a href="/book/cal_ie_hist">
                IE Filings Directory
            </a>
        </li>
        <li>
            <a href="/book/spending_history">
                Past Campaign & IE Spending
            </a>
        </li>

        <li>
            <h6>FPPC Information</h6>
        </li>

        <li>
            <a href="/book/e22_finances">
                2022 Campaign Finance Summaries
            </a>
        </li>

        <li>
            <a href="/book/fppc_lobby_2021">
                2021 Top Lobbyist Employers/Firms
            </a>
        </li>


        <li>
            <a href="/book/fppc_top_cmtes">
                FPPC Summaries by Report End Date
            </a>
        </li>

        <li>
            <a href="/book/fppc_top_lobby">
                FPPC Top Lobbying Payments by Year
            </a>
        </li>

        <li>
            <a href="/book/party_spend">
                State/County Party Spending in Targeted Races (2020 General)
            </a>
        </li>

        <li>
            <a href="/book/ca_e20_finance_summary">
                2020 Campaign Finance Summaries
            </a>
        </li>


        <li>
            <a href="/book/ca_candidates_e18_summary">
                2018 Campaign Finance Summaries
            </a>
        </li>
        <li>
            <a href="/book/fppc_active">
                FPPC Committee Directory (Active Only)
            </a>
        </li>
        <li>
            <a href="/book/fppc_all">
                FPPC Committee Directory (All)
            </a>
        </li>
        <li>
            <a href="/book/fppc_legislator_ballot_cmtes">
                CA Ballot Measure Committees
            </a>
        </li>
        <li>
            <a href="/book/fppc_county_party">
                County Political Party Committees
            </a>
        </li>


        <li>
            <h6>Proposition Spending</h6>
        </li>

	<li>
	     <a href='/book/e20_prop_financials'>
		2020 Propositions Financials
	     </a>
        <li>
            <a href="/book/fppc_past_prop_spending">
                Past Spending on Propositions
            </a>
        </li>

    </ul>
</li>



<li class="dropdown" data-submenu="federal" >
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
            @click="setSubMenu('federal')">
        Federal
        <div v-show="subMenus.finance !== 'federal'" class="material-icons pull-right">expand_more</div>
        <div v-show="subMenus.finance === 'federal'" class="material-icons pull-right">expand_less</div>
    </a>
    <ul v-show="subMenus.finance === 'federal'" class="dropdown-menu">
	<li>
	    <h6>Campaign & IE Spending Charts</h6>
	</li>

	<li>
	     <a href='/book/fed_spending_2020_ca'>2020 California Races</a>
	</li>

	<li>
	     <a href='/book/fed_spending_2020_all'>2020 All Races</a>
	</li>

	<li>
	     <a href='/book/fed_spending_2017_2018_ca'>2017 - 2018 California Races</a>
	</li>
	<li>
	     <a href='/book/fed_spending_2017_2018_all'>2017 - 2018 All Races</a>
	</li>	
        <li>
            <h6>FEC Filings</h6>
        </li>
	<li>
	    <a href='/book/fec_2020_hub'>FEC Campaign 2020 Filings Hub (Live)</a>
	</li>
        <li>
            <a href='/book/fec_new'>FEC Filings (New) - Live Feed</a>
        </li>
        <li>
            <a href='/book/fec_detailed'>FEC Filings (New) - Detailed Live Feed</a>
        </li>
        <li>
            <a href='/book/fec_all'>FEC Filings (All) - Live Feed</a>
        </li>

	<li>
		<h6>FEC 48-Hour Contribution Reports</h6>
	</li>
		
	<li>
		<a href='/book/f6_by_cmte'>By Candidate Totals</a>
	</li>

	<li>
		<a href='/book/f6_by_donor'>By Top Individual Transactions</a>
	</li>

        <li>
            <h6>Campaign Finance Summaries</h6>
        </li>
        <li>
            <a href='/book/g18_fedsumbrowser'>2018 Campaign Cycle</a>
        </li>
        <li>
            <a href='/book/g16_fedsumbrowser'>2016 Campaign Cycle</a>
        </li>
        <li>
            <a href='/book/g14_fedsumbrowser'>2014 Campaign Cycle</a>
        </li>
        <li>
            <a href='/book/g12_fedsumbrowser'>2012 Campaign Cycle</a>
        </li>


        <li>
            <h6>FEC Committees</h6>
        </li>


        <li>
            <a href='/book/fec_cmte_directory'>FEC Committee Directory</a>
        </li>
        <li>
            <a href='/book/f3_summaries'>2017 Form 3 Summaries</a>
        </li>
        <li>
            <a href='/book/fec_act_blue/'>FEC ActBlue Summaries (2017-2018)</a>
        </li>
        <li>
            <a href='/book/fec_act_blue_monthly'>FEC ActBlue Monthly Summary (CA)</a>
        </li>
        <li>
            <a href='/book/heybigspender_18'>2018 Independent Expenditures</a>
        </li>

    </ul>
</li>


{{--<li class="dropdown" data-submenu="local" >--}}
    {{--<a class="dropdown-toggle" data-toggle="dropdown" href="#"--}}
            {{--@click="setSubMenu('local')">--}}
        {{--Local--}}
        {{--<div v-show="subMenus.finance !== 'local'" class="material-icons pull-right">expand_more</div>--}}
        {{--<div v-show="subMenus.finance === 'local'" class="material-icons pull-right">expand_less</div>--}}
    {{--</a>--}}
    {{--<ul v-show="subMenus.finance === 'local'" class="dropdown-menu">--}}
    {{--</ul>--}}
{{--</li>--}}

