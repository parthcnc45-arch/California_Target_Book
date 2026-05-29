@inject('ctbUtil', 'App\Services\CTB\Util')
@inject('districts', 'App\Services\CTB\Districts')

<div class="row">
	<div class="ctb-directory-column">
		<ul class="nav nav-pills mb-3 general-pill-tab" id="pills-tab">
		     <li class="nav-item active">
			<a class="nav-link" data-toggle="pill" href="#pills-ad-20">
				AD
			</a>
		     </li>

		     <li class="nav-item">
			<a class="nav-link" data-toggle="pill" href="#pills-sd-20">
				SD
			</a>
		     </li>

		     <li class="nav-item">
			<a class="nav-link" data-toggle="pill" href="#pills-cd-20">
				CD
			</a>
		     </li>

		     <li class="nav-item">
			<a class="nav-link" data-toggle="pill" href="#pills-boe-20">
				BOE
			</a>
		     </li>

		     <li class="nav-item">
			<a class="nav-link" data-toggle="pill" href="#pills-stw">
				Statewide
			</a>
		     </li>

		     <li class="nav-item">
			<a class="nav-link" data-toggle="pill" href="#pills-uss">
				US Senate
			</a>
		     </li>

		     <li class="nav-item">
			<a class="nav-link" data-toggle="pill" href="#pills-county">
				Counties
			</a>
		     </li>

		     <li class="nav-item">
			<a class="nav-link" data-toggle="pill" href="#pills-us">
				US House (All)
			</a>
		     </li>

		     <li class="nav-item">
			<a class="nav-link" data-toggle="pill" href="#pills-ad-10">
				AD (Old)
			</a>
		     </li>

		     <li class="nav-item">
			<a class="nav-link" data-toggle="pill" href="#pills-sd-10">
				SD (Old)
			</a>
		     </li>

		     <li class="nav-item">
			<a class="nav-link" data-toggle="pill" href="#pills-cd-10">
				CD (Old)
			</a>
		     </li>
		 </ul>
	   </div>
	   <div class="ctb-directory-column">
		<div class="tab-content" id="pills-tabContent">

			<!--ADs (CURRENT) -->
			<div class="tab-pane fade active in" id="pills-ad-20">
			    <div class="district-card" v-if="!verboseMode">
    				<ul class="numbered-nav">
				        @foreach ($districts->find2('AD') as $dist)
				            <li class="ctb-tooltip-container">
				                <a class="{{ $districts->getParty($dist->PARTY) }}"
						    href="/book/new/{{$dist->DIST}}">
				                    <span>
				                        {{ $districts->parseNumber($dist->DIST) }}
				                    </span>
						    <div :class="['incumbent', { 'ctb-tooltip': !verboseMode }]">{{ $dist->ALIAS }}</div>
				                    
				                </a>
				            </li>
        				@endforeach
			         </ul>
			    </div>
				   <div class="row" v-if="verboseMode">
					@foreach ($districts->find2('AD') as $dist)
					   <div class="col-lg-2 col-md-3 col-sm-4">
						<a href="/book/new/{{$dist->DIST}}" class="text-decoration-none">
						<div class="card">
							<div class="card-head {{ $dist->PARTY == 'D' ? 'bg-primary' : ($dist->PARTY == 'R' ? 'bg-danger' : '') }}">
							   {{ $dist->DIST }}
							</div>
							<div class="card-body">
							   <h4>{{ $dist->LEGISLATOR }}</h4>
   							   <div class="row">
								<div class='col-lg-6'>
                                				   <div class='small 
				                                       @if (strpos($dist->PRS_20, 'Biden') !== false)
                                   					     text-primary
				                                       @elseif (strpos($dist->PRS_20, 'Trump') !== false)
                                   					     text-danger
                                   				       @endif'>

									   {{ $dist->PRS_20 }}
									</div>
								</div>
								<div class='col-lg-6'>
                                				   <div class='small 
				                                       @if (strpos($dist->GOV_22, 'Newsom') !== false)
                                   					     text-primary
				                                       @elseif (strpos($dist->GOV_22, 'Dahle') !== false)
                                   					     text-danger
                                   				       @endif'>
									   {{ $dist->GOV_22 }}
									</div>
								</div>
							   </div>
						   	</div>
						   </div>
						  </a>
					    </div>
					@endforeach
				   </div>

			</div>

			<!--SDs (CURRENT) -->
			<div class="tab-pane fade in" id="pills-sd-20">
			    <div class="district-card" v-if="!verboseMode">
    				<ul class="numbered-nav">
				        @foreach ($districts->find2('SD') as $dist)
				            <li class="ctb-tooltip-container">
				                <a class="{{ $districts->getParty($dist->PARTY) }}"
						    href="/book/new/{{$dist->DIST}}">
				                    <span>
				                        {{ $districts->parseNumber($dist->DIST) }}
				                    </span>
						    <div :class="['incumbent', { 'ctb-tooltip': !verboseMode }]">{{ $dist->ALIAS }}</div>
				                    
				                </a>
				            </li>
        				@endforeach
			         </ul>
			    </div>
				   <div class="row" v-if="verboseMode">
					@foreach ($districts->find2('SD') as $dist)
					   <div class="col-lg-2 col-md-3 col-sm-4">
						<a href="/book/new/{{$dist->DIST}}" class="text-decoration-none">
						<div class="card">
							<div class="card-head {{ $dist->PARTY == 'D' ? 'bg-primary' : ($dist->PARTY == 'R' ? 'bg-danger' : '') }}">
							   {{ $dist->DIST }}
							</div>
							<div class="card-body">
							   <h4>{{ $dist->LEGISLATOR }}</h4>
   							   <div class="row">
								<div class='col-lg-6'>
                                				   <div class='small 
				                                       @if (strpos($dist->PRS_20, 'Biden') !== false)
                                   					     text-primary
				                                       @elseif (strpos($dist->PRS_20, 'Trump') !== false)
                                   					     text-danger
                                   				       @endif'>

									   {{ $dist->PRS_20 }}
									</div>
								</div>
								<div class='col-lg-6'>
                                				   <div class='small 
				                                       @if (strpos($dist->GOV_22, 'Newsom') !== false)
                                   					     text-primary
				                                       @elseif (strpos($dist->GOV_22, 'Dahle') !== false)
                                   					     text-danger
                                   				       @endif'>
									   {{ $dist->GOV_22 }}
									</div>
								</div>
							   </div>
						   	</div>
						   </div>
						   </a>
					    </div>
					@endforeach
				   </div>

			</div>


			<!--CDs (CURRENT) -->
			<div class="tab-pane fade in" id="pills-cd-20">
			    <div class="district-card" v-if="!verboseMode">
    				<ul class="numbered-nav">
				        @foreach ($districts->find2('CD') as $dist)
				            <li class="ctb-tooltip-container">
				                <a class="{{ $districts->getParty($dist->PARTY) }}"
						    href="/book/new/{{$dist->DIST}}">
				                    <span>
				                        {{ $districts->parseNumber($dist->DIST) }}
				                    </span>
						    <div :class="['incumbent', { 'ctb-tooltip': !verboseMode }]">{{ $dist->ALIAS }}</div>
				                    
				                </a>
				            </li>
        				@endforeach
			         </ul>
			    </div>
				   <div class="row" v-if="verboseMode">
					@foreach ($districts->find2('CD') as $dist)
					   <div class="col-lg-2 col-md-3 col-sm-4">
						<a href="/book/new/{{$dist->DIST}}" class="text-decoration-none">
						<div class="card">
							<div class="card-head {{ $dist->PARTY == 'D' ? 'bg-primary' : ($dist->PARTY == 'R' ? 'bg-danger' : '') }}">
							   {{ $dist->DIST }}
							</div>
							<div class="card-body">
							   <h4>{{ $dist->LEGISLATOR }}</h4>
   							   <div class="row">
								<div class='col-lg-6'>
                                				   <div class='small 
				                                       @if (strpos($dist->PRS_20, 'Biden') !== false)
                                   					     text-primary
				                                       @elseif (strpos($dist->PRS_20, 'Trump') !== false)
                                   					     text-danger
                                   				       @endif'>

									   {{ $dist->PRS_20 }}
									</div>
								</div>
								<div class='col-lg-6'>
                                				   <div class='small 
				                                       @if (strpos($dist->GOV_22, 'Newsom') !== false)
                                   					     text-primary
				                                       @elseif (strpos($dist->GOV_22, 'Dahle') !== false)
                                   					     text-danger
                                   				       @endif'>
									   {{ $dist->GOV_22 }}
									</div>
								</div>
							   </div>
						   	</div>
						   </div>
						 </a>
					    </div>
					@endforeach
				   </div>

			</div>

			<!--BOE -->

			<div class="tab-pane fade" id="pills-boe-20">
			    <div class="district-card">
				    <ul>
				        @foreach ($districts->find('BOE') as $dist)
				            <li>
				                <a href="/book/new/{{$dist->DIST}}">
				                    {{ $dist->DIST }}
				                    <small class="pull-right {{ $districts->getParty($dist->PARTY) }}">
				                        {{ $dist->LEGISLATOR }}
				                    </small>
				                </a>
				            </li>
				        @endforeach
				    </ul>
			    </div>
			</div>

			<!--CONSTITUTIONAL -->

			<div class="tab-pane fade" id="pills-stw">
			    <div class="district-card">
				<ul>
				        <li><a href='/book/new/.GOV'>Governor </a></li>
				        <li><a href='/book/new/.LTG'>Lt. Governor </a></li>
				        <li><a href='/book/new/.ATG'>Attorney General </a></li>
				        <li><a href='/book/new/.SOS'>Secretary of State </a></li>
				        <li><a href='/book/new/.TRS'>Treasurer </a></li>
				        <li><a href='/book/new/.CON'>Controller </a></li>
				        <li><a href='/book/new/.INS'>Insurance Commissioner </a></li>
				        <li><a href='/book/new/.SPI'>Superintendent of Public Instruction </a></li>
			        </ul>
			    </div>
			</div>

			<!--US Senate -->

			<div class="tab-pane fade" id="pills-uss">
			    <div class="district-card">
				    <ul>
				        @foreach ($districts->find('.SN') as $dist)
				            <li>
				                <a href="/book/new/{{ $dist->DIST }}">
				                    {{ $dist->DIST }}
				                    <small class="pull-right {{ $districts->getParty($dist->PARTY) }}">
				                        {{ $dist->LEGISLATOR }}
				                    </small>
				                </a>
				            </li>
				        @endforeach
				    </ul>
			    </div>
			</div>



			<!--COUNTY -->

			<div class="tab-pane fade" id="pills-county">
			    <div class="district-card-wide">

				    <ul>
				        @foreach ($ctbUtil->getCounties() as $county)
					  <div class="col-lg-2 col-sm-4">
				            <li>
				                <a href="{{ route('book.county', [ 'id' => $county ]) }}">
				                    {{ ucwords(strtolower($county))  }}
				                </a>
				            </li>
				          </div>
				        @endforeach
				    </ul>
			    </div>
			</div>


			<!--US Federal (ALL)-->

			<div class="tab-pane fade" id="pills-us">
				<div class="ctb-directory-column">
   	         	    <ul class="nav nav-pills mb-3 general-pill-tab" id="fed-pills-tab">
			          	@foreach ($districts->getFed() as $state => $fedDistricts)
			            	<li class="nav-item">
			                	<a class="nav-link" data-toggle="pill" href="#pills-fed-{{ $state }}">
		                 			{{ $ctbUtil->formatState($state) }}
			                	</a>
				    		</li>
						@endforeach
			     	</ul>
			   </div>

			   <div class="ctb-directory-column">
			   		<div class="tab-content" id="pills-tabContentUS">
			        	@foreach ($districts->getFed() as $state => $fedDistricts)
				     		<div class="tab-pane fade" id="pills-fed-{{ $state }}">
					  			@foreach ($fedDistricts as $dist)
					  				<div v-if="!verboseMode">
						    			<div class="col-lg-2 col-sm-4">
											<li class="ctb-tooltip-container">
												<a class="{{ $districts->getParty($dist->PARTY) }}" href="/book/US/{{ $dist->DIST }}">
			                                		<span>
					                                    {{ $dist->DIST }}
					                                </span>
													&nbsp;&nbsp;
													<span>
														{{ $dist->NAML }}
													</span>
												</a>
											</li>
						    			</div>
						    		</div>
						    		<div v-if="verboseMode">
								     
						  				<div class="district-nav-card-item col-lg-2 col-md-3 col-sm-4">
						  					<a href="/book/us/{{$dist->DIST}}" class="text-decoration-none">
						  						<div class="card district-nav-card d-flex">
						  							<div class="card-head {{ $dist->PARTY == 'D' ? 'bg-primary' : ($dist->PARTY == 'R' ? 'bg-danger' : '') }}">
						  								{{ $dist->DIST }}
						  							</div>
						  							<div class='district-nav-card-body card-body'>
						  								<h4>{{ $dist->NAMF }} {{ $dist->NAML }}</h4>
						  								<div class='row'>
															<div class='col-lg-4'>
						  										<div class="small
						  											@if (strpos($dist->PRS_16, 'Clinton') !== false)
						  												text-primary
						  											@elseif (strpos($dist->PRS_16, 'Trump') !== false))
						  												 text-danger
						  											@endif
						  										">PRS '16<br>
						  											{{$dist->PRS_16}}
						  										</div>
						  									</div>
						  									<div class='col-lg-4'>
						  										<div class="small
						  											@if (strpos($dist->PRS_20, 'Biden') !== false)
						  												text-primary
						  											@elseif (strpos($dist->PRS_20, 'Trump') !== false))
						  												 text-danger
						  											@endif
						  										">PRS '20<br>
						  											{{$dist->PRS_20}}
						  										</div>
						  									</div>		
						  									<div class='col-lg-4'>
						  										<div class="small
						  											@if (strpos($dist->PRS_24, 'Harris') !== false)
						  												text-primary
						  											@elseif (strpos($dist->PRS_24, 'Trump') !== false))
						  												 text-danger
						  											@endif
						  										">PRS '24<br>
						  											{{$dist->PRS_24}}
						  										</div>
						  									</div>					  									
						  								</div>
						  							</div>
						  						</div>
						  					</a>
						  				</div>
									
						    		</div>
					  			@endforeach
				     		</div>
						@endforeach
			   		</div>
				</div>
			</div>					


			<!--ADs (2012-2021) -->

			<div class="tab-pane fade" id="pills-ad-10">

			    <div class="district-card" v-if="!verboseMode">
    				<ul class="numbered-nav">
				        @foreach ($districts->find('AD') as $dist)
				            <li class="ctb-tooltip-container">
				                <a class="{{ $districts->getParty($dist->PARTY) }}"
						    href="/book/old/{{$dist->DIST}}">
				                    <span>
				                        {{ $districts->parseNumber($dist->DIST) }}
				                    </span>
						    <div :class="['incumbent', { 'ctb-tooltip': !verboseMode }]">{{ $dist->ALIAS }}</div>
				                    
				                </a>
				            </li>
        				@endforeach
			         </ul>
			    </div>
			    <div class="row" v-if="verboseMode">
				@foreach ($districts->find('AD') as $dist)
				   <div class="col-lg-2 col-md-3 col-sm-4">
					<a href="/book/old/{{$dist->DIST}}" class="text-decoration-none">
					   <div class="card">
						<div class="card-head {{ $dist->PARTY == 'D' ? 'bg-primary' : ($dist->PARTY == 'R' ? 'bg-danger' : '') }}">
						   {{ $dist->DIST }}
						</div>
						<div class="card-body">
						   <h4>{{ $dist->LEGISLATOR }}</h4>
					   	</div>
					   </div>
					  </a>
				    </div>
				@endforeach
			   </div>

			</div>

			<!--SDs (2012-2021) -->

			<div class="tab-pane fade" id="pills-sd-10">

			    <div class="district-card" v-if="!verboseMode">
    				<ul class="numbered-nav">
				        @foreach ($districts->find('SD') as $dist)
				            <li class="ctb-tooltip-container">
				                <a class="{{ $districts->getParty($dist->PARTY) }}"
						    href="/book/old/{{$dist->DIST}}">
				                    <span>
				                        {{ $districts->parseNumber($dist->DIST) }}
				                    </span>
						    <div :class="['incumbent', { 'ctb-tooltip': !verboseMode }]">{{ $dist->ALIAS }}</div>
				                    
				                </a>
				            </li>
        				@endforeach
			         </ul>
			    </div>
			    <div class="row" v-if="verboseMode">
				@foreach ($districts->find('SD') as $dist)
				   <div class="col-lg-2 col-md-3 col-sm-4">
					<a href="/book/old/{{$dist->DIST}}" class="text-decoration-none">
					   <div class="card">
						<div class="card-head {{ $dist->PARTY == 'D' ? 'bg-primary' : ($dist->PARTY == 'R' ? 'bg-danger' : '') }}">
						   {{ $dist->DIST }}
						</div>
						<div class="card-body">
						   <h4>{{ $dist->LEGISLATOR }}</h4>
					   	</div>
					   </div>
					  </a>
				    </div>
				@endforeach
			   </div>


			</div>

			<!--CDs (2012-2021) -->


			<div class="tab-pane fade" id="pills-cd-10">

			    <div class="district-card" v-if="!verboseMode">
    				<ul class="numbered-nav">
				        @foreach ($districts->find('CD') as $dist)
				            <li class="ctb-tooltip-container">
				                <a class="{{ $districts->getParty($dist->PARTY) }}"
						    href="/book/old/{{$dist->DIST}}">
				                    <span>
				                        {{ $districts->parseNumber($dist->DIST) }}
				                    </span>
						    <div :class="['incumbent', { 'ctb-tooltip': !verboseMode }]">{{ $dist->ALIAS }}</div>
				                    
				                </a>
				            </li>
        				@endforeach
			         </ul>
			    </div>
			    <div class="row" v-if="verboseMode">
				@foreach ($districts->find('CD') as $dist)
				   <div class="col-lg-2 col-md-3 col-sm-4">
					<a href="/book/old/{{$dist->DIST}}" class="text-decoration-none">
					   <div class="card">
						<div class="card-head {{ $dist->PARTY == 'D' ? 'bg-primary' : ($dist->PARTY == 'R' ? 'bg-danger' : '') }}">
						   {{ $dist->DIST }}
						</div>
						<div class="card-body">
						   <h4>{{ $dist->LEGISLATOR }}</h4>
					   	</div>
					   </div>
					  </a>
				    </div>
				@endforeach
			   </div>


			</div>


		</div> <!--END TAB CONTENT-->

	</div> <!--END DIRECTORY COLUMN-->

