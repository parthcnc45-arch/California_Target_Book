    <div class="row">
        <div class="ctb-directory-column tabs-sec">
            <ul class="d-flex nav nav-pills mb-3 general-pill-tab" id="pills-tab" >
                <li class="nav-item active">
                    <a class="nav-link" data-toggle="pill" href="#pills-all"> All</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#pills-2024-cycle">2024</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#pills-2022-cycle">2022</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#pills-2020-cycle">2020</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#pills-2018-cycle">2018</a>
                </li>
            </ul>
        </div>
        <div class="ctb-directory-column">
            <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade active in" id="pills-all">
                    	<!--ALL - LIST VIEW -->
                    	<div v-if="!verboseMode">
                    		<h6>Election Detail Reports (2004-Present)</h6>
							<li>
							    <a class="text-decoration-none"  href="/book/results">
							        Election Detail Reports
							    </a>
							</li>
					
							<li>
							    <a class="text-decoration-none" href="/book/rpt_nav">
							        Election Detail Reports (Old)
							    </a>
							</li>

							<li>
							    <a class="text-decoration-none" href="/book/results_geo">
							        Past Election Results (2002 - Present) by Geographic Area
							    </a>
							</li>

							<li>
							    <a class="text-decoration-none"  href="/book/geo_nav">
							        Past Election Results (2002 - Present) by Geographic Area (Old)
							    </a>
							</li>
							<h6>Other Election Results</h6>
				            <li>
				                <a class="text-decoration-none" href="/book/city_detail_browser">
				                 County/Local Results (1996 - Present)
				                </a>
				             </li>

				            <li>
				                <a class="text-decoration-none" href="/book/city_browser2">
				                 Past Election Results by County, County Subdivision, or City
				                </a>
				             </li>

				            <li>
				                <a class="text-decoration-none" href='/book/uv'>
				                    Past Turnout & Undervote (2012 - 2016)
				                </a>
				            </li>

				            <li>
				                <a class="text-decoration-none" href="/book/vote_progress">
				                     Vote Count Over Time (2018 Primary - Present)
				                </a>
				            </li>

				            <li>
				                <a class="text-decoration-none" href="/book/past_sov">
				                 California Statement of Vote PDFs (1912 - Present)
				                </a>
				            </li>
				            <h6>Ballot Returns</h6>
				            <li>
				                <a class="text-decoration-none" href="/pdi_g18">
				                 PDI Absentee Ballot Trackers (2014 - 2020)
				                </a>
				             </li>
				        </div>
				        <!--END ALL - LIST VIEW -->


				        <!--ALL - CARD VIEW -->
                    	<div v-if="verboseMode">
                    		<div class="row d-flex text-justify">

                    			<div class='card'>
                    				<a class="text-decoration-none"  href="/book/results">
                    					<div class='card-head fs-5 fw-bold'>
                    						Election Detail Reports
                    					</div>
                    					<div class='card-body'>
                    						<div class='small text-justify'>
                    							<p>View complete election results by Congressional, Assembly, or State Senate District. Includes registration / turnout data by ethnic group, party, and age; partisan composition of returns by voting method; additional information broken out by city and county; full results by individual precincts.</p>	
                    						</div>
                    					</div>
                    				</a>
                    			</div>


                    			<div class='card'>
                    				<a class="text-decoration-none"  href="/book/rpt_nav">
                    					<div class='card-head fs-5 fw-bold'>
                    						Election Detail Reports (Legacy Version)
                    					</div>
                    					<div class='card-body'>
                    						<div class='small text-justify'>
                    							<p>View complete election results by Congressional, Assembly, or State Senate District. Includes registration / turnout data by ethnic group, party, and age; partisan composition of returns by voting method.</p>	
                    						</div>
                    					</div>
                    				</a>
                    			</div>
					
                    			<div class='card'>
                    				<a class="text-decoration-none"  href="/book/results_geo">
                    					<div class='card-head fs-5 fw-bold'>
                    						Past Election Results (2002 - Present) by Geographic Area
                    					</div>
                    					<div class='card-body'>
                    						<div class='small text-justify'>
                    							<p>View complete election results for all precincts within the boundaries of a specified geographic area. Includes registration / turnout data by ethnic group, party, and age; partisan composition of returns by voting method; additional information broken out by city and county; full results by individual precincts.</p>	
                    						</div>
                    					</div>
                    				</a>
                    			</div>


                    			<div class='card'>
                    				<a class="text-decoration-none"  href="/book/geo_nav">
                    					<div class='card-head fs-5 fw-bold'>
                    						Past Election Results by Geographic Area (Legacy Version)
                    					</div>
                    					<div class='card-body'>
                    						<div class='small text-justify'>
                    							<p>View complete election results for all precincts within the boundaries of a specified geographic area. Includes registration / turnout data by ethnic group, party, and age; partisan composition of returns by voting method.</p>	
                    						</div>
                    					</div>
                    				</a>
                    			</div>


                    			<div class='card'>
                    				<a class="text-decoration-none"  href="/book/city_detail_browser">
                    					<div class='card-head fs-5 fw-bold'>
                    						County/Local Results (1996 - Present)
                    					</div>
                    					<div class='card-body'>
                    						<div class='small text-justify'>
                    							<p>Lorem ipsum.</p>	
                    						</div>
                    					</div>
                    				</a>
                    			</div>

                    			<div class='card'>
                    				<a class="text-decoration-none"  href="/book/city_browser2">
                    					<div class='card-head fs-5 fw-bold'>
                    						Past Election Results by County, County Subdivision, or City
                    					</div>
                    					<div class='card-body'>
                    						<div class='small text-justify'>
                    							<p>Lorem ipsum.</p>	
                    						</div>
                    					</div>
                    				</a>
                    			</div>

                    			<div class='card'>
                    				<a class="text-decoration-none"  href="/book/vote_progress">
                    					<div class='card-head fs-5 fw-bold'>
                    						Vote Count Over Time
                    					</div>
                    					<div class='card-body'>
                    						<div class='small text-justify'>
                    							<p>View voting results for past elections throughout the counting period, including results broken out by each update.</p>	
                    						</div>
                    					</div>
                    				</a>
                    			</div>

                    			<div class='card'>
                    				<a class="text-decoration-none"  href="/book/past_sov">
                    					<div class='card-head fs-5 fw-bold'>
                    						California Statement of Vote PDFs (1912 - Present)
                    					</div>
                    					<div class='card-body'>
                    						<div class='small text-justify'>
                    							<p>Archived PDF copies of past California statements of vote for every election dating back to 1912.</p>	
                    						</div>
                    					</div>
                    				</a>
                    			</div>

                    			<div class='card'>
                    				<a class="text-decoration-none"  href="/book/past_sov">
                    					<div class='card-head fs-5 fw-bold'>
                    						PDI Ballot Return Tracker
                    					</div>
                    					<div class='card-body'>
                    						<div class='small text-justify'>
                    							<p>Political Data, Inc.'s public ballot return trackers (2014 - Present).</p>	
                    						</div>
                    					</div>
                    				</a>
                    			</div>
                    		</div>
				        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-2024-cycle">
			<!--2024 LIST VIEW -->
			<div v-if="!verboseMode">
                        	<ul>                           
	                            <li class="text-decoration-none">
        	                        <a class="text-decoration-none"  href='/book/p24_hub'>March 5th, 2024 Primary</a>
                	            </li>
                        	    <li class="text-decoration-none">
                                	<a class="text-decoration-none"  href='/book/media/2024'>2024 Campaign Ads</a>
	                            </li>
        	                </ul>
			</div>
			<!--END 2024 LIST VIEW -->

			<!--2024 VERBOSE VIEW-->
			<div v-if="verboseMode">
				<div class='row d-flex'>
                    			<div class='card'>
                    				<a class="text-decoration-none"  href="/book/p24_hub">
                    					<div class='card-head fs-5 fw-bold'>
                    						March 5th, 2024 Primary
                    					</div>
                    					<div class='card-body'>
                    						<div class='small text-justify'>
                    							<ul class='bullet-square'>
										<li>Candidates filed & ballot descriptions</li>
										<li>Live results scoreboard</li>
										<li>Mapped results</li>
										<li>County count progress</li>
										<li>Vote count changes over time</li>
										<li>Early/election day/post-election vote shifts</li>
										<li>Final certified results</li>
										<li>Turnout, Prop 1, US Senate (partial term) results by district</li>
										<li>GOP / Democratic delegate selection overviews.</li>
										<li>California Target Book's Post-Primary Deck.</li>

									</ul>
                    						</div>
                    					</div>
                    				</a>
                    			</div>
                    			<div class='card'>
                    				<a class="text-decoration-none"  href="/book/media/2024">
                    					<div class='card-head fs-5 fw-bold'>
                    						2024 Cycle Campaign Ads
                    					</div>
                    					<div class='card-body'>
                    						<div class='small text-justify'>
                    							<p>Archive of candidate / independent expenditure ads for the 2024 election cycle.</p>	
                    						</div>
                    					</div>
                    				</a>
                    			</div>
				</div>

			</div>
			<!--END 2024 VERBOSE VIEW-->

                    </div>
                    <div class="tab-pane fade" id="pills-2022-cycle">

			<!--2022 LIST VIEW -->
			<div v-if="!verboseMode">
                        	<ul>                           
	                            <li class="text-decoration-none">
        	                        <a class="text-decoration-none"  href='/book/p22_hub'>June 7th, 2022 Primary</a>
                	            </li>
	                            <li class="text-decoration-none">
        	                        <a class="text-decoration-none"  href='/book/g22_hub'>November 8th, 2022 General</a>
                	            </li>

                        	    <li class="text-decoration-none">
                                	<a class="text-decoration-none"  href='/book/media/2022'>2022 Campaign Ads</a>
	                            </li>
        	                </ul>
			</div>
			<!--END 2022 LIST VIEW -->

			<!--2022 VERBOSE VIEW-->
			<div v-if="verboseMode">
				<div class='row d-flex'>
                    			<div class='card'>
                    				<a class="text-decoration-none"  href="/book/p22_hub">
                    					<div class='card-head fs-5 fw-bold'>
                    						June 7th, 2022 Primary
                    					</div>
                    					<div class='card-body'>
                    						<div class='small text-justify'>
                    							<ul class='bullet-square'>
										<li>Candidates filed & ballot descriptions</li>
										<li>Live results scoreboard</li>
										<li>Mapped results</li>
										<li>County count progress</li>
										<li>Vote count changes over time</li>
										<li>Early/election day/post-election vote shifts</li>
										<li>Final certified results</li>
										<li>Top Two 1-page PDF summary</li>
									</ul>

                    						</div>
                    					</div>
                    				</a>
                    			</div>
                    			<div class='card'>
                    				<a class="text-decoration-none"  href="/book/g22_hub">
                    					<div class='card-head fs-5 fw-bold'>
                    						November 8th, 2022 General
                    					</div>
                    					<div class='card-body'>
                    						<div class='small text-justify'>
                   							<ul class='bullet-square'>
										<li>Candidates filed & ballot descriptions</li>
										<li>Live results scoreboard</li>
										<li>Mapped results</li>
										<li>County count progress</li>
										<li>Vote count changes over time</li>
										<li>Early/election day/post-election vote shifts</li>
										<li>Final certified results</li>
										<li>Preliminary reuslts by district (Governor, Controller, Treasurer, Attorney General , Prop 1)</li>
									</ul>

                    							
                    						</div>
                    					</div>
                    				</a>
                    			</div>

                    			<div class='card'>
                    				<a class="text-decoration-none"  href="/book/media/2022">
                    					<div class='card-head fs-5 fw-bold'>
                    						2022 Cycle Campaign Ads
                    					</div>
                    					<div class='card-body'>
                    						<div class='small text-justify'>
                    							<p>Archive of candidate / independent expenditure ads for the 2022 election cycle.</p>	
                    						</div>
                    					</div>
                    				</a>
                    			</div>
				</div>
			</div>
			<!--END 2022 VERBOSE VIEW-->

                    </div>

                    <div class="tab-pane fade" id="pills-2020-cycle">

			<!--2020 LIST VIEW -->
			<div v-if="!verboseMode">
                        	<ul>                           
	                            <li class="text-decoration-none">
        	                        <a class="text-decoration-none"  href='/book/p20_hub'>March 3rd, 2020 Primary</a>
                	            </li>
	                            <li class="text-decoration-none">
        	                        <a class="text-decoration-none"  href='/book/g20_hub'>November 3rd, 2020 General</a>
                	            </li>

                        	    <li class="text-decoration-none">
                                	<a class="text-decoration-none"  href='/book/media/2020'>2020 Campaign Ads</a>
	                            </li>
        	                </ul>
			</div>
			<!--END 2020 LIST VIEW -->

			<!--2020 VERBOSE VIEW-->
			<div v-if="verboseMode">
				<div class='row d-flex'>
                    			<div class='card'>
                    				<a class="text-decoration-none"  href="/book/p22_hub">
                    					<div class='card-head fs-5 fw-bold'>
                    						March 3rd, 2020 Primary
                    					</div>
                    					<div class='card-body'>
                    						<div class='small text-justify'>
                   							<ul class='bullet-square'>
										<li>Candidates filed & ballot descriptions</li>
										<li>Live results scoreboard</li>
										<li>Mapped results</li>
										<li>County count progress</li>
										<li>Vote count changes over time</li>
										<li>Final certified results</li>
									</ul>
                    						</div>
                    					</div>
                    				</a>
                    			</div>
                    			<div class='card'>
                    				<a class="text-decoration-none"  href="/book/g22_hub">
                    					<div class='card-head fs-5 fw-bold'>
                    						November 3rd, 2020 General
                    					</div>
                    					<div class='card-body'>
                    						<div class='small text-justify'>
                   							<ul class='bullet-square'>
										<li>Candidates filed & ballot descriptions</li>
										<li>Live results scoreboard</li>
										<li>Mapped results</li>
										<li>County count progress</li>
										<li>Vote count changes over time</li>
										<li>Final certified results</li>
									</ul>	
                    						</div>
                    					</div>
                    				</a>
                    			</div>

                    			<div class='card'>
                    				<a class="text-decoration-none"  href="/book/media/2020">
                    					<div class='card-head fs-5 fw-bold'>
                    						2020 Cycle Campaign Ads
                    					</div>
                    					<div class='card-body'>
                    						<div class='small text-justify'>
                    							<p>Archive of candidate / independent expenditure ads for the 2020 election cycle.</p>	
                    						</div>
                    					</div>
                    				</a>
                    			</div>
				</div>

			</div>
			<!--END 2020 VERBOSE VIEW-->

                    </div>

                    <div class="tab-pane fade" id="pills-2018-cycle">

			<!--2018 LIST VIEW -->
			<div v-if="!verboseMode">
                        	<ul>                           
	                            <li class="text-decoration-none">
        	                        <a class="text-decoration-none"  href='/book/p18_hub'>June 5th, 2018 Primary</a>
                	            </li>
	                            <li class="text-decoration-none">
        	                        <a class="text-decoration-none"  href='/book/g18_hub'>November 6th, 2018 General</a>
                	            </li>

                        	    <li class="text-decoration-none">
                                	<a class="text-decoration-none"  href='/book/media/2018'>2018 Campaign Ads</a>
	                            </li>
        	                </ul>
			</div>
			<!--END 2018 LIST VIEW -->

			<!--2018 VERBOSE VIEW-->
			<div v-if="verboseMode">
				<div class='row d-flex'>
                    			<div class='card'>
                    				<a class="text-decoration-none"  href="/book/p18_hub">
                    					<div class='card-head fs-5 fw-bold'>
                    						June 5th, 2018 Primary
                    					</div>
                    					<div class='card-body'>
                    						<div class='small text-justify'>
                   							<ul class='bullet-square'>
										<li>Candidates filed & ballot descriptions</li>
										<li>Live results scoreboard</li>
										<li>Mapped results</li>
										<li>County count progress</li>
										<li>Vote count changes over time</li>
										<li>Final certified results</li>
									</ul>	
	
                    						</div>
                    					</div>
                    				</a>
                    			</div>
                    			<div class='card'>
                    				<a class="text-decoration-none"  href="/book/g18_hub">
                    					<div class='card-head fs-5 fw-bold'>
                    						November 6th, 2018 General
                    					</div>
                    					<div class='card-body'>
                    						<div class='small text-justify'>
                   							<ul class='bullet-square'>
										<li>Candidates filed & ballot descriptions</li>
										<li>Live results scoreboard</li>
										<li>Mapped results</li>
										<li>County count progress</li>
										<li>Vote count changes over time</li>
										<li>Final certified results</li>
									</ul>	
	
                    						</div>
                    					</div>
                    				</a>
                    			</div>

                    			<div class='card'>
                    				<a class="text-decoration-none"  href="/book/media/2018">
                    					<div class='card-head fs-5 fw-bold'>
                    						2018 Cycle Campaign Ads
                    					</div>
                    					<div class='card-body'>
                    						<div class='small text-justify'>
                    							<p>Archive of candidate / independent expenditure ads for the 2018 election cycle.</p>	
                    						</div>
                    					</div>
                    				</a>
                    			</div>
				</div>
			</div>
			<!--END 2020 VERBOSE VIEW-->

                    </div>
            </div>
        </div>
    </div>
