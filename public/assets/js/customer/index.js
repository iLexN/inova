/** global: Vue */
/** global: customer_list */


var app = new Vue({
  el: '#list',
  data: {
    customer_list : customer_list,
    search_text: ''
  },
  watch : {

  },
  computed : {
    customer_list_sort : function (){
      var new_list = this.customer_list;
      var search = this.search_text;

      return new_list.filter(function(c){
        if ( search == ''){
          return true;
        }
        return (c.name.indexOf(search) !== -1 ||
            ( c.code !== null && c.code.indexOf(search) !== -1)
        );
      });
    }
  },
  methods :{

  }
});