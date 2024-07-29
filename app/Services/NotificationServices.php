<?php
namespace App\Services;

use App\Models\Notification;

class NotificationServices
{
    public function all()
    {
        return Notification::all();
    }

    public function createNotification(array $Data)
    {
        return Notification::create($Data);
    }

    public function getActiveNotification()
    {
        return Notification::where('status', 1)->orderBy('id', 'desc')->get();
    }

    public function getInactiveNotification()
    {
        return Notification::where('status', 0)->orderBy('id', 'desc')->get();
    }

    public function getNotificationById($id)
    {
        return Notification::find($id);
    }

    public function updateNotification($id, $data)
    {
        return Notification::where('id', $id)->update($data);
    }

    public function deleteNotification($id)
    {
        return Notification::where('id', $id)->delete();
    }
}
