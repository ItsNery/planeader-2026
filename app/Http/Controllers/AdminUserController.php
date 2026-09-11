<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-usuario|crear-usuario|editar-usuario|borrar-usuario', ['only' => ['index']]);
        $this->middleware('permission:crear-usuario', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-usuario', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-usuario', ['only' => ['destroy']]);
    }

    /**
     * Muestra un listado paginado de los usuarios que actuamente están en la base de datos.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::where('id', '!=', 1)->with('roles')->get(); // Excluir el usuario administrador
        return view('panel-admin.index', compact('users'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user = new User();
        $roles = Role::all();
        return view('panel-admin.form', compact('user', 'roles'));
    }

    /**
     * Valida y almacena un nuevo usuario en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'validador' => $request->role === 'admin' || $request->role === 'super-admin' ? 1 : 0, // Legacy support
        ]);

        $user->assignRole($request->role);

        return redirect()->route('panel-admin.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Actualmente no se utiliza, pero se deja como parte de la estructura del controlador.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     *
     * @param  int  $id El ID del usuario a editar.
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $userRole = $user->roles->first()?->name;
        return view('panel-admin.form', compact('user', 'roles', 'userRole'));
    }

    /**
     * Valida y actualiza un usuario existente en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud con los datos actualizados.
     * @param  int  $id El ID del usuario a actualizar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->validador = $request->role === 'admin' || $request->role === 'super-admin' ? 1 : 0; // Legacy support
        $user->save();

        $user->syncRoles([$request->role]);

        return redirect()->route('panel-admin.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Elimina un usuario de la base de datos.
     *
     * @param  int  $id El ID del usuario a eliminar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('panel-admin.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
