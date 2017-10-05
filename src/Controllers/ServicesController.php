<?php

namespace Dot\Options\Controllers;

use Dot\Platform\Controller;
use Illuminate\Http\Request;
use stdClass;

/**
 * Class ServicesController
 * @package Dot\Platform\Controllers
 */
class ServicesController extends Controller
{


    /**
     * Getting google search suggestions
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function keywords(Request $request)
    {

        $q = $request->get("term");

        $keywords = array();
        $data = file_get_contents('http://suggestqueries.google.com/complete/search?output=firefox&client=firefox&hl=ar-EG&q=' . $q);
        if (($data = json_decode($data, true)) !== null) {
            foreach ($data[1] as $item) {
                $keyword = new stdClass();
                $keyword->name = $item;
                $keywords[] = $keyword;
            }
        }

        return response()->json($keywords);
    }

}
