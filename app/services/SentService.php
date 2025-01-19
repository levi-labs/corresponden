<?php

namespace App\Services;

use App\Events\OutgoingLetterCreated;
use App\Events\SentCreated;
use App\Models\Sent;
use Illuminate\Support\Facades\DB;

class SentService
{
    protected $recentActivityService;

    public function __construct(RecentActivityService $recentActivityService)
    {
        $this->recentActivityService = $recentActivityService;
    }
    public function getAllOutgoingLetters()
    {
        $data = Sent::join('letter_types', 'sent.letter_type_id', '=', 'letter_types.id')
            ->join('users as sender', 'sent.sender_id', '=', 'sender.id')
            ->join('users as receiver', 'sent.receiver_id', '=', 'receiver.id')
            ->select(
                'sent.id',
                'sent.date',
                'sent.subject',
                'sent.body',
                'letter_types.name as letter_type',
                'sender.name as sender_name',
                'receiver.name as receiver_name',
                'sent.status',
                'sent.attachment',
                'sent.letter_number'
            )
            ->paginate(25);
        return $data;
    }

    public function getAllOutgoingLettersByUser()
    {
        $data = Sent::join('users as sender', 'sent.sender_id', '=', 'sender.id')
            ->join('letter_types', 'sent.letter_type_id', '=', 'letter_types.id')
            ->join('users as receiver', 'sent.receiver_id', '=', 'receiver.id')
            ->where('sender.id', '=', auth('web')->user()->id)
            ->select(
                'sent.id',
                'sent.date',
                'sent.subject',
                'sent.body',
                'letter_types.name as letter_type',
                'sender.name as sender_name',
                'receiver.name as receiver_name',
                'receiver.username as receiver_username',
                'sent.status',
                'sent.attachment',
                'sent.letter_number'
            )
            ->paginate(25);
        return $data;
    }

    public function getAllOutgoingLetterByRole() {}

    public function searchOutgoingLetter($search) {}

    public function getOutgoingLetterById($id)
    {
        $outgoingLetter = Sent::join('users as receiver', 'sent.receiver_id', '=', 'receiver.id')
            ->join('users as sender', 'sent.sender_id', '=', 'sender.id')
            ->join('letter_types', 'sent.letter_type_id', '=', 'letter_types.id')
            ->where('sent.id', $id)
            ->select(
                'sent.id',
                'sent.date',
                'sent.subject',
                'sent.body',
                'letter_types.name as letter_type',
                'sender.name as sender_name',
                'receiver.name as receiver_name',
                'receiver.username as receiver_username',
                'sent.status',
                'sent.attachment',
                'sent.letter_number'
            )
            ->first();
        return $outgoingLetter;
    }

    public function create($data)
    {
        // dd($data);
        try {
            DB::transaction(function () use ($data) {
                $this->recentActivityService->create(auth('web')->user()->id, 'send-message');
                $sent = Sent::create($data);
                event(new SentCreated($sent));
            });
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Sent $outgoingLetter, $data) {}

    public function destroy(Sent $outgoingLetter) {}
}
