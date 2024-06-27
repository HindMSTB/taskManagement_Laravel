<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tache;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
class NotificationController extends Controller
{
   

public function markNotificationAsRead($id)
{
    $notification = Notification::findOrFail($id);
    $notification->update(['Vu' => 1]);

    return redirect()->back()->with('success', 'Notification marquée comme lue');
}

public function markAllAsRead()
{
    $user_id = Auth::id();

    Notification::where('vu', 0)
        ->whereHas('tache', function ($query) use ($user_id) {
            $query->where('user_id', $user_id)
                ->orWhere('createdBy', $user_id);
        })
        ->update(['VUFromBouttonNotif' => 1]);

    return response()->json(['success' => true]);
}
    
 
}

