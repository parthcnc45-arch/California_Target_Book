<li><a href='/book/new_districts'><b>NEW DISTRICT DIRECTORY</b></a></li>

<li><h6>Final Map Info</h6></li>
<li><a href='/book/draft_map_viz_1220_summary'>Final Map Summary Tables</a></li>
<li><a href='/book/draft_map_viz_1220_cvap'>Final Map CVAP Tables</a></li>		
<li><a href='/book/draft_map_viz_1220_interactive'>Final Map Interactive Map Viewer</a></li>
<hr/>






<h6>News / Info</h6>
<li><a href='/book/redist_news'>Redistricting News</a></li>
<li><a href='/book/redist_timelines'>Redistricting Timelines</a></li>

<h6>Redisticting Commission</h6>
<li><a href='/book/commissioners'>Members</a></li>

<h6>Data</h6>
<li><a href="/book/geo_nav">Election Results/Past Census by Geographic Area</a></li>
<li><a href="/book/blockgroup_nav">Census Block Group Maps/Data (2010 / 2018) by Geographic Area</a></li>
<li><a href="/book/acs_delta">Population/Ethnic Demographic Changes by Census Location (2012 to 2018)</a></li>
<li><a href="/book/geo_info">Lookup County/City/District Information by Location</a></li>

<hr />

<li><h6>Obsolete  Visualizations</h6></li>
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
            @click="setSubMenu('visualizations6')">
        December Visualizations (Updated 12/18)
        <div v-show="subMenus.redist !== 'visualizations6'" class="material-icons pull-right">expand_more</div>
        <div v-show="subMenus.redist === 'visualizations6'" class="material-icons pull-right">expand_less</div>
    </a>
    <ul v-show="subMenus.redist === 'visualizations6'" class="dropdown-menu">
		<li><h6>12/18 Congressional Map Info</h6></li>

		<li><a href='/book/draft_map_viz_1218_summary'>12/18 Congressional Map Summary Tables</a>
		<li><a href='/book/draft_map_viz_1218_cvap'>12/18 Congressional Map CVAP Tables</a>		
		<li><a href='/book/draft_map_viz_1218_interactive'>12/18 Congressional Interactive Map Viewer</a>


		<li><h6>12/17 State Senate Map Info</h6></li>

		<li><a href='/book/draft_map_viz_1217_summary'>12/17 Senate Map Summary Tables</a>
		<li><a href='/book/draft_map_viz_1217_cvap'>12/17 Senate Map CVAP Tables</a>		
		<li><a href='/book/draft_map_viz_1217_interactive'>12/17 Senate Interactive Map Viewer</a>


		<li><h6>12/11 Congressional Map Info</h6></li>

		<li><a href='/book/draft_map_viz_1211_summary'>12/11 Congressional Map Summary Tables</a>
		<li><a href='/book/draft_map_viz_1211_cvap'>12/11 Congressional Map CVAP Tables</a>		
		<li><a href='/book/draft_map_viz_1211_interactive'>12/11 Congressional Interactive Map Viewer</a>

		<li><h6>12/06 Assembly Map Info (OBSOLETE)</h6></li>

		<li><a href='/book/draft_map_viz_1206_summary'>December Map Summary Tables</a>
		<li><a href='/book/draft_map_viz_1206_cvap'>December Map CVAP Tables</a>		
		<li><a href='/book/draft_map_viz_1206_interactive'>Interactive Map Viewer</a>
    </ul>
</li>

<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
            @click="setSubMenu('visualizations7')">
        Pre-Final Maps
        <div v-show="subMenus.redist !== 'visualizations7'" class="material-icons pull-right">expand_more</div>
        <div v-show="subMenus.redist === 'visualizations7'" class="material-icons pull-right">expand_less</div>
    </a>
    <ul v-show="subMenus.redist === 'visualizations7'" class="dropdown-menu">
		<li><h6>Pre-Final Assembly (12/08) </h6></li>
	        
		<li><a href="/book/viz6/AD/NORCAL">Central / Northern California</a></li>
		<li><a href="/book/viz6/AD/COAST">Bay Area / North & Central Coast</a></li>
		<li><a href="/book/viz6/AD/LA">Los Angeles County</a></li>
		<li><a href="/book/viz6/AD/SOCAL">Southern California</a></li>

		<li><h6>Pre-Final Assembly (12/08) </h6></li>

		<li><a href='/book/draft_map_viz_1208_summary'>Summary Tables</a>
		<li><a href='/book/draft_map_viz_1208_cvap'>CVAP Tables</a>		
		<li><a href='/book/draft_map_viz_1208_interactive'>Interactive Map Viewer</a>


    </ul>
</li>


