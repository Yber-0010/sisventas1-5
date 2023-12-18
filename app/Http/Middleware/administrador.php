<?php

namespace App\Http\Middleware;
use Iluminate\Contrats\Auth\Guard;
use Closure;
use Session;
class administrador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected $auth;
    public function __Construct(Gurard $auth){
        $this->auth=$auth;
    }
    public function handle($request, Closure $next)
    {
        switch ($this->auth->user()->idrol)
        {
            //case '1':return redirect()->to('administrador');
            case '2':return redirect()->to('vendedor');
        }
        return $next($request);
    }
}
