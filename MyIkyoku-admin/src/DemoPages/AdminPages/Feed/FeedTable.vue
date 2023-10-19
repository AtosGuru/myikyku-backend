<template>
    <div>
        <div class="card-body p-2">
            <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 m-1">
                <v-toolbar flat color="white">
                    <v-toolbar-title>Feed list</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-dialog v-model="dialog" max-width="500px">
                        <template v-slot:activator="{ on }">
                            <v-btn color="primary" dark class="mb-2" @click="selectedFeedActivity">Selected Feed Status Activity</v-btn>
                            <v-btn color="primary" dark class="mb-2" v-on="on">Create new Feed</v-btn>
                        </template>
                        <v-card>
                            <v-card-title>
                                <span class="headline">{{ formTitle }}</span>
                            </v-card-title>

                            <v-card-text>
                                <v-container grid-list-md>
                                    <v-layout wrap>
                                        <v-flex xs12 sm6 md6>
                                            <v-text-field v-model="editedItem.name" label="Name"></v-text-field>
                                        </v-flex>
                                        <v-flex xs12 sm6 md6>
                                            <v-text-field v-model="editedItem.email" label="Email"></v-text-field>
                                        </v-flex>
                                        <v-flex xs12 sm12 md12>
                                            <v-text-field v-model="editedItem.title" label="Title"></v-text-field>
                                        </v-flex>
                                        <v-flex xs12 sm12 md12>
                                            <v-text-field v-model="editedItem.link" label="Link"></v-text-field>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card-text>

                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" flat @click="close">Cancel</v-btn>
                                <v-btn color="blue darken-1" flat @click="save">Save</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>
                <template>
                    <v-form>
                        <v-container>
                            <v-layout row wrap>
                                <v-flex xs12 sm4 md3>
                                    <v-combobox
                                        v-model="search_name"
                                        label="Full Name"
                                        single-line
                                    ></v-combobox>
                                </v-flex>
                                <v-flex xs12 sm4 md3>
                                    <v-text-field
                                        v-model="search_email"
                                        label="Email"
                                        single-line
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs12 sm4 md3>
                                    <v-text-field
                                        v-model="search_title"
                                        label="Title"
                                        single-line
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs12 sm4 md3>
                                    <v-text-field
                                        v-model="search_link"
                                        label="Website Link"
                                        single-line
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-form>
                </template>
                <v-data-table
                    v-model="selected"
                    :headers="headers"
                    :items="desserts"
                    item-key="id"
                    :pagination.sync="pagination"
                    select-all
                    hide-actions
                >
                    <template v-slot:headers="props">
                        <tr>
                            <th>
                                <v-checkbox
                                    :input-value="props.all"
                                    :indeterminate="props.indeterminate"
                                    primary
                                    hide-details
                                    @click.stop="toggleAll"
                                ></v-checkbox>
                            </th>
                            <th
                                v-for="header in props.headers"
                                :key="header.text"
                                :class="[header.class, 'column sortable', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']"
                                @click="changeSort(header.value)"
                            >
                                <v-icon small>arrow_upward</v-icon>
                                {{ header.text }}
                            </th>
                        </tr>
                    </template>
                    <template v-slot:items="props">
                        <tr>
                            <td>
                                <v-checkbox
                                    v-model="props.selected"
                                    primary
                                    hide-details
                                ></v-checkbox>
                            </td>
                            <td hidden>{{props.item.id}}</td>
                            <td class="text-xs-center">{{ props.item.name }}</td>
                            <td class="text-xs-center">{{ props.item.email }}</td>
                            <td class="text-xs-center">{{ props.item.title }}</td>
                            <td class="text-xs-center">{{ props.item.link }}</td>
                            <td class="text-xs-center feed-status">
                                <v-switch
                                    v-model="props.item.status"
                                    color="primary"
                                    hide-details
                                ></v-switch>
                            </td>
                            <td class="text-xs-center feed-actions">
                                <v-icon big class="mr-2" color="blue darken-2" @click="showNewsList(props.item)" >
                                    lnr-eye
                                </v-icon>
                                <v-icon big class="mr-2" color="green darken-2" @click="editItem(props.item)" >
                                    edit
                                </v-icon>
                                <v-icon big class="mr-2" color="red" @click="deleteItem(props.item)" >
                                    delete
                                </v-icon>
                            </td>
                        </tr>
                    </template>
                    <template v-slot:no-data>
                        <v-alert :value="true" color="error" icon="warning">Sorry, nothing to display here :(</v-alert>
                    </template>
                </v-data-table>
                <div class="text-xs-right pt-2">
                    <v-pagination
                        v-model="pagination.page"
                        :length="pages"
                        :total-visible="7"
                    ></v-pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import data from "./feed.json"
    export default {
        data: () => ({
            search_name: '',
            search_email: '',
            search_title: '',
            search_link: '',
            dialog: false,
            pagination: {},
            selected: [],
            headers: [
                { text: 'Name', value: 'name', class: 'text-xs-center feed-name' },
                { text: 'Email', value: 'email', class: 'text-xs-center feed-email' },
                { text: 'Feed title', value: 'title', class: 'text-xs-center feed-title' },
                { text: 'Website link', value: 'link', class: 'text-xs-center feed-link' },
                { text: 'Status', value: 'status', class: 'text-xs-center', sortable: false },
                { text: 'Actions', value: 'action', class: 'text-xs-center', sortable: false }
            ],
            desserts: data,
            editedIndex: -1,
            editedItem: {
            },
            defaultItem: {
            }
        }),
        computed: {
            pages () {
                if (this.pagination.rowsPerPage == null || this.pagination.totalItems == null)
                    return 0;

                return Math.ceil(this.pagination.totalItems / this.pagination.rowsPerPage);
            },

            formTitle () {
                return this.editedIndex === -1 ? 'Create New Feed' : 'Edit Feed'
            }
        },

        watch: {
            dialog (val) {
                val || this.close()
            }
        },

        methods: {
            initialize () {
            },

            editItem (item) {
                this.editedIndex = this.desserts.indexOf(item);
                this.editedItem = Object.assign({}, item);
                this.dialog = true
            },

            deleteItem (item) {
                const index = this.desserts.indexOf(item);
                confirm('Are you sure you want to delete this item?') && this.desserts.splice(index, 1)
            },

            showNewsList(item) {
                if (item.status) {
                    this.$router.push('/feed/' + item.id);
                }
                else {
                    this.$toastr.error('This feed is not allow.', 'Error');
                }
            },

            close () {
                this.dialog = false
                setTimeout(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                }, 300)
            },

            save () {
                if (this.editedIndex > -1) {
                    Object.assign(this.desserts[this.editedIndex], this.editedItem)
                } else {
                    this.desserts.push(this.editedItem)
                }
                this.close()
            },

            selectedFeedActivity() {
                for (let i = 0;i < this.selected.length;i ++) {
                    this.selected[i].status = true;
                }
            },

            toggleAll () {
                if (this.selected.length) {
                    this.selected = [];
                }
                else {
                    this.selected = this.desserts.slice();
                }
            },

            changeSort (column) {
                if (this.pagination.sortBy === column) {
                    this.pagination.descending = !this.pagination.descending;
                } else {
                    this.pagination.sortBy = column;
                    this.pagination.descending = false;
                }
            }
        }
    }
</script>


<style>
    .feed-name {
        width: 15%;
    }
    .feed-email {
        width: 15%;
    }
    .feed-title {
        width: 20%;
    }
    .feed-link {
        width: 30%;
    }
    .feed-status {
        width: 5%;
    }
    .feed-actions {
        width: 10%;
    }
</style>