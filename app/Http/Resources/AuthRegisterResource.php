<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthRegisterResource extends JsonResource
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'user' => new UserResource($this->user)
        ];
    }
}
