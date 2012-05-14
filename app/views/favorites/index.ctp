<h2>View All Favorites</h2>
<table>
	<tr>
		<th> User </th>
		<th> Tweet </th>
	</tr>
	<?php foreach($favorites as $favorite): ?>
		<td><?php echo $favorite['Favorite']['user_id']; ?></td>
		<td><?php echo $favorite['Favorite']['tweet_id']; ?></td>
	<?php endforeach; ?>
</table>
