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
        }
    }
</script>

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
            <option selected>Choose...</option>
            <option value="1">Power</option>
            <option value="2">Computer</option>
            <option value="3">Tech</option>
        </select>
    </div>
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
        @endif
    </tbody>
</table>

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
            <option selected>Choose...</option>
            <option value="1">Power</option>
            <option value="2">Computer</option>
            <option value="3">Tech</option>
        </select>
    </div>
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
    }
}
