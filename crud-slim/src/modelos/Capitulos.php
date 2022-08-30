<?php
namespace App\Modelos;

//importa Eloquent para usarlo en el modelo
use Illuminate\Database\Eloquent\Model as Eloquent;

class Capitulos extends Eloquent
{
   // Define la llave primaria de la tabla usuarios
   protected $primaryKey = 'id';

   // Define el nombre de la tabla 
   protected $table = 'series_capitulos';
   
     // Define los campos que pueden llenarse en la tabla
   protected $fillable = [
       'id',
       'id_serie',
       'temporada',
       'capitulo',
       'nombre',
       'img',
       'duracion',
       'descripcion',
       'url'
   ];


   function Series(){

      return  $this->belongsTo('App\Modelos\Series', 'id_serie');

   }

   function User_view(){

      return  $this->hasMany('App\Modelos\UsersLog', 'id_rcs');

   }
}