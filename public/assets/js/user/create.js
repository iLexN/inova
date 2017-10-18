/** global: Vue */
/** global: user_info */
/** global: axios */
/** global: _ */

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
      var data = this.user;
      axios.post('/api/user', data).then(function (response) {
        if ( response.data.error !== undefined ){
          alert(response.data.error);
        } else {
          window.location.href = '/user/'+response.data.id;
        }
      }).catch(function () {

      });
    },
    update_user:function(){
      var data = this.user;
      axios.post('/api/user/'+this.user.id, data).then(function (response) {
        if ( response.data.error !== undefined ){
          alert(response.data.error);
        }
      }).catch(function () {

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