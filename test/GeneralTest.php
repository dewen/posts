<?php
include_once dirname(__FILE__) . '/../init.php';
include_once ROOT . '/model/Post.class.php';

class GeneralTest extends PHPUnit_Framework_TestCase
{
    protected $postData = array();

    protected function setUp()
    {
        $this->postData = array(
            'header' => 'id,title,privacy,likes,views,comments,timestamp',
            'public' => '4839210,Top 5 Makeup Looks for Fall,public,1000,9125,11,Thu Oct 03 02:05:34 2013',
            'private' => '4839212,Paris Hilton\'s My New BFF,private,113,11227,11,Sat Oct 05 04:05:36 2013',
        );
    }

    public function testPost()
    {
        $header = explode(',', $this->postData['header']);
        $public = explode(',', $this->postData['public']);
        $private = explode(',', $this->postData['private']);
        
        $pubParams = array_combine($header, $public);
        $privParams = array_combine($header, $private);

        $obj1 = new Post($pubParams);

        // creation
        $this->assertInstanceOf('Post', $obj1);

        // is top post
        $this->assertTrue($obj1->isTopPost());

        $obj2 = new Post($privParams);

        // is NOT top post
        $this->assertFalse($obj2->isTopPost());

    }
}
