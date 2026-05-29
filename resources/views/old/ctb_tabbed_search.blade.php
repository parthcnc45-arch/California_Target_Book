<?php

global $endjava;
$endjava = Array();
Util::require_ctb_api();
use App\User;
$role = Auth::user()->role;

ini_set('memory_limit', '4048M');
set_time_limit(0);

?>

@php ($book_side_nav_active = 'search')

@extends('layouts.book')

@section('title', 'FEC / FPPC Multi-Search | California Target Book')

@section('content')

  <div class="container">
    <ul class="nav nav-tabs" id="mainTabs">
      <li class="nav-item" id="fec-li">
        <a class="nav-link active" data-toggle="tab" href="#fec" value='fec'><img src='/img/fec_logo.png'  width='150px' class='fec-logo' />  FEC</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#fppc" value='fppc'><img src='/img/fppc_logo.png'  width='150px' class='fec-logo' />  FPPC</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#netfile" value='netfile'><img src='/img/netfile_logo.png'  width='150px' class='fec-logo' />  NETFILE</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#other" value='other'><img src='/img/ctb1993.png'  width='150px' class='fec-logo' />  OTHER</a>
      </li>
    </ul>

    <!--
                                                              
                                                              
FFFFFFFFFFFFFFFFFFFFFEEEEEEEEEEEEEEEEEEEEEE      CCCCCCCCCCCCC
F::::::::::::::::::::E::::::::::::::::::::E   CCC::::::::::::C
F::::::::::::::::::::E::::::::::::::::::::E CC:::::::::::::::C
FF::::::FFFFFFFFF::::EE::::::EEEEEEEEE::::EC:::::CCCCCCCC::::C
  F:::::F       FFFFFF E:::::E       EEEEEC:::::C       CCCCCC
  F:::::F              E:::::E           C:::::C              
  F::::::FFFFFFFFFF    E::::::EEEEEEEEEE C:::::C              
  F:::::::::::::::F    E:::::::::::::::E C:::::C              
  F:::::::::::::::F    E:::::::::::::::E C:::::C              
  F::::::FFFFFFFFFF    E::::::EEEEEEEEEE C:::::C              
  F:::::F              E:::::E           C:::::C              
  F:::::F              E:::::E       EEEEEC:::::C       CCCCCC 
FF:::::::FF          EE::::::EEEEEEEE:::::EC:::::CCCCCCCC::::C
F::::::::FF          E::::::::::::::::::::E CC:::::::::::::::C
F::::::::FF          E::::::::::::::::::::E   CCC::::::::::::C
FFFFFFFFFFF          EEEEEEEEEEEEEEEEEEEEEE      CCCCCCCCCCCCC
                                                              
                                                              
                                                              
             
    -->

    <div class="tab-content">
      <div id="fec" class="tab-pane fade active">
        <ul class="nav nav-tabs" id="fecTabs">
          <li class="nav-item" id="fec-contributor-li">
            <a class="nav-link active" data-toggle="tab" href="#fec-contributor" value='contributor'>CONTRIBUTOR</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#fec-vendor" value='vendor'>VENDOR</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#fec-treasurer" value='treasurer'>TREASURER</a>
          </li>
          <!--
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#fec-employer" value='employer'>BY EMPLOYER</a>
          </li>
          -->
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#fec-candidate" value='candidate'>LOOKUP CANDIDATE</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#fec-committee" value='committee'>LOOKUP COMMITTEE</a>
          </li>
        </ul>

<!--

                                                                bbbbbbbb            
                            tttt                            iiiib::::::b            
                         ttt:::t                           i::::b::::::b            
                         t:::::t                            iiiib::::::b            
                         t:::::t                                 b:::::b            
    cccccccccccccccttttttt:::::ttttttt  rrrrr   rrrrrrrrr iiiiiiib:::::bbbbbbbbb    
  cc:::::::::::::::t:::::::::::::::::t  r::::rrr:::::::::ri:::::ib::::::::::::::bb  
 c:::::::::::::::::t:::::::::::::::::t  r:::::::::::::::::ri::::ib::::::::::::::::b 
c:::::::cccccc:::::tttttt:::::::tttttt  rr::::::rrrrr::::::i::::ib:::::bbbbb:::::::b
c::::::c     ccccccc     t:::::t         r:::::r     r:::::i::::ib:::::b    b::::::b
c:::::c                  t:::::t         r:::::r     rrrrrri::::ib:::::b     b:::::b
c:::::c                  t:::::t         r:::::r           i::::ib:::::b     b:::::b
c::::::c     ccccccc     t:::::t    tttttr:::::r           i::::ib:::::b     b:::::b
c:::::::cccccc:::::c     t::::::tttt:::::r:::::r          i::::::b:::::bbbbbb::::::b
 c:::::::::::::::::c     tt::::::::::::::r:::::r          i::::::b::::::::::::::::b 
  cc:::::::::::::::c       tt:::::::::::tr:::::r          i::::::b:::::::::::::::b  
    cccccccccccccccc         ttttttttttt rrrrrrr          iiiiiiibbbbbbbbbbbbbbbb   
                                                                                    
      

-->

        <div class="tab-content">
          <div id="fec-contributor" class="tab-pane fade subtab active" value='contributor'>
            <h4>FEC Contributor Search</h4>
            <!-- Add your content here -->
            <div class='row'>
              <div class='panel'>
                <form id="fec-contributor-form">
                  <input type="text" style='display: none;' class='form-control' id='scope' value='fec'>
                  <input type="text" style='display: none;' class='form-control' id='type' value='contributor'>            
                  <div class="form-group">
                    <label for="fec-contributor-name">Contributor Name</label>
                    <input type="text" class="form-control" id="fec-contributor-name" name="fec-contributor-name">
                  </div>
                  <div class="form-group">
                    <label for="fec-contributor-city">City (Optional)</label>
                    <input type="text" class="form-control" id="fec-contributor-city" name="fec-contributor-city">
                  </div>
                  <div class="form-group">
                    <label for="fec-contributor-state">State (Optional)</label>
                    <input type="text" class="form-control" id="fec-contributor-state" name="fec-contributor-state">
                  </div>
                  <div class="form-group">
                    <label for="fec-contributor-zip">Zip (Optional)</label>
                    <input type="text" class="form-control" id="fec-contributor-zip" name="fec-contributor-zip">
                  </div>

                  <button type="submit" class="btn btn-primary" onClick="formHandler()">View Detail Report</button>
                </form>
              </div>
            </div>
          </div>

<!--
                                                                                                                
                                                                     dddddddd                                   
                                                                     d::::::d                                   
                                                                     d::::::d                                   
                                                                     d::::::d                                   
                                                                     d:::::d                                    
vvvvvvv           vvvvvvveeeeeeeeeeee   nnnn  nnnnnnnn       ddddddddd:::::d   ooooooooooo  rrrrr   rrrrrrrrr   
 v:::::v         v:::::ee::::::::::::ee n:::nn::::::::nn   dd::::::::::::::d oo:::::::::::oor::::rrr:::::::::r  
  v:::::v       v:::::e::::::eeeee:::::en::::::::::::::nn d::::::::::::::::do:::::::::::::::r:::::::::::::::::r 
   v:::::v     v:::::e::::::e     e:::::nn:::::::::::::::d:::::::ddddd:::::do:::::ooooo:::::rr::::::rrrrr::::::r
    v:::::v   v:::::ve:::::::eeeee::::::e n:::::nnnn:::::d::::::d    d:::::do::::o     o::::or:::::r     r:::::r
     v:::::v v:::::v e:::::::::::::::::e  n::::n    n::::d:::::d     d:::::do::::o     o::::or:::::r     rrrrrrr
      v:::::v:::::v  e::::::eeeeeeeeeee   n::::n    n::::d:::::d     d:::::do::::o     o::::or:::::r            
       v:::::::::v   e:::::::e            n::::n    n::::d:::::d     d:::::do::::o     o::::or:::::r            
        v:::::::v    e::::::::e           n::::n    n::::d::::::ddddd::::::do:::::ooooo:::::or:::::r            
         v:::::v      e::::::::eeeeeeee   n::::n    n::::nd:::::::::::::::::o:::::::::::::::or:::::r            
          v:::v        ee:::::::::::::e   n::::n    n::::n d:::::::::ddd::::doo:::::::::::oo r:::::r            
           vvv           eeeeeeeeeeeeee   nnnnnn    nnnnnn  ddddddddd   ddddd  ooooooooooo   rrrrrrr            
       
-->


          <div id="fec-vendor" class="tab-pane fade">
            <h4>FEC Vendor Search</h4>
            <div class='row'>
              <div class='panel'>
                <form id="fec-vendor-form">
                  <input type="text" style='display: none;' class='form-control' id='scope' value='fec'>
                  <input type="text" style='display: none;' class='form-control' id='type' value='vendor'>            
                  <div class="form-group">
                    <label for="fec-vendor-name">Vendor Name</label>
                    <input type="text" class="form-control" id="fec-vendor-name" name="fec-vendor-name">
                  </div>
                  <div class="form-group">
                    <label for="fec-vendor-city">City (Optional)</label>
                    <input type="text" class="form-control" id="fec-vendor-city" name="fec-vendor-city">
                  </div>
                  <div class="form-group">
                    <label for="fec-vendor-state">State (Optional)</label>
                    <input type="text" class="form-control" id="fec-vendor-state" name="fec-vendor-state">
                  </div>
                  <div class="form-group">
                    <label for="fec-vendor-zip">Zip (Optional)</label>
                    <input type="text" class="form-control" id="fec-vendor-zip" name="fec-vendor-zip">
                  </div>

                  <button type="submit" class="btn btn-primary" onClick="formHandler()">View Detail Report</button>
                </form>
              </div>
            </div>            
          </div>

<!--

                                                                                                                                                                   
         tttt                                                                                                                                                      
      ttt:::t                                                                                                                                                      
      t:::::t                                                                                                                                                      
      t:::::t                                                                                                                                                      
ttttttt:::::ttttttt  rrrrr   rrrrrrrrr      eeeeeeeeeeee   aaaaaaaaaaaaa     ssssssssss  uuuuuu    uuuuuurrrrr   rrrrrrrrr      eeeeeeeeeeee   rrrrr   rrrrrrrrr   
t:::::::::::::::::t  r::::rrr:::::::::r   ee::::::::::::ee a::::::::::::a  ss::::::::::s u::::u    u::::ur::::rrr:::::::::r   ee::::::::::::ee r::::rrr:::::::::r  
t:::::::::::::::::t  r:::::::::::::::::r e::::::eeeee:::::eaaaaaaaaa:::::ss:::::::::::::su::::u    u::::ur:::::::::::::::::r e::::::eeeee:::::er:::::::::::::::::r 
tttttt:::::::tttttt  rr::::::rrrrr::::::e::::::e     e:::::e        a::::s::::::ssss:::::u::::u    u::::urr::::::rrrrr::::::e::::::e     e:::::rr::::::rrrrr::::::r
      t:::::t         r:::::r     r:::::e:::::::eeeee::::::e aaaaaaa:::::as:::::s  ssssssu::::u    u::::u r:::::r     r:::::e:::::::eeeee::::::er:::::r     r:::::r
      t:::::t         r:::::r     rrrrrre:::::::::::::::::eaa::::::::::::a  s::::::s     u::::u    u::::u r:::::r     rrrrrre:::::::::::::::::e r:::::r     rrrrrrr
      t:::::t         r:::::r           e::::::eeeeeeeeeeea::::aaaa::::::a     s::::::s  u::::u    u::::u r:::::r           e::::::eeeeeeeeeee  r:::::r            
      t:::::t    tttttr:::::r           e:::::::e        a::::a    a:::::ssssss   s:::::su:::::uuuu:::::u r:::::r           e:::::::e           r:::::r            
      t::::::tttt:::::r:::::r           e::::::::e       a::::a    a:::::s:::::ssss::::::u:::::::::::::::ur:::::r           e::::::::e          r:::::r            
      tt::::::::::::::r:::::r            e::::::::eeeeeeea:::::aaaa::::::s::::::::::::::s u:::::::::::::::r:::::r            e::::::::eeeeeeee  r:::::r            
        tt:::::::::::tr:::::r             ee:::::::::::::ea::::::::::aa:::s:::::::::::ss   uu::::::::uu:::r:::::r             ee:::::::::::::e  r:::::r            
          ttttttttttt rrrrrrr               eeeeeeeeeeeeee aaaaaaaaaa  aaaasssssssssss       uuuuuuuu  uuurrrrrrr               eeeeeeeeeeeeee  rrrrrrr            
                                                                                                                                                                   
                                                                                                                                                                   
                                                                                                                                                                   
                                                                                                                                                                   
     

-->          
          <div id="fec-treasurer" class="tab-pane fade">
            <h4>FEC Treasurer/Agent/Custodian of Records Lookup</h4>
            <div class='row'>
              <div class='panel'>
                <form id="fec-treasurer-form">
                  <input type="text" style='display: none;' class='form-control' id='scope' value='fec'>
                  <input type="text" style='display: none;' class='form-control' id='type' value='treasurer'>            
                  <div class="form-group">
                    <label for="fec-treasurer-namf">First Name</label>
                    <input type="text" class="form-control" id="fec-treasurer-namf" name="fec-treasurer-namf">
                  </div>
                  <div class="form-group">
                    <label for="fec-treasurer-naml">Last Name</label>
                    <input type="text" class="form-control" id="fec-treasurer-naml" name="fec-treasurer-naml">
                  </div>
                  <!--<button type="submit" class="btn btn-primary" onClick="formHandler()">Submit</button>-->
                </form>
              </div>
            </div>   
          </div>

<!--

                                                             lllllll                                                                          
                                                             l:::::l                                                                          
                                                             l:::::l                                                                          
                                                             l:::::l                                                                          
    eeeeeeeeeeee      mmmmmmm    mmmmmmm  ppppp   ppppppppp   l::::l   oooooooooooyyyyyyy           yyyyyyyeeeeeeeeeeee   rrrrr   rrrrrrrrr   
  ee::::::::::::ee  mm:::::::m  m:::::::mmp::::ppp:::::::::p  l::::l oo:::::::::::oy:::::y         y:::::ee::::::::::::ee r::::rrr:::::::::r  
 e::::::eeeee:::::em::::::::::mm::::::::::p:::::::::::::::::p l::::lo:::::::::::::::y:::::y       y:::::e::::::eeeee:::::er:::::::::::::::::r 
e::::::e     e:::::m::::::::::::::::::::::pp::::::ppppp::::::pl::::lo:::::ooooo:::::oy:::::y     y:::::e::::::e     e:::::rr::::::rrrrr::::::r
e:::::::eeeee::::::m:::::mmm::::::mmm:::::mp:::::p     p:::::pl::::lo::::o     o::::o y:::::y   y:::::ye:::::::eeeee::::::er:::::r     r:::::r
e:::::::::::::::::em::::m   m::::m   m::::mp:::::p     p:::::pl::::lo::::o     o::::o  y:::::y y:::::y e:::::::::::::::::e r:::::r     rrrrrrr
e::::::eeeeeeeeeee m::::m   m::::m   m::::mp:::::p     p:::::pl::::lo::::o     o::::o   y:::::y:::::y  e::::::eeeeeeeeeee  r:::::r            
e:::::::e          m::::m   m::::m   m::::mp:::::p    p::::::pl::::lo::::o     o::::o    y:::::::::y   e:::::::e           r:::::r            
e::::::::e         m::::m   m::::m   m::::mp:::::ppppp:::::::l::::::o:::::ooooo:::::o     y:::::::y    e::::::::e          r:::::r            
 e::::::::eeeeeeee m::::m   m::::m   m::::mp::::::::::::::::pl::::::o:::::::::::::::o      y:::::y      e::::::::eeeeeeee  r:::::r            
  ee:::::::::::::e m::::m   m::::m   m::::mp::::::::::::::pp l::::::loo:::::::::::oo      y:::::y        ee:::::::::::::e  r:::::r            
    eeeeeeeeeeeeee mmmmmm   mmmmmm   mmmmmmp::::::pppppppp   llllllll  ooooooooooo       y:::::y           eeeeeeeeeeeeee  rrrrrrr            
                                           p:::::p                                      y:::::y                                               
                                           p:::::p                                     y:::::y                                                
                                          p:::::::p                                   y:::::y                                                 
                                          p:::::::p                                  y:::::y                                                  
                                          p:::::::p                                 yyyyyyy                                                   
                                          ppppppppp                                       

-->          
          <div id="fec-employer" class="tab-pane fade">
            <h4>Search FEC Contributions by Employer</h4>
            <!-- Add your content here -->
          </div>

<!--

                                                                        
                                                                dddddddd
                                                                d::::::d
                                                                d::::::d
                                                                d::::::d
                                                                d:::::d 
    cccccccccccccccc aaaaaaaaaaaaa nnnn  nnnnnnnn       ddddddddd:::::d 
  cc:::::::::::::::c a::::::::::::an:::nn::::::::nn   dd::::::::::::::d 
 c:::::::::::::::::c aaaaaaaaa:::::n::::::::::::::nn d::::::::::::::::d 
c:::::::cccccc:::::c          a::::nn:::::::::::::::d:::::::ddddd:::::d 
c::::::c     ccccccc   aaaaaaa:::::a n:::::nnnn:::::d::::::d    d:::::d 
c:::::c              aa::::::::::::a n::::n    n::::d:::::d     d:::::d 
c:::::c             a::::aaaa::::::a n::::n    n::::d:::::d     d:::::d 
c::::::c     cccccca::::a    a:::::a n::::n    n::::d:::::d     d:::::d 
c:::::::cccccc:::::a::::a    a:::::a n::::n    n::::d::::::ddddd::::::dd
 c:::::::::::::::::a:::::aaaa::::::a n::::n    n::::nd:::::::::::::::::d
  cc:::::::::::::::ca::::::::::aa:::an::::n    n::::n d:::::::::ddd::::d
    cccccccccccccccc aaaaaaaaaa  aaaannnnnn    nnnnnn  ddddddddd   ddddd
                                                                        
        

-->          
          <div id="fec-candidate" class="tab-pane fade">
            <h4>Search Federal Candidates</h4>
            <div class='row'>
              <div class='panel'>
                <form id="fec-candidate-form">
                  <input type="text" style='display: none;' class='form-control' id='scope' value='fec'>
                  <input type="text" style='display: none;' class='form-control' id='type' value='candidate'>            
                  <div class="form-group">
                    <label for="fec-candidate-name">Candidate Name</label>
                    <input type="text" class="form-control" id="fec-candidate-name" name="fec-candidate-name">
                  </div>
                  <!--<button type="submit" class="btn btn-primary" onClick="formHandler()">Submit</button>-->
                </form>
              </div>
            </div> 
          </div>

