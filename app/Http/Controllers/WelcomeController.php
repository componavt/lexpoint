<?php namespace App\Http\Controllers;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
    {
        $monolog = \Log::getMonolog();

        $items = array('items' => ['Pack luggage', 'Go to airport', 'Arrive in San Juan']);

        $monolog->pushHandler(new \Monolog\Handler\FirePHPHandler());
        $monolog->addInfo('Log Message', array('items' => $items));

        // dd( $items );
        //\Log::debug($items);

/*\Debugbar::error('Something is definitely going wrong.');

\Debugbar::info($items);
\Debugbar::error('Error!');
\Debugbar::warning('Watch out…');
\Debugbar::addMessage('Another message', 'mylabel');
  */
        return view('welcome');
	}

}