</div> <!--END ROW-->



<!--
<li><h6>DISTRICTS</h6></li>

<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
            @click="setSubMenu('AD2')">
        Assembly
        <div v-show="subMenus.district !== 'AD2'" class="material-icons pull-right">expand_more</div>
        <div v-show="subMenus.district === 'AD2'" class="material-icons pull-right">expand_less</div>
    </a>
    <ul v-show="subMenus.district === 'AD2'" class="dropdown-menu numbered-nav">
        @foreach ($districts->find2('AD') as $dist)
            <li class="ctb-tooltip-container">
                <a class="{{ $districts->getParty($dist->PARTY) }}"

		    href="/book/new/{{$dist->DIST}}">
                    <span>
                        {{ $districts->parseNumber($dist->DIST) }}
                    </span>

                    <div :class="['incumbent', { 'ctb-tooltip': !verboseMode }]">{{ $dist->ALIAS }}</div>

                </a>
            </li>
        @endforeach
    </ul>
</li>

<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
            @click="setSubMenu('SD2')">
        State Senate
        <div v-show="subMenus.district !== 'SD2'" class="material-icons pull-right">expand_more</div>
        <div v-show="subMenus.district === 'SD2'" class="material-icons pull-right">expand_less</div>
    </a>
    <ul v-show="subMenus.district === 'SD2'" class="dropdown-menu numbered-nav">
        @foreach ($districts->find2('SD') as $dist)
            <li class="ctb-tooltip-container">
                <a class="{{ $districts->getParty($dist->PARTY) }}"
		  href="/book/new/{{$dist->DIST}}">
                    <span>
                        {{ $districts->parseNumber($dist->DIST) }}
                    </span>

		    <div :class="['incumbent', { 'ctb-tooltip': !verboseMode }]">{{ $dist->ALIAS }}</div>

                    
                </a>
            </li>
        @endforeach
    </ul>
