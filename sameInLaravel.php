<<<<<<< HEAD
<h1 class="text-center">LOGIN</h1>
<style>
    .error {
        background-color: #FF0000;
        ;
    }

    .success {
        background-color: #04AA6D;
    }

    .success,
    .error {
        padding: 20px;
        color: white;
        opacity: 1;
        transition: opacity 0.6s;
        text-align: center;
    }

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }
</style>
@if(session('flash'))
<div class="error">
    <span class="closebtn">&times;</span>
    <strong>Error!</strong> Login or Password is Wrong.
</div>
@endif
@if(session('success'))
<div class="success">
    <span class="closebtn">&times;</span>
    <strong>New</strong> User added Sucessfully.
</div>
@endif
<script>
    var close = document.getElementsByClassName("closebtn");
    var i;

    for (i = 0; i < close.length; i++) {
        close[i].onclick = function() {
            var div = this.parentElement;
            div.style.opacity = "0";
            setTimeout(function() {
                div.style.display = "none";
            }, 600);
=======
<?php
/**
 * sameInLaravel.php — Reference: same CRUD in Laravel
 *
 * NOT a runnable script. Shows how PHP CRUD maps to Laravel structure.
 *
 * In a real Laravel project, each section would be a separate file:
 *   resources/views/  → Blade templates (HTML)
 *   routes/web.php    → URL routing
 *   app/Http/Controllers/  → Business logic
 *
 * Key bug fixed from original: delete used WHERE catagory instead of WHERE sno,
 * which deleted ALL posts in a category instead of one.
 */
?>
<!-- =====================================================
VIEW: resources/views/login.blade.php
===================================================== -->
<h1 class="text-center">LOGIN</h1>

<style>
    .error { background-color: #FF0000; }
    .success { background-color: #04AA6D; }
    .error, .success {
        padding: 20px; color: white; opacity: 1;
        transition: opacity 0.6s; text-align: center;
    }
    .closebtn {
        margin-left: 15px; color: white; font-weight: bold;
        float: right; font-size: 22px; cursor: pointer;
    }
    .closebtn:hover { color: black; }
</style>

@if(session('flash'))
<div class="error">
    <span class="closebtn">&times;</span>
    <strong>Error!</strong> {{ session('flash') }}
</div>
@endif

@if(session('success'))
<div class="success">
    <span class="closebtn">&times;</span>
    <strong>Success!</strong> {{ session('success') }}
</div>
@endif

<script>
    var close = document.getElementsByClassName("closebtn");
    for (var i = 0; i < close.length; i++) {
        close[i].onclick = function() {
            var div = this.parentElement;
            div.style.opacity = "0";
            setTimeout(function() { div.style.display = "none"; }, 600);
>>>>>>> master
        }
    }
</script>

<<<<<<< HEAD
<form action="check" method="post">
    @csrf
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">* User Name (Only Alphabets)</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="name" pattern="[A-Za-z]*" required>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">* Password ( Atlest 4 Character )</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="****" minlength="4" required>
    </div>
    <div class="mb-3">
        <label class="form-check-label" for="exampleCheck1">Dont have account? <a href="/signin">Create account</a>
        </label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<h1 class="text-center">posts</h1>
<form class="row row-cols-lg-auto g-3 align-items-center" method="post" action="/search">
    @csrf
    <div class="col-12">
        <label>Select Catagory</label>
    </div>
    <div class="col-12">
        <label class="visually-hidden" for="inlineFormSelectPref">Preference</label>
        <select class="form-select" id="inlineFormSelectPref" name="value">
=======
<form action="{{ route('login.check') }}" method="post">
    @csrf
    <div class="mb-3">
        <label for="username">* User Name (Only Alphabets)</label>
        <input type="text" id="username" name="username" placeholder="name" pattern="[A-Za-z]*" required>
    </div>
    <div class="mb-3">
        <label for="password">* Password (At least 4 Characters)</label>
        <input type="password" id="password" name="password" placeholder="****" minlength="4" required>
    </div>
    <div class="mb-3">
        <label>Don't have an account? <a href="{{ route('signin') }}">Create account</a></label>
    </div>
    <button type="submit">Submit</button>
</form>

<hr>

<!-- VIEW: resources/views/posts.blade.php -->
<h1 class="text-center">Posts</h1>

<form method="post" action="{{ route('posts.search') }}">
    @csrf
    <div>
        <label>Select Category</label>
        <select name="value">
>>>>>>> master
            <option selected>Choose...</option>
            <option value="1">Power</option>
            <option value="2">Computer</option>
            <option value="3">Tech</option>
        </select>
    </div>
<<<<<<< HEAD
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>
<table>
    <thead>
        <tr>
            <th></th>
            <th>sno.</th>
            <th>posts</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($posts))
        <?php $counter = 1; ?>
        @foreach ($posts as $post)
        <tr>
            <td>
                <form method="post" action="delete">
                    @csrf
                    <input type="hidden" name="id" value="{{ $post->sno }}">
                    <button type="submit" name="delete">Delete</button>
                </form>
            </td>
            <th>{{$counter}}</th>
            <td>{{ $post->content }}</td>
        </tr>
        <?php $counter++; ?>
        @endforeach
=======
    <button type="submit">Search</button>
</form>

<table>
    <thead>
        <tr><th></th><th>#</th><th>Post Content</th></tr>
    </thead>
    <tbody>
        @if(isset($posts) && count($posts) > 0)
            @foreach ($posts as $index => $post)
            <tr>
                <td>
                    <form method="post" action="{{ route('posts.delete') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $post->sno }}">
                        <button type="submit" onclick="return confirm('Delete this post?')">Delete</button>
                    </form>
                </td>
                <td>{{ $index + 1 }}</td>
                <td>{{ $post->content }}</td>
            </tr>
            @endforeach
        @else
            <tr><td colspan="3">No posts found.</td></tr>
>>>>>>> master
        @endif
    </tbody>
</table>

<<<<<<< HEAD
<h1 class="text-center">New posts to add</h1>
<form class="row row-cols-lg-auto g-3 align-items-center" method="post" action="/add">
    @csrf
    <div class="col-12">
        <label for="exampleFormControlTextarea1" class="form-label">Content</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" name="content" rows="3"></textarea>
    </div>
    <div class="col-12">
        <label class="visually-hidden" for="inlineFormSelectPref">Preference</label>
        <select class="form-select" id="inlineFormSelectPref" name="value">
=======
<h1 class="text-center">Add New Post</h1>
<form method="post" action="{{ route('posts.add') }}">
    @csrf
    <div>
        <label for="content">Content</label>
        <textarea id="content" name="content" rows="3"></textarea>
    </div>
    <div>
        <label>Category</label>
        <select name="value">
>>>>>>> master
            <option selected>Choose...</option>
            <option value="1">Power</option>
            <option value="2">Computer</option>
            <option value="3">Tech</option>
        </select>
    </div>
<<<<<<< HEAD
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Add</button>
    </div>
</form>

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\postController;

Route::post('/check', [loginController::class, 'datacheck']);
Route::post('/newuser', [loginController::class, 'adduser']);
Route::post('/search', [postController::class, 'search']);
Route::post('/delete', [postController::class, 'delete']);
Route::post('/add', [postController::class, 'add']);

/* login controller */

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class loginController extends Controller
{
    function datacheck()
    {
        $data = request(['username', 'password']); // user enter data
        $users = DB::table('login')->select('name', 'password')->get();

        foreach ($users as $user) {
            $name_value = $user->name;
            $password_value = $user->password;

            if ($data['username'] == $name_value && $data['password'] == $password_value) {
                return redirect('/posts');
            }
        }
        return redirect('/login')->with('flash', 'Invalid credentials');
    }

    function adduser()
    {
        $data = request(['newName', 'newPassword']);
        DB::table('login')->insert([
            'name' => $data['newName'],
            'password' => $data['newPassword']
        ]);
        return redirect('/login')
            ->with('success', 'add Sucessfully');
    }
}

/* post  controller */

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class postController extends Controller
{
    function search()
    {
        $data = request()->only('value');
        $posts = DB::table('post')->where('catagory', $data['value'])->get();
        $value = 1;
        return view('posts', ['posts' => $posts, 'data' => $value]);
    }

    function delete()
    {
        $idToDelete = request()->only('id');
        DB::table('post')->where('catagory', $idToDelete['id'])->delete();
        return view('posts');
    }

    function add()
    {
        $data = request(['content', 'value']);
        DB::table('post')->insert([
            'catagory' => $data['value'],
            'content' => $data['content']
        ]);
        return redirect('/posts');
=======
    <button type="submit">Add</button>
</form>


<?php
/**
 * =====================================================
 * ROUTES (routes/web.php)
 * =====================================================
 * Maps URLs to controller methods.
 *
 * Route::post('/login/check', [LoginController::class, 'datacheck'])->name('login.check');
 * Route::post('/signin',      [LoginController::class, 'adduser'])->name('signin');
 * Route::post('/posts/search',[PostController::class, 'search'])->name('posts.search');
 * Route::post('/posts/delete',[PostController::class, 'delete'])->name('posts.delete');
 * Route::post('/posts/add',   [PostController::class, 'add'])->name('posts.add');
 * Route::get('/login',  fn() => view('login'))->name('login');
 * Route::get('/posts',  [PostController::class, 'index'])->name('posts');
 */

return; // Reference only — execution stops here

/**
 * =====================================================
 * CONTROLLERS (app/Http/Controllers/)
 * =====================================================
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function datacheck(Request $request)
    {
        $data = $request->only(['username', 'password']);
        $users = DB::table('login')->select('name', 'password')->get();

        foreach ($users as $user) {
            if ($data['username'] == $user->name && $data['password'] == $user->password) {
                return redirect()->route('posts');
            }
        }
        return redirect()->route('login')->with('flash', 'Invalid credentials');
    }

    public function adduser(Request $request)
    {
        $data = $request->only(['newName', 'newPassword']);
        DB::table('login')->insert([
            'name'     => $data['newName'],
            'password' => $data['newPassword']  // Use bcrypt() in production
        ]);
        return redirect()->route('login')->with('success', 'User added successfully');
    }
}

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = DB::table('post')->get();
        return view('posts', ['posts' => $posts]);
    }

    public function search(Request $request)
    {
        $data = $request->only('value');
        $posts = DB::table('post')->where('catagory', $data['value'])->get();
        return view('posts', ['posts' => $posts]);
    }

    public function delete(Request $request)
    {
        // FIXED: was `where('catagory', ...)` — deleted all posts in a category
        DB::table('post')->where('sno', $request->input('id'))->delete();
        return redirect()->route('posts');
    }

    public function add(Request $request)
    {
        $data = $request->only(['content', 'value']);
        DB::table('post')->insert([
            'catagory' => $data['value'],
            'content'  => $data['content']
        ]);
        return redirect()->route('posts');
>>>>>>> master
    }
}
