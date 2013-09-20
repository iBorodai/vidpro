<?php
					$coord=json_decode(file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?language='.LANG.'&address='.urlencode(implode(',',$search)).'&sensor=false'),1);

					if(empty($coord['results'][0]['geometry']['location'])){
						$coord='';
					}
					else {
						$coord=$coord['results'][0]['geometry']['location']['lat'].','.$coord['results'][0]['geometry']['location']['lng'];
					}
?>