</li>

<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
            @click="setSubMenu('CD2')">
        Congress
        <div v-show="subMenus.district !== 'CD2'" class="material-icons pull-right">expand_more</div>
        <div v-show="subMenus.district === 'CD2'" class="material-icons pull-right">expand_less</div>
    </a>
    <ul v-show="subMenus.district === 'CD2'" class="dropdown-menu numbered-nav">
        @foreach ($districts->find2('CD') as $dist)
            <li class="ctb-tooltip-container">
                <a class="{{ $districts->getParty($dist->PARTY) }}"
		href="/book/new/{{$dist->DIST}}">
                    <span>
                        {{ $districts->parseNumber($dist->DIST) }}
                    </span>

                    <div :class="['incumbent', { 'ctb-tooltip': !verboseMode }]">{{ $dist->ALIAS }}</div>

                </a>
            </li>
        @endforeach
    </ul>
</li>

<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
            @click="setSubMenu('BOE')">
        Board Of Equalization
        <div v-show="subMenus.district !== 'BOE'" class="material-icons pull-right">expand_more</div>
        <div v-show="subMenus.district === 'BOE'" class="material-icons pull-right">expand_less</div>
    </a>
    <ul v-show="subMenus.district === 'BOE'" class="dropdown-menu">
        @foreach ($districts->find('BOE') as $dist)
            <li>
                <a href="{{ route('book.district', [ 'id' => $dist->DIST]) }}">
                    {{ $dist->DIST }}
                    <small class="pull-right {{ $districts->getParty($dist->PARTY) }}">
                        {{ $dist->LEGISLATOR }}
                    </small>
                </a>
            </li>
        @endforeach
    </ul>
