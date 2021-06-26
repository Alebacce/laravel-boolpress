const { default: Axios } = require("axios");

var app = new Vue({
    el: '#root',

    data: {
        title: 'Lista post',
        posts: []
    },

    mounted() {
        axios.get('http://127.0.0.1:8000/api/posts-api')
            .then(result => {
                console.log(result.data);
                this.posts = result.data;
            })
    } 
});