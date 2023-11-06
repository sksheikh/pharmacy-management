<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // return $request->all();
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

    public function destroy(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();

        $response = [
            'success' => true,
            'message' => 'Vendor deleted succefully'
        ];

        return response($response,200);

    }

    public function update(Request $request, $id)
    {
        // return $request->all();
        $vendor = Vendor::findOrFail($id);

        $vendor->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        $response = [
            'success' => true,
            'message' => 'Vendor updated succefully'
        ];

        return response($response,200);

    }
}
