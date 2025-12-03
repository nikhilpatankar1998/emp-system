<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function chatpage()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('admin.chat', compact('users'));
    }

    // public function sendMessage(Request $request)
    // {
    //     $request->validate([
    //         // 'receiver_id' => 'required|exists:users,id',
    //         // 'receiver_id' => 'required|integer', // Allows 9999 for group
    //         'receiver_id' => [
    //             'required',
    //             'integer',
    //             function ($attribute, $value, $fail) {
    //                 if ($value !== 9999 && !\App\Models\User::where('id', $value)->exists()) {
    //                     $fail('Receiver must be a valid user or group.');
    //                 }
    //             },
    //         ],
    //         'message' => 'nullable|string',
    //         'file' => 'nullable|file|max:10240', // max 10MB
    //     ]);

    //     $chat = new Message();
    //     $chat->sender_id = auth()->id();
    //     $chat->receiver_id = $request->receiver_id;
    //     $chat->message = $request->message;

    //     // if ($request->hasFile('file')) {
    //     //     $file = $request->file('file');
    //     //     $type = $file->getClientMimeType();

    //     //     $filePath = $file->store('chat_files', 'public');
    //     //     $chat->file_path = $filePath;

    //     //     if (str_starts_with($type, 'image')) {
    //     //         $chat->file_type = 'image';
    //     //     } elseif (str_starts_with($type, 'video')) {
    //     //         $chat->file_type = 'video';
    //     //     } else {
    //     //         $chat->file_type = 'other';
    //     //     }
    //     // }

    //     if ($request->hasFile('file')) {
    //         $file = $request->file('file');
    //         $type = $file->getClientMimeType();

    //         // Get original name
    //         $originalName = $file->getClientOriginalName();

    //         // Store with original name in storage/app/public/chat_files/
    //         $filePath = $file->storeAs('chat_files', $originalName, 'public');

    //         $chat->file_path = $filePath;

    //         if (str_starts_with($type, 'image')) {
    //             $chat->file_type = 'image';
    //         } elseif (str_starts_with($type, 'video')) {
    //             $chat->file_type = 'video';
    //         } else {
    //             $chat->file_type = 'other';
    //         }
    //     }

    //     $chat->save();

    //     return response()->json($chat);
    // }

    public function sendMessage(Request $request)
{
    $request->validate([
        'receiver_id' => [
        'required',
        function ($attribute, $value, $fail) {
            \Log::info('Receiver ID:', ['value' => $value]);
            if ($value != 9999 && !\App\Models\User::where('id', $value)->exists()) {
                $fail('Invalid receiver_id.');
            }
        }
    ],
        'message' => 'nullable|string',
        'file' => 'nullable|file|max:10240', // 10MB
    ]);

    $chat = new Message();
    $chat->sender_id = auth()->id();
    $chat->receiver_id = $request->receiver_id;
    $chat->message = $request->message;

    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $type = $file->getClientMimeType();
        $originalName = $file->getClientOriginalName();
        $filePath = $file->storeAs('chat_files', $originalName, 'public');

        $chat->file_path = $filePath;

        if (str_starts_with($type, 'image')) {
            $chat->file_type = 'image';
        } elseif (str_starts_with($type, 'video')) {
            $chat->file_type = 'video';
        } else {
            $chat->file_type = 'other';
        }
    }

    $chat->save();

    return response()->json($chat);
}


    // public function getMessages($userId)
    // {
    //     $messages = Message::where(function ($q) use ($userId) {
    //         $q->where('sender_id', auth()->id())->where('receiver_id', $userId);
    //     })->orWhere(function ($q) use ($userId) {
    //         $q->where('sender_id', $userId)->where('receiver_id', auth()->id());
    //     })->orderBy('created_at')->get();

    //     return response()->json($messages);
    // }
// working fine but -------------------------------------------------------------
    // public function getMessages($userId)
    // {
    //     if ($userId == 9999) {
    //         // Fetch group chat messages
    //         $messages = Message::where('receiver_id', 9999)
    //             ->orderBy('created_at')
    //             ->get();
    //     } else {
    //         // Fetch personal chat messages
    //         $messages = Message::where(function ($q) use ($userId) {
    //             $q->where('sender_id', auth()->id())->where('receiver_id', $userId);
    //         })
    //             ->orWhere(function ($q) use ($userId) {
    //                 $q->where('sender_id', $userId)->where('receiver_id', auth()->id());
    //             })
    //             ->orderBy('created_at')
    //             ->get();

    //     }

    //     return response()->json($messages);
    // }



