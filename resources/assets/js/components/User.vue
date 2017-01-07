<template>
    <div class="container">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ user.name }}</div>
                    <div class="panel-body">
                        {{ user.email }}
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
                                {{ note.body }}
                                <div class="form-group">
                                    <label class="form-label note__label">Añadir nota:</label>
                                    <textarea rows="10" class="form-control note__textarea" v-model="note.body"></textarea>
                                    <button @click="createNote" class="btn btn-success note__actions-create">Crear nota</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row"  v-if="notes.length">
            <div class="col-md-8 col-md-offset-2">
                <nav aria-label="...">
                    <ul class="pager">
                        <li class="{{ !paginationNotes.prev_page_url ? 'disabled' : '' }}"><a @click="fetchUserNotes(paginationNotes.prev_page_url)">Anterior</a></li>
                        <li><span>Página {{paginationNotes.current_page}} de {{paginationNotes.last_page}}</span></li>
                        <li class="{{ !paginationNotes.next_page_url ? 'disabled' : '' }}"><a @click="fetchUserNotes(paginationNotes.next_page_url)">Siguiente</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <note v-for='note in notes' :note='note' @notedeleted='refreshUserNotes(paginationNotes.current_page)'></note>

        <div class="row" v-if="notes.length">
            <div class="col-md-8 col-md-offset-2">
                <nav aria-label="...">
                    <ul class="pager">
                        <li class="{{ !paginationNotes.prev_page_url ? 'disabled' : '' }}"><a @click="fetchUserNotes(paginationNotes.prev_page_url)">Anterior</a></li>
                        <li><span>Página {{paginationNotes.current_page}} de {{paginationNotes.last_page}}</span></li>
                        <li class="{{ !paginationNotes.next_page_url ? 'disabled' : '' }}"><a @click="fetchUserNotes(paginationNotes.next_page_url)">Siguiente</a></li>
                    </ul>
                </nav>
            </div>
        </div>


        <div class="row" v-if="! notes.length">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                Todavía no tenemos notas en el sistema. Añade tu primera nota.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<style>
    .note__actions-create {
        margin-top: 10px;
    }
</style>

<script>
    import note from './Note.vue';

    export default {
        ready() {
            this.fetchUser();
            this.fetchUserNotes();
        },
        data() {
            return {
                note: {},
                user: [],
                notes: [],
                paginationNotes: []
            };
        },
        methods: {
            fetchUser() {
                this.$http.get('/api/user').then((response) => {
                    this.user = response.data;
                }, (response) => {
                    console.log(response);
                });
            },
            fetchUserNotes(page_url) {
                page_url = page_url || '/api/user/notes';
                this.$http.get(page_url).then((response) => {
                    this.notes = response.data.data;
                    this.makeNotesPagination(response.data);
                    if((this.notes.length === 0) && (this.paginationNotes.current_page > 1)) {
                        this.fetchUserNotes(this.paginationNotes.prev_page_url);
                    }
                }, (response) => {
                    console.log(response);
                });
            },
            refreshUserNotes() {
                let page_url = '/api/user/notes?page=' + this.paginationNotes.current_page;
                this.fetchUserNotes(page_url);
            },
            makeNotesPagination(data){
                this.paginationNotes = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    next_page_url: data.next_page_url,
                    prev_page_url: data.prev_page_url
                };
            },
            createNote() {
                this.$http.post('api/notes', this.note).then((response) => {
                    this.note = {};
                    this.fetchUserNotes();
                }, (response) => {
                    console.log(response);
                });
            }
        },
        components:{
            note,
        }
    }
</script>
