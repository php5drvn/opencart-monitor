<template>
    <nav>
        <v-toolbar flat app class="grey lighten-2">
            <v-toolbar-side-icon @click="drawer = !drawer" class="green--text"></v-toolbar-side-icon>
            <v-toolbar-title class="text-uppercase green--text">
                <span class="font-weight-light">Opencart</span>
                <span>Monitor</span>
            </v-toolbar-title>
            <v-spacer></v-spacer>

            <!-- dropdown menu -->
            <!--<v-menu offset-y>
                <v-btn flat slot="activator" color="green">
                    <v-icon left>expand_more</v-icon>
                    <span>Menu</span>
                </v-btn>
                <v-list>
                    <v-list-tile style="cursor: pointer;" @click="getAllExtensions">
                        <v-list-tile-title>Get all extensions</v-list-tile-title>
                    </v-list-tile>
                </v-list>
            </v-menu>
-->
            <v-btn flat color="green" @click="send('')">
                <v-icon left>autorenew</v-icon>
                <span>Refresh extensions</span>
            </v-btn>
            <v-btn flat color="green" @click="send('addExtension')">
                <v-icon left>add</v-icon>
                <span>Add new extension</span>
            </v-btn>
            <v-btn flat color="green" @click="send('getAllExtensions')">
                <v-icon left>list</v-icon>
                <span>Get all extensions</span>
            </v-btn>
        </v-toolbar>

        <v-navigation-drawer app v-model="drawer" class="green">
            <v-list>
                <!--<v-list-tile v-for="link in links" :key="link.text" router :to="link.route">
                    <v-list-tile-action>
                        <v-icon class="white&#45;&#45;text">{{ link.icon }}</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title class="white&#45;&#45;text">{{ link.text }}</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>-->
            </v-list>
        </v-navigation-drawer>

    </nav>
</template>

<script>
    export default {

        name: "Navbar",

        data() {
            return {

            	// Show <v-navigator-drawer> or not
              drawer: false,

            }
        },

        methods: {

        	  // Catch click on the toolbar item and send it to the App.vue
            send(type) {
                this.$emit(type)
            },
        }

	  };
</script>

<style scoped>

</style>