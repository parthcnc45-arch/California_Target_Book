@extends('layouts.book')
@php ($book_side_nav_active = 'redist')

@section('title', 'Redistricting Commissioners | California Target Book')

@section('content')

    <send-message-modal
            v-if="sendMessageModalTo"
            :to="sendMessageModalTo"
            @close="sendMessageModalTo = null">
    </send-message-modal>

    <div class="container mt-lg">

        <div class="row">
            <div class="col-xs-12">
                <div class="m-n panel about-panel">
                    <div class="panel-heading">
                        <h2 class="text-center">California Redistricting Commission</h2>
                        <hr class="red" />
                    </div>
                    <div class="panel-body">
                            <p>
                                California's Reidstricting Commission will ultimately be composed of fourteen members comprised of five Democrats, five Republicans, and four members belonging to neither party. 
			    </p>
			    <p>In late June, the California legislature approved the final pool of <a href='http://shapecaliforniasfuture.auditor.ca.gov/pdfs/remaining_applicants_20200626.pdf' target='_blank'>35 eligible candidates</a>. The first eight commissioners were selected on July 2nd, three Republicans, three Democrats, and two No Party Preference members chosen at random from their respective sub-pools.</p>
			    <p>
				The eight commissioners are tasked with choosing the remaining six members.                            
			</p>
                        </div>
                </div>
            </div>
        </div>


        <div class="row"> <!--BEGIN COMMISSIONER DIV -->
            <div class="col-xs-12">
                <div class="m-n panel about-panel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="media">
                                    <img src="../img/IsraAhmad.jpg" width="150" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-heading">
                                <h2>Isra Ahmad</h2>
                                <h3 class="sub upper text-red mt-sm">No Party Preference - San Jose - Female - Other Asian -$75,000 - $124,999</h3>
                            </div>
                            <div class="panel-body">
                                <p>
                                    ISRA AHMAD (NPP), 29, has worked as a health planning/research and evaluation specialist for the <a href='https://transparentcalifornia.com/salaries/search/?q=Isra+Ahmad' target='_blank'>Santa Clara County Public Health Department</a> since 2016. After earning her associate's at De Anza Community College in 2011, she earned her bachelor's in health science from San Jose State University in 2013 and a master's in epidemiology and biostatistics from UC-Berkeley in 2016. She resides in San Jose.
                                </p>
				<p align='center'>
					<a href='https://www.sccgov.org/sites/esj/about-us/Pages/IsraAhmad.aspx' target='_blank'>PROFESSIONAL</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://applications.shapecaliforniasfuture.auditor.ca.gov/application/17733.html' target='_blank'>APPLICATION</a>
				</p>
			
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- END COMMISSIONER DIV -->

        <div class="row"> <!--BEGIN COMMISSIONER DIV -->
            <div class="col-xs-12">
                <div class="m-n panel about-panel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="media">
                                    <img src="../img/JaneAndersen.jpg" width="150" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-heading">
                                <h2>Jane Andersen</h2>
                                <h3 class="sub upper text-red mt-sm">Republican - Berkeley - Female - White - $250,000+</h3>
                            </div>
                            <div class="panel-body">
                                <p>
                                    JANE MARIE ANDERSEN (R), 60, is a semi-retired structural engineer. She earned her bachelor's in civil engineering from University of Notre Dame in 1981 and completed a master's in structural engineering and structural mechanics from UC-Berkeley in 1982. She worked as a civil engineer for Toft & deNevers Structural Engineering from 1983 to 1982 and as a structural engineer for Wiss, Janney, Elstner Associates from 1988 to 1995. She served two terms on the Structural Engineers Association of Northern California. She resides in Berkeley.
                                </p>
				<p align='center'>
					<a href='https://applications.shapecaliforniasfuture.auditor.ca.gov/application/20496.html' target='_blank'>APPLICATION</a>
				</p>
			
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- END COMMISSIONER DIV -->

        <div class="row"> <!--BEGIN COMMISSIONER DIV -->
            <div class="col-xs-12">
                <div class="m-n panel about-panel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="media">
                                    <img src="../img/NealFornaciari.jpg" width="150" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-heading">
                                <h2>Neal Fornaciari</h2>
                                <h3 class="sub upper text-red mt-sm">Republican - Tracy - Male - White - $75,000 - $124,999</h3>
                            </div>
                            <div class="panel-body">
                                <p>
                                    NEAL FORNACIARI (R), 57, is a retired mechanical engineer who worked for Sandia National Laboratories for 27 years, most recently working as a senior manager for its Mission Business Solutions division from 2012 to 2017 and as a manger in the thermal/fluids science and engineering department from 2009 to 2012. He earned his bachelor's in mechanical engineering in 1990, his master's in mechanical engineering in 1992, and an MBA in 2014, all from UC-Berkeley. He served as foreman of the San Joaquin County Cicil Grand Jury from July 2018 to June 2019, has lectured at UC-Berkeley, and currently is the principal at Fornaciari and Company Consultants. He resides in Tracy.
                                </p>
				<p align='center'>
					<a href='https://www.linkedin.com/in/nealf/' target='_blank'>LINKEDIN</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://www.facebook.com/neal.fornaciari' target='_blank'>FACEBOOK</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://applications.shapecaliforniasfuture.auditor.ca.gov/application/7806.html' target='_blank'>APPLICATION</a>

				</p>			
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- END COMMISSIONER DIV -->

        <div class="row"> <!--BEGIN COMMISSIONER DIV -->
            <div class="col-xs-12">
                <div class="m-n panel about-panel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="media">
                                    <img src="../img/JRayKennedy.jpg" width="150" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-heading">
                                <h2>J. Ray Kennedy</h2>
                                <h3 class="sub upper text-red mt-sm">Democratic - Morongo Valley - Male - White - $75,000 - $124,999</h3>
                            </div>
                            <div class="panel-body">
                                <p>
                                    JAMES (J). RAY KENNEDY (D), 57, spent nearly thirty years as an elections professional, serving as director at the International Foundation for Electoral Systems from 1990 to 2000 and as a senior electoral expert for the United Nations from 2000 to 2017. He has done work for The Carter Center and consulted for Conflic Dynamics International and International IDEA. A California resident for 15 years, he worked as a senior management analyst for the Valley Sanitary District for six months in 2016 and co-oorganized international electoin observer visits to Riverside and L.A. County between 2012 and 2016.  He earned a bachelor's in economics from University of Virginia in 1980, a master's in Latin American Studies and international economics from Johns Hopkins in 1984, a Ph.D. in Latin American Studies from Johns Hopkins in 2000, and holds a certificate in international disability law from National University of Ireland. He resides in Morongo Valley.
                                </p>
				<p align='center'>
					<a href='https://www.linkedin.com/in/ray-kennedy-37b1854b/' target='_blank'>LINKEDIN</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://www.facebook.com/ray.kennedy.3726' target='_blank'>FACEBOOK</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://applications.shapecaliforniasfuture.auditor.ca.gov/application/3710.html' target='_blank'>APPLICATION</a>

				</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- END COMMISSIONER DIV -->


       
        <div class="row"> <!--BEGIN COMMISSIONER DIV -->
            <div class="col-xs-12">
                <div class="m-n panel about-panel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="media">
                                    <img src="../img/AntonioLeMons.jpg" width="150" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-heading">
                                <h2>Antonio Le Mons</h2>
                                <h3 class="sub upper text-red mt-sm">No Party Preference - Toluca Lake - Male - Black -$125,000 - $250,000</h3>
                            </div>
                            <div class="panel-body">
                                <p>
                                    ANONIO LE MONS (NPP), 57, is a clinical therapist, nonprofit executive, and personal coach. He earned his bachelor's in telecommunications from Michigan State University in 1986, later obtaining a master's in clinical and community psychology from Antioch University in 2006. He worked for the Los Angeles Lesbian and Gay Center from 1994 to 2005, serving as VP of Prevention Services from 1994 to 1997 and as Deputy Director from 1997 to 2005. From 2005 to 2007 he was VP of corporate oversight for Voices, Inc, a marketing and communications firm. He joined the FAME Assistance Corporation in 2008, serving as director of transportation from 2008 to 2009 and as executive VP of operations from 2009 to 2013. Since 2016 he has been its senior VP of strategic initiatives. He has also been the principal at Antonio Le Mons Coaching and Consulting since 2012. A resident of California for 33 years, out member of the LGBT community, and parent to two Latinx sons, he resides in Toluca Lake.
                                </p>

				<p align='center'>
					<a href='https://twitter.com/PassionCzar' target='_blank'>TWITTER</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://www.facebook.com/antonio.passionczar' target='_blank'>FACEBOOK</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://antoniolemons.com/' target='_blank'>PERSONAL</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://applications.shapecaliforniasfuture.auditor.ca.gov/application/16977.html' target='_blank'>APPLICATION</a>

				</p>			
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- END COMMISSIONER DIV -->

        <div class="row"> <!--BEGIN COMMISSIONER DIV -->
            <div class="col-xs-12">
                <div class="m-n panel about-panel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="media">
                                    <img src="../img/SaraSadhwani.jpg" width="150" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-heading">
                                <h2>Sara Sadhwani</h2>
                                <h3 class="sub upper text-red mt-sm">Democratic - La Canada Flintridge - Female - Asian Indian - $250,000+</h3>
                            </div>
                            <div class="panel-body">
                                <p>
                                    SARA SADHWANI (D), 39, is a political science professor at Cal Lutheran University. She previouusly worked as an adjunct lecutrer and visitng instructor at Pomona College from 							2017 to 2019, and as an adjunct professor at Glendale Community College in 2016. The daughter of immigrants, she was born and 						raised in the Rust Belt, earning a bachelor's in politics and philosophy from University of Pittsburg in 2002, a master's in international development from University of Pittsburg 						in 2005, and a Ph.D in political science from University of Southern California, her dissertation focusing on the variations in voting behavior between Asian Americans and Latinos.                                
				</p>

				<p align='center'>
					<a href='https://twitter.com/sarasadhwani' target='_blank'>TWITTER</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://www.facebook.com/sara.sadhwani' target='_blank'>FACEBOOK</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://sarasadhwani.com/' target='_blank'>PERSONAL</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://applications.shapecaliforniasfuture.auditor.ca.gov/application/7164.html' target='_blank'>APPLICATION</a>
				</p>			
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- END COMMISSIONER DIV -->


        <div class="row"> <!--BEGIN COMMISSIONER DIV -->
            <div class="col-xs-12">
                <div class="m-n panel about-panel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="media">
                                    <img src="../img/DerricTaylor.jpg" width="150" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-heading">
                                <h2>Derric Taylor</h2>
                                <h3 class="sub upper text-red mt-sm">Republican - Los Angeles - Republican - Male - Black - $250,000+</h3>
                            </div>
                            <div class="panel-body">
                                <p>
                                    DERRIC TAYLOR (R), 50, is a <a href='https://transparentcalifornia.com/salaries/search/?q=Derric+Taylor' target='_blank'>Los Angeles County Deputy Sheriff</a> who has been with the department for nearly 25 years. He earned a bachelor's in accounting from Morehouse College in 1993 and a master's in criminology from UC-Irvine in 2019. He resides in Altadena with his wife, Peggy, who is president of the Soroptimist International of Altadena-Pasadena.
                                </p>

				<p align='center'>
					<a href='https://twitter.com/dtracerx' target='_blank'>TWITTER</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://www.facebook.com/dtracerx' target='_blank'>FACEBOOK</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://www.pinterest.ie/dtracerx/' target='_blank'>PINTEREST</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://applications.shapecaliforniasfuture.auditor.ca.gov/application/21705.html' target='_blank'>APPLICATION</a>
				</p>				
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- END COMMISSIONER DIV -->


        <div class="row"> <!--BEGIN COMMISSIONER DIV -->
            <div class="col-xs-12">
                <div class="m-n panel about-panel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="media">
                                    <img src="../img/TrenaTurner.jpg" width="150" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-heading">
                                <h2>Trena Turner</h2>
                                <h3 class="sub upper text-red mt-sm">Democratic - Stockton - Female - Black - $125,000 - $250,000</h3>
                            </div>
                            <div class="panel-body">
                                <p>
                                    TRENA TURNER (D), 59, is executive director of Faith In The Valley, a and has been the executive pastor at Victory In Praise Church since 2007. She previously worked for AT&T for over 25 years as an associate director. She earned a bachelor's in business administation from American InterContinental University in 2006.
                                </p>
				<p align='center'>
					<a href='https://twitter.com/LadyTrenaTurner' target='_blank'>TWITTER</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://www.facebook.com/trena.turner' target='_blank'>FACEBOOK</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://faithinthevalley.org/staff-member/trena-turner/' target='_blank'>PROFESSIONAL</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://applications.shapecaliforniasfuture.auditor.ca.gov/application/7656.html' target='_blank'>APPLICATION</a>
				</p>
			
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- END COMMISSIONER DIV -->


       <div class="row"> <!--BEGIN COMMISSIONER DIV -->
            <div class="col-xs-12">
                <div class="m-n panel about-panel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="media">
                                    <img src="../img/LindaAkutagawa.jpg" width="150" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-heading">
                                <h2>Linda Akutagawa</h2>
                                <h3 class="sub upper text-red mt-sm">No Party Preference - Huntington Beach - Female - Japanese -$125,000 - $250,000</h3>
                            </div>
                            <div class="panel-body">
                                <p>COMING SOON

                                </p>
				<p align='center'>
					<a href='https://www.leap.org/linda-akutagawa' target='_blank'>PROFESSIONAL</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://www.linkedin.com/in/lakutagawa/' target='_blank'>LINKEDIN</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://www.facebook.com/linda.akutagawa' target='_blank'>FACEBOOK</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://applications.shapecaliforniasfuture.auditor.ca.gov/application/22971.html' target='_blank'>APPLICATION</a>
				</p>
			
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- END COMMISSIONER DIV -->

       <div class="row"> <!--BEGIN COMMISSIONER DIV -->
            <div class="col-xs-12">
                <div class="m-n panel about-panel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="media">
                                    <img src="../img/AliciaFernandez.jpg" width="150" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-heading">
                                <h2>Alicia Fernandez</h2>
                                <h3 class="sub upper text-red mt-sm">Republican - Clarksburg - Mexican - Female - $125,000 - $250,000</h3>
                            </div>
                            <div class="panel-body">
                                <p>COMING SOON

                                </p>
				<p align='center'>
					<a href='https://rdusd-ca.schoolloop.com/Board' target='_blank'>PROFESSIONAL</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://applications.shapecaliforniasfuture.auditor.ca.gov/application/12652.html' target='_blank'>APPLICATION</a>
				</p>
			
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- END COMMISSIONER DIV -->

       <div class="row"> <!--BEGIN COMMISSIONER DIV -->
            <div class="col-xs-12">
                <div class="m-n panel about-panel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="media">
                                    <img src="../img/PatriciaSinay.jpg" width="150" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-heading">
                                <h2>Patricia Sinay</h2>
                                <h3 class="sub upper text-red mt-sm">Democratic - Encinitas - Other Latino - Female - $125,000 - $250,000</h3>
                            </div>
                            <div class="panel-body">
                                <p>COMING SOON

                                </p>
				<p align='center'>
					<a href='https://www.linkedin.com/in/patricia-sinay/' target='_blank'>LINKEDIN</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://twitter.com/patricia_sinay' target='_blank'>TWITTER</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://applications.shapecaliforniasfuture.auditor.ca.gov/application/1602.html' target='_blank'>APPLICATION</a>
				</p>
			
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- END COMMISSIONER DIV -->

       <div class="row"> <!--BEGIN COMMISSIONER DIV -->
            <div class="col-xs-12">
                <div class="m-n panel about-panel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="media">
                                    <img src="../img/PedroToledo.jpg" width="150" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-heading">
                                <h2>Pedro Toledo</h2>
                                <h3 class="sub upper text-red mt-sm">No Party Preference - Petaluma - Mexican - Male - $125,000 - $250,000</h3>
                            </div>
                            <div class="panel-body">
                                <p>COMING SOON

                                </p>
				<p align='center'>
					<a href='https://phealthcenter.org/about-us/who-we-are/management-staff/' target='_blank'>PROFESSIONAL</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://www.linkedin.com/in/pedrotoledo/' target='_blank'>LINKEDIN</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://twitter.com/pedrotoledo' target='_blank'>TWITTER</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://www.facebook.com/pedro.toledo.1656' target='_blank'>FACEBOOK</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;		
					<a href='https://applications.shapecaliforniasfuture.auditor.ca.gov/application/12677.html' target='_blank'>APPLICATION</a>
				</p>
			
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- END COMMISSIONER DIV -->

       <div class="row"> <!--BEGIN COMMISSIONER DIV -->
            <div class="col-xs-12">
                <div class="m-n panel about-panel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="media">
                                    <img src="../img/AngelaVazquez.jpg" width="150" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-heading">
                                <h2>Angela Vazquez</h2>
                                <h3 class="sub upper text-red mt-sm">Democratic - Los Angeles - Mexican - Female - $125,000 - $250,000</h3>
                            </div>
                            <div class="panel-body">
                                <p>COMING SOON

                                </p>
				<p align='center'>
					<a href='https://childrenspartnership.org/about/our-team/' target='_blank'>PROFESSIONAL</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://www.linkedin.com/in/angmvazquez/' target='_blank'>LINKEDIN</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://applications.shapecaliforniasfuture.auditor.ca.gov/application/15239.html' target='_blank'>APPLICATION</a>
				</p>
			
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- END COMMISSIONER DIV -->

       <div class="row"> <!--BEGIN COMMISSIONER DIV -->
            <div class="col-xs-12">
                <div class="m-n panel about-panel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="media">
                                    <img src="../img/RussellYee.jpg" width="150" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-heading">
                                <h2>Russell Yee</h2>
                                <h3 class="sub upper text-red mt-sm">Republican - Oakland - Chinese - Male - $125,000 - $250,000</h3>
                            </div>
                            <div class="panel-body">
                                <p>COMING SOON

                                </p>
				<p align='center'>
					<a href='https://healthychurchleaders.net/who-we-are/russell-yee/' target='_blank'>PROFESSIONAL</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://www.judsonpress.com/Author/Default.aspx?AuthorID=151837' target='_blank'>BOOKS</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://www.linkedin.com/in/russell-yee-067a1944/' target='_blank'>LINKEDIN</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://russellyee.wordpress.com/' target='_blank'>PERSONAL</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='https://applications.shapecaliforniasfuture.auditor.ca.gov/application/11312.html' target='_blank'>APPLICATION</a>
				</p>
			
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- END COMMISSIONER DIV -->







    </div>


@endsection

@section("scripts")

    <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    <script>

      $(window).on('load resize', function () {
        if ($(this).width() < 640) {
          $('table tfoot').hide();
        } else {
          $('table tfoot').show();
        }
      });

    </script>

@endsection



@section('styles')
<style>


    .panel img {
        border-radius: 0;
        border: 1px solid #dadada;
        width: 100%;
        max-width: 280px;
    }
    .row {
        margin-bottom: 40px;
    }

    .panel p {
        text-align: justify;
    }

    hr {
        border-width: 3px;
    }

    .red {
        border-color: red;
    }
</style>
@endsection
