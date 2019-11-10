<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    private $pek_roles = [
        'tag' => 3,
        'gazdaságis' => 4,
        'körvezető' => 5,
        'volt körvezető' => 2,
        'volt gazdaságis' => 2,
        'pulcsirészlegvezető' => 2,
        'próbás' => 2,
        '' => 1,
        'újonc' => 1
    ];

    public function authSchRedirect(Request $request)
    {
        $auth_sch_id = env('AUTH_SCH_ID');
        $auth_sch_key = env('AUTH_SCH_KEY');
        $ip = md5($request->ip());
        $redirect_uri = env('APP_URL') . "/auth/callback";

        $scope = [
            'basic',
            'displayName',
            'sn',
            'givenName',
            'mail',
            'eduPersonEntitlement '
        ];

        $new_scope = "";

        foreach($scope as $scope_part) {
            $new_scope .= $scope_part . "+";
        }

        $url = "https://auth.sch.bme.hu/site/login?client_id=" . $auth_sch_id . "&redirect_uri=" . $redirect_uri
            . "&scope=" . $new_scope . "&response_type=code&state=" . $ip;

        return redirect($url);
    }

    public function authSchCallback(Request $request)
    {
        $code = $request->get('code');

        $auth_sch_id = env('AUTH_SCH_ID');
        $auth_sch_key = env('AUTH_SCH_KEY');

        $url = "https://auth.sch.bme.hu/oauth2/token";
        $post_fields = "grant_type=authorization_code&code=$code";

        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl,CURLOPT_USERPWD,"$auth_sch_id:$auth_sch_key");
        curl_setopt($curl,CURLOPT_POST,1);
        curl_setopt($curl, CURLOPT_POSTFIELDS,$post_fields);
        $result = curl_exec($curl);

        curl_close($curl);

        $result = json_decode($result);

        if(isset($result->access_token)){
            $access_token = $result->access_token;
        }else{
            abort(400);
        }

        $url = "https://auth.sch.bme.hu/api/profile?access_token=$access_token";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($result);

        foreach($result->eduPersonEntitlement as $group){
            if($group->name == "Pulcsi és Foltmékör"){
                $himzo = $group;
            }
        }

        if(isset($himzo)){
            if($himzo->status=="tag"){
                $title = $himzo->title[0];
            }else{
                $title = "";
            }
        }else{
            $title = '';
        }

        $user = User::where('email',$result->mail)->get();
        if($user->isEmpty()) {
            $user = new User();

            $user->name = $result->displayName;
            $user->email = $result->mail;
            $user->internal_id = $result->internal_id;
            $user->role_id = $this->pek_roles[$title];

            $user->save();
        }elseif($user->first()->internal_id==null){
            $user = $user->first();
            $user->internal_id = $result->internal_id;
            $user->name = $result->displayName;
            $user->surname = $result->sn;
            $user->role_id = $this->pek_roles[$title];
            $user->given_names = $result->givenName;
            $user->save();
        }else{
            $user = $user->first();
            $user->role_id = $this->pek_roles[$title];
            $user->save();
        }

        Auth::loginUsingId($user->id);

        return redirect()->intended('');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        Auth::attempt(['email' => $email, 'password' => $password]);

        return redirect()->intended('');
    }

    public function logout(Request $request)
    {
        if(Auth::check()){
            Auth::logout();
        }

        return redirect()->back();
    }

    public function facebookCallback(Request $request)
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookRedirect(Request $request)
    {
        dd($request);
    }

    public function register(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $password2 = $request->input('password2');
        $name = $request->input('name');

        if($name == null || $password == null || $password2 == null || $email == null){
            abort(400);
        }

        if(!$this->checkPassword($password)->getData()->password=="ok"){
            abort(400);
        }

        if(!$this->checkEmail($email)->getData()->success==true){
            abort(400);
        }

        if($password != $password2){
            abort(400);
        }

        $user = new User();
        $user->password = bcrypt($password);
        $user->email = $email;
        $user->name = $name;
        $user->role_id = 1;

        $user->save();

        Auth::loginUsingId($user->id);

        return redirect()->back();
    }

    public function email(Request $request){
        return $this->checkEmail($request->input('email'));
    }

    public function checkEmail($email)
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $user = User::where('email',$email)->first();
            if($user==null){
                return response()->json(['success' => true]);
            }else{
                return response()->json(['success' => false,'kaki' => true]);
            }
        }else{
            return response()->json(['success' => false,'kaki' => false,'email' => $email]);
        }
    }

    public function password(Request $request)
    {
        return $this->checkPassword($request->input('password'));
    }

    public function checkPassword($original_password)
    {
        $password = $original_password;

        $characters = ['#','&','@','{','}','<','>',';',':','.',',','$','[',']','\\','|','÷','×','~','^','˘','°','`','˙','´'];

        $special_characters = 0;

        foreach($characters as $character){
            $special_characters += substr_count($password,$character);
        }

        $capital_letters = strlen(preg_replace('![^A-Z]+!','',$password));
        $password = $original_password;
        $numbers = strlen(preg_replace('![^0-9]+!','',$password));
        $password = $original_password;

        $length = strlen($password);

        if($numbers>2){
            if($length<8 && $capital_letters<1 && $special_characters<1){
                return response()->json(['password' => 'nok', 'reason' => ['length','capitals','specials']]);
            }elseif($length>=8 && $capital_letters<1 && $special_characters<1){
                return response()->json(['password' => 'nok', 'reason' => ['capitals','specials']]);
            }elseif($length<8 && $capital_letters>0 && $special_characters<1){
                return response()->json(['password' => 'nok', 'reason' => ['length','specials']]);
            }elseif($length>=8 && $capital_letters>0 && $special_characters<1){
                return response()->json(['password' => 'nok', 'reason' => ['specials']]);
            }elseif($length<8 && $capital_letters<1 && $special_characters>0){
                return response()->json(['password' => 'nok', 'reason' => ['length','capitals']]);
            }elseif($length>=8 && $capital_letters<1 && $special_characters>0){
                return response()->json(['password' => 'nok', 'reason' => ['capitals']]);
            }elseif($length<8 && $capital_letters>0 && $special_characters>0){
                return response()->json(['password' => 'nok', 'reason' => ['length']]);
            }elseif($length>=8 && $capital_letters>0 && $special_characters>0){
                return response()->json(['password' => 'ok', 'reason' => []]);
            }else{
                return response()->json(['success' => 'false']);
            }
        }else{
            if($length<8 && $capital_letters<1 && $special_characters<1){
                return response()->json(['password' => 'nok', 'reason' => ['number','length','capitals','specials']]);
            }elseif($length>=8 && $capital_letters<1 && $special_characters<1){
                return response()->json(['password' => 'nok', 'reason' => ['number','capitals','specials']]);
            }elseif($length<8 && $capital_letters>0 && $special_characters<1){
                return response()->json(['password' => 'nok', 'reason' => ['number','length','specials']]);
            }elseif($length>=8 && $capital_letters>0 && $special_characters<1){
                return response()->json(['password' => 'nok', 'reason' => ['number','specials']]);
            }elseif($length<8 && $capital_letters<1 && $special_characters>0){
                return response()->json(['password' => 'nok', 'reason' => ['number','length','capitals']]);
            }elseif($length>=8 && $capital_letters<1 && $special_characters>0){
                return response()->json(['password' => 'nok', 'reason' => ['number','capitals']]);
            }elseif($length<8 && $capital_letters>0 && $special_characters>0){
                return response()->json(['password' => 'nok', 'reason' => ['number','length']]);
            }elseif($length>=8 && $capital_letters>0 && $special_characters>0){
                return response()->json(['password' => 'nok', 'reason' => ['number']]);
            }else{
                return response()->json(['success' => 'false']);
            }
        }

    }
}
