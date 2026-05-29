
<footer>
    <div class="footer-nav">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h4>General</h4>
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="/editors">Editors</a></li>
                        <li><a href="/login">Login</a></li>
                        <li><a href="/register">Subscribe</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h4>Book</h4>
                    <ul>
                        <li><a href="{{ route('book') }}">Home</a></li>
                        <li><a href="{{ route('book.hotsheet') }}">Hotsheets</a></li>
                        <li><a href="{{ route('book') }}#districts">Districts</a></li>
                        <li><a href="{{ route('book') }}#propositions">Propositions</a></li>
                        <li><a href="{{ route('book') }}#candidates">Candidates</a></li>
                        <li><a href="{{ route('book') }}#finance">Finance</a></li>
                        <li><a href="{{ route('book') }}#census-data">Census Data</a></li>
                        <li><a href="{{ route('book') }}#maps">Maps</a></li>
                        <li><a href="{{ route('book') }}#elections">Elections</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h4>Contact</h4>
                    <p>
                        <b>Email:</b> <br/>
                        <a href="mailto:info@californiatargetbook.com">info@californiatargetbook.com</a>
                    </p>
                    <p>
                        <b>Phone:</b> <br/>
                        <a href="tel:916-200-3950">916-200-3950</a>
                    </p>
                    <p>
                        <b>Mailing Address:</b> <br/>
                        P.O. Box 5978 <br/>
                        Beverly Hills, CA 90209
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-copyright">
        <div class="container">
            <p class="text-right">
                ©{{ (new DateTime())->format("Y") }} California Target Book. All Rights Reserved. |
                <a href="/copyright">Copyright</a>
            </p>
        </div>
    </div>


</footer>