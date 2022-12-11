<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Response;
use Flash;

class GeneralController extends Controller
{

	function __construct()
	{
	}
    function home(){
    }
    function cache(){
        Artisan::call('cache:clear');
        return redirect('/');
    }


}