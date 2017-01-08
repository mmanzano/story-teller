// Usage <story :story="story"></story>

<template>
    <div class="container">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading" v-if="storyEdit">
                        {{ storyLive.title }}<br />
                        <input v-model="storyLive.title"><br />
                        Private: <input type="checkbox" v-model="storyLive.private"><br />
                        In Front: <input type="checkbox" v-model="storyLive.in_front"><br />
                    </div>
                    <div class="panel-heading" v-else>
                        {{ storyLive.title }}
                        <span class="btn btn-success" v-if="storyLive.private">Private</span>
                        <span class="btn btn-success" v-else>Public</span>
                        <span class="btn btn-success" v-if="storyLive.in_front">In Front</span>
                    </div>
                    <div class="panel-body">
                        <div class="row message__actions">
                            <div v-if="storyEdit" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                                <button  @click="updateStory" class="btn btn-success">Save</button>
                            </div>
                            <div v-else class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                                <button @click="storyEdit = (! storyEdit)" class="btn btn-success">Edit</button>
                                <button @click="deleteStory" class="btn btn-danger">Delete</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <message v-for='message in messages' :message='message' @messagedeleted='refreshUserNotes(paginationNotes.current_page)'></message>

        <div class="row" v-if="! messages.length">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                No messages in the Story
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-warning">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                {{ message.body }}
                                <div class="form-group">
                                    <label class="form-label message__label">Add Message to story:</label>
                                    <textarea rows="2" class="form-control message__textarea" v-model="message.body" id="message"></textarea>
                                    <button @click="createMessage" class="btn btn-success message__actions-create">Crear nota</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<style>
    .message__actions-create {
        margin-top: 10px;
    }
</style>

<script>
    import message from './Message.vue';

    export default {
         mounted() {
            this.fetchStoryMessages();
        },
        data: function() {
            return {
                message: {},
                messages: [],
                storyEdit: false,
                storyDelete: false,
                storyLive: this.story
            };
        },
        props: [
            'story'
        ],
        methods: {
            fetchStoryMessages(messageId) {
                if (messageId === undefined) {
                    var page_url = '/api/stories/' + this.storyLive.id + '/messages';
                } else {
                    var page_url = '/api/stories/' + this.storyLive.id + '/messages/' + messageId ;
                }
                this.$http.get(page_url).then((response) => {
                    var message = response.data;
                    if(message.id !== undefined) {
                        this.messages.push(message);
                        this.fetchStoryMessages(message.id);
                    }
                }, (response) => {
                    console.log(response);
                });
            },
            createMessage() {
                this.$http.post('/api/stories/' + this.storyLive.id + '/messages', this.message).then((response) => {
                    this.messages.push(this.message);
                    this.message = {};
                    document.getElementById('message').focus();
                }, (response) => {
                    console.log(response);
                });
            },
            updateStory() {
                this.$http.patch('/api/stories/' + this.storyLive.id, this.storyLive).then((response) => {
                    console.log(response.data);
                    this.storyLive = response.data;
                    this.storyEdit = ! this.storyEdit;
                }, (response) => {
                    console.log(response);
                });
            },
            deleteStory() {
                this.$http.delete('/api/stories/' + this.storyLive.id).then((response) => {
                    this.storyDeleted = true;
                    window.location = '/stories';
                }, (response) => {
                    console.log(response);
                });
            }
        },
        components: {
            message,
        }
    }
</script>
