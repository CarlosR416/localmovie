<?php
namespace App\Modelos;

//importa Eloquent para usarlo en el modelo
use Illuminate\Database\Eloquent\Model as Eloquent;

class CategoriaPelicula extends Eloquent
{
   // Define la llave primaria de la tabla usuarios
   protected $primaryKey = 'id';

   // Define el nombre de la tabla 
   //protected $table = 'series_capitulos';
   
     // Define los campos que pueden llenarse en la tabla
   protected $fillable = [
       'id',
       'pelicula',
       'categoria'
   ];


   function peliculas(){

      return  $this->belongsTo('App\Modelos\Pelicula', 'pelicula');

   }

   function User_view(){

      return  $this->hasMany('App\Modelos\UsersLog', 'id_rcs');

   }
}