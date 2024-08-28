<?php

namespace App\Order\Controller;

use App\Http\Controllers\Controller;
use App\Utils\ElasticsearchService;
use Illuminate\Http\Request;

class OrderSearchController extends Controller
{
    public $elasticsearch;

    public function __construct(ElasticsearchService $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function search(Request $request)
    {
        $query = $request->input('key','');

        $response = $this->elasticsearch->search('my_index', [
            'query' => [
                'bool' => [
                    'should' => [
                        ['match' => ['name' => $query]],
                        // 其他字段
                    ]
                ]
            ]
        ]);

        return response()->json($response);
    }

}
