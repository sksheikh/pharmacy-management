<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function index()
    {
        $vendor = Vendor::orderBy('name','asc')->get();

        $response = [
            'success' => true,
            'data' => $vendor,
            'message' => 'Vendor get succefully'
        ];

        return response($response,200);

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()){
            $response = [
                'success' => false,
                'message' => 'Vendor create failed'
            ];
            return response($response,400);
        }else{

            $vendor = Vendor::create($request->all());

            $response = [
                'success' => true,
                'data' => $vendor,
                'message' => 'Vendor created succefully'
            ];

            return response($response,200);
        }

    }
}
