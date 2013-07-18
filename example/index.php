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

/**
 * XHTML 1.0 Transitional, Language "en" and encoding of "UTF-8" no indention
 */
//$HTML = new GeekLab\HTML();

/**
 * XHTML 1.0 Transitional, Language "en" and encoding of "UTF-8" with indention
 */
//$HTML = new GeekLab\HTML(array('indent' => TRUE));

/**
 * XHTML 1.0 Strict, Language "en" and encoding of "UTF-8" with indention
 */
//$HTML = new GeekLab\HTML(array('indent' => TRUE, 'level' => 'strict')) ;

/**
 * XHTML 1.0 Strict, Language "fr" and encoding of "ISO-8859-1" with indention
 */
//$HTML = new GeekLab\HTML(array('indent' => TRUE, 'level' => 'strict', 'lang' => 'fr', 'encoding' => 'ISO-8859-1')) ;

/**
 * XHTML 1.1, Language "en" and encoding of "UTF-8" with indention
 */
//$HTML = new GeekLab\HTML(array('indent' => TRUE, 'version' => '1.1')) ;

/**
 * HTML 4.01, Language "en" no indention
 **/
//$HTML = new GeekLab\HTML(array('indent' => TRUE, 'docType' => 'html', 'version' => '4.01'));

/**
 * HTML5, Language "en" with indention
 */
$HTML = new GeekLab\HTML(array('indent' => TRUE, 'docType' => 'html', 'version' => '5'));

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
