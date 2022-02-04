export default {
  
  index: function( p ){
    return axios.get('/api/voting', {params: p});
  },

  indexCu: function( p, id ){
    return axios.get('/api/voting/indexCu/' + id, {params: p});
  },

  indexVoting: function(){
    return axios.get('/api/voting/indexVoting');
  },

  indexVotingCu: function(id){
    return axios.get('/api/voting/indexVotingCu/' + id);
  },

  indexPilihan: function(name){
    return axios.get('/api/voting/indexPilihan/' + name);
  },

  indexSuara: function(id){
    return axios.get('/api/voting/indexSuara/' + id);
  },

  indexDataSuara: function(p, id){
    return axios.get('/api/voting/indexDataSuara/' + id, {params:p});
  },

  indexDataTanggapan: function(p, id){
    return axios.get('/api/voting/indexDataTanggapan/' + id, {params:p});
  },

  checkUser: function(id){
    return axios.get('/api/voting/checkUser/' + id);
  },

  create: function(){
    return axios.get('/api/voting/create');
  },

  store: function (form ){
    return axios.post('/api/voting/store', form);
  },

  storeSuara: function (form ){
    return axios.post('/api/voting/storeSuara', form);
  },

  storePilihan: function ( form ){
    return axios.post('/api/voting/storePilihan', form);
  },

  edit: function( id ){
    return axios.get('/api/voting/edit/' + id);
  },

  updateStatus: function ( id, cu ){
    return axios.get('/api/voting/updateStatus/' + id + '/' + cu);
  },

  updateSuara: function ( id, form ){
    return axios.post('/api/voting/updateSuara/' + id, form);
  },

  updateSuaraCu: function ( form ){
    return axios.post('/api/voting/updateSuaraCu', form);
  },

  destroy: function( id ){
    return axios.delete('/api/voting/' + id);
  },

  destroySuara: function( id ){
    return axios.delete('/api/voting/destroySuara/' + id);
  },

  countPilihan: function( id ){
    return axios.get('/api/voting/countPilihan/' + id);
  },

  countSuara: function( id ){
    return axios.get('/api/voting/countSuara/' + id);
  },
}