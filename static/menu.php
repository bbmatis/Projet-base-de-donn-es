<nav>
	<?php 
		foreach ($routes as $route => $routeValue) {
			$selected = $actualRoute == $route ? "class='selected'" : "";
			echo "<a href='?page=$routeValue[1]' $selected>$routeValue[0]</a>";
		}
	?>
</nav>

