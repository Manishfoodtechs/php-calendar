<?
	include("header.php");
	include("config.php");

	$tablename = date('Fy', mktime(0,0,0,$month,1,$year));
	$monthname = date('F', mktime(0,0,0,$month,1,$year));

	if(!($day && $month && $year)) {
		$day = date("j", time());
		$month = date("n", time());
		$year = date("Y", time());
	}
	$lastday = $day - 1;
	$lastmonth = $month;
	$lastyear = $year;
	if($lastday == 0) {
		$lastmonth = $lastmonth - 1;
		$lastday = 28;
		if($lastmonth == 0) {
			$lastyear = $lastyear - 1;
			$lastmonth = 12;
		}
	        while (checkdate($month,$lastday,$year))
        	{
                	$lastday++;
        	}
	}

	$nextday = $day + 1;
	$nextmonth = $month;
	$nextyear = $year;
	if(!checkdate($month, $nextday, $year)) {
		$nextmonth = $nextmonth + 1;
		$nextday = 1;
		if($nextmonth == 13) {
			$nextyear = $nextyear + 1;
			$nextmonth = 1;
		}
	}

	echo "<table class=nav>
	<tr>
	<td><a href=\"display.php?month=$lastmonth&amp;day=$lastday&amp;year=$lastyear\">$lastmonthname $lastday</a></td>
	<td><a href=\"display.php?month=$nextmonth&amp;day=$nextday&amp;year=$nextyear\">$nextmonthname $nextday</a></td>
	</tr>
	</table>
	<form action=operate.php>
	<table cellspacing=2 class=display>
	<tr><td colspan=5 class=title>$day $monthname $year</td></tr>";

	$database = mysql_connect($mysql_hostname, $mysql_username, $mysql_password);
	mysql_select_db($mysql_database, $database);

	$query = mysql_query("SELECT * FROM $mysql_tablename WHERE stamp >= \"$year-$month-$day 00:00:00\" AND stamp <= \"$year-$month-$day 23:59:59\" ORDER BY stamp", $database);

	echo "<tr><td><b>Select</b></td><td><b>Username</b></td><td><b>Time</b></td><td><b>Subject</b></td>
		<td><b>Description</b></td></tr>";
	while ($row = mysql_fetch_array($query))
	{
		$i++;
		$name = stripslashes($row[username]);
		$subject = stripslashes($row[subject]);
		$desc = nl2br(stripslashes($row[description]));
		echo "<tr><td><input type=radio name=id value=$row[id]></td>
			<td>$name</td><td>$row[stamp]</td>
			<td>$subject</td><td>$desc</td></tr>";
	}
	echo "</table><p>
	<input type=hidden name=day value=$day>
	<input type=hidden name=month value=$month>
	<input type=hidden name=year value=$year>
	<input type=submit name=action value=\"Delete Selected\">
	<input type=submit name=action value=\"Modify Selected\">
	<input type=submit name=action value=\"Add Item\">
	</form>";
	include("footer.php");
?>
