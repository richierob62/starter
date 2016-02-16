<?php

// ===============================================================================================
// AUTH
// ...............................................................................................

// create routes and views for login, registration, and password reset
php artisan make:auth

$request->user()
Auth::check()
Auth::attempt(['email' => $email, 'password' => $password, 'active' => 1], $remember)
Auth::once($credentials)
Auth::logout();
Auth::viaRemember()
Auth::login($user);
Auth::loginUsingId(1);
Auth::onceBasic()
$user = auth()->user();

// ===============================================================================================
// POLICY
// ...............................................................................................

php artisan make:policy PostPolicy

in AuthServiceProvider
protected $policies = [
    Post::class => PostPolicy::class,
];

in Policy class
public function before($user, $ability)
{
    if ($user->isSuperAdmin()) {
        return true;
    }
}
public function update(User $user, Post $post)
{
    return $user->id === $post->user_id;
}

call using:
Gate::denies('update', $post) etc
$user->can('update', $post) etc
policy($post)->update($user, $post) etc
$this->authorize('update', $post) in controller in try-catch block
$this->authorizeForUser($user, 'update', $post); in controller in try-catch block

// ===============================================================================================
// MIDDLEWARE
// ...............................................................................................

php artisan make:middleware SomeMiddleware // creates app/Http/Middleware/SomeMiddleware

In middleware itself:
    public function handle($request, Closure $next, $myValue)
    {
        if (someBooleanCheck) {
            return redirect('home');
        }
        return $next($request);
    }
    // Perform action after passing on request
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        // some stuff
        return $response;
    }
    // define the middleware as "terminable" by adding a terminate method to the middleware
    public function terminate($request, $response)
    {

    }

}

In controller constructor:
    $this->middleware('auth');
    $this->middleware('log', ['only' => ['fooAction', 'barAction']]);
    $this->middleware('subscribed', ['except' => ['fooAction', 'barAction']]);

In App\Http\Kernel.php:
    protected $middlewareGroups = [
        'api' => [
            'throttle:60,1',
            'auth:api'
        ],
    ];
    protected $middleware = [
        \namespace\SomeMiddleware::class,
    ];
    protected $routeMiddleware = [
        'some_name' => \namespace\SomeMiddleware::class,
    ];


In route group:
Route::group(
    [
        'middleware' => ['api:someParam'],
    ],
    function () {...}
);


// ===============================================================================================
// GATE
// ...............................................................................................


within boot of service provider:
    $gate->before(function ($user, $ability) {
        if ($user->isSuperAdmin()) {
            return true;
        }
    });
    $gate->define('update-post', function ($user, $post, $otherParam) {
        return boolean;
    });
    $gate->define('update-post', 'Class@method');
    $gate->after(function ($user, $ability, $result, $arguments) {
        //
    });


In controller or Request class, current user implied:
    use Gate;
    if (Gate::denies('update-post', $post)) {
        abort(403);
    }
    if (!Gate::allows('update-post', [$post, $otherParam])) {
        abort(403);
    }
    // for other user
    if (Gate::forUser($user)->allows('update-post', $post)) {
        //
    }


In controller:
    if ($request->user()->cannot('update-post', $post)) {
        abort(403);
    }
    if ($request->user()->can('update-post', $post)) {
        //
    }


// ===============================================================================================
// ROUTES
// ...............................................................................................

Route::group(
    [
        'as' => 'api::', // route name prefix
        'prefix' => 'api', // url prefix
        'namespace' => 'Api', // only controllers in App\Http\Controllers\Api namespace
        'domain' => '{account}.myapp.com'
    ],
    function () {
        Route::get('user/profile/{id}', 'UserController@showProfile')->name('profile');
        Route::get('user/profile/{optionalParam?}', 'UserController@showProfile')->name('profile');
    }
);

// if closures not used
php artisan route:cache

// ===============================================================================================

class VerifyCsrfToken extends BaseVerifier
{
    /** The URIs that should be excluded from CSRF verification.  */
    protected $except = [
        'stripe/*',
    ];
}


// ===============================================================================================

