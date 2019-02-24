<template>
    <div>
        <h2>Articles</h2>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <!--Disable the button if there is no previous page the url comes from the makePagination method-->
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">

                    <a class="page-link" href="#" @click="fetchArticles(pagination.prev_page_url)">Previous</a></li>

                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
        <div class="card card-body mb-2" v-for="article in articles" v-bind:key="article.id">
            <h3>{{article.title}}</h3>
            <p>{{article.body}}</p>
        </div>
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
            //values from the api is extracted and used inside of the fetch instead of fetching from just api/articles
            //parameter page_url
            fetchArticles(page_url){
                //defining different variable for this
                let vm = this;
                page_url = page_url || '/api/articles'
                //for making request fetch API is used
                fetch(page_url)//parameter
                //With fetch API one dot is to be done which gives the response but doesn't give data so by mapping with json
                    .then(res => res.json())
                    //Another dot gives the actual data after json
                    .then(res  => {//promise response
                        //res.data gives the data. res.links gives the pagination links, res.meta gives the last page, current page, etc.
                        this.articles = res.data;
                        //passing both links and meta from the data obtained from the api/articles
                        vm.makePagination(res.meta, res.links);
                    })
                    .catch(err => console.log(err));
            },
            makePagination(meta, links){
                let pagination = {
                    //data from the api response api/articles
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };

                this.pagination = pagination;
            }
        }
    }
</script>

<style scoped>

</style>