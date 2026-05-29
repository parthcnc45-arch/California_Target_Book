
@extends('layouts.master')

@section('title', 'Copyright | California Target Book')

@section('content')

<div class='container copyright'>
    <div class='row'>
        <div class='col-lg-12'>
            <h1>Copyright</h1>
            <p>Copyright ©2017 California Target Book. All rights reserved under International and Pan-American
                copyright Conventions.</p>
            <p>No part of this book may be reproduced or transmitted in any form or by any means electronic, mechanical,
                including photocopying, any information storage or retrieval system without a license or other
                permission in writing from the publisher.</p>
            <p>Quoting of brief passages, properly sourced, in an article or review written for inclusion in a magazine,
                newspaper or broadcast is permitted.</p>
            <br />
            <hr />
            <h3>Publisher: Darry Sragow</h3>
            <p>The California Target Book is a registered trademark (Reg. No. 120818, Class No. 16) with the California
                Secretary of State. A catalog record for this publication is available from the United States Library of
                Congress.</p>
        </div>
    </div>
</div>

@endsection


@section('styles')
<style>

    .copyright {
        font-size: 1.3em;
        font-family: 'Lato';
        font-weight: bold;
        font-style: italic;
    }

</style>
@endsection