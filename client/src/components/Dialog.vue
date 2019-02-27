<template>
    <div>
        <v-card>
            <v-card-title class="headline grey lighten-2" primary-title>
                Extension: {{extension.name}}
            </v-card-title>
            <v-card-text>
                <div v-if="action === 'look'">
                    <p class="subheading"><span class="grey--text">Name: </span>{{extension.name}}</p>
                    <p class="subheading"><span class="grey--text">Price: </span>{{extension.price}}</p>
                    <p class="subheading"><span class="grey--text">Description: </span>{{extension.description}}</p>
                    <p class="subheading"><span class="grey--text">Documentation: </span>{{extension.documentation}}</p>
                    <p class="subheading"><span class="grey--text">Extension category: </span>{{extension.extension_category}}</p>
                    <p class="subheading"><span class="grey--text">Compatibility: </span><span v-html="compatibilityString"></span></p>
                    <p class="subheading"><span class="grey--text">Download name: </span>{{extension['extension_download[0][name]']}}</p>
                    <p class="subheading"><span class="grey--text">ZIP folder name: </span>{{extension['extension_download[0][mask]']}}</p>
                    <p class="subheading"><span class="grey--text">License: </span>{{extension.license}}</p>
                    <p class="subheading"><span class="grey--text">License Period: </span>{{extension.license_period}}</p>
                    <p class="subheading"><span class="grey--text">Tag: </span>{{extension.tag}}</p>
                    <p class="subheading"><span class="grey--text">Publish: </span>{{extension.publish}}</p>
                    <p class="subheading"><span class="grey--text">Notify when new comments are made: </span>{{extension.notify}}</p>
                    <p class="subheading"><span class="grey--text">Send update email to purchasers: </span>{{extension.alert}}</p>
                    <div class="text-xs-center">
                        <p class="title">Image</p>
                        <v-avatar  size="175" tile><img :src="extension.image"></v-avatar>
                    </div>
                    <div class="text-xs-center">
                        <p class="title">Banner</p>
                        <v-avatar  size="175" tile><img :src="extension.banner"></v-avatar>
                    </div>
                </div>

                <div v-else-if="action === 'edit'">
                    <v-layout row wrap justify-space-between>
                        <v-flex md5>
                            <div class="form-elements">
                                <v-text-field v-model="name" class="title" label="Name:" :value="extension.name"></v-text-field>
                            </div>
                            <div class="form-elements">
                                <v-text-field v-model="price" class="title" label="Price:" :placeholder="extension.price"></v-text-field>
                            </div>
                            <div class="form-elements">
                                <v-textarea  v-model="description" label="Description" :placeholder="extension.description"></v-textarea>
                            </div>
                            <div class="form-elements">
                                <v-textarea  v-model="documentation" label="Documentation" :placeholder="extension.documentation"></v-textarea>
                            </div>
                            <div class="form-elements mb-5">
                                <p class="subheading"><span class="grey--text">Compatibility: </span></p>
                                <v-layout row wrap style="overflow: scroll; ">
                                    <v-flex md2 v-for="item in extension.compatibility_list">
                                        <v-checkbox :label="item" v-model="compatibilityMas[item]"></v-checkbox>
                                    </v-flex>
                                </v-layout>
                            </div>
                        </v-flex>
                        <v-flex md5 >
                            <div class="form-elements">
                                <v-select v-model="category" :items="extension.extension_category_list" label="Extension category" :placeholder="extension.extension_category"></v-select>
                            </div>
                            <div class="form-elements">
                                <v-select v-model="license" :items="['Free', 'Paid']" label="License" :placeholder="extension.license"></v-select>
                            </div>
                            <div class="form-elements">
                                <v-select v-model="licensePeriod" :items="extension.license_period_list" label="License period" :placeholder="extension.license_period"></v-select>
                            </div>
                            <div class="form-elements">
                                <v-text-field v-model="tag" class="subheading" label="Tags:" :placeholder="extension.tag"></v-text-field>
                            </div>
                            <div class="form-elements">
                                <v-switch v-model="publish" label="Publish: "></v-switch>
                            </div>
                            <div class="form-elements">
                                <v-switch v-model="notify" label="Notify when new comments are made: "></v-switch>
                            </div>
                            <div class="form-elements">
                                <v-switch v-model="alert" label="Send update email to purchasers: "></v-switch>
                            </div>
                            <!--<div class="text-xs-center">
                                <p class="title">Image</p>
                                <v-avatar  size="175" tile><img :src="extension.image"></v-avatar>
                            </div>
                            <div class="text-xs-center">
                                <p class="title">Banner</p>
                                <v-avatar  size="175" tile><img :src="extension.banner"></v-avatar>
                            </div>-->
                        </v-flex>
                    </v-layout>
                </div>

                <div v-else-if="action === 'delete'">
                    <div>
                        <h3 class="text-xs-center subheading">Are you sure you want to delete this extension?</h3>
                        <h3 class="text-xs-center subheading">Hope you understand what consequences this entails.</h3>
                        <v-layout class="mt-3">
                            <v-flex md8>
                                <v-btn class="red darken-2" dark @click="sendDelete(true)">
                                    <span class="ml-1">Yes, I am</span>
                                </v-btn>
                            </v-flex>
                            <v-flex>
                                <v-btn class="primary" dark @click="sendDelete(false)">
                                    <span class="ml-1">No, I changed my mind</span>
                                </v-btn>
                            </v-flex>
                        </v-layout>

                    </div>
                </div>
            </v-card-text>
            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn class="success" @click="sendEditData()">Send</v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>

    export default {

        name: "Dialog",

        // dialogLookData - data about one_extension
        // action - delete/edit/look/null
        props: ['extension', 'action'],

        data() {
        	  return {
        	  	  name: '',
                price: '',
                description: '',
                documentation: '',
                category: '',
        	  	  compatibilityMas: [],
                license: '',
                licensePeriod: '',
                tag: '',
                notify: false,
                publish: false,
                alert: false,
                compatibilityString: ''
            }
        },

        methods: {
        	  // Send edit data to the parent
        	  sendEditData() {
        	  	  let keys = Object.keys(this.compatibilityMas);
        	  	  let compatibility = [];
        	  	  for (let i = 0; i < keys.length; i++) {
        	  	  	  if (this.compatibilityMas[keys[i]] === true) {
        	  	  	  	  compatibility.push(keys[i])
                    }
                }

        	  	  if (this.name === '') {
        	  	  	  this.name =  this.extension.name;
                }
                if (this.price === '') {
                    this.price =  this.extension.price;
                }
                if (this.description === '') {
                    this.description =  this.extension.description;
                }
                if (this.documentation === '') {
                    this.documentation =  this.extension.documentation;
                }
                if (this.category === '') {
                    this.category =  this.extension.extension_category;
                }
                if (this.license === '') {
                    this.license =  this.extension.license;
                }
                if (this.licensePeriod === '') {
                    this.licensePeriod =  this.extension.license_period;
                }
                if (this.tag === '') {
                    this.tag =  this.extension.tag;
                }
                let data = {
                    'name': this.name,
	                  'price': this.price,
                    'description': this.description,
                    'documentation': this.documentation,
                    'category': this.category,
                    'compatibility': compatibility,
                    'license': this.license,
                    'license_period': this.licensePeriod,
                    'tag': this.tag,
                    'notify': this.notify,
                    'publish': this.publish,
                    'alert': this.alert,
                };
                this.$emit('sendEdit', data);
            },

            // Send delete data to the parent
            sendDelete(status) {
                this.$emit('deleteExtension', status)
            },

            // This.dialogLookData.compatibility_list and extension_category_list -> objects, but we need arrays
            getCompatibilityList() {
	            let compatibility_list = [];
	            for (var key in this.extension.compatibility_list) {
		            compatibility_list.push(this.extension.compatibility_list[key]);
	            }
	            this.extension.compatibility_list = compatibility_list;
            },
            getCategoryList() {
	            let category_list = [];
	            for (var key in this.extension.extension_category_list) {
	              category_list.push(this.extension.extension_category_list[key]);
	            }
	            this.extension.extension_category_list = category_list;
            }
        },

        watch: {

        	  // If dialog look data have changed we need to clean old values and write out new
	        extension: function () {
        	  	  this.getCompatibilityList();
        	  	  this.getCategoryList();
                this.compatibilityMas = [];
                this.compatibilityString = '';
                this.name = '';
                this.price = '';
                this.description = '';
                this.documentation = '';
                this.category = '';
                this.license = '';
                this.licensePeriod = '';
                this.tag = '';
                for (let i = 0; i < this.extension.compatibility.length; i++) {
                    this.compatibilityMas[this.extension.compatibility[i]] = true;
                    this.compatibilityString += '<span class="ml-2">'+ this.extension.compatibility[i] + '</span>; '
                }
        	  	  if (this.action === 'edit') {
                    for (let i = 0; i < this.extension.compatibility.length; i++) {
                      this.compatibilityMas[this.extension.compatibility[i]] = true;
                      this.compatibilityString += '<span class="ml-2">'+ this.extension.compatibility[i] + '</span>; '
                    }

                    if (this.extension.notify === 'Yes') {
                      this.notify = true;
                    }
                    if (this.extension.alert === 'Yes') {
                      this.notify = true;
                    }
                    if (this.extension.alert === 'Yes') {
                      this.notify = true;
                    }
                }


            }

        }

	  }
</script>

<style>
    .form-elements {
        margin-bottom: 20px;
    }
</style>