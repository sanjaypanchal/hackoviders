function displayMesg(mesg)
{
	alert (mesg);
}

function logout(host)
{
	alert(host);
	//document.forms["main"].submit();
	var url = "http://" + host + "/nand/welcome.php?btnLogout=Logout";
	alert (url);
	window.location = url;
}

function setFocus(controlId)
{
	document.getElementById(controlId).focus();
}


//Function to allow only numbers to textbox
function validate(key)
{
	//getting key code of pressed key
	var keycode = (key.which) ? key.which : key.keyCode;
	//comparing pressed keycodes
	if ((keycode == 8) || (keycode == 9) || (keycode == 13) || (keycode == 116) || (keycode == 46) || (keycode > 36 && keycode < 41) || (keycode > 47 && keycode < 58))
	{
		return true;
	}
	else
	{
		return false;
	}
}


function click_report(url)
{
//	alert (url);
	window.location = url;
}

function printReport(type)
{
	var printWin;
	if (type == "moderator")
	{
		printWin = window.open('./printReport.php',  'open_window', 'menubar, toolbar, location, directories, status, scrollbars, resizable, dependent, width=8000, height=6400, left=0, top=0, fullscreen=yes');
	}
	else
	{
		printWin = window.open('./printReport_man.php',  'open_window', 'menubar, toolbar, location, directories, status, scrollbars, resizable, dependent, width=8000, height=6400, left=0, top=0, fullscreen=yes');
	}
	printWin.focus();
}


function printWin()
{
	window.print();
	window.close();
}

function checkRating()
{
	var rating_1 = document.getElementById('sltRating1');
	var rating_2p = document.getElementById('sltRating2p');
	var rating_2 = document.getElementById('sltRating2');
	var rating_3 = document.getElementById('sltRating3');
	var rating_4 = document.getElementById('sltRating4');
	var rating_all = document.getElementById('sltRatingAll');

	if (rating_all.checked == true)
	{
		rating_1.checked = rating_2p.checked = rating_2.checked = rating_3.checked = rating_4.checked = true;
	}
	else
	{
		rating_1.checked = rating_2p.checked = rating_2.checked = rating_3.checked = rating_4.checked = false;
	}
}


function selectCan(candidate)
{
	//var radCandidate = document.getElementById('radCandidate');
	var hidCandidate = document.getElementById('hidCandidate');
	var selected = hidCandidate.value;
	var old_selected = new Array();
	var remove = -1;
	var button_flag = false;

	if (selected == "")
	{
		old_selected[0] = "";
		old_selected[1] = "";
	}
	else
	{
		if (selected.length == 1)
		{
			old_selected[0] = selected;
			old_selected[1] = "";
		}
		else
		{
			old_selected = selected.split(",");
		}
	}

	if (document.getElementById('radCandidate'+candidate).checked == false)
	{
		if (old_selected[0] == candidate)
		{
			old_selected[0] = old_selected[1];
			old_selected[1] = "";
		}
		else if (old_selected[1] == candidate)
		{
			old_selected[1] = "";
		}
	}
	else
	{
		remove = old_selected[1];
		old_selected[1] = old_selected[0];
		old_selected[0] = candidate;
		
		if ((remove != "") && (document.getElementById('radCandidate'+remove) != null))
		{
			document.getElementById('radCandidate'+remove).checked = false;
		}
		if ((old_selected[0] != "") && (document.getElementById('radCandidate'+old_selected[0]) != null))
		{
			document.getElementById('radCandidate'+old_selected[0]).checked = true;
		}
		if ((old_selected[1] != "") && (document.getElementById('radCandidate'+old_selected[1]) != null))
		{
			document.getElementById('radCandidate'+old_selected[1]).checked = true;
		}
//		document.getElementById('radCandidate'+old_selected[1]).checked = true;
//alert ("radCandidate"+candidate + "=" + document.getElementById('radCandidate'+candidate).checked + "\nold_selected[0]="+old_selected[0]+"\nold_selected[1]="+old_selected[1]+"\nremove="+remove);
	}

	hidCandidate.value = old_selected[0] + "," + old_selected[1];

	if ((old_selected[0] != "") && (old_selected[1] != ""))
	{
		document.getElementById('btnVotingSubmit').style.visibility = 'visible';
	}
	else
	{
		document.getElementById('btnVotingSubmit').style.visibility = 'hidden';
	}
//	alert ("old selected=" + selected + "\nnew selected=>" + old_selected[0] + "<,>" + old_selected[1] + "<");
}

