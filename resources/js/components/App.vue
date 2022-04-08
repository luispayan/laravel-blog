<template>
    <div class="container mb-5">
        <div>
            <b-navbar toggleable="sm" type="light" variant="light">
                <b-navbar-brand tag="h1" class="mb-0">Blog</b-navbar-brand>
            </b-navbar>
        </div>
        <Post/>
        <div class="row justify-content-center">
            <div class="col-12 title mt-4">
                Leave a comment
            </div>
            <div class="col-12 mt-2">
                <CommentInput v-model="comment" :saved="saved"/>
            </div>
            <div class="col-md-12" v-for="(comment, index) in comments" :key="`comment${index}`">
                <Comment :comment="comment"/>
            </div>
        <div class="col-12 text-center mt-2 mb-2" v-if="comments.length < total">
            <b-button variant="outline-dark" @click="loadMore" v-if="!loading">Load More...</b-button>
            <div class="spinner-border" role="status" v-else>
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
    import Comment from './Comment.vue';
    import CommentInput from './CommentInput.vue';
    import Post from './Post.vue';
    import axios from 'axios';
    export default {
        components: { Comment, CommentInput, Post },
        data: function(){
            return {
                comments: [],
                total: 0,
                comment: {
                    name: "",
                    comment: "",
                    reply_to: null,
                    comment_level: 1
                },
                error: false,
                takeSize: 10,
                loading: false,
            }
        },
        methods: {
            saved(object){
                if(this.comment.replies){
                    this.comment.replies.unshift(object.data);
                } else {
                    this.comment.replies = [object.data];
                }
                this.comment = {
                    name: "",
                    comment: "",
                    reply_to: null,
                    comment_level: 1
                };
            },
            loadMore(){
                this.loading = true;
                axios.get(`/api/v1/comments?take=${this.takeSize}&skip=${this.comments.length}&sort=desc`)
                .then(response => {
                    this.comments = this.comments.concat(response.data.data);
                    if(this.total == 0){
                        this.total = response.data.meta.total;
                    }
                }).catch(error => {
                    console.log("No se encontraron mensages")
                }).finally(() => {
                    this.loading = false;
                });
            }
        },
        created(){
            this.loadMore();
        }
    }
</script>
<style lang="scss" scoped>
.title{
    font-size: 22px;
    font-weight: bold;
}
</style>