<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\User;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GetfollowerService
{
    use ResponseTrait;
    public $apiKey = '';
    public $apiUrl = '';
    protected User $user;
    protected Payment $payment;

    public function __construct()
    {
        $this->apiKey = "v1TpP8WZMsoaEIk3jDdeh30WBxYSveTT";
        $this->apiUrl = "https://clientarea.getfollowed.com.ng/api/v1";
    }

    public function connect(array $post)//: JsonResponse
    {
        try {
            $query      = http_build_query($post);
            $url        = $this->apiUrl . '?' . $query;
            $response   = Http::withUserAgent('API (compatible; MSIE 5.01; Windows NT 5.0)')->get($url);

            if ($response->successful()) {
                return $response->body();
            }

            return false;
        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), "Something went wrong", 401);
        }
    }

    // private function connect($post) {
    //     $_post = Array();

    //     if (is_array($post)) {
    //       foreach ($post as $name => $value) {
    //         $_post[] = $name.'='.urlencode($value);
    //       }
    //     }

    //     if (is_array($post)) {
    //       $url_complete = join('&', $_post);
    //     }
    //     $url = $this->apiUrl."?".$url_complete;

    //     $ch = curl_init($url);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //     curl_setopt($ch, CURLOPT_HEADER, 0);
    //     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    //     curl_setopt($ch, CURLOPT_USERAGENT, 'API (compatible; MSIE 5.01; Windows NT 5.0)');
    //     $result = curl_exec($ch);
    //     if (curl_errno($ch) != 0 && empty($result)) {
    //       $result = false;
    //     }
    //     curl_close($ch);
    //     return $result;
    // }

    public function balance()//: JsonResponse
    {
        $result = $this->connect(['key' => $this->apiKey, 'action' => 'balance']);
        return json_decode($result);
    }

    public function services()//: JsonResponse
    {
        $result = $this->connect([
            'key' => $this->apiKey,
            'action' => 'services'
        ]);
        return json_decode($result);
    }


    public function addOrder(array $data): JsonResponse
    {
        try {
            $post = array_merge(['key' => $this->apiKey, 'action' => 'add'], $data);
            $result = $this->connect($post);
            $decodedResult = json_decode($result, true);
            return response()->json($decodedResult);
        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), "Something went wrong", 401);
        }
    }

    public function status($orderId)
    //: JsonResponse
    {
        $result = $this->connect(['key' => $this->apiKey, 'action' => 'status', 'order' => $orderId]);
        return json_decode($result);
    }

    public function multi_status($orderIds): JsonResponse
    {
        $result = $this->connect([
            'key' => $this->apiKey,
            'action' => 'status',
            'order' => implode(",", [$orderIds])
        ]);
        return json_decode($result);
    }
}
