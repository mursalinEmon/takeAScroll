<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use App\Events\ChatEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function contacts(){
        $contacts=[];
        if(auth()->user()->type == "admin"){
            $contacts=User::where('id','!=', auth()->user()->id)->get();

        }
        else{
            $admin=User::findOrFail('6');
            array_push($contacts,$admin);
        }

        return response()->json($contacts);
    }
    public function fetchMessages($id){
        $messages=Message::where(function($q) use($id){
            $q->where('from', auth()->user()->id);
            $q->where('to',$id);
        })->orWhere(
            function($q)use($id){
                $q->where('from',$id);
                $q->where('to',auth()->user()->id);
            }
        )->get();
        return response()->json($messages);
    }
    public function storeMessage(Request $request){
        $message=Message::create([
            'body'=>$request->body,
            'from'=>auth()->user()->id,
            'to'=>$request->to,
        ]);
        broadcast(new ChatEvent($message));
        return response()->json($message);
    }
    public function unreadcount(){
        $messages= DB::table('messages')
        ->where('seen',0)
        ->Where('to', auth()->user()->id)
        ->get();
        $count=$messages->count();
        return response(['count'=>$count]);
    }
    public function markasseen(Request $request){

        DB::table('messages')
            ->where('from',$request['contact']['id'])
            ->where('to', auth()->user()->id)
            ->update([
                'seen'=>1
            ]);
        return response([]);
    }
}
