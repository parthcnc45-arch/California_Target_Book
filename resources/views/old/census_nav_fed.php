<?php 


if(isset($_POST['submit'])){


} // brace for if(isset($_POST['submit']))

?>

<style type="text/css">

.holds-the-iframe {
	background: url('/img/spinner.gif') center center no-repeat;

}

#dropdown {
	text-align: center;
	margin-left: auto;
	margin-right: auto;
}

select {
	display: inline-block;
	margin: 0 auto;
}

</style>

<form id="form" name="form" onsubmit="return false" method="post">
	<div id="containerdiv" width="100%">

		<select id="office" name="office">
			<option value="">SELECT REPORT</option>
			<option value="age">Population % By Age Group</option>
			<option value="race">Population % By Ethnicity</option>
			<option value="school">Population % Currently Enrolled in School</option>
			<option value="education">Population % By Level of Education</option>
			<option value="veteran">Population % of Military Veterans</option>
			<option value="born">Population % By Place of Birth</option>
			<option value="language">Population % By Language Spoken At Home</option>
			<option value="occupation">Population % By Employment Category</option>
			<option value="industry">Population % By Employment Industry</option>
			<option value="class">Population % By Employment Classification (Private/Govt/Self)</option>
			<option value="income">Population % By Income Level</option>
		</select>

		<button id="submitbutton" type="button" onclick="formhandler();">Submit</button>
	</div>
</form>

<div id="hiddendiv" class="holds-the-iframe" style="display: none;" style="background-image: url('/img/spinner.gif');" >

</div>

<script language="javascript">


function formhandler(form){

closeiframe();
var link = "/img/spinner.gif";
window.content.location.href=link;
document.getElementById("hiddendiv").style["display"] = "inline-block";
var URL = "http://calelections.com/census_compare_fed.php?id=" + document.form.office.value;
//alert(URL);
 window.content.location.href=URL;
 return false;


}

function closeiframe(type) {
	removeiframes();
	var link = "/img/spinner.gif";
	var iframe = document.createElement('iframe');
	iframe.frameBorder=0;
	iframe.width="1280px";
	iframe.height="1280px";
	iframe.id="hiddeniframe";
	iframe.name="content";
	iframe.setAttribute("src", link);
	iframe.setAttribute("background-color", "white");
	document.getElementById("hiddendiv").appendChild(iframe);
	return false;
}

function removeiframes(){
	var iframes = document.querySelectorAll('iframe');
	for (var i = 0; i < iframes.length; i++) {
    iframes[i].parentNode.removeChild(iframes[i]);
	}
}

</script>

