<?php
require '/../vendor/autoload.php';
use InstagramScraper\Instagram;
$medias = Instagram::getMediasByTag('pedro', 200);
header('Content-Type: application/json');
echo json_encode($medias);