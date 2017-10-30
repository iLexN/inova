/** global: Vue */
/** global: _ */
/** global: axios */
/** global: type_list */
/** global: list */
/** global: product_info */
/** global: pc_list */


var app = new Vue({
  el: '#product_info',
  data: {
    product_info: product_info,
    pc_list : pc_list,
    list : list,
    type1_list : type_list,
    series_v :'',
    type_v:'',
    nature_v:''
  },
  watch : {

  },
  computed : {
    series_list:function(){
      var a = this.type1_list[0];
      return this.list.filter(function(s1){
        return s1.type == a;
      });
    },
    pc_series_list:function(){
      var a = this.type1_list[0];
      return this.pc_list.filter(function(s1){
        return s1.type == a;
      });
    },
    type_list:function(){
      var a = this.type1_list[1];
      return this.list.filter(function(s1){
        return s1.type == a;
      });
    },
    pc_type_list:function(){
      var a = this.type1_list[1];
      return this.pc_list.filter(function(s1){
        return s1.type == a;
      });
    },
    nature_list:function(){
      var a = this.type1_list[2];
      return this.list.filter(function(s1){
        return s1.type == a;
      });
    },
    pc_nature_list:function(){
      var a = this.type1_list[2];
      return this.pc_list.filter(function(s1){
        return s1.type == a;
      });
    }
  },
  methods :{
    add:function(id){
      if ( id == ''){
        return;
      }
      var a_index = _.findIndex(this.pc_list, {"id":id});
      if ( a_index !== -1) {
        return;
      }
      var index = _.findIndex(this.list, {"id":id});
      this.pc_list.push(this.list[index]);
    },
    take:function(r){
      var index = _.findIndex(pc_list, r);
      this.pc_list.splice(index, 1);
    },
    create:function()
    {
      var data = {
        'product_info' : this.product_info,
        'pc_list' : this.pc_list.map(function(r){
          return r.id
        })
      };
      console.log(data);
      axios.post('/api/product', data).then(function (r) {
        console.log(r);
      }).catch(function () {

      });
    },
    update : function (){
      var data = {
        'product_info' : this.product_info,
        'pc_list' : this.pc_list.map(function(r){
          return r.id
        })
      };
      console.log(data);
      axios.post('/api/product/'+this.product_info.id, data).then(function (r) {
        console.log(r);
      }).catch(function () {

      });
    }
  }
});