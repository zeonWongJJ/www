<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>提示信息</title>
<meta http-equiv="refresh" content="<?php echo $a_view_data['wait'];?>;url=<?php echo $a_view_data['url'];?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
<style type="text/css">
@import url('normalize.css');

/* General Demo Style */
body{
	font-family: Cambria, Palatino, "Palatino Linotype", "Palatino LT STD", Georgia, serif;
	background: #fff url(../images/bg.jpg) repeat top left;
	font-weight: 400;
	font-size: 15px;
	color: #333;
	-webkit-font-smoothing: antialiased;
	-moz-font-smoothing: antialiased;
	font-smoothing: antialiased;
}
a{
	color: #555;
	text-decoration: none;
}
.clr {
	clear: both;
	padding: 0;
	height: 0;
	margin: 0;
}
.container{
	width: 100%;
	position: relative;
	min-height: 350px;
	text-align: center;
	position: absolute;
    top: 50%;
    transform: translateY(-50%);
}
.container > header{
	margin: 10px 10px 0px 10px;
	padding: 20px 10px 0px 10px;
	position: relative;
	display: block;
	text-shadow: 1px 1px 1px rgba(0,0,0,0.2);
    text-align: center;
}
.container > header > span{
	font-size: 20px;
	line-height: 20px;
	display: block;
	font-weight: 400;
	font-style: italic;
	color: #719dab;
	text-shadow: 1px 1px 1px rgba(0,0,0,0.1);
	font-family: 'Alegreya SC', Georgia, serif;
}
.container > header h1{
	font-size: 36px;
	line-height: 36px;
	margin: 0;
	position: relative;
	font-weight: 300;
	color: #498ea5;
	padding: 5px 0px;
	text-shadow: 1px 1px 1px rgba(255,255,255,0.7);
}
.container > header h1 span{
	font-weight: 700;
}
.container > header h2{
	font-size: 14px;
	font-weight: 300;
	letter-spacing: 2px;
	text-transform: uppercase;
	margin: 0;
	padding: 15px 0 5px 0;
	color: #6190ca;
	text-shadow: 1px 1px 1px rgba(255,255,255,0.7);
}
.container > header p{
	font-style: italic;
	color: #aaa;
	text-shadow: 1px 1px 1px rgba(255,255,255,0.7);
}
/* Header Style */
.codrops-top{
	text-align: left;
	line-height: 24px;
	font-size: 11px;
	background: #fff;
	background: rgba(255, 255, 255, 0.7);
	text-transform: uppercase;
	z-index: 9999;
	position: relative;
	font-family: Cambria, Georgia, serif;
	box-shadow: 1px 0px 2px rgba(0,0,0,0.2);
}
.codrops-top a{
	padding: 0px 10px;
	letter-spacing: 1px;
	color: #333;
	display: inline-block;
}
.codrops-top a:hover{
	background: rgba(255,255,255,0.3);
}
.codrops-top span.right{
	float: right;
}
.codrops-top span.right a{
	float: left;
	display: block;
}
.support-note span{
	color: #ac375d;
	font-size: 16px;
	display: none;
	font-weight: bold;
	text-align: center;
	padding: 5px 0;
}
.no-cssanimations .support-note span.no-cssanimations,
.no-csstransforms .support-note span.no-csstransforms,
.no-csstransforms3d .support-note span.no-csstransforms3d,
.no-csstransitions .support-note span.no-csstransitions{
	display: block;
}

