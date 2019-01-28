<?
function genToken() {
	$vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
    $consonants .= 'BDGHJLMNPQRSTVWXZ';
    $vowels .= "AEUY";
    $consonants .= '23456789';

	$base = '';
	$alt = time() % 2;
	for ($i = 0; $i < 9; $i++) {
		if ($alt == 1) {
			$base .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$base .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return sha256($base);
}
for ($i = 0; $i < 5; $i++) {
echo genToken()."</br>";
}
?>