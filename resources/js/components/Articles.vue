<template>
    <div class="row">
        <div class="col-md-6">
        <h2>Articles</h2>
        <form @submit.prevent="addArticle" class="mb-3">
            <div class="form-group">
                <!--bind this input to article title-->
                <input type="text" class="form-control" placeholder="Title" v-model="article.title"/>

            </div>
            <div class="form-group">
                <!--bind this input to article body-->
                <textarea class="form-control" placeholder="Body" v-model="article.body"></textarea>

            </div>
            <button type="submit" class="btn btn-light btn-block">
                Save
            </button>
        </form>
        </div>
        <div class="col-md-6">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <!--Disable the button if there is no previous page the url comes from the makePagination method-->
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click="fetchArticles(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item disabled">
                    <a class="page-link text-dark"  href="">Page {{pagination.current_page}} of {{pagination.last_page}}</a> </li>

                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click="fetchArticles(pagination.next_page_url)">Next</a>
                </li>
            </ul>
        </nav>
        <div class="card card-body mb-2 col-md-12" v-for="article in articles" v-bind:key="article.id">
            <h3>{{article.title}}</h3>
            <p>{{article.body}}</p>
            <hr>
            <button @click="editArticle(article)" class="btn btn-warning mb-2">
                Edit
            </button>
            <button @click="deleteArticle(article.id)" class="btn btn-danger">
                Delete
            </button>

        </div>
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
            },
            deleteArticle(id){
                if(confirm('Are you Sure?')){
                    //use backticks as api/article singular is doing
                    fetch(`api/article/${id}`,{
                      method: 'delete'//second parametr of the object
                    })
                        .then(res => res.json())//gives the article back
                        .then(data => {
                            alert('Article Removed');
                            this.fetchArticles();
                        })
                        .catch(err => console.log(err));
                }
            },
            //handles add and update
            addArticle()
            {
                //edit is defined in the data
                if (this.edit === false)
                {
                    //Add
                    fetch('api/article', {
                        method: 'post',//post request
                        //wrap in JSON.stringify as this need to be JSON string
                        body: JSON.stringify(this.article),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.article.title = '';
                            this.article.body = '';
                            alert('Article Added');
                            this.fetchArticles();
                        })
                        .catch(err => console.log(err));
                }
                else
                {
                    //update
                    fetch('api/article', {
                        method: 'put',//post request
                        //wrap in JSON.stringify as this need to be JSON string
                        body: JSON.stringify(this.article),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.article.title = '';
                            this.article.body = '';
                            alert('Article Updated');
                            this.fetchArticles();
                        })
                        .catch(err => console.log(err));
                }

            },
            editArticle(article)
            {
                this.edit = true;
                //this article is equal to the article being passed in id
                this.article.id = article.id;
                //while updating there is article_id field which is also set to the article id that is being passed through
                this.article.article_id = article.id;
                this.article.title = article.title;
                this.article.body = article.body;
            }

        }
    }


</script>

<style scoped>

</style>