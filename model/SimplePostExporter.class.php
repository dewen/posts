<?php

/**
 * CLASS
 *      SimplePostExporter
 *
 *      export the post data in simplest format
 */
class SimplePostExporter implements iExportable
{
    /**
     * export the post id
     *
     * @param   $post       Post
     *
     * @return      string
     */
    public function export(Post $post)
    {
        return $post->getId();
    }
}
