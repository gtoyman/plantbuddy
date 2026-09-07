<?php include 'header.php'; ?>
<?php
    $today = date('Y/m/d');
    //echo $today;
?>
<?php
    if(isset($_POST['file']) && $_POST['file'] != "") {
        //echo "READING CONTENT";
        $content = file_get_contents('plants/' . $_POST['file']);
        //echo $content;

        $result = explode('<br>', $content);
        $pName = explode(':', $result[0]);
        $pStrain = explode(':', $result[1]);
        $file = $_POST['file'];
    }
?>
<?php
    $wDate = "";
    $wVolume = "";
    if (isset($_POST['add']) && $_POST['add'] == 1) {
        //print_r($_POST);
        //echo "Watering plant";
        $nutName = [];
 	$wDate = "";
	$wVolume = "";
        $nutrient_parts = [];

	if(isset($_POST['pHours'])){
		$pHours = $_POST['pHours'];
	} else {
		$pHours = "0";
	}

        if(isset($_POST['wDate']) && $_POST['wDate'] != ""){
            $wDate = $_POST['wDate'];
            if(isset($_POST['wVolume']) && $_POST['wVolume'] != "") {
                $wVolume = $_POST['wVolume'];

                    $dir = 'nutrients/';

                    $files = array_diff(scandir($dir), ['.', '..']);
                    sort($files);

                    foreach ($files as $nutrient) {
                        $path = $dir . $nutrient;

                        if (is_file($path)) {
                            $content = file_get_contents($path);
                            $nutrient = explode(':', $content);
                            $result = str_replace(["\r", "\n"], '', $nutrient[1]);
                            $nutName[] = $result;
                        }
                    }
                //print_r($nutName);
                //print_r($_POST);
                $i = 1;
                $count = count($_POST);
                $nutrient_parts = [];
                foreach ($_POST as $key => $value) {
                    if($i > 3 && $i <= ($count - 3)) {
                        //echo $key . " = " . $value . "<br>";
                        $nutrient_parts[] = $value;
                    }
                    $i++;
                }

                // WRITE FILE TO DISK
                $bestand = fopen("water/" . $file, "a");

                if ($bestand === false) {
                    die("Unable to open file for writing");
                }

                fwrite($bestand, "&nbsp;Watering Date : " . $wDate . "<br>");
                fwrite($bestand, "&nbsp;Water Volume : " . $wVolume . " L<br>");
                fwrite($bestand, "&nbsp;Hours Of Light : " . $pHours . " H<br>");

                $y=0;

                foreach ($_POST as $key => $value) {
                    if ($y >= 4 && $y < ($count -4)) {
                        $tst = explode('<br>', $key);
                        if($value != ""){
                            fwrite($bestand, "&nbsp;" . $tst[0] . " : " . $value . " ml<br>");
                        }
                    }
                    $y++;
                }

                fwrite($bestand, "\n");
                fclose($bestand);
            }
        }
    }
?>
<?php
        if(isset($_POST['numb'])) {
            //echo "DELETING LINE : ";
            $numb = $_POST['numb'];
            $del = 1;
            //echo $numb . "<br>";
            //print_r($_POST);
            $filename = "water/" . $file;
            //echo $filename;
            $lineToRemove = $numb; // line numbers start at 1

            // Read all lines into an array
            $lines = file($filename, FILE_IGNORE_NEW_LINES);

            // Remove the specific line
            if (isset($lines[$lineToRemove - 1])) {
                unset($lines[$lineToRemove - 1]);
            }

            // Write the remaining lines back to the file
             file_put_contents($filename, implode(PHP_EOL, $lines));

             $bestand = fopen("water/" . $file, "a");

             if ($bestand === false) {
                  die("Unable to open file for writing");
             }
             fwrite($bestand, "\n");
             fclose($bestand);
        }
