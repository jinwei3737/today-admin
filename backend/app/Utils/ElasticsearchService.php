<?php

namespace App\Utils;


use \Elasticsearch\Client;

class ElasticsearchService
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function search($index, $body)
    {
        return $this->client->search([
            'index' => $index,
            'body' => $body,
        ]);
    }

    public function index($index, $id, $body)
    {
        return $this->client->index([
            'index' => $index,
            'id'    => $id,
            'body'  => $body,
        ]);
    }

    // 其他 Elasticsearch 操作
}
