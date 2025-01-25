<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Postsresources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string)$this->id,

            'attributes' => [
                'body' => $this->body,
            ],
            'Relathionship' => [
                'user' => $this->user,
                'Comments' => $this->Comment,
            ],
        ];
    }
}
