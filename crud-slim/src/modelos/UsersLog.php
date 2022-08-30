<?php
namespace App\Modelos;

//importa Eloquent para usarlo en el modelo
use Illuminate\Database\Eloquent\Model as Eloquent;

class UsersLog extends Eloquent
{
   // Define la llave primaria de la tabla usuarios
   protected $primaryKey = 'id';

   // Define el nombre de la tabla 
   //protected $table = 'series_capitulos';
   
     // Define los campos que pueden llenarse en la tabla
   protected $fillable = [
       'id',
       'id_user',
       'id_rcs',
       'id_subrcs',
       'ip',
       'comentario'
   ];


   function Capitulos(){

      return  $this->belongsTo('App\Modelos\Capitulos', 'id_subrcs');

   }

   function rcs(){

      return  $this->belongsTo('App\Modelos\Capitulos', 'id_rcs');

   }
}