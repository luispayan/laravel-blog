<template>
  <div class="row mb-2">
        <div class="col-12 col-md-6 mb-2">
            <b-form-input v-model="content.name" placeholder="Enter your name"></b-form-input>
            <span class="error" v-if="errors.name">Name field is required</span>
        </div>
        <div class="col-12">
            <b-form-textarea
            id="textarea"
            v-model="content.comment"
            placeholder="What you want to say..."
            rows="2"
            max-rows="3"
            ></b-form-textarea>
            <span class="error" v-if="errors.name">Comment field is required</span>
        </div>
        <div class="col-12 text-right mt-2">
            <b-button variant="outline-dark" @click="submit" v-if="!loading">Send</b-button>
            <div class="spinner-border" role="status" v-else>
                <span class="sr-only">Loading...</span>
            </div>
        </div>
  </div>
</template>

<script>
export default {
    data: function(){
        return {
            errors: {
                name: undefined,
                comment: undefined
            },
            fields: ['name', 'comment'],
            loading: false
        }
    },
    props: {
      value: [Object],
      saved: [Function]
    },
    methods: {
        submit(){
            this.loading = true;
            var valid = true;

            this.fields.forEach(field => {
                if(!this.content[field]){
                    this.errors[field] = true;
                    valid = false;
                } else {
                    this.errors[field] = undefined;
                }
            });

            if(valid){
                axios.post('/api/v1/comments', {
                    data: {
                        name: this.content.name,
                        comment: this.content.comment,
                        reply_to: this.content.reply_to,
                        comment_level: this.content.comment_level
                    }
                }).then(response => {
                    this.saved(response.data);
                }).catch(error => {
                    console.log("There was an error saving your comment");
                }).finally(() => {
                    this.loading = false;
                });
            } else {
                this.loading = false;
            }
        }
    },
    computed: {
        content: {
            get() {
                return this.value;
            },
            set(newValue) {
                this.$emit('input', newValue);
            }
        }
    }
}
</script>

<style>
.error{
    color: red;
}
</style>