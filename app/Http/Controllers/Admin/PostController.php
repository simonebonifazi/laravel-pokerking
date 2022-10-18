<?php

namespace App\Http\Controllers\Admin;

//importo modelli
use App\Models\Post;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('updated_at', 'DESC')->orderBy('created_at', 'DESC')->orderBy('title')->paginate(10);

                $categories = Category::all();
        return view('admin.posts.index', compact('posts','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()

    {
        //passo un post vuoto per favorire unificazione form
        $post = new Post();
        $categories = Category::select('id', 'label')->get();
        $tags = Tag::select('id', 'label')->get();

        return view('admin.posts.create' , compact('post', 'categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

         $request->validate([
            'title' => 'required|string|min:1|max:50|unique:posts',
            'content' => 'required|string',
            'image' => 'nullable|url',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|exists:tags,id',
        ],[
            'required' => 'Attenzione, il campo :attribute è obbbligatorio',
            'title.required' => 'Attenzione, compila il campo Titolo per continuare',
            'title.max' => 'Attenzione,il titolo non può avere più di 50 caratteri. Hai già pensato di mettere le informazioni nel contenuto?',
            'title.min' => 'Attenzione, ci dev\'essere un titolo per procedere' ,
            'title.unique' => 'Attenzione, il titolo scelto è già associato ad un altro post',
            'tags.exists' => 'uno dei tag selezionati è non valido',
        ]);

        $post = new Post();

        $post->fill($data);
        //slug   
        $post->slug = Str::slug($post->title , '-');

        $post->user_id = Auth::id(); 
            
        $post->save();
        //se è stato spuntato almeno un checkbox, montalo sul db
        if(array_key_exists('tags', $data))
        {
            $post->tags()->attach($data['tags']);
        }
        
        return redirect()->route('admin.posts.show', $post->id)
        ->with('message', 'Il post è stato creato con successo!')
        ->with('type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::select('id', 'label')->get();
        $tags = Tag::select('id', 'label')->get();
        $tag_ids = $post->tags->pluck('id')->toArray();

        return view('admin.posts.edit', compact('post', 'categories','tags','tag_ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->all();

        $request->validate([
            'title' => ['required','string','min:1','max:50', Rule::unique('posts')->ignore($post->id)],
            'content' => 'required|string',
            'image' => 'nullable|url',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|exists:tags,id',
        ],[
            'required' => 'Attenzione, il campo :attribute è obbbligatorio',
            'title.required' => 'Attenzione, compila il campo Titolo per continuare',
            'title.max' => 'Attenzione,il titolo non può avere più di 50 caratteri. Hai già pensato di mettere le informazioni nel contenuto?',
            'title.min' => 'Attenzione, ci dev\'essere un titolo per procedere' ,
            'title.unique' => 'Attenzione, il titolo scelto è già associato ad un altro post',
            'tags.exists' => 'uno dei tag selezionati è non valido',

        ]);


        //slug in maniera alternativa, non ho ancora post per cui devo prendere il title dalla request
        $data['slug'] = Str::slug($request->title , '-'); // o anche( $data['title'], '-')
        
        $post->update($data);

       if(array_key_exists('tags', $data))
        {
            $post->tags()->sync($data['tags']);
        } else{
            $post->tags()->detach();
        }
        

        return redirect()->route('admin.posts.show', $post)
        ->with('message', 'Il post è stato aggiornato correttamente')
        ->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post )
    {
        //ulteriore controllo sul funzionamento di cascade
       // if(count($post->tags)) $post->tags->detach();

        $post->delete();

        return redirect()->route('admin.posts.index')
        ->with('message', 'Il post è stato eliminato correttamente')
        ->with('type', 'success');
    }
}