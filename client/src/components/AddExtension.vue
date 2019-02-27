<template>
    <div>
        <v-card>
            <v-card-title
                    class="headline grey lighten-2"
                    primary-title
                    fixed app
            >
                Add Extension
            </v-card-title>

            <v-card-text>
                <form id="form">
                    <v-layout justify-space-between>
                        <v-flex md5 class="ml-4">
                            <div class="form-elements">
                                <v-text-field id="name" class="title" label="Name:"></v-text-field>
                            </div>
                            <div class="form-elements">
                                <v-text-field id="price" class="title" label="Price:"></v-text-field>
                            </div>
                            <div class="form-elements">
                                <v-textarea outline id="description" label="Description"></v-textarea>
                            </div>
                            <div class="form-elements">
                                <v-textarea outline id="documentation" label="Documentation"></v-textarea>
                            </div>
                        </v-flex>
                        <v-flex md5 class="mr-5">
                            <div class="form-elements">
                                <v-select id="category" :items="infoForAddExtensionForm.category" label="Extension category"></v-select>
                            </div>
                            <div class="form-elements">
                                <v-select id="license" :items="['Free', 'Paid']" label="License" ></v-select>
                            </div>
                            <div class="form-elements">
                                <v-select id="license_period" :items="infoForAddExtensionForm.license_period" label="License period" ></v-select>
                            </div>
                            <div class="form-elements">
                                <v-text-field id="tag" class="subheading" label="Tags:"></v-text-field>
                            </div>
                            <div class="form-elements">
                                <v-switch id="publish" label="Publish: "></v-switch>
                            </div>
                            <div class="form-elements">
                                <v-switch id="notify" label="Notify when new comments are made: "></v-switch>
                            </div>
                            <div class="form-elements">
                                <v-switch id="alert" label="Send update email to purchasers: "></v-switch>
                            </div>
                        </v-flex>
                    </v-layout>
                    <div class="form-elements">
                        <p class="subheading"><span class="grey--text">Compatibility: </span></p>
                        <v-layout row wrap>
                            <div v-for="item in infoForAddExtensionForm.compatibility" class="mr-4">
                                <v-checkbox :label="item" v-model="compatibilityMas[item]"></v-checkbox>
                            </div>
                        </v-layout>
                    </div>
                </form>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-btn color="red darken-3" flat @click="sendNewExtension(false)">Cancel</v-btn>
                <v-spacer></v-spacer>
                <v-btn color="primary" flat @click="sendNewExtension(true)">
                    Send
                </v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
    export default {

        name: "AddExtension",

        props: ['infoForAddExtensionForm'],

        data() {
        	  return {
                compatibilityMas: [],
            }
        },

        methods: {
        	  sendNewExtension(status) {
                if (status) {
	                  const form = document.getElementById('form');
	                  let data = [

                    ];
	                  console.log(form.name.value);
                	  //this.$emit('sendNewExtension')
                } else {
                	  this.$emit('sendNewExtension')
                }
            },

	        getListByProp(prop) {
		        let mas = [];
		        for (var key in this.infoForAddExtensionForm[prop]) {
			        mas.push(this.infoForAddExtensionForm[prop][key]);
		        }
		        this.infoForAddExtensionForm[prop] = mas;
	        }
        },
        watch: {
            infoForAddExtensionForm: function () {
                this.getListByProp('category');
                this.getListByProp('license_period');
                this.getListByProp('compatibility');
            }
        }

    };
</script>

<style scoped>

</style>