//--- plugin para formulario en ajax --//
(function($) {
 
// Declaración del plugin.
$.fn.ajaxform = function(options) {
   
    options = $.extend({}, $.fn.ajaxform.defaultOptions, options);
   
    //--- metodos auxiliares --//
    var $self = {
        blockForm : function(form){
            $("input:not(submit),select,textarea",form).each(function(){
                $(this).attr("readonly",true);
            });

            $(":submit",form).attr("disabled",true).css({
                'opacity': 0.5,
                "cursor":"wait"
            });
            $(form).css("cursor","wait");
        },
        unblockForm:  function(form){
            $("input:not(:submit),select,textarea",form).each(function(){
                $(this).attr("readonly",false);
            });

            $(":submit",form).attr("disabled",false).css({
                'opacity': 1,
                "cursor" :"pointer"
            });

            $(form).css("cursor","auto");
        },
    };

    this.each(function() {
            var _this = $(this);
            var valid = true;
            
            //--- agregamos la data de envio --//
            _this.data("submited",false);

            //--- activamos el evento al objeto --//
            _this.on("submit",function(e){
                //e.stopPropagation();
                e.preventDefault();

                //--- verificamo si hay que validar 
                if(options.validate)
                    valid = _this.valid();

                    
                // variables //
                var $action = _this.attr("action"),
                    $formdata = new FormData(this),
                    $method = _this.attr("method"); 
            
                if(valid &&  _this.data("submited") === false )
                {
                    //-- cambiamos el estado --//
                    _this.data("submited",true);

                    //-- enlazamos nuestro ajax --//
                    $.ajax({
                        url : $action,
                        type : $method, 
                        data : $formdata,
                        datatype : options.datatype,
                        cache : false,
                        contentType : false,
                        processData : false,
                        beforeSend : function(){
                            //-- lanzamos nuestro procedimiento previo --//
                            $self.blockForm();

                            //-- verificamos y lanzamos la funcion de cover --//
                            if(typeof options.waiter === 'function')
                                options.waiter(_this);
                        },
                        success :function(data){
                             //-- lanzamos nuestro procedimiento previo --//
                             $self.unblockForm();
                             
                             //--- volvemos el estado del form a normal --//
                             _this.data("submited",false);

                            //-- verificamos y lanzamos la funcion de cover --//
                            if(typeof options.complete === 'function')
                                options.complete(data,_this);

                            
                        },
                        error : function(xhr){
                            //-- lanzamos nuestro procedimiento previo --//
                            $self.unblockForm();

                             //--- volvemos el estado del form a normal --//
                             _this.data("submited",false);

                            //-- verificamos y lanzamos la funcion de cover --//
                            if(typeof options.fail=== 'function'){
                                var Response = xhr.responseText;

                                if( options.datatype == "json" )
                                  Response= JSON.parse(xhr.responseText);
                                
                                options.fail(_this,Response);
                            }

                        }
                    });
                }//--- if
        });

     
        
    }); //_- fin de each 
   
      return this;
    }
   
    // Parametros del plugin.
    $.fn.ajaxform.defaultOptions = {
      waiter : null,
      complete : null,
      fail: null,
      datatype : "json",
      validate : true
    }
   
})(jQuery);