</li>

<li><h6>STATEWIDE</h6></li>

<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
            @click="setSubMenu('CO')">
        Constitutional Offices
        <div v-show="subMenus.district !== 'CO'" class="material-icons pull-right">expand_more</div>
        <div v-show="subMenus.district === 'CO'" class="material-icons pull-right">expand_less</div>
    </a>
    <ul v-show="subMenus.district === 'CO'" class="dropdown-menu">
        <li><a href='/book/new/.GOV'>Governor </a></li>
        <li><a href='/book/new/.LTG'>Lt. Governor </a></li>
        <li><a href='/book/new/.ATG'>Attorney General </a></li>
        <li><a href='/book/new/.SOS'>Secretary of State </a></li>
        <li><a href='/book/new/.TRS'>Treasurer </a></li>
        <li><a href='/book/new/.CON'>Controller </a></li>
        <li><a href='/book/new/.INS'>Insurance Commissioner </a></li>
        <li><a href='/book/new/.SPI'>Superintendent of Public Instruction </a></li>
    </ul>
</li>
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
            @click="setSubMenu('SN')">
        U.S. Senate (CA)
        <div v-show="subMenus.district !== 'SN'" class="material-icons pull-right">expand_more</div>
        <div v-show="subMenus.district === 'SN'" class="material-icons pull-right">expand_less</div>
    </a>
    <ul v-show="subMenus.district === 'SN'" class="dropdown-menu">
        <li><a href='/book/new/.SN1'>U.S. Senate 1</a></li>
        <li><a href='/book/new/.SN2'>U.S. Senate 2</a></li>
    </ul>
