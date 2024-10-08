<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Product;
use Illuminate\Support\Facades\URL;

class UsersController extends Controller
{

    public function profile()
    {

        try {
            if (Auth::check()) {
                DB::beginTransaction();
                $user_name = Auth::user()->name;
                $user_id = Auth::user()->id;
                DB::commit();
                return view('client.profile', compact('user_name', 'user_id'));
            } else {
                return view('auth.verify-email');
            }
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            DB::commit();
            return view('client.update', compact('user'));
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            //Comprobamos los datos
            $request->validate([
                'email' => ['required', 'string', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
            ]);
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $user->email = $request->email;
            $user->name = $request->name;
            $user->save();
            DB::commit();

            return redirect()->route('user.profile')->with('success', 'Tu perfil ha sido actualizado');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('user.profile')->with('error', 'Error al actualizar el usuario.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function contact_send(Request $request)
    {
        // Validar los datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|min:9|max:9',
            'message' => 'required|string|max:2000',
        ]);

        // Obtener la dirección de correo del archivo .env
        $toEmail = env('MAIL_TO_ADDRESS', 'miguelvegamolina2404@gmail.com'); // Asegúrate de definir MAIL_TO_ADDRESS en tu .env

        // Enviar el correo
        Mail::send('emails.contact', ['data' => $validatedData], function ($message) use ($validatedData, $toEmail) {
            $message->to($toEmail, 'Your Name')
                ->subject('Nuevo mensaje de contacto');
        });

        // Redirigir con un mensaje de éxito
        return redirect()->route('home')->with('success', 'Tu mensaje ha sido enviado correctamente.');
    }


    public function like_unlike(Request $request)
    {
        try {
            if (!auth()->check()) {
                return redirect()->route('login');
            }

            DB::beginTransaction();

            $client = Auth::user();

            $product_id = $request->input('product_id');

            $product = Product::findOrFail($product_id);

            $likeProduct = $client->favouriteProducts()->where('product_id', $product_id)->first();
            //Comprobamos si like o unlike
            if ($likeProduct == null) {
                $client->favouriteProducts()->attach($product_id);
            } else {
                $client->favouriteProducts()->detach($product_id);
            }
            DB::commit();

            //Volvemos a la url anterior ya que este metodo se llama desde distintas paginas
            $previousUrl = URL::previous();

            return redirect()->to($previousUrl);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