public function getMessages($userId)
{
    if ($userId == 9999) {
        // Group chat messages
        $messages = Message::where('receiver_id', 9999)
            ->with('sender:id,name') // eager load sender
            ->orderBy('created_at')
            ->get();
    } else {
        // Personal chat messages
        $messages = Message::where(function ($q) use ($userId) {
                $q->where('sender_id', auth()->id())->where('receiver_id', $userId);
            })
            ->orWhere(function ($q) use ($userId) {
                $q->where('sender_id', $userId)->where('receiver_id', auth()->id());
            })
            ->with('sender:id,name') // eager load sender
            ->orderBy('created_at')
            ->get();
    }

    // Transform for frontend
    $transformed = $messages->map(function ($msg) {
        return [
            'id' => $msg->id,
            'sender_id' => $msg->sender_id,
            'sender_name' => $msg->sender->name ?? 'Unknown',
            'message' => $msg->message,
            'created_at' => $msg->created_at,
            'file_path' => $msg->file_path,
            'file_type' => $msg->file_type,
        ];
    });

    return response()->json($transformed);
}


    public function getuserchatpage()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('user.chatpage', compact('users'));
    }

    //for the chat page message counter.
    // public function getUnreadCounts()
    // {
    //     $adminId = auth()->id(); // Admin ID
    //     $counts = DB::table('messages')
    //         ->select('sender_id', DB::raw('COUNT(*) as unread_count'))
    //         ->where('receiver_id', $adminId)
    //         ->where('receiver_id', '!=', 9999)
    //         ->where('is_read', false)
    //         ->groupBy('sender_id')
    //         ->get();

    //     return response()->json($counts);
    // }

    public function getUnreadCounts()
    {
        $adminId = auth()->id(); // Current user
    
        // Personal unread message counts
        $personalCounts = DB::table('messages')
            ->select('sender_id', DB::raw('COUNT(*) as unread_count'))
            ->where('receiver_id', $adminId)
            ->where('is_read', false)
            ->groupBy('sender_id')
            ->get();
    
        // Group unread message count (messages to group not sent by current user)
        $groupCount = DB::table('messages')
            ->where('receiver_id', 9999)
            ->where('sender_id', '!=', $adminId)
            ->where('is_read', false)
            ->count();
    
        // Format the result
        $result = $personalCounts->toArray();
    
        // If there are unread group messages, add to the result
        if ($groupCount > 0) {
            $result[] = (object)[
                'sender_id' => 9999, // Use 9999 to map to group in frontend
                'unread_count' => $groupCount,
            ];
        }
    
        return response()->json($result);
    }
    

    // public function markAsRead($senderId)
    // {
    //     Message::where('sender_id', $senderId)
    //         ->where('receiver_id', auth()->id())
    //         ->where('is_read', false)
    //         ->update(['is_read' => true]);

    //     return response()->json(['status' => 'success']);
    // }

    public function markAsRead($senderId)
{
    if ($senderId == 9999) {
        // Mark all group messages as read that are not from this user
        Message::where('receiver_id', 9999)
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
    } else {
        // Personal chat messages
        Message::where('sender_id', $senderId)
            ->where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    return response()->json(['status' => 'success']);
}


    //for the counter in sidebar chat 
    public function getUnreadCount()
    {
        $adminId = auth()->id(); // Admin user
        $count = \App\Models\Message::where('receiver_id', $adminId)
            ->where('is_read', false)
            ->count();

        return response()->json(['unread_count' => $count]);
    }
    // public function getGroupMessages()
    // {
    //     $messages = ChatMessage::whereNull('receiver_id') // group chat has no receiver_id
    //                 ->orderBy('created_at', 'asc')
    //                 ->get();

    //     return response()->json($messages);
    // }

    // public function sendGroupMessage(Request $request)
    // {
    //     $message = new ChatMessage();
    //     $message->sender_id = auth()->id();
    //     $message->message = $request->message;

    //     // Handle file upload
    //     if ($request->hasFile('file')) {
    //         $file = $request->file('file');
    //         $path = $file->store('chat_files', 'public');
    //         $message->file_path = $path;

    //         $ext = strtolower($file->getClientOriginalExtension());
    //         $message->file_type = in_array($ext, ['jpg', 'jpeg', 'png', 'gif']) ? 'image' :
    //                               (in_array($ext, ['mp4', 'mov']) ? 'video' : 'file');
    //     }

    //     $message->save();

    //     return response()->json($message);
    // }
    // public function unreadCounts()
    // {
    //     $userId = auth()->id();

    //     $userUnreads = Message::select('sender_id', DB::raw('COUNT(*) as unread_count'))
    //         ->where('receiver_id', $userId)
    //         ->where('is_read', false)
    //         ->groupBy('sender_id')
    //         ->get();

    //     $groupUnread = GroupMessage::whereDoesntHave('readers', function($query) use ($userId) {
    //         $query->where('user_id', $userId);
    //     })->count();

    //     return response()->json([
    //         'user_unreads' => $userUnreads,
    //         'group_unread' => $groupUnread
    //     ]);
    // }
  public function latestMessage()
{
    $userId = auth()->id();

    $latest = Message::where('receiver_id', $userId)
        ->where('is_read', false)
        ->latest()
        ->first();

    if ($latest) {
        return response()->json([
            'sender_name' => $latest->sender->name ?? 'Unknown',
            'message' => $latest->message
        ]);
    }

    return response()->json(null);
}

}
