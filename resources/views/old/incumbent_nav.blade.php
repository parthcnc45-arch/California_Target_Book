@extends('layouts.book')
@php ($book_side_nav_active = 'candidates')

@section('title', 'Incumbent Detail | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        Incumbent Detail Reports
    </h2>

    <p style='line-height: 2em;'></p>

	<select name="release" id="release" class="switcher">
		<option value=''>Select an Officeholder</option>
		<option value='1003436'>	.ATG - Xavier Becerra (D) TL-2026</option>
		<option value='1273041'>	.CON - Betty Yee (D) TL-2022</option>
		<option value='1308192'>	.GOV - Gavin Newsom (D) TL-2026</option>
		<option value='1304215'>	.INS - Ricardo Lara (D) TL-2026</option>
		<option value='1395992'>	.LTG - Eleni Kounalakis (D) TL-2026</option>
		<option value='1278243'>	.SOS - Alex Padilla (D) TL-2022</option>
		<option value='1295704'>	.SPI - Tony Thurmond (D) TL-2026</option>
		<option value='1261661'>	.TRS - Fiona Ma (D) TL-2026</option>
		<option value='1224716'>	AD01 - Brian Dahle (R) TL-2024</option>
		<option value='1353393'>	AD02 - Jim Wood (D) TL-2026</option>
		<option value='1357069'>	AD03 - Jim Gallagher (R) TL-2026</option>
		<option value='1379566'>	AD04 - Cecilia Aguiar-Curry (D) TL-2028</option>
		<option value='1342402'>	AD05 - Frank Bigelow (R) TL-2024</option>
		<option value='1377646'>	AD06 - Kevin Kiley (R) TL-2028</option>
		<option value='1314046'>	AD07 - Kevin McCarty (D) TL-2026</option>
		<option value='1240640'>	AD08 - Ken Cooley (D) TL-2024</option>
		<option value='1354349'>	AD09 - Jim Cooper (D) TL-2026</option>
		<option value='1338897'>	AD10 - Marc Levine (D) TL-2024</option>
		<option value='1341572'>	AD11 - Jim Frazier (D) TL-2024</option>
		<option value='1376113'>	AD12 - Heath Flora (R) TL-2028</option>
		<option value='1337454'>	AD13 - Susan Eggman (D) TL-2024</option>
		<option value='1376434'>	AD14 - Tim Grayson (D) TL-2028</option>
		<option value='1396735'>	AD15 - Buffy Wicks (D) TL-2030</option>
		<option value='1398720'>	AD16 - Rebecca Bauer-Kahan (D) TL-2030</option>
		<option value='1360423'>	AD17 - David Chiu (D) TL-2026</option>
		<option value='1339733'>	AD18 - Rob Bonta (D) TL-2024</option>
		<option value='1343138'>	AD19 - Phil Ting (D) TL-2024</option>
		<option value='1336944'>	AD20 - Bill Quirk (D) TL-2024</option>
		<option value='1315410'>	AD21 - Adam Gray (D) TL-2024</option>
		<option value='1342937'>	AD22 - Kevin Mullin (D) TL-2024</option>
		<option value='1346007'>	AD23 - Jim Patterson (R) TL-2024</option>
		<option value='1317907'>	AD24 - Marc Berman (D) TL-2028</option>
		<option value='1356482'>	AD25 - Kansen Chu (D) TL-2026</option>
		<option value='1365277'>	AD26 - Devon Mathis (R) TL-2026</option>
		<option value='1372978'>	AD27 - Ash Kalra (D) TL-2028</option>
		<option value='1335519'>	AD28 - Evan Low (D) TL-2026</option>
		<option value='1340922'>	AD29 - Mark Stone (D) TL-2024</option>
		<option value='1399487'>	AD30 - Robert Rivas (D) TL-2030</option>
		<option value='1377114'>	AD31 - Joaquin Arambula (D) TL-2026</option>
		<option value='1340989'>	AD32 - Rudy Salas (D) TL-2024</option>
		<option value='1362835'>	AD33 - Jay Obernolte (R) TL-2026</option>
		<option value='1381906'>	AD34 - Vince Fong (R) TL-2028</option>
		<option value='1374711'>	AD35 - Jordan Cunningham (R) TL-2028</option>
		<option value='1345765'>	AD36 - Tom Lackey (R) TL-2026</option>
		<option value='1375717'>	AD37 - Monique Limon (D) TL-2028</option>
		<option value='1381884'>	AD38 - Christy Smith (D) TL-2030</option>
		<option value='1401108'>	AD39 - Luz Rivas (D) TL-2028</option>
		<option value='1401776'>	AD40 - James Ramos (D) TL-2030</option>
		<option value='1336467'>	AD41 - Chris Holden (D) TL-2024</option>
		<option value='1351765'>	AD42 - Chad Mayes (R) TL-2026</option>
		<option value='1368701'>	AD43 - Laura Friedman (D) TL-2028</option>
		<option value='1362509'>	AD44 - Jacqui Irwin (D) TL-2026</option>
		<option value='1400730'>	AD45 - Jesse Gabriel (D) TL-2028</option>
		<option value='1323126'>	AD46 - Adrin Nazarian (D) TL-2024</option>
		<option value='1381098'>	AD47 - Eloise Gomez-Reyes (D) TL-2028</option>
		<option value='1374663'>	AD48 - Blanca Rubio (D) TL-2028</option>
		<option value='1281706'>	AD49 - Ed Chau (D) TL-2024</option>
		<option value='1330273'>	AD50 - Richard Bloom (D) TL-2024</option>
		<option value='1396973'>	AD51 - Wendy Carrillo (D) TL-2028</option>
		<option value='1354976'>	AD52 - Freddie Rodriguez (D) TL-2024</option>
		<option value='1357853'>	AD53 - Miguel Santiago (D) TL-2026</option>
		<option value='1401214'>	AD54 - Sydney Kamlager (D) TL-2028</option>
		<option value='1358732'>	AD55 - Phillip Chen (R) TL-2028</option>
		<option value='1355371'>	AD56 - Eduardo Garcia (D) TL-2026</option>
		<option value='1336511'>	AD57 - Ian Calderon (D) TL-2024</option>
		<option value='1343926'>	AD58 - Cristina Garcia (D) TL-2024</option>
		<option value='1317870'>	AD59 - Reggie Jones-Sawyer (D) TL-2024</option>
		<option value='1377791'>	AD60 - Sabrina Cervantes (D) TL-2028</option>
		<option value='1005789'>	AD61 - Jose Medina (D) TL-2024</option>
		<option value='1357823'>	AD62 - Autumn Burke (D) TL-2026</option>
		<option value='1335212'>	AD63 - Anthony Rendon (D) TL-2024</option>
		<option value='1299805'>	AD64 - Mike Gipson (D) TL-2026</option>
		<option value='1345707'>	AD65 - Sharon Quirk-Silva (D) TL-2026</option>
		<option value='1315952'>	AD66 - Al Muratsuchi (D) TL-2026</option>
		<option value='1340675'>	AD67 - Melissa Melendez (R) TL-2024</option>
		<option value='1296275'>	AD68 - Steven Choi (R) TL-2028</option>
		<option value='1341148'>	AD69 - Tom Daly (D) TL-2024</option>
		<option value='1296270'>	AD70 - Patrick O'Donnell (D) TL-2026</option>
		<option value='1226426'>	AD71 - Randy Voepel (R) TL-2028</option>
		<option value='1339560'>	AD72 - Tyler Diep (R) TL-2030</option>
		<option value='1356165'>	AD73 - Bill Brough (R) TL-2026</option>
		<option value='1400671'>	AD74 - Cottie Petrie-Norris (D) TL-2030</option>
		<option value='1273672'>	AD75 - Marie Waldron (R) TL-2024</option>
		<option value='1399345'>	AD76 - Tasha Boerner Horvath (D) TL-2030</option>
		<option value='1339637'>	AD77 - Brian Maienschein (D) TL-2024</option>
		<option value='1376637'>	AD78 - Todd Gloria (D) TL-2028</option>
		<option value='1342820'>	AD79 - Shirley Weber (D) TL-2024</option>
		<option value='1353845'>	AD80 - Lorena Gonzalez Fletcher (D) TL-2024</option>
		<option value='1265444'>	BOE1 - Ted Gaines (R) TL-2026</option>
		<option value='1393661'>	BOE2 - Malia Coehn (D) TL-2026</option>
		<option value='1005783'>	BOE3 - Tony Vazquez (D) TL-2026</option>
		<option value='1402442'>	BOE4 - J. Michael Schaefer (D) TL-2026</option>
		<option value=''>SD01 - VACANT</option>
		<option value='1361301'>	SD02 - Mike McGuire (D) TL-2026</option>
		<option value='1359048'>	SD03 - Bill Dodd (D) TL-2026</option>
		<option value='1299401'>	SD04 - Jim Nielsen (R) TL-2022</option>
		<option value='1273495'>	SD05 - Cathleen Galgiani (D) TL-2020</option>
		<option value='1319205'>	SD06 - Richard Pan (D) TL-2022</option>
		<option value='1355210'>	SD07 - Steve Glazer (D) TL-2026</option>
		<option value='1394471'>	SD08 - Andreas Borgeas (R) TL-2030</option>
		<option value='1303644'>	SD09 - Nancy Skinner (D) TL-2024</option>
		<option value='1315744'>	SD10 - Bob Wieckowski (D) TL-2020</option>
		<option value='1376435'>	SD11 - Scott Wiener (D) TL-2028</option>
		<option value='1282323'>	SD12 - Anna Caballero (D) TL-2026</option>
		<option value='1290757'>	SD13 - Jerry Hill (D) TL-2020</option>
		<option value='1401463'>	SD14 - Melissa Hurtado (D) TL-2030</option>
		<option value='1251768'>	SD15 - Jim Beall (D) TL-2020</option>
		<option value='1325437'>	SD16 - Shannon Grove (R) TL-2026</option>
		<option value='1297947'>	SD17 - Bill Monning (D) TL-2020</option>
		<option value='1004251'>	SD18 - Bob Hertzberg (D) TL-2022</option>
		<option value='1005197'>	SD19 - Hannah-Beth Jackson (D) TL-2020</option>
		<option value='1364478'>	SD20 - Conie Leyva (D) TL-2026</option>
		<option value='1339656'>	SD21 - Scott Wilk (R) TL-2024</option>
		<option value='1392891'>	SD22 - Susan Rubio (D) TL-2030</option>
		<option value='1252076'>	SD23 - Mike Morrell (R) TL-2020</option>
		<option value='1395750'>	SD24 - Maria Elena Durazo (D) TL-2030</option>
		<option value='1267043'>	SD25 - Anthony Portantino (D) TL-2024</option>
		<option value='1363828'>	SD26 - Ben Allen (D) TL-2026</option>
		<option value='1374151'>	SD27 - Henry Stern (D) TL-2028</option>
		<option value='1238568'>	SD28 - Jeff Stone (R) TL-2026</option>
		<option value='1357038'>	SD29 - Ling Ling Chang (R) TL-2024</option>
		<option value='1307762'>	SD30 - Holly Mitchell (D) TL-2022</option>
		<option value='1343716'>	SD31 - Richard Roth (D) TL-2024</option>
		<option value='1402932'>	SD32 - Bob Archuleta (D) TL-2030</option>
		<option value=''>SD33 - VACANT</option>
		<option value='1241318'>	SD34 - Tom Umberg (D) TL-2026</option>
		<option value='1235136'>	SD35 - Steven Bradford (D) TL-2024</option>
		<option value='1003846'>	SD36 - Pat Bates (R) TL-2022</option>
		<option value='1241305'>	SD37 - John M.W. Moorlach (R) TL-2026</option>
		<option value='1319720'>	SD38 - Brian Jones (R) TL-2024</option>
		<option value='1314678'>	SD39 - Toni Atkins (D) TL-2024</option>
		<option value='1315742'>	SD40 - Ben Hueso (D) TL-2022</option>
	</select>

    <p style='line-height: 2em;'></p>

    <iframe id='lower_frame' name='lower_frame' class='switch-target ported' src='' width='100%' height='100%'></iframe>
</div>

@endsection


@section('scripts')

<script>
$( "#release" ).change(function () {	
		switcher();
  });


function switcher() {
   var theSelect = document.getElementById('release');
   var theIframe = document.getElementById('lower_frame');
   var x = theSelect.options[theSelect.selectedIndex].value;
   var url = '/ctb-legacy/lifetime_contributions.php?id=' + x;
   theIframe.src = url;
}
</script>

@endsection



@section('styles')

<style>

.ported {
    height: 100vh;
}

</style>


@endsection