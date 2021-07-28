<?php

namespace App\Transformers;

use App\Models\Bookmark;
use League\Fractal\TransformerAbstract;

class BookmarkTransformer extends TransformerAbstract
{
    public function transform(Bookmark $bookmark)
    {
        return [
            'id' => $bookmark->id,
            'name' => $bookmark->name,
            'fats' => $bookmark->fats,
            'carbs' => $bookmark->carbs,
            'proteins' => $bookmark->proteins,
            'calories' => $bookmark->calories,
        ];
    }
}