<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
            @click="setSubMenu('visualizations5')">
        DRAFT MAPS v1
        <div v-show="subMenus.redist !== 'visualizations5'" class="material-icons pull-right">expand_more</div>
        <div v-show="subMenus.redist === 'visualizations5'" class="material-icons pull-right">expand_less</div>
    </a>
    <ul v-show="subMenus.redist === 'visualizations5'" class="dropdown-menu">
		<li><h6>State Senate</h6></li>
	    <li><a href="/book/draft/SD/NORCAL">Central / Northern California</a></li>
	    <li><a href="/book/draft/SD/COAST">Bay Area / North & Central Coast</a></li>
	    <li><a href="/book/draft/SD/LA">Los Angeles County</a></li>
	    <li><a href="/book/draft/SD/SOCAL">Southern California</a></li>

		<li><h6>Assembly</h6></li>
	    <li><a href="/book/draft/AD/NORCAL">Central / Northern California</a></li>
	    <li><a href="/book/draft/AD/COAST">Bay Area / North & Central Coast</a></li>
	    <li><a href="/book/draft/AD/LA">Los Angeles County</a></li>
	    <li><a href="/book/draft/AD/SOCAL">Southern California</a></li>

		<li><h6>Congressional</h6></li>
	    <li><a href="/book/draft/CD/NORCAL">Central / Northern California</a></li>
	    <li><a href="/book/draft/CD/COAST">Bay Area / North & Central Coast</a></li>
	    <li><a href="/book/draft/CD/LA">Los Angeles County</a></li>
	    <li><a href="/book/draft/CD/SOCAL">Southern California</a></li>

<li><a href='/book/draft_map_v1_summary'>Draft Map v1 Summary Tables</a></li>
<li><a href='/book/draft_map_v1_cvap'>Draft Map v1 CVAP Tables</a></li>
<li><a href='/book/draft_map_v1_interactive'>Draft Map v1 Interactive Map Viewer</a></li>
<li><a href='/book/map_analysis'>Map Analysis Archive</a></li>

    </ul>
</li>

<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
            @click="setSubMenu('visualizations4')">
        Visualizations v4
        <div v-show="subMenus.redist !== 'visualizations4'" class="material-icons pull-right">expand_more</div>
        <div v-show="subMenus.redist === 'visualizations4'" class="material-icons pull-right">expand_less</div>
    </a>
    <ul v-show="subMenus.redist === 'visualizations4'" class="dropdown-menu">
		<li><h6>State Senate</h6></li>
		<li><a href="/book/viz4/SD/NORCAL">Central / Northern California</a></li>
	    <li><a href="/book/viz4/SD/COAST">Bay Area / North & Central Coast</a></li>
	    <li><a href="/book/viz4/SD/LA">Los Angeles County</a></li>
	    <li><a href="/book/viz4/SD/SOCAL">Southern California</a></li>
		<li><h6>Assembly</h6></li>
		<li><a href="/book/viz4/AD/NORCAL">Central / Northern California</a></li>
	    <li><a href="/book/viz4/AD/COAST">Bay Area / North & Central Coast</a></li>
	    <li><a href="/book/viz4/AD/LA">Los Angeles County</a></li>
	    <li><a href="/book/viz4/AD/SOCAL">Southern California</a></li>	
	    <li><h6>Congressional</h6></li>
		<li><a href="/book/viz4/CD/NORCAL">Central / Northern California</a></li>
	    <li><a href="/book/viz4/CD/COAST">Bay Area / North & Central Coast</a></li>
	    <li><a href="/book/viz4/CD/LA">Los Angeles County</a></li>
	    <li><a href="/book/viz4/CD/SOCAL">Southern California</a></li>
    </ul>
</li>

<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
            @click="setSubMenu('visualizations3')">
        Visualizations v3
        <div v-show="subMenus.redist !== 'visualizations3'" class="material-icons pull-right">expand_more</div>
        <div v-show="subMenus.redist === 'visualizations3'" class="material-icons pull-right">expand_less</div>
    </a>
    <ul v-show="subMenus.redist === 'visualizations3'" class="dropdown-menu">
		<li><h6>State Senate</h6></li>
		<li><a href="/book/viz3/SD/NORCAL">Central / Northern California</a></li>
	    <li><a href="/book/viz3/SD/COAST">Bay Area / North & Central Coast</a></li>
	    <li><a href="/book/viz3/SD/LA">Los Angeles County</a></li>
	    <li><a href="/book/viz3/SD/SOCAL">Southern California</a></li>
		<li><h6>Assembly</h6></li>
		<li><a href="/book/viz3/AD/NORCAL">Central / Northern California</a></li>
	    <li><a href="/book/viz3/AD/COAST">Bay Area / North & Central Coast</a></li>
	    <li><a href="/book/viz3/AD/LA">Los Angeles County</a></li>
	    <li><a href="/book/viz3/AD/SOCAL">Southern California</a></li>	
	    <li><h6>Congressional</h6></li>
		<li><a href="/book/viz3/CD/NORCAL">Central / Northern California</a></li>
	    <li><a href="/book/viz3/CD/COAST">Bay Area / North & Central Coast</a></li>
	    <li><a href="/book/viz3/CD/LA">Los Angeles County</a></li>
	    <li><a href="/book/viz3/CD/SOCAL">Southern California</a></li>    
	</ul>
