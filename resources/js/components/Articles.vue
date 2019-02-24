<template>
    <div>
        <h2>Articles</h2>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                //empty array to start
                articles: [],
                //single article which is an object
                article: {
                    id: '',
                    title: '',
                    body: ''
                },
                // during update this field have to be sent during put request for it to be put
                //id is not passed in the route, so the article_id is passed which makes the system know which article to update
                article_id: '',
                pagination: {},
                edit: false
            }
        },
        //Articles needs to be fetched so this method automatically runs when a page loaded as
        created(){
            this.fetchArticles();
        },

        methods: {
            fetchArticles(){
                //for making request fetch API is used
                fetch('api/articles')
                //With fetch API one dot is to be done which gives the response but doesn't give data so by mapping with json
                    .then(res => res.json())
                    //Another dot gives the actual data after json
                    .then(res  => {
                        console.log(res.data);
                    })
            }
        }
    }
</script>

<style scoped>

</style>