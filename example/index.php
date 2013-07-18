<?php
/**
 * GeekLab\HTML Examples
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
define('DEV', TRUE);
define('DOCROOT', realpath(__DIR__) . DIRECTORY_SEPARATOR);

// Auto loader
require_once DOCROOT . 'AutoLoader.php';

AutoLoader::getInstance()->registerPaths(DOCROOT . '..'.DIRECTORY_SEPARATOR.'lib' . DIRECTORY_SEPARATOR)
                         ->load();

$HTML = new GeekLab\HTML(array('indent' => TRUE));
$HTML->open('head')
     ->open('title', 'HTML Test')
     ->close(2);

$HTML->open('body')
     ->openClose('h1', 'Hello Wold')
     ->openClose('hr')
     ->open('div', '', array('id' => 'myDiv'))
     ->open('p')
     ->addText('Testing 123!')
     ->closeAll();

echo $HTML->output(TRUE);
