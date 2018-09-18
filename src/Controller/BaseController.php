<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{

    public function createPaginator($paginatedQuery, $limit, $currentPage){
        $paginator = array();
        $paginator['results'] = $paginatedQuery['paginator'];
        $paginator['maxPages'] = ceil($paginatedQuery['paginator']->count() / $limit);
        $paginator['currentPage'] = $currentPage;
        $paginator['query'] = $paginatedQuery['query'];
        return $paginator;
    }

}