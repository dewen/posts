<?php

class PostWriter
{
    /**
     * output file handlers
     *
     * @var     array       < key : file_handler >
     *                          
     *                          keys (TOPPOST|OTHERPOST|DAILTOP)
     */
    protected $handlers;

    /**
     * formatter
     *
     * @var         iFormattable        a formatter implemented iFormattable interface
     */
    protected $formatter;

    public function __construct($files)
    {
        foreach($files as $k => $fname) {
            $this->handlers[$k] = fopen($fname, 'w');
        }
    }

    /**
     * write post to files
     *
     * @return  mixed
     */
    public function write(Post $post) 
    {
        $line = $this->formatter->format($post->export());

        if ($post->isTopPost())
            fwrite($this->handlers['TOPPOST'], $line);
        else
            fwrite($this->handlers['OTHERPOST'], $line);
    }

    /**
     * write score list to file
     *
     * @params  array
     * @return  void
     */
    public function writeScore($scores) 
    {
        foreach($scores as $date => $score) {
            $line = $this->formatter->format(array($date, $score['id'], $score['likes']));
            fwrite($this->handlers['DAILYTOP'], $line);
        }
    }

    /**
     * write post to files
     *
     * @return  mixed
     */
    public function setFormatter(iFormattable $formatter) 
    {
        $this->formatter = $formatter;
    }

    /**
     * destructor closes the file handler.
     */
    public function __destruct()
    {
        foreach($this->handlers as $handler) {
            if ($handler) fclose($handler);
        }
    }

}
