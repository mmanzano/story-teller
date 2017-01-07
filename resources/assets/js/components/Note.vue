// Usage <note :note="note"></note>

<template>

    <div class="row" v-if="! noteDeleted">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row note__actions">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                            <button @click="deleteNote" class="btn btn-danger">Borrar</button>

                            <button v-if="noteEdit" @click="updateNote" class="btn btn-success">Guardar</button>
                            <button v-else @click="noteEdit = (! noteEdit)" class="btn btn-success">Editar</button>
                        </div>
                    </div>

                    <div class="row" v-if="noteEdit">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            {{ note.body }}
                            <div class="form-group">
                                <label class="form-label note__label">Editar Nota:</label>
                                <textarea rows="10" class="form-control note__textarea" v-model="note.body"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            {{ note.body }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<style>
    .note__actions {
        margin-bottom: 10px;
    }
    .note__label {
        margin: 10px 0;
    }
</style>

<script>
    export default {
        data () {
          return {
              noteEdit: false,
              noteDeleted: false
          }
        },
        props: [
            'note'
        ],
        methods: {
            updateNote() {
                this.$http.patch('/api/notes/' + this.note.id, this.note).then((response) => {
                    this.note = response.data;
                    this.noteEdit = ! this.noteEdit;
                }, (response) => {
                    console.log(response);
                });
            },
            deleteNote() {
                this.$http.delete('/api/notes/' + this.note.id).then((response) => {
                    this.noteDeleted = true;
                    this.$emit('notedeleted');
                }, (response) => {
                    console.log(response);
                });
            }
        }
    }
</script>
