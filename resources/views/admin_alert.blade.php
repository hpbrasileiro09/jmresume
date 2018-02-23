<?php

	$_kind = session('kind', -1);
	$_msg = session('msg', "");

	$html = "";
	$_class = "";
	$_type = "";

	switch ($_kind) {
	case 1:
		$_class = "alert-success";
		$_type = "Well done!";
		break;
	case 2:
		$_class = "alert-info";
		$_type = "Heads up!";
		break;
	case 3:
		$_class = "alert-danger";
		$_type = "O snap!";
		break;
	case 4:
		$_class = "alert-warning";
		$_type = "Warning!";
		break;
	}

	if ($_kind != -1) {
		$html .= "<div id=\"message-alert\" class=\"alert alert-dismissable fade show ".$_class."\">";
		$html .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>";
		$html .= "<h4>".$_type."</h4>";
		$html .= "<p>". $_msg ."</p>";
		$html .= "</div>";
	}

	session(['kind' => -1]);
	session(['msg' => ""]);

	echo "[".$html."]";

?>