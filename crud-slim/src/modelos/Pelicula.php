<?php
namespace App\Modelos;

//importa Eloquent para usarlo en el modelo
use Illuminate\Database\Eloquent\Model as Eloquent;

class Pelicula extends Eloquent
{
   // Define la llave primaria de la tabla usuarios
   protected $primaryKey = 'id';

   // Define el nombre de la tabla 
   protected $table = 'peliculas';
   
     // Define los campos que pueden llenarse en la tabla
   protected $fillable = [
       'id',
       'titulo',
       'duracion',
       'img',
       'descripcion',
       'url'
   ];

   function categorias(){
 
      return $this->hasMany('App\Modelos\CategoriaPelicula', 'pelicula');

   }
}