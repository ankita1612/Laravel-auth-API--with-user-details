<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\DB;   
class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = md5($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User register successfully.');
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {          
        //DB::enableQueryLog();
        $user_data=User::select("*","person_id AS id")->where(array("email"=>$request->email,"pass"=>md5($request->password)))->first();           
        //$query=DB::getQueryLog();
        // pr($query);    pr($user_data);exit;
        if($user_data)
        { 
            $user = $user_data;                             
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            //$success['name'] =  $user->name;   
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else
        { 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    } 
     /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function user_detail(Request $request)
    {  
        $validator = Validator::make($request->all(), [            
            'person_id' => 'required',            
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $person_id=$request->person_id;
        
        DB::enableQueryLog();
       
        $user_data=User::where("person_id","=",$person_id)->get();           
     //   pr($user_data);

        $query=DB::getQueryLog();
       //  pr($query);    pr($user_data->toArray());
       //  exit;

        $data['user_data'] = $user_data;                             
            
        return $this->sendResponse($data, 'User login successfully.');
        
    }    
}