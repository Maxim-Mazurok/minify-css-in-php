<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 3/23/17
 * Time: 7:21 PM
 */

require_once(__DIR__ . '/Minify.php');

$min = new Minify;

$path = '/home/maxim/web/minify-css-in-php/example.css';
$min->run($path);