<!--

                                                   tttt                             
                                                ttt:::t                             
                                                t:::::t                             
                                                t:::::t                             
    cccccccccccccccc  mmmmmmm    mmmmmmm  ttttttt:::::ttttttt       eeeeeeeeeeee    
  cc:::::::::::::::cmm:::::::m  m:::::::mmt:::::::::::::::::t     ee::::::::::::ee  
 c:::::::::::::::::m::::::::::mm::::::::::t:::::::::::::::::t    e::::::eeeee:::::ee
c:::::::cccccc:::::m::::::::::::::::::::::tttttt:::::::tttttt   e::::::e     e:::::e
c::::::c     ccccccm:::::mmm::::::mmm:::::m     t:::::t         e:::::::eeeee::::::e
c:::::c            m::::m   m::::m   m::::m     t:::::t         e:::::::::::::::::e 
c:::::c            m::::m   m::::m   m::::m     t:::::t         e::::::eeeeeeeeeee  
c::::::c     ccccccm::::m   m::::m   m::::m     t:::::t    ttttte:::::::e           
c:::::::cccccc:::::m::::m   m::::m   m::::m     t::::::tttt:::::e::::::::e          
 c:::::::::::::::::m::::m   m::::m   m::::m     tt::::::::::::::te::::::::eeeeeeee  
  cc:::::::::::::::m::::m   m::::m   m::::m       tt:::::::::::tt ee:::::::::::::e  
    cccccccccccccccmmmmmm   mmmmmm   mmmmmm         ttttttttttt     eeeeeeeeeeeeee  
                                                                                    
              

-->          
          <div id="fec-committee" class="tab-pane fade">
            <h4>Search Federal Committees</h4>
            <div class='row'>
              <div class='panel'>
                <form id="fec-committee-form">
                  <input type="text" style='display: none;' class='form-control' id='scope' value='fec'>
                  <input type="text" style='display: none;' class='form-control' id='type' value='committee'>            
                  <div class="form-group">
                    <label for="fec-committee-name">Committee Name</label>
                    <input type="text" class="form-control" id="fec-committee-name" name="fec-committee-name">
                  </div>
                  <!--<button type="submit" class="btn btn-primary" onClick="formHandler()">Submit</button>-->
                </form>
              </div>
            </div> 
          </div>
        </div>
      </div>

<!--

                                                                                
FFFFFFFFFFFFFFFFFFFFFPPPPPPPPPPPPPPPPP  PPPPPPPPPPPPPPPPP          CCCCCCCCCCCCC
F::::::::::::::::::::P::::::::::::::::P P::::::::::::::::P      CCC::::::::::::C
F::::::::::::::::::::P::::::PPPPPP:::::PP::::::PPPPPP:::::P   CC:::::::::::::::C
FF::::::FFFFFFFFF::::PP:::::P     P:::::PP:::::P     P:::::P C:::::CCCCCCCC::::C
  F:::::F       FFFFFF P::::P     P:::::P P::::P     P:::::PC:::::C       CCCCCC
  F:::::F              P::::P     P:::::P P::::P     P:::::C:::::C              
  F::::::FFFFFFFFFF    P::::PPPPPP:::::P  P::::PPPPPP:::::PC:::::C              
  F:::::::::::::::F    P:::::::::::::PP   P:::::::::::::PP C:::::C              
  F:::::::::::::::F    P::::PPPPPPPPP     P::::PPPPPPPPP   C:::::C              
  F::::::FFFFFFFFFF    P::::P             P::::P           C:::::C              
  F:::::F              P::::P             P::::P           C:::::C              
  F:::::F              P::::P             P::::P            C:::::C       CCCCCC
FF:::::::FF          PP::::::PP         PP::::::PP           C:::::CCCCCCCC::::C
F::::::::FF          P::::::::P         P::::::::P            CC:::::::::::::::C
F::::::::FF          P::::::::P         P::::::::P              CCC::::::::::::C
FFFFFFFFFFF          PPPPPPPPPP         PPPPPPPPPP                 CCCCCCCCCCCCC
                                                                                
              

-->      
      <div id="fppc" class="tab-pane fade">
        <ul class="nav nav-tabs" id="fppcTabs">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#fppc-contributor">CONTRIBUTOR</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#fppc-vendor">VENDOR</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#fppc-committee">LOOKUP FILER</a>
          </li>
        </ul>

        <div class="tab-content">
          <div id="fppc-contributor" class="tab-pane fade active">
            <h4>FPPC Contributor Search</h4>
            <div class='row'>
              <div class='panel'>
                <form id="fppc-contributor-form">
                  <input type="text" style='display: none;' class='form-control' id='scope' value='fppc'>
                  <input type="text" style='display: none;' class='form-control' id='type' value='contributor'>            
                  <div class="form-group">
                    <label for="fppc-contributor-name">Contributor Name</label>
                    <input type="text" class="form-control" id="fppc-contributor-name" name="fppc-contributor-name">
                  </div>
                  <div class="form-group">
                    <label for="fppc-contributor-city">City (Optional)</label>
                    <input type="text" class="form-control" id="fppc-contributor-city" name="fppc-contributor-city">
                  </div>
                  <div class="form-group">
                    <label for="fppc-contributor-state">State (Optional)</label>
                    <input type="text" class="form-control" id="fppc-contributor-state" name="fppc-contributor-state">
                  </div>
                  <div class="form-group">
                    <label for="fppc-contributor-zip">Zip (Optional)</label>
                    <input type="text" class="form-control" id="fppc-contributor-zip" name="fppc-contributor-zip">
                  </div>

                  <button type="submit" class="btn btn-primary" onClick="formHandler()">View Detail Report</button>
                </form>
              </div>
            </div>
          </div>
          <div id="fppc-vendor" class="tab-pane fade">
            <h4>FPPC Vendor Search</h4>
            <!-- Add your content here -->
            <div class='row'>
              <div class='panel'>
                <form id="fppc-vendor-form">
                  <input type="text" style='display: none;' class='form-control' id='scope' value='fppc'>
                  <input type="text" style='display: none;' class='form-control' id='type' value='vendor'>            
                  <div class="form-group">
                    <label for="fppc-vendor-name">Vendor Name</label>
                    <input type="text" class="form-control" id="fppc-vendor-name" name="fppc-vendor-name">
                  </div>
                  <div class="form-group">
                    <label for="fppc-vendor-city">City (Optional)</label>
                    <input type="text" class="form-control" id="fppc-vendor-city" name="fppc-vendor-city">
                  </div>
                  <div class="form-group">
                    <label for="fppc-vendor-state">State (Optional)</label>
                    <input type="text" class="form-control" id="fppc-vendor-state" name="fppc-vendor-state">
                  </div>
                  <div class="form-group">
                    <label for="fppc-vendor-zip">Zip (Optional)</label>
                    <input type="text" class="form-control" id="fppc-vendor-zip" name="fppc-vendor-zip">
                  </div>

                  <button type="submit" class="btn btn-primary" onClick="formHandler()">View Detail Report</button>
                </form>
              </div>
            </div>
            <!-- End content -->
          </div>
          <div id="fppc-committee" class="tab-pane fade">
            <h4>FPPC Filer Search</h4>
            <!-- Add your content here -->

            <form id='fppc-committee-form'>
              <div class="row">
                <div class="col">
                  
                  <div class="form-group">
                    <div class="form-check checkbox-inline">
                      <input class="form-check-input" type="checkbox" id="fppc-committee-type_cand" checked>
                      <label class="form-check-label" for="fppc-committee-type_cand">
                        Candidate
                      </label>
                    </div>
                    <div class="form-check checkbox-inline">
                      <input class="form-check-input" type="checkbox" id="fppc-committee-type_cmte" checked>
                      <label class="form-check-label" for="fppc-committee-type_cmte">
                        Committee
                      </label>
                    </div>
                    <div class="form-check checkbox-inline">
                      <input class="form-check-input" type="checkbox" id="fppc-committee-type_donor">
                      <label class="form-check-label" for="fppc-committee-type_donor">
                        Major Donor
                      </label>
                    </div>
                    <div class="form-check checkbox-inline">
                      <input class="form-check-input" type="checkbox" id="fppc-committee-type_firm">
                      <label class="form-check-label" for="fppc-committee-type_firm">
                        Lobbying Firm
                      </label>
                    </div>
                    <div class="form-check checkbox-inline">
                      <input class="form-check-input" type="checkbox" id="fppc-committee-type_client">
                      <label class="form-check-label" for="fppc-committee-type_client">
                        Lobbying Client
                      </label>
                    </div>
                    <div class="form-check checkbox-inline">
                      <input class="form-check-input" type="checkbox" id="fppc-committee-type_emp">
                      <label class="form-check-label" for="fppc-committee-type_emp">
                        Lobbyist Employer
                      </label>
                    </div>
                    <div class="form-check checkbox-inline">
                      <input class="form-check-input" type="checkbox" id="fppc-committee-type_lobby">
                      <label class="form-check-label" for="fppc-committee-type_lobby">
                        Lobbyist
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="fppc-committee-name">Text Input:</label>
                    <input type="text" class="form-control" id="fppc-committee-name" name="fppc-committee-name">
                  </div>
                </div>
              </div>
            </form>
  

          </div> <!--END DIV -->
        </div>
      </div>
<!--

                                                                                                                                             
NNNNNNNN        NNNNNNNEEEEEEEEEEEEEEEEEEEEETTTTTTTTTTTTTTTTTTTTTTFFFFFFFFFFFFFFFFFFFFFIIIIIIIIILLLLLLLLLLL            EEEEEEEEEEEEEEEEEEEEEE
N:::::::N       N::::::E::::::::::::::::::::T:::::::::::::::::::::F::::::::::::::::::::I::::::::L:::::::::L            E::::::::::::::::::::E
N::::::::N      N::::::E::::::::::::::::::::T:::::::::::::::::::::F::::::::::::::::::::I::::::::L:::::::::L            E::::::::::::::::::::E
N:::::::::N     N::::::EE::::::EEEEEEEEE::::T:::::TT:::::::TT:::::FF::::::FFFFFFFFF::::II::::::ILL:::::::LL            EE::::::EEEEEEEEE::::E
N::::::::::N    N::::::N E:::::E       EEEEETTTTTT  T:::::T  TTTTTT F:::::F       FFFFFF I::::I   L:::::L                E:::::E       EEEEEE
N:::::::::::N   N::::::N E:::::E                    T:::::T         F:::::F              I::::I   L:::::L                E:::::E             
N:::::::N::::N  N::::::N E::::::EEEEEEEEEE          T:::::T         F::::::FFFFFFFFFF    I::::I   L:::::L                E::::::EEEEEEEEEE   
N::::::N N::::N N::::::N E:::::::::::::::E          T:::::T         F:::::::::::::::F    I::::I   L:::::L                E:::::::::::::::E   
N::::::N  N::::N:::::::N E:::::::::::::::E          T:::::T         F:::::::::::::::F    I::::I   L:::::L                E:::::::::::::::E   
N::::::N   N:::::::::::N E::::::EEEEEEEEEE          T:::::T         F::::::FFFFFFFFFF    I::::I   L:::::L                E::::::EEEEEEEEEE   
N::::::N    N::::::::::N E:::::E                    T:::::T         F:::::F              I::::I   L:::::L                E:::::E             
N::::::N     N:::::::::N E:::::E       EEEEEE       T:::::T         F:::::F              I::::I   L:::::L         LLLLLL E:::::E       EEEEEE
N::::::N      N::::::::EE::::::EEEEEEEE:::::E     TT:::::::TT     FF:::::::FF          II::::::ILL:::::::LLLLLLLLL:::::EE::::::EEEEEEEE:::::E
N::::::N       N:::::::E::::::::::::::::::::E     T:::::::::T     F::::::::FF          I::::::::L::::::::::::::::::::::E::::::::::::::::::::E
N::::::N        N::::::E::::::::::::::::::::E     T:::::::::T     F::::::::FF          I::::::::L::::::::::::::::::::::E::::::::::::::::::::E
NNNNNNNN         NNNNNNEEEEEEEEEEEEEEEEEEEEEE     TTTTTTTTTTT     FFFFFFFFFFF          IIIIIIIIILLLLLLLLLLLLLLLLLLLLLLLEEEEEEEEEEEEEEEEEEEEEE
                                                                                                                                             
                                                                                                                                             
                                                                                                                                             
 

-->
      <div id="netfile" class="tab-pane fade">
        <ul class="nav nav-tabs" id="netfileTabs">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#netfile-contributor">CONTRIBUTOR</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#netfile-vendor">VENDOR</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#netfile-committee">LOOKUP FILER</a>
          </li>
        </ul>

        <div class="tab-content">
          <div id="netfile-contributor" class="tab-pane fade active">
            <h4>Netfile Contributor Search</h4>
            <!-- Add your content here -->
            <div class='row'>
              <div class='panel'>
                <form id="netfile-contributor-form">
                  <input type="text" style='display: none;' class='form-control' id='scope' value='netfile'>
                  <input type="text" style='display: none;' class='form-control' id='type' value='contributor'>            
                  <div class="form-group">
                    <label for="netfile-contributor-name">Contributor Name</label>
                    <input type="text" class="form-control" id="netfile-contributor-name" name="netfile-contributor-name">
                  </div>
                  <div class="form-group">
                    <label for="netfile-contributor-city">City (Optional)</label>
                    <input type="text" class="form-control" id="netfile-contributor-city" name="netfile-contributor-city">
                  </div>
                  <div class="form-group">
                    <label for="netfile-contributor-state">State (Optional)</label>
                    <input type="text" class="form-control" id="netfile-contributor-state" name="netfile-contributor-state">
                  </div>
                  <div class="form-group">
                    <label for="netfile-contributor-zip">Zip (Optional)</label>
                    <input type="text" class="form-control" id="netfile-contributor-zip" name="netfile-contributor-zip">
                  </div>

                  <button type="submit" class="btn btn-primary" onClick="formHandler()">View Detail Report</button>
                </form>
              </div>
            </div>            
          </div>
          <div id="netfile-vendor" class="tab-pane fade">
            <h4>Netfile Vendor Search</h4>
            <!-- Add your content here -->

            <div class='row'>
              <div class='panel'>
                <form id="netfile-vendor-form">
                  <input type="text" style='display: none;' class='form-control' id='scope' value='netfile'>
                  <input type="text" style='display: none;' class='form-control' id='type' value='vendor'>            
                  <div class="form-group">
                    <label for="netfile-vendor-name">Vendor Name</label>
                    <input type="text" class="form-control" id="netfile-vendor-name" name="netfile-vendor-name">
                  </div>
                  <div class="form-group">
                    <label for="netfile-vendor-city">City (Optional)</label>
                    <input type="text" class="form-control" id="netfile-vendor-city" name="netfile-vendor-city">
                  </div>
                  <div class="form-group">
                    <label for="netfile-vendor-state">State (Optional)</label>
                    <input type="text" class="form-control" id="netfile-vendor-state" name="netfile-vendor-state">
                  </div>
                  <div class="form-group">
                    <label for="netfile-vendor-zip">Zip (Optional)</label>
                    <input type="text" class="form-control" id="netfile-vendor-zip" name="netfile-vendor-zip">
                  </div>

                  <button type="submit" class="btn btn-primary" onClick="formHandler()">View Detail Report</button>
                </form>
              </div>
            </div>

            <!-- End content -->
          </div>
          <div id="netfile-committee" class="tab-pane fade">
            <h4>Netfile Filer Search</h4>
            <!-- Add your content here -->

            <div class='row'>
              <div class='panel'>
                <form id="netfile-committee-form">
                  <input type="text" style='display: none;' class='form-control' id='scope' value='netfile'>
                  <input type="text" style='display: none;' class='form-control' id='type' value='committee'>  
                  <div class='row'>         
                    <div class="radio-inline">
                      <label><input type="radio" name="netfile-committee-juris" id='netfile-committee-radio_city' value="city">City</label>
                    </div>
                    <div class="radio-inline">
                      <label><input type="radio" name="netfile-committee-juris" id='netfile-committee-radio_county' value="county">County</label>
                    </div>      
                  </div>
                  <div class='row'>            
                    <div id="netfile-committee-city_dropdown" style="display: none;">
                      <h4>Cities</h4>
                      <select class="form-control" id='netfile-committee-city' name='netfile-committee-city'onchange="autocompleteHandler(this, 'netfile-committee-city')">
                        <option value=''>Select City</option>
                          <?php 
                            $conn = Util::get_ctb_conn();
                            $sql = "SELECT aid, verbose FROM netfile_locations WHERE juris = 'city' ORDER BY verbose";
                            $result = $conn->query($sql);
                            if($result->num_rows > 0) {
                              while($row = $result->fetch_assoc()) {
                                echo("<option value='" . $row['aid'] . "'>" . $row['verbose'] . "</option>");
                              }
                            }
                          ?>
                      </select>
                    </div>

                    <div id="netfile-committee-county_dropdown" style="display: none;">
                      <h4>Counties</h4>
                      <select class="form-control" id='netfile-committee-county' name='netfile-committee-county' onchange="autocompleteHandler(this, 'netfile-committee-county')">
                        <option value=''>Select County</option>
                          <?php 
                            $conn = Util::get_ctb_conn();
                            $sql = "SELECT aid, verbose FROM netfile_locations WHERE juris = 'county' ORDER BY verbose";
                            $result = $conn->query($sql);
                            if($result->num_rows > 0) {
                              while($row = $result->fetch_assoc()) {
                                echo("<option value='" . $row['aid'] . "'>" . $row['verbose'] . "</option>");
                              }
                            }
                          ?>
                      </select>
                    </div>
                  </div>
                </form>
              </div>
            </div>             
           <!-- End content -->
          </div>
        </div>
      </div>

<!--

                                                                                                       
     OOOOOOOOO    TTTTTTTTTTTTTTTTTTTTTTHHHHHHHHH     HHHHHHHHEEEEEEEEEEEEEEEEEEEEERRRRRRRRRRRRRRRRR   
   OO:::::::::OO  T:::::::::::::::::::::H:::::::H     H:::::::E::::::::::::::::::::R::::::::::::::::R  
 OO:::::::::::::OOT:::::::::::::::::::::H:::::::H     H:::::::E::::::::::::::::::::R::::::RRRRRR:::::R 
