/** global: Vue */
/** global: product_list */

var app = new Vue({
  el: '#list',
  data: {
    product_list : product_list,
    search_text: ''
  },
  watch : {

  },
  computed : {
    product_list_sort : function (){
      var new_list = this.product_list;
      var search = this.search_text;

      return new_list.filter(function(c){
        if ( search == ''){
          return true;
        }
        return (c.material_code.indexOf(search) !== -1 ||
            ( c.model_no !== null && c.model_no.indexOf(search) !== -1)
        );
      });
    }
  },
  methods :{

  }
});