php artisan make:controller PhotoController

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{

    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function store(Request $request, $someRouteParameter)
    {
        // requests
        $input = $request->all();
        $input = $request->except(['credit_card']);
        $input = $request->except('credit_card');
        $input = $request->only(['username', 'password']);
        $input = $request->only('username', 'password');
        $method = $request->method();
        $name = $request->input('name');
        $name = $request->input('name', 'Sally');
        $name = $request->name;
        $request->ajax();
        $request->flash();
        $request->flashExcept('password');
        $request->flashOnly('username', 'email');
        $request->has('name')
        $request->hasCookie('name');
        $request->ip();
        $request->is('admin/*')
        $request->isJson();
        $request->isMethod('post')
        $request->json('key', $default)
        $request->session();
        $request->wantsJson();
        $uri = $request->path();
        $url = $request->url();
        $user = $request->user();
        $username = $request->old('username');
        $value = $request->cookie('name');


        // file
        $file = $request->file('photo')
        $request->hasFile('photo')
        $request->file('photo')->isValid()
        $request->file('photo')->move($destinationPath);
        $request->file('photo')->move($destinationPath, $fileName);
        more at Symfony\Component\HttpFoundation\File\UploadedFile

        // redirect
        back()->withInput();
        redirect()->route('login');
        redirect()->route('profile', [$model]);
        redirect()->route('profile', [1]);
        redirect('form')->withInput($request->except('password'));
        redirect('form')->withInput();
        redirect()->action('HomeController@index');
        redirect()->action('UserController@profile', [1]);
        redirect('dashboard')->with('status', 'Profile updated!')


        // response
        $response = new Illuminate\Http\Response('Hello World');
        $response->withCookie(cookie()->forever('name', 'value'));
        $response->withCookie(cookie('name', 'value', $minutes));
        response($content, $status)->header('Content-Type', $value);
        response()->view('hello', $data)->header('Content-Type', $type);
        response()->json(['name' => 'Abigail', 'state' => 'CA']);
        response()->json(['name' => 'Abigail', 'state' => 'CA'])->setCallback($request->input('callback'))
        response()->download($pathToFile, $name, $headers);

        // view
        view('greeting', ['name' => 'James']);
        view('admin.profile', $data);
        view()->exists('emails.customer')
        view('greeting')->with('name', 'Victoria');

        // route
        $route = Route::current();
        $name = $route->getName();
        $actionName = $route->getActionName();
        $name = Route::currentRouteName();
        $action = Route::currentRouteAction();

    }

}

// ===============================================================================================

artisan commands

// config
app:name Set the application namespace
config:cache Create a cache file for faster configuration loading
down Put the application into maintenance mode
key:generate Set the application key
optimize Optimize the framework for better performance
up Bring the application out of maintenance mode


// clean up
auth:clear-resets Flush expired password reset tokens
cache:clear Flush the application cache
clear-compiled Remove the compiled class file
config:clear Remove the configuration cache file
view:clear Clear all compiled view files

// database
cache:table Create a migration for the cache database table
db:seed Seed the database with records
make:migration Create a new migration file
make:seeder Create a new seeder class
migrate Run the database migrations
migrate:install Create the migration repository
migrate:refresh Reset and re-run all migrations
migrate:reset Rollback all database migrations
migrate:rollback Rollback the last database migration
migrate:status Show the status of each migration
session:table Create a migration for the session database table


// info
env Display the current framework environment
help Displays help for a command
inspire Display an inspiring quote
list Lists commands
tinker Interact with your application

// events
event:generate Generate the missing events and listeners based on registration
handler:event Create a new event handler class
make:event Create a new event class
make:listener Create a new event listener class

// commands
handler:command Create a new command handler class
make:command Create a new command class
make:console Create a new Artisan command
schedule:run Run the scheduled commands

// controllers
make:controller Create a new resource controller class

// jobs
make:job Create a new job class

// middleware
make:middleware Create a new middleware class

// models
make:model Create a new Eloquent model class

// policies
make:policy Create a new policy class

// service providers
make:provider Create a new service provider class

// requests
make:request Create a new form request class

// tests
make:test Create a new test class

// queues
queue:failed List all of the failed queue jobs
queue:failed-table Create a migration for the failed queue jobs database table
queue:flush Flush all of the failed queue jobs
queue:forget Delete a failed queue job
queue:listen Listen to a given queue
queue:restart Restart queue worker daemons after their current job
queue:retry Retry a failed queue job
queue:subscribe Subscribe a URL to an Iron.io push queue
queue:table Create a migration for the queue jobs database table
queue:work Process the next job on a queue

