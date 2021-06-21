<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Fakepost;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Fakepost::all();

        $data = [
            'posts' => $posts
        ];

        return view('admin.posts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->getValidationRules());

        $form_data = $request->all();

        // dump($form_data);

        // Calcolo dello slug
        $new_slug = Str::slug($form_data['title'], '-');
        $base_slug = $new_slug;
        // Qua faccio first, perché so che non ci sarà più di un post con lo slug
        // uguale, altrimenti mysql mi da errore
        $post_with_existing_slug = Fakepost::where('slug', '=', $new_slug)->first();
        $counter = 1;

        // Se un post con lo stesso sluf esiste, allo slug viene aggiunto il valore
        // counter
        while($post_with_existing_slug) {
            // Provo con un nuovo slug appendendo il counter
            $new_slug = $base_slug . '-' . $counter;
            $counter++;

            // Se trova un elemento con lo stesso slug nel db lo ritorna, quindi la
            // condizione è sempre vera e il ciclo continua, altrimenti se non lo 
            // trova ritorna null e il ciclo si blocca
            $post_with_existing_slug = Fakepost::where('slug', '=', $new_slug)->first();
        }

        // Quando lo slug è libero allora lo popolo
        $form_data['slug'] = $new_slug;

        $post = new Fakepost();
        $post->fill($form_data);
        $post->save();

        return redirect()->route('admin.posts.show', [
            'post' => $post->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Fakepost::findOrFail($id);

        $data = [
            'post' => $post
        ];

        return view('admin.posts.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Fakepost::findOrFail($id);

        $data = [
            'post' => $post
        ];

        return view('admin.posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->getValidationRules());

        $form_data = $request->all();

        // Il fail non serve perché ci sei già
        $post = Fakepost::find($id);

        // Aggiorno con le nuove informazioni modificate
        $post->update($form_data);

        return redirect()->route('admin.posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Fakepost::find($id);
        $post->delete();

        return redirect()->route('admin.posts.index');
    }

    // Validation rules. Uguale per tutti, più facile
    // da cambiare e gestire
    private function getValidationRules() {
        $validation_rules = [
            'title' => 'required|min:5|max:80',
            'content' => 'required|max:65000',
            'author' => 'required|min:3|max:50'
        ];

        return $validation_rules;
    }
}
