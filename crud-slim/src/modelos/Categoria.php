<?php
namespace App\Modelos;

//importa Eloquent para usarlo en el modelo
use Illuminate\Database\Eloquent\Model as Eloquent;

class Categoria extends Eloquent
{
   // Define la llave primaria de la tabla usuarios
   protected $primaryKey = 'id';

   
     // Define los campos que pueden llenarse en la tabla
   protected $fillable = [
       'id',
       'nombre'
   ];


   function total_p(){
 
      return $this->hasMany('App\Modelos\CategoriaPelicula', 'categoria');

   }

   function total_s(){
 
      return $this->hasMany('App\Modelos\CategoriaSerie', 'categoria');

   }

   function User_view(){

      return  $this->hasMany('App\Modelos\UsersLog', 'id_rcs');

   }
}