<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class RelationMtm extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            //'relationNullables' => $this->when(Auth::user()->isAdmin(),RelationNullable::collection($this->relationNullables)),
            'relationNullables' => RelationNullable::collection($this->whenLoaded('relationNullables')),
            $this->mergeWhen(Auth::user()->isAdmin(), [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ])
        ];
    }

    public function with($request)
    {
        return [
            'meta' => [
                'hello' => 'world',
            ],
        ];
    }

    public function withResponse($request, $response)
    {
        $response->header('X-Value', 'True');
    }
}
