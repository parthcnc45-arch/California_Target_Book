
@inject('propositions', 'App\Services\CTB\Propositions')
<?php
  $allProps=$propositions->getAllProps();
?>

    <div class="row">
        <div class="ctb-directory-column">
            <ul class="nav nav-pills mb-3 general-pill-tab" id="pills-tab" >
                <li class="nav-item active">
                    <a class="nav-link" data-toggle="pill" href="#pills-clear-for-ballot">Cleared For Ballot</a>
                </li>
                @foreach ($allProps as $year => $props)
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#pills-{{ $year }}">{{ $year }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="ctb-directory-column">
            <div class="tab-content" id="pills-tabContent">

                @foreach ($allProps as $year => $props)
                    @if( $year===2024)
                        <div class="tab-pane fade active in" id="pills-clear-for-ballot">
		          <div class="row">
                            @foreach ($props as $prop)
                                @if($year > 2019 && isset($prop->prop_status) && $prop->prop_status==100)
				  <div class="col-xl-2 col-lg-3 col-sm-12">
				   <div class="panel">
				    <div class="badge bg-dark text-white text-wrap font-weight-bold">
                                    <a href="{{ $propositions->getLinkFor($prop) }}" class="text-decoration-none">
                                        <span class="px-0 font-weight-bold text-white">{{ $propositions->getName($prop) }}</span>
				     </div>
                                        <br><b><small class='font-weight-bold text-success'>Cleared for General Election Ballot</small></b><br>
                                        <h4 class="text-capitalize text-dark text-wrap">{{ strtolower($prop->prop_dscr)  }}</h4>

                                    </a>
				    </div>
			          </div>
                                @endif
                            @endforeach
                        </div>
		       </div>
                    @endif
                    <div class="tab-pane fade" id="pills-{{ $year }}">
		     <div class="row">
                        @foreach ($props as $prop)
			  <div class="col-xl-2 col-lg-3 col-sm-12">
			   <div class="panel">
			    <div class="badge bg-dark text-white text-wrap font-weight-bold">

                            <a href="{{ $propositions->getLinkFor($prop) }}" class="text-decoration-none">
                                <span class="px-0 text-white 
				<?php
                                if($year > 2021) {
                                    if(isset($prop->prop_status)) {
					switch($prop->prop_status) {
					    case "100":
						$class = "text-success";
						break;
					    case "96":
						$class= "text-primary";
						break;
					    case "50":
						$class="text-danger";
						break;
					    case "25":
						$class="text-warning";
						break;
					    case "2":
						$class="text-muted";
						break;
					    case "1":
						$class="text-info";
						break;
					    case "0":
						$class="";
						break;
					}
                                        //echo($class);
                                    }
                                }


                              ?>">{{ @$propositions->getName($prop) }}</span>
			      </div>
				<?php
					$result_span = '';
					if(isset($prop->yes)) {
					   $yes = $prop->yes;
					   $no = $prop->no;
					   $tot = $yes + $no;

					   if($prop->yes > $prop->no) {
						$result_span = "<span class='text-success'>PASSED (" . number_format((($yes / $tot) * 100), 2) . "%)";
					   } elseif($no > $yes) {
						$result_span = "<span class='text-danger'>FAILED (" . number_format((($no / $tot) * 100), 2) . "%)";
					   }
					}
					echo("&nbsp;&nbsp;$result_span");
				?>


				<br>

                                <?php
                                    if($year > 2021) {

                                        switch(@$prop->prop_status) {
                                        case "0":
                                            $draw = "<small class='$class'>Withdrawn/Failed to Qualify</small>";
                                            break;
                                        case "1":
                                            $draw = "<small class='$class'>Cleared for Circulation</small>";
                                            break;
                                        case "2":
                                            $draw = "<small class='$class'>Submitted to AG</small>";
                                            break;
                                        case "25":
                                            $draw = "<small class='$class'>25% Signatures Reached</small>";
                                            break;
                                        case "50":
                                            $draw = "<small class='$class'>Undergoing Signature Verification</small>";
                                            break;
                                        case "96":
                                            $draw = "<small class='$class'>Cleared for Primary Election Ballot</small>";
                                            break;
                                        case "100":
                                             $draw = "<small class='$class'>Cleared for General Election Ballot</small>";
                                             break;
                                        default:
                                            $draw = '';
                                            break;
                                        }
                                        echo($draw);
                                    }

                                ?>


                                <br><h4 class="text-dark text-capitalize text-wrap">{{ strtolower(@$prop->prop_dscr)  }}</small></h4>
                            </a>
			   </div>
			  </div>
                        @endforeach
                    </div>
		   </div>
                @endforeach

            </div>
        </div>
    </div>


