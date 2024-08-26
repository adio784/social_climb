<?php
namespace App\Services;

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerService
{
    public function all()
    {
        return Banner::all();
    }

    public function createBanner(array $Data)
    {
        return Banner::create($Data);
    }

    public function getActiveBanners()
    {
        return Banner::where('status', 1)->orderBy('id', 'desc')->get();
    }

    public function getInactiveBanner()
    {
        return Banner::where('status', 0)->orderBy('id', 'desc')->get();
    }

    public function getBannerById($id)
    {
        return Banner::find($id);
    }

    public function updateBanner($id, $data)
    {
        $banner = Banner::where('id', $id)->first();

        if ($banner->banner_image) {
            Storage::disk('public')->delete($banner->banner_image);
        }
        return Banner::where('id', $id)->update($data);
    }

    public function deleteBanner($id)
    {
        return Banner::where('id', $id)->delete();
    }
}
