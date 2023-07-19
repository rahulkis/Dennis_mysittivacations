<?php  $PAGEURL = $_SERVER['SCRIPT_NAME']; ?>

<!-- tab buttons new -->
<div class="media_collection">
	<div class="meadia_tabs">
		<ul>
		<?php 
			if(!isset($_GET['id']))
			{
		?>
				<li <?php if($PAGEURL == '/user_search.php'){ echo 'class="activem"'; } ?>>
					<a href="user_search.php">Invite Friends</a>
				</li>
				<li <?php if($PAGEURL == '/all_friends.php'){ echo 'class="activem"'; } ?>>
					<a href="all_friends.php">Friends List</a>
				</li>
				<li <?php if($PAGEURL == '/friend_request.php'){ echo 'class="activem"'; } ?>>
					<a href="friend_request.php">Requests</a>
				</li>
				<li <?php if($PAGEURL == '/private_groups.php'){ echo 'class="activem"'; } ?>>
					<a href="private_groups.php">Groups</a>
				</li>
				<li <?php if($PAGEURL == '/all_hosts.php'){ echo 'class="activem"'; } ?>>
					<a href="all_hosts.php">Favourites</a>
				</li>
		<?php 	}
			else
			{
		?>		<li <?php if($PAGEURL == '/all_friends.php'){ echo 'class="activem"'; } ?>>
					<a href="all_friends.php?id=<?php echo $_GET['id'];?>">Friends List</a>
				</li>
		<?php 
			}	
		?>
		</ul>
	</div>
</div>
<!-- end tab container -->