O:::::::OOO:::::::T:::::TT:::::::TT:::::HH::::::H     H::::::HEE::::::EEEEEEEEE::::RR:::::R     R:::::R
O::::::O   O::::::TTTTTT  T:::::T  TTTTTT H:::::H     H:::::H   E:::::E       EEEEEE R::::R     R:::::R
O:::::O     O:::::O       T:::::T         H:::::H     H:::::H   E:::::E              R::::R     R:::::R
O:::::O     O:::::O       T:::::T         H::::::HHHHH::::::H   E::::::EEEEEEEEEE    R::::RRRRRR:::::R 
O:::::O     O:::::O       T:::::T         H:::::::::::::::::H   E:::::::::::::::E    R:::::::::::::RR  
O:::::O     O:::::O       T:::::T         H:::::::::::::::::H   E:::::::::::::::E    R::::RRRRRR:::::R 
O:::::O     O:::::O       T:::::T         H::::::HHHHH::::::H   E::::::EEEEEEEEEE    R::::R     R:::::R
O:::::O     O:::::O       T:::::T         H:::::H     H:::::H   E:::::E              R::::R     R:::::R
O::::::O   O::::::O       T:::::T         H:::::H     H:::::H   E:::::E       EEEEEE R::::R     R:::::R
O:::::::OOO:::::::O     TT:::::::TT     HH::::::H     H::::::HEE::::::EEEEEEEE:::::RR:::::R     R:::::R
 OO:::::::::::::OO      T:::::::::T     H:::::::H     H:::::::E::::::::::::::::::::R::::::R     R:::::R
   OO:::::::::OO        T:::::::::T     H:::::::H     H:::::::E::::::::::::::::::::R::::::R     R:::::R
     OOOOOOOOO          TTTTTTTTTTT     HHHHHHHHH     HHHHHHHHEEEEEEEEEEEEEEEEEEEEERRRRRRRR     RRRRRRR
                                                                                                       
                                                                                                       
                                                                                                       
    

-->

      <div id="other" class="tab-pane fade">
        <ul class="nav nav-tabs" id="otherTabs">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#ctb-ca_candidate">CALIFORNIA CANDIDATE SEARCH</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#ctb-domain">DOMAIN LOOKUP</a>
          </li>
        </ul>

        <div class="tab-content">
          <div id="ctb-ca_candidate" class="tab-pane fade active">
            <h4>Search State / Local California Candidates</h4>
            <!-- Add your content here -->

            <div class='row'>
              <div class='panel'>
                <form id="ctb-ca_candidate-form">
                  <input type="text" style='display: none;' class='form-control' id='scope' value='ctb'>
                  <input type="text" style='display: none;' class='form-control' id='type' value='ca_candidate'>            
                  <div class="form-group">
                    <label for="ctb-ca_candidate-name">Candidate Name</label>
                    <input type="text" class="form-control" id="ctb-ca_candidate-name" name="ctb-ca_candidate-name">
                  </div>
                </form>
              </div>
            </div>  

            <!-- End content -->
          </div>
          <div id="ctb-domain" class="tab-pane fade">
            <h4>Search Political Web Domain Registrations</h4>
            <!-- Add your content here -->

            <div class='row'>
              <div class='panel'>
                <form id="ctb-domain-form">
                  <input type="text" style='display: none;' class='form-control' id='scope' value='ctb'>
                  <input type="text" style='display: none;' class='form-control' id='type' value='domain'>            
                  <div class="form-group">
                    <label for="ctb-domain-name">Domain Name</label>
                    <input type="text" class="form-control" id="ctb-domain-name" name="ctb-domain-name">
                  </div>
                </form>
              </div>
            </div>  

            <!-- End content -->
          </div>
        </div>
      </div>
    </div>

    <div>
      <p>Quicksearch Results</p>
      <div id='hint'></div>
      <p></p>
      <hr />
      <p></p>
      <div id='search-results'></div>
    </div>
  </div>

@endsection

@section('scripts')

<!--

                                                                                
                                                                                  
          JJJJJJJJJJJ         AAA  VVVVVVVV           VVVVVVVV  AAA               
          J:::::::::J        A:::A V::::::V           V::::::V A:::A              
          J:::::::::J       A:::::AV::::::V           V::::::VA:::::A             
          JJ:::::::JJ      A:::::::V::::::V           V::::::A:::::::A            
            J:::::J       A:::::::::V:::::V           V:::::A:::::::::A           
            J:::::J      A:::::A:::::V:::::V         V:::::A:::::A:::::A          
            J:::::J     A:::::A A:::::V:::::V       V:::::A:::::A A:::::A         
            J:::::j    A:::::A   A:::::V:::::V     V:::::A:::::A   A:::::A        
            J:::::J   A:::::A     A:::::V:::::V   V:::::A:::::A     A:::::A       
JJJJJJJ     J:::::J  A:::::AAAAAAAAA:::::V:::::V V:::::A:::::AAAAAAAAA:::::A      
J:::::J     J:::::J A:::::::::::::::::::::V:::::V:::::A:::::::::::::::::::::A     
J::::::J   J::::::JA:::::AAAAAAAAAAAAA:::::V:::::::::A:::::AAAAAAAAAAAAA:::::A    
J:::::::JJJ:::::::A:::::A             A:::::V:::::::A:::::A             A:::::A   
 JJ:::::::::::::JA:::::A               A:::::V:::::A:::::A               A:::::A  
   JJ:::::::::JJA:::::A                 A:::::V:::A:::::A                 A:::::A 
     JJJJJJJJJ AAAAAAA                   AAAAAAVVAAAAAAA                   AAAAAAA
                                                                                  
                                                                                  
                                                                                  

-->

  <!-- Bootstrap JS -->
  <!--<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>-->
  <!--<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>-->
  <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>-->

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/cr-1.6.1/fh-3.3.1/r-2.4.0/datatables.min.js"></script>

<script>


