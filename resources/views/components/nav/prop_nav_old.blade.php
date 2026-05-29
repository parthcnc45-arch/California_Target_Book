
@inject('propositions', 'App\Services\CTB\Propositions')

@foreach ($propositions->getAllProps() as $year => $props)
<li>
    <a class="dropdown-item" href="#">
        {{$year}} &raquo;
    </a>
    <ul
    class="dropdown-menu dropdown-submenu">
        @foreach ($props as $prop)

            <li>
                <a href="{{ $propositions->getLinkFor($prop) }}">
                    <span class="dropdown-item px-0 <?php
					if($year > 2019) {
						if(isset($prop->prop_status)) {
							echo("pclass" . @$prop->prop_status);
						}
					}


				  ?>">{{ @$propositions->getName($prop) }}</span>

                    <?php
                        if($year > 2019) {

                            switch(@$prop->prop_status) {
                            case "0":
                                $draw = "<small class='boldme'>Withdrawn/Failed to Qualify</small>";
                                break;
                            case "1":
                                $draw = "<small class='boldme'>Cleared for Circulation</small>";
                                break;
                            case "2":
                                $draw = "<small class='boldme'>Submitted to AG</small>";
                                break;
                            case "25":
                                $draw = "<small class='boldme'>25% Signatures Reached</small>";
                                break;
                            case "50":
                                $draw = "<small class='boldme redme'>Undergoing Signature Verification</small>";
                                break;
                            case "96":
                                $draw = "<small class='boldme blueme'>Cleared for Primary Election Ballot</small>";
                                break;
                            case "100":
                                $draw = "<small class='boldme blueme'>Cleared for General Election Ballot</small>";
                                break;
                            default:
                                $draw = '';
                                break;
                            }
                            echo($draw);
                        }

                    ?>
                    <small class="text-capitalize text-wrap">{{ strtolower(@$prop->prop_dscr)  }}</small>
                </a>
            </li>
        @endforeach
    </ul>
</li>
@endforeach


