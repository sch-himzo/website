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
        '' => 1
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
}
