<?php
	// Some wordings
	$label_filter 		= "Filter :";
	$label_search 		= "Search...";
	$label_instance 	= "Instance";
	$label_version 		= "Current precise version";
	$label_maintained 	= "Maintained";
	$label_date 		= "Major version support end date";
	$label_days 		= "Number of days";
	$label_left 		= "days left";
	$label_ago 		= "days ago";
	$label_yes 		= "yes";
	$label_no 		= "no";
?>
<!DOCTYPE html>
	<head>
		<title>Nextcloud instances versions monitoring page</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width" />
		<meta name="format-detection" content="telephone=no">
		<meta http-equiv="Content-Language" content="fr">
		<link href="styles.css" rel="stylesheet">        
		<script src="scripts.js"></script>
	</head>
	<body>
		<?php
			// NEXTCLOUD INSTANCES TO MONITOR
			// Add your instances domains without "https://"
			$instanceURLs = array(
				'cloud.nextcloud.com',
				'valise.chapril.org',
				'framadrive.org'
			);
			uasort( $instanceURLs, 'strcasecmp' );
			
			// NEXTCLOUD MAJOR VERSIONS
			// Add version number and EOL date
			$versions = array(
				'20' => array(
					'eol' => '2021-11-03'
				),
				'21' => array(
					'eol' => '2022-02-22'
				),
				'22' => array(
					'eol' => '2022-07-06'
				),
				'23' => array(
					'eol' => '2022-12-03'
				),
				'24' => array(
					'eol' => '2023-04-03'
				),
				'25' => array(
					'eol' => '2023-10-19'
				),	
				'26' => array(
					'eol' => '2024-03-21'
				),	
				'27' => array(
					'eol' => '2024-06-13'
				),	
			);

			// Table's search field
			echo '<strong>'.$label_filter.'</stong>';
			echo '<input type="text" id="myInput" onkeyup="filterTable()" placeholder="'.$label_search.'" title="'.$label_search.'"><br><br><br>';
			
			// Beginning of table structure (with sortable columns)
			echo '<table border="1" class="sortable" id="myTable">';
			echo '<thead>';
			echo '<th><button>'.$label_instance.'<span aria-hidden="true"></span></button></th>';
			echo '<th><button>'.$label_version.'<span aria-hidden="true"></span></button></th>';
			echo '<th><button>'.$label_maintained.'<span aria-hidden="true"></span></button></th>';
			echo '<th><button>'.$label_date.'<span aria-hidden="true"></span></button></th>';
			echo '<th><button>'.$label_days.'<span aria-hidden="true"></span></button></th>';
			echo '</thead>';
			echo '<tbody>';
			// Start of the process of collecting, analysing and displaying information from each instance
			foreach ($instanceURLs as &$url) {
				echo '<tr>';
				// Get version information
				$statusURL = 'https://'.$url . '/status.php'; // "/status.php" is the file which contains Nextcloud instance version information
				$content = file_get_contents($statusURL);
				//Cleaning up then storing fetched information in an array
				$search = array("{", "}", ",", "\"", "installed:", "installed:", "needsDbUpgrade:", "version:", "edition:", "productname:", "extendedSupport:", "maintenance:", "versionstring:");	
				$replace   = array("", "", "|", "", "", "", "", "", "", "", "", "", "", "");
				$content = str_replace($search, $replace, $content);
				$content = $url."|".$content."|".date("Y-m-d");
				$content = explode("|",$content);
				$currentVersion = substr($content[5], 0, 2);
				$eolDate = $versions[$currentVersion]['eol'];
				$currentDate = date('Y-m-d');
				$diff = abs(strtotime($eolDate) - strtotime($currentDate));
				$numberOfDays = floor($diff / (60 * 60 * 24));
				$headers = @get_headers($statusURL);
				echo "<td><a href='https://".$content[0]."' target='_blank'>".$content[0]."</a></td>";
				if ($headers && strpos($headers[0], '200') !== false) {	
					// Display information when they have been found				
					echo "<td>".$content[4]."</td>";
					if (strtotime($currentDate) <= strtotime($eolDate)) {
						$color = "green";
						if($numberOfDays <= 30){
							$color = "orange";
						}elseif($numberOfDays <= 15) {
							$color = "red";
						}
						echo "<td>".$label_yes."</td>";
						echo "<td>".$eolDate."</td>";
						echo "<td><span style='color:".$color."'>".$numberOfDays." ".$label_left."</span></td>";
					} else {
						$color = "blueviolet";
						if($numberOfDays <= 90){
							$color = "red";
						}		
						echo "<td>".$label_no."</td>";
						echo "<td>".$eolDate."</td>";
						echo "<td><span style='color:".$color."'>".$numberOfDays." ".$label_ago."</span></td>";
					}
					echo '</tr>';
				} else {
					// Nothing to display because they instance or the "/status.php" file can't be reached
					echo "<td>N/A</td>";
					echo "<td>N/A</td>";
					echo "<td>N/A</td>";
					echo "<td>N/A</td>";
				} 
			}
			echo '</tbody>';
			echo '</table>';
		?>
		<script src="jquery-1.12.4.min.js"></script>
		<script src="jquery.filtertable.min.js"></script>
	</body>
</html> 
