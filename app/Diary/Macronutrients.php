<?php

namespace App\Diary;

class Macronutrients
{
    public const MACRONUTRIENT_TYPES = ['carbs', 'proteins', 'fats'];

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;

        foreach ($this->data as $key => $value) {
            $this->$key;
        }
    }

    public function __get($key)
    {
        if (! in_array($key, static::MACRONUTRIENT_TYPES)) {
            throw new InvalidMacronutrientException();
        }

        return $this->data[$key] ?? 0;
    }
}
