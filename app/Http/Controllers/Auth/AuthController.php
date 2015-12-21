<?php

namespace lexpoint\Http\Controllers\Auth;

use lexpoint\User;
use Validator;
use lexpoint\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Contracts\Mail\MailQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    protected $redirectPath = '/';

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {

	$user=new User;
        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
	$user->activationCode=str_random(128);
	$user->save();
	return $user;
    }


    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);
	$credentials['isActive']=1;

        if (Auth::attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Contracts\Mail\MailQueue $mailer
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request, MailQueue $mailer)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

// не будем сразу авторизовывать
//        Auth::login($this->create($request->all()));

// создадим пользователя, запишем в базу с кодом подтверждения в create()
	$user = $this->create($request->all());
	
//генерируем URL подтверждения  
        $url = action('Auth\AuthController@getConfirm', [ $user->activationCode ]); 

//ставим письмо в очередь на отправку
        $mailer->queue('emails.confirm', compact('url', 'user'), function ($message) use ($user, $url) 
        {
            $message->to($user->email)->subject(trans('user.registration_confirmation'));
        });


//        return redirect($this->redirectPath());
	return view('message')->withMessage('user.register_complete');
    }

    /**
     * Подтверждение регистрации пользователем
     *
     * @param Request     $request
     * @param User        $user
     * @param string|null $token
     *
     * @return Response
     */
    public function getConfirm(Request $request, User $user, $token = null)
    { 
        if (is_null($token)) {
		throw new NotFoundHttpException;
        }

       //находим в БД пользователя 
       $user = $user->where('activationCode','=',$token)->first();  
       //если не найден:
        if (!$user) {
            return view('message')->withMessage('user.invalid_activate_link');
        }
       //если уже подтвержден
        if ($user->isActive) {
            return view('message')->withMessage('user.account_already_activated');
        }
        //поднимаем флаг пользователь подтвержден
        $user->isActive = true;
       //записываем в БД
        $user->save();

	Auth::login($user);
      
        return redirect($this->redirectPath());
    }

}
