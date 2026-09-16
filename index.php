<?php include 'header.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['picture'])) {
    $uploadDir = __DIR__ . '/plants/';

    $pfile = $_FILES['picture'];
    $file = $_POST['file'];
    if ($pfile['error'] === UPLOAD_ERR_OK) {

        // Check that it is actually an image
        $imageInfo = getimagesize($pfile['tmp_name']);

        if ($imageInfo !== false) {

            // Get extension
            $extension = strtolower(pathinfo($pfile['name'], PATHINFO_EXTENSION));

            // Allow only these image types
            $allowed = ['jpg', 'jpeg', 'png'];

            if (in_array($extension, $allowed, true)) {

                // Generate a unique filename
                $filename = 'img_'. $file . '.' . $extension;

                $destination = $uploadDir . $filename;

                if (move_uploaded_file($pfile['tmp_name'], $destination)) {
                    echo "Picture uploaded successfully!";
                } else {

                    echo "Failed to move uploaded file.";
                }

            } else {
                echo "Invalid image type.";
            }

        } else {
            echo "The uploaded file is not a valid image.";
        }

    } else {
        echo "Upload error: " . $pfile['error'];
    }
}


    $dir = 'plants/';

    $files = array_diff(scandir($dir), ['.', '..']);
    rsort($files);

    foreach ($files as $file) {
        $path = $dir . $file;

        if (is_file($path)) {
	$i = 0;
	$extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

	if ($extension === 'png') {
		$i = 1;
	}
	if ($extension === 'jpeg') {
		$i = 1;
	}
	if ($extension === 'jpg') {
		$i = 1;
	}
	
	if($i == 0) {

            $content = file_get_contents($path);
            $result = explode('<br>', $content);
            print("<div class =\"plantfile\" style=\"width:80%; margin: 0 auto; padding: 10px; background-color: #000; border: 2px solid #000;\">");
            print("<br><form action=\"water_plant.php\" method=\"post\">
                <input type=\"hidden\" name=\"water\" value=\"1\">
                <input type=\"hidden\" name=\"file\" value=\"$file\">");

            $pSDate = explode(':', $result[3]); $sDate = $pSDate[1];
            $sDate = ltrim($sDate);
            $pVSDate = explode(':', $result[4]); $VSDate = $pVSDate[1];
            $VSDate = ltrim($VSDate);
            $pFSDate = explode(':', $result[5]); $FSDate = $pFSDate[1];
            $FSDate = ltrim($FSDate);
            $pFEDate = explode(':', $result[6]); $FEDate = $pFEDate[1];
            $FEDate = ltrim($FEDate);

	    $dateToCheck = new DateTime($sDate);
	    $now = new DateTime();

            if ($dateToCheck > $now) {
                echo "This Seed Date is in the future<br><br>";
		$days = "";
		$stage = "";
		$procent = "";

            } else {
                //echo "The date is not in the future";

            // CALCULATE TOTAL DAYS IN.
            $now = new DateTime();
            $totaldays = new DateTime($sDate);
            $diff = $totaldays->diff($now);
            $days = ($diff->days) + 1;

            // CALCULATE GROWTH STAGE.
            $start = new Datetime($sDate);
            $end = new DateTime($VSDate);
            $diff = $start->diff($end);
            $vdays = ($diff->days) + 1;

            $start = new Datetime($sDate);
            $end = new DateTime($FSDate);
            $diff = $start->diff($end);
            $fdays = ($diff->days);

            if ($days < $vdays) {
                $stage = "Seedling for " . $days . " days.";
            } elseif ($days <= $fdays) {
                $tot = $days - $vdays + 1;
                $stage = "Vegetative for " . $tot . " days.";
            } else {
                $tot = $days - $fdays;
                $stage = "Flowering for " . $tot . " days.";
            }

            // CALCULATE PERCENTAGE COMPLETED.
            $start = new DateTime($sDate);
            $end = new DateTime($FEDate);
            $diff = $start->diff($end);
            $tdays = ($diff->days);
            if ($dateToCheck > $now) {
            	$procent = "";
	    } else {
		$procent = (100/$tdays)*$days;
		$procent = round($procent, 0);

		if($procent > 100) {
			$procent = 100;
		}
	    }
            }

            // READ LAST WATERING INFO.
	    $lastLine = "";
	    if(file_exists('water/' . $file)) {
            	$lines = file('water/' . $file , FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            	$lastLine = end($lines);
	    } else {
		$lastLine = "";
	    }
            // CALCULATE TOTAL L WATER.
	    if(file_exists('water/' . $file)) {
            	$liters = file("water/" . $file , FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            	$total = 0;
            	foreach ($liters as $line) {
                	$results = explode('Volume : ', $line);
                	$liter = explode('L', $results[1]);
                	$total += $liter[0];
            	}
	    } else {
		$total = 0;
	    }

            // CALCULATE TOTAL H OF LIGHT.
	    if(file_exists('water/' . $file)) {
            	$liters = file("water/" . $file , FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            	$totalh = 0;
            	foreach ($liters as $line) {
                	$results = explode('Light : ', $line);
                	if(isset($results[1])) {
				$liter = explode('H', $results[1]);
                		$totalh += $liter[0];
			}
            	}
	    } else {
		$totalh = 0;
	    }


            // SHOW CARD
	    if ($procent != 100) {
            	echo "<div style=\"background-color: #fff; font-size: 30px;\">&nbsp;<u>$result[0]</u></div>";
            } else {
		echo "<div style=\"background-color: #fff; font-size: 30px;\">&nbsp;<u>$result[0] - COMPLETED</u></div>";
	    }
            echo "<div style=\"background-color: #ddd; font-size: 25px\">&nbsp;$result[1]</div>";
            echo "<br>&nbsp;$result[3]<br>";
            echo "&nbsp;$result[4]<br>";
            echo "&nbsp;$result[5]<br>";
            echo "&nbsp;$result[6]<br><br>";

            	$start = new DateTime($sDate);
            	$end = new DateTime($VSDate);
            	$diff = $start->diff($end);
            	$tdays = ($diff->days);
	    	echo "&nbsp;Total Seedling Days: $tdays<br>";
            	$start = new DateTime($VSDate);
            	$end = new DateTime($FSDate);
            	$diff = $start->diff($end);
            	$tdays = ($diff->days);
	    	echo "&nbsp;Total Vegetative Days: $tdays<br>";
            	$start = new DateTime($FSDate);
            	$end = new DateTime($FEDate);
            	$diff = $start->diff($end);
            	$tdays = ($diff->days);
	    	echo "&nbsp;Total Flowering Days: $tdays<br><br>";

	    if ($procent != 100) {
            echo "&nbsp;This plant is $days days in.<br>";
            echo "&nbsp;Growing Stage : " . $stage . "<br>";
            }
	    echo "&nbsp;Completed : " . $procent . "% done.<br><br>";
            echo "&nbsp;Last Watering : <br>";
            echo "$lastLine";
            echo "<br>";
            echo "&nbsp;Total Liters water used : " . $total . " L<br>";
            echo "&nbsp;Total Hours Of Light used : " . $totalh . " H";
            echo "<br><br>";

	    if($procent != 100) {
            	echo "&nbsp;<button type=\"submit\">Care Plant</button></form>";
            } else {
		echo "<input type=\"hidden\" name=\"log\" value=\"1\">";
            	echo "&nbsp;<button type=\"submit\">Care Log</button></form>";
	    }

	    if(file_exists("plants/img_$file.png")) {
	       echo "<img src=\"plants/img_$file.png\" width=\"400px\" style=\"border: 5px solid black;\"></img><br>";
            }
	    if(file_exists("plants/img_$file.jpeg")) {
	       echo "<img src=\"plants/img_$file.jpeg\" width=\"400px\" style=\"border: 5px solid black;\"></img><br>";
            }
	    if(file_exists("plants/img_$file.jpg")) {
	       echo "<img src=\"plants/img_$file.jpg\" width=\"400px\" style=\"border: 5px solid black;\"></img><br>";
            }

?>

<form action="index.php" method="post" enctype="multipart/form-data">
<?php echo "<input type=\"hidden\" name=\"file\" value=\"$file\">"; ?>
&nbsp;<input
        type="file"
        name="picture"
        id="picture"
        accept="image/*"
        required
    >
    <br>
    &nbsp;<button type="submit">Upload Picture</button>

</form>

<?php

	    echo "</div><br>";
	}
        }
    }
?>
<?php include 'footer.php'; ?>
