<template>
<div class="row" :class="`level-${comment.comment_level}`">
    <div class="col-12 d-flex ml-2 mt-3 name">
        <img src="/img/user.png" alt="User" class="profile-pick mr-2">
        {{comment.name}}
        <span class="time-ago ml-3">{{timeAgo(comment.created_at)}}</span>
    </div>
    <div class="col-12 comment">
        {{comment.comment}}
    </div>
    <div class="col-12" v-if="comment.comment_level < 3">
        <a href="" class="reply" @click.prevent="replyMessage">Reply</a>
        <a href="" v-if="comment.replies && comment.replies.length > 0" class="reply ml-2" @click.prevent="showReplies = !showReplies">{{showReplies ? 'Hide' : 'Show'}} replies</a>
    </div>
    <div class="col-12 mt-2" v-if="showInput">
        <CommentInput v-model="reply" :saved="saved"/>
    </div>
    <div class="col-12" v-show="showReplies">
        <comment v-for="(reply, index) in comment.replies" :key="`reply${index}`" :comment="reply"/>
    </div>
</div>
</template>

<script>
import moment from 'moment';
import Comment from './Comment.vue';
import CommentInput from './CommentInput.vue';
export default {
    name: 'comment',
    components: { 'comment': Comment, CommentInput },
    data: function(){
        return{
            reply: {
                name: "",
                comment: "",
                reply_to: null,
                comment_level: 1
            },
            showInput: false,
            showReplies: true
        }
    },
    props: {
        comment: {
            type: Object,
            required: true
        }
    },
    methods:{
        saved(object){
            if(this.comment.replies){
                this.comment.replies.unshift(object.data);
            } else {
                this.comment.replies = [object.data];
            }
            this.$set(this, 'showInput', false);
            this.$set(this, 'showReplies', true);
            this.$set(this, 'reply', {
                name: "",
                comment: "",
                reply_to: null,
                comment_level: 1
            });
        },
        timeAgo(date){
            return moment.utc(date).fromNow();
        },
        replyMessage(){
            this.$set(this, 'reply', {
                name: "",
                comment: "",
                reply_to: this.comment.id,
                comment_level: this.comment.comment_level+1
            });
            this.$set(this, 'showInput', true);
        }
    }
}
</script>

<style lang="scss" scoped>
.level-1{
    border: 1px solid #eee;
}
.level-2{
    margin-left: 30px;
}
.level-3{
    margin-left: 50px;
}
.d-flex{
    align-items: center;
}

.profile-pick{
    width: 2em;
    height: 2em;
}
.name{
    font-weight: bold;
}
.comment{
    margin-left: 4%;
}
.time-ago{
    font-weight: normal;
    font-size: 12px;
}
.reply{
    font-size: 12px;
    margin-left: 4%;
}
</style>