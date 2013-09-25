<?php
	require 'php-sdk/facebook.php';
	$facebook = new Facebook(array(
		'appId' => '524209414332364',
		'secret' => '31add7470aa5cc797ac4e3627f452f97'
 	));
 	
	$qty = 3;
	$currentoffset = $_GET['offset'];
 	$coolBeans = "COOL BEANS";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Facebook PHP</title>
    <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/flat-ui.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/facebook-app.css"/>
</head>
<body>
<div class="container">
<?php
	//get user from facebook object
	$user = $facebook->getUser();
	
	if ($user): //check for existing user id
		$current_user = $facebook->api('/me');
		echo '<header class="row">';
		echo '<h1> Hello', $current_user['name'], ' !!</h1>';
		//print logout link
		echo '<p class="notes"><a class="btn btn-danger" href="logout.php">logout</a></p>';
		echo '</header>';
		$user_graph = $facebook->api('/me/friends/');
		$howmanyfriends = count($user_graph['data']);
		
		$moviespath = 'me/friends?fields=id,name,movies.fields(id,name,created_time,picture.type(square).height(100).width(100),link,description,likes)&limit='.$qty.'&offset='.$currentoffset;
		
		/*echo $moviespath;*/
		$movies_graph = $facebook->api($moviespath);

		echo '<div class="moviegroup clearfix">';
		foreach ($movies_graph['data'] as $key => $value) {
			if (count($value['movies']['data'])): //check if user has one recommendation
			echo '<div class="friend group">'; //col-md-3
			echo '<div class="friendinfo group">';
			echo '<a href="http://facebook.com/', $value['id'], '" target="_top">';
			echo '<img class="img-circle" src="https://graph.facebook.com/', $value['id'],'/picture" alt="',$value['name'],'"/>';
			echo "</a>";
			echo "<h2>", $value['name'],'</h2>';
			echo '<h3>Recommends</h3>';
			echo '</div>'; //friendinfo
			echo '<ul class="movies group clearfix">';
			
			foreach ($value['movies']['data'] as $moviekey => $movievalue) {
				echo '<li>';
				echo '<a href="',$movievalue['link'],'" target="_top">';
				echo '<img class="img-thumbnail img-brick" src="',$movievalue['picture']['data']['url'],'" alt="',$movievalue['name'],'" title="',$movievalue['name'],'" />';
				echo '</a>';
				echo '<div class="movieinfo">';
				echo '<div class="wrapper">';
				echo '<h3>', $movievalue['name'], '</h3>';
				echo '<p>', $movievalue['description'], '</p>';
				echo '</div>'; // wrapper
				echo '</div>'; // movie info
				echo '</li>'; // list
			} //go through each list of recommendations
			
			echo '</ul>'; //list of movies
			echo "</div>"; // movie group
			endif; //if user recommends one movie
		} //iterate through friends graph
		
		
		$totalpages = ceil($howmanyfriends/$qty); //total pages
		$currentpage = ($currentoffset/$qty)+1; //current page
		$nextoffset = $currentoffset + $qty; //increment offset
		
		if ($totalpages > 1) :
			echo '<div class="paging container">';
				echo '<div class="pagenav">';
				
				if ($currentoffset >= $qty):
					echo '<span class="previous">';
					echo '<a href="',$_SERVER['SELF'],'?offset=',$currentoffset-$qty,'">&laquo; Previous</a>';
					echo '</span>';
				endif; // previous link


				for ($i = 0; $i < $totalpages; $i++) {
					echo '<span class="number';
					if ($i===($currentpage-1)) { echo ' current '; }
					echo '">';
					echo '<a href="',$_SERVER['SELF'],'?offset=', $i * $qty,'">', $i+1, '</a>';
					echo '</span>';
				}

				if ($nextoffset < $howmanyfriends):
					echo '<span class="next">';
					echo '<a href="',$_SERVER['SELF'],'?offset=',$nextoffset,'">Next &raquo;</a>';
					echo '</span>';
				endif; // next link
				
				echo '</div>'; //pagenav
				echo '<div class="info">Page ', $currentpage ,' of ', $totalpages, '</div>';
				echo '<p>You have ', $howmanyfriends, ' friends</p>';
			echo '</div>'; // paging section
		endif; // there is at least one page
		echo '</div>'; // ends movie group
		
	else: //user doesn't exist
		$loginUrl = $facebook->getLoginUrl(array(
			'diplay'=>'popup',
			'scope'=>'email, friends_likes',
			'redirect_uri' => 'http://apps.facebook.com/raverestuarants/'
		));
		echo '<div class="notes">';
		echo '<p>To get access to the movie recommendator, please <a href="', $loginUrl, '" target="_top">login</a></p>';
		echo '</div>';
	endif; //check for user id
?>
  </div>
</body>
</html>
