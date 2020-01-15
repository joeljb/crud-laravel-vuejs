<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
class User extends Authenticatable
{
   use Notifiable;

   /**
     * The attributes that are mass assignable.
     *
     * @var array
   */
   protected $fillable = [
      'nombres', 'apellidos','username', 'email', 'password',
   ];

   /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
   */
   protected $hidden = [
      'password', 'remember_token',
   ];

   public function autorizacion($tipo_usuarios)
   {
      if (is_array($tipo_usuarios)) {
         foreach ($tipo_usuarios as $tipo_usuario) {
            if (Auth::user()->tipo_usuario==$tipo_usuario) {
               return true;
            }
         }
      } else {
         if (Auth::user()->tipo_usuario==$tipo_usuario) {
            return true;
         }
      }
      abort(401, 'No está autorizado.');
   }
}