?>

    <form action="water_plant.php" method="post">
    <input type="hidden" name="add" value="1"></input>
    <div class="nutrientfile" style="width:98%; margin: 0 auto; padding: 10px; background-color: #fff; border: 2px solid #000;">
        <div><h3><u>Watering Plant</u><h3></div>
        <div>
            <div style="display:flex">
                <div style="width: 230px;">Plant Name : </div><?php echo "<div>" . $pName[1] . "</div>"; ?>
            </div>
            <div style="display:flex">
                <div style="width: 230px;">Strain Name : </div><?php echo "<div>" . $pStrain[1] . "</div>"; ?>
            </div>
            <div><br></div>

            <div style="display: flex;">
                <div style="width: 230px;">Watering Date : </div>
                <?php if ($wDate != "") {
                        print("<div style=\"width: 230px;\"><input type=\"text\" name=\"wDate\" value=\"$wDate\";\"></input></div>");
                      } else {
                        print("<div style=\"width: 230px;\"><input type=\"text\" name=\"wDate\" value=\"$today\";\"></input></div>");
                      }
                  ?>
                <div style="width: 230px;">(YYYY/MM/DD)</div>
            </div>
            <div style="display: flex;">
                <div style="width: 230px;">Water Volume : </div>
                <?php if ($wVolume != "") {
                        print("<div style=\"width: 230px;\"><input type=\"text\" name=\"wVolume\" value=\"$wVolume\";\"></input></div>");
                      } else {
                        print("<div style=\"width: 230px;\"><input type=\"text\" name=\"wVolume\" value=\"1\";\"></input></div>");
                      }
                  ?>
                <div style="width: 230px;">(L)<br><br></div>
            </div>
            <div style="display:flex">
                <div style="width: 230px;">Hours Of Light : </div><?php echo "<div><input type=\"text\" name=\"pHours\" value=\"18\"></input></div>"; ?>
            </div>
	    <br>
            <?php
                $dir = 'nutrients/';

                $files = array_diff(scandir($dir), ['.', '..']);
                sort($files); // descending

                $i = 0;
                foreach ($files as $nutrient) {
                    $path = $dir . $nutrient;

                    if (is_file($path)) {
                        $content = file_get_contents($path);
                        $nutrient = explode(':', $content);
                        $result = str_replace(["\r", "\n"], '', $nutrient[1]);
                        $result = str_replace(' ', '', $result);
                        //print($result); echo "!";
                        print("<div style=\"display: flex; width:98%;\">");
                            echo "<div style=\"display: flex; width: 230px\">";
                              echo "<div>$result</div>";
                              echo "<div style=\"\">&nbsp;:&nbsp</div>";
                            echo "</div>";
			    if(isset($nutrients_parts[$i])) {
		            echo "<div style=\"width: 230px;\"><input type=\"text\" name=\"$result\" value=\"$nutrient_parts[$i]\"></input></div>";
			    } else {
		            echo "<div style=\"width: 230px;\"><input type=\"text\" name=\"$result\" value=\"\"></input></div>";
			    }
                            echo "<div style=\"width: 230px;\">(ml)</div>";
                        echo "</div>";
                    }
                    $i++;
                }
                ?>
        </div>
        <div style="display: flex;"">
            <div style="width: 230px;"><br>
            <?php
                //echo $file;
                print("<input type=\"hidden\" name=\"file\" value=\"$file\"></input>");
                print("<input type=\"hidden\" name=\"pName\" value=\"$pName[1]\"></input>");
                print("<input type=\"hidden\" name=\"pStrain\" value=\"$pStrain[1]\"></input>");
                if(!isset($_POST['log'])) {
			print("&nbsp;<button type=\"submit\">Water Plant</button></form></div>");
		} else {
			echo "</form></div>";
		}
            ?>

	</div>

    <?php
        $filename = "water/" . $_POST['file'];

        if (file_exists($filename)) {
            //echo "OK";
	    echo "<br>";
            echo "<div class=\"nutrientfile\" style=\"width:98%; margin: 0 auto; padding: 10px; background-color: #fff; border: 2px solid #000;\"><br>";
            //echo $filename;
            $lines = file($filename);
            //print_r($lines);
            // Reverse the array
            //sort($lines);
            $lines = array_reverse($lines);
            $countlines = count($lines);

            $z = 1;
            foreach ($lines as $line) {
                 //echo $countlines;
                 echo $line;
                 $numb = (string)($countlines - $z) + 1;
                 //echo "nummer : " . $numb;
                 if($line != "\n") {
                 print("<form action=\"water_plant.php\" method=\"post\">");
                 print("<input type=\"hidden\" name=\"file\" value=\"$file\"></input>");
                 print("<input type=\"hidden\" name=\"numb\" value=\"$numb\"></input>");
                	 if(!isset($_POST['log'])) {
		 		print("<br><button type=\"submit\">Delete Watering</button></form>");
			 } else {
				echo "<br></form>";
			 }
                 }
                 $z++;
            }

            echo "</div>";
        }
    ?>
    </div>

<?php include 'footer.php'; ?>
