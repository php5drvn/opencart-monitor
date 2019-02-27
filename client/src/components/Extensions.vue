<template>
    <div>
        <v-dialog v-model="dialogLook">
            <Dialog @deleteExtension="deleteExtension($event)" :extension="one_extension" :action="action" @sendEdit="sendEdit($event)"/>
        </v-dialog>

        <v-card v-if="showExtensions" flat v-for="(extension, id) in extensions" :key="id">
            <v-layout row wrap :class="`pa-3 ${getClass(extension)}`">
                <v-flex xs12 md2>
                    <div class="caption grey--text">Extension Name</div>
                    <div>{{ extension.name }}</div>
                </v-flex>
                <v-flex xs2 sm4 md2>
                    <div class="caption grey--text">Extension status</div>
                    <div>{{ extension.status }}</div>
                </v-flex>
                <v-flex xs2 sm4 md2>
                    <div class="caption grey--text">Date Added</div>
                    <div>{{ extension.date }}</div>
                </v-flex>
                <v-flex xs2 sm4 md6>
                    <div class="right">
                        <v-btn class="green" dark @click="showLookEditDialog(id, 'look')">
                            <v-icon>remove_red_eye</v-icon>
                            <!--<span class="ml-1">Look</span>-->
                        </v-btn>
                        <v-btn class="primary" dark @click="showLookEditDialog(id, 'edit')">
                            <v-icon>edit</v-icon>
                            <!--<span class="ml-1">Edit</span>-->
                        </v-btn>
                        <v-btn class="red darken-3" dark @click="showDeleteDialog(id)">
                            <v-icon>delete</v-icon>
                            <!--<span class="ml-1">Delete</span>-->
                        </v-btn>
                    </div>
                </v-flex>
            </v-layout>
            <v-divider></v-divider>
        </v-card>

    </div>
</template>

<script>

    import Dialog from '@/components/Dialog'

    export default {

		    name: "Extensions",

        components: {Dialog},

        // extensions - get general info about all extensions on the current page from App.vue->Admin.vue
        // showExtensions - show list of extensions or not
        // one_extension - get all info about one extension from App.vue->Admin.vue
	      props: ['extensions', 'showExtensions', 'one_extension'],

        data() {
		    	  return {

		    	  	  // Show Popup with info about one extension or not
		    	  	  dialogLook: false,

                // Send action to the Dialog.vue  look/edit/delete/null
                action: null,

                // Id of current extension choose by customer
                id: null,
            }
        },

        methods: {

		    	  // defines which class we should assign to the extensions
            getClass(extension) {
                if (extension.status === 'Disable'){
                    return 'danger-border'
                } else {
                    return 'suc-border'
                }
            },

            // Catch showExtension event and send it to the Admin.vue->App.vue
            showLookEditDialog(id, type) {
            	this.id = id;
            	this.action = type;
              this.$emit('showExtension', id);
            },

	          // Catch deleteExtension event and send it to the Admin.vue->App.vue
            showDeleteDialog(id) {
	              this.id = id;
                let extension;
                for (let i = 0; i < this.extensions.length; i++) {
                    if (this.extensions[i].id === id) {
                        extension = this.extensions[i];
                    }
                }
                this.action = 'delete';
                this.dialogLook = true;
            },

            // Catch sendEdit event and send it to the Admin.vue->App.vue
            sendEdit($event) {
            	  this.$emit('sendEdit', [$event, this.id])
            },

            // Catch deleteExtension event and send it to the Admin.vue->App.vue
            deleteExtension(status) {
            	  this.dialogLook = false;
            	  if (status === true) {
	                  this.$emit('deleteExtension', this.id)
                }
	          }
        },

        watch: {

		    	  // Catch changes of one_extension on execute Popup with extension data
            one_extension: function () {
                this.dialogLook = true;
            }
        }

	  };
</script>

<style scoped>
    .suc-border {
        border-left: 4px solid #339966;
    }
    .danger-border {
        border-left: 4px solid #CC3333;
    }
    .title-dialog-border {
        border-bottom: 2px solid #339966;
    }
</style>