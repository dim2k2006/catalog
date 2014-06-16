<?php
$array = array('The', 'only', 'way', 'to', 'do', 'great', 'work', 'is', 'to', 'love', 'what', 'you', 'do.');
$string = implode(" ", $array);

echo $string."<br>";

//собственная реализация
for ($i=0; $i < count($array) ; $i++) { 
	echo $array[$i]." ";
}

