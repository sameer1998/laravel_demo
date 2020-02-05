<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PassportController;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Validator,File;
use App\models\Products;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $token = $request->header('Authorization');
        if (isset($token)) {
            $isLogin = PassportController::CheckLogin($request->header('Authorization'));
            if ($isLogin == true) {
                $content['status'] = 200;
                $content['message'] = 'Success';
            } else {
                $content['status'] = 412;
                $content['message'] = 'Invalid Login Id or Password';
            }
        } else {
            $content['status'] = 401;
            $content['message'] = 'Please Login To Continue';
        }
        return response()->json($content);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request)
    {
        $token = $request->header('Authorization');
        if (isset($token)) {
            $isLogin = PassportController::CheckLogin($token);
            if ($isLogin == true) {
                /*******
                 * Add Validation Below For Required Field
                 *******/
                $validator = Validator::make($request->all(),
                    ['product_id' => 'required']);
                /*******
                 * if Validation fails
                 ******/

                if ($validator->fails()) {
                    $content['status'] = 412;
                    $content['message'] = $validator->errors()->first();
                } else {
                    /*******
                     * Do Code Here For Any Valdate Api with token
                     * when validation success
                     ******/
                    if ($request->hasFile('file')) {
                        $image = $request->file('file');
                        $name = str_random(5).time() . '.' . $image->getClientOriginalExtension();
                        $path = public_path('/public/product/');
                        if(!File::exists($path)) {
                            File::makeDirectory($path,$mode = 0777, true, true);
                        }
                        $image->move($path,$name);
                        $product =  new Products();
                        $product->image = $name;
                        $product->name = 'test';
                        $product->save();
                    }
                    $content['status'] = 200;
                    $content['message'] = 'Success';
                }
            } else {
                $content['status'] = 412;
                $content['message'] = 'Invalid Token';
            }
        } else {
            $content['status'] = 401;
            $content['message'] = 'Please Login To Continue';
        }
        return response()->json($content);
    }

    public function imageFunction(Request $request)
    {
        $token = $request->header('Authorization');
        if (isset($token)) {
            $isLogin = PassportController::CheckLogin($token);
            if ($isLogin == true) {
                /*******
                 * Add Validation Below For Required Field
                 *******/
                $validator = Validator::make($request->all(),
                    ['product_id' => 'required']);
                /*******
                 * if Validation fails
                 ******/

                if ($validator->fails()) {
                    $content['status'] = 412;
                    $content['message'] = $validator->errors()->first();
                } else {
                    /*******
                     * Do Code Here For Any Valdate Api with token
                     * when validation success
                     ******/
                    $product = Products::where('id',$request->product_id)->first();
                    $product->image =  checkImage(1,$product->image);
                    $content['status'] = 200;
                    $content['message'] = 'Success';
                    $content['data'] = $product;

            }
            } else {
                $content['status'] = 412;
                $content['message'] = 'Invalid Token';
            }
        } else {
            $content['status'] = 401;
            $content['message'] = 'Please Login To Continue';
        }
        return response()->json($content);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
