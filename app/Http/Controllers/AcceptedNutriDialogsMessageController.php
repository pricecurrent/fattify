<?php

namespace App\Http\Controllers;

use App\Diary\DiaryEntryFactory;
use App\Diary\Macronutrients;
use App\Models\NutriDialogMessage;
use Illuminate\Support\Facades\Cookie;

class AcceptedNutriDialogsMessageController
{
    public function __construct(
        protected DiaryEntryFactory $entryFactory
    ) {
    }

    public function store(NutriDialogMessage $nutriDialogMessage)
    {
        collect($nutriDialogMessage->suggestions)->each(function ($suggestion) {
            return $this->entryFactory
                ->withUser(auth()->user())
                ->withDate(today())
                ->write(
                    macronutrients: new Macronutrients($suggestion),
                    dishName: $suggestion['name']
                );
        });

        $nutriDialogMessage->nutriDialog->close();

        Cookie::expire('dialog_id');

        return redirect()->back()->with('success', 'Your meal has been added to your diary.');
    }
}
