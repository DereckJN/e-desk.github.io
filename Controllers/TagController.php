<?php
class Tag
{
    public function index()
    {
        try {
            $response = new Response();
            $tag = new TagModel();
            $result = $tag->all();
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function get($param)
    {
        try {
            $response = new Response();
            $tag = new TagModel();
            $result = $tag->get($param);
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getActiveTags()
    {
        try {
            $response = new Response();
            $tag = new TagModel();
            $result = $tag->getActiveTags();
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}