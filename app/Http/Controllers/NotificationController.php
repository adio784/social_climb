<?php

namespace App\Http\Controllers;

use App\Services\NotificationServices;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    //
    use ResponseTrait;
    protected $notificationServices;
    public function __construct(NotificationServices $notificationServices)
    {
        $this->notificationServices = $notificationServices;
    }


    public function index()
    {
        $data = [ 'Notifications'=> $this->notificationServices->all() ];
        return view('control.notifications', $data);
    }

    public function getActiveNotice()
    {
        try {
            $data = $this->notificationServices->getActiveNotification();
            return $this->successResponse("Successful", $data);
        } catch (\Exception $ex) {
            return $this->inputErrorResponse("Something went wrong", 401);
        }
    }

    public function read(Request $request)
    {
        $id = $request->route('id');
        $data = [ 'Notifications'=> $this->notificationServices->all() ];
        return view('control.notifications', $data);
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'message' => 'required|string'
            ]);
            $data = [
                'title' => $request->title,
                'message' => $request->message,
                'posted_by' => Auth::user()->id
            ];
            $this->notificationServices->createNotification($data);
            return back()->with('success', 'Record Successfully Created !!!');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return back()->with('fail', 'Error Creating Record !!!');
        }
    }

    public function update(Request $request)
    {
        try {
            $id = $request->id;
            $data = [
                'title' => $request->title,
                'message' => $request->message
            ];
            $this->notificationServices->createNotification($id, $data);
            return back()->with('success', 'Record Successfully Updated !!!');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return back()->with('fail', 'Error Updating Record !!!');
        }
    }

    public function delete($id)
    {
        try {
            $this->notificationServices->deleteNotification($id);
            return back()->with('success', 'Record Successfully Deleted !!!');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return back()->with('fail', 'Error Updating Record !!!');
        }
    }

    public function toggle($id)
    {

        try{
            $planState = $this->notificationServices->getNotificationById($id);
            $state = ($planState->status == 1) ? 0 : 1;
            $this->notificationServices->updateNotification($id, ['status' => 0]);
            $this->notificationServices->updateNotification($id, ['status' => $state]);
            return back()->with('success', 'Record Successfully Updated !!!');

        }catch(\Exception $e){
            Log::debug($e->getMessage());
            return back()->with('success', 'Error Occured !!!');
        }

    }
}
