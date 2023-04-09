<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'email'=>$this->email,
            //if you want to show to default posts structure
//            'posts'=>$this->whenLoaded('posts'),
            //if you want to show to your PostResource Structure
            'posts'=>PostResource::collection($this->whenLoaded('posts')),
        ];
    }


}
