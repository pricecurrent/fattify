<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookmarkResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'fats' => $this->fats,
            'carbs' => $this->carbs,
            'proteins' => $this->proteins,
            'calories' => $this->calories,
        ];
    }
}
