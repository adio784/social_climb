<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\BannerService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    //
    protected $bannerServices;
    public function __construct(BannerService $bannerServices)
    {
        $this->bannerServices = $bannerServices;
    }
    public function index()
    {
        $data = [ 'Banners'=> $this->bannerServices->all() ];
        return view('control.banners', $data);
    }

    public function getActiveBanners()
    {
        return $this->bannerServices->getActiveBanners();
    }

    public function read(Request $request)
    {
        $id = $request->route('id');
        $data = [ 'Banners'=> $this->bannerServices->all() ];
        return view('control.banners', $data);
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'bannerImage' => 'required|mime:png,jpg,jpeg|max:2048'
            ]);

            if ($request->hasFile('bannerImage')) {

                $fileName   = Str::uuid() . "." . $request->file("bannerImage")->extension();
                $filePath   = $request->file("bannerImage")->storeAs("banners", $fileName, "public");
                $id         = auth()->user()->id;
                $data       = [
                    'title' => $request->title,
                    'banner_image' => $filePath,
                    'posted_by' => $id
                ];
                $this->bannerServices->createBanner($data);
                return back()->with('success', 'Record Successfully Created !!!');
            } else {
                return back()->with('fail', 'No file uploaded!');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return back()->with('fail', 'Error Creating Record !!!');
        }
    }

    public function update(Request $request)
    {
        try {

            if ($request->hasFile('bannerImage')) {
                $request->validate([
                    'bannerImage' => 'required|mime:png,jpg,jpeg|max:2048'
                ]);
                $id         = $request->id;
                $fileName   = Str::uuid() . "." . $request->file("bannerImage")->extension();
                $filePath   = $request->file("bannerImage")->storeAs("banners", $fileName, "public");

                $data = [
                    'title'         => $request->title,
                    'banner_image'  => $filePath
                ];
                $this->bannerServices->createBanner($id, $data);
                return back()->with('success', 'Record Successfully Updated !!!');
            } else {

                return back()->with('fail', 'No file uploaded!');
            }

        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return back()->with('fail', 'Error Updating Record !!!');
        }
    }

    public function delete($id)
    {
        try {
            $this->bannerServices->deleteBanner($id);
            return back()->with('success', 'Record Successfully Deleted !!!');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return back()->with('fail', 'Error Updating Record !!!');
        }
    }

    public function toggle($id)
    {

        try{
            $planState = $this->bannerServices->getBannerById($id);
            $state = ($planState->status == 1) ? 0 : 1;
            $this->bannerServices->updateBanner($id, ['status' => $state]);
            return back()->with('success', 'Record Successfully Updated !!!');

        }catch(\Exception $e){
            Log::debug($e->getMessage());
            return back()->with('success', 'Error Occured !!!');
        }

    }
}
