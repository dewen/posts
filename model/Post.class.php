<?php

/**
 * Post class represent the Post type
 *
 */
class Post
{
    /**
     * post id
     *
     * @var     id         int
     */
    protected $id          = 0;

    /**
     * post id
     *
     * @var     title         string
     */
    protected $title       = '';

    /**
     * post privacy
     *
     * @var     privacy         string
     */
    protected $privacy     = '';

    /**
     * post likes
     *
     * @var     likes         int
     */
    protected $likes       = 0;

    /**
     * post views
     *
     * @var     views         int
     */
    protected $views       = 0;

    /**
     * post comment counts
     *
     * @var     comments         int
     */
    protected $comments    = 0;

    /**
     * post timestamp
     *
     * @var     timestamp         int
     */
    protected $timestamp   = 0;

    /**
     * post data exporter
     *
     * @var     iExportable
     */
    protected $exporter   = null;

    /**
     * constructor
     *
     * @param       params          array           post attribute in assoc. array
     */
    public function __construct($params)
    {
        $vars = get_class_vars(__CLASS__);
        foreach($params as $k => $v) {
            if (in_array($k, $vars)) {
                if ($k == 'timestamp')
                    $this->$k = strtotime($v);
                else
                    $this->$k = $v;
            }
        }
    } 

    /**
     * if this post is top post base on rules
     *
     * @return      boolean
     */
    public function isTopPost()
    {
        return ($this->privacy == 'public') && ($this->comments > 10) && ($this->views > 9000);
    }

    /**
     * return the post id
     *
     * @return      int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * return the post likes
     *
     * @return      int
     */
    public function getLikes()
    {
        return (int)$this->likes;
    }

    /**
     * return the post date
     *
     * @return      string
     */
    public function getDate()
    {
        return date('Y-m-d', $this->timestamp);
    }

    /**
     * return the current exporter
     *
     * @return      iExportable
     */
    public function getExporter()
    {
        return $this->exporter;
    }

    /**
     * if this post is top post base on rules
     *
     * @return      boolean
     */
    public function setExporter(iExportable $exporter)
    {
        $this->exporter = $exporter;
    }

    /**
     * export post in different format. Depends on selected exporter. Can be 
     * array, string, xml or json ...
     *
     * @return      boolean
     */
    public function export()
    {
        if (!$this->exporter) throw new Exception('Post exporter needs to be set before export.');

        return $this->exporter->export($this);
    }
}
