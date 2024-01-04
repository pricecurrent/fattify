<?php

namespace App\Diary;

class Macronutrients
{
    public const FIELDS = ['carbs', 'proteins', 'fats', 'name'];

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
        if (! in_array($key, static::FIELDS)) {
            throw new InvalidMacronutrientException();
        }

        return $this->data[$key] ?? 0;
    }

    public function toArray()
    {
        return $this->data;
    }

    public static function fake($params = [])
    {
        return new static(array_merge([
            'carbs' => rand(0, 100),
            'proteins' => rand(0, 100),
            'fats' => rand(0, 100),
            'name' => 'Fake food',
        ], $params));
    }
}
