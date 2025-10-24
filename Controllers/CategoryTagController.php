<?php
class CategoryTag
{
    public function index()
    {
        try {
            $response = new Response();
            $categoryTag = new CategoryTagModel();
            $result = $categoryTag->all();
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function getByCategory($category_id)
    {
        try {
            $response = new Response();
            $categoryTag = new CategoryTagModel();
            $result = $categoryTag->getByCategory($category_id);
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }

    public function create()
    {
        try {
            $request = new Request();
            $response = new Response();
            $inputJSON = $request->getJSON();
            $categoryTag = new CategoryTagModel();
            $result = $categoryTag->create($inputJSON);
            $response->toJSON($result);
        } catch (Exception $e) {
            handleException($e);
        }
    }
}