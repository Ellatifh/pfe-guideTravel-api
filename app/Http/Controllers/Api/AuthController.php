<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['signup','login','forgot_password']);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $this->authorize('isAdmin');
        $users = User::all();

        // return response
        $response = [
            'success' => true,
            'message' => 'users retrieved successfully.',
            'data' => $users,
        ];

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        //$this->authorize('isAdmin');
        $validators = Validator::make($request->all(),[
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
            'c_password' => 'required|string|same:password',
            'role' => 'required|string|in:admin,tourist,user'
        ]);
        if ($validators->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validators->errors(),
                'message' => "user creation failed"
            ], 422);
        }

        $user = new User([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password)
        ]);
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'user created Successfully!'
        ], 200);
    }

    public function update(Request $request,$id)
    {
        // $this->authorize('isAdmin');
        $user = User::find($id);
        if($user){
            $input = $request->all();
            $validators = Validator::make($request->all(),[
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|unique:users,email,'.$user->id,
                'password' => 'required|string|min:6',
                'c_password' => 'required|string|same:password',
                'role' => 'required|string|in:admin,tourist,user'
            ]);

            if ($validators->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validators->errors(),
                    'message' => "user update failed"
                ], 422);
            }

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->password = bcrypt($request->password);
            $user->save();

            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'user update Successfully!'
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => "user id does not exist on database"
        ], 404);
    }

    public function show($id)
    {
        //$this->authorize('isAdmin');
        $user = User::find($id);

        if($user){
            $response = [
                'success' => true,
                'data'    => $user,
                'message' => 'user retrieved successfully.',
            ];
            return response()->json($response, 200);
        }
        $response = [
            'success' => false,
            'message' => 'user not found',
        ];
        return response()->json($response, 404);
    }

    public function destroy($id){
        //$this->authorize('isAdmin');
        $user = User::find($id);

        if (!$user) {
            $response = [
                'success' => false,
                'message' => 'user not found',
            ];
            return response()->json($response, 404);
        }
        $user->delete();

        // return response
        $response = [
            'success' => true,
            'message' => 'user deleted successfully.',
        ];
        return response()->json($response, 200);
    }

    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $validators = Validator::make($request->all(),[
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
            'c_password' => 'required|string|same:password',
            'role' => 'required|string|in:tourist,user'
        ]);
        if ($validators->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validators->errors(),
                'message' => $validators->errors()->all()[0]
            ], 200);
        }

        $user = new User([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Successfully created user!'
        ], 200);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $validators = Validator::make($request->all(),[
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();
        return response()->json([
            'status' => true,
            'user' => new UserResource($user),
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer'
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'status' => true,
            'message' => 'logged out Successfully'
        ]);
    }

       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function forgot_password(Request $request)
    {
        $input = $request->all();
        $code = 400;
        $rules = array(
            'email' => "required|email",
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $rslt = array("status" => false, "message" => $validator->errors()->first(), "data" => array());
        } else {
            $user = User::where('email',$input['email'])->first();
            if($user){
                $mdp = str_random(8);
                $user->password = bcrypt($mdp);
                $user->save();

                $data = ['username'=>$user->first_name." ".$user->last_name,"password" => $mdp];
                Mail::to($input['email'])->send(new ResetPassword($data));

                $rslt = [
                    'status' => true,
                    'message' => 'password has been sent to your email'
                ];
                $code = 200;
            }else{
                $rslt = [
                    'status' => false,
                    'message' => 'User not found on database'
                ];
                $code = 404;
            }
        }
        return response()->json($rslt,$code);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|string|min:6',
            'new_password2' => 'required|string|same:new_password'
        ]);

        if($validator->fails()){
            $response = [
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()->all()
            ];
            return response()->json($response, 400);
        }

        $id = Auth::user()->id;
        User::find($id)->update([
            'password' => bcrypt($request->new_password),
        ]);

        return response()->json([
            'status' => true,
            'user_id' => $id,
            'message' => 'password updated Successfully'
        ],200);
    }


    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
