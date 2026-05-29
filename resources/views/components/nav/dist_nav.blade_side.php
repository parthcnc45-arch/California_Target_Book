@inject('ctbUtil', 'App\Services\CTB\Util')
@inject('districts', 'App\Services\CTB\Districts')

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