// routes
route:cache Create a route cache file for faster route registration
route:clear Remove the route cache file
route:list List all registered routes

// server
serve Serve the application on the PHP development server

// dependendencies
vendor:publish Publish any publishable assets from vendor packages


// ===============================================================================================

config/app.php
    'providers' => [
        // Other Service Providers
        App\Providers\AppServiceProvider::class,
    ],

php artisan make:provider RiakServiceProvider

<?php

namespace App\Providers;

use Riak\Connection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\ResponseFactory;

class RiakServiceProvider extends ServiceProvider
{

    protected $defer = true;

    public function register()
    {
        $this->app->singleton('Riak\Contracts\Connection', function ($app) {
            return new Connection(config('riak'));
        });
    }

    public function provides()
    {
        return ['Riak\Contracts\Connection'];
    }

    public function boot(ResponseFactory $factory)
    {
        view()->composer('view', function () {
            //
        });

        $factory->macro('caps', function ($value) {
            //
        });
    }
}

next: http://laravel.com/docs/5.1/container


// ===============================================================================================

$this->belongsTo('App\User');
$this->belongsToMany('App\Role');
$this->belongsToMany('App\Role')->withPivot('column1', 'column2')->withTimestamps();
$this->belongsToMany('App\Role', 'joining_table');
$this->belongsToMany('App\Role', 'joining_table', 'this_table_foreign_key', 'other_table_foreign_key');
$this->hasMany('App\Comment')->orderBy('title');
$this->hasManyThrough('App\FinalTable', 'App\IntermediateTable');
$this->hasManyThrough('App\Post', 'App\User', 'foreign_key_name_on_user_table', 'foreign_key_name_on_post_table');
$this->hasOne('App\Phone');
$this->hasOne('App\Phone', 'foreign_key');
$this->hasOne('App\Phone', 'foreign_key', 'local_key');
in comments or posts: public function likes() { return $this->morphMany('App\Like', 'likeable'); }
in likes: public function likeable() { return $this->morphTo(); }}
in posts or videos: public function tags() { return $this->morphToMany('App\Tag', 'taggable'); }
in tags: public function post or videos() { return $this->morphedByMany('App\Post or Video', 'taggable'); }
likes table has: likeable_id - integer, likeable_type - string

// ===============================================================================================

public function getFirstNameAttribute($value){} // $user->first_name;
public function setFirstNameAttribute($value){ $this->attributes['first_name'] = strtolower($value) } // $user->first_name = 'Sally';
protected $casts = [ 'is_admin' => 'boolean',  ]; // integer, real, float, double, string, boolean, object, array, collection, date and datetime.

// ===============================================================================================

protected $dates = ['created_at', 'updated_at', 'deleted_at'];
$user->deleted_at = Carbon::now();
$user->deleted_at->getTimestamp(); // 'Y-m-d H:i:s'
protected $dateFormat = 'U';

// ===============================================================================================

$collection->load(['author' => function ($query) { $query->orderBy('published_date', 'asc'); }]);
$collection->load('author', 'publisher');}
$model->account()->associate($account);  // account belongs to user
$model->account()->dissociate(); // account belongs to user
$model->comments()->create(['message' => 'A new comment.',]);
$model->comments()->save($comment);
$model->comments()->saveMany([..]);
$model->roles()->attach($roleId); // many to many
$model->roles()->attach($roleId, ['expires' => $expires]); // many to many
$model->roles()->attach([1 => ['expires' => $expires], 2, 3]); // many to many
$model->roles()->detach($roleId); // many to many
$model->roles()->save($role, ['expires' => $expires]);
$model->roles()->sync([1 => ['expires' => true], 2, 3]); // many to many
$model->roles()->sync([1, 2, 3]); // many to many
$model->roles()->updateExistingPivot($roleId, $attributes); // many to many
$model->save();
$model->toArray();
$model->toJson();
$model->whereDate('created_at', date('Y-m-d'));
$model->whereDay('created_at', date('d'));
$model->whereMonth('created_at', date('m'));
$model->whereYear('created_at', date('Y'));
Model::find($customer_id)->decrement('loyalty_points', 10);
Model::find($customer_id)->increment('loyalty_points', 10);
Model::groupBy('category_id')->havingRaw('count(*) > 1')->get();
Model::has('comments')->get(); // comments records exist
Model::has('comments', '>=', 3)->get();
Model::has('comments.votes')->get();
Model::whereHas('comments', function ($query) { $query->where('content', 'like', 'foo%');})->get();
Model::with(['posts' => function ($query) { $query->orderBy('created_at', 'desc'); }])->get();
Model::with(['posts' => function ($query) { $query->where('title', 'like', '%first%');}])->get();
Model::with('author')->get();
Model::with('author', 'publisher')->get();
Model::with('author.contacts')->get();
Model::with('products')->has('products')->get();


