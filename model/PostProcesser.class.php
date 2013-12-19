<?php

/**
 * PostProcesser class. Load and analyze data
 *
 */
class PostProcesser
{
    /**
     * input file handler
     *
     * @var     resource
     */
    protected $handler = null;

    /**
     * input file name
     *
     * @var     string
     */
    protected $input = null;

    /**
     * output writer 
     *
     * @var     iPostWritable           Object
     */
    protected $writer = null;

    /**
     * constructor
     *
     * @param       inputFileName       string              target file name
     * @param       postWriter          iPostWritable       output handler
     *
     * @throws      Exception
     */
    public function __construct($inputFileName, PostWriter $postWriter)
    {
        if (!file_exists($inputFileName))
            throw new Exception('Failed to open file ['.$inputFileName.']');

        $this->input = $inputFileName;
        $this->writer = $postWriter;
    } 

    /**
     * process the input
     */
    public function run()
    {
        $highScores = array();

        $this->_openInput();

        $header = fgetcsv($this->handler);

        while($values = fgetcsv($this->handler)){

            $params = array_combine($header, $values);
            $post = new Post($params);

            $post->setExporter(new SimplePostExporter);

            // writer in charge of writing post to different files base on 
            // requirement.
            $this->writer->write($post);

            $this->setScores($highScores, $post);
        }

        $this->writer->writeScore($highScores);
    }

    public function output($post)
    {
        if ($post->isTopPost())
            $this->outputHandler->write($post);

    }

    /**
     * set the single highest scoring top post of the day
     *
     * @param       $scores         array
     * @param       $post           Post object
     *
     * @return      void
     */
    public function setScores(&$scores, $post)
    {
        $date = $post->getDate();
        $likes = $post->getLikes();
        $id = $post->getId();

        if (isset($scores[$date])) {
            if ($scores[$date] < $likes) $scores[$date]['likes'] = array('likes' => $likes, 'id' => $id);;
        } else {
            $scores[$date] = array('likes' => $likes, 'id' => $id);
        }
    }

    /**
     * destructor closes the file handler.
     */
    public function __destruct()
    {
        if ($this->handler)
            fclose($this->handler);
    }

    //* implementation

    /**
     * open the input file
     */
    protected function _openInput()
    {
        $this->handler = fopen($this->input, 'r');
        if (!$this->handler)
            throw new Exception('Failed to access input file');
    }
}
