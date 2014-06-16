<?php
define('_PAGE_SIZE',4);

/**
*Получает базу данных и сохранает её в массив
*@return array
*/
function get_db () {
	return file('db.txt');
}

/**
*Находит количество страниц
*@param array $db
*@param CONSTANT $pageSize
*@return int
*/
function get_page_num ($db, $pageSize) {
	$dbSize = count($db);
	$pageNum = $dbSize/$pageSize;
	return ((int)$pageNum == $pageNum) ? $pageNum : (int)ceil($pageNum);
}

/**
*Выводит содержимое текущей страницы
*@param array $db
*@param CONSTANT $pageSize
*@return string
*/
function page_get_content ($db, $pageSize) {
	global $html;
	isset($_GET['page']) ? $page = $_GET['page'] : $page = 1;
	$startIndex = ($page - 1)*$pageSize;
	$pageItems = array_slice($db, $startIndex, $pageSize);

	for ($i=0; $i < count($pageItems) ; $i++) { 
		$tmp = explode(';', $pageItems[$i]);
		$html .= $tmp[0]." ".$tmp[1]." ".$tmp[2]."<br>";
		unset($tmp);
	}
}

/**
*Выводит пагинатор
*@param ште $pageNum
*@return string
*/
function get_paginator ($pageNum) {
	global $html;
	for ($i=1; $i <= $pageNum; $i++) { 
		$html .= "<a href=\"?page=$i\">".$i."</a><br>";
	}
}


//получаем базу данных
$db = get_db ();

//получаем кол-во страниц
$pageNum = get_page_num ($db, _PAGE_SIZE);

//выводим содержимое текущей страницы
page_get_content ($db, _PAGE_SIZE);

//выводим пагинатор
get_paginator ($pageNum);

//выводим всю страницу
echo $html;