public function store() {
    $post = new Post();
    $post->fill(Input::all());
    $post->user_id = Auth::user()->user_id;
    $post->user;
    return $post->save();
}

// ===============================================================================================

DB::transaction(function () {...});
DB::beginTransaction();
DB::rollBack();
DB::commit();

// ===============================================================================================

DB::connection()->getPdo();
DB::connection('foo')->select(...);
DB::delete('delete from users');
DB::insert('insert into users (id, name) values (?, ?)', [1, 'Dayle']);
DB::select('select * from users where active = ?', [1]);
DB::select('select * from users where id = :id', ['id' => 1]);
DB::statement('drop table users');
DB::table('orders')->avg('price');
DB::table('orders')->max('price');
DB::table('orders')->min('price');
DB::table('orders')->select('department', DB::raw('SUM(price) as total_sales'))->groupBy('department')->havingRaw('SUM(price) > 2500')->get();
DB::table('orders')->sum('price');
DB::table('roles')->lists('title');
DB::table('roles')->lists('title', 'field_to_use_as_key');
DB::table('users')->chunk(100, function($users) {... return false;});
DB::table('users')->chunk(100, function($users) {...});
DB::table('users')->count();
DB::table('users')->decrement('votes');
DB::table('users')->decrement('votes', 5);
DB::table('users')->distinct()->get();
DB::table('users')->get();  //  returns an array of StdClass objects
DB::table('users')->groupBy('account_id')->having('account_id', '>', 100)->get();
DB::table('users')->groupBy('status')->get()
DB::table('users')->increment('votes');
DB::table('users')->increment('votes', 1, ['name' => 'John']);
DB::table('users')->increment('votes', 5);
DB::table('users')->insert( [['email' => 'john@example.com', 'votes' => 0], ...] );
DB::table('users')->insertGetId(['email' => 'john@example.com', 'votes' => 0]);
DB::table('users')->join('contacts', function ($join) { $join->on('users.id', '=', 'contacts.user_id')->orOn(...); })->get();
DB::table('users')->join('contacts', function ($join) { $join->on('users.id', '=', 'contacts.user_id')->where('contacts.user_id', '>', 5);})->get();
DB::table('users')->join('contacts', 'users.id', '=', 'contacts.user_id')->get()
DB::table('users')->leftJoin('posts', 'users.id', '=', 'posts.user_id')->get()
DB::table('users')->orderBy('name', 'desc')->get();
DB::table('users')->select(DB::raw('count(*) as user_count, status'))->get()
DB::table('users')->select('name')->addSelect('age')->get();
DB::table('users')->select('name', 'email as user_email')->get();
DB::table('users')->skip(10)->take(5)->get();
DB::table('users')->truncate();
DB::table('users')->where([ ['status','1'],  ['subscribed','<>','1'], ])->get();
DB::table('users')->where('id', 1)->update(['votes' => 1]);
DB::table('users')->where('name', 'John')->first();
DB::table('users')->where('name', 'John')->value('email');
DB::table('users')->where('votes', '<', 100)->delete();
DB::table('users')->where('votes', '>', 100)->lockForUpdate()->get();
DB::table('users')->where('votes', '>', 100)->orWhere('name', 'John')->get();
DB::table('users')->where('votes', '>', 100)->sharedLock()->get();
DB::table('users')->where('votes', '>=', 100)->get();
DB::table('users')->whereBetween('votes', [1, 100])->get();
DB::table('users')->whereExists(function ($query) { $query->select(DB::raw(1))->from('orders')->whereRaw('orders.user_id = users.id');})->get();
DB::table('users')->whereIn('id', [1, 2, 3])->get();
DB::table('users')->whereNotBetween('votes', [1, 100])->get();
DB::table('users')->whereNotIn('id', [1, 2, 3])->get();
DB::table('users')->whereNotNull('updated_at')->get();
DB::table('users')->whereNull('first_name');
DB::table('users')->whereNull('last_name')->union($first_query)->get();
DB::table('users')->whereNull('updated_at')->get();
DB::update('update users set votes = 100 where name = ?', ['John']);

