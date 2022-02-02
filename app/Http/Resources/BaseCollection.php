<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var LengthAwarePaginator $paginate */
        $paginate = $this;
        return [
            "total" => $paginate->total(),
            "per_page" => $paginate->perPage(),
            "next_page" => $paginate->currentPage() + 1 <= $paginate->lastPage() ? $paginate->currentPage() + 1 : null,
            "first_page_url" => $paginate->url(1),
            "last_page_url" => $paginate->url($paginate->lastPage()),
            "next_page_url" => $paginate->nextPageUrl(),
            "prev_page_url" => $paginate->previousPageUrl(),
            "path" => $paginate->getOptions()['path'],
            "data" => $this->collection
        ];
    }

    public function withResponse($request, $response)
    {
        $originalContent = $response->getData(true);
        unset($originalContent['links'],$originalContent['meta']);
        $response->setData($originalContent);
    }
}
