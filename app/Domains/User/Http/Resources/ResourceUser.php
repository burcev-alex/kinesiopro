<?php

namespace App\Domains\User\Http\Resources;

use App\Domains\User\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ResourceUser extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $resource = $this->resource;
        $birthday = $resource->birthday
            ? Carbon::parse($resource->birthday)
            : null;

        return [
            'firstname' => $resource->firstname,
            'surname' => $resource->surname,
            'email' => $resource->email,
            'avatar' => $resource->avatar->relativeUrl,
            'birthday' => $birthday,
            'work' => $resource->work,
            'position' => $resource->position,
            'country' => $resource->country,
            'phone' => $resource->phone
        ];
    }
}
