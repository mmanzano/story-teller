// Usage <message :message="message"></message>

<template>

    <div class="row" v-if="! messageDeleted">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div v-if="messageEdit">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                {{ messageLive.body }}
                                <div class="form-group">
                                    <label class="form-label message__label">Edit Message:</label>
                                    <textarea rows="2" class="form-control message__textarea" v-model="messageLive.body"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row message__actions" v-if="isAuthor">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                                <button @click="updateMessage" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </div>

                    <div v-else>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                {{ messageLive.body }}
                            </div>
                        </div>
                        <div class="row message__actions" v-if="isAuthor">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                                <button @click="messageEdit = (! messageEdit)" class="btn btn-success">Edit</button>
                                <button @click="deleteMessage" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .message__actions {
        margin-bottom: 10px;
    }
    .message__label {
        margin: 10px 0;
    }
</style>

<script>
    export default {
        data () {
          return {
              messageEdit: false,
              messageDeleted: false,
              messageLive: this.message
          }
        },
        props: [
            'message',
            'user',
            'story'
        ],
        computed: {
            isAuthor() {
                return (this.story.user_id == this.user.id);
            }
        },
        methods: {
            updateMessage() {
                this.$http.patch('/api/messages/' + this.messageLive.id, this.messageLive).then((response) => {
                    this.messageLive = response.data;
                    this.messageEdit = ! this.messageEdit;
                }, (response) => {
                    console.log(response);
                });
            },
            deleteMessage() {
                this.$http.delete('/api/messages/' + this.messageLive.id).then((response) => {
                    this.messageDeleted = true;
                }, (response) => {
                    console.log(response);
                });
            }
        }
    }
</script>
