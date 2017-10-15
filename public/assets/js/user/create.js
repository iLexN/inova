var app = new Vue({
  el: '#user',
  data: {
    user: user_info,
    header_name : ''
  },
  mounted : function(){
    this.show_head_name(this.user.head_id);
  },
  watch:{
    'user.head_id' : function(newValue){
      this.show_head_name(newValue);
    }
  } ,
  methods :{
    create_user : function() {
      console.log('create');
      var data = this.user;
      console.log(data);
      axios.post('/api/user', data).then(function (response) {
        if ( response.data.error !== undefined ){
          alert(response.data.error);
        } else {
          window.location.href = '/user/'+response.data.id;
        }
        console.log(response);
      }).catch(function (error) {
        console.log(error);
      });
    },
    update_user:function(){
      console.log('create');
      var data = this.user;
      axios.post('/api/user/'+this.user.id, data).then(function (response) {
        console.log(response);
      }).catch(function (error) {
        console.log(error);
      });
    },
    show_head_name : function(newValue){
      var u = this.$refs.usersList.options;
      var o =_.find(u, function(o) {
        return parseInt(o.value) === parseInt(newValue);
      });
      if ( typeof o !== 'undefined'){
        this.header_name = o.text;
      } else {
        this.header_name = 'not match';
      }
    }
  }
});