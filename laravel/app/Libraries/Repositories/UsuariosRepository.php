<?php
namespace App\Libraries\Repositories;
use App\Models\Usuarios;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
class UsuariosRepository{

	public function all(){
		return Usuarios::leftJoin('role_user', 'users.id','=','role_user.user_id')
            ->leftJoin('roles','roles.id','=','role_user.role_id')
            ->leftJoin('ciudades','ciudades.id','=','users.ciudad')
            ->select('users.*','roles.display_name as rol','ciudades.title as nombreCiudad')
			->paginate(30);
	}

	public function store($input){
        return Usuarios::create($input);
    }

	public function storeRoleUser($input,$id){
		$hoy = date("Y-m-d H:i:s");
		DB::table('role_user')
				->insert([
						'role_id'	=>$input['role'],
						'user_id'	=>$id,
						'created_at'=>$hoy,
						'updated_at'=>$hoy
				]);
    }

	public function findUsuariosById($id){
		return Usuarios::find($id);
	}

    public function findUsuarios($id){
        return Usuarios::leftJoin('role_user', 'users.id','=','role_user.user_id')
            ->leftJoin('roles','roles.id','=','role_user.role_id')
            ->select('users.*','roles.display_name as rol','roles.id as id_rol')
            ->where('users.id','=',$id)
            ->get()
            ->first();
	}

    public function update($usuarios, $input){
        $user_id= $usuarios['id'];
        $rol	= $input['role'];
        $pass   = $input['password'];

		//Si la contraseña no esta vacia, se actualiza
        if (!empty($pass)){
            $pass = Hash::make($input['password']);
            if($pass != $usuarios['password']){
                DB::table('users') ->where('id', $user_id) ->update(['password' => $pass]);
            }
        }

        //Actulizar el nombre y el email de el usuario
        DB::table('users')
            ->where('id', $user_id)
            ->update([
                'nombre'	=>	$input['nombre'],
                'apellido'	=>	$input['apellido'],
                'calle'		=>	$input['calle'],
                'no_ext'	=>	$input['no_ext'],
                'no_int'	=>	$input['no_int'],
                'colonia'	=>	$input['colonia'],
                'tel'		=>	$input['tel'],
                'cel'		=>	$input['cel'],
                'estado'	=>	$input['estado'],
                'ciudad'	=>	$input['ciudad'],
                'cp'		=>	$input['cp'],
                'puesto'	=>	$input['puesto'],
                'name'		=>	$input['name'],
                'email' 	=>	$input['email']
            ]);

        //Actualizamos el perfil de usuario.
        DB::table('role_user') ->where('user_id',$user_id) ->update(['role_id'	=>	$rol]);

        return $usuarios;
    }

	public function search($input){
		$query = User::query();

		$columns = Schema::getColumnListing('usuarios');
		$attributes = array();

		foreach($columns as $attribute){
			if(isset($input[$attribute])){
				$query->where($attribute, $input[$attribute]);
				$attributes[$attribute] =  $input[$attribute];
			}else{
				$attributes[$attribute] =  null;
			}
		};
		return [$query->get(), $attributes];

	}


	public static function getRamSpace(){
		foreach(file('/proc/meminfo') as $ri)
			$m[strtok($ri, ':')] = strtok('');
		return $m;
	}

	public static function getDiskSpace(){
		return disk_total_space("/");
	}

	public static function getDiskSpaceFree(){
		return disk_free_space("/");
	}

	public static function getDiskSpaceUsed($path){
		$bytestotal = 0;
		$path = realpath($path);
		if($path!==false){
			foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS)) as $object){
				$bytestotal += $object->getSize();
			}
		}
		return $bytestotal;
	}

}