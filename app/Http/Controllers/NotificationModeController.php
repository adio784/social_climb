<?php

namespace App\Http\Controllers;

use App\Services\NotificationModeServices;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class NotificationModeController extends Controller
{
    //
    use ResponseTrait;
    protected $noticeModeServices;
    public function __construct(NotificationModeServices $noticeModeServices)
    {
        $this->noticeModeServices = $noticeModeServices;
    }

    public function index()
    {
        try {
            $data = $this->noticeModeServices->all();
            return $this->successResponse("Successful", $data);
        } catch (\Exception $ex) {
            return $this->inputErrorResponse("Something went wrong", 401);
        }
    }

    public function toggle($id)
    {

        try{
            $planState = $this->noticeModeServices->getNotificationModeById($id);
            $state = ($planState->status == 1) ? 0 : 1;
            $this->noticeModeServices->updateNotificationMode($id, ['status' => $state]);
            return $this->successResponse("Successful");
        }catch(\Exception $e){
            return $this->inputErrorResponse("Something went wrong");
        }

    }
}