</li>


<li><h6>US FEDERAL</h6></li>

<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
            @click="setSubMenu('FED')">
        U.S. House of Reps.
        <div v-show="subMenus.district !== 'FED'" class="material-icons pull-right">expand_more</div>
        <div v-show="subMenus.district === 'FED'" class="material-icons pull-right">expand_less</div>
    </a>
    <ul v-show="subMenus.district === 'FED'" class="dropdown-menu">
        @foreach ($districts->getFed() as $state => $fedDistricts)
            <li class="dropdown force-dropdown-hide">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    {{ $ctbUtil->formatState($state) }}
                    <div class="caret pull-right mt-sm"></div>
                </a>
                <ul class="dropdown-menu numbered-nav">
                    @foreach ($fedDistricts as $dist)
                        <li class="ctb-tooltip-container">
                            <a class="{{ $districts->getParty($dist->PARTY) }}"
                                    href="{{ route('book.fed', [ 'id' => $dist->DIST]) }}">
                                <span>
                                    {{ $districts->parseNumber($dist->DIST) }}
                                </span>

                                <div :class="['incumbent', { 'ctb-tooltip': !verboseMode }]">{{ $dist->NAML }}</div>
                            </a>
                        </li>
                    @endforeach
                </ul>

            </li>
        @endforeach
    </ul>
