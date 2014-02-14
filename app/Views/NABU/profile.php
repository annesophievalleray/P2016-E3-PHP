<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Nabu - The Social Web History Culture</title>
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<style>
		* {margin: 0; padding:0;}
		ul {list-style: none;}
		html,body {margin:0; height:100%; background: oldlace; box-sizing: border-box; font: normal 14px/1.3 Helvetica, sans-serif; color:darkturquoise }
		body {padding:20px;}
		header {width: 100%; height:70px; background: antiquewhite; margin-bottom: 20px;}
			header h1 {display:inline-block; width:50px; height: 50px; font-size:0; color: transparent; border-radius: 50px; background:darkturquoise; margin: 10px; vertical-align: top;}
			header .searchbar {display:inline-block; width: 200px; border-radius: 10px; border: solid 1px darkturquoise; height: 30px; margin:20px;}
			header nav {display:inline-block; height: 20px; margin: 25px 10px; float:right;}
				header nav li {display:inline-block; margin:0 8px; height: 20px; line-height: 20px; font-size:20px; color: darkturquoise;}
		.wrapper {height: 80%; width: 100%; font-size:0;}
			.profile 	{display:inline-block; height: 100%; width: 20%; font-size:14px; vertical-align: top;}
				.profile .user { height:65%; margin-bottom: 5%; width: 100%; background:antiquewhite; }
				.profile .stats { height:30%; width: 100%; background:antiquewhite; }
			.feed {display:inline-block; background:antiquewhite; height: 100%; width: 50%; font-size:14px; margin: 0 5%; vertical-align: top;}
			.isuser .feed { width:50%; margin: 0 2% 0 10%; }
			.isuser .profile { width:26%; margin: 0 10% 0 2%; }
				.isuser .profile .user { height:45%; margin-bottom: 5%; }
				.isuser .profile .stats { height:25%; margin-bottom: 5%; }
				.isuser .profile .achievements { height:20%; width: 100%; background:antiquewhite;}
	</style>
</head>
<body>
	<header>
		<h1>Nabu</h1>
		<input type="text" class="searchbar" placeholder="Search..."/>
		<nav>
			<ul>
				<li>•</li>
				<li>•</li>
				<li>•</li>
			</ul>
		</nav>
	</header>
	<section class="wrapper isuser">
		<section class="feed">Feed</section>
		<section class="profile">
			<article class="user">User</article>
			<article class="stats">Stats</article>
			<article class="achievements">Objectifs</article>
		</section>
	</section>
</body>
</html>