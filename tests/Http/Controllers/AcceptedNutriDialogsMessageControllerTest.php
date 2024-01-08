<?php

namespace Tests\Http\Controllers;

use App\Models\NutriDialog;
use App\Models\NutriDialogMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AcceptedNutriDialogsMessageControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_accpets_the_suggestions_from_the_message()
    {
        $user = User::factory()->create();
        $dialog = NutriDialog::factory()->for($user)->create();
        $message = NutriDialogMessage::factory()->for($dialog)->create([
            'suggestions' => [
                ['name' => 'omelette', 'carbs' => 10, 'fats' => 20, 'proteins' => 30],
                ['name' => 'apple', 'carbs' => 5, 'fats' => 0, 'proteins' => 3],
            ]
        ]);

        $this->withoutExceptionHandling();
        $this
            ->actingAs($user)
            ->withCookie('dialog_id', $dialog->id)
            ->json('POST', route('nutri-dialog-messages.accepted.store', $message))
            ->assertRedirect()
            ->assertCookieExpired('dialog_id');

        $this->assertCount(2, $user->nutritionDiaryEntries);
        $this->assertTrue($dialog->fresh()->isClosed());
        $entryA = $user->nutritionDiaryEntries()->first();
        $entryB = $user->nutritionDiaryEntries()->get()->last();
        $this->assertEquals('omelette', $entryA->dish_name);
        $this->assertEquals(10, $entryA->carbohydrates);
        $this->assertEquals(20, $entryA->fat);
        $this->assertEquals(30, $entryA->protein);
        $this->assertEquals('apple', $entryB->dish_name);
        $this->assertEquals(5, $entryB->carbohydrates);
        $this->assertEquals(0, $entryB->fat);
        $this->assertEquals(3, $entryB->protein);
    }
}
