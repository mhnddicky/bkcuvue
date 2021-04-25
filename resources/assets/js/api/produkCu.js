export default {
  
  index: function( p ){
    return axios.get('/api/produkcu' , {params: p});
  },

  indexCu: function( p, id ){
    return axios.get('/api/produkcu/indexCu/' + id, {params: p});
  },

  getCu: function( id ){
    return axios.get('/api/produkcu/getCu/' + id);
  },

  getCuJalinan: function( id ){
    return axios.get('/api/produkcu/getCuJalinan/' + id);
  },

  getSimpananCu: function( id ){
    return axios.get('/api/produkcu/getSimpananCu/' + id);
  },

  getPinjamanCu: function( id ){
    return axios.get('/api/produkcu/getPinjamanCu/' + id);
  },

  create: function(){
    return axios.get('/api/produkcu/create');
  },

  store: function ( form ){
    return axios.post('/api/produkcu/store', form);
  },

  edit: function( id ){
    return axios.get('/api/produkcu/edit/' + id);
  },

  update: function ( id, form ){
    return axios.post('/api/produkcu/update/' + id, form);
  },

  destroy: function( id ){
    return axios.delete('/api/produkcu/' + id);
  },

  count: function(){
    return axios.get('/api/produkcu/count');
  },

  history: function(){
    return axios.get('/api/produkcu/history');
  },
}