<?php

namespace App\Listeners;

use App\Events\OutgoingLetterCreated;
use App\Models\IncomingLetter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateIncomingLetter
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OutgoingLetterCreated $event): void
    {
        try {
            DB::transaction(function () use ($event) {
                $outgoingLetter = $event->outgoingLetter;
                IncomingLetter::create([
                    'letter_type_id' => $outgoingLetter->letter_type_id,
                    'sender_id' => $outgoingLetter->sender_id,
                    'receiver_id' => $outgoingLetter->receiver_id,
                    'letter_number' => $outgoingLetter->letter_number,
                    'date' => $outgoingLetter->date,
                    'subject' => $outgoingLetter->subject,
                    'body' => $outgoingLetter->body,
                    'attachment' => $outgoingLetter->attachment,
                    'status' => 'unread',
                ]);
            });
            Log::info('Surat masuk telah berhasil dibuat.');
        } catch (\Throwable $th) {
            Log::info('Surat masuk telah berhasil dibuat.');
            throw $th;
        }
    }
}
