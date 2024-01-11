<?php

namespace Tests\Diary;

use Tests\TestCase;
use App\Diary\Macronutrients;
use App\Diary\DiaryEntryFactory;
use App\Diary\WriteToDiaryException;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DiaryEntryFactoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @covers \App\Diary\DiaryEntryFactory::write
     */
    public function it_cant_creat_a_diary_entry_without_user_provided()
    {
        try {
            resolve(DiaryEntryFactory::class)->write(
                macronutrients: new Macronutrients([]),
                mealTime: 'dinner',
                dishName: 'potato'
            );
        } catch (WriteToDiaryException $e) {
            $this->markTestPassed();
            return;
        }

        $this->fail('Wrote to diary without user and date.');
    }
}
