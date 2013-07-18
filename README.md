GeekLab\HTML
=============

Programmatically create HTML (XHTML, 4.x, 5) for PHP 5.3+

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
```
$HTML = new GeekLab\HTML(array('indent' => TRUE));
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

echo $HTML->output(TRUE); // Out XHTML wrapped with DOCType and HTML tags.
```

### API
