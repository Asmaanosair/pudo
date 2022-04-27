<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'reset']]);
    }

    /**
     * Register new user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request){
        $validate = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:4|confirmed',
        ]);
        if ($validate->fails()){
            return response()->json([
                'status' => 'error',
                'errors' => $validate->errors()
            ], 422);
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->status = 'Active';
        $user->save();
        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        if (! $token = auth()->attempt(['email' => $request->email, 'password' => $request->password, 'status' =>"Active"])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    public function reset(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [  //validate inputs
                'phone' => 'required|numeric',
            ]);
            if ($validator->fails()) {  // in case validator failed
                return response()->json(['status' => false, 'message' => 'failed', 'data' => $validator->errors()], 400);
            }
            $fleet = User::where('phone',$request->phone)->first();

            if ($fleet == null) {
                return response()->json(['status' => false, 'message' => 'failed', 'data' => 'phone is wrong'],500);
            }
            $pass=Str::random(10);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.msegat.com/gw/sendsms.php");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, TRUE);

            curl_setopt($ch, CURLOPT_POST, TRUE);

            $fields = <<<EOT
                            {
                              "userName": "pudo",
                              "numbers": $fleet->phone,
                              "userSender": "PUDO",
                              "apiKey": "81996d9f14eec357f3fe63280ac6e47f",
                              "msg": "Your New Password  is : $pass" ,
                              "msgEncoding":"UTF8"
                            }
                            EOT;
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json"
            ));

            $response = curl_exec($ch);
            $info = curl_getinfo($ch);
            curl_close($ch);
            $fleet->password=Hash::make($pass);
            $fleet->save();

            return response()->json(['status' => true,  'message' => 'success','data' => 'successfully Send Your password to your phone']);
        } catch (\Exception  $e) {
            return response()->json([$e->getMessage()], 500);
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
