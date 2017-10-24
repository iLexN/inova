/** global: Vue */
/** global: _ */
/** global: axios */



var app = new Vue({
  el: '#product_component',
  data: {
    new_info: new_info,
    list : list,
    type1_list : type_list
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
    type_list:function(){
      var a = this.type1_list[1];
      return this.list.filter(function(s1){
        return s1.type == a;
      });
    },
    nature_list:function(){
      var a = this.type1_list[2];
      return this.list.filter(function(s1){
        return s1.type == a;
      });
    }
  },
  methods :{
    create:function()
    {
      var self = this;
      axios.post('/api/product/component', this.new_info).then(function (r) {
        self.list.push(r.data);
        self.new_info.value ='';
        self.new_info.type = '';
      }).catch(function () {

      });
    },
    edit : function (r){
      var data = {
        'value' : r.value
      };
      axios.post('/api/product/component/'+r.id, data).then(function () {

      }).catch(function () {

      });
    },
    remove:function(r){
      var data = {
        '_METHOD' : 'DELETE'
      };
      var self = this;
      axios.post('/api/product/component/'+r.id, data).then(function () {
        var index = _.findIndex(self.list, r);
        console.log(index);
        self.list.splice(index, 1);
      }).catch(function () {

      });
    }
  }
});