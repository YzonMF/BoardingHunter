<?php

namespace App\Http\Controllers;

use App\Models\CommunityPost;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * A simple community board: anyone can read, signed-in users can post,
 * authors edit/delete their own posts and admins can remove any post.
 */
class CommunityController extends Controller
{
    public function index(Request $request)
    {
        $posts = CommunityPost::with('author')
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = '%' . $request->input('q') . '%';
                $query->where(fn ($q) => $q->where('Title', 'like', $term)->orWhere('Content', 'like', $term));
            })
            ->orderByDesc('PostDate')
            ->orderByDesc('PostID')
            ->paginate(Setting::int('posts_per_page', 10, 5, 50))
            ->withQueryString();

        return view('community.commindex', compact('posts'));
    }

    public function show(CommunityPost $post)
    {
        $post->load('author');

        return view('community.show', compact('post'));
    }

    public function create()
    {
        return view('community.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $post = CommunityPost::create($data + ['UserID' => Auth::id(), 'PostDate' => now()]);

        return redirect()->route('community.show', $post->PostID)->with('success', 'Post published.');
    }

    public function edit(CommunityPost $post)
    {
        $this->authorizeAuthor($post);

        return view('community.edit', compact('post'));
    }

    public function update(Request $request, CommunityPost $post)
    {
        $this->authorizeAuthor($post);

        $post->update($request->validate($this->rules()));

        return redirect()->route('community.show', $post->PostID)->with('success', 'Post updated.');
    }

    public function destroy(CommunityPost $post)
    {
        abort_unless(Auth::id() === $post->UserID || Auth::user()->role === 'admin', 403);

        $post->delete();

        return redirect()->route('community.index')->with('success', 'Post deleted.');
    }

    private function rules(): array
    {
        return [
            'Title' => 'required|string|max:150',
            'Content' => 'required|string|max:5000',
        ];
    }

    private function authorizeAuthor(CommunityPost $post): void
    {
        abort_unless(Auth::id() === $post->UserID, 403);
    }
}