!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof module&&"object"==typeof module.exports?module.exports=e(require("jquery")):e(jQuery)}(function(e){return function(A){"use strict";var L=A.tablesorter={version:"2.31.3",parsers:[],widgets:[],defaults:{theme:"default",widthFixed:!1,showProcessing:!1,headerTemplate:"{content}",onRenderTemplate:null,onRenderHeader:null,cancelSelection:!0,tabIndex:!0,dateFormat:"mmddyyyy",sortMultiSortKey:"shiftKey",sortResetKey:"ctrlKey",usNumberFormat:!0,delayInit:!1,serverSideSorting:!1,resort:!0,headers:{},ignoreCase:!0,sortForce:null,sortList:[],sortAppend:null,sortStable:!1,sortInitialOrder:"asc",sortLocaleCompare:!1,sortReset:!1,sortRestart:!1,emptyTo:"bottom",stringTo:"max",duplicateSpan:!0,textExtraction:"basic",textAttribute:"data-text",textSorter:null,numberSorter:null,initWidgets:!0,widgetClass:"widget-{name}",widgets:[],widgetOptions:{zebra:["even","odd"]},initialized:null,tableClass:"",cssAsc:"",cssDesc:"",cssNone:"",cssHeader:"",cssHeaderRow:"",cssProcessing:"",cssChildRow:"tablesorter-childRow",cssInfoBlock:"tablesorter-infoOnly",cssNoSort:"tablesorter-noSort",cssIgnoreRow:"tablesorter-ignoreRow",cssIcon:"tablesorter-icon",cssIconNone:"",cssIconAsc:"",cssIconDesc:"",cssIconDisabled:"",pointerClick:"click",pointerDown:"mousedown",pointerUp:"mouseup",selectorHeaders:"> thead th, > thead td",selectorSort:"th, td",selectorRemove:".remove-me",debug:!1,headerList:[],empties:{},strings:{},parsers:[],globalize:0,imgAttr:0},css:{table:"tablesorter",cssHasChild:"tablesorter-hasChildRow",childRow:"tablesorter-childRow",colgroup:"tablesorter-colgroup",header:"tablesorter-header",headerRow:"tablesorter-headerRow",headerIn:"tablesorter-header-inner",icon:"tablesorter-icon",processing:"tablesorter-processing",sortAsc:"tablesorter-headerAsc",sortDesc:"tablesorter-headerDesc",sortNone:"tablesorter-headerUnSorted"},language:{sortAsc:"Ascending sort applied, ",sortDesc:"Descending sort applied, ",sortNone:"No sort applied, ",sortDisabled:"sorting is disabled",nextAsc:"activate to apply an ascending sort",nextDesc:"activate to apply a descending sort",nextNone:"activate to remove the sort"},regex:{templateContent:/\{content\}/g,templateIcon:/\{icon\}/g,templateName:/\{name\}/i,spaces:/\s+/g,nonWord:/\W/g,formElements:/(input|select|button|textarea)/i,chunk:/(^([+\-]?(?:\d*)(?:\.\d*)?(?:[eE][+\-]?\d+)?)?$|^0x[0-9a-f]+$|\d+)/gi,chunks:/(^\\0|\\0$)/,hex:/^0x[0-9a-f]+$/i,comma:/,/g,digitNonUS:/[\s|\.]/g,digitNegativeTest:/^\s*\([.\d]+\)/,digitNegativeReplace:/^\s*\(([.\d]+)\)/,digitTest:/^[\-+(]?\d+[)]?$/,digitReplace:/[,.'"\s]/g},string:{max:1,min:-1,emptymin:1,emptymax:-1,zero:0,none:0,"null":0,top:!0,bottom:!1},keyCodes:{enter:13},dates:{},instanceMethods:{},setup:function(t,r){if(t&&t.tHead&&0!==t.tBodies.length&&!0!==t.hasInitialized){var e,o="",s=A(t),a=A.metadata;t.hasInitialized=!1,t.isProcessing=!0,t.config=r,A.data(t,"tablesorter",r),L.debug(r,"core")&&(console[console.group?"group":"log"]("Initializing tablesorter v"+L.version),A.data(t,"startoveralltimer",new Date)),r.supportsDataObject=((e=A.fn.jquery.split("."))[0]=parseInt(e[0],10),1<e[0]||1===e[0]&&4<=parseInt(e[1],10)),r.emptyTo=r.emptyTo.toLowerCase(),r.stringTo=r.stringTo.toLowerCase(),r.last={sortList:[],clickedIndex:-1},/tablesorter\-/.test(s.attr("class"))||(o=""!==r.theme?" tablesorter-"+r.theme:""),r.namespace?r.namespace="."+r.namespace.replace(L.regex.nonWord,""):r.namespace=".tablesorter"+Math.random().toString(16).slice(2),r.table=t,r.$table=s.addClass(L.css.table+" "+r.tableClass+o+" "+r.namespace.slice(1)).attr("role","grid"),r.$headers=s.find(r.selectorHeaders),r.$table.children().children("tr").attr("role","row"),r.$tbodies=s.children("tbody:not(."+r.cssInfoBlock+")").attr({"aria-live":"polite","aria-relevant":"all"}),r.$table.children("caption").length&&((o=r.$table.children("caption")[0]).id||(o.id=r.namespace.slice(1)+"caption"),r.$table.attr("aria-labelledby",o.id)),r.widgetInit={},r.textExtraction=r.$table.attr("data-text-extraction")||r.textExtraction||"basic",L.buildHeaders(r),L.fixColumnWidth(t),L.addWidgetFromClass(t),L.applyWidgetOptions(t),L.setupParsers(r),r.totalRows=0,r.debug&&L.validateOptions(r),r.delayInit||L.buildCache(r),L.bindEvents(t,r.$headers,!0),L.bindMethods(r),r.supportsDataObject&&void 0!==s.data().sortlist?r.sortList=s.data().sortlist:a&&s.metadata()&&s.metadata().sortlist&&(r.sortList=s.metadata().sortlist),L.applyWidget(t,!0),0<r.sortList.length?(r.last.sortList=r.sortList,L.sortOn(r,r.sortList,{},!r.initWidgets)):(L.setHeadersCss(r),r.initWidgets&&L.applyWidget(t,!1)),r.showProcessing&&s.unbind("sortBegin"+r.namespace+" sortEnd"+r.namespace).bind("sortBegin"+r.namespace+" sortEnd"+r.namespace,function(e){clearTimeout(r.timerProcessing),L.isProcessing(t),"sortBegin"===e.type&&(r.timerProcessing=setTimeout(function(){L.isProcessing(t,!0)},500))}),t.hasInitialized=!0,t.isProcessing=!1,L.debug(r,"core")&&(console.log("Overall initialization time:"+L.benchmark(A.data(t,"startoveralltimer"))),L.debug(r,"core")&&console.groupEnd&&console.groupEnd()),s.triggerHandler("tablesorter-initialized",t),"function"==typeof r.initialized&&r.initialized(t)}else L.debug(r,"core")&&(t.hasInitialized?console.warn("Stopping initialization. Tablesorter has already been initialized"):console.error("Stopping initialization! No table, thead or tbody",t))},bindMethods:function(r){var e=r.$table,t=r.namespace,o="sortReset update updateRows updateAll updateHeaders addRows updateCell updateComplete sorton appendCache updateCache applyWidgetId applyWidgets refreshWidgets destroy mouseup mouseleave ".split(" ").join(t+" ");e.unbind(o.replace(L.regex.spaces," ")).bind("sortReset"+t,function(e,t){e.stopPropagation(),L.sortReset(this.config,function(e){e.isApplyingWidgets?setTimeout(function(){L.applyWidget(e,"",t)},100):L.applyWidget(e,"",t)})}).bind("updateAll"+t,function(e,t,r){e.stopPropagation(),L.updateAll(this.config,t,r)}).bind("update"+t+" updateRows"+t,function(e,t,r){e.stopPropagation(),L.update(this.config,t,r)}).bind("updateHeaders"+t,function(e,t){e.stopPropagation(),L.updateHeaders(this.config,t)}).bind("updateCell"+t,function(e,t,r,o){e.stopPropagation(),L.updateCell(this.config,t,r,o)}).bind("addRows"+t,function(e,t,r,o){e.stopPropagation(),L.addRows(this.config,t,r,o)}).bind("updateComplete"+t,function(){this.isUpdating=!1}).bind("sorton"+t,function(e,t,r,o){e.stopPropagation(),L.sortOn(this.config,t,r,o)}).bind("appendCache"+t,function(e,t,r){e.stopPropagation(),L.appendCache(this.config,r),A.isFunction(t)&&t(this)}).bind("updateCache"+t,function(e,t,r){e.stopPropagation(),L.updateCache(this.config,t,r)}).bind("applyWidgetId"+t,function(e,t){e.stopPropagation(),L.applyWidgetId(this,t)}).bind("applyWidgets"+t,function(e,t){e.stopPropagation(),L.applyWidget(this,!1,t)}).bind("refreshWidgets"+t,function(e,t,r){e.stopPropagation(),L.refreshWidgets(this,t,r)}).bind("removeWidget"+t,function(e,t,r){e.stopPropagation(),L.removeWidget(this,t,r)}).bind("destroy"+t,function(e,t,r){e.stopPropagation(),L.destroy(this,t,r)}).bind("resetToLoadState"+t,function(e){e.stopPropagation(),L.removeWidget(this,!0,!1);var t=A.extend(!0,{},r.originalSettings);(r=A.extend(!0,{},L.defaults,t)).originalSettings=t,this.hasInitialized=!1,L.setup(this,r)})},bindEvents:function(e,t,r){var o,i=(e=A(e)[0]).config,s=i.namespace,d=null;!0!==r&&(t.addClass(s.slice(1)+"_extra_headers"),(o=L.getClosest(t,"table")).length&&"TABLE"===o[0].nodeName&&o[0]!==e&&A(o[0]).addClass(s.slice(1)+"_extra_table")),o=(i.pointerDown+" "+i.pointerUp+" "+i.pointerClick+" sort keyup ").replace(L.regex.spaces," ").split(" ").join(s+" "),t.find(i.selectorSort).add(t.filter(i.selectorSort)).unbind(o).bind(o,function(e,t){var r,o,s,a=A(e.target),n=" "+e.type+" ";if(!(1!==(e.which||e.button)&&!n.match(" "+i.pointerClick+" | sort | keyup ")||" keyup "===n&&e.which!==L.keyCodes.enter||n.match(" "+i.pointerClick+" ")&&void 0!==e.which||n.match(" "+i.pointerUp+" ")&&d!==e.target&&!0!==t)){if(n.match(" "+i.pointerDown+" "))return d=e.target,void("1"===(s=a.jquery.split("."))[0]&&s[1]<4&&e.preventDefault());if(d=null,r=L.getClosest(A(this),"."+L.css.header),L.regex.formElements.test(e.target.nodeName)||a.hasClass(i.cssNoSort)||0<a.parents("."+i.cssNoSort).length||r.hasClass("sorter-false")||0<a.parents("button").length)return!i.cancelSelection;i.delayInit&&L.isEmptyObject(i.cache)&&L.buildCache(i),i.last.clickedIndex=r.attr("data-column")||r.index(),(o=i.$headerIndexed[i.last.clickedIndex][0])&&!o.sortDisabled&&L.initSort(i,o,e)}}),i.cancelSelection&&t.attr("unselectable","on").bind("selectstart",!1).css({"user-select":"none",MozUserSelect:"none"})},buildHeaders:function(d){var e,l,t,r;for(d.headerList=[],d.headerContent=[],d.sortVars=[],L.debug(d,"core")&&(t=new Date),d.columns=L.computeColumnIndex(d.$table.children("thead, tfoot").children("tr")),l=d.cssIcon?'<i class="'+(d.cssIcon===L.css.icon?L.css.icon:d.cssIcon+" "+L.css.icon)+'"></i>':"",d.$headers=A(A.map(d.$table.find(d.selectorHeaders),function(e,t){var r,o,s,a,n,i=A(e);if(!L.getClosest(i,"tr").hasClass(d.cssIgnoreRow))return/(th|td)/i.test(e.nodeName)||(n=L.getClosest(i,"th, td"),i.attr("data-column",n.attr("data-column"))),r=L.getColumnData(d.table,d.headers,t,!0),d.headerContent[t]=i.html(),""===d.headerTemplate||i.find("."+L.css.headerIn).length||(a=d.headerTemplate.replace(L.regex.templateContent,i.html()).replace(L.regex.templateIcon,i.find("."+L.css.icon).length?"":l),d.onRenderTemplate&&(o=d.onRenderTemplate.apply(i,[t,a]))&&"string"==typeof o&&(a=o),i.html('<div class="'+L.css.headerIn+'">'+a+"</div>")),d.onRenderHeader&&d.onRenderHeader.apply(i,[t,d,d.$table]),s=parseInt(i.attr("data-column"),10),e.column=s,n=L.getOrder(L.getData(i,r,"sortInitialOrder")||d.sortInitialOrder),d.sortVars[s]={count:-1,order:n?d.sortReset?[1,0,2]:[1,0]:d.sortReset?[0,1,2]:[0,1],lockedOrder:!1,sortedBy:""},void 0!==(n=L.getData(i,r,"lockedOrder")||!1)&&!1!==n&&(d.sortVars[s].lockedOrder=!0,d.sortVars[s].order=L.getOrder(n)?[1,1]:[0,0]),d.headerList[t]=e,i.addClass(L.css.header+" "+d.cssHeader),L.getClosest(i,"tr").addClass(L.css.headerRow+" "+d.cssHeaderRow).attr("role","row"),d.tabIndex&&i.attr("tabindex",0),e})),d.$headerIndexed=[],r=0;r<d.columns;r++)L.isEmptyObject(d.sortVars[r])&&(d.sortVars[r]={}),e=d.$headers.filter('[data-column="'+r+'"]'),d.$headerIndexed[r]=e.length?e.not(".sorter-false").length?e.not(".sorter-false").filter(":last"):e.filter(":last"):A();d.$table.find(d.selectorHeaders).attr({scope:"col",role:"columnheader"}),L.updateHeader(d),L.debug(d,"core")&&(console.log("Built headers:"+L.benchmark(t)),console.log(d.$headers))},addInstanceMethods:function(e){A.extend(L.instanceMethods,e)},setupParsers:function(e,t){var r,o,s,a,n,i,d,l,c,g,p,u,f,h,m=e.table,b=0,y=L.debug(e,"core"),w={};if(e.$tbodies=e.$table.children("tbody:not(."+e.cssInfoBlock+")"),0===(h=(f=void 0===t?e.$tbodies:t).length))return y?console.warn("Warning: *Empty table!* Not building a parser cache"):"";for(y&&(u=new Date,console[console.group?"group":"log"]("Detecting parsers for each column")),o={extractors:[],parsers:[]};b<h;){if((r=f[b].rows).length)for(n=0,a=e.columns,i=0;i<a;i++){if((d=e.$headerIndexed[n])&&d.length&&(l=L.getColumnData(m,e.headers,n),p=L.getParserById(L.getData(d,l,"extractor")),g=L.getParserById(L.getData(d,l,"sorter")),c="false"===L.getData(d,l,"parser"),e.empties[n]=(L.getData(d,l,"empty")||e.emptyTo||(e.emptyToBottom?"bottom":"top")).toLowerCase(),e.strings[n]=(L.getData(d,l,"string")||e.stringTo||"max").toLowerCase(),c&&(g=L.getParserById("no-parser")),p=p||!1,g=g||L.detectParserForColumn(e,r,-1,n),y&&(w["("+n+") "+d.text()]={parser:g.id,extractor:p?p.id:"none",string:e.strings[n],empty:e.empties[n]}),o.parsers[n]=g,o.extractors[n]=p,0<(s=d[0].colSpan-1)))for(n+=s,a+=s;0<s+1;)o.parsers[n-s]=g,o.extractors[n-s]=p,s--;n++}b+=o.parsers.length?h:1}y&&(L.isEmptyObject(w)?console.warn("  No parsers detected!"):console[console.table?"table":"log"](w),console.log("Completed detecting parsers"+L.benchmark(u)),console.groupEnd&&console.groupEnd()),e.parsers=o.parsers,e.extractors=o.extractors},addParser:function(e){var t,r=L.parsers.length,o=!0;for(t=0;t<r;t++)L.parsers[t].id.toLowerCase()===e.id.toLowerCase()&&(o=!1);o&&(L.parsers[L.parsers.length]=e)},getParserById:function(e){if("false"==e)return!1;var t,r=L.parsers.length;for(t=0;t<r;t++)if(L.parsers[t].id.toLowerCase()===e.toString().toLowerCase())return L.parsers[t];return!1},detectParserForColumn:function(e,t,r,o){for(var s,a,n,i=L.parsers.length,d=!1,l="",c=L.debug(e,"core"),g=!0;""===l&&g;)(n=t[++r])&&r<50?n.className.indexOf(L.cssIgnoreRow)<0&&(d=t[r].cells[o],l=L.getElementText(e,d,o),a=A(d),c&&console.log("Checking if value was empty on row "+r+", column: "+o+': "'+l+'"')):g=!1;for(;0<=--i;)if((s=L.parsers[i])&&"text"!==s.id&&s.is&&s.is(l,e.table,d,a))return s;return L.getParserById("text")},getElementText:function(e,t,r){if(!t)return"";var o,s=e.textExtraction||"",a=t.jquery?t:A(t);return"string"==typeof s?"basic"===s&&void 0!==(o=a.attr(e.textAttribute))?A.trim(o):A.trim(t.textContent||a.text()):"function"==typeof s?A.trim(s(a[0],e.table,r)):"function"==typeof(o=L.getColumnData(e.table,s,r))?A.trim(o(a[0],e.table,r)):A.trim(a[0].textContent||a.text())},getParsedText:function(e,t,r,o){void 0===o&&(o=L.getElementText(e,t,r));var s=""+o,a=e.parsers[r],n=e.extractors[r];return a&&(n&&"function"==typeof n.format&&(o=n.format(o,e.table,t,r)),s="no-parser"===a.id?"":a.format(""+o,e.table,t,r),e.ignoreCase&&"string"==typeof s&&(s=s.toLowerCase())),s},buildCache:function(e,t,r){var o,s,a,n,i,d,l,c,g,p,u,f,h,m,b,y,w,x,v,C,$,I,D=e.table,R=e.parsers,T=L.debug(e,"core");if(e.$tbodies=e.$table.children("tbody:not(."+e.cssInfoBlock+")"),l=void 0===r?e.$tbodies:r,e.cache={},e.totalRows=0,!R)return T?console.warn("Warning: *Empty table!* Not building a cache"):"";for(T&&(f=new Date),e.showProcessing&&L.isProcessing(D,!0),d=0;d<l.length;d++){for(y=[],o=e.cache[d]={normalized:[]},h=l[d]&&l[d].rows.length||0,n=0;n<h;++n)if(m={child:[],raw:[]},g=[],!(c=A(l[d].rows[n])).hasClass(e.selectorRemove.slice(1)))if(c.hasClass(e.cssChildRow)&&0!==n)for($=o.normalized.length-1,(b=o.normalized[$][e.columns]).$row=b.$row.add(c),c.prev().hasClass(e.cssChildRow)||c.prev().addClass(L.css.cssHasChild),p=c.children("th, td"),$=b.child.length,b.child[$]=[],x=0,C=e.columns,i=0;i<C;i++)(u=p[i])&&(b.child[$][i]=L.getParsedText(e,u,i),0<(w=p[i].colSpan-1)&&(x+=w,C+=w)),x++;else{for(m.$row=c,m.order=n,x=0,C=e.columns,i=0;i<C;++i){if((u=c[0].cells[i])&&x<e.columns&&(!(v=void 0!==R[x])&&T&&console.warn("No parser found for row: "+n+", column: "+i+'; cell containing: "'+A(u).text()+'"; does it have a header?'),s=L.getElementText(e,u,x),m.raw[x]=s,a=L.getParsedText(e,u,x,s),g[x]=a,v&&"numeric"===(R[x].type||"").toLowerCase()&&(y[x]=Math.max(Math.abs(a)||0,y[x]||0)),0<(w=u.colSpan-1))){for(I=0;I<=w;)a=e.duplicateSpan||0===I?a:"string"!=typeof e.textExtraction&&L.getElementText(e,u,x+I)||"",m.raw[x+I]=a,g[x+I]=a,I++;x+=w,C+=w}x++}g[e.columns]=m,o.normalized[o.normalized.length]=g}o.colMax=y,e.totalRows+=o.normalized.length}if(e.showProcessing&&L.isProcessing(D),T){for($=Math.min(5,e.cache[0].normalized.length),console[console.group?"group":"log"]("Building cache for "+e.totalRows+" rows (showing "+$+" rows in log) and "+e.columns+" columns"+L.benchmark(f)),s={},i=0;i<e.columns;i++)for(x=0;x<$;x++)s["row: "+x]||(s["row: "+x]={}),s["row: "+x][e.$headerIndexed[i].text()]=e.cache[0].normalized[x][i];console[console.table?"table":"log"](s),console.groupEnd&&console.groupEnd()}A.isFunction(t)&&t(D)},getColumnText:function(e,t,r,o){var s,a,n,i,d,l,c,g,p,u,f="function"==typeof r,h="all"===t,m={raw:[],parsed:[],$cell:[]},b=(e=A(e)[0]).config;if(!L.isEmptyObject(b)){for(d=b.$tbodies.length,s=0;s<d;s++)for(l=(n=b.cache[s].normalized).length,a=0;a<l;a++)i=n[a],o&&!i[b.columns].$row.is(o)||(u=!0,g=h?i.slice(0,b.columns):i[t],i=i[b.columns],c=h?i.raw:i.raw[t],p=h?i.$row.children():i.$row.children().eq(t),f&&(u=r({tbodyIndex:s,rowIndex:a,parsed:g,raw:c,$row:i.$row,$cell:p})),!1!==u&&(m.parsed[m.parsed.length]=g,m.raw[m.raw.length]=c,m.$cell[m.$cell.length]=p));return m}L.debug(b,"core")&&console.warn("No cache found - aborting getColumnText function!")},setHeadersCss:function(a){function e(e,t){e.removeClass(n).addClass(i[t]).attr("aria-sort",l[t]).find("."+L.css.icon).removeClass(d[2]).addClass(d[t])}var t,r,o=a.sortList,s=o.length,n=L.css.sortNone+" "+a.cssNone,i=[L.css.sortAsc+" "+a.cssAsc,L.css.sortDesc+" "+a.cssDesc],d=[a.cssIconAsc,a.cssIconDesc,a.cssIconNone],l=["ascending","descending"],c=a.$table.find("tfoot tr").children("td, th").add(A(a.namespace+"_extra_headers")).removeClass(i.join(" ")),g=a.$headers.add(A("thead "+a.namespace+"_extra_headers")).removeClass(i.join(" ")).addClass(n).attr("aria-sort","none").find("."+L.css.icon).removeClass(d.join(" ")).end();for(g.not(".sorter-false").find("."+L.css.icon).addClass(d[2]),a.cssIconDisabled&&g.filter(".sorter-false").find("."+L.css.icon).addClass(a.cssIconDisabled),t=0;t<s;t++)if(2!==o[t][1]){if((g=(g=a.$headers.filter(function(e){for(var t=!0,r=a.$headers.eq(e),o=parseInt(r.attr("data-column"),10),s=o+L.getClosest(r,"th, td")[0].colSpan;o<s;o++)t=!!t&&(t||-1<L.isValueInArray(o,a.sortList));return t})).not(".sorter-false").filter('[data-column="'+o[t][0]+'"]'+(1===s?":last":""))).length)for(r=0;r<g.length;r++)g[r].sortDisabled||e(g.eq(r),o[t][1]);c.length&&e(c.filter('[data-column="'+o[t][0]+'"]'),o[t][1])}for(s=a.$headers.length,t=0;t<s;t++)L.setColumnAriaLabel(a,a.$headers.eq(t))},getClosest:function(e,t){return A.fn.closest?e.closest(t):e.is(t)?e:e.parents(t).filter(":first")},setColumnAriaLabel:function(e,t,r){if(t.length){var o=parseInt(t.attr("data-column"),10),s=e.sortVars[o],a=t.hasClass(L.css.sortAsc)?"sortAsc":t.hasClass(L.css.sortDesc)?"sortDesc":"sortNone",n=A.trim(t.text())+": "+L.language[a];t.hasClass("sorter-false")||!1===r?n+=L.language.sortDisabled:(a=(s.count+1)%s.order.length,r=s.order[a],n+=L.language[0===r?"nextAsc":1===r?"nextDesc":"nextNone"]),t.attr("aria-label",n),s.sortedBy?t.attr("data-sortedBy",s.sortedBy):t.removeAttr("data-sortedBy")}},updateHeader:function(e){var t,r,o,s,a=e.table,n=e.$headers.length;for(t=0;t<n;t++)o=e.$headers.eq(t),s=L.getColumnData(a,e.headers,t,!0),r="false"===L.getData(o,s,"sorter")||"false"===L.getData(o,s,"parser"),L.setColumnSort(e,o,r)},setColumnSort:function(e,t,r){var o=e.table.id;t[0].sortDisabled=r,t[r?"addClass":"removeClass"]("sorter-false").attr("aria-disabled",""+r),e.tabIndex&&(r?t.removeAttr("tabindex"):t.attr("tabindex","0")),o&&(r?t.removeAttr("aria-controls"):t.attr("aria-controls",o))},updateHeaderSortCount:function(e,t){var r,o,s,a,n,i,d,l,c=t||e.sortList,g=c.length;for(e.sortList=[],a=0;a<g;a++)if(d=c[a],(r=parseInt(d[0],10))<e.columns){switch(e.sortVars[r].order||(l=L.getOrder(e.sortInitialOrder)?e.sortReset?[1,0,2]:[1,0]:e.sortReset?[0,1,2]:[0,1],e.sortVars[r].order=l,e.sortVars[r].count=0),l=e.sortVars[r].order,o=(o=(""+d[1]).match(/^(1|d|s|o|n)/))?o[0]:""){case"1":case"d":o=1;break;case"s":o=n||0;break;case"o":o=0===(i=l[(n||0)%l.length])?1:1===i?0:2;break;case"n":o=l[++e.sortVars[r].count%l.length];break;default:o=0}n=0===a?o:n,s=[r,parseInt(o,10)||0],e.sortList[e.sortList.length]=s,o=A.inArray(s[1],l),e.sortVars[r].count=0<=o?o:s[1]%l.length}},updateAll:function(e,t,r){var o=e.table;o.isUpdating=!0,L.refreshWidgets(o,!0,!0),L.buildHeaders(e),L.bindEvents(o,e.$headers,!0),L.bindMethods(e),L.commonUpdate(e,t,r)},update:function(e,t,r){e.table.isUpdating=!0,L.updateHeader(e),L.commonUpdate(e,t,r)},updateHeaders:function(e,t){e.table.isUpdating=!0,L.buildHeaders(e),L.bindEvents(e.table,e.$headers,!0),L.resortComplete(e,t)},updateCell:function(e,t,r,o){if(A(t).closest("tr").hasClass(e.cssChildRow))console.warn('Tablesorter Warning! "updateCell" for child row content has been disabled, use "update" instead');else{if(L.isEmptyObject(e.cache))return L.updateHeader(e),void L.commonUpdate(e,r,o);e.table.isUpdating=!0,e.$table.find(e.selectorRemove).remove();var s,a,n,i,d,l,c=e.$tbodies,g=A(t),p=c.index(L.getClosest(g,"tbody")),u=e.cache[p],f=L.getClosest(g,"tr");if(t=g[0],c.length&&0<=p){if(n=c.eq(p).find("tr").not("."+e.cssChildRow).index(f),d=u.normalized[n],(l=f[0].cells.length)!==e.columns)for(s=!1,a=i=0;a<l;a++)s||f[0].cells[a]===t?s=!0:i+=f[0].cells[a].colSpan;else i=g.index();s=L.getElementText(e,t,i),d[e.columns].raw[i]=s,s=L.getParsedText(e,t,i,s),d[i]=s,"numeric"===(e.parsers[i].type||"").toLowerCase()&&(u.colMax[i]=Math.max(Math.abs(s)||0,u.colMax[i]||0)),!1!==(s="undefined"!==r?r:e.resort)?L.checkResort(e,s,o):L.resortComplete(e,o)}else L.debug(e,"core")&&console.error("updateCell aborted, tbody missing or not within the indicated table"),e.table.isUpdating=!1}},addRows:function(e,t,r,o){var s,a,n,i,d,l,c,g,p,u,f,h,m,b="string"==typeof t&&1===e.$tbodies.length&&/<tr/.test(t||""),y=e.table;if(b)t=A(t),e.$tbodies.append(t);else if(!(t&&t instanceof A&&L.getClosest(t,"table")[0]===e.table))return L.debug(e,"core")&&console.error("addRows method requires (1) a jQuery selector reference to rows that have already been added to the table, or (2) row HTML string to be added to a table with only one tbody"),!1;if(y.isUpdating=!0,L.isEmptyObject(e.cache))L.updateHeader(e),L.commonUpdate(e,r,o);else{for(d=t.filter("tr").attr("role","row").length,n=e.$tbodies.index(t.parents("tbody").filter(":first")),e.parsers&&e.parsers.length||L.setupParsers(e),i=0;i<d;i++){for(p=0,c=t[i].cells.length,g=e.cache[n].normalized.length,f=[],u={child:[],raw:[],$row:t.eq(i),order:g},l=0;l<c;l++)h=t[i].cells[l],s=L.getElementText(e,h,p),u.raw[p]=s,a=L.getParsedText(e,h,p,s),f[p]=a,"numeric"===(e.parsers[p].type||"").toLowerCase()&&(e.cache[n].colMax[p]=Math.max(Math.abs(a)||0,e.cache[n].colMax[p]||0)),0<(m=h.colSpan-1)&&(p+=m),p++;f[e.columns]=u,e.cache[n].normalized[g]=f}L.checkResort(e,r,o)}},updateCache:function(e,t,r){e.parsers&&e.parsers.length||L.setupParsers(e,r),L.buildCache(e,t,r)},appendCache:function(e,t){var r,o,s,a,n,i,d,l=e.table,c=e.$tbodies,g=[],p=e.cache;if(L.isEmptyObject(p))return e.appender?e.appender(l,g):l.isUpdating?e.$table.triggerHandler("updateComplete",l):"";for(L.debug(e,"core")&&(d=new Date),i=0;i<c.length;i++)if((s=c.eq(i)).length){for(a=L.processTbody(l,s,!0),o=(r=p[i].normalized).length,n=0;n<o;n++)g[g.length]=r[n][e.columns].$row,e.appender&&(!e.pager||e.pager.removeRows||e.pager.ajax)||a.append(r[n][e.columns].$row);L.processTbody(l,a,!1)}e.appender&&e.appender(l,g),L.debug(e,"core")&&console.log("Rebuilt table"+L.benchmark(d)),t||e.appender||L.applyWidget(l),l.isUpdating&&e.$table.triggerHandler("updateComplete",l)},commonUpdate:function(e,t,r){e.$table.find(e.selectorRemove).remove(),L.setupParsers(e),L.buildCache(e),L.checkResort(e,t,r)},initSort:function(t,e,r){if(t.table.isUpdating)return setTimeout(function(){L.initSort(t,e,r)},50);var o,s,a,n,i,d,l,c=!r[t.sortMultiSortKey],g=t.table,p=t.$headers.length,u=L.getClosest(A(e),"th, td"),f=parseInt(u.attr("data-column"),10),h="mouseup"===r.type?"user":r.type,m=t.sortVars[f].order;if(u=u[0],t.$table.triggerHandler("sortStart",g),d=(t.sortVars[f].count+1)%m.length,t.sortVars[f].count=r[t.sortResetKey]?2:d,t.sortRestart)for(a=0;a<p;a++)l=t.$headers.eq(a),f!==(d=parseInt(l.attr("data-column"),10))&&(c||l.hasClass(L.css.sortNone))&&(t.sortVars[d].count=-1);if(c){if(A.each(t.sortVars,function(e){t.sortVars[e].sortedBy=""}),t.sortList=[],t.last.sortList=[],null!==t.sortForce)for(o=t.sortForce,s=0;s<o.length;s++)o[s][0]!==f&&(t.sortList[t.sortList.length]=o[s],t.sortVars[o[s][0]].sortedBy="sortForce");if((n=m[t.sortVars[f].count])<2&&(t.sortList[t.sortList.length]=[f,n],t.sortVars[f].sortedBy=h,1<u.colSpan))for(s=1;s<u.colSpan;s++)t.sortList[t.sortList.length]=[f+s,n],t.sortVars[f+s].count=A.inArray(n,m),t.sortVars[f+s].sortedBy=h}else if(t.sortList=A.extend([],t.last.sortList),0<=L.isValueInArray(f,t.sortList))for(t.sortVars[f].sortedBy=h,s=0;s<t.sortList.length;s++)(d=t.sortList[s])[0]===f&&(d[1]=m[t.sortVars[f].count],2===d[1]&&(t.sortList.splice(s,1),t.sortVars[f].count=-1));else if(n=m[t.sortVars[f].count],t.sortVars[f].sortedBy=h,n<2&&(t.sortList[t.sortList.length]=[f,n],1<u.colSpan))for(s=1;s<u.colSpan;s++)t.sortList[t.sortList.length]=[f+s,n],t.sortVars[f+s].count=A.inArray(n,m),t.sortVars[f+s].sortedBy=h;if(t.last.sortList=A.extend([],t.sortList),t.sortList.length&&t.sortAppend&&(o=A.isArray(t.sortAppend)?t.sortAppend:t.sortAppend[t.sortList[0][0]],!L.isEmptyObject(o)))for(s=0;s<o.length;s++)if(o[s][0]!==f&&L.isValueInArray(o[s][0],t.sortList)<0){if(i=(""+(n=o[s][1])).match(/^(a|d|s|o|n)/))switch(d=t.sortList[0][1],i[0]){case"d":n=1;break;case"s":n=d;break;case"o":n=0===d?1:0;break;case"n":n=(d+1)%m.length;break;default:n=0}t.sortList[t.sortList.length]=[o[s][0],n],t.sortVars[o[s][0]].sortedBy="sortAppend"}t.$table.triggerHandler("sortBegin",g),setTimeout(function(){L.setHeadersCss(t),L.multisort(t),L.appendCache(t),t.$table.triggerHandler("sortBeforeEnd",g),t.$table.triggerHandler("sortEnd",g)},1)},multisort:function(l){var e,t,c,r,g=l.table,p=[],u=0,f=l.textSorter||"",h=l.sortList,m=h.length,o=l.$tbodies.length;if(!l.serverSideSorting&&!L.isEmptyObject(l.cache)){if(L.debug(l,"core")&&(t=new Date),"object"==typeof f)for(c=l.columns;c--;)"function"==typeof(r=L.getColumnData(g,f,c))&&(p[c]=r);for(e=0;e<o;e++)c=l.cache[e].colMax,l.cache[e].normalized.sort(function(e,t){var r,o,s,a,n,i,d;for(r=0;r<m;r++){if(s=h[r][0],a=h[r][1],u=0===a,l.sortStable&&e[s]===t[s]&&1===m)return e[l.columns].order-t[l.columns].order;if(n=(o=/n/i.test(L.getSortType(l.parsers,s)))&&l.strings[s]?(o="boolean"==typeof L.string[l.strings[s]]?(u?1:-1)*(L.string[l.strings[s]]?-1:1):l.strings[s]&&L.string[l.strings[s]]||0,l.numberSorter?l.numberSorter(e[s],t[s],u,c[s],g):L["sortNumeric"+(u?"Asc":"Desc")](e[s],t[s],o,c[s],s,l)):(i=u?e:t,d=u?t:e,"function"==typeof f?f(i[s],d[s],u,s,g):"function"==typeof p[s]?p[s](i[s],d[s],u,s,g):L["sortNatural"+(u?"Asc":"Desc")](e[s]||"",t[s]||"",s,l)))return n}return e[l.columns].order-t[l.columns].order});L.debug(l,"core")&&console.log("Applying sort "+h.toString()+L.benchmark(t))}},resortComplete:function(e,t){e.table.isUpdating&&e.$table.triggerHandler("updateComplete",e.table),A.isFunction(t)&&t(e.table)},checkResort:function(e,t,r){var o=A.isArray(t)?t:e.sortList;!1===(void 0===t?e.resort:t)||e.serverSideSorting||e.table.isProcessing?(L.resortComplete(e,r),L.applyWidget(e.table,!1)):o.length?L.sortOn(e,o,function(){L.resortComplete(e,r)},!0):L.sortReset(e,function(){L.resortComplete(e,r),L.applyWidget(e.table,!1)})},sortOn:function(e,t,r,o){var s,a=e.table;for(e.$table.triggerHandler("sortStart",a),s=0;s<e.columns;s++)e.sortVars[s].sortedBy=-1<L.isValueInArray(s,t)?"sorton":"";L.updateHeaderSortCount(e,t),L.setHeadersCss(e),e.delayInit&&L.isEmptyObject(e.cache)&&L.buildCache(e),e.$table.triggerHandler("sortBegin",a),L.multisort(e),L.appendCache(e,o),e.$table.triggerHandler("sortBeforeEnd",a),e.$table.triggerHandler("sortEnd",a),L.applyWidget(a),A.isFunction(r)&&r(a)},sortReset:function(e,t){var r;for(e.sortList=[],r=0;r<e.columns;r++)e.sortVars[r].count=-1,e.sortVars[r].sortedBy="";L.setHeadersCss(e),L.multisort(e),L.appendCache(e),A.isFunction(t)&&t(e.table)},getSortType:function(e,t){return e&&e[t]&&e[t].type||""},getOrder:function(e){return/^d/i.test(e)||1===e},sortNatural:function(e,t){if(e===t)return 0;e=(e||"").toString(),t=(t||"").toString();var r,o,s,a,n,i,d=L.regex;if(d.hex.test(t)){if((r=parseInt(e.match(d.hex),16))<(o=parseInt(t.match(d.hex),16)))return-1;if(o<r)return 1}for(r=e.replace(d.chunk,"\\0$1\\0").replace(d.chunks,"").split("\\0"),o=t.replace(d.chunk,"\\0$1\\0").replace(d.chunks,"").split("\\0"),i=Math.max(r.length,o.length),n=0;n<i;n++){if(s=isNaN(r[n])?r[n]||0:parseFloat(r[n])||0,a=isNaN(o[n])?o[n]||0:parseFloat(o[n])||0,isNaN(s)!==isNaN(a))return isNaN(s)?1:-1;if(typeof s!=typeof a&&(s+="",a+=""),s<a)return-1;if(a<s)return 1}return 0},sortNaturalAsc:function(e,t,r,o){if(e===t)return 0;var s=L.string[o.empties[r]||o.emptyTo];return""===e&&0!==s?"boolean"==typeof s?s?-1:1:-s||-1:""===t&&0!==s?"boolean"==typeof s?s?1:-1:s||1:L.sortNatural(e,t)},sortNaturalDesc:function(e,t,r,o){if(e===t)return 0;var s=L.string[o.empties[r]||o.emptyTo];return""===e&&0!==s?"boolean"==typeof s?s?-1:1:s||1:""===t&&0!==s?"boolean"==typeof s?s?1:-1:-s||-1:L.sortNatural(t,e)},sortText:function(e,t){return t<e?1:e<t?-1:0},getTextValue:function(e,t,r){if(r){var o,s=e?e.length:0,a=r+t;for(o=0;o<s;o++)a+=e.charCodeAt(o);return t*a}return 0},sortNumericAsc:function(e,t,r,o,s,a){if(e===t)return 0;var n=L.string[a.empties[s]||a.emptyTo];return""===e&&0!==n?"boolean"==typeof n?n?-1:1:-n||-1:""===t&&0!==n?"boolean"==typeof n?n?1:-1:n||1:(isNaN(e)&&(e=L.getTextValue(e,r,o)),isNaN(t)&&(t=L.getTextValue(t,r,o)),e-t)},sortNumericDesc:function(e,t,r,o,s,a){if(e===t)return 0;var n=L.string[a.empties[s]||a.emptyTo];return""===e&&0!==n?"boolean"==typeof n?n?-1:1:n||1:""===t&&0!==n?"boolean"==typeof n?n?1:-1:-n||-1:(isNaN(e)&&(e=L.getTextValue(e,r,o)),isNaN(t)&&(t=L.getTextValue(t,r,o)),t-e)},sortNumeric:function(e,t){return e-t},addWidget:function(e){e.id&&!L.isEmptyObject(L.getWidgetById(e.id))&&console.warn('"'+e.id+'" widget was loaded more than once!'),L.widgets[L.widgets.length]=e},hasWidget:function(e,t){return(e=A(e)).length&&e[0].config&&e[0].config.widgetInit[t]||!1},getWidgetById:function(e){var t,r,o=L.widgets.length;for(t=0;t<o;t++)if((r=L.widgets[t])&&r.id&&r.id.toLowerCase()===e.toLowerCase())return r},applyWidgetOptions:function(e){var t,r,o,s=e.config,a=s.widgets.length;if(a)for(t=0;t<a;t++)(r=L.getWidgetById(s.widgets[t]))&&r.options&&(o=A.extend(!0,{},r.options),s.widgetOptions=A.extend(!0,o,s.widgetOptions),A.extend(!0,L.defaults.widgetOptions,r.options))},addWidgetFromClass:function(e){var t,r,o=e.config,s="^"+o.widgetClass.replace(L.regex.templateName,"(\\S+)+")+"$",a=new RegExp(s,"g"),n=(e.className||"").split(L.regex.spaces);if(n.length)for(t=n.length,r=0;r<t;r++)n[r].match(a)&&(o.widgets[o.widgets.length]=n[r].replace(a,"$1"))},applyWidgetId:function(e,t,r){var o,s,a,n=(e=A(e)[0]).config,i=n.widgetOptions,d=L.debug(n,"core"),l=L.getWidgetById(t);l&&(a=l.id,o=!1,A.inArray(a,n.widgets)<0&&(n.widgets[n.widgets.length]=a),d&&(s=new Date),!r&&n.widgetInit[a]||(n.widgetInit[a]=!0,e.hasInitialized&&L.applyWidgetOptions(e),"function"==typeof l.init&&(o=!0,d&&console[console.group?"group":"log"]("Initializing "+a+" widget"),l.init(e,l,n,i))),r||"function"!=typeof l.format||(o=!0,d&&console[console.group?"group":"log"]("Updating "+a+" widget"),l.format(e,n,i,!1)),d&&o&&(console.log("Completed "+(r?"initializing ":"applying ")+a+" widget"+L.benchmark(s)),console.groupEnd&&console.groupEnd()))},applyWidget:function(e,t,r){var o,s,a,n,i,d=(e=A(e)[0]).config,l=L.debug(d,"core"),c=[];if(!1===t||!e.hasInitialized||!e.isApplyingWidgets&&!e.isUpdating){if(l&&(i=new Date),L.addWidgetFromClass(e),clearTimeout(d.timerReady),d.widgets.length){for(e.isApplyingWidgets=!0,d.widgets=A.grep(d.widgets,function(e,t){return A.inArray(e,d.widgets)===t}),s=(a=d.widgets||[]).length,o=0;o<s;o++)(n=L.getWidgetById(a[o]))&&n.id?(n.priority||(n.priority=10),c[o]=n):l&&console.warn('"'+a[o]+'" was enabled, but the widget code has not been loaded!');for(c.sort(function(e,t){return e.priority<t.priority?-1:e.priority===t.priority?0:1}),s=c.length,l&&console[console.group?"group":"log"]("Start "+(t?"initializing":"applying")+" widgets"),o=0;o<s;o++)(n=c[o])&&n.id&&L.applyWidgetId(e,n.id,t);l&&console.groupEnd&&console.groupEnd()}d.timerReady=setTimeout(function(){e.isApplyingWidgets=!1,A.data(e,"lastWidgetApplication",new Date),d.$table.triggerHandler("tablesorter-ready"),t||"function"!=typeof r||r(e),l&&(n=d.widgets.length,console.log("Completed "+(!0===t?"initializing ":"applying ")+n+" widget"+(1!==n?"s":"")+L.benchmark(i)))},10)}},removeWidget:function(e,t,r){var o,s,a,n,i=(e=A(e)[0]).config;if(!0===t)for(t=[],n=L.widgets.length,a=0;a<n;a++)(s=L.widgets[a])&&s.id&&(t[t.length]=s.id);else t=(A.isArray(t)?t.join(","):t||"").toLowerCase().split(/[\s,]+/);for(n=t.length,o=0;o<n;o++)s=L.getWidgetById(t[o]),0<=(a=A.inArray(t[o],i.widgets))&&!0!==r&&i.widgets.splice(a,1),s&&s.remove&&(L.debug(i,"core")&&console.log((r?"Refreshing":"Removing")+' "'+t[o]+'" widget'),s.remove(e,i,i.widgetOptions,r),i.widgetInit[t[o]]=!1);i.$table.triggerHandler("widgetRemoveEnd",e)},refreshWidgets:function(e,t,r){function o(e){A(e).triggerHandler("refreshComplete")}var s,a,n=(e=A(e)[0]).config.widgets,i=L.widgets,d=i.length,l=[];for(s=0;s<d;s++)(a=i[s])&&a.id&&(t||A.inArray(a.id,n)<0)&&(l[l.length]=a.id);L.removeWidget(e,l.join(","),!0),!0!==r?(L.applyWidget(e,t||!1,o),t&&L.applyWidget(e,!1,o)):o(e)},benchmark:function(e){return" ("+((new Date).getTime()-e.getTime())+" ms)"},log:function(){console.log(arguments)},debug:function(e,t){return e&&(!0===e.debug||"string"==typeof e.debug&&-1<e.debug.indexOf(t))},isEmptyObject:function(e){for(var t in e)return!1;return!0},isValueInArray:function(e,t){var r,o=t&&t.length||0;for(r=0;r<o;r++)if(t[r][0]===e)return r;return-1},formatFloat:function(e,t){return"string"!=typeof e||""===e?e:(e=(t&&t.config?!1!==t.config.usNumberFormat:void 0===t||t)?e.replace(L.regex.comma,""):e.replace(L.regex.digitNonUS,"").replace(L.regex.comma,"."),L.regex.digitNegativeTest.test(e)&&(e=e.replace(L.regex.digitNegativeReplace,"-$1")),r=parseFloat(e),isNaN(r)?A.trim(e):r);var r},isDigit:function(e){return isNaN(e)?L.regex.digitTest.test(e.toString().replace(L.regex.digitReplace,"")):""!==e},computeColumnIndex:function(e,t){var r,o,s,a,n,i,d,l,c,g,p=t&&t.columns||0,u=[],f=new Array(p);for(r=0;r<e.length;r++)for(i=e[r].cells,o=0;o<i.length;o++){for(d=r,l=(n=i[o]).rowSpan||1,c=n.colSpan||1,void 0===u[d]&&(u[d]=[]),s=0;s<u[d].length+1;s++)if(void 0===u[d][s]){g=s;break}for(p&&n.cellIndex===g||(n.setAttribute?n.setAttribute("data-column",g):A(n).attr("data-column",g)),s=d;s<d+l;s++)for(void 0===u[s]&&(u[s]=[]),f=u[s],a=g;a<g+c;a++)f[a]="x"}return L.checkColumnCount(e,u,f.length),f.length},checkColumnCount:function(e,t,r){var o,s,a=!0,n=[];for(o=0;o<t.length;o++)if(t[o]&&(s=t[o].length,t[o].length!==r)){a=!1;break}a||(e.each(function(e,t){var r=t.parentElement.nodeName;n.indexOf(r)<0&&n.push(r)}),console.error("Invalid or incorrect number of columns in the "+n.join(" or ")+"; expected "+r+", but found "+s+" columns"))},fixColumnWidth:function(e){var t,r,o,s,a,n=(e=A(e)[0]).config,i=n.$table.children("colgroup");if(i.length&&i.hasClass(L.css.colgroup)&&i.remove(),n.widthFixed&&0===n.$table.children("colgroup").length){for(i=A('<colgroup class="'+L.css.colgroup+'">'),t=n.$table.width(),s=(o=n.$tbodies.find("tr:first").children(":visible")).length,a=0;a<s;a++)r=parseInt(o.eq(a).width()/t*1e3,10)/10+"%",i.append(A("<col>").css("width",r));n.$table.prepend(i)}},getData:function(e,t,r){var o,s,a="",n=A(e);return n.length?(o=!!A.metadata&&n.metadata(),s=" "+(n.attr("class")||""),void 0!==n.data(r)||void 0!==n.data(r.toLowerCase())?a+=n.data(r)||n.data(r.toLowerCase()):o&&void 0!==o[r]?a+=o[r]:t&&void 0!==t[r]?a+=t[r]:" "!==s&&s.match(" "+r+"-")&&(a=s.match(new RegExp("\\s"+r+"-([\\w-]+)"))[1]||""),A.trim(a)):""},getColumnData:function(e,t,r,o,s){if("object"!=typeof t||null===t)return t;var a,n=(e=A(e)[0]).config,i=s||n.$headers,d=n.$headerIndexed&&n.$headerIndexed[r]||i.find('[data-column="'+r+'"]:last');if(void 0!==t[r])return o?t[r]:t[i.index(d)];for(a in t)if("string"==typeof a&&d.filter(a).add(d.find(a)).length)return t[a]},isProcessing:function(e,t,r){var o=(e=A(e))[0].config,s=r||e.find("."+L.css.header);t?(void 0!==r&&0<o.sortList.length&&(s=s.filter(function(){return!this.sortDisabled&&0<=L.isValueInArray(parseFloat(A(this).attr("data-column")),o.sortList)})),e.add(s).addClass(L.css.processing+" "+o.cssProcessing)):e.add(s).removeClass(L.css.processing+" "+o.cssProcessing)},processTbody:function(e,t,r){if(e=A(e)[0],r)return e.isProcessing=!0,t.before('<colgroup class="tablesorter-savemyplace"/>'),A.fn.detach?t.detach():t.remove();var o=A(e).find("colgroup.tablesorter-savemyplace");t.insertAfter(o),o.remove(),e.isProcessing=!1},clearTableBody:function(e){A(e)[0].config.$tbodies.children().detach()},characterEquivalents:{a:"·‡‚„‰aÂ",A:"¡¿¬√ƒA≈",c:"Ácc",C:"«CC",e:"ÈËÍÎee",E:"…» ÀEE",i:"ÌÏIÓÔi",I:"ÕÃIŒœ",o:"ÛÚÙıˆo",O:"”“‘’÷O",ss:"ﬂ",SS:"?",u:"˙˘˚¸u",U:"⁄Ÿ€‹U"},replaceAccents:function(e){var t,r="[",o=L.characterEquivalents;if(!L.characterRegex){for(t in L.characterRegexArray={},o)"string"==typeof t&&(r+=o[t],L.characterRegexArray[t]=new RegExp("["+o[t]+"]","g"));L.characterRegex=new RegExp(r+"]")}if(L.characterRegex.test(e))for(t in o)"string"==typeof t&&(e=e.replace(L.characterRegexArray[t],t));return e},validateOptions:function(e){var t,r,o,s,a="headers sortForce sortList sortAppend widgets".split(" "),n=e.originalSettings;if(n){for(t in L.debug(e,"core")&&(s=new Date),n)if("undefined"===(o=typeof L.defaults[t]))console.warn('Tablesorter Warning! "table.config.'+t+'" option not recognized');else if("object"===o)for(r in n[t])o=L.defaults[t]&&typeof L.defaults[t][r],A.inArray(t,a)<0&&"undefined"===o&&console.warn('Tablesorter Warning! "table.config.'+t+"."+r+'" option not recognized');L.debug(e,"core")&&console.log("validate options time:"+L.benchmark(s))}},restoreHeaders:function(e){var t,r,o=A(e)[0].config,s=o.$table.find(o.selectorHeaders),a=s.length;for(t=0;t<a;t++)(r=s.eq(t)).find("."+L.css.headerIn).length&&r.html(o.headerContent[t])},destroy:function(e,t,r){if((e=A(e)[0]).hasInitialized){L.removeWidget(e,!0,!1);var o,s=A(e),a=e.config,n=s.find("thead:first"),i=n.find("tr."+L.css.headerRow).removeClass(L.css.headerRow+" "+a.cssHeaderRow),d=s.find("tfoot:first > tr").children("th, td");!1===t&&0<=A.inArray("uitheme",a.widgets)&&(s.triggerHandler("applyWidgetId",["uitheme"]),s.triggerHandler("applyWidgetId",["zebra"])),n.find("tr").not(i).remove(),o="sortReset update updateRows updateAll updateHeaders updateCell addRows updateComplete sorton appendCache updateCache applyWidgetId applyWidgets refreshWidgets removeWidget destroy mouseup mouseleave "+"keypress sortBegin sortEnd resetToLoadState ".split(" ").join(a.namespace+" "),s.removeData("tablesorter").unbind(o.replace(L.regex.spaces," ")),a.$headers.add(d).removeClass([L.css.header,a.cssHeader,a.cssAsc,a.cssDesc,L.css.sortAsc,L.css.sortDesc,L.css.sortNone].join(" ")).removeAttr("data-column").removeAttr("aria-label").attr("aria-disabled","true"),i.find(a.selectorSort).unbind("mousedown mouseup keypress ".split(" ").join(a.namespace+" ").replace(L.regex.spaces," ")),L.restoreHeaders(e),s.toggleClass(L.css.table+" "+a.tableClass+" tablesorter-"+a.theme,!1===t),s.removeClass(a.namespace.slice(1)),e.hasInitialized=!1,delete e.config.cache,"function"==typeof r&&r(e),L.debug(a,"core")&&console.log("tablesorter has been removed")}}};A.fn.tablesorter=function(t){return this.each(function(){var e=A.extend(!0,{},L.defaults,t,L.instanceMethods);e.originalSettings=t,!this.hasInitialized&&L.buildTable&&"TABLE"!==this.nodeName?L.buildTable(this,e):L.setup(this,e)})},window.console&&window.console.log||(L.logs=[],console={},console.log=console.warn=console.error=console.table=function(){var e=1<arguments.length?arguments:arguments[0];L.logs[L.logs.length]={date:Date.now(),log:e}}),L.addParser({id:"no-parser",is:function(){return!1},format:function(){return""},type:"text"}),L.addParser({id:"text",is:function(){return!0},format:function(e,t){var r=t.config;return e&&(e=A.trim(r.ignoreCase?e.toLocaleLowerCase():e),e=r.sortLocaleCompare?L.replaceAccents(e):e),e},type:"text"}),L.regex.nondigit=/[^\w,. \-()]/g,L.addParser({id:"digit",is:function(e){return L.isDigit(e)},format:function(e,t){var r=L.formatFloat((e||"").replace(L.regex.nondigit,""),t);return e&&"number"==typeof r?r:e?A.trim(e&&t.config.ignoreCase?e.toLocaleLowerCase():e):e},type:"numeric"}),L.regex.currencyReplace=/[+\-,. ]/g,L.regex.currencyTest=/^\(?\d+[\u00a3$\u20ac\u00a4\u00a5\u00a2?.]|[\u00a3$\u20ac\u00a4\u00a5\u00a2?.]\d+\)?$/,L.addParser({id:"currency",is:function(e){return e=(e||"").replace(L.regex.currencyReplace,""),L.regex.currencyTest.test(e)},format:function(e,t){var r=L.formatFloat((e||"").replace(L.regex.nondigit,""),t);return e&&"number"==typeof r?r:e?A.trim(e&&t.config.ignoreCase?e.toLocaleLowerCase():e):e},type:"numeric"}),L.regex.urlProtocolTest=/^(https?|ftp|file):\/\//,L.regex.urlProtocolReplace=/(https?|ftp|file):\/\/(www\.)?/,L.addParser({id:"url",is:function(e){return L.regex.urlProtocolTest.test(e)},format:function(e){return e?A.trim(e.replace(L.regex.urlProtocolReplace,"")):e},type:"text"}),L.regex.dash=/-/g,L.regex.isoDate=/^\d{4}[\/\-]\d{1,2}[\/\-]\d{1,2}/,L.addParser({id:"isoDate",is:function(e){return L.regex.isoDate.test(e)},format:function(e){var t=e?new Date(e.replace(L.regex.dash,"/")):e;return t instanceof Date&&isFinite(t)?t.getTime():e},type:"numeric"}),L.regex.percent=/%/g,L.regex.percentTest=/(\d\s*?%|%\s*?\d)/,L.addParser({id:"percent",is:function(e){return L.regex.percentTest.test(e)&&e.length<15},format:function(e,t){return e?L.formatFloat(e.replace(L.regex.percent,""),t):e},type:"numeric"}),L.addParser({id:"image",is:function(e,t,r,o){return 0<o.find("img").length},format:function(e,t,r){return A(r).find("img").attr(t.config.imgAttr||"alt")||e},parsed:!0,type:"text"}),L.regex.dateReplace=/(\S)([AP]M)$/i,L.regex.usLongDateTest1=/^[A-Z]{3,10}\.?\s+\d{1,2},?\s+(\d{4})(\s+\d{1,2}:\d{2}(:\d{2})?(\s+[AP]M)?)?$/i,L.regex.usLongDateTest2=/^\d{1,2}\s+[A-Z]{3,10}\s+\d{4}/i,L.addParser({id:"usLongDate",is:function(e){return L.regex.usLongDateTest1.test(e)||L.regex.usLongDateTest2.test(e)},format:function(e){var t=e?new Date(e.replace(L.regex.dateReplace,"$1 $2")):e;return t instanceof Date&&isFinite(t)?t.getTime():e},type:"numeric"}),L.regex.shortDateTest=/(^\d{1,2}[\/\s]\d{1,2}[\/\s]\d{4})|(^\d{4}[\/\s]\d{1,2}[\/\s]\d{1,2})/,L.regex.shortDateReplace=/[\-.,]/g,L.regex.shortDateXXY=/(\d{1,2})[\/\s](\d{1,2})[\/\s](\d{4})/,L.regex.shortDateYMD=/(\d{4})[\/\s](\d{1,2})[\/\s](\d{1,2})/,L.convertFormat=function(e,t){e=(e||"").replace(L.regex.spaces," ").replace(L.regex.shortDateReplace,"/"),"mmddyyyy"===t?e=e.replace(L.regex.shortDateXXY,"$3/$1/$2"):"ddmmyyyy"===t?e=e.replace(L.regex.shortDateXXY,"$3/$2/$1"):"yyyymmdd"===t&&(e=e.replace(L.regex.shortDateYMD,"$1/$2/$3"));var r=new Date(e);return r instanceof Date&&isFinite(r)?r.getTime():""},L.addParser({id:"shortDate",is:function(e){return e=(e||"").replace(L.regex.spaces," ").replace(L.regex.shortDateReplace,"/"),L.regex.shortDateTest.test(e)},format:function(e,t,r,o){if(e){var s=t.config,a=s.$headerIndexed[o],n=a.length&&a.data("dateFormat")||L.getData(a,L.getColumnData(t,s.headers,o),"dateFormat")||s.dateFormat;return a.length&&a.data("dateFormat",n),L.convertFormat(e,n)||e}return e},type:"numeric"}),L.regex.timeTest=/^(0?[1-9]|1[0-2]):([0-5]\d)(\s[AP]M)$|^((?:[01]\d|[2][0-4]):[0-5]\d)$/i,L.regex.timeMatch=/(0?[1-9]|1[0-2]):([0-5]\d)(\s[AP]M)|((?:[01]\d|[2][0-4]):[0-5]\d)/i,L.addParser({id:"time",is:function(e){return L.regex.timeTest.test(e)},format:function(e){var t=(e||"").match(L.regex.timeMatch),r=new Date(e),o=e&&(null!==t?t[0]:"00:00 AM"),s=o?new Date("2000/01/01 "+o.replace(L.regex.dateReplace,"$1 $2")):o;return s instanceof Date&&isFinite(s)?(r instanceof Date&&isFinite(r)?r.getTime():0)?parseFloat(s.getTime()+"."+r.getTime()):s.getTime():e},type:"numeric"}),L.addParser({id:"metadata",is:function(){return!1},format:function(e,t,r){var o=t.config,s=o.parserMetadataName?o.parserMetadataName:"sortValue";return A(r).metadata()[s]},type:"numeric"}),L.addWidget({id:"zebra",priority:90,format:function(e,t,r){var o,s,a,n,i,d,l,c=new RegExp(t.cssChildRow,"i"),g=t.$tbodies.add(A(t.namespace+"_extra_table").children("tbody:not(."+t.cssInfoBlock+")"));for(i=0;i<g.length;i++)for(a=0,l=(o=g.eq(i).children("tr:visible").not(t.selectorRemove)).length,d=0;d<l;d++)s=o.eq(d),c.test(s[0].className)||a++,n=a%2==0,s.removeClass(r.zebra[n?1:0]).addClass(r.zebra[n?0:1])},remove:function(e,t,r,o){if(!o){var s,a,n=t.$tbodies,i=(r.zebra||["even","odd"]).join(" ");for(s=0;s<n.length;s++)(a=L.processTbody(e,n.eq(s),!0)).children().removeClass(i),L.processTbody(e,a,!1)}}})}(e),e.tablesorter});
</script>

    <script type="text/javascript"> 

  jQuery.tablesorter.addParser({
      id: "monetaryValue",
          is: function (s) {
          return false;
        }, format: function (s) {
          var n = parseFloat( s.replace('$','').replace(/,/g,'') );
            return isNaN(n) ? s : n;
    }, type: "numeric"
  });

</script>

<script>

$( document ).ready(function() {
    $('#fec-li').click();
    $('#fec-contributor-li').click();
});


    // Handle form submission
    function formHandler(event) {
      event.preventDefault();

      var scope = this.scope.value;
      var type = this.type.value;      

      var prefix = scope + '-' + type;

      var formData = populateFormData(prefix, scope, type);

      var jsonData = JSON.stringify(formData);
      sendFormData(jsonData);

    }

function sendFormData(data) {
  // Perform an AJAX request to the server
  // Here, you can use any AJAX method or library of your choice
  // For example, using jQuery
  //console.log(data);
  //alert('Sending data');

  $('#search-results').empty();
  $('#search-results').append("<div class='row'><p align='center'><img src='/img/loading-spinner.gif' width='150' align='center' /></p></div>");


  $.ajax({
    url: 'ctb_multi_search',
    type: 'GET',
    dataType: 'text', // Set the dataType to 'text' instead of 'json'
    data: { q: data },
    success: function(response) {
      var decodedResponse = JSON.parse(response); // Parse the gzencoded JSON response
      // Handle the server response
      //console.log(decodedResponse);
      //$('#search-results').empty();
      draw_search_results(decodedResponse);
    },
    error: function(xhr, status, error) {
      // Handle error
      console.error(error);
    }
  });
}

function draw_search_results(x) {
	var this_scope = x.scope;
	var this_search = x.type;
	switch(this_scope) {
		case "fec":
			draw_fec(x, this_search);
			break;	
		case "fppc":
			draw_fppc(x, this_search);
			break;
		case "netfile":
			draw_netfile(x, this_search);
			break;
		case "ctb":
			draw_ctb(x, this_search);
			break;
	}
}

function draw_fec(x, type) {
	//console.log("Entered draw_fec function, routing with " + type);
	switch(type) {
		case "contributor":
			draw_fec_contributor(x);
			break;		
		case "vendor":
			draw_fec_vendor(x);
			break;
		case "treasurer":
			draw_fec_treasurer(x);
			break;
	}
}

function draw_fec_contributor(x) {
	//console.log("Running draw_fec_contributor function");
	//console.log(x);
	const searchDiv = document.getElementById('search-results');

	var grandTotal = parseFloat(x.grand_total).toLocaleString('en-US', {
		  style: 'currency',
		  currency: 'USD',
		  maximumFractionDigits: 0
		});



	searchDiv.innerHTML = "<h2 align='center'>FEC Contributor Results for <span class='greenme boldme'>" + x.search_name.toUpperCase() + "</h2><h3 align='center'>" + grandTotal + "</h3>";


	//draw summary table

	const sortedCmteTotals = Object.entries(x.cmte_totals).sort((a,b) => b[1] - a[1]);

	var table = document.createElement('table');
	table.setAttribute('id', 'search-results-summary-table');
	table.setAttribute('class', 'tablesorter table-striped2 line-1em w-auto');
	table.setAttribute('align', 'center');
	var thead = table.createTHead();
	var headerRow = thead.insertRow();
	var headerColumns = ['cmte_id', 'cmte_nm', 'total'];

	 $("search-results-summary-table").tablesorter({
	    headers: {
	      2: {
        	sorter: 'monetaryValue'
	      },
	    }
	  });
	headerColumns.forEach(columnName => {
	  var th = document.createElement('th');
	  th.textContent = columnName;
	  th.setAttribute('data-sortable', 'true');
	  headerRow.appendChild(th);
	});

	searchDiv.appendChild(table);
	var tableBody = table.createTBody();

	sortedCmteTotals.forEach(([cmte_id, total]) => {
		var cmte_nm = x.committees[cmte_id];
		var row = tableBody.insertRow();
		
		//INSERT CELLS
		var c1 = row.insertCell();
		var c2 = row.insertCell();
		var c3 = row.insertCell();

		//SET CONTENT
		c1.textContent = cmte_id;
		c2.textContent = cmte_nm;
		var transactionAmt = parseFloat(total);
		c3.textContent = transactionAmt.toLocaleString('en-US', {
		  style: 'currency',
		  currency: 'USD',
		  maximumFractionDigits: 0
		});
		c3.style.textAlign='right';


	});

  var spacer = "<hr /><h3 align='center'>Results Detail</h3>";
  searchDiv.innerHTML = searchDiv.innerHTML + spacer;

	//draw results table

	var table = document.createElement('table');
	table.setAttribute('id', 'search-results-table');
	table.setAttribute('class', 'tablesorter table-striped');
        table.setAttribute('v-ctb-table', 'v-ctb-table');
	var thead = table.createTHead();
	var headerRow = thead.insertRow();
	var headerColumns = ['date', 'name', 'city', 'st', 'employer', 'occupation', 'amt', 'cmte_id', 'cmte_nm', 'tran_id', 'image_num'];

	 $("search-results-table").tablesorter({
	    headers: {
	      6: {
        	sorter: 'monetaryValue'
	      },
	    }
	  });


	headerColumns.forEach(columnName => {
	  var th = document.createElement('th');
	  th.textContent = columnName;
	  th.setAttribute('data-sortable', 'true');
	  headerRow.appendChild(th);
	});

	searchDiv.appendChild(table);
	var tableBody = table.createTBody();

	for (let i = 0; i < x.transactions.length; i++) {
		var t = x.transactions[i];
		var cmte_id = t.CMTE_ID;
		var cmte_nm = x.committees[cmte_id];
		var row = tableBody.insertRow();

		//INSERT CELLS
		var c1 = row.insertCell();
		var c2 = row.insertCell();
		var c3 = row.insertCell();
		var c4 = row.insertCell();
		var c5 = row.insertCell();
		var c6 = row.insertCell();
		var c7 = row.insertCell();
		var c8 = row.insertCell();
		var c9 = row.insertCell();
		var c10 = row.insertCell();
		var c11 = row.insertCell();

		var transactionDate = t.TRANSACTION_DT;
		var formattedDate = `${transactionDate.slice(4, 8)}-${transactionDate.slice(0, 2)}-${transactionDate.slice(2, 4)}`;
		c1.textContent = formattedDate;

		c2.textContent = t.NAME;
		c3.textContent = t.CITY;
		c4.textContent = t.STATE;
		c5.textContent = t.EMPLOYER;
		c6.textContent = t.OCCUPATION;

		var transactionAmt = parseFloat(t.TRANSACTION_AMT);
		c7.textContent = transactionAmt.toLocaleString('en-US', {
		  style: 'currency',
		  currency: 'USD',
		  maximumFractionDigits: 0
		});
		c7.style.textAlign='right';
		c8.innerHTML = get_link('ctb-f3', cmte_id, cmte_id);
		c9.innerHTML = get_link('fec-cmte', cmte_id, cmte_nm);
		c10.textContent = t.TRAN_ID;
		c11.innerHTML = get_link('fec-image', t.IMAGE_NUM, 'IMG');
		
	}
  	$('#search-results-table').DataTable( {
      		"paging": false,
	      	"dom": 'Bfrtip',       
      		"buttons": ['copy', 'excel', 'pdf', 'print', 'colvis']
	  });
	$('#search-results-table').tablesorter().trigger('update');
}



function draw_fec_vendor(x) {
	//console.log("Running draw_fec_vendor function");
	//console.log(x);
	const searchDiv = document.getElementById('search-results');

	var grandTotal = parseFloat(x.grand_total).toLocaleString('en-US', {
		  style: 'currency',
		  currency: 'USD',
		  maximumFractionDigits: 0
		});

	searchDiv.innerHTML = "<h2 align='center'>FEC Vendor Results for <span class='greenme boldme'>" + x.search_name.toUpperCase() + "</h2><h3 align='center'>" + grandTotal + "</h3>";

	//draw summary table

	const sortedCmteTotals = Object.entries(x.cmte_totals).sort((a,b) => b[1] - a[1]);

	var table = document.createElement('table');
	table.setAttribute('id', 'search-results-summary-table');
	table.setAttribute('class', 'tablesorter table-striped2 line-1em w-auto');
	table.setAttribute('align', 'center');
	var thead = table.createTHead();
	var headerRow = thead.insertRow();
	var headerColumns = ['cmte_id', 'cmte_nm', 'total'];

	 $("search-results-summary-table").tablesorter({
	    headers: {
	      2: {
        	sorter: 'monetaryValue'
	      },
	    }
	  });
	headerColumns.forEach(columnName => {
	  var th = document.createElement('th');
	  th.textContent = columnName;
	  th.setAttribute('data-sortable', 'true');
	  headerRow.appendChild(th);
	});

	searchDiv.appendChild(table);
	var tableBody = table.createTBody();

	sortedCmteTotals.forEach(([cmte_id, total]) => {
		var cmte_nm = x.committees[cmte_id];
		var row = tableBody.insertRow();
		
		//INSERT CELLS
		var c1 = row.insertCell();
		var c2 = row.insertCell();
		var c3 = row.insertCell();

		//SET CONTENT
		c1.textContent = cmte_id;
		c2.textContent = cmte_nm;
		var transactionAmt = parseFloat(total);
		c3.textContent = transactionAmt.toLocaleString('en-US', {
		  style: 'currency',
		  currency: 'USD',
		  maximumFractionDigits: 0
		});
		c3.style.textAlign='right';


	});

  var spacer = "<hr /><h3 align='center'>Results Detail</h3>";
  searchDiv.innerHTML = searchDiv.innerHTML + spacer;


	//draw results table

	var table = document.createElement('table');
	table.setAttribute('id', 'search-results-table');
	table.setAttribute('class', 'tablesorter table-striped');
	var thead = table.createTHead();
	var headerRow = thead.insertRow();
	var headerColumns = ['date', 'cmte_id', 'cmte_nm', 'name', 'city', 'st', 'zip', 'purpose', 'amt', 'tran_id', 'image_num'];

	 $("search-results-table").tablesorter({
	    headers: {
	      7: {
        	sorter: 'monetaryValue'
	      },
	    }
	  });


	headerColumns.forEach(columnName => {
	  var th = document.createElement('th');
	  th.textContent = columnName;
	  th.setAttribute('data-sortable', 'true');
	  headerRow.appendChild(th);
	});

	searchDiv.appendChild(table);
	var tableBody = table.createTBody();

	for (let i = 0; i < x.transactions.length; i++) {
		var t = x.transactions[i];
		var cmte_id = t.CMTE_ID;
		var cmte_nm = x.committees[cmte_id];
		var row = tableBody.insertRow();

		//INSERT CELLS
		var c1 = row.insertCell();
		var c2 = row.insertCell();
		var c3 = row.insertCell();
		var c4 = row.insertCell();
		var c5 = row.insertCell();
		var c6 = row.insertCell();
		var c7 = row.insertCell();
		var c8 = row.insertCell();
		var c9 = row.insertCell();
		var c10 = row.insertCell();
		var c11 = row.insertCell();

		var originalDate = t.TRANSACTION_DT;
		var parts = originalDate.split('/'); // Split the date string into parts
		var reformattedDate = `${parts[2]}-${parts[0].padStart(2, '0')}-${parts[1].padStart(2, '0')}`;

		c1.textContent = reformattedDate;
		c2.innerHTML = get_link('ctb-f3', t.CMTE_ID, t.CMTE_ID);
		c3.innerHTML = get_link('fec-cmte', t.CMTE_ID, t.CMTE_NM);
		c4.textContent = t.NAME;
		c5.textContent = t.CITY;
		c6.textContent = t.STATE;
		c7.textContent = t.ZIP_CODE;
		c8.textContent = t.PURPOSE;

		var transactionAmt = parseFloat(t.TRANSACTION_AMT);
		c9.textContent = transactionAmt.toLocaleString('en-US', {
		  style: 'currency',
		  currency: 'USD',
		  maximumFractionDigits: 0
		});
		c9.style.textAlign='right';
		c10.textContent = t.TRAN_ID;
		c11.innerHTML = get_link('fec-image', t.IMAGE_NUM, 'IMG');
		
	}
  	$('#search-results-table').DataTable( {
      		"paging": false,
	      	"dom": 'Bfrtip',       
      		"buttons": ['copy', 'excel', 'pdf', 'print', 'colvis']
	  });
	$('#search-results-table').tablesorter().trigger('update');
}


function draw_fppc(x, type) {
	switch(type) {
		case "contributor":
			draw_fppc_contributor(x);
			break;		
		case "vendor":
			draw_fppc_vendor(x);
			break;
		case "committee":
			draw_fppc_committee(x);
			break;
	}
}

function draw_fppc_contributor(x) {
  //console.log("Running draw_fppc_contributor function");
  //console.log(x);
  const searchDiv = document.getElementById('search-results');

  var grandTotal = parseFloat(x.grand_total).toLocaleString('en-US', {
      style: 'currency',
      currency: 'USD',
      maximumFractionDigits: 0
    });

  searchDiv.innerHTML = "<h2 align='center'>FPPC Contributor Results for <span class='greenme boldme'>" + x.search_name.toUpperCase() + "</h2><h3 align='center'>" + grandTotal + "</h3>";

  //draw summary table

  const sortedCmteTotals = Object.entries(x.cmte_totals).sort((a,b) => b[1] - a[1]);

  var table = document.createElement('table');
  table.setAttribute('id', 'search-results-summary-table');
  table.setAttribute('class', 'tablesorter table-striped2 line-1em w-auto');
  table.setAttribute('align', 'center');
  var thead = table.createTHead();
  var headerRow = thead.insertRow();
  var headerColumns = ['cmte_id', 'cmte_nm', 'total'];

   $("search-results-summary-table").tablesorter({
      headers: {
        2: {
          sorter: 'monetaryValue'
        },
      }
    });
  headerColumns.forEach(columnName => {
    var th = document.createElement('th');
    th.textContent = columnName;
    th.setAttribute('data-sortable', 'true');
    headerRow.appendChild(th);
  });

  searchDiv.appendChild(table);
  var tableBody = table.createTBody();

  sortedCmteTotals.forEach(([cmte_id, total]) => {
    var cmte_nm = x.committees[cmte_id];
    var row = tableBody.insertRow();
    
    //INSERT CELLS
    var c1 = row.insertCell();
    var c2 = row.insertCell();
    var c3 = row.insertCell();

    //SET CONTENT
    c1.textContent = cmte_id;
    c2.textContent = cmte_nm;
    var transactionAmt = parseFloat(total);
    c3.textContent = transactionAmt.toLocaleString('en-US', {
      style: 'currency',
      currency: 'USD',
      maximumFractionDigits: 0
    });
    c3.style.textAlign='right';


  });

  var spacer = "<hr /><h3 align='center'>Results Detail</h3>";
  searchDiv.innerHTML = searchDiv.innerHTML + spacer;


  //draw results table

  var table = document.createElement('table');
  table.setAttribute('id', 'search-results-table');
  table.setAttribute('class', 'tablesorter table-striped');
  var thead = table.createTHead();
  var headerRow = thead.insertRow();
  var headerColumns = ['date', 'filing', 'cmte_id', 'cmte_nm', 'amt', 'name', 'employer', 'occupation', 'city', 'st', 'zip', 'tran_id'];

   $("search-results-table").tablesorter({
      headers: {
        6: {
          sorter: 'monetaryValue'
        },
      }
    });


  headerColumns.forEach(columnName => {
    var th = document.createElement('th');
    th.textContent = columnName;
    th.setAttribute('data-sortable', 'true');
    headerRow.appendChild(th);
  });

  searchDiv.appendChild(table);
  var tableBody = table.createTBody();

  for (let i = 0; i < x.transactions.length; i++) {
    var t = x.transactions[i];
    var cmte_id = t.CMTE_ID;
    var cmte_nm = x.committees[cmte_id];
    var row = tableBody.insertRow();

    //INSERT CELLS
    var c1 = row.insertCell();
    var c2 = row.insertCell();
    var c3 = row.insertCell();
    var c4 = row.insertCell();
    var c5 = row.insertCell();
    var c6 = row.insertCell();
    var c7 = row.insertCell();
    var c8 = row.insertCell();
    var c9 = row.insertCell();
    var c10 = row.insertCell();
    var c11 = row.insertCell();
    var c12 = row.insertCell();

    c1.textContent = t.RCPT_DATE;
    c2.innerHTML = get_link('calaccess-filing', t.FILING_ID, t.FILING_ID);
    c3.innerHTML = get_link('cmlocal', t.FILER_ID, t.FILER_ID);
    c4.innerHTML = get_link('calaccess-redirect', t.FILER_ID, t.FILER_NM);

    var transactionAmt = parseFloat(t.AMOUNT);
    c5.textContent = transactionAmt.toLocaleString('en-US', {
      style: 'currency',
      currency: 'USD',
      maximumFractionDigits: 0
    });
    c5.style.textAlign='right';


    c6.textContent = t.NAME;
    c7.textContent = t.CTRIB_EMP;
    c8.textContent = t.CTRIB_OCC;
    c9.textContent = t. CTRIB_CITY;
    c10.textContent = t.CTRIB_ST;
    c11.textContent = t.CTRIB_ZIP4;
    c12.textContent = t.TRAN_ID;
    
  }
    $('#search-results-table').DataTable( {
          "paging": false,
          "dom": 'Bfrtip',       
          "buttons": ['copy', 'excel', 'pdf', 'print', 'colvis']
    });
  $('#search-results-table').tablesorter().trigger('update');
}

function draw_fppc_vendor(x) {
  //console.log("Running draw_fppc_vendor function");
  //console.log(x);
  const searchDiv = document.getElementById('search-results');

  var grandTotal = parseFloat(x.grand_total).toLocaleString('en-US', {
      style: 'currency',
      currency: 'USD',
      maximumFractionDigits: 0
    });

  searchDiv.innerHTML = "<h2 align='center'>FPPC Vendor Results for <span class='greenme boldme'>" + x.search_name.toUpperCase() + "</h2><h3 align='center'>" + grandTotal + "</h3>";

  //draw summary table

  const sortedCmteTotals = Object.entries(x.cmte_totals).sort((a,b) => b[1] - a[1]);

  var table = document.createElement('table');
  table.setAttribute('id', 'search-results-summary-table');
  table.setAttribute('class', 'tablesorter table-striped2 line-1em w-auto');
  table.setAttribute('align', 'center');
  var thead = table.createTHead();
  var headerRow = thead.insertRow();
  var headerColumns = ['cmte_id', 'cmte_nm', 'total'];

   $("search-results-summary-table").tablesorter({
      headers: {
        2: {
          sorter: 'monetaryValue'
        },
      }
    });
  headerColumns.forEach(columnName => {
    var th = document.createElement('th');
    th.textContent = columnName;
    th.setAttribute('data-sortable', 'true');
    headerRow.appendChild(th);
  });

  searchDiv.appendChild(table);
  var tableBody = table.createTBody();

  sortedCmteTotals.forEach(([cmte_id, total]) => {
    var cmte_nm = x.committees[cmte_id];
    var row = tableBody.insertRow();
    
    //INSERT CELLS
    var c1 = row.insertCell();
    var c2 = row.insertCell();
    var c3 = row.insertCell();

    //SET CONTENT
    c1.textContent = cmte_id;
    c2.textContent = cmte_nm;
    var transactionAmt = parseFloat(total);
    c3.textContent = transactionAmt.toLocaleString('en-US', {
      style: 'currency',
      currency: 'USD',
      maximumFractionDigits: 0
    });
    c3.style.textAlign='right';


  });

  var spacer = "<hr /><h3 align='center'>Results Detail</h3>";
  searchDiv.innerHTML = searchDiv.innerHTML + spacer;

  //draw results table

  var table = document.createElement('table');
  table.setAttribute('id', 'search-results-table');
  table.setAttribute('class', 'tablesorter table-striped');
  var thead = table.createTHead();
  var headerRow = thead.insertRow();
  var headerColumns = ['filing_id', 'date', 'cmte_id', 'cmte_nm', 'name', 'city', 'st', 'zip', 'code', 'purpose', 'amt', 'tran_id'];

   $("search-results-table").tablesorter({
      headers: {
        10: {
          sorter: 'monetaryValue'
        },
      }
    });


  headerColumns.forEach(columnName => {
    var th = document.createElement('th');
    th.textContent = columnName;
    th.setAttribute('data-sortable', 'true');
    headerRow.appendChild(th);
  });

  searchDiv.appendChild(table);
  var tableBody = table.createTBody();

  for (let i = 0; i < x.transactions.length; i++) {
    var t = x.transactions[i];
    var row = tableBody.insertRow();

    //INSERT CELLS
    var c1 = row.insertCell();
    var c2 = row.insertCell();
    var c3 = row.insertCell();
    var c4 = row.insertCell();
    var c5 = row.insertCell();
    var c6 = row.insertCell();
    var c7 = row.insertCell();
    var c8 = row.insertCell();
    var c9 = row.insertCell();
    var c10 = row.insertCell();
    var c11 = row.insertCell();
    var c12 = row.insertCell();


    c1.innerHTML = get_link('calaccess-filing', t.FILING_ID, t.FILING_ID);
    c2.textContent = t.EXPN_DATE;
    c3.innerHTML = get_link('cmlocal', t.FILER_ID, t.FILER_ID);
    c4.innerHTML = get_link('calaccess-redirect', t.FILER_ID, t.FILER_NM);
    c5.textContent = t.NAME;
    c6.textContent = t.PAYEE_CITY;
    c7.textContent = t.PAYEE_ST;
    c8.textContent = t.PAYEE_ZIP4;
    c9.textContent = t.EXPN_CODE;
    c10.textContent = t.EXPN_DSCR;

    var transactionAmt = parseFloat(t.AMOUNT);
    c11.textContent = transactionAmt.toLocaleString('en-US', {
      style: 'currency',
      currency: 'USD',
      maximumFractionDigits: 0
    });
    c11.style.textAlign='right';
    c12.textContent = t.TRAN_ID;
    
    
  }
    $('#search-results-table').DataTable( {
          "paging": false,
          "dom": 'Bfrtip',       
          "buttons": ['copy', 'excel', 'pdf', 'print', 'colvis']
    });
  $('#search-results-table').tablesorter().trigger('update');
}

function draw_netfile(x, type) {
	switch(type) {
		case "contributor":
			draw_netfile_contributor(x);
			break;		
		case "vendor":
			draw_netfile_vendor(x);
			break;
		case "committee":
			draw_netfile_committee(x);
			break;
	}
}

function draw_netfile_contributor(x) {
  //console.log("Running draw_netfile_contributor function");
  //console.log(x);
  const searchDiv = document.getElementById('search-results');

  var grandTotal = parseFloat(x.grand_total).toLocaleString('en-US', {
      style: 'currency',
      currency: 'USD',
      maximumFractionDigits: 0
    });

  searchDiv.innerHTML = "<h2 align='center'>Netfile Contributor Results for <span class='greenme boldme'>" + x.search_name.toUpperCase() + "</h2><h3 align='center'>" + grandTotal + "</h3>";

  //draw summary table

  const sortedCmteTotals = Object.entries(x.cmte_totals).sort((a,b) => b[1] - a[1]);

  var table = document.createElement('table');
  table.setAttribute('id', 'search-results-summary-table');
  table.setAttribute('class', 'tablesorter table-striped2 line-1em w-auto');
  table.setAttribute('align', 'center');
  var thead = table.createTHead();
  var headerRow = thead.insertRow();
  var headerColumns = ['cmte_id', 'cmte_nm', 'total'];

   $("search-results-summary-table").tablesorter({
      headers: {
        2: {
          sorter: 'monetaryValue'
        },
      }
    });
  headerColumns.forEach(columnName => {
    var th = document.createElement('th');
    th.textContent = columnName;
    th.setAttribute('data-sortable', 'true');
    headerRow.appendChild(th);
  });

  searchDiv.appendChild(table);
  var tableBody = table.createTBody();

  sortedCmteTotals.forEach(([cmte_id, total]) => {
    var cmte_nm = x.committees[cmte_id];
    var row = tableBody.insertRow();
    
    //INSERT CELLS
    var c1 = row.insertCell();
    var c2 = row.insertCell();
    var c3 = row.insertCell();

    //SET CONTENT
    c1.textContent = cmte_id;
    c2.textContent = cmte_nm;
    var transactionAmt = parseFloat(total);
    c3.textContent = transactionAmt.toLocaleString('en-US', {
      style: 'currency',
      currency: 'USD',
      maximumFractionDigits: 0
    });
    c3.style.textAlign='right';


  });

  var spacer = "<hr /><h3 align='center'>Results Detail</h3>";
  searchDiv.innerHTML = searchDiv.innerHTML + spacer;


  //draw results table

  var table = document.createElement('table');
  table.setAttribute('id', 'search-results-table');
  table.setAttribute('class', 'tablesorter table-striped');
  var thead = table.createTHead();
  var headerRow = thead.insertRow();
  var headerColumns = ['date', 'juris', 'cmte_id', 'cmte_nm', 'amt', 'name', 'employer', 'occupation', 'city', 'st', 'zip', 'tran_id'];

   $("search-results-table").tablesorter({
      headers: {
        4: {
          sorter: 'monetaryValue'
        },
      }
    });


  headerColumns.forEach(columnName => {
    var th = document.createElement('th');
    th.textContent = columnName;
    th.setAttribute('data-sortable', 'true');
    headerRow.appendChild(th);
  });

  searchDiv.appendChild(table);
  var tableBody = table.createTBody();

  for (let i = 0; i < x.transactions.length; i++) {
    var t = x.transactions[i];
    var cmte_id = t.Filer_ID;
    var cmte_nm = x.committees[cmte_id];
    var row = tableBody.insertRow();

    //INSERT CELLS
    var c1 = row.insertCell();
    var c2 = row.insertCell();
    var c3 = row.insertCell();
    var c4 = row.insertCell();
    var c5 = row.insertCell();
    var c6 = row.insertCell();
    var c7 = row.insertCell();
    var c8 = row.insertCell();
    var c9 = row.insertCell();
    var c10 = row.insertCell();
    var c11 = row.insertCell();
    var c12 = row.insertCell();

    c1.textContent = t.Tran_Date.replace('/', '-');
    c2.textContent = t.verbose;
    c3.innerHTML = get_link('cmlocal', t.Filer_ID, t.Filer_ID);
    c4.textContent = t.Filer_NamL;

    var transactionAmt = parseFloat(t.Tran_Amt1);
    c5.textContent = transactionAmt.toLocaleString('en-US', {
      style: 'currency',
      currency: 'USD',
      maximumFractionDigits: 0
    });
    c5.style.textAlign='right';


    c6.textContent = t.NAME;
    c7.textContent = t.Tran_Emp;
    c8.textContent = t.Tran_Occ;
    c9.textContent = t.Tran_City;
    c10.textContent = t.Tran_State;
    c11.textContent = t.Tran_Zip4;
    c12.textContent = t.Tran_ID;
    
  }
    $('#search-results-table').DataTable( {
          "paging": false,
          "dom": 'Bfrtip',       
          "buttons": ['copy', 'excel', 'pdf', 'print', 'colvis']
    });
  $('#search-results-table').tablesorter().trigger('update');
}

function draw_netfile_vendor(x) {
  //console.log("Running draw_netfile_vendor function");
  //console.log(x);
  const searchDiv = document.getElementById('search-results');

  var grandTotal = parseFloat(x.grand_total).toLocaleString('en-US', {
      style: 'currency',
      currency: 'USD',
      maximumFractionDigits: 0
    });

  searchDiv.innerHTML = "<h2 align='center'>Netfile Vendor Results for <span class='greenme boldme'>" + x.search_name.toUpperCase() + "</h2><h3 align='center'>" + grandTotal + "</h3>";

  //draw summary table

  const sortedCmteTotals = Object.entries(x.cmte_totals).sort((a,b) => b[1] - a[1]);

  var table = document.createElement('table');
  table.setAttribute('id', 'search-results-summary-table');
  table.setAttribute('class', 'tablesorter table-striped2 line-1em w-auto');
  table.setAttribute('align', 'center');
  var thead = table.createTHead();
  var headerRow = thead.insertRow();
  var headerColumns = ['cmte_id', 'cmte_nm', 'total'];

   $("search-results-summary-table").tablesorter({
      headers: {
        2: {
          sorter: 'monetaryValue'
        },
      }
    });
  headerColumns.forEach(columnName => {
    var th = document.createElement('th');
    th.textContent = columnName;
    th.setAttribute('data-sortable', 'true');
    headerRow.appendChild(th);
  });

  searchDiv.appendChild(table);
  var tableBody = table.createTBody();

  sortedCmteTotals.forEach(([cmte_id, total]) => {
    var cmte_nm = x.committees[cmte_id];
    var row = tableBody.insertRow();
    
    //INSERT CELLS
    var c1 = row.insertCell();
    var c2 = row.insertCell();
    var c3 = row.insertCell();

    //SET CONTENT
    c1.textContent = cmte_id;
    c2.textContent = cmte_nm;
    var transactionAmt = parseFloat(total);
    c3.textContent = transactionAmt.toLocaleString('en-US', {
      style: 'currency',
      currency: 'USD',
      maximumFractionDigits: 0
    });
    c3.style.textAlign='right';


  });

  var spacer = "<hr /><h3 align='center'>Results Detail</h3>";
  searchDiv.innerHTML = searchDiv.innerHTML + spacer;

  //draw results table

  var table = document.createElement('table');
  table.setAttribute('id', 'search-results-table');
  table.setAttribute('class', 'tablesorter table-striped');
  var thead = table.createTHead();
  var headerRow = thead.insertRow();
  var headerColumns = ['date', 'juris', 'cmte_id', 'cmte_nm', 'name', 'city', 'st', 'zip', 'code', 'purpose', 'amt', 'tran_id'];

   $("search-results-table").tablesorter({
      headers: {
        10: {
          sorter: 'monetaryValue'
        },
      }
    });


  headerColumns.forEach(columnName => {
    var th = document.createElement('th');
    th.textContent = columnName;
    th.setAttribute('data-sortable', 'true');
    headerRow.appendChild(th);
  });

  searchDiv.appendChild(table);
  var tableBody = table.createTBody();

  for (let i = 0; i < x.transactions.length; i++) {
    var t = x.transactions[i];
    var row = tableBody.insertRow();

    //INSERT CELLS
    var c1 = row.insertCell();
    var c2 = row.insertCell();
    var c3 = row.insertCell();
    var c4 = row.insertCell();
    var c5 = row.insertCell();
    var c6 = row.insertCell();
    var c7 = row.insertCell();
    var c8 = row.insertCell();
    var c9 = row.insertCell();
    var c10 = row.insertCell();
    var c11 = row.insertCell();
    var c12 = row.insertCell();


    c1.textContent = t.Expn_Date.replace('/', '-');
    c2.textContent = t.verbose;
    c3.innerHTML = get_link('cmlocal', t.Filer_ID, t.Filer_ID);
    c4.textContent = t.Filer_NamL;
    c5.textContent = t.NAME;
    c6.textContent = t.Payee_City;
    c7.textContent = t.Payee_State;
    c8.textContent = t.Payee_Zip4;
    c9.textContent = t.Expn_Code;
    c10.textContent = t.Expn_Dscr;

    var transactionAmt = parseFloat(t.Amount);
    c11.textContent = transactionAmt.toLocaleString('en-US', {
      style: 'currency',
      currency: 'USD',
      maximumFractionDigits: 0
    });
    c11.style.textAlign='right';
    c12.textContent = t.Tran_ID;
    
    
  }
    $('#search-results-table').DataTable( {
          "paging": false,
          "dom": 'Bfrtip',       
          "buttons": ['copy', 'excel', 'pdf', 'print', 'colvis']
    });
  $('#search-results-table').tablesorter().trigger('update');
}

function draw_ctb(x, type) {
	switch(type) {
		case "ca_candidate":
			draw_ctb_ca_candidate(x);
			break;		
		case "domain":
			draw_ctb_dns(x);
			break;
	}
}




    function autocompleteHandler(input, name) {
      // Perform autocomplete logic here
      var parts = name.split('-');
      var scope = parts[0];
      var type = parts[1];
      var field = parts[2];

      var prefix = scope + '-' + type;
      //console.log(prefix);
      var formData = populateFormData(prefix, scope, type);
      //console.log(formData);

      var jsonData = JSON.stringify(formData);
      sendAutocompleteData(jsonData);

    }

    function sendAutocompleteData(data) {
      // Perform an AJAX request to the server
      // Here, you can use any AJAX method or library of your choice
      // For example, using jQuery
      //console.log(data);
      //alert('Sending data');
      $.ajax({
        url: 'ctb_multi_autocomplete',
        type: 'GET',
        dataType: 'json',
        data: { q: data },
        success: function(response) {
          // Handle the server response
          $('#hint').empty();
          
          $('#hint').append('<div>' + response.html + '</div>');
          
          //console.log(response.html);
        },
        error: function(xhr, status, error) {
          // Handle error
          console.error(error);
	  //console.log(error);
	  //console.log(status);
        }
      });
    }    

// Attach the formHandler function to the onclick event of each form
var forms = document.querySelectorAll('form');
forms.forEach(function(form) {
  form.addEventListener('submit', formHandler);
  var inputs = form.querySelectorAll('input[type="text"]');
  inputs.forEach(function(input){
    var timer;
    var inputName = input.getAttribute('name');
    input.addEventListener('input', function() {
      clearTimeout(timer);
      timer = setTimeout(function() {
        autocompleteHandler(input, inputName);
      }, 500);
    });
  });
});

var radios = document.querySelectorAll('input[type=radio][name="netfile-committee-juris"]');
radios.forEach(radio => radio.addEventListener('change', () => toggleNetfileDropdown(radio.value)));


function toggleNetfileDropdown(type) {
  if(type==='city') {
    $('#netfile-committee-city_dropdown').show();
    $('#netfile-committee-county_dropdown').hide();
    $('select[name="netfile-committee-county"]').prop('selectedIndex',0);
    //console.log('Reset County Value');
  } else {
    $('#netfile-committee-city_dropdown').hide();
    $('#netfile-committee-county_dropdown').show();
    $('select[name="netfile-committee-city"]').prop('selectedIndex',0);
    //console.log('Reset City Value');
  }
}


function populateFormData(prefix, scope, type) {

      try{
        var name = document.getElementById(prefix + '-name').value;
      }catch(e){
        //console.log(e);
      } 

      try{
        var namf = document.getElementById(prefix + '-namf').value;
      }catch(e){
        //console.log(e);
      } 

      try{
        var naml = document.getElementById(prefix + '-naml').value;
      }catch(e){
        //console.log(e);
      } 


      try{
        var city = document.getElementById(prefix + '-city').value;
      }catch(e){
        //console.log(e);
      } 

      try{
        var state = document.getElementById(prefix + '-state').value;
      }catch(e){
        //console.log(e);
      } 

      try{
        var zip = document.getElementById(prefix + '-zip').value;
      }catch(e){
        //console.log(e);
      } 

      try{
        var county = document.getElementById(prefix + '-county').value;
      }catch(e){
        //console.log(e);
      } 

      try{
        var start = document.getElementById(prefix + '-start').value;
      }catch(e){
        //console.log(e);
      } 
      try{
        var end = document.getElementById(prefix + '-end').value;
      }catch(e){
        //console.log(e);
      } 
      try{
        var cmte_id = document.getElementById(prefix + '-cmte_id').value;
      }catch(e){
        //console.log(e);
      }            

      try{
        var type_cand = document.getElementById(prefix + '-type_cand').checked;
      }catch(e){
        //console.log(e);
      } 

      try{
        var type_cmte = document.getElementById(prefix + '-type_cmte').checked;
      }catch(e){
        //console.log(e);
      } 
      try{
        var type_donor = document.getElementById(prefix + '-type_donor').checked;
      }catch(e){
        //console.log(e);
      } 
      try{
        var type_firm = document.getElementById(prefix + '-type_firm').checked;
      }catch(e){
        //console.log(e);
      } 
      try{
        var type_client = document.getElementById(prefix + '-type_client').checked;
      }catch(e){
        //console.log(e);
      } 
      try{
        var type_emp = document.getElementById(prefix + '-type_emp').checked;
      }catch(e){
        //console.log(e);
      } 
      try{
        var type_lobby = document.getElementById(prefix + '-type_lobby').checked;
      }catch(e){
        //console.log(e);
      }                                     

      var formData = {
        scope: scope,
        type: type,
        name: name,
        namf: namf,
        naml: naml,
        city: city,
        state: state,
        zip: zip,
        county: county,
        start: start,
        end: end,
        cmte_id: cmte_id,
        type_cand: type_cand,
        type_cmte: type_cmte,
        type_donor: type_donor,
        type_firm: type_firm,
        type_client: type_client,
        type_emp: type_emp,
        type_lobby: type_lobby

      };

      return formData;

}

function get_link(type, id, text) {
  switch(type) {
    case "fec-image":
      return "<a href='https://docquery.fec.gov/cgi-bin/fecimg/?" + id + "' target='_blank'>" + text + "</a>";
      break;
    case "fec-cand":
      return "<a href='https://www.fec.gov/data/candidate/" + id + "/?tab=filings' target='_blank'>" + text + "</a>";
      break;
    case "fec-cmte":
      return "<a href='https://www.fec.gov/data/committee/" + id + "/?tab=filings' target='_blank'>" + text + "</a>";
      break;
    case "fec-filing":
      return "<a href='https://docquery.fec.gov/cgi-bin/forms/" + id + "' target='_blank'>" + text + "</a>";
      break;
    case "ctb-fec-all":
      return "<a href='https://californiatargetbook.com/ctb-legacy/getfedfilings.php?id=" + id + "' target='_blank'>" + text + "</a>";
      break;
    case "ctb-f3":
      return "<a href='https://californiatargetbook.com/book/fec_f3/" + id + "' target='_blank'>" + text + "</a>";
      break;
    case "ctb-ie":
      return "<a href='https://californiatargetbook.com/ctb-legacy/iedetail.php?id=" + id + "' target='_blank'>" + text + "</a>";
      break;
    case "ctb-dist-old":
      return "<a href='https://californiatargetbook.com/book/old/" + id + "' target='_blank'>" + text + "</a>";
      break;
    case "ctb-dist":
      return "<a href='https://californiatargetbook.com/book/new/" + id + "' target='_blank'>" + text + "</a>";
      break;
    case "ctb-fed-dist":
      return "<a href='https://californiatargetbook.com/book/us/" + id + "' target='_blank'>" + text + "</a>";
      break;
    case "calaccess-filing":
      return "<a href='https://cal-access.sos.ca.gov/PDFGen/pdfgen.prg?filingid=" + id + "' target='_blank'>" + text + "</a>";
      break;
    case "calaccess-cand":
      return "<a href='http://cal-access.sos.ca.gov/Campaign/Candidates/Detail.aspx?id=" + id + "' target='_blank'>" + text + "</a>";
      break;
    case "calaccess-cmte":
      return "<a href='http://cal-access.sos.ca.gov/Campaign/Committees/Detail.aspx?id=" + id + "' target='_blank'>" + text + "</a>";
      break;
    case "calaccess-info":
      return "<a href='http://cal-access.sos.ca.gov/Lobbying/Employers/Detail.aspx?id=" + id + "' target='_blank'>" + text + "</a>";
      break;
    case "cmlocal":
      return "<a href='https://californiatargetbook.com/ctb-legacy/cmlocal2.php?id=" + id + "' target='_blank'>" + text + "</a>";
      break;
    case "calaccess-redirect":
      return "<a href='http://cal-access.sos.ca.gov/Misc/redirector.aspx?id=" + id + "' target='_blank'>" + text + "</a>";
      break;

  }
}

  </script>      

@endsection

@section('styles')


<!--

                                                         
        CCCCCCCCCCCCC  SSSSSSSSSSSSSSS   SSSSSSSSSSSSSSS 
     CCC::::::::::::CSS:::::::::::::::SSS:::::::::::::::S
   CC:::::::::::::::S:::::SSSSSS::::::S:::::SSSSSS::::::S
  C:::::CCCCCCCC::::S:::::S     SSSSSSS:::::S     SSSSSSS
 C:::::C       CCCCCS:::::S           S:::::S            
C:::::C             S:::::S           S:::::S            
C:::::C              S::::SSSS         S::::SSSS         
C:::::C               SS::::::SSSSS     SS::::::SSSSS    
C:::::C                 SSS::::::::SS     SSS::::::::SS  
C:::::C                    SSSSSS::::S       SSSSSS::::S 
C:::::C                         S:::::S           S:::::S
 C:::::C       CCCCCC           S:::::S           S:::::S
  C:::::CCCCCCCC::::SSSSSSS     S:::::SSSSSSS     S:::::S
   CC:::::::::::::::S::::::SSSSSS:::::S::::::SSSSSS:::::S
     CCC::::::::::::S:::::::::::::::SSS:::::::::::::::SS 
        CCCCCCCCCCCCCSSSSSSSSSSSSSSS   SSSSSSSSSSSSSSS   
                                                         

-->
  <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/cr-1.6.1/fh-3.3.1/r-2.4.0/datatables.min.css"/>

  <style>

    @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Blinker&display=swap');

  .border-red {
	border: 2px solid red;
   }

  .border-blue {
	border: 2px solid blue;
   }

  .border-orange {
	border: 2px solid orange;
   }

  .border-purple {
	border: 2px solid purple;
   }

  .border-green {
	border: 2px solid green;
   }

   .greenme {
	color: green;
   }

   .boldme {
	font-weight: bold;
   }

   table, th, tr, td {
	font-family: 'Lato';
	font-size: 0.95em;
	line-height: 1em;
   }
   th {
	background-color: black;
	color: white;
	font-weight: bold;
    }
    td, th {
	padding-left: 3px;
	padding-right: 3px;
     }

  h4 {
    margin-top: 15px;
    font-variant: small-caps;
    font-family: 'Blinker';
  }

   #search-results-table th {
	color: white !important;
   }
   .tablesorter-header-inner {
	color: white !important;
   }

    .line-1em {
        line-height: 1.1em !important;
    }

    .table-striped2 tbody > tr:nth-of-type(odd) {
      background-color: #f9f9f9;
    }

.table-striped2 thead > tr > th,
.table-striped2 thead > tr > td,
.table-striped2 tbody > tr > th,
.table-striped2 tbody > tr > td,
.table-striped2 tfoot > tr > th,
.table-striped2 tfoot > tr > td {
  padding-left: 3px;
  padding-right: 3px;
  vertical-align: top;
  border-top: 1px solid #ddd;
}

body {
 	background-color: white  !important;
}

   </style>
  

@endsection
