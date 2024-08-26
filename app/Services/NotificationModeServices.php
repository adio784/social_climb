<?php
namespace App\Services;

use App\Models\NotificationMode;

class NotificationModeServices
{
    public function all()
    {
        return NotificationMode::all();
    }

    public function createNotificationMode(array $Data)
    {
        return NotificationMode::create($Data);
    }

    public function getActiveNotificationModes()
    {
        return NotificationMode::where('status', 1)->orderBy('id', 'desc')->get();
    }

    public function getNotificationModeByName($name)
    {
        return NotificationMode::where('name', $name)->first();
    }

    public function getInactiveNotificationMode()
    {
        return NotificationMode::where('status', 0)->orderBy('id', 'desc')->get();
    }

    public function getNotificationModeById($id)
    {
        return NotificationMode::find($id);
    }

    public function updateNotificationMode($id, $data)
    {

        return NotificationMode::where('id', $id)->update($data);
    }

    public function deleteNotificationMode($id)
    {
        return NotificationMode::where('id', $id)->delete();
    }
}
