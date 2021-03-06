<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Fakepost;
use App\Category;
use App\Tag;
// NewPostAdminNotification + la classe della mail che ho creato io
use App\Mail\NewPostAdminNotification;

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
            'posts' => $posts,
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
        $categories = Category::all();
        $tags = Tag::all();

        $data = [
            'categories' => $categories,
            'tags' => $tags
        ];

        return view('admin.posts.create', $data);
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

        // dd($form_data);

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

        // Se c'è un immagine caricata dall'utente, la salvo in storage e aggiungo
        // il path relativo a cover in $new_post_data
        if(isset($form_data['cover-image'])) {
            $new_img_path = Storage::put('posts-cover', $form_data['cover-image'] );

            // Se $new_img_path è vera (per cui non è falsa e ha funzionato tornandomi una stringa)
            // allora dico che l'attributo cover di $form_data, ossia uguale al nome della colonna nel
            // database, è il path dell'immagine caricata ottenuto con Storage::put. 
            if ($new_img_path) {
                $form_data['cover'] = $new_img_path;
            }
        }

        // A questo punto creo una nuova istanza nella mia tabella
        $post = new Fakepost();
        // La riempo con i parametri passati con create e con lo slug appena ottenuto
        $post->fill($form_data);
        // E la salvo
        $post->save();

        // verifico che esista l'array 'tags' passato e anche che sia un array
        if(isset($form_data['tags']) && is_array($form_data['tags'])) {
            // Va non direttamente a post, ma a tags, in questo caso va con le parentesi.
            // Se voglio leggere i tags associati non metto le parentesi, se voglio usare un metodo
            // di tags, in questo caso sync, devo usare le parentesi. tags ritorna un'istanza dell'oggetto
            // di Eloquent, il responsabile della gestione del database, l'ORM.
            $post->tags()->sync($form_data['tags']);
        }
        
        
        // Dopo che il post è stato creato, invio l'email all'amministratore del sito.
        // Inoltre passo $post come construct quando creo una nuova istanza di NewPostAdminNotification
        // in modo che ogni volta il suo construct sia il post stesso, di modo da ottenere i dati di questo
        // nel Model della mail 
        Mail::to('alebacce@mail.it')->send(new NewPostAdminNotification($post));

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
            'post' => $post,
            'post_category' => $post->category,
            'post_tags' => $post->tags
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
        $categories = Category::all();
        $tags = Tag::all();

        $data = [
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags
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

        // Se c'è un immagine caricata dall'utente, la salvo in storage e aggiungo
        // il path relativo a cover in $new_post_data
        if(isset($form_data['cover-image'])) {
            $new_img_path = Storage::put('posts-cover', $form_data['cover-image'] );

            // Se $new_img_path è vera (per cui non è falsa e ha funzionato tornandomi una stringa)
            // allora dico che l'attributo cover di $form_data, ossia uguale al nome della colonna nel
            // database, è il path dell'immagine caricata ottenuto con Storage::put. 
            if ($new_img_path) {
                $form_data['cover'] = $new_img_path;
            }
        }

        // Aggiorno con le nuove informazioni modificate
        $post->update($form_data);

        // verifico che esista l'array 'tags' passato e anche che sia un array
        if(isset($form_data['tags']) && is_array($form_data['tags'])) {
            $post->tags()->sync($form_data['tags']);
        } else {
            // Quindi array vuoto, ossia non sono stati selezionati tags
            $post->tags()->sync([]);
        }
        
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
        // Non posso eliminare un post con una relazione a una tabella ponte
        // per cui prima elimino le relazioni e poi elimino il post
        $post->tags()->sync([]);
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
            'author' => 'required|min:3|max:50',
            // exist impedisce che si modifichi l'id della categoria
            // dall'inspector, se non esiste l'id invece di darmi error
            // rivelando dati sensibili del mio database, da semplicemente 404
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|exists:tags,id',
            // max 10000 indica la grandezza massima in kylobite
            // si può fare anche con min
            'cover-image' => 'nullable|mimes:jpg,png,jpeg,gif,svg'
        ];

        return $validation_rules;
    }
}
