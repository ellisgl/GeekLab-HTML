<?php
namespace GeekLab\HTML;

class HTML extends \XMLWriter
{
    /**
     * Element Counter / Position
     *
     * @var int $e
     */
    protected $e       = 0;

    /**
     * Header information
     *
     *@var array
     */
    protected $headers = array(
        'xhtml' => array(
            'versions' => array(
                '1.0'    => array(
                    'transitional' => array(
                        'public' => '-//W3C//DTD HTML 1.0 Transitional//EN', 'system' => 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'
                    ), 'strict'    => array(
                        'public' => '--//W3C//DTD HTML 4.01//EN', 'system' => 'http://www.w3.org/TR/html4/strict.dtd'
                    ), 'frameset'  => array(
                        'public' => '-//W3C//DTD HTML 4.01 Frameset//EN', 'system' => 'http://www.w3.org/TR/html4/frameset.dtd'
                    )
                ), '1.1' => array(
                    'default' => array(
                        'public' => '-//W3C//DTD XHTML 1.1//EN', 'system' => 'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd'
                    )
                )
            ),
            'xmlns' => 'http://www.w3.org/1999/xhtml'
        ),
        'html' => array(
            'versions' => array(
                '4.01' => array(
                    'transitional' => array(
                        'public' => '-//W3C//DTD HTML 4.01 Transitional//EN', 'system' => 'http://www.w3.org/TR/html4/loose.dtd'
                    ), 'strict'    => array(
                        'public' => '-//W3C//DTD HTML 1.0 Strict//EN', 'system' => 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'
                    ), 'frameset'  => array(
                        'public' => '-//W3C//DTD HTML 1.0 Frameset//EN', 'system' => 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd'
                    )
                ),
                '5' => array(
                    'default' => array(
                        'docType' => 'html'
                    )
                )
            )
        )
    );

    /**
     * Options for header / html tag wrapper
     *
     * @var array
     */
    protected $options = array();

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $defaults = array('indent'       => FALSE,
                          'indentString' => '  ',
                          'docType'      => 'xhtml',
                          'version'      => '1.0',
                          'level'        => 'transitional',
                          'lang'         => 'en',
                          'encoding'     => 'UTF-8');

        $this->options = array_merge($defaults, $options);

        unset($options);
        $this->openMemory();

        // Use indention on output?
        if($this->options['indent'])
        {
            $this->indent($this->options['indentString']);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->output();
    }

    public function addAttribute(array $attributes)
    {
        foreach($attributes as $key => $value)
        {
            $this->writeAttribute($key, $value);
        }

        return $this;
    }

    public function addText($text)
    {
        $this->text($text);
        return $this;
    }

    public function close($level = 1)
    {
        for($i = 0; $i < $level; ++$i)
        {
            $this->endElement();
            --$this->e;
        }

        return $this;
    }

    public function closeAll()
    {
        for($i = 0; $i <= $this->e; ++$i)
        {
            $this->endElement();
            --$this->e;
        }
    }

    /**
     * Get the PUBLIC attribute
     *
     * @return string|NULL
     */
    public function getPublic()
    {
        $ret = "";

        if(isset($this->headers[$this->options['docType']]['versions'][$this->options['version']][$this->options['level']]['public']))
        {
            $ret = $this->headers[$this->options['docType']]['versions'][$this->options['version']][$this->options['level']]['public'];
        }
        else if(isset($this->headers[$this->options['docType']]['versions'][$this->options['version']]['default']['public']))
        {
            $ret = $this->headers[$this->options['docType']]['versions'][$this->options['version']]['default']['public'];
        }
        else
        {
            $ret = NULL;
        }

        return $ret;
    }

    /**
     * Get the SYSTEM attribute
     *
     * @return string|null
     */
    public function getSystem()
    {
        $ret = "";

        if(isset($this->headers[$this->options['docType']]['versions'][$this->options['version']][$this->options['level']]['system']))
        {
            $ret = $this->headers[$this->options['docType']]['versions'][$this->options['version']][$this->options['level']]['system'];
        }
        else if(isset($this->headers[$this->options['docType']]['versions'][$this->options['version']]['default']['system']))
        {
            $ret = $this->headers[$this->options['docType']]['versions'][$this->options['version']]['default']['system'];
        }
        else
        {
            $ret = NULL;
        }

        return $ret;
    }

    /**
     * Get the XMLNS
     *
     * @return string
     */
    public function getXMLNS()
    {
        $ret = (isset($this->headers[$this->options['docType']]['xmlns'])) ? $this->headers[$this->options['docType']]['xmlns'] : "";
        return $ret;

    }
    /**
     * Set output indention
     *
     * @param null $indentString
     *
     * @return $this|bool
     */
    protected function indent($indentString = NULL)
    {
        if(!$indentString)
        {
            $this->setIndentString('');
            $this->setIndent(FALSE);

            return false;
        }

        $this->setIndentString($indentString);
        $this->setIndent(TRUE);
        return $this;
    }

    public function open($name, $text = '', $attributes = array())
    {
        // Start a new XML element
        $this->startElement($name);

        // Increment element counter
        ++$this->e;

        // Add attributes
        if(count($attributes) > 0)
        {
            $this->addAttribute($attributes);
        }

        // Add content
        if(!empty($text))
        {
            $this->text($text);
        }

        return $this;
    }

    public function openClose($name, $text = '', $attributes = array())
    {
        $this->open($name, $text, $attributes);
        $this->close();
        return $this;
    }

    /**
     * Output HTML
     *
     *@param bool $HTMLWrap
     *
     *@return string
     */
    public function output($HTMLWrap = FALSE)
    {
        $this->closeAll();

        $ret = trim($this->outputMemory());

        if($this->options['indent'])
        {
            $ret = $this->rawIndent($ret);
        }

        if($HTMLWrap)
        {
            $HTML = new \XMLWriter();
            $HTML->openMemory();

            // Use indention on output? (Not very DRY, I know.)
            if($this->options['indent'])
            {
                $HTML->setIndentString($this->options['indentString']);
                $HTML->setIndent(TRUE);
            }

            $public = "";
            $system = "";

            switch($this->options['docType'])
            {
                case 'html':
                    $HTML->startDtd('html', $this->getPublic(), $this->getSystem());
                    $HTML->endDtd();
                    $HTML->startElement('html');
                    $HTML->writeAttribute('lang', $this->options['lang']);
                    $HTML->writeRaw("\n" . $ret);
                    $HTML->endDocument();

                    $ret = $HTML->outputMemory();
                break;

                case 'xhtml':
                default:
                    // Get the inner html
                    $HTML->startDocument( '1.0' , $this->options['encoding']);
                    $HTML->startDtd('html', $this->getPublic(), $this->getSystem());
                    $HTML->endDtd();
                    $HTML->startElement('html');
                    $HTML->writeAttribute('xmlns', $this->getXMLNS());
                    $HTML->writeAttribute('xml:lang', $this->options['lang']);
                    $HTML->writeAttribute('lang', $this->options['lang']);
                    $HTML->writeRaw("\n" . $ret);
                    $HTML->endDocument();

                    $ret = $HTML->outputMemory();
                break;
            }

        }

        return trim($ret);
    }

    public function rawIndent($text)
    {
        $ret   = "";
        $lines = preg_split("/((\r?\n)|(\r\n?))/", $text);

        foreach($lines as $line)
        {
            $ret = $ret . $this->options['indentString'] . $line."\n";
        }

        return $ret;
    }
}