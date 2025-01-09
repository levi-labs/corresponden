<?php

namespace App\Services;

use App\Models\Reply;
use Illuminate\Support\Facades\DB;

class ReplyService
{


    public function approve($data, $file = null)
    {
        DB::beginTransaction();
        if ($file != null) {

            try {
                $path = $file->store('outgoing_letters', 'public');
                Reply::create([
                    'id_letter' => $data['id_letter'],
                    'file' => $path
                ]);
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                throw $th;
            }
        } else {
            try {
                Reply::create([
                    'id_letter' => $data['id_letter'],
                    'greeting' => $data['greeting'],
                    'closing' => $data['closing']
                ]);
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                throw $th;
            }
        }
    }
}
