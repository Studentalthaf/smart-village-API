<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaginateResource extends JsonResource
{
    protected $resourceClass;

    public function __construct($resource, $resourceClass)
    {
        parent::__construct($resource);
        $this->resourceClass = $resourceClass;
    }

    public function collect($resource)
    {
        return ($this->resourceClass)::collection($resource);
    }

    public function toArray($request)
    {
        return [
            'data' => $this->collect($this->items()),
            'meta' => [
                'current_page' => $this->currentPage(),
                'from' => $this->firstItem(),
                'last_page' => $this->lastPage(),
                'path' => $this->path(),
                'per_page' => $this->perPage(),
                'to' => $this->lastItem(),
                'total' => $this->total(),
            ],
            'links' => [
                'first' => $this->url(1),
                'last' => $this->url($this->lastPage()),
                'prev' => $this->previousPageUrl(),
                'next' => $this->nextPageUrl(),
            ],
        ];
    }
}
