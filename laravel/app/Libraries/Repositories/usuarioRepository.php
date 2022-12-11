<?php

namespace App\Libraries\Repositories;


use App\Models\usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class usuarioRepository
{
	public function all()
	{
		return usuario::all();
	}

	public function search($input)
    {
        return usuario::where('id', '>', 1)
			->orderBy('name', 'asc')
			->paginate(20);

    }

	public function store($data)
	{
	   $usuario = usuario::create([
		   'name' => $data['name'],
		   'email' => $data['email'],
		   'password' => $data['password']
	   ]);
	   DB::table('role_user')
		  ->insertGetId([
			'role_id'=>$data['rol'],
			'user_id'=>$usuario->id
		  ]);

	   return $usuario;
	}

	public function findusuarioById($id)
	{
		return usuario::find($id);
	}

	public function update($usuarios, $input)
	{
	   $user_id = $usuarios['id'];

	   $data['name']       = $input['name'];
	   $data['rol']       = $input['rol'];
	   $data['email']      = $input['email'];
	   $data['password']   = $input['password'];
	   //Verificar si el password esta vacio o no para cambiarlo si no o conservarlo como esta si es vacio
	   if (!empty($data['password'])) {  //si password no esta vacio
		  $data['password'] = Hash::make($input['password']);
		  if ($data['password'] != $usuarios['password']) {
			 DB::table('users')
				 ->where('id', $user_id)
				 ->update(['password' => $data['password']]);
		  }
	   }

	   //Actulizar el nombre y el email de el usuario
	   DB::table('users')
		  ->where('id', $user_id)
		  ->update([
			 'name'=>$data['name'],
			  'email' => $data['email']
		  ]);

		//Eliminar el link del el rol y el usuario que existe para signar uno nuevo
	   DB::table('role_user')->where('user_id', '=', $user_id)->delete();

	   //Guardamos nuevamente un rol para el usuario, sin importar si cambio o no.
	   DB::table('role_user')->insertGetId([
		  'user_id'=>$user_id,
		  'role_id'=>$data['rol']
	   ]);
	   return $usuarios;
	}
	
	public function verificarCorreo($email){
		return DB::table('users')
			->where('deleted_at', null)
			->where('email', $email)
			->get();
	}

}