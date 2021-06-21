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
        // Per ritornare i post da vedere abbiamo bisogno di
        // connetterci al MOdel e passarli alla route da visualizzare
        $posts = Fakepost::all();

        // È posts e non post perché l'array con tutti i posts e non il singolo post
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

    // Create reinderizza semplicemente al form di creazion post
    // sarà l'action del form a mandare i dati a 'store'
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
        // Metodi di validazione
        $request->validate($this->getValidationRules());

        // Salvo in una variabile i dati della $request, cioè
        // ciò che è stato inviato col form
        $form_data = $request->all();

        // dump($form_data);

        // Calcolo dello slug
        // Creo lo slug a partire dal title nella $request, quindi in $form_data
        $new_slug = Str::slug($form_data['title'], '-');

        // Salvo $new_slug in una variabile concatenabile successivamente nel ciclo while
        $base_slug = $new_slug;

        // Qua faccio first, perché so che non ci sarà più di un post con lo slug
        // uguale, altrimenti mysql mi da errore
        $post_with_existing_slug = Fakepost::where('slug', '=', $new_slug)->first();

        // Il mio counter per il while loop
        $counter = 1;

        // Se un post con lo stesso slug esiste, allo slug viene aggiunto il valore in counter
        // Fintanto che il post con slug uguale esiste ($post_with_existing_slug) fai il ciclo
        while($post_with_existing_slug) {
            // Provo con un nuovo slug appendendo il counter
            // Se concatenassi $new_slug rischierei slug-1-2 e non slug-2,
            // $base_slug serve a questo
            $new_slug = $base_slug . '-' . $counter;

            // Incremento il mio counter
            $counter++;

            // Se trova un elemento con lo stesso slug nel database lo ritorna, quindi la
            // condizione è sempre vera e il ciclo continua, altrimenti se non lo 
            // trova ritorna null e il ciclo si blocca, assegnando lo slug
            $post_with_existing_slug = Fakepost::where('slug', '=', $new_slug)->first();
        }

        // Quando lo slug è libero allora lo popolo. All'attributo 'slug' della 
        // $request do il valore di $new_slug, che provenga da fuori o dentro il ciclo
        $form_data['slug'] = $new_slug;

        // A questo punto creo una nuova istanza nella mia tabella
        $post = new Fakepost();
        // La riempo con i parametri passati con create e con lo slug appena ottenuto
        $post->fill($form_data);
        // E la salvo
        $post->save();

        // Faccio il redirect a show
        return redirect()->route('admin.posts.show', [
            // Show ha bisogno dell'id per cui le passo l'id dell'istanza appena creata
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
        // Verifico che nel Model ci sia l'id passato, se non c'è mi da 404
        $post = Fakepost::findOrFail($id);

        $data = [
            'post' => $post
        ];
        
        // Passo i dati come $post essendo il singolo post e non posts e 
        // visualizzo la route di show 
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
        // Con edit gli passo l'id dal tah <a> in index
        // se c'è mi manda alla pagina, altrimenti 404
        $post = Fakepost::findOrFail($id);

        $data = [
            'post' => $post
        ];

        // Ritorno la view coi $data siccome ci popolo il form per le modifiche
        return view('admin.posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // Una volta inviato il form arrivo su update, che ha bisogno dell'id
    public function update(Request $request, $id)
    {
        // Metodi di validazione
        $request->validate($this->getValidationRules());

        $form_data = $request->all();

        // Il fail non serve perché ci sei già, ci arrivi direttamente dall'invio del form
        // per cui salvo in una variabile l'istanza che sto modificando con l'id giusto
        $post = Fakepost::find($id);

        // Dico subito che l'attributo di $request['slug] è lo slug originale dell'istanza.
        // Rimane così se non c'è bisogno di cambiarlo, cioè quando non cambia il titolo,
        // altrimenti entra nel mega if sottostante
        $form_data['slug'] = $post->slug;

        // Calcolo dello slug
        //Se il title di $request (quello modificato responsabile della generazione dello slug) 
        // è diverso dal title originale dell'istanza allora si parte al controllo dello slug
        if($form_data['title'] != $post->title) {
            
            // Qui mi salvo lo slug nuovo generato con l'invio del form di modifica
            $new_slug = Str::slug($form_data['title'], '-');
            // Anche qui mi salvo una variabile concatenabile
            $base_slug = $new_slug;
            // Qua faccio first, perché so che non ci sarà più di un post con lo slug
            // uguale, altrimenti mysql mi da errore
            $post_with_existing_slug = Fakepost::where('slug', '=', $new_slug)->first();
            // E anche qui il mio counter
            $counter = 1;

            // Se un post con lo stesso slug esiste, allo slug viene aggiunto il valore
            // counter
            while($post_with_existing_slug) {
                // Provo con un nuovo slug appendendo il counter
                $new_slug = $base_slug . '-' . $counter;
                // Incremento il counter
                $counter++;

                // Se trova un elemento con lo stesso slug nel db lo ritorna, quindi la
                // condizione è sempre vera e il ciclo continua, altrimenti se non lo 
                // trova ritorna null e il ciclo si blocca
                $post_with_existing_slug = Fakepost::where('slug', '=', $new_slug)->first();
            }

            // Quando lo slug è libero allora lo popolo con quello generato ora correttamente
            $form_data['slug'] = $new_slug;
        }

        // Aggiorno con le nuove informazioni modificate
        $post->update($form_data);
        
        // Faccio il mio solito redirect a show con passaggio di id
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
        // Cerco l'istanza passata per id e la distruggo
        $post = Fakepost::find($id);
        $post->delete();

        // Faccio il redirect alla pagina di lista post che è index
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
