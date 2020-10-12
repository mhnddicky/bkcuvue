export default {
  
  index: function( p ){
    return axios.get('/api/assesmentAccess' , {params: p});
  },

  indexCu: function( p, id ){
    return axios.get('/api/assesmentAccess/indexCu/' + id, {params: p});
  },

  create: function(){
    return axios.get('/api/assesmentAccess/create');
  },

  store: function ( form ){
    return axios.post('/api/assesmentAccess/store', form);
  },

  edit: function( id ){
    return axios.get('/api/assesmentAccess/edit/' + id);
  },

  editPenilaian: function( id ){
    return axios.get('/api/assesmentAccess/editPenilaian/' + id);
  },

  update: function ( id, form ){
    return axios.post('/api/assesmentAccess/update/' + id, form);
  },

  updateSingle: function ( id, perspektif,  form ){
    return axios.post('/api/assesmentAccess/updateSingle/' + id + '/' + perspektif, form);
  },

  destroy: function( id ){
    return axios.delete('/api/assesmentAccess/' + id);
  },

  count: function(){
    return axios.get('/api/assesmentAccess/count');
  },

  history: function(){
    return axios.get('/api/assesmentAccess/history');
  },

  cariData: function( cu, periode ){
    return axios.get('/api/assesmentAccess/cariData/' + cu + '/' + periode);
  },
}