button.fire{
	color: #fff;
	display: inline-block;
	margin: 5px auto 30px auto;
	border-radius: 4px;
	padding: 0px 15px;
	height: 30px;
	line-height: 30px;
	width: 160px;
	font-family: Cambria, Palatino, "Palatino Linotype", "Palatino LT STD", Georgia, serif;;
	font-weight: bold;
	font-size: 13px;
	text-shadow: 0 1px 1px rgba(0,0,0,0.3);
	border: 1px solid #377a90;
	background: #6fafc4; /* Old browsers */
	background: -moz-linear-gradient(top, #6fafc4 0%, #498ea5 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#6fafc4), color-stop(100%,#498ea5)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, #6fafc4 0%,#498ea5 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, #6fafc4 0%,#498ea5 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, #6fafc4 0%,#498ea5 100%); /* IE10+ */
	background: linear-gradient(top, #6fafc4 0%,#498ea5 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#6fafc4', endColorstr='#498ea5',GradientType=0 ); /* IE6-9 */
	box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
	z-index: 10;
}
input.fire-check:hover + button.fire{
	box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
}
input.fire-check:checked + button.fire{
	color: #377a90;
	border-color: #4991a9;
	text-shadow: 0 1px 1px rgba(255,255,255,0.6);
	background: #94cde0;
	text-shadow: 0px 1px 1px rgba(255,255,255,0.4);
	box-shadow: 0px 1px 1px rgba(255, 255, 255, 0.5);
}
input.fire-check{
	width: 160px;
	position: absolute;
	left: 50%;
	margin-left: -80px;
	height: 35px;
	cursor: pointer;
	opacity: 0;
	z-index: 100;
}

.no-cssanimations button.fire,
.no-cssanimations input.fire-check{
	display: none;
}
.tn-box {
	width: 70%;
	position: relative;
	margin: 20px auto 20px auto;
	padding: 50px 15px;
	text-align: left;
	border-radius: 5px;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1), inset 0 1px 0 rgba(255,255,255,0.6);  
	/*opacity: 0;*/
	-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
	filter: alpha(opacity=0);	
	cursor: default;
	/*display: none;*/
}
@media screen and (min-width: 450px) { 
	.tn-box {width: 360px} 
}
.tn-box p {
	font-weight: bold;
	font-size: 30px;
	margin: 0;
	padding: 0 10px 0 60px;
	text-shadow: 0 1px 1px rgba(255,255,255,0.6);
}
.tn-box p:before{
	text-align: center;
	border: 3px solid rgba(255, 255, 255, 1);
	margin-top: -17px;
	top: 50%;
	left: 20px;
	width: 30px;
	content: 'i';
	font-size: 30px;
	color: rgba(255, 255, 255, 1);
	position: absolute;
	height: 30px;
	line-height: 30px;
	border-radius: 50%;
	text-shadow: 1px 1px 1px rgba(0,0,0,0.1);
	box-shadow: 1px 1px 1px rgba(0,0,0,0.1);
}
.remind-info p:before{
	text-align: center;
	border: 3px solid rgba(255, 255, 255, 1);
	margin-top: -17px;
	top: 50%;
	left: 20px;
	width: 30px;
	content: 'i';
	font-size: 30px;
	color: rgba(255, 255, 255, 1);
	position: absolute;
	height: 30px;
	line-height: 30px;
	border-radius: 50%;
	text-shadow: 1px 1px 1px rgba(0,0,0,0.1);
	box-shadow: 1px 1px 1px rgba(0,0,0,0.1);
}
.remind-error p:before{
	text-align: center;
	border: 3px solid red;
	margin-top: -17px;
	top: 50%;
	left: 20px;
	width: 30px;
	content: '✘';
	font-size: 30px;
	color: red;
	position: absolute;
	height: 30px;
	line-height: 30px;
	border-radius: 50%;
	text-shadow: 1px 1px 1px rgba(0,0,0,0.1);
	box-shadow: 1px 1px 1px rgba(0,0,0,0.1);
}
.remind-success p:before{
	text-align: center;
	border: 3px solid #1E90FF;
	margin-top: -17px;
	top: 50%;
	left: 20px;
	width: 30px;
	content: '✔';
	font-size: 30px;
	color: #1E90FF;
	position: absolute;
	height: 30px;
	line-height: 30px;
	border-radius: 50%;
	text-shadow: 1px 1px 1px rgba(0,0,0,0.1);
	box-shadow: 1px 1px 1px rgba(0,0,0,0.1);
}
.remind-warning p:before{
	text-align: center;
	border: 3px solid #EE00EE;
	margin-top: -17px;
	top: 50%;
	left: 20px;
	width: 30px;
	content: '!';
	font-size: 30px;
	color: #EE00EE;
	position: absolute;
	height: 30px;
	line-height: 30px;
	border-radius: 50%;
	text-shadow: 1px 1px 1px rgba(0,0,0,0.1);
	box-shadow: 1px 1px 1px rgba(0,0,0,0.1);
}
.tn-progress {
	width: 0;
	height: 4px;
	background: rgba(255,255,255,0.3);
	position: absolute;
	bottom: 5px;
	left: 2%;
	border-radius: 3px;
	box-shadow: 
		inset 0 1px 1px rgba(0,0,0,0.05), 
		0 -1px 0 rgba(255,255,255,0.6);
}

/* Colors */

.tn-box-color-1{
	background: #ffe691;
	border: 1px solid #f6db7b;
}
.tn-box-color-1 p {
	color: #7d5912;
}

.tn-box-color-2{
	background: #99ffb1;
	border: 1px solid #7ce294;
}
.tn-box-color-2 p {
	color: #2d8241;
}

.tn-box-color-3{
	background: #66CD00;
	border: 1px solid #458B00;
}
.tn-box-color-3 p {
	color: #0000EE;
}

.tn-box-color-4{
	background: #FFA500;
	border: 1px solid #FF7F00;
}
.tn-box-color-4 p {
	color: red;
}

/* Fire the animations */

input.fire-check:checked ~ section .tn-box {
	display: block;
	-webkit-animation: fadeOut 5s linear forwards;
	-moz-animation: fadeOut 5s linear forwards;
	-o-animation: fadeOut 5s linear forwards;
	-ms-animation: fadeOut 5s linear forwards;
	animation: fadeOut 5s linear forwards;
}

.tn-progress {
	-webkit-animation: runProgress 4s linear forwards 0.5s;
	-moz-animation: runProgress 4s linear forwards 0.5s;
	-o-animation: runProgress 4s linear forwards 0.5s;
	-ms-animation: runProgress 4s linear forwards 0.5s;
	animation: runProgress <?php echo ($a_view_data['wait'] - 1.2) > 0 ? ($a_view_data['wait'] - 1.2) : $a_view_data['wait'];?>s linear forwards 0.5s;
}

/* If you use JavaScript you could add a class instead: */

.tn-box.tn-box-active {
	display: block;
	-webkit-animation: fadeOut 5s linear forwards;
	-moz-animation: fadeOut 5s linear forwards;
	-o-animation: fadeOut 5s linear forwards;
	-ms-animation: fadeOut 5s linear forwards;
	animation: fadeOut 5s linear forwards;
}

.tn-box.tn-box-active .tn-progress {
	-webkit-animation: runProgress 4s linear forwards 0.5s;
	-moz-animation: runProgress 4s linear forwards 0.5s;
	-o-animation: runProgress 4s linear forwards 0.5s;
	-ms-animation: runProgress 4s linear forwards 0.5s;
	animation: runProgress 4s linear forwards 0.5s;
}


@-webkit-keyframes fadeOut {
	0% { opacity: 0; }
	10% { opacity: 1; }
	90% { opacity: 1; -webkit-transform: translateY(0px);}
	99% { opacity: 0; -webkit-transform: translateY(-30px);}
	100% { opacity: 0; }
}

@-moz-keyframes fadeOut {
	0% { opacity: 0; }
	10% { opacity: 1; }
	90% { opacity: 1; -moz-transform: translateY(0px);}
	99% { opacity: 0; -moz-transform: translateY(-30px);}
	100% { opacity: 0; }
}

@-o-keyframes fadeOut {
	0% { opacity: 0; }
	10% { opacity: 1; }
	90% { opacity: 1; -o-transform: translateY(0px);}
	99% { opacity: 0; -o-transform: translateY(-30px);}
	100% { opacity: 0; }
}

@-ms-keyframes fadeOut {
	0% { opacity: 0; }
	10% { opacity: 1; }
	90% { opacity: 1; -ms-transform: translateY(0px);}
	99% { opacity: 0; -ms-transform: translateY(-30px);}
	100% { opacity: 0; }
}

@keyframes fadeOut {
	0% { opacity: 0; }
	10% { opacity: 1; }
	90% { opacity: 1; transform: translateY(0px);}
	99% { opacity: 0; transform: translateY(-30px);}
	100% { opacity: 0; }
}

@-webkit-keyframes runProgress {
	0%{ width: 0%; background: rgba(255,255,255,0.3); }
	100%{ width: 96%; background: rgba(255,255,255,1); }
}

@-moz-keyframes runProgress {
	0%{ width: 0%; background: rgba(255,255,255,0.3); }
	100%{ width: 96%; background: rgba(255,255,255,1); }
}

@-o-keyframes runProgress {
	0%{ width: 0%; background: rgba(255,255,255,0.3); }
	100%{ width: 96%; background: rgba(255,255,255,1); }
}

@-ms-keyframes runProgress {
	0%{ width: 0%; background: rgba(255,255,255,0.3); }
	100%{ width: 96%; background: rgba(255,255,255,1); }
}

@keyframes runProgress {
	0%{ width: 0%; background: rgba(255,255,255,0.3); }
	100%{ width: 96%; background: rgba(255,255,255,1); }
}


/* Let's add some different durations for the demo */

input.fire-check:checked ~ section .tn-box:nth-child(2) {
	-webkit-animation-duration: 6s;
	-moz-animation-duration: 6s;
	-o-animation-duration: 6s;
	-ms-animation-duration: 6s;
	animation-duration: 6s;
	
	-webkit-animation-delay: 0.2s;
	-moz-animation-delay: 0.2s;
	-o-animation-delay: 0.2s;
	-ms-animation-delay: 0.2s;
	animation-delay: 0.2s;
}

input.fire-check:checked ~ section .tn-box:nth-child(2) .tn-progress {
	-webkit-animation-duration: 5s;
	-moz-animation-duration: 5s;
	-o-animation-duration: 5s;
	-ms-animation-duration: 5s;
	animation-duration: 5s;
	
	-webkit-animation-delay: 0.7s;
	-moz-animation-delay: 0.7s;
	-o-animation-delay: 0.7s;
	-ms-animation-delay: 0.7s;
	animation-delay: 0.7s;
}

input.fire-check:checked ~ section .tn-box:nth-child(3) {
	-webkit-animation-duration: 9s;
	-moz-animation-duration: 9s;
	-o-animation-duration: 9s;
	-ms-animation-duration: 9s;
	animation-duration: 9s;
	
	-webkit-animation-delay: 0.4s;
	-moz-animation-delay: 0.4s;
	-o-animation-delay: 0.4s;
	-ms-animation-delay: 0.4s;
	animation-delay: 0.4s;
}

input.fire-check:checked ~ section .tn-box:nth-child(3) .tn-progress {
	-webkit-animation-duration: 7.5s;
	-moz-animation-duration: 7.5s;
	-o-animation-duration: 7.5s;
	-ms-animation-duration: 7.5s;
	animation-duration: 7.5s;
	
	-webkit-animation-delay: 0.9s;
	-moz-animation-delay: 0.9s;
	-o-animation-delay: 0.9s;
	-ms-animation-delay: 0.9s;
	animation-delay: 0.9s;
}

/* Last example pauses on hover (causes problems in WebKit browsers) */

.tn-box.tn-box-hoverpause:hover, 
.tn-box.tn-box-hoverpause:hover .tn-progress{
	-webkit-animation-play-state: paused;
	-moz-animation-play-state: paused;
	-o-animation-play-state: paused;
	-ms-animation-play-state: paused;
	animation-play-state: paused;
}
</style>
</head>

<body>
<div class="container">
	<section>
<?php
if ($a_view_data['type'] == 'remind') {
?>
	<div class="tn-box tn-box-color-2 remind-info">
		<p><?php echo $a_view_data['msg'];?><p>
		<div class="tn-progress"></div>
	</div>
<?php
}
?>

<?php
if ($a_view_data['type'] == 'success') {
?>
	<div class="tn-box tn-box-color-3 remind-success">
		<p><?php echo $a_view_data['msg'];?></</p>
		<div class="tn-progress"></div>
	</div>
<?php
}
?>

<?php
if ($a_view_data['type'] == 'error') {
?>
	<div class="tn-box tn-box-color-4 remind-error">
		<p><?php echo $a_view_data['msg'];?><p>
		<div class="tn-progress"></div>
	</div>
<?php
}
?>

<?php
if ($a_view_data['type'] == 'warning') {
?>
	<div class="tn-box tn-box-color-1 remind-warning">
		<p><?php echo $a_view_data['msg'];?></p>
		<div class="tn-progress"></div>
	</div>
<?php
}
?>
	</section>
</div>
</body>
</html>
