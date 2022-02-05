<h1>Laravel 8 JWT Token Authentication</h1>


## Step 1

<p>Install Laravel</p>
<code>composer create-project laravel/laravel example-app</code>
<br>
<p>Database Create and Set Database name to .env file</p>
<p>Migrate to database</p>
<code>php artisan migrate</code>
<p>Create User Seeder and run it through DatabaseSeeder</p>

## Step 2

<p>Install JWT<p>
<code>composer require tymon/jwt-auth</code>
<p>Add service provider<p>
<span>Add the service provider to the providers array in the config/app.php config file as follows: <span>

<code>
'providers' => [

    ...

    Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
]
</code>

<p>Run the following command to publish the package config file:</p>
<code>php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider" </code>
<p>You should now have a config/jwt.php file that allows you to configure the basics of this package.</p>
<p>Generate secret key:</p>
<code>php artisan jwt:secret</code>
<p>This will update your .env file with something like JWT_SECRET=foobar</p>


## Step 3
<p> To use JWT default Middeware auth token check: </p>
<span>Add those code in the app/Http/Kernel.php file as follows: <span>

<code>

protected $routeMiddleware = [

        ...

        'jwt.auth' => Tymon\JWTAuth\Http\Middleware\Authenticate::class,
        'jwt.check' => Tymon\JWTAuth\Http\Middleware\Check::class,
        'jwt.refresh' => Tymon\JWTAuth\Http\Middleware\RefreshToken::class,
        'jwt.renew' => Tymon\JWTAuth\Http\Middleware\AuthenticateAndRenew::class,
        
    ];
</code>


## Setp 3

<p>Edit User Model following below:</p>

<code>
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{

    ...


           /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


}

</code>




## Step 4

<p>To Send JWT Token from Controller</p>

<span>First Add those in namespace </span>

<span> 
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
</span>

<code>
 $user = User::find(Auth::id());

            $customClaims = [
                'foo' => 'bar', 
                'baz' => 'bob'
            ];

            $myTTL = 5; //minute
            
            $payload = JWTFactory::sub($user->id)
                        ->myCustomString('Foo Bar')
                        ->myCustomArray($customClaims)
                        ->myCustomObject($user)
                        ->setTTL($myTTL)
                        ->make();

            $token = JWTAuth::fromUser($user,$payload);
</code>


## Step 4

<p>Protect Middleware or Controller Following below:</p>

<code>

Route::group(['middleware' => 'jwt.auth'], function () {

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard/{token}', [DashboardController::class, 'dashboard'])->name('dashboard');


});

//Controller

public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['login', 'loginCheck']]);
    }
</code>



