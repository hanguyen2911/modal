<?php

namespace App\Http\Controllers;
use App\Models\Car;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class CarController extends Controller
{
    private $status = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $cars=Car::all();
        if(count($cars)>0){
            return response()->json(["status"=>$this->status,"success"=>true,"count"=>count($cars),"data"=>$cars]);
        }else{
            return response()->json(["status"=>"failed","success"=>false,"message"=>"Whoopa! no record found"]);
            
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),
        [
            "description"  => "required",
            "model" => "required",
            "produced_on"  => "required|date",

            'image'=>'mimes:jpeg,jpg,png,gif|max:10000'

        ]
    );

        if ($validation->fails()){
            return response()->json(["status" => "error", "errors" => $validation->getMessageBag()]);
        }
         //nếu dùng $this->validate() thì lấy về lỗi: $errors = $vali
    //kiểm tra file tồn tại
    $name='';
        
    if($request->hasfile('image'))
    {
        $this->validate($request, 
        [
        //Kiểm tra đúng file đuôi .jpg,.jpeg,.png.gif và dung lượng không quá 2M
            'image' => 'mimes:jpg,jpeg,png,gif|max:2048',
        ],          
        [
        //Tùy chỉnh hiển thị thông báo không thõa điều kiện
            'image.mimes' => 'Chỉ chấp nhận hình thẻ với đuôi .jpg .jpeg .png .gif',
            'image.max' => 'Hình thẻ giới hạn dung lượng không quá 2M',
        ]
    );
        $file = $request->file('image');
        $name=time().'_'.$file->getClientOriginalName();
        $destinationPath=public_path('images'); //project\public\images\cars, //public_path(): trả về đường dẫn tới thư mục public
        $file->move($destinationPath, $name); //lưu hình ảnh vào thư mục public/images/cars
    } 
  
    
    $car=new Car();
    $car->description=$request->input('description');
    $car->model=$request->input('model');
    $car->produced_on=$request->input('produced_on');
    //$car->manufacturer_id=$request->input('manufacturer_id');
    $car->image=$name;
    $car->save();
    if($car) {            
            return response()->json(["status" => $this->status, "data" => $car]);
        }    
    else {
            return response()->json(["status" => "error", "errors" => $validation->getMessageBag()]);
    }
}
        
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
