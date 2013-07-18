GeekLab\HTML
=============

Programmatically create HTML (HTML, 4.x, 5) for PHP 5.3+

### Todo
*    Add HTML 4.x and 5 support
*    More methods
*    API Docs

### Features
*    Creates (X)HTML programmitically

### Installation
Copy the lib\GeekLab folder to your codebase where it can be loaded.
-OR-
Via Composer
composer.json
```json
{
    "require":
    {
        "geeklab/html": "*"
    }
    "minimum-stability" : "dev"
}
```

### Usage (From example\index.php)
```php
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

$HTML->open('head') // Create the head tag
     ->open('title', 'HTML Test') // Create the title tag with text
     ->close(2); // Close the previous 2 html tags

$HTML->open('body') // Create the body tag
     ->openClose('h1', 'Hello Wold') // Create and close an H1 tag with text
     ->openClose('hr') // Create and close an HR tag
     ->open('div', '', array('id' => 'myDiv')) // Create a div tag with an ID of 'myDiv'
     ->open('p') // Create a P tag
     ->addText('Testing 123!') // Add some text
     ->closeAll(); // Close all open tags.

echo $HTML->output(TRUE); // Out HTML wrapped with DOCType and HTML tags.
```

### API
