<template>
    <div class="dashboard">
        <h1 class="subheading grey--text">Dashboard</h1>

        <v-container class="my-5">

            <!-- Loader / True while methods app.requestAll || app.requestOne || app.showExtensionData -->
            <v-dialog v-model="loading" hide-overlay persistent width="600">
                <v-card color="green" dark >
                    <v-card-text class="pa-4">
                        Please wait, extension(s) are loading
                        <v-progress-linear
                                indeterminate
                                color="white"
                                class="mb-0"
                        ></v-progress-linear>
                    </v-card-text>
                </v-card>
            </v-dialog>

            <!-- Add Extension -->
            <v-dialog v-model="addExtensionStatus" persistent>
                <AddExtension @sendNewExtension="sendNewExtension" :infoForAddExtensionForm="infoForAddExtensionForm"></AddExtension>
            </v-dialog>

            <div>

                <!-- Component Extensions / Show list of all Extensions and Popup with one extension -->
                <Extensions :one_extension="one_extension" :extensions="allExtensionsCom"
                            :showExtensions="extensions" @showExtension="showExtension($event)"
                            @sendEdit="sendEdit($event)" @deleteExtension="deleteExtension($event)"/>
                <div class="text-xs-center mt-3">

                    <!-- Pagination -->
                    <v-pagination
                            v-if="pagination"
                            v-model="page"
                            :length="paginationCom"
                    ></v-pagination>
                </div>
            </div>


        </v-container>

    </div>
</template>

<script>
    import Extensions from "@/components/Extensions";
    import AddExtension from "@/components/AddExtension";

    export default {

		    name: "Admin",

		    components: {AddExtension, Extensions},

		    // allExtensions - get from App.vue list of extension / by default false
		// loading - popup with loading alert, true/false
		// pagination - total amount of pagination pages
		// one_extension - one extension information
		    props: ['allExtensions','loading', 'pagination', 'one_extension', 'addExtensionStatus', 'infoForAddExtensionForm'],

		    data() {
            return {
                // Show list of extensions or not
                extensions: false,

                // Bind with <v-pagination>, keeps current page of pagination
                page: 1,
            };
		    },

		    computed: {

            // Catch changes of this.extensions and send it to the Extensions.vue
            allExtensionsCom() {
                this.extensions = true;
                return this.allExtensions;
            },

            // Catch total amount of pagination from App.vue and transforms data to integer
            paginationCom() {
                return +this.pagination;
            }
        },

		    watch: {

			// Catch change page event and send it to the App.vue
			page: function (val) {
				this.$emit('page', val)
			}

		},

		    methods: {

			// Catch showExtension event from Extensions.vue and send it to the App.vue
			showExtension(event) {
				this.$emit('showExtension', event);
			},

			// Catch editExtension event from Extensions.vue and send it to the App.vue
			sendEdit(event) {
				this.$emit('sendEdit', event);
			},

			// Catch deleteExtension event from Extensions.vue and send it to the App.vue
			deleteExtension(event) {
				this.$emit('deleteExtension', event);
			},

			// Send new Extension
			sendNewExtension() {
				this.$emit('newExtensionData')
			}

		}

	};
</script>

<style scoped>

</style>