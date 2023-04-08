<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    //if you want to change the wrapper
//    public static $wrap = 'post';
    //if you want to change the wrapper globally you must put this code into AppServiceProvider function boot -> JsonResource::wrap('attr');

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        to show all data
//        return parent::toArray($request);

//        to show data with premission
        return [
            'id' => $this->id,
            //if you want to change export for example
            'title' => strtoupper($this->title),
            //if you want to change key of array just change name without any command
            'description' => $this->body,
            //if you want to format the export for example for date and time
            'created_at' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }

    //bind array method 1 -> if want to bind an array to main export data => method 2 is on PostController function show (if you want to bind a variable)
//    public function with($request)
//    {
//        return [
//            'foo'=>[
//                'key'=> 'value'
//            ]
//        ];
//    }
}