</li>


<li><h6>LOCAL</h6></li>

<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
            @click="setSubMenu('CT')">
        Counties
        <div v-show="subMenus.district !== 'CT'" class="material-icons pull-right">expand_more</div>
        <div v-show="subMenus.district === 'CT'" class="material-icons pull-right">expand_less</div>
    </a>
    <ul v-show="subMenus.district === 'CT'" class="dropdown-menu">
        @foreach ($ctbUtil->getCounties() as $county)
            <li>
                <a href="{{ route('book.county', [ 'id' => $county ]) }}">
                    {{ ucwords(strtolower($county))  }}
                </a>
            </li>
        @endforeach
    </ul>
</li>



<li><h6>LEGACY DISTRICTS (2012-2021)</h6></li>

<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
            @click="setSubMenu('AD')">
        Assembly
        <div v-show="subMenus.district !== 'AD'" class="material-icons pull-right">expand_more</div>
        <div v-show="subMenus.district === 'AD'" class="material-icons pull-right">expand_less</div>
    </a>
    <ul v-show="subMenus.district === 'AD'" class="dropdown-menu numbered-nav">
        @foreach ($districts->find('AD') as $dist)
            <li class="ctb-tooltip-container">
                <a class="{{ $districts->getParty($dist->PARTY) }}"
                        href="{{ route('book.district', [ 'id' => $dist->DIST]) }}">
                    <span>
                        {{ $districts->parseNumber($dist->DIST) }}
                    </span>

                    <div :class="['incumbent', { 'ctb-tooltip': !verboseMode }]">{{ $dist->ALIAS }}</div>
                </a>
            </li>
        @endforeach
    </ul>