</li>
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
            @click="setSubMenu('visualizations2')">
        Visualizations v2
        <div v-show="subMenus.redist !== 'visualizations2'" class="material-icons pull-right">expand_more</div>
        <div v-show="subMenus.redist === 'visualizations2'" class="material-icons pull-right">expand_less</div>
    </a>
    <ul v-show="subMenus.redist === 'visualizations2'" class="dropdown-menu">
		<li><h6>State Senate</h6></li>
		<li><a href="/book/viz2/SD/NORCAL">Central / Northern California</a></li>
	    <li><a href="/book/viz2/SD/COAST">Bay Area / North & Central Coast</a></li>
	    <li><a href="/book/viz2/SD/LA">Los Angeles County</a></li>
	    <li><a href="/book/viz2/SD/SOCAL">Southern California</a></li>
		<li><h6>Assembly</h6></li>
		<li><a href="/book/viz2/AD/NORCAL">Central / Northern California</a></li>
	    <li><a href="/book/viz2/AD/COAST">Bay Area / North & Central Coast</a></li>
	    <li><a href="/book/viz2/AD/LA">Los Angeles County</a></li>
	    <li><a href="/book/viz2/AD/SOCAL">Southern California</a></li>	
	    <li><h6>Congressional</h6></li>
		<li><a href="/book/viz2/CD/NORCAL">Central / Northern California</a></li>
	    <li><a href="/book/viz2/CD/COAST">Bay Area / North & Central Coast</a></li>
	    <li><a href="/book/viz2/CD/LA">Los Angeles County</a></li>
	    <li><a href="/book/viz2/CD/SOCAL">Southern California</a></li>      </ul>
</li>
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
            @click="setSubMenu('visualizations')">
        Visualizations v1
        <div v-show="subMenus.redist !== 'visualizations'" class="material-icons pull-right">expand_more</div>
        <div v-show="subMenus.redist === 'visualizations'" class="material-icons pull-right">expand_less</div>
    </a>
    <ul v-show="subMenus.redist === 'visualizations'" class="dropdown-menu">
		<li><h6>State Senate</h6></li>
		<li><a href="/book/viz_sd_a_norcal">A - Central / Northern California</a></li>
		<li><a href="/book/viz_sd_a_coast">A - Bay Area / North & Central Coast</a></li>
	    <li><a href="/book/viz_sd_a_laco">A - Los Angeles County</a></li>
	    <li><a href="/book/viz_sd_a_socal">A - Southern California</a></li>
	    <li><a href="/book/viz_sd_b_norcal">B - Central / Northern California</a></li>
	    <li><a href="/book/viz_sd_b_coast">B - Bay Area / North & Central Coast</a></li>
		<li><a href="/book/viz_sd_b_laco">B - Los Angeles County</a></li>
		<li><a href="/book/viz_sd_b_socal">B - Southern California</a></li>
		<li><h6>Assembly</h6></li>
		<li><a href="/book/viz_ad_a_norcal">A - Central / Northern California</a></li>
		<li><a href="/book/viz_ad_a_coast">A - Bay Area / North & Central Coast</a></li>
	    <li><a href="/book/viz_ad_a_laco">A - Los Angeles County</a></li>
	    <li><a href="/book/viz_ad_a_socal">A - Southern California</a></li>
	    <li><a href="/book/viz_ad_b_norcal">B - Central / Northern California</a></li>
	    <li><a href="/book/viz_ad_b_coast">B - Bay Area / North & Central Coast</a></li>
		<li><a href="/book/viz_ad_b_laco">B - Los Angeles County</a></li>
		<li><a href="/book/viz_ad_b_socal">B - Southern California</a></li>
		<li><h6>Congressional</h6></li>
		<li><a href="/book/viz_cd_a_norcal">A - Central / Northern California</a></li>
		<li><a href="/book/viz_cd_a_coast">A - Bay Area / North & Central Coast</a></li>
	    <li><a href="/book/viz_cd_a_laco">A - Los Angeles County</a></li>
	    <li><a href="/book/viz_cd_a_socal">A - Southern California</a></li>
	    <li><a href="/book/viz_cd_b_norcal">B - Central / Northern California</a></li>
	    <li><a href="/book/viz_cd_b_coast">B - Bay Area / North & Central Coast</a></li>
		<li><a href="/book/viz_cd_b_laco">B - Los Angeles County</a></li>
		<li><a href="/book/viz_cd_b_socal">B - Southern California</a></li>
    </ul>
</li>



