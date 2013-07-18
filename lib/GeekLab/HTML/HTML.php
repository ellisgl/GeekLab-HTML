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
                        'public' => '-//W3C//DTD HTML 1.0 Strict//EN', 'system' => 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'
                    ), 'frameset'  => array(
                        'public' => '-//W3C//DTD HTML 1.0 Frameset//EN', 'system' => 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd'
                    )
                ), '1.1' => array(
                    'default' => array(
                        'public' => '-//W3C//DTD HTML 1.1//EN', 'system' => 'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd'
                    )
                )
            ),
            'xmlns' => 'http://www.w3.org/1999/xhtml'
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
        $defaults = array('indent' => FALSE,
                          'indentString' => '  ',
                          'docType' => 'xhtml',
                          'version' => '1.0',
                          'level'   => 'transitional');

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
     * @return string
     */
    public function getPublic()
    {
        $ret = "";

        if(isset($this->headers[$this->options['docType']]['versions'][$this->options['version']][$this->options['level']]['public']))
        {
            $ret = $this->headers[$this->options['docType']]['versions'][$this->options['version']][$this->options['level']]['public'];
        }
        else if($this->headers[$this->options['docType']]['versions'][$this->options['version']]['default']['public'])
        {
            $ret = $this->headers[$this->options['docType']]['versions'][$this->options['version']]['default']['public'];
        }

        return $ret;
    }

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
     * @param bool $XHTMLWrap
     *
     * @return string
     */
    public function output($XHTMLWrap = FALSE)
    {
        $this->closeAll();

        $ret = $this->outputMemory();

        if($XHTMLWrap)
        {
            $XHTML = new \XMLWriter();
            $XHTML->openMemory();

            // Use indention on output? (Not very DRY, I know.)
            if($this->options['indent'])
            {
                $XHTML->setIndentString($this->options['indentString']);
                $XHTML->setIndent(TRUE);
            }

            if($this->options['docType'] === 'xhtml')
            {
                $public = "";
                $system = "";

                $XHTML->startDtd('html', $this->getPublic(), $this->getSystem());
                $XHTML->endDtd();
                $XHTML->startElement('html');
                $XHTML->writeAttribute('xmlns', $this->getXMLNS());
                $XHTML->endElement();
                $XHTML->writeRaw(trim($ret));
                $XHTML->endDocument();

                $ret = $XHTML->outputMemory();
            }
        }

        return $ret;
    }
}