in AppServiceProvider boot()...
DB::listen(function($query) {
    // $query->sql
    // $query->bindings
    // $query->time
});

// ===============================================================================================

$collection = collect(['taylor', 'abigail', null])
$collection = new Collection($my_array);
$collection->all();
$collection->avg();
$collection->avg('pages');
$collection->chunk(4);
$collection->collapse(); // returns base collection
$collection->contains('Desk');
$collection->contains(function ($key, $value) {...});
$collection->contains('product', 'Bookcase');
$collection->count();
$collection->diff([2, 4, 6, 8]);
$collection->each(function ($item, $key) {...});
$collection->every(4);
$collection->except(['price', 'discount']);
$collection->filter( function($item) {..})
$collection->first();
$collection->first(function ($key, $value) {...});
$collection->flatten(); // returns base collection
$collection->flip(); // returns base collection
$collection->forget('name');
$collection->forPage(2, 3);
$collection->get('email', function () {...});
$collection->get('foo', 'default-value');
$collection->get('name');
$collection->groupBy('account_id');
$collection->groupBy(function ($item, $key) {...});
$collection->has('email');
$collection->implode('product', ', ');
$collection->intersect(['Desk', 'Chair', 'Bookcase']);
$collection->isEmpty();
$collection->keyBy(function ($item) {...});
$collection->keyBy('product_id');
$collection->keys(); // returns base collection
$collection->last();
$collection->last(function ($key, $value) {...});
$collection->map(function ($name) {..})
$collection->max('foo');
$collection->merge(['price' => 100, 'discount' => false]);
$collection->min('foo');
$collection->only(['product_id', 'name']);
$collection->pluck('name'); // returns base collection
$collection->pluck('name', 'value_for_key');  // returns base collection
$collection->pop();
$collection->prepend(0);
$collection->prepend(0, 'zero');
$collection->pull('name');
$collection->push($array_key_vals);
$collection->put('price', 100);
$collection->random();
$collection->random(3);
$collection->reduce(function ($carry, $item) {...}, 4);
$collection->reject(function ($name) {..})
$collection->reverse();
$collection->search(function ($item, $key) {...});
$collection->shift();
$collection->shuffle();
$collection->slice(4, 2);
$collection->slice(4, 2, true);
$collection->sort();
$collection->sortBy(function ($product, $key) {...});
$collection->sortBy('price');
$collection->sortByDesc('price');
$collection->splice(2, 1);
$collection->splice(2, 1, [10, 11]);
$collection->sum();
$collection->sum(function ($product) {...});
$collection->sum('pages')
$collection->take(-2);
$collection->take(3);
$collection->toArray();
$collection->toJson();
$collection->transform(function ($item, $key) {...});
$collection->unique('brand');
$collection->unique(function ($item) {...});
$collection->values();
$collection->where('price', 100);
$collection->whereIn('price', [150, 200]);
$collection->zip([100, 200]); // returns base collection

// ===============================================================================================

in EventServiceProvider
protected $listen = [
    'App\Events\PodcastWasPurchased' => [
        'App\Listeners\EmailPurchaseConfirmation',
    ],
];

then run php artisan event:generate
generates events and listeners listed above

in listener...
class EmailPurchaseConfirmation implements ShouldQueue {
    public function handle(PodcastWasPurchased $event)
    {
        return false to stop propogation
    }
}

to fire...
Event::fire(new PodcastWasPurchased($podcast));
event(new PodcastWasPurchased($podcast));

to broadcast to websockets
listener must be queued
require:
    Redis: predis/predis ~1.0

class ServerCreated extends Event implements ShouldBroadcast
{
    public properties will be shared in payload
    public function broadcastAs()
    {
        return 'custom name of event to broadcast';
    }
    public function broadcastOn()
    {
        return [name of channel to broadcast on];
    }
    or restrict with...
    public function broadcastWith()
    {
        return ['user' => $this->user->id];
    }
}

consuming the broadcast...
var app = require('http').createServer(handler);
var io = require('socket.io')(app);
var Redis = require('ioredis');
var redis = new Redis();

app.listen(6001, function() {
    console.log('Server is running!');
});

function handler(req, res) {
    res.writeHead(200);
    res.end('');
}