</li>



<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
            @click="setSubMenu('SD')">
        State Senate
        <div v-show="subMenus.district !== 'SD'" class="material-icons pull-right">expand_more</div>
        <div v-show="subMenus.district === 'SD'" class="material-icons pull-right">expand_less</div>
    </a>
    <ul v-show="subMenus.district === 'SD'" class="dropdown-menu numbered-nav">
        @foreach ($districts->find('SD') as $dist)
            <li class="ctb-tooltip-container">
                <a class="{{ $districts->getParty($dist->PARTY) }}"
                        href="{{ route('book.district', [ 'id' => $dist->DIST]) }}">
                    <span>
                        {{ $districts->parseNumber($dist->DIST) }}
                    </span>

                    <div :class="['incumbent', { 'ctb-tooltip': !verboseMode }]">{{ $dist->ALIAS }}</div>
                </a>
            </li>
        @endforeach
    </ul>
</li>

<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
            @click="setSubMenu('CD')">
        Congress
        <div v-show="subMenus.district !== 'CD'" class="material-icons pull-right">expand_more</div>
        <div v-show="subMenus.district === 'CD'" class="material-icons pull-right">expand_less</div>
    </a>
    <ul v-show="subMenus.district === 'CD'" class="dropdown-menu numbered-nav">
        @foreach ($districts->find('CD') as $dist)
            <li class="ctb-tooltip-container">
                <a class="{{ $districts->getParty($dist->PARTY) }}"
                        href="{{ route('book.district', [ 'id' => $dist->DIST]) }}">
                    <span>
                        {{ $districts->parseNumber($dist->DIST) }}
                    </span>

                    <div :class="['incumbent', { 'ctb-tooltip': !verboseMode }]">{{ $dist->ALIAS }}</div>
                </a>
            </li>
        @endforeach
    </ul>
</li>

-->


