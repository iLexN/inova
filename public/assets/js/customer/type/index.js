/** global: Vue */
/** global: type_list */
/** global: axios */
/** global: regions_list */


var type_app = new Vue({
  el: '#type_list',
  data: {
    type_list : type_list,
    type : {
      name : ''
    }
  },
  watch : {

  },
  computed : {

  },
  methods :{
    add : function() {
      if ( this.type.name === ''){
        return;
      }
      var self = this;
      axios.post('/api/customer/type', this.type).then(function (response) {
        self.type.name = '';
      self.type_list.push(response.data);
      }).catch(function () {

      });
    },
    update:function(t){
      if ( t.name === ''){
        return;
      }
      var data = {
        name : t.name
      }
      axios.post('/api/customer/type/'+t.id, data).then(function () {

      }).catch(function () {

      });
    }
  }
});

var region_app = new Vue({
  el: '#regions_list',
  data: {
    regions_list : regions_list,
    region : {
      name : ''
    },
    country :{
      name : ''
    }
  },
  watch : {

  },
  computed : {

  },
  methods :{
    addRegion : function() {
      if ( this.region.name === ''){
        return;
      }
      var self = this;
      axios.post('/api/customer/region', this.region).then(function (response) {

        var data = response.data;
        data.countries = [];
        self.regions_list.push(response.data);
        self.region.name = '';
      }).catch(function () {

      });
    },
    updateRegion:function(r){
      if ( r.name === ''){
        return;
      }
      var data = {
        name : r.name
      };
      axios.post('/api/customer/region/'+r.id, data).then(function () {

      }).catch(function () {

      });
    },
    addCountry : function(r,r_index) {
      if ( typeof r.new_country === 'undefined' ||  r.new_country === ''){
        return;
      }
      var data = {
        name : r.new_country
      };
      var self = this;
      axios.post('/api/customer/region/'+r.id+'/country', data).then(function (response) {
        self.regions_list[r_index].countries.push(response.data);
        r.new_country = '';
      }).catch(function () {

      });
    },
    updateCountry:function(c){
      if ( c.name === ''){
        return;
      }
      var data = {
        name : c.name
      }
      axios.post('/api/customer/country/'+c.id, data).then(function () {

      }).catch(function () {

      });
    }
  }
});
