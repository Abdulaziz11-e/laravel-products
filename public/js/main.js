
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})

// $(document).ready(function(){
//    $('.product').css('opacity', 0.7)
//    .mouseover(function(){
//       $(this).css('opacity', 1);  
//    })
//    .mouseout(function(){
//       $(this).css('opacity', 0.7);  
//    });   
// });

var BaseRecord={


  top9: 1,
  search: '',

  more: function(){
  	var ajaxSetting={
        method: 'get',
        url: './',
        data: {
        	top9: this.top9, // $_POST['top9'] == $request->top9 это в mine js!
        	search: this.search,

        },
        success: function(data){
        	//alert(data.table);
        	$('.row.products_row').html(data.table);

        },

  	};
    $.ajax(ajaxSetting);

  },


 removeone: function(id){
    var ajaxSetting={
        method: 'post',
        url: './clearone',
        data: {
           id: id,
        },
        success: function(data){
          //alert(data);
          BaseRecord.cart();
        },

    };
    $.ajax(ajaxSetting);

  },

  cart: function(){
    var ajaxSetting={
        method: 'get',
        url: './cart',
        // data: {
        //    id: id,
        // },
        success: function(data){
          //alert(data);
          $('.cart_items_list').html(data.table);
          $('.listbuttonremove').click(function(){
          BaseRecord.removeone($(this).attr('id'));
           return false;

        });
          
        },

    };
    $.ajax(ajaxSetting);

  },

  mailer: function(message, contact){
    //if(message!='' && contact!=''){
    var ajaxSetting={
        method: 'post',
        url: './mailer',
        data: {
           message: message, //$request->message
           contact: contact, //$request->contact

        },
        success: function(data){
          //alert(data.answer);
 
          //alert(data);
          if(data.answer){
               var data_json=JSON.parse(data.answer);
               if(data_json['mail'] && data_json['request']){
               $('.result_to_email').html('Your message has been sending...');
               $('.result_to_email').css('color', 'green');

         }    else {
              $('.result_to_email').html('Mistake...');
              $('.result_to_email').css('color', 'red');
              }

          } else{
                var data_json=JSON.parse(data);
                var error_str = '';
                for (var i in data_json) {
                  error_str+=data_json[i]+'\n';
                }
                alert(error_str);
          }
         
        },

    };
    $.ajax(ajaxSetting);
  //} else{
   // alert('Fields must be filled');

  //}

  },

  clearall: function(){ 
   var ajaxSetting={
      method: 'post',
      url: './clearall', //vagrant - ./
      //data: {
      //   id: id,
      //},
      success: function(data){
         BaseRecord.cart(); //!!!ajax-обновление страницы
      },
   };
   $.ajax(ajaxSetting);
},

};