<?php

interface iExportable
{
    /**
     * export the object data 
     *
     * @return      array       Object value in key|value pair 
     */
    public function export(Post $post);

}
