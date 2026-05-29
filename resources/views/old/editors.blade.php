
@extends('layouts.master')

@section('title', 'About Us | California Target Book')

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
                        <h2 class="text-center">About Us</h2>
                        <hr class="red" />
                    </div>
                    <div class="panel-body">
                            <p>
                                Why do so many of California’s major corporations, labor
                                unions, professional trade associations, political action
                                committees (PACs), broadcast and print media, universities
                                and libraries, along with elected officials, legislative
                                advocates, political consultants and pollsters subscribe to
                                the California Target Book?
                            </p>
                            <p>
                                Established in 1993, the California Target Book gives
                                non-partisan, unbiased information to all who want to be
                                kept fully informed and up-to-date on congressional and
                                state legislative election campaigns in California. The
                                online edition includes a comprehensive set of tools for
                                keeping up-to-date on every aspect of California's political
                                system.
                            </p>
                        </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12">
                <div class="m-n panel about-panel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="media">
                                    <img src="../img/darry_sragow.gif" width="250" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-heading">
                                <h2>Darry Sragow</h2>
                                <h3 class="sub upper text-red mt-sm">Publisher</h3>

                                <a class="contact-link" @click="sendMessageModalTo = 'Darry'">
                                    Send Message
                                </a>
                            </div>
                            <div class="panel-body">
                                <p>
                                    Darry Sragow is a veteran Democratic political strategist
                                    and attorney. From 1996 through 2002, he was the chief
                                    campaign advisor for the Assembly Democratic Caucus,
                                    reporting directly to the Speaker of the Assembly. He also
                                    served as campaign manager for five statewide races in
                                    California, three for governor, and two for the U.S.
                                    Senate, and managed a number of school and community
                                    college bond campaigns. He is currently Senior Counsel
                                    with the international law firm Dentons, and for eight
                                    years served as the Managing Partner of the Los Angeles
                                    office. He is in his eighteenth year teaching
                                    undergraduate political science, previously at the
                                    University of California, Berkeley, and currently at the
                                    University of Southern California.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="m-n panel about-panel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="media">
                                    <img src="../img/rob_pyers.jpg" width="250" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-heading">
                                <h2>Rob Pyers</h2>
                                <h3 class="sub upper text-red mt-sm">Research Director</h3>
                                <a class="contact-link" @click="sendMessageModalTo = 'Rob'">
                                    Send Message
                                </a>
                                <a href="https://twitter.com/rpyers" class="twitter-follow-button"
                                        data-show-count="false">Follow @rpyers</a>
                            </div>
                            <div class="panel-body">
                                <p>
                                    Rob Pyers began his involvement with the Target Book in
                                    2015, tasked with increasing the amount of data available
                                    for online subscribers. Under his direction, the Target
                                    Book's databases have grown to include precinct-level
                                    voting data, FEC contribution data for all California
                                    federal candidates, legislator voting records, real-time
                                    campaign contribution and independent expenditure data for
                                    California legislative candidates, live election returns,
                                    and a growing amount of census data and voter registration
                                    information. Born and raised in Florida, he studied
                                    English and Political Science at Florida State and
                                    Washington & Lee University, and has called the Golden
                                    State his home since 2003.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="m-n panel about-panel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="media">
                                    <img src="../img/tom_shortridge.png" width="250" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-heading">
                                <h2>Tom Shortridge</h2>
                                <h3 class="sub upper text-red mt-sm">Associate Publisher</h3>
                                <a class="contact-link" @click="sendMessageModalTo = 'Tom'">
                                    Send Message
                                </a>
                            </div>
                            <div class="panel-body">
                                <p>
                                    Tom Shortridge has
                                    been working in California politics for over 25 years,
                                    including several years serving as the chief district
                                    representative for a Republican Assembly Member. He has
                                    managed scores of campaigns for city council and special
                                    districts. He currently serves as a consultant to the
                                    Torrance Chamber of Commerce Political Action Committee.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="m-n panel about-panel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="media">
                                    <!--<img src="../img/tony_quinn.jpg" width="250" />-->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-heading">
                                <h2>Tony Quinn, Ph.D.</h2>
                                <h3 class="sub upper text-red mt-sm mb-lg">Senior Editor</h3>
                            </div>
                            <div class="panel-body">
                                <p>
                                    Dr. Tony Quinn is an authority on California political
                                    trends and demographics. He served on the Assembly
                                    Republican redistricting staff in both the 1971 and 1981
                                    reapportionments and advised Los Angeles County on the
                                    1991 redistricting. He has been an expert witness in
                                    several redistricting lawsuits. He served three years as
                                    an assistant to the California Attorney General, is a
                                    former director of the Office of Economic Research in the
                                    Department of Commerce, and for five years served as a
                                    member of the California Fair Political Practices
                                    Commission. Dr. Quinn has written extensively on
                                    California politics and elections, recent articles having
                                    appeared on Fox and Hounds and in the Capitol Morning
                                    Report.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


       
        <div class="row">
            <div class="col-xs-12">
                <div class="m-n panel about-panel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="media">
                                    <img src="/img/Marva_Diaz.jpeg" alt="Marva Diaz" width="250" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-heading">
                                <h2>Marva Diaz</h2>
                                <h3 class="sub upper text-red mt-sm mb-lg">Editor</h3>
                            </div>
                            <div class="panel-body">
                                <p>
                                    Marva Diaz is a public affairs and government relations professional with 23 years of experience in both the public and private sectors.
                                </p>
                                <p>
                                     Marva specializes in California politics to effect change on the local and statewide levels by utilizing issue advocacy and campaign tactics. Marva’s 12 years of experience in leadership roles while working in the State Legislature has resulted in the successful passage of hundreds of bills passed by the Legislature and signed by Governors. Her work with leaders in the State Assembly and the State Senate has given her the opportunity to work in almost every county in California. She also managed the political affairs program for a prominent business association, and collaborated on the strategic planning for over 600 campaigns in dozens of states, ranging from internal corporate campaigns to ballot propositions, and from school board races to presidential campaigns.
                                </p>
                                <p>
                                    In her marketing and brand development background, Marva drafted a business plan for the creation of Black Eagle Wines. The wine was produced from grapes picked by the United Farm Workers (UFW) and the sale of each bottle sent dollars back to the UFW for organizing.
                                </p>
                                <p>
                                    Marva graduated from the University of California at Davis with a B.A. in Economics, with an emphasis on Political Science.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="m-n panel about-panel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="media">
                                    <img src="/img/Marty_Wilson.jpeg" alt="Marty Wilson" width="250" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-heading">
                                <h2>Marty Wilson</h2>
                                <h3 class="sub upper text-red mt-sm mb-lg">Editor</h3>
                            </div>
                            <div class="panel-body">
                                <p>
                                    Marty Wilson is the executive vice president of public affairs for the California Chamber of Commerce, a position he has held for more than four years.
                                </p>
                                <p>
                                    Wilson oversees all of the CalChamber’s public affairs activities, including the Public Affairs Council, a political advisory committee made up of the CalChamber’s major members; its candidate recruitment and support program; and its political action committees: ChamberPAC, which supports pro-jobs candidates and legislators, and CalBusPAC, which qualifies, supports and/or opposes ballot initiatives. He also serves as the CalChamber liaison to JobsPAC, an employer-based independent committee that supports pro-jobs candidates.
                                </p>
                                <p>
                                    Wilson has almost 40-years of experience in California politics, playing leadership roles in the election and re-election of two governors and a U.S. senator. He also has orchestrated numerous successful ballot measure and public affairs campaigns.
                                </p>
                                <p>
                                    In addition to his campaign experience, Wilson has served in government as a senior staff member at the local, state and federal levels.
                                </p>
                                <p>
                                    Before joining the CalChamber, Wilson spent seven years as managing partner of Wilson-Miller Communications, where he also advised Governor Arnold Schwarzenegger as head of the Governor’s political and initiative committee, the California Recovery Team.
                                </p>
                                <p>
                                    Before founding his own firm, Wilson was managing director for Public Strategies Inc. in Sacramento for five years and held a similar position with Burson-Marsteller for six years.
                                </p>
                                <p>
                                    Wilson has served as senior fellow for the University of California, Los Angeles School of Public Affairs, board member for the California State Fair and director of the Coro Foundation, a public affairs training organization.
                                </p>
                                <p>
                                    He graduated from San Diego State University with a B.A. in history.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12">
                <div class="m-n panel about-panel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="media">
                                    <img src="../img/roxanne_connelly.jpg" width="250" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-heading">
                                <h2>Roxanne Connelly</h2>
                                <h3 class="sub upper text-red mt-sm">Administrative Director</h3>
                                <a class="contact-link" @click="sendMessageModalTo = 'Roxanne'">
                                    Send Message
                                </a>
                            </div>
                            <div class="panel-body">
                                <p>
                                    Roxanne Connelly joined the Target Book in 2017 to oversee
                                    and provide administrative functions and provide support
                                    to the Target Book team. She has more than two decades of
                                    administrative and accounting experience and has worked
                                    closely with Darry Sragow for most of that time.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <hr/>

        <div class="row">
            <div class="col-xs-12">
                <div class="m-n panel about-panel panel-accent">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="media">
                                    <img src="../img/allan_hoffenblum.jpg" width="250" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-heading">
                                <h2>Allan Hoffenblum</h2>
                                <h3 class="sub upper text-red mt-sm mb-lg">Founding Publisher</h3>
                            </div>
                            <div class="panel-body">
                                <p>
                                    Allan Hoffenblum co-founded the Target Book with Al Pross
                                    in 1994. On October 2, 2015, he passed away peacefully at
                                    home. The current Target Book team will continue his work
                                    and forever recognize him as Founding Publisher. Allan was
                                    a major force in California politics for nearly five
                                    decades, starting in 1968 on the staff of the Los Angeles
                                    County Republican Party. He was a respected speaker,
                                    teacher and frequently quoted expert on California
                                    politics. An active alumnus of USC, a decorated Air Force
                                    officer who served with distinction during the Vietnam
                                    War, he was a wonderful friend, patient mentor, and gifted
                                    strategist. In 2017, he was inducted into the American
                                    Association of Political Consultants Hall of Fame. It is
                                    in his honor that we continue his work, producing the most
                                    complete resource possible for those who make their living
                                    in and follow California politics.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12">
                <div class="m-n panel about-panel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="media">
                                    <img src="../img/al_pross.jpg" width="250" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-heading">
                                <h2>Al Pross</h2>
                                <h3 class="sub upper text-red mt-sm mb-lg">Co-Founder</h3>
                            </div>
                            <div class="panel-body">
                                <p>
                                         Al Pross, a co-founder of the Target Book, was one of California's top political action-public affairs consultants. His clients included major business, association and union organizations. He was a top aide to Leo McCarthy while he was the Democratic Speaker of the Assembly. When McCarthy became the Assembly Speaker Pro Tempore, Pross served as his chief of staff.  He later served as Vice President of Public Affairs for the California Cable TV Association and directed the California Medical Association's Political Action Committee, CALPAC.  Mr. Pross also managed numerous Democratic campaigns for federal, state and local candidates and ballot propositions and was an independent expenditure specialist.                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



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
