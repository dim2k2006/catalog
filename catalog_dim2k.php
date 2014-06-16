<?php
define('_PAGE_SIZE',5);

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
function get_page_num ($db) {
	$dbSize = count($db);
	$pageNum = $dbSize/_PAGE_SIZE;
	return ((int)$pageNum == $pageNum) ? $pageNum : (int)ceil($pageNum);
}

/**
*Выводит содержимое текущей страницы
*@param array $db
*@param CONSTANT $pageSize
*@return string
*/
function page_get_content ($db) {
	isset($_GET['page']) ? $page = $_GET['page'] : $page = 1;
	$startIndex = ($page - 1)*_PAGE_SIZE;
	$pageItems = array_slice($db, $startIndex, _PAGE_SIZE);
	$html = "";
	for ($i=0; $i < count($pageItems) ; $i++) { 
		$tmp = explode(';', $pageItems[$i]);
		$html .= $tmp[0]." ".$tmp[1]." ".$tmp[2]."<br>";
	}
	unset($tmp);
	return $html;
}

/**
*Выводит пагинатор
*@param int $pageNum
*@return string
*/
function get_paginator ($pageNum) {
	$html = "";
	for ($i=1; $i <= $pageNum; $i++) { 
		$html .= "<a href=\"?page=$i\">$i</a><br>";
	}
	return $html;
}

/**
*Формирует готовую страницу для вывода
*@param string $currentPageContent
*@param string $paginator
*@return string
*/
function html ($currentPageContent, $paginator) {
	return $currentPageContent.$paginator;
}


//получаем базу данных
$db = get_db ();

//получаем кол-во страниц
$pageNum = get_page_num ($db);

//выводим содержимое текущей страницы
$currentPageContent = page_get_content ($db);

//выводим пагинатор
$paginator = get_paginator ($pageNum);

//выводим всю страницу
echo html ($currentPageContent, $paginator);