io.on('connection', function(socket) {
    //
});

redis.psubscribe('*', function(err, count) {
    //
});

redis.on('pmessage', function(subscribed, channel, message) {
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});

subscribe to event...


// ===============================================================================================

Hash::make($request->newPassword)
bcrypt('plain-text');
Hash::check('plain-text', $hashedPassword)
Hash::needsRehash($hashed)


// ===============================================================================================

array_add(['name' => 'Desk'], 'price', 100); // ['name' => 'Desk', 'price' => 100]
array_collapse([[1, 2, 3], [4, 5, 6], [7, 8, 9]]); // [1, 2, 3, 4, 5, 6, 7, 8, 9]
array_divide(['name' => 'Desk']);  // $keys: ['name']  $values: ['Desk']
array_dot(['foo' => ['bar' => 'baz']]); // ['foo.bar' => 'baz'];
array_except( ['name' => 'Desk', 'price' => 100] , ['price']); // ['name' => 'Desk']
array_first([100, 200, 300], function ($key, $value) { return $value >= 150; }); // 200
array_flatten(['name' => 'Joe', 'languages' => ['PHP', 'Ruby']]);  // ['Joe', 'PHP', 'Ruby'];
array_forget(['products' => ['desk' => ['price' => 100]]], 'products.desk'); // ['products' => []]
array_get(['products' => ['desk' => ['price' => 100]]], 'products.desk');  // ['price' => 100]
array_has(['products' => ['desk' => ['price' => 100]]], 'products.desk'); // true
array_only(['name' => 'Desk', 'price' => 100, 'orders' => 10], ['name', 'price']); // ['name' => 'Desk', 'price' => 100]
array_pluck($array, 'developer.name'); // ['Taylor', 'Abigail'];
array_pluck($array, 'developer.name', 'developer.id');  // [1 => 'Taylor', 2 => 'Abigail'];
array_prepend($array, 'zero'); // $array: ['zero', 'one', 'two', 'three', 'four']
array_pull($array, 'name');
array_set($array, 'products.desk.price', 200);  // ['products' => ['desk' => ['price' => 200]]]
array_sort()
array_sort($array, function ($value) {return $value['name'];}));
array_sort_recursive($array);
array_where($array, function ($key, $value) {return is_string($value);});
head($array);
last($array);

// ===============================================================================================

app_path();
app_path('Http/Controllers/Controller.php');
base_path();
base_path('vendor/bin');
config_path();
database_path();
public_path();
storage_path();
storage_path('app/file.txt');

// ===============================================================================================

camel_case('foo_bar');
class_basename('Foo\Bar\Baz');
e('<html>foo</html>'); // &lt;html&gt;foo&lt;/html&gt;
ends_with('This is my name', 'name');
snake_case('fooBar');
str_limit('The PHP framework for web artisans.', 7);
starts_with('This is my name', 'This'); // true
str_contains('This is my name', 'my');
str_finish('this/string', '/'); // this/string/
str_is('foo*', 'foobar'); // true
str_plural('car');
str_plural('child', 2); // children
str_plural('child', 1); // child
str_random(40);
str_singular('cars');
str_slug("Laravel 5 Framework", "-");
studly_case('foo_bar'); // FooBar
trans('validation.required'):
trans_choice('foo.bar', $count);

// ===============================================================================================

$url = action('HomeController@getIndex');
$url = action('UserController@profile', ['id' => 1]);
$url = asset('img/photo.jpg');
secure_asset('foo/bar.zip', $title, $attributes = []);
$url = route('routeName');
$url = route('routeName', ['id' => 1]);
url('user/profile');
url('user/profile', [1]);
url()->current();
url()->full();
url()->previous();

// ===============================================================================================

$user = auth()->user();
back()
bcrypt('my-secret-password');
config('app.timezone');
config('app.timezone', $default);
config(['app.debug' => true]);
csrf_field()
csrf_token()
dd()
dispatch()
dispatch(new App\Jobs\SendEmails);
env('APP_ENV');
env('APP_ENV', 'production');
event(new UserRegistered($user));
factory(App\User::class)->make();
old('value');
redirect('/home');
request('key', $default = null)
response('Hello World', 200, $headers);
response()->json(['foo' => 'bar'], 200, $headers);
session('key');
session(['chairs' => 7, 'instruments' => 3]);
session()->get('key');
session()->put('key', $value);
value(function() { return 'bar'; });
view('auth.login');
with(new Foo)->work();


