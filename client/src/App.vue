<template>
    <v-app class="grey lighten-4">
        <Navbar @getAllExtensions="getAllExtensions" @addExtension="addExtension()"/>
        <v-content class="my-5 mx-5">

            <!-- Snackbar -->
            <v-snackbar v-model="snackbar" :timeout="3000" color="green" top>
                {{ text }}
                <v-btn color="white" flat @click="snackbar = false">
                    Close
                </v-btn>
            </v-snackbar>

            <router-view  :one_extension="one_extension" :loading="loading" :allExtensions="extensions"
                          :pagination="pagination" @sendEdit="sendEdit($event)" @page="changePage($event)"
                          @showExtension="showExtensionData($event)" @deleteExtension="deleteExtension($event)"
                        :addExtensionStatus="addExtensionStatus" :infoForAddExtensionForm="infoForAddExtensionForm" @newExtensionData="sendNewExtension($event)"/>
        </v-content>
    </v-app>
</template>

<script>
	import Navbar from '@/components/Navbar'
	import axios from 'axios'

    export default {

        name: 'App',

        components: {Navbar},

        data () {
            return {

                //Snackbar
                snackbar: false,
                text: '',

                // Api url
                apiUrl: 'http://opencart-monitor.loc/',

                // Add Extension
                addExtensionStatus: false,
                infoForAddExtensionForm: false,

                // Result of this.requestAll / object with general extensions data
                extensions: false,

                // Result of this.requestOne / object with all information about one extension
                one_extension: false,

                // Loading popup / True while methods this.requestAll || this.requestOne running || this.showExtensionData
                loading: false,

                // Total amount of pagination pages
                pagination: null,

                // Current pagination page
                paginationPage: 1,
            }
        },

        methods: {

            // Get all extensions fro 1st page of pagination
            getAllExtensions() {
            this.loading = true;
            document.body.style.pointerEvents = 'none';
            this.requestAll('getAllExtensions', this.paginationPage, false)
          },

            // Change pagination page and load needed extensions
            changePage(page) {
            this.loading = true;
            document.body.style.pointerEvents = 'none';
            this.requestAll('getAllExtensions', page, this.pagination)
          },

            // Show data of one extension in Popup
            showExtensionData(data) {
                this.loading = true;
                document.body.style.pointerEvents = 'none';
                this.requestOne('getExtension', data)
            },

            // Add new extension
            addExtension() {
            	this.loading = true;
	            document.body.style.pointerEvents = 'none';
	            axios({
		            method: 'post',
		            url: this.apiUrl,
		            data: {
			            type: 'getInfoForAddExtension',
		            }
	            }).then(response => {
		            this.loading = false;
		            this.infoForAddExtensionForm = response.data;
		            document.body.style.pointerEvents = 'auto';
		            this.addExtensionStatus = true;
	            });
            },

	          sendNewExtension(event) {
            	  this.addExtensionStatus = false;
            },

            // Edit extension by id
            sendEdit(event) {
            this.loading = true;
            document.body.style.pointerEvents = 'none';
            this.requestEdit('editExtension', event[0], event[1])
          },

            // Delete one extension by id
            deleteExtension(id) {
            this.loading = true;
            document.body.style.pointerEvents = 'none';
            this.requestDelete('deleteExtension', id);
          },

            // Request to the server for this.getAllExtensions / this.changePage
            requestAll(type, page, pagination) {
            axios({
              method: 'post',
              url: this.apiUrl,
              data: {
                type: type,
                page: page,
                pagination: pagination,
              }
            }).then(response => {
              this.extensions = response.data.extensions;
              this.pagination = response.data.count;
              this.loading = false;
	            document.body.style.pointerEvents = 'auto';
            });
          },

            // Request to the server for this.sendEdit
            requestEdit(type, data, id) {
            axios({
              method: 'post',
              url: this.apiUrl,
              data: {
                type: type,
                data: data,
                id: id,
              }
            }).then(response => {
              this.one_extension = response.data;
              this.loading = false;
	            document.body.style.pointerEvents = 'auto';
            });
          },

            // Request to the server for this.showExtensionData
            requestOne(type, id) {
            axios({
              method: 'post',
              url: this.apiUrl,
              data: {
                type: type,
                id: id,
              }
            }).then(response => {
              this.one_extension = response.data;
              this.loading = false;
	            document.body.style.pointerEvents = 'auto';
            });
          },

            // Request to the server for this.deleteExtension
            requestDelete(type, id) {
            axios({
              method: 'post',
              url: this.apiUrl,
              data: {
                type: type,
                id: id,
              }
            }).then(response => {
              this.loading = false;
              this.text = 'Extension successfully removed';
              this.snackbar = true;
	            document.body.style.pointerEvents = 'auto';
            });
          }

        }
    }
</script>

<style>

</style>
