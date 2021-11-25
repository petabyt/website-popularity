<!DOCTYPE html>
<html>
<head>
	<title>Website Popularity</title>
</head>
<body>
	<h1>Website Popularity</h1>
	<p>Uses data from archive.org</p>
	<form action="" method="post" enctype="multipart/form-data">
		<input type="text" name="url" placeholder="google.com">
		<input type="submit" value="Submit" name="submit">
	</form>
	<?php
		if (!isset($_POST["url"])) {
			die("");
		}

		$site = $_POST["url"];
		$site = preg_replace("/[^a-zA-Z\.0-9]/i", "", $site);
		echo("<p>" . $site . "</p>");

		$url = "https://web.archive.org/__wb/calendarcaptures/2?url=" . $site . "&date=2021&groupby=day";

		$archiveData = json_decode(file_get_contents($url));

		$saves = 0;
		foreach ($archiveData->items as $i) {
			$saves += $i[2];
		}

		echo("In 2021, this site got " . strval($saves) . " archive.org saves.");
	?>
	<br>
	<?php
		$score = 0;
		if ($saves >= 100000) {
			$score = 5;
		} else if ($saves >= 5000) {
			$score = 4;
		} else if ($saves >= 1000) {
			$score = 3;
		} else if ($saves >= 100) {
			$score = 2;
		} else if ($saves >= 1) {
			$score = 1;
		}

		echo("This site's popularity score is " . strval($score) . ".<br>");

		switch ($score) {
		case 0:
			echo("This site basically zero popularity. Either that, or it doesn't exist. :(");
			break;
		case 1:
			echo("This site is fairly popular.");
			break;
		case 2:
			echo("This site is pretty big. A hundred or so probably visit it every day.");
			break;
		case 3:
			echo("This site is very big. It's probably a business site, and gets tens of thousand of views every day.");
			break;
		case 4:
			echo("This is also probably a business site, but one of the more popular ones.");
			break;
		case 5:
			echo("This is either a huge social media site or search engine.");
			break;
		}
	?>
</body>
</html>
