<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\DB;   
use App\Models\Person;
use App\Models\State;
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
     * Author: user_detail
     * Purpose : it returns details of currrent user     
     */
    public function logout(Request $request)
    {
        //pr( $request->user()->toArray());exit;
        try
        {
            $request->user()->currentAccessToken()->delete();
            return $this->sendResponse([], 'You are logged out successfully.');
        
        } 
        catch (\Exception $e) 
        {
            print_r($e->getMessage());
            exit;
        }        

    } 
     /**
     * Author: user_detail
     * Purpose : it returns details of currrent user     
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
        $result['user_detail']=array();
        $result['address_detail']=array();

        $user_data = DB::table('login as l')
            ->join('person as p', 'p.id', '=', 'l.person_id')        
            ->select('p.name','l.email','l.active_from','l.active_thru','l.is_primary' )
            ->where("l.person_id","=",$person_id)
            ->first();
        
        
        if($user_data)
        {
            $user_data=obj_to_array($user_data);            
            $result['user_detail']=$user_data;
            
            $address_data = DB::table('person as p')
                    ->join('person_address as pa', 'pa.person_id', '=', 'p.id')
                    ->join('address as a', 'a.id', '=', 'pa.address_id')
                    ->where('p.id', $person_id)
                    ->get()->toArray();
            if($address_data)
            {             
                foreach($address_data  as $key=>$value)
                {    
                    $address_info=obj_to_array($value);
                    $state_country=State::with('country')->where('id',$address_info['state_id'])->first()->toArray();                    
                    if($state_country)
                    { 
                         $address_info['state']=$state_country['name'];                         
                         $address_info['country']=$state_country['country']['name'];                         
                         $result['address_detail'][]=$address_info;
                    }
                }           
           
            }
            // echo "Final result";
             pr($result);
             exit;
            // $query=DB::getQueryLog();
            // pr($query);  

        }
        else
        {
            return $this->sendError('Invalid user id.', ['error'=>'Please enter valid user id.']);
        }   
        return $this->sendResponse($result, 'Record found successfully.');
        
    }    
}