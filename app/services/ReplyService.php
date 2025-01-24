<?php

namespace App\Services;

use App\Events\SentCreated;
use App\Models\Inbox;
use App\Models\Notification;
use App\Models\Reply;
use App\Models\Sent;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class ReplyService
{

    public function sendBack($data)
    {
        $inbox = Inbox::where('id', $data['id_letter'])->first();

        Sent::create([
            'receiver_id' => $inbox->sender_id,
            'sender_id' => $inbox->receiver_id,
            'letter_type_id' => $inbox->letter_type_id,
            'subject' => $inbox->subject,
            'body' => 'Dikembalikan ke ' . $inbox->sender_id,
        ]);
    }

    public function approve($data, $file = null)
    {
        $inbox = Inbox::join('users as sender', 'inbox.sender_id', '=', 'sender.id')
            ->select(
                'inbox.*',
                'sender.name as sender_name'
            )
            ->where('inbox.id', $data['id_letter'])
            ->first();
        $sender = auth('web')->user()->id;
        $letter_number = date('Y') . '/' . 'USNI' . '/' . str_pad($sender, 3, '0', STR_PAD_LEFT) . rand(0, 999);
        DB::beginTransaction();
        if ($file != null) {
            try {
                $name = $file->getClientOriginalName();
                $path = $file->storeAs('outgoing_letters', $name, 'public');
                $sent_data = [
                    'receiver_id' => $inbox->sender_id,
                    'sender_id' => $sender,
                    'letter_number' => $letter_number,
                    'letter_type_id' => $inbox->letter_type_id,
                    'subject' => $inbox->subject,
                    'body' => 'Dikembalikan ke ' . $inbox->sender_name,
                    'date' => date('Y-m-d'),
                    'sent_id' => $inbox->sent_id,
                    'attachment' => $path
                ];

                $sent = Sent::create($sent_data);
                $check_role = User::where('id', $inbox->sender_id)->first();
                $is_staff = $check_role->role == 'lecturer' ? false : true;

                $new_inbox = Inbox::create([
                    'receiver_id' => $inbox->sender_id,
                    'sender_id' => $sender,
                    'letter_number' => $letter_number,
                    'letter_type_id' => $inbox->letter_type_id,
                    'subject' => $inbox->subject,
                    'body' => 'Dikembalikan ke ' . $inbox->sender_name,
                    'date' => date('Y-m-d'),
                    'sent_id' => $sent->id,
                    'is_staff' => $is_staff,
                    'attachment' => $path
                ]);
                Notification::create([
                    'receiver_id' => $inbox->sender_id,
                    'inbox_id' => $new_inbox->id
                ]);
                Reply::create([
                    'id_letter' => $data['id_letter'],
                    'file' => $path,
                    'inbox_id' => $new_inbox->id
                ]);
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                throw $th;
            }
        } else {
            try {
                $sent_data = [
                    'receiver_id' => $inbox->sender_id,
                    'sender_id' => $sender,
                    'letter_number' => $letter_number,
                    'letter_type_id' => $inbox->letter_type_id,
                    'subject' => $inbox->subject,
                    'body' => 'Dikembalikan ke ' . $inbox->sender_name,
                    'date' => date('Y-m-d'),
                    'sent_id' => $inbox->sent_id,

                ];
                $sent = Sent::create($sent_data);
                $check_role = User::where('id', $inbox->sender_id)->first();
                $is_staff = $check_role->role == 'lecturer' ? false : true;

                $new_inbox = Inbox::create([
                    'receiver_id' => $inbox->sender_id,
                    'sender_id' => $sender,
                    'letter_number' => $letter_number,
                    'letter_type_id' => $inbox->letter_type_id,
                    'subject' => $inbox->subject,
                    'body' => 'Dikembalikan ke ' . $inbox->sender_name,
                    'date' => date('Y-m-d'),
                    'is_staff' => $is_staff,
                    'sent_id' => $sent->id,

                ]);
                Notification::create([
                    'receiver_id' => $inbox->sender_id,
                    'inbox_id' => $new_inbox->id
                ]);
                Reply::create([
                    'id_letter' => $data['id_letter'],
                    'greeting' => $data['greeting'],
                    'closing' => $data['closing'],
                    'inbox_id' => $new_inbox->id,
                    'sincerely_id' => $data['sincerely_id']
                ]);
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                throw $th;
            }
        }
    }
    public function update($id, $data)
    {
        try {
            $reply =  Reply::where('id', $id)->first();
            $reply->update([
                'greeting' => $data['greetings'],
                'closing' => $data['closings'],
                'sincerely_id' => $data['sincerelys_id']
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
