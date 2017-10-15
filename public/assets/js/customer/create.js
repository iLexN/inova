var app = new Vue({
  el: '#customer',
  data: {
    customer: customer_info,
    extra : customer_extra,
    type : customer_type,
    staff : customer_staff,
    regions : region,
    extra_info:{
      "customer_name" : "",
      "contact_person" : "",
      "phone" : ""
    },
    staff_list : staff_list,
    staff_id : ''
  },
  watch : {
    'customer.region_id' : function(){
      this.customer.country_id = ''
    }
  },
  computed : {
    'regionsList' : function () {
      return this.regions.map(function(r) {
        return {"id" : r.id, "name" : r.name};
      });
    },
    'countryList' : function(){
      var r_id = this.customer.region_id;
      if ( r_id === ''){
        return {};
      }
      var c = this.regions.find(function(r){
        return r.id === r_id;
      });
      return c.countries.map(function(r) {
        return {"id" : r.id, "name" : r.name};
      });
    },
    show_head_name : function(){
      var id = this.staff_id;
      if ( id === ''){
        return '';
      }
      var o =_.find(this.staff_list, function(o) {
        return parseInt(o.id) === parseInt(id);
      });
      if ( typeof o !== 'undefined'){
        return o.name;
      } else {
        return 'not match';
      }
    },
    staff_list_choose : function () {
      var staff = this.staff;
      return this.staff_list.filter(function(s1){
        var is_exist = _.findIndex(staff, function(s2) {
          return s2 === s1.id;
        });
        if ( is_exist === -1){
          return true;
        }
        return false;
      });
    }
  },
  methods :{
    add_extra : function(){
      if ( this.extra_info.customer_name === '' ||
          this.extra_info.contact_person === '' ||
          this.extra_info.phone === ''
      ){
        console.log('cannot add with empty value');
        return false;
      }
      this.extra.push(Object.assign({}, this.extra_info));
      this.reest_type();
    },
    reest_type : function(){
      this.extra_info.customer_name = '';
      this.extra_info.contact_person = '';
      this.extra_info.phone = '';
    },
    add_staff : function(){
      if ( this.show_head_name !== 'not match' && this.show_head_name !==''){
        var id = parseInt(this.staff_id);
        this.staff.push(id);
        this.staff_id = '';
      }
    },
    get_staff_info: function(id,key){
      var o =_.find(this.staff_list, function(o) {
        return parseInt(o.id) === parseInt(id);
      });
      return _.get(o, key);
    },
    create_customer : function() {
      console.log('create');
      var data = {
        'customer' : this.customer,
        'type' : this.type,
        'extra' : this.extra,
        'staff' : this.staff,
      };
      console.log(data);
      axios.post('/api/customer', data).then(function (response) {
        if ( response.data.error !== undefined ){
          alert(response.data.error);
        } else {
          window.location.href = '/customer/'+response.data.id;
        }
        console.log(response);
      }).catch(function (error) {
        console.log(error);
      });
    },
    update_customer:function(){
      console.log('create');
      var data = {
        'customer' : this.customer,
        'type' : this.type,
        'extra' : this.extra,
        'staff' : this.staff
      };
      axios.post('/api/customer/'+this.customer.id, data).then(function (response) {
        console.log(response);
      }).catch(function (error) {
        console.log(error);
      });
    },
    delete_extra : function (index, id){
      if ( id === undefined ){
        this.extra.splice(index, 1);
        return;
      }
      var data = {
        '_METHOD' : 'DELETE'
      };
      var self = this;
      axios.post('/api/customer/extra/'+id, data).then(function (response) {
        console.log(response);
        self.extra.splice(index, 1);
      }).catch(function (error) {
        console.log(error);
      });
    },
    delete_staff : function (index, id){
        this.staff.splice(index, 1);
    }
  }
});