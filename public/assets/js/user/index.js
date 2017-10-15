var app = new Vue({
  el: '#list',
  data: {
    user_list : user_list,
    search_text: ''
  },
  watch : {

  },
  computed : {
    list_sort : function (){
      var new_list = this.user_list;
      var search = this.search_text;

      return new_list.filter(function(c){
        if ( search == ''){
          return true;
        }
        console.log(c.name);
        return c.name.indexOf(search) !== -1 || c.email.indexOf(search) !== -1;
      });
    }
  },
  methods :{

  }
});