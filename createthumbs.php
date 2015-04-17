<?

error_reporting(E_ALL);

set_time_limit(0);

include "../images.conf3.php";
include "cropfunction.php";

define("PATH","$_SERVER[DOCUMENT_ROOT]/$place/");

// Вывод индекса фотографий
function GenerateImageIndex($place, $width="128", $height="128", $startdiv="<table>",$enddiv="</table>")	{

	global $imagesset;

	$message = "<B>Exec time before:</B> " . ini_get("max_execution_time");
	ini_set("max_execution_time",'360');
	$message .= "<br><B>Exec time after:</B> " . ini_get("max_execution_time");


	$thumbsdir = "thumbs$width";

	if (!is_dir(PATH.$thumbsdir)) { mkdir(PATH.$thumbsdir,0755); $mesg = " created";} else $mesg = " already exists";

	$message .= 
	
	"
	<br>Folder " . PATH.$thumbsdir . " <b>$mesg</b>
	<br><B>Setting working directory to:</B> " . PATH.$thumbsdir .
	"<br><B>Date</B>: " . $imagesset[$place]['traveldate'] . 
	"<br><B>Converted date</B>: " . strtotime(substr($imagesset[$place]['traveldate'],0,10)) . "";


	// Используем для теней к фоткам
	$message .= $startdiv;

	foreach($imagesset[$place]['images'] as $key=>$value)	{

			@$count++;

				foreach($value as $path=>$title)	{

					$filename['oldpath'] = "$_SERVER[DOCUMENT_ROOT]/$place/images/$path.jpg";
					$filename['newpath'] = "$_SERVER[DOCUMENT_ROOT]/$place/$thumbsdir/$path.jpg";

					// print_r($filename);

					unset($value);

					resizeAnyPolyGon($filename['oldpath'], $width, $height, $filename['newpath'], 0);
					$message .= "
					
					<tr>
						<td>Processing: <B>$path.jpg</B></td>
						<td><img src='/$place/thumbnails/$path.jpg' title='$title / $filename[oldpath]' border='0'></td>
						<td><img src='/$place/$thumbsdir/$path.jpg' title='$title / $filename[newpath]' border='0'></td>
					</tr>
					" ;

					flush();




				}

			}

	// Используем для теней к фоткам
	return $message.$enddiv;

}

?>

<link rel="stylesheet" type="text/css" href="http://milk.ecm7.ru/Content/less/milk.less"/>
<div class="row">
<div class="span12 offset1">

<?

if (!empty($_GET['place'])) {

echo GenerateImageIndex($_GET['place']);
echo GenerateImageIndex($_GET['place'],"64","64");

}

?>

</div>
</div>

