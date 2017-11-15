/** global: Vue */
/** global: product_list */
/** global: axios */
/** global: customer_info */

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
      var search = this.search_text;

      return this.product_list.filter(function(c){
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
    addToCustomer: function(product){
      var self = this;
      axios.post('/api/customer/'+customer_info.id+'/attach-product', product).then(function () {
        var index = _.findIndex(self.product_list, product);
        self.product_list.splice(index, 1);
      }).catch(function () {

      });
    },
    save: function(product,index){
      var self = this;
      var data = {
        'selling_price' : product.pivot.selling_price
      };

      axios.post('/api/customer/'+customer_info.id+'/product/'+product.id, data).then(function (response) {
        self.product_list_sort[index].pivot.cal = response.data.pivot.cal;
      }).catch(function () {

      });

    }
  }
});