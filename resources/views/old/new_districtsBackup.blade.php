@extends('layouts.book')
@php ($book_side_nav_active = 'district')
@section('title', 'New District Directory | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2 align='center'>
        New District Directory
    </h2>
    
    <h5 align='center'>
		<em>VRA Districts indicated with an *</em>
    
   		<div class='row'>
			<div class='col-sm-4'>
				<h2>Assembly</h2>
					<table class='table-striped' v-ctb-table>
						<thead>
							<tr>
								<th>NEW #</th>
								<th>OLD #</th>
								<th>INCUMBENT</th>
								<th>REG ADV</th>
								<th>PRS '20</th>
							</tr>
						</thead>

						<tbody>
								<tr><td><a href='/book/new/AD01' target='_blank'>AD01</a></td><td><a href='/book/old/AD01' target='_blank'>AD01</a></td><td>Megan Dahle</td><td>R +12.18%</td><td>Trump +12.57</td></tr>
								<tr><td><a href='/book/new/AD02' target='_blank'>AD02</a></td><td><a href='/book/old/AD02' target='_blank'>AD02</a></td><td>Jim Wood</td><td>D +28.79%</td><td>Biden +40.37</td></tr>
								<tr><td><a href='/book/new/AD03' target='_blank'>AD03</a></td><td><a href='/book/old/AD03' target='_blank'>AD03</a></td><td>Jim Gallagher</td><td>R +8.62%</td><td>Trump +12.35</td></tr>
								<tr><td><a href='/book/new/AD04' target='_blank'>AD04</a></td><td><a href='/book/old/AD04' target='_blank'>AD04</a></td><td>Cecilia Aguiar-Curry</td><td>D +25.69%</td><td>Biden +35.55</td></tr>
								<tr><td><a href='/book/new/AD05' target='_blank'>AD05</a></td><td><a href='/book/old/AD06' target='_blank'>AD06</a></td><td>Kevin Kiley</td><td>R +12.64%</td><td>Trump +9.16</td></tr>
								<tr><td><a href='/book/new/AD06' target='_blank'>AD06</a></td><td><a href='/book/old/AD07' target='_blank'>AD07</a></td><td>Kevin McCarty</td><td>D +28.15%</td><td>Biden +38.76</td></tr>
								<tr><td><a href='/book/new/AD07' target='_blank'>AD07</a></td><td><a href='/book/old/AD08' target='_blank'>AD08</a></td><td>Ken Cooley</td><td>D +2.96%</td><td>Biden +5.83</td></tr>
								<tr><td><a href='/book/new/AD08' target='_blank'>AD08</a></td><td><a href='/book/old/AD23' target='_blank'>AD23</a></td><td>Jim Patterson</td><td>R +14.29%</td><td>Trump +13.69</td></tr>
								<tr><td><a href='/book/new/AD09' target='_blank'>AD09</a></td><td><a href='/book/old/AD12' target='_blank'>AD12</a></td><td>Heath Flora</td><td>R +9.63%</td><td>Trump +14.25</td></tr>
								<tr><td><a href='/book/new/AD10' target='_blank'>AD10</a></td><td><a href='/book/old/AD09' target='_blank'>AD09</a></td><td>Jim Cooper</td><td>D +30.19%</td><td>Biden +37.86</td></tr>
								<tr><td><a href='/book/new/AD11' target='_blank'>AD11</a></td><td><a href='/book/old/AD11' target='_blank'>AD11</a></td><td>Jim Frazier</td><td>D +23.58%</td><td>Biden +27.07</td></tr>
								<tr><td><a href='/book/new/AD12' target='_blank'>AD12</a></td><td><a href='/book/old/AD10' target='_blank'>AD10</a></td><td>Marc Levine</td><td>D +42.64%</td><td>Biden +59.42</td></tr>
								<tr><td><a href='/book/new/AD13' target='_blank'>AD13</a></td><td><a href='/book/old/AD13' target='_blank'>AD13</a></td><td>Carlos Villapudua</td><td>D +27.66%</td><td>Biden +30.51</td></tr>
								<tr><td><a href='/book/new/AD14' target='_blank'>AD14</a></td><td><a href='/book/old/AD15' target='_blank'>AD15</a></td><td>Buffy Wicks</td><td>D +62.49%</td><td>Biden +78.30</td></tr>
								<tr><td><a href='/book/new/AD15' target='_blank'>AD15</a></td><td><a href='/book/old/AD14' target='_blank'>AD14</a></td><td>Tim Grayson</td><td>D +32.11%</td><td>Biden +40.44</td></tr>
								<tr><td><a href='/book/new/AD16' target='_blank'>AD16</a></td><td><a href='/book/old/AD16' target='_blank'>AD16</a></td><td>Rebecca Bauer-Kahan</td><td>D +21.39%</td><td>Biden +40.06</td></tr>
								<tr><td><a href='/book/new/AD17' target='_blank'>AD17</a></td><td><a href='/book/old/AD17' target='_blank'>AD17</a></td><td>VACANT (Chiu)</td><td>D +58.37%</td><td>Biden +75.37</td></tr>
								<tr><td><a href='/book/new/AD18' target='_blank'>AD18</a></td><td><a href='/book/old/AD18' target='_blank'>AD18</a></td><td>Mia Bonta</td><td>D +62.61%</td><td>Biden +80.41</td></tr>
								<tr><td><a href='/book/new/AD19' target='_blank'>AD19</a></td><td><a href='/book/old/AD19' target='_blank'>AD19</a></td><td>Phil Ting</td><td>D +49.90%</td><td>Biden +65.82</td></tr>
								<tr><td><a href='/book/new/AD20' target='_blank'>AD20</a></td><td><a href='/book/old/AD20' target='_blank'>AD20</a></td><td>Bill Quirk</td><td>D +42.27%</td><td>Biden +51.67</td></tr>
								<tr><td><a href='/book/new/AD21' target='_blank'>AD21</a></td><td><a href='/book/old/AD22' target='_blank'>AD22</a></td><td>Kevin Mullin</td><td>D +39.24%</td><td>Biden +57.88</td></tr>
								<tr><td><a href='/book/new/AD22' target='_blank'>AD22</a></td><td><a href='' target='_blank'>NEW1</a></td><td>NULL</td><td>D +6.12%</td><td>Biden +4.62</td></tr>
								<tr><td><a href='/book/new/AD23' target='_blank'>AD23</a></td><td><a href='/book/old/AD24' target='_blank'>AD24</a></td><td>Marc Berman</td><td>D +36.81%</td><td>Biden +58.94</td></tr>
								<tr><td><a href='/book/new/AD24' target='_blank'>AD24</a></td><td><a href='/book/old/AD25' target='_blank'>AD25</a></td><td>Alex Lee</td><td>D +32.73%</td><td>Biden +42.77</td></tr>
								<tr><td><a href='/book/new/AD25' target='_blank'>AD25</a></td><td><a href='/book/old/AD27' target='_blank'>AD27</a></td><td>Ash Kalra</td><td>D +35.07%</td><td>Biden +43.26</td></tr>
								<tr><td><a href='/book/new/AD26' target='_blank'>AD26</a></td><td><a href='/book/old/AD28' target='_blank'>AD28</a></td><td>Evan Low</td><td>D +35.16%</td><td>Biden +53.85</td></tr>
								<tr><td><a href='/book/new/AD27' target='_blank'>AD27*</a></td><td><a href='/book/old/AD21' target='_blank'>AD21</a></td><td>Adam Gray</td><td>D +15.15%</td><td>Biden +13.57</td></tr>
								<tr><td><a href='/book/new/AD28' target='_blank'>AD28</a></td><td><a href='/book/old/AD29' target='_blank'>AD29</a></td><td>Mark Stone</td><td>D +31.20%</td><td>Biden +47.79</td></tr>
								<tr><td><a href='/book/new/AD29' target='_blank'>AD29*</a></td><td><a href='/book/old/AD30' target='_blank'>AD30</a></td><td>Robert Rivas</td><td>D +33.12%</td><td>Biden +39.65</td></tr>
								<tr><td><a href='/book/new/AD30' target='_blank'>AD30</a></td><td><a href='/book/old/AD35' target='_blank'>AD35</a></td><td>Jordan Cunningham</td><td>D +16.85%</td><td>Biden +30.15</td></tr>
								<tr><td><a href='/book/new/AD31' target='_blank'>AD31*</a></td><td><a href='/book/old/AD31' target='_blank'>AD31</a></td><td>Joaquin Arambula</td><td>D +24.07%</td><td>Biden +30.14</td></tr>
								<tr><td><a href='/book/new/AD32' target='_blank'>AD32</a></td><td><a href='/book/old/AD34' target='_blank'>AD34</a></td><td>Vince Fong</td><td>R +23.44%</td><td>Trump +27.84</td></tr>
								<tr><td><a href='/book/new/AD33' target='_blank'>AD33*</a></td><td><a href='/book/old/AD26' target='_blank'>AD26</a></td><td>Devon Mathis</td><td>R +1.18%</td><td>Trump +4.41</td></tr>
								<tr><td><a href='/book/new/AD34' target='_blank'>AD34</a></td><td><a href='/book/old/AD33' target='_blank'>AD33</a></td><td>Thurston 'Smitty' Smith</td><td>R +9.68%</td><td>Trump +15.14</td></tr>
								<tr><td><a href='/book/new/AD35' target='_blank'>AD35*</a></td><td><a href='/book/old/AD32' target='_blank'>AD32</a></td><td>Rudy Salas</td><td>D +24.31%</td><td>Biden +21.08</td></tr>
								<tr><td><a href='/book/new/AD36' target='_blank'>AD36*</a></td><td><a href='/book/old/AD56' target='_blank'>AD56</a></td><td>Eduardo Garcia</td><td>D +16.40%</td><td>Biden +14.68</td></tr>
								<tr><td><a href='/book/new/AD37' target='_blank'>AD37</a></td><td><a href='' target='_blank'>NEW2</a></td><td>NULL</td><td>D +18.71%</td><td>Biden +29.22</td></tr>
								<tr><td><a href='/book/new/AD38' target='_blank'>AD38</a></td><td><a href='/book/old/AD37' target='_blank'>AD37</a></td><td>Steve Bennett</td><td>D +25.11%</td><td>Biden +32.28</td></tr>
								<tr><td><a href='/book/new/AD39' target='_blank'>AD39*</a></td><td><a href='/book/old/AD36' target='_blank'>AD36</a></td><td>Tom Lackey</td><td>D +24.60%</td><td>Biden +25.43</td></tr>
								<tr><td><a href='/book/new/AD40' target='_blank'>AD40</a></td><td><a href='/book/old/AD38' target='_blank'>AD38</a></td><td>Suzette Valladares</td><td>D +10.79%</td><td>Biden +16.07</td></tr>
								<tr><td><a href='/book/new/AD41' target='_blank'>AD41</a></td><td><a href='/book/old/AD41' target='_blank'>AD41</a></td><td>Chris Holden</td><td>D +15.40%</td><td>Biden +25.61</td></tr>
								<tr><td><a href='/book/new/AD42' target='_blank'>AD42</a></td><td><a href='/book/old/AD44' target='_blank'>AD44</a></td><td>Jacqui Irwin</td><td>D +8.19%</td><td>Biden +18.99</td></tr>
								<tr><td><a href='/book/new/AD43' target='_blank'>AD43</a></td><td><a href='/book/old/AD39' target='_blank'>AD39</a></td><td>Luz Rivas</td><td>D +41.95%</td><td>Biden +49.75</td></tr>
								<tr><td><a href='/book/new/AD44' target='_blank'>AD44</a></td><td><a href='/book/old/AD43' target='_blank'>AD43</a></td><td>Laura Friedman<br>Adrin Nazarian</td><td>D +29.27%</td><td>Biden +38.65</td></tr>
								<tr><td><a href='/book/new/AD45' target='_blank'>AD45*</a></td><td><a href='/book/old/AD40' target='_blank'>AD40</a></td><td>James Ramos</td><td>D +25.62%</td><td>Biden +30.71</td></tr>
								<tr><td><a href='/book/new/AD46' target='_blank'>AD46</a></td><td><a href='/book/old/AD45' target='_blank'>AD45</a></td><td>Jesse Gabriel</td><td>D +31.11%</td><td>Biden +37.89</td></tr>
								<tr><td><a href='/book/new/AD47' target='_blank'>AD47</a></td><td><a href='/book/old/AD42' target='_blank'>AD42</a></td><td>Chad Mayes</td><td>D +3.24%</td><td>Biden +6.62</td></tr>
								<tr><td><a href='/book/new/AD48' target='_blank'>AD48*</a></td><td><a href='/book/old/AD48' target='_blank'>AD48</a></td><td>Blanca Rubio</td><td>D +25.78%</td><td>Biden +30.99</td></tr>
								<tr><td><a href='/book/new/AD49' target='_blank'>AD49*</a></td><td><a href='/book/old/AD49' target='_blank'>AD49</a></td><td>Ed Chau</td><td>D +25.73%</td><td>Biden +35.53</td></tr>
								<tr><td><a href='/book/new/AD50' target='_blank'>AD50*</a></td><td><a href='/book/old/AD47' target='_blank'>AD47</a></td><td>Eloise Gomez-Reyes</td><td>D +21.66%</td><td>Biden +25.18</td></tr>
								<tr><td><a href='/book/new/AD51' target='_blank'>AD51</a></td><td><a href='/book/old/AD50' target='_blank'>AD50</a></td><td>Richard Bloom</td><td>D +44.12%</td><td>Biden +57.44</td></tr>
								<tr><td><a href='/book/new/AD52' target='_blank'>AD52</a></td><td><a href='/book/old/AD51' target='_blank'>AD51</a></td><td>Wendy Carrillo</td><td>D +50.94%</td><td>Biden +63.59</td></tr>
								<tr><td><a href='/book/new/AD53' target='_blank'>AD53*</a></td><td><a href='/book/old/AD52' target='_blank'>AD52</a></td><td>Freddie Rodriguez</td><td>D +25.63%</td><td>Biden +29.52</td></tr>
								<tr><td><a href='/book/new/AD54' target='_blank'>AD54</a></td><td><a href='/book/old/AD53' target='_blank'>AD53</a></td><td>Miguel Santiago</td><td>D +48.51%</td><td>Biden +58.80</td></tr>
								<tr><td><a href='/book/new/AD55' target='_blank'>AD55</a></td><td><a href='/book/old/AD54' target='_blank'>AD54</a></td><td>Isaac Bryan</td><td>D +55.89%</td><td>Biden +70.69</td></tr>
								<tr><td><a href='/book/new/AD56' target='_blank'>AD56*</a></td><td><a href='/book/old/AD57' target='_blank'>AD57</a></td><td>Lisa Calderon</td><td>D +27.00%</td><td>Biden +32.85</td></tr>
								<tr><td><a href='/book/new/AD57' target='_blank'>AD57</a></td><td><a href='/book/old/AD59' target='_blank'>AD59</a></td><td>Reggie Jones-Sawyer</td><td>D +58.14%</td><td>Biden +73.20</td></tr>
								<tr><td><a href='/book/new/AD58' target='_blank'>AD58*</a></td><td><a href='/book/old/AD60' target='_blank'>AD60</a></td><td>Sabrina Cervantes</td><td>D +17.80%</td><td>Biden +19.24</td></tr>
								<tr><td><a href='/book/new/AD59' target='_blank'>AD59</a></td><td><a href='/book/old/AD55' target='_blank'>AD55</a></td><td>Phillip Chen</td><td>R +9.40%</td><td>Trump +1.62</td></tr>
								<tr><td><a href='/book/new/AD60' target='_blank'>AD60*</a></td><td><a href='/book/old/AD61' target='_blank'>AD61</a></td><td>Jose Medina</td><td>D +23.66%</td><td>Biden +25.99</td></tr>
								<tr><td><a href='/book/new/AD61' target='_blank'>AD61</a></td><td><a href='/book/old/AD62' target='_blank'>AD62</a></td><td>Autumn Burke</td><td>D +52.69%</td><td>Biden +67.65</td></tr>
								<tr><td><a href='/book/new/AD62' target='_blank'>AD62*</a></td><td><a href='/book/old/AD63' target='_blank'>AD63</a></td><td>Anthony Rendon</td><td>D +41.40%</td><td>Biden +47.29</td></tr>
								<tr><td><a href='/book/new/AD63' target='_blank'>AD63</a></td><td><a href='/book/old/AD67' target='_blank'>AD67</a></td><td>Kelly Seyarto</td><td>R +6.43%</td><td>Trump +6.14</td></tr>
								<tr><td><a href='/book/new/AD64' target='_blank'>AD64*</a></td><td><a href='/book/old/AD58' target='_blank'>AD58</a></td><td>Cristina Garcia</td><td>D +29.50%</td><td>Biden +33.01</td></tr>
								<tr><td><a href='/book/new/AD65' target='_blank'>AD65</a></td><td><a href='/book/old/AD64' target='_blank'>AD64</a></td><td>Mike Gipson</td><td>D +49.45%</td><td>Biden +60.52</td></tr>
								<tr><td><a href='/book/new/AD66' target='_blank'>AD66</a></td><td><a href='/book/old/AD66' target='_blank'>AD66</a></td><td>Al Muratsuchi</td><td>D +14.74%</td><td>Biden +28.11</td></tr>
								<tr><td><a href='/book/new/AD67' target='_blank'>AD67</a></td><td><a href='/book/old/AD65' target='_blank'>AD65</a></td><td>Sharon Quirk-Silva</td><td>D +16.21%</td><td>Biden +19.80</td></tr>
								<tr><td><a href='/book/new/AD68' target='_blank'>AD68*</a></td><td><a href='/book/old/AD69' target='_blank'>AD69</a></td><td>Tom Daly</td><td>D +28.69%</td><td>Biden +35.49</td></tr>
								<tr><td><a href='/book/new/AD69' target='_blank'>AD69</a></td><td><a href='/book/old/AD70' target='_blank'>AD70</a></td><td>Patrick O'Donnell</td><td>D +33.69%</td><td>Biden +44.91</td></tr>
								<tr><td><a href='/book/new/AD70' target='_blank'>AD70</a></td><td><a href='/book/old/AD72' target='_blank'>AD72</a></td><td>Janet Nguyen</td><td>D +2.22%</td><td>Biden +0.32</td></tr>
								<tr><td><a href='/book/new/AD71' target='_blank'>AD71</a></td><td><a href='' target='_blank'>NEW3</a></td><td></td><td>R +13.03%</td><td>Trump +7.73</td></tr>
								<tr><td><a href='/book/new/AD72' target='_blank'>AD72</a></td><td><a href='/book/old/AD74' target='_blank'>AD74</a></td><td>Cottie Petrie-Norris</td><td>R +7.82%</td><td>Biden +1.61</td></tr>
								<tr><td><a href='/book/new/AD73' target='_blank'>AD73</a></td><td><a href='/book/old/AD68' target='_blank'>AD68</a></td><td>Steven Choi</td><td>D +11.18%</td><td>Biden +25.47</td></tr>
								<tr><td><a href='/book/new/AD74' target='_blank'>AD74</a></td><td><a href='/book/old/AD73' target='_blank'>AD73</a></td><td>Laurie Davies</td><td>R +2.17%</td><td>Biden +6.08</td></tr>
								<tr><td><a href='/book/new/AD75' target='_blank'>AD75</a></td><td><a href='/book/old/AD71' target='_blank'>AD71</a></td><td>Randy Voepel</td><td>R +14.84%</td><td>Trump +12.06</td></tr>
								<tr><td><a href='/book/new/AD76' target='_blank'>AD76</a></td><td><a href='/book/old/AD75' target='_blank'>AD75</a></td><td>Marie Waldron</td><td>D +3.24%</td><td>Biden +15.98</td></tr>
								<tr><td><a href='/book/new/AD77' target='_blank'>AD77</a></td><td><a href='/book/old/AD78' target='_blank'>AD78</a></td><td>Chris Ward</td><td>D +14.27%</td><td>Biden +32.37</td></tr>
								<tr><td><a href='/book/new/AD78' target='_blank'>AD78</a></td><td><a href='/book/old/AD77' target='_blank'>AD77</a></td><td>Brian Maienschein</td><td>D +23.17%</td><td>Biden +38.46</td></tr>
								<tr><td><a href='/book/new/AD79' target='_blank'>AD79</a></td><td><a href='/book/old/AD79' target='_blank'>AD79</a></td><td>Akilah Weber</td><td>D +25.79%</td><td>Biden +34.46</td></tr>
								<tr><td><a href='/book/new/AD80' target='_blank'>AD80*</a></td><td><a href='/book/old/AD80' target='_blank'>AD80</a></td><td>Lorena Gonzalez Fletcher</td><td>D +25.53%</td><td>Biden +33.11</td></tr>
						</tbody>
					</table>
				</div>
				<div class='col-sm-4'>
					<h2>State Senate</h2>
						<table class='table-striped' v-ctb-table>
							<thead>
								<tr>
									<th>NEW #</th>
									<th>OLD #</th>
									<th>INCUMBENT</th>
									<th>REG ADV</th>
									<th>PRS '20</th>
								</tr>
							</thead>						
							<tbody>

								<tr><td><a href='/book/new/SD01' target='_blank'>SD01</a></td><td><a href='/book/old/SD01' target='_blank'>SD01</a></td><td>Brian Dahle</td><td>R +12.73%</td><td>Trump +15.82</td></tr>
								<tr><td><a href='/book/new/SD02' target='_blank'>SD02</a></td><td><a href='/book/old/SD02' target='_blank'>SD02</a></td><td>Mike McGuire</td><td>D +34.11%</td><td>Biden +47.91</td></tr>
								<tr><td><a href='/book/new/SD03' target='_blank'>SD03</a></td><td><a href='/book/old/SD03' target='_blank'>SD03</a></td><td>Bill Dodd</td><td>D +25.89%</td><td>Biden +33.34</td></tr>
								<tr><td><a href='/book/new/SD04' target='_blank'>SD04</a></td><td><a href='/book/old/SD08' target='_blank'>SD08</a></td><td>Andreas Borgeas</td><td>R +4.47%</td><td>Trump +5.30</td></tr>
								<tr><td><a href='/book/new/SD05' target='_blank'>SD05</a></td><td><a href='/book/old/SD05' target='_blank'>SD05</a></td><td>Susan Eggman</td><td>D +15.86%</td><td>Biden +20.26</td></tr>
								<tr><td><a href='/book/new/SD06' target='_blank'>SD06</a></td><td><a href='/book/old/SD04' target='_blank'>SD04</a></td><td>Jim Nielsen</td><td>R +2.72%</td><td>Biden +0.88</td></tr>
								<tr><td><a href='/book/new/SD07' target='_blank'>SD07</a></td><td><a href='/book/old/SD09' target='_blank'>SD09</a></td><td>Nancy Skinner</td><td>D +62.56%</td><td>Biden +79.35</td></tr>
								<tr><td><a href='/book/new/SD08' target='_blank'>SD08</a></td><td><a href='/book/old/SD06' target='_blank'>SD06</a></td><td>Richard Pan</td><td>D +30.90%</td><td>Biden +40.11</td></tr>
								<tr><td><a href='/book/new/SD09' target='_blank'>SD09</a></td><td><a href='/book/old/SD07' target='_blank'>SD07</a></td><td>Steve Glazer</td><td>D +32.13%</td><td>Biden +45.15</td></tr>
								<tr><td><a href='/book/new/SD10' target='_blank'>SD10</a></td><td><a href='/book/old/SD10' target='_blank'>SD10</a></td><td>Bob Wieckowski</td><td>D +36.88%</td><td>Biden +48.77</td></tr>
								<tr><td><a href='/book/new/SD11' target='_blank'>SD11</a></td><td><a href='/book/old/SD11' target='_blank'>SD11</a></td><td>Scott Wiener</td><td>D +53.96%</td><td>Biden +70.38</td></tr>
								<tr><td><a href='/book/new/SD12' target='_blank'>SD12</a></td><td><a href='/book/old/SD16' target='_blank'>SD16</a></td><td>Shannon Grove</td><td>R +17.98%</td><td>Trump +20.10</td></tr>
								<tr><td><a href='/book/new/SD13' target='_blank'>SD13</a></td><td><a href='/book/old/SD13' target='_blank'>SD13</a></td><td>Josh Becker</td><td>D +37.30%</td><td>Biden +58.06</td></tr>
								<tr><td><a href='/book/new/SD14' target='_blank'>SD14*</a></td><td><a href='/book/old/SD12' target='_blank'>SD12</a></td><td>Anna Caballero</td><td>D +19.51%</td><td>Biden +21.08</td></tr>
								<tr><td><a href='/book/new/SD15' target='_blank'>SD15</a></td><td><a href='/book/old/SD15' target='_blank'>SD15</a></td><td>Dave Cortese</td><td>D +31.34%</td><td>Biden +43.32</td></tr>
								<tr><td><a href='/book/new/SD16' target='_blank'>SD16*</a></td><td><a href='/book/old/SD14' target='_blank'>SD14</a></td><td>Melissa Hurtado</td><td>D +12.30%</td><td>Biden +8.53</td></tr>
								<tr><td><a href='/book/new/SD17' target='_blank'>SD17</a></td><td><a href='/book/old/SD17' target='_blank'>SD17</a></td><td>John Laird</td><td>D +27.61%</td><td>Biden +39.14</td></tr>
								<tr><td><a href='/book/new/SD18' target='_blank'>SD18*</a></td><td><a href='/book/old/SD40' target='_blank'>SD40</a></td><td>Ben Hueso</td><td>D +25.17%</td><td>Biden +30.03</td></tr>
								<tr><td><a href='/book/new/SD19' target='_blank'>SD19</a></td><td><a href='/book/old/SD23' target='_blank'>SD23</a></td><td>Rosilicie Ochoa Bogh</td><td>R +0.96%</td><td>Trump +0.28</td></tr>
								<tr><td><a href='/book/new/SD20' target='_blank'>SD20</a></td><td><a href='/book/old/SD18' target='_blank'>SD18</a></td><td>Bob Hertzberg</td><td>D +35.84%</td><td>Biden +42.95</td></tr>
								<tr><td><a href='/book/new/SD21' target='_blank'>SD21</a></td><td><a href='/book/old/SD19' target='_blank'>SD19</a></td><td>Monique Limon</td><td>D +20.33%</td><td>Biden +29.06</td></tr>
								<tr><td><a href='/book/new/SD22' target='_blank'>SD22*</a></td><td><a href='/book/old/SD22' target='_blank'>SD22</a></td><td>Susan Rubio</td><td>D +25.49%</td><td>Biden +29.82</td></tr>
								<tr><td><a href='/book/new/SD23' target='_blank'>SD23</a></td><td><a href='/book/old/SD21' target='_blank'>SD21</a></td><td>Scott Wilk</td><td>D +8.17%</td><td>Biden +7.61</td></tr>
								<tr><td><a href='/book/new/SD24' target='_blank'>SD24</a></td><td><a href='/book/old/SD26' target='_blank'>SD26</a></td><td>Ben Allen</td><td>D +28.19%</td><td>Biden +42.11</td></tr>
								<tr><td><a href='/book/new/SD25' target='_blank'>SD25</a></td><td><a href='/book/old/SD25' target='_blank'>SD25</a></td><td>Anthony Portantino</td><td>D +21.59%</td><td>Biden +31.22</td></tr>
								<tr><td><a href='/book/new/SD26' target='_blank'>SD26</a></td><td><a href='/book/old/SD24' target='_blank'>SD24</a></td><td>Maria Elena Durazo</td><td>D +51.75%</td><td>Biden +65.07</td></tr>
								<tr><td><a href='/book/new/SD27' target='_blank'>SD27</a></td><td><a href='/book/old/SD27' target='_blank'>SD27</a></td><td>Henry Stern</td><td>D +20.37%</td><td>Biden +28.86</td></tr>
								<tr><td><a href='/book/new/SD28' target='_blank'>SD28</a></td><td><a href='/book/old/SD30' target='_blank'>SD30</a></td><td>Sydney Kamlager</td><td>D +55.67%</td><td>Biden +70.57</td></tr>
								<tr><td><a href='/book/new/SD29' target='_blank'>SD29*</a></td><td><a href='/book/old/SD20' target='_blank'>SD20</a></td><td>Connie Leyva</td><td>D +23.34%</td><td>Biden +27.06</td></tr>
								<tr><td><a href='/book/new/SD30' target='_blank'>SD30*</a></td><td><a href='/book/old/SD32' target='_blank'>SD32</a></td><td>Bob Archuleta</td><td>D +27.49%</td><td>Biden +32.38</td></tr>
								<tr><td><a href='/book/new/SD31' target='_blank'>SD31*</a></td><td><a href='/book/old/SD31' target='_blank'>SD31</a></td><td>Richard Roth</td><td>D +22.07%</td><td>Biden +24.37</td></tr>
								<tr><td><a href='/book/new/SD32' target='_blank'>SD32</a></td><td><a href='/book/old/SD28' target='_blank'>SD28</a></td><td>Melissa Melendez</td><td>R +10.80%</td><td>Trump +9.54</td></tr>
								<tr><td><a href='/book/new/SD33' target='_blank'>SD33*</a></td><td><a href='/book/old/SD33' target='_blank'>SD33</a></td><td>Lena Gonzalez</td><td>D +40.25%</td><td>Biden +49.70</td></tr>
								<tr><td><a href='/book/new/SD34' target='_blank'>SD34*</a></td><td><a href='/book/old/SD29' target='_blank'>SD29</a></td><td>Josh Newman</td><td>D +24.74%</td><td>Biden +28.91</td></tr>
								<tr><td><a href='/book/new/SD35' target='_blank'>SD35</a></td><td><a href='/book/old/SD35' target='_blank'>SD35</a></td><td>Steve Bradford</td><td>D +50.07%</td><td>Biden +60.99</td></tr>
								<tr><td><a href='/book/new/SD36' target='_blank'>SD36</a></td><td><a href='/book/old/SD34' target='_blank'>SD34</a></td><td>Tom Umberg</td><td>R +3.39%</td><td>Biden +0.75</td></tr>
								<tr><td><a href='/book/new/SD37' target='_blank'>SD37</a></td><td><a href='/book/old/SD37' target='_blank'>SD37</a></td><td>Dave Min</td><td>D +1.19%</td><td>Biden +12.77</td></tr>
								<tr><td><a href='/book/new/SD38' target='_blank'>SD38</a></td><td><a href='/book/old/SD36' target='_blank'>SD36</a></td><td>Pat Bates</td><td>D +3.12%</td><td>Biden +16.28</td></tr>
								<tr><td><a href='/book/new/SD39' target='_blank'>SD39</a></td><td><a href='/book/old/SD39' target='_blank'>SD39</a></td><td>Toni Atkins</td><td>D +21.32%</td><td>Biden +33.20</td></tr>
								<tr><td><a href='/book/new/SD40' target='_blank'>SD40</a></td><td><a href='/book/old/SD38' target='_blank'>SD38</a></td><td>Brian Jones</td><td>R +2.58%</td><td>Biden +6.32</td></tr>

							</tbody>
						</table>
					</div>
					<div class='col-sm-4'>
						<h2>Congress</h2>
						<table class='table-striped' v-ctb-table>

							<thead>
								<tr>
									<th>NEW #</th>
									<th>OLD #</th>
									<th>INCUMBENT</th>
									<th>REG ADV</th>
									<th>PRS '20</th>
								</tr>
							</thead>						
							<tbody>



								<tr><td><a href='/book/new/CD01' target='_blank'>CD01</a></td><td><a href='/book/old/CD01' target='_blank'>CD01</a></td><td>Doug LaMalfa</td><td>R +14.16%</td><td>Trump +19.08</td></tr>
								<tr><td><a href='/book/new/CD02' target='_blank'>CD02</a></td><td><a href='/book/old/CD02' target='_blank'>CD02</a></td><td>Jared Huffman</td><td>D +35.06%</td><td>Biden +49.53</td></tr>
								<tr><td><a href='/book/new/CD03' target='_blank'>CD03</a></td><td><a href='/book/old/CD04' target='_blank'>CD04</a></td><td>Tom McClintock</td><td>R +6.76%</td><td>Trump +1.78</td></tr>
								<tr><td><a href='/book/new/CD04' target='_blank'>CD04</a></td><td><a href='/book/old/CD05' target='_blank'>CD05</a></td><td>Mike Thompson</td><td>D +26.50%</td><td>Biden +36.58</td></tr>
								<tr><td><a href='/book/new/CD05' target='_blank'>CD05</a></td><td><a href='/book/old/CD10' target='_blank'>CD10</a></td><td>Joshua Harder</td><td>R +11.52%</td><td>Trump +12.30</td></tr>
								<tr><td><a href='/book/new/CD06' target='_blank'>CD06</a></td><td><a href='/book/old/CD07' target='_blank'>CD07</a></td><td>Ami Bera</td><td>D +13.90%</td><td>Biden +18.33</td></tr>
								<tr><td><a href='/book/new/CD07' target='_blank'>CD07</a></td><td><a href='/book/old/CD06' target='_blank'>CD06</a></td><td>Doris Matsui</td><td>D +28.83%</td><td>Biden +37.23</td></tr>
								<tr><td><a href='/book/new/CD08' target='_blank'>CD08</a></td><td><a href='/book/old/CD03' target='_blank'>CD03</a></td><td>John Garamendi</td><td>D +44.07%</td><td>Biden +54.08</td></tr>
								<tr><td><a href='/book/new/CD09' target='_blank'>CD09</a></td><td><a href='/book/old/CD09' target='_blank'>CD09</a></td><td>Jerry McNerney</td><td>D +13.37%</td><td>Biden +12.60</td></tr>
								<tr><td><a href='/book/new/CD10' target='_blank'>CD10</a></td><td><a href='/book/old/CD11' target='_blank'>CD11</a></td><td>Mark DeSaulnier</td><td>D +25.40%</td><td>Biden +39.25</td></tr>
								<tr><td><a href='/book/new/CD11' target='_blank'>CD11</a></td><td><a href='/book/old/CD12' target='_blank'>CD12</a></td><td>Nancy Pelosi</td><td>D +56.27%</td><td>Biden +74.57</td></tr>
								<tr><td><a href='/book/new/CD12' target='_blank'>CD12</a></td><td><a href='/book/old/CD13' target='_blank'>CD13</a></td><td>Barbara Lee</td><td>D +63.30%</td><td>Biden +80.74</td></tr>
								<tr><td><a href='/book/new/CD13' target='_blank'>CD13*</a></td><td><a href='/book/old/CD16' target='_blank'>CD16</a></td><td>Jim Costa</td><td>D +13.49%</td><td>Biden +11.16</td></tr>
								<tr><td><a href='/book/new/CD14' target='_blank'>CD14</a></td><td><a href='/book/old/CD15' target='_blank'>CD15</a></td><td>Eric Swalwell</td><td>D +34.44%</td><td>Biden +45.42</td></tr>
								<tr><td><a href='/book/new/CD15' target='_blank'>CD15</a></td><td><a href='/book/old/CD14' target='_blank'>CD14</a></td><td>Jackie Speier</td><td>D +41.74%</td><td>Biden +57.37</td></tr>
								<tr><td><a href='/book/new/CD16' target='_blank'>CD16</a></td><td><a href='/book/old/CD18' target='_blank'>CD18</a></td><td>Anna Eshoo</td><td>D +33.88%</td><td>Biden +52.94</td></tr>
								<tr><td><a href='/book/new/CD17' target='_blank'>CD17</a></td><td><a href='/book/old/CD17' target='_blank'>CD17</a></td><td>Ro Khanna</td><td>D +32.95%</td><td>Biden +47.49</td></tr>
								<tr><td><a href='/book/new/CD18' target='_blank'>CD18*</a></td><td><a href='/book/old/CD19' target='_blank'>CD19</a></td><td>Zoe Lofgren</td><td>D +35.54%</td><td>Biden +44.01</td></tr>
								<tr><td><a href='/book/new/CD19' target='_blank'>CD19</a></td><td><a href='/book/old/CD20' target='_blank'>CD20</a></td><td>Jimmy Panetta</td><td>D +26.75%</td><td>Biden +39.59</td></tr>
								<tr><td><a href='/book/new/CD20' target='_blank'>CD20</a></td><td><a href='/book/old/CD23' target='_blank'>CD23</a></td><td>Kevin McCarthy</td><td>R +21.13%</td><td>Trump +24.94</td></tr>
								<tr><td><a href='/book/new/CD21' target='_blank'>CD21*</a></td><td><a href='/book/old/CD22' target='_blank'>CD22</a></td><td>Devin Nunes</td><td>D +16.75%</td><td>Biden +20.35</td></tr>
								<tr><td><a href='/book/new/CD22' target='_blank'>CD22*</a></td><td><a href='/book/old/CD21' target='_blank'>CD21</a></td><td>David Valadao</td><td>D +16.92%</td><td>Biden +13.24</td></tr>
								<tr><td><a href='/book/new/CD23' target='_blank'>CD23</a></td><td><a href='/book/old/CD08' target='_blank'>CD08</a></td><td>Jay Obernolte</td><td>R +4.39%</td><td>Trump +9.79</td></tr>
								<tr><td><a href='/book/new/CD24' target='_blank'>CD24</a></td><td><a href='/book/old/CD24' target='_blank'>CD24</a></td><td>Salud Carbajal</td><td>D +17.47%</td><td>Biden +28.93</td></tr>
								<tr><td><a href='/book/new/CD25' target='_blank'>CD25*</a></td><td><a href='/book/old/CD36' target='_blank'>CD36</a></td><td>Raul Ruiz</td><td>D +15.81%</td><td>Biden +15.34</td></tr>
								<tr><td><a href='/book/new/CD26' target='_blank'>CD26</a></td><td><a href='/book/old/CD26' target='_blank'>CD26</a></td><td>Julia Brownley</td><td>D +12.27%</td><td>Biden +20.00</td></tr>
								<tr><td><a href='/book/new/CD27' target='_blank'>CD27</a></td><td><a href='/book/old/CD25' target='_blank'>CD25</a></td><td>Mike Garcia</td><td>D +9.92%</td><td>Biden +12.34</td></tr>
								<tr><td><a href='/book/new/CD28' target='_blank'>CD28</a></td><td><a href='/book/old/CD27' target='_blank'>CD27</a></td><td>Judy Chu</td><td>D +22.26%</td><td>Biden +33.94</td></tr>
								<tr><td><a href='/book/new/CD29' target='_blank'>CD29</a></td><td><a href='/book/old/CD29' target='_blank'>CD29</a></td><td>Tony Cardenas</td><td>D +41.86%</td><td>Biden +51.15</td></tr>
								<tr><td><a href='/book/new/CD30' target='_blank'>CD30</a></td><td><a href='/book/old/CD28' target='_blank'>CD28</a></td><td>Adam Schiff</td><td>D +36.78%</td><td>Biden +45.97</td></tr>
								<tr><td><a href='/book/new/CD31' target='_blank'>CD31*</a></td><td><a href='/book/old/CD32' target='_blank'>CD32</a></td><td>Grace Napolitano</td><td>D +25.89%</td><td>Biden +31.05</td></tr>
								<tr><td><a href='/book/new/CD32' target='_blank'>CD32</a></td><td><a href='/book/old/CD30' target='_blank'>CD30</a></td><td>Brad Sherman</td><td>D +30.60%</td><td>Biden +40.65</td></tr>
								<tr><td><a href='/book/new/CD33' target='_blank'>CD33*</a></td><td><a href='/book/old/CD31' target='_blank'>CD31</a></td><td>Pete Aguilar</td><td>D +21.95%</td><td>Biden +25.40</td></tr>
								<tr><td><a href='/book/new/CD34' target='_blank'>CD34</a></td><td><a href='/book/old/CD34' target='_blank'>CD34</a></td><td>Jimmy Gomez</td><td>D +51.39%</td><td>Biden +64.43</td></tr>
								<tr><td><a href='/book/new/CD35' target='_blank'>CD35*</a></td><td><a href='/book/old/CD35' target='_blank'>CD35</a></td><td>Norma Torres</td><td>D +24.59%</td><td>Biden +27.94</td></tr>
								<tr><td><a href='/book/new/CD36' target='_blank'>CD36</a></td><td><a href='/book/old/CD33' target='_blank'>CD33</a></td><td>Ted Lieu</td><td>D +28.02%</td><td>Biden +43.84</td></tr>
								<tr><td><a href='/book/new/CD37' target='_blank'>CD37</a></td><td><a href='/book/old/CD37' target='_blank'>CD37</a></td><td>Karen Bass</td><td>D +59.07%</td><td>Biden +73.29</td></tr>
								<tr><td><a href='/book/new/CD38' target='_blank'>CD38*</a></td><td><a href='/book/old/CD38' target='_blank'>CD38</a></td><td>Linda Sanchez</td><td>D +25.30%</td><td>Biden +30.28</td></tr>
								<tr><td><a href='/book/new/CD39' target='_blank'>CD39*</a></td><td><a href='/book/old/CD41' target='_blank'>CD41</a></td><td>Mark Takano</td><td>D +23.00%</td><td>Biden +26.17</td></tr>
								<tr><td><a href='/book/new/CD40' target='_blank'>CD40</a></td><td><a href='/book/old/CD45' target='_blank'>CD45</a></td><td>Young Kim</td><td>R +7.69%</td><td>Biden +1.64</td></tr>
								<tr><td><a href='/book/new/CD41' target='_blank'>CD41</a></td><td><a href='/book/old/CD42' target='_blank'>CD42</a></td><td>Ken Calvert</td><td>R +2.66%</td><td>Trump +1.17</td></tr>
								<tr><td><a href='/book/new/CD42' target='_blank'>CD42*</a></td><td><a href='/book/old/CD47' target='_blank'>CD47</a></td><td>Alan Lowenthal</td><td>D +37.18%</td><td>Biden +45.79</td></tr>
								<tr><td><a href='/book/new/CD43' target='_blank'>CD43</a></td><td><a href='/book/old/CD43' target='_blank'>CD43</a></td><td>Maxine Waters</td><td>D +51.82%</td><td>Biden +63.81</td></tr>
								<tr><td><a href='/book/new/CD44' target='_blank'>CD44*</a></td><td><a href='/book/old/CD44' target='_blank'>CD44</a></td><td>Nanette Barragan</td><td>D +40.25%</td><td>Biden +48.18</td></tr>
								<tr><td><a href='/book/new/CD45' target='_blank'>CD45</a></td><td><a href='/book/old/CD39' target='_blank'>CD39</a></td><td>Michelle Steel</td><td>D +3.61%</td><td>Biden +6.16</td></tr>
								<tr><td><a href='/book/new/CD46' target='_blank'>CD46*</a></td><td><a href='/book/old/CD46' target='_blank'>CD46</a></td><td>Lou Correa</td><td>D +26.44%</td><td>Biden +30.40</td></tr>
								<tr><td><a href='/book/new/CD47' target='_blank'>CD47</a></td><td><a href='/book/old/CD48' target='_blank'>CD48</a></td><td>Katie Porter</td><td>R +0.40%</td><td>Biden +10.78</td></tr>
								<tr><td><a href='/book/new/CD48' target='_blank'>CD48</a></td><td><a href='/book/old/CD50' target='_blank'>CD50</a></td><td>Darrell Issa</td><td>R +14.02%</td><td>Trump +12.59</td></tr>
								<tr><td><a href='/book/new/CD49' target='_blank'>CD49</a></td><td><a href='/book/old/CD49' target='_blank'>CD49</a></td><td>Mike Levin</td><td>D +0.13%</td><td>Biden +11.29</td></tr>
								<tr><td><a href='/book/new/CD50' target='_blank'>CD50</a></td><td><a href='/book/old/CD52' target='_blank'>CD52</a></td><td>Scott Peters</td><td>D +16.19%</td><td>Biden +33.14</td></tr>
								<tr><td><a href='/book/new/CD51' target='_blank'>CD51</a></td><td><a href='/book/old/CD53' target='_blank'>CD53</a></td><td>Sara Jacobs</td><td>D +15.32%</td><td>Biden +27.41</td></tr>
								<tr><td><a href='/book/new/CD52' target='_blank'>CD52*</a></td><td><a href='/book/old/CD51' target='_blank'>CD51</a></td><td>Juan Vargas</td><td>D +28.47%</td><td>Biden +36.85</td></tr>



								</tbody>
							</table>
						</div>
					</div>
  				</div>
			</div>


@endsection


@section('scripts')

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<script type='text/javascript'>

<?php
    
    // foreach($endjava as $value) {
    //     echo($value);
    // }

?>

</script>


@endsection



@section('styles')

<style>

.ported {
    height: 100vh;
}

.rightme {
  text-align: right !important;
}

.countdown {
  text-align: center;
  font-family: 'Lato';
  font-size: 60px;
  margin-top:0px;
}

</style>


@endsection