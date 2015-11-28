<?

function pathToBase64($path){
	$type = pathinfo($path, PATHINFO_EXTENSION);
	$data = file_get_contents($path);
	$base64 = "data:image/" . $type . ";base64," . base64_encode($data);

	return "<img src='".$base64."' class='full'></img>";
}

?>