// ===============================================================================================

$users = DB::table('users')->paginate(per_page);
$users = DB::table('users')->simplePaginate(per_page);
$users = App\User::paginate(per_page);
$users = User::where('votes', '>', 100)->paginate(per_page);
$users = User::where('votes', '>', 100)->simplePaginate(per_page);
{
   "total": 50,
   "per_page": 15,
   "current_page": 1,
   "last_page": 4,
   "next_page_url": "http://laravel.app?page=2",
   "prev_page_url": null,
   "from": 1,
   "to": 15,
   "data":[
        {
            // Result Object
        },
        {
            // Result Object
        }
   ]
}

// ===============================================================================================

// automatic
$this->validate($request, [ $rules ]);
$this->validate($request, ['title' => 'bail|required|unique:posts|max:255','body' => 'required',]);
$this->validate($request, ['author.name' => 'required', 'author.description' => 'required',]);

// manual
$messages = ['required' => 'The :attribute field is required.',];
$messages = ['email.required' => 'We need to know your e-mail address!',];
$validator = Validator::make($request->all(), ['person.*.email' => 'email|unique:users'], $messages);
$validator->fails()
$validator->errors()->add('field', 'Something is wrong with this field!');
$validator->errors()->first('email');
$validator->errors()->get('email')
$validator->errors()->all()
$validator->errors()->has('email')
$validator->sometimes('reason', 'required|max:500', function($input) {return $input->games >= 100;}); // conditional check
$validator->sometimes(['reason', 'cost'], 'required', function($input) {return $input->games >= 100;});

// automatic
php artisan make:request StoreBlogPostRequest
public function rules()
public function authorize()
{
    $commentId = $this->route('comment');
    return Comment::where('id', $commentId)->where('user_id', Auth::id())->exists();
}
public function store(StoreBlogPostRequest $request)

// rules
accepted // yes, on, 1, or true.
active_url
after:tomorrow
after:start_date
alpha
alpha_dash
alpha_num
array
before:date
between:min,max
boolean // true, false, 1, 0, "1", and "0".
confirmed // *_confirmation field must be present
date
date_format:format // either date or this
different:field
digits:value
digits_between:min,max
email
exists:table,column,where_field,value
exists:table,column,where_field,!value
image // jpeg, png, bmp, gif, or svg
in:foo,bar,...
integer
ip
json
max:value
mimes:foo,bar,... // 'mimes:jpeg,bmp,png'
min:value
not_in:foo,bar,...
numeric
regex:pattern
required
required_if:anotherfield,value,...
required_unless:anotherfield,value,...
required_with:foo,bar,... // any of
required_with_all:foo,bar,... // all of
required_without:foo,bar,...
required_without_all:foo,bar,...
same:field
size:value // num characters, int value, fiel size
'sometimes|required|email', // only if present
string
timezone
unique:table,column,except,idColumn
'unique:users,email_address'
'unique:connection.users,email_address'
'unique:users,email_address,'.$user->id
'unique:users,email_address,'.$user->id.',user_id'
'unique:users,email_address,NULL,id,account_id,1' // account_id of 1 would be included in the unique check.
url

// ===============================================================================================

Person::find([1]);
Person::find([1,2,3]);

class User extends Model
{
    protected $appends = ['full_name'];
    protected $hidden = ['password'];
    protected $visible = ['first_name', 'last_name'];

    public function getFullNameAttribute() {
        return $this->first_name . ' ' . $this->last_name;
    }
}
$employees = Employee::where('branch_id', 9)->get()->lists('full_name', 'id')


$link->users()->orderBy('link_user.some_pivot_field', 'desc')->take(10)->get();
$model->makeVisible('attribute')->toArray();

// ===============================================================================================

$url = route('profile', ['id' => 1]);
$url = action('FooController@method');

$redirect = redirect()->route('profile');

$action = Route::currentRouteAction();

<?php echo csrf_field(); ?>
<meta name="csrf-token" content="{{ csrf_token() }}">
$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});

// ===============================================================================================

https://laravel.com/docs/5.2/billing
https://laravel.com/docs/5.2/cache
https://laravel.com/docs/5.2/mail
https://laravel.com/docs/5.2/queues
https://laravel.com/docs/5.2/redis
https://laravel.com/docs/5.2/session

