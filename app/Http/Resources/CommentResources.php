<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use PhpParser\Node\Expr\Cast\String_;

class CommentResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (String)$this->id,
            'Attributes'=>[
                'body' => $this->body
            ],
            'Relathionship'=>[
                'user' => $this->user,
                'post' => $this->post,
            ]
        ];
    }
}
