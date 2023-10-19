<template>
    <div>
        <div class="card-body p-2">
            <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 m-1">
                <v-toolbar flat color="white">
                    <v-toolbar-title>Article list</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-dialog v-model="dialog" max-width="750px">
                        <template v-slot:activator="{ on }">
                            <v-btn color="primary" dark class="mb-2" @click="selectedArticleRelease">Release</v-btn>
                            <v-btn color="primary" dark class="mb-2" @click="selectedArticleClose">Close</v-btn>
                            <v-btn color="primary" dark class="mb-2" v-on="on">Create new Article</v-btn>
                        </template>
                        <v-card>
                            <v-card-title>
                                <span class="headline">{{ formTitle }}</span>
                            </v-card-title>

                            <v-card-text>
                                <v-container grid-list-md>
                                    <v-layout wrap>
                                        <v-flex xs12 sm12 md12>
                                            <v-text-field v-model="editedItem.title" label="Title"></v-text-field>
                                        </v-flex>
                                        <v-flex xs12 sm12 md12>
                                            <v-textarea v-model="editedItem.thumbnail" label="Thumbnail"></v-textarea>
                                        </v-flex>
                                        <v-flex xs12 sm6 md6>
                                            <v-text-field v-model="editedItem.pub_date" label="Public Date" disabled=""></v-text-field>
                                        </v-flex>
                                        <v-flex xs12 sm6 md6>
                                            <v-text-field v-model="editedItem.category" label="Category"></v-text-field>
                                        </v-flex>
                                        <v-flex xs12 sm12 md12>
                                            <v-textarea v-model="editedItem.content" label="Content"></v-textarea>
                                        </v-flex>
                                        <v-flex xs12 sm12 md12>
                                            <v-text-field v-model="editedItem.copyright" label="Copyright"></v-text-field>
                                        </v-flex>
                                        <v-flex xs12 sm12 md12>
                                            <v-text-field v-model="editedItem.link" label="Copyright Link"></v-text-field>
                                        </v-flex>
                                        <v-flex xs12 sm4 md4>

                                        </v-flex>
                                        <v-flex xs12 sm4 md4>
                                            <v-menu
                                                ref="date1"
                                                v-model="date1"
                                                :close-on-content-click="false"
                                                :nudge-right="40"
                                                :return-value.sync="date1"
                                                lazy
                                                transition="scale-transition"
                                                offset-y
                                                full-width
                                                min-width="290px"
                                            >
                                                <template v-slot:activator="{ on }">
                                                    <v-text-field
                                                        v-model="editedItem.release_date"
                                                        label="Release Date"
                                                        prepend-icon="event"
                                                        readonly
                                                        v-on="on"
                                                    ></v-text-field>
                                                </template>
                                                <v-date-picker v-model="editedItem.release_date" no-title scrollable>
                                                    <v-spacer></v-spacer>
                                                    <v-btn flat color="primary" @click="date1 = false">Cancel</v-btn>
                                                    <v-btn flat color="primary" @click="$refs.date1.save(date1)">OK</v-btn>
                                                </v-date-picker>
                                            </v-menu>
                                        </v-flex>
                                        <v-flex xs12 sm4 md4>
                                            <v-menu
                                                ref="date2"
                                                v-model="date2"
                                                :close-on-content-click="false"
                                                :nudge-right="40"
                                                :return-value.sync="date2"
                                                lazy
                                                transition="scale-transition"
                                                offset-y
                                                full-width
                                                min-width="290px"
                                            >
                                                <template v-slot:activator="{ on }">
                                                    <v-text-field
                                                        v-model="editedItem.close_date"
                                                        label="Close Date"
                                                        prepend-icon="event"
                                                        readonly
                                                        v-on="on"
                                                    ></v-text-field>
                                                </template>
                                                <v-date-picker v-model="editedItem.close_date" no-title scrollable>
                                                    <v-spacer></v-spacer>
                                                    <v-btn flat color="primary" @click="date2 = false">Cancel</v-btn>
                                                    <v-btn flat color="primary" @click="$refs.date2.save(date2)">OK</v-btn>
                                                </v-date-picker>
                                            </v-menu>
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
                        <v-container fluid>
                            <v-layout row wrap>
                                <v-flex xs6 sm4 md2>
                                    <v-text-field
                                        label="Title"
                                        single-line
                                        @input="filterTitle"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs6 sm4 md2>
                                    <v-text-field
                                        label="Category"
                                        single-line
                                        @input="filterCategory"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs6 sm4 md2>
                                    <v-select
                                        :items="status"
                                        label="Status"
                                        @change="filterStatus"
                                    ></v-select>
                                </v-flex>
                                <v-flex xs6 sm4 md2>
                                    <v-menu
                                        ref="show_start_date"
                                        :close-on-content-click="false"
                                        v-model="show_start_date"
                                        :nudge-right="40"
                                        :return-value.sync="start_date"
                                        lazy
                                        transition="scale-transition"
                                        offset-y
                                        full-width
                                        min-width="290px"
                                    >
                                        <v-text-field
                                            slot="activator"
                                            v-model="start_date"
                                            label="From"
                                            prepend-icon="event"
                                        ></v-text-field>
                                        <v-date-picker v-model="start_date" no-title @input="filterStartDate">
                                        </v-date-picker>
                                    </v-menu>
                                </v-flex>
                                <v-flex xs6 sm4 md2>
                                    <v-menu
                                        ref="show_end_date"
                                        :close-on-content-click="false"
                                        v-model="show_end_date"
                                        :nudge-right="40"
                                        :return-value.sync="end_date"
                                        lazy
                                        transition="scale-transition"
                                        offset-y
                                        full-width
                                        min-width="290px"
                                    >
                                        <v-text-field
                                            slot="activator"
                                            v-model="end_date"
                                            label="To"
                                            prepend-icon="event"
                                        ></v-text-field>
                                        <v-date-picker v-model="end_date" no-title @input="filterEndDate">
                                        </v-date-picker>
                                    </v-menu>
                                </v-flex>
                                <v-flex xs6 sm4 md2>
                                    <v-btn class="ma-2" outline color="primary">
                                        <v-icon left>pe-7s-search</v-icon> Search
                                    </v-btn>
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
                    :search="filters"
                    :custom-filter="customFilter"
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
                                :class="[header.class + ' column sortable', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']"
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
                            <td class="text-xs-center text-title">{{ props.item.title | truncate(15, '...')}}</td>
                            <td class="text-xs-center text-thumbnail">{{ props.item.thumbnail | truncate(15, '...') }}</td>
                            <td class="text-xs-center text-pub-date">{{ props.item.pub_date }}</td>
                            <td class="text-xs-center text-category">{{ props.item.category }}</td>
                            <td class="text-xs-center text-content">{{ props.item.content | truncate(15, '...') }}</td>
                            <td class="text-xs-center text-copyright">{{ props.item.copyright | truncate(30, '...') }}</td>
                            <td class="text-xs-center text-link">{{ props.item.link }}</td>
                            <td class="text-xs-center text-release-date">{{ props.item.release_date }}</td>
                            <td class="text-xs-center text-close-date">{{ props.item.close_date }}</td>
                            <td class="text-xs-center">
                                <v-chip :color="getColor(props.item.status)" dark>{{ props.item.status }}</v-chip>
                            </td>
                            <td class="text-xs-center">
                                <v-icon big class="mr-2" color="green darken-2" @click="editItem(props.item)" >
                                    edit
                                </v-icon>
                                <v-icon big class="mr-2" color="red" @click="deleteItem(props.item)" >
                                    delete
                                </v-icon>
                            </td>
                        </tr>
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
    import data from "./articles.json"
    export default {
        data: () => ({
            show_start_date: false,
            start_date: null,
            show_end_date: false,
            end_date: null,
            filters: {
                title: '',
                category: '',
                status: '',
                start_date: null,
                end_date: null,
            },
            date1: '',
            date2: '',
            status: ['ALL', 'Draft', 'Release', 'Close'],
            dialog: false,
            pagination: {},
            selected: [],
            headers: [
                { text: 'Title', value: 'title', class: 'text-xs-center text-title' },
                { text: 'Thumbnail', value: 'thumbnail', class: 'text-xs-center text-thumbnail' },
                { text: 'Public Date', value: 'pub_date', class: 'text-xs-center text-pub-date' },
                { text: 'Category', value: 'category', class: 'text-xs-center text-category' },
                { text: 'Content', value: 'content', class: 'text-xs-center text-content' },
                { text: 'Copyright', value: 'copyright', class: 'text-xs-center text-copyright' },
                { text: 'Copyright Link', value: 'link', class: 'text-xs-center text-link' },
                { text: 'Release Date', value: 'release_date', class: 'text-xs-center text-release-date' },
                { text: 'Close Date', value: 'close_date', class: 'text-xs-center text-close-date' },
                { text: 'Status', value: 'status', class: 'text-xs-center', sortable: false, },
                { text: 'Actions', value: 'action', class: 'text-xs-center', sortable: false, }
            ],
            desserts: data,
            editedIndex: -1,
            editedItem: {
                title: '',
                thumbnail: '',
                pub_date: '',
                category: '',
                content: '',
                copyright: '',
                link: '',
                release_date: '',
                close_date: '',
                status: false,
            },
            defaultItem: {
                title: '12',
                thumbnail: '',
                pub_date: new Date().toISOString().substr(0, 10),
                category: '',
                content: '',
                copyright: '',
                link: '',
                release_date: '',
                close_date: '',
                status: false,
            }
        }),

        computed: {
            pages () {
                if (this.pagination.rowsPerPage == null || this.pagination.totalItems == null)
                    return 0;

                return Math.ceil(this.pagination.totalItems / this.pagination.rowsPerPage);
            },

            formTitle () {
                return this.editedIndex === -1 ? 'Create New Article' : 'Edit Article'
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

            getColor (status) {
                if (status == 'Draft') {
                    return 'grey';
                }
                else if (status == 'Release') {
                    return 'green';
                }
                else {
                    return 'red';
                }
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

            selectedArticleRelease() {
                for (let i = 0;i < this.selected.length;i ++) {
                    if (this.selected[i].status != 'Release') {
                        this.selected[i].status = 'Release';
                        this.selected[i].release_date = new Date().toISOString().substr(0, 10);
                    }
                }
            },

            selectedArticleClose() {
                for (let i = 0;i < this.selected.length;i ++) {
                    if (this.selected[i].status != 'Close') {
                        this.selected[i].status = 'Close';
                        this.selected[i].close_date = new Date().toISOString().substr(0, 10);
                    }
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
            },

            customFilter(items, filters, filter, headers) {
                const cf = new this.$MultiFilters(items, filters, filter, headers);

                cf.registerFilter('title', function (title, items) {
                    if (title.trim() === '') return items;
                    return items.filter(item => {
                        return item.title.toLowerCase().includes(title.toLowerCase());
                    }, title);
                });

                cf.registerFilter('category', function (category, items) {
                    if (category.trim() === '') return items;
                    return items.filter(item => {
                        return item.category.toLowerCase() === category.toLowerCase();
                    }, category);
                });

                cf.registerFilter('status', function (status, items) {
                    if (status.trim() === '' || status == 'ALL' ) return items;
                    return items.filter(item => {
                        return item.status.toLowerCase() === status.toLowerCase();
                    }, status);
                });

                cf.registerFilter('start_date', function (start_date, items) {
                    if (start_date === null || start_date === '') return items;
                    return items.filter(item => {
                        return item.release_date >= start_date;
                    }, start_date);
                });

                cf.registerFilter('end_date', function (end_date, items) {
                    if (end_date === null || end_date === '') return items;
                    return items.filter(item => {
                        return item.release_date <= end_date;
                    }, end_date);
                });

                return cf.runFilters();
            },

            filterTitle(val) {
                this.filters = this.$MultiFilters.updateFilters(this.filters, {title: val});
            },

            filterCategory(val) {
                this.filters = this.$MultiFilters.updateFilters(this.filters, {category: val});
            },

            filterStatus(val) {
                this.filters = this.$MultiFilters.updateFilters(this.filters, {status: val});
            },

            filterStartDate(val) {
                // Close the date picker.
                this.$refs.show_start_date.save(val);
                //Convert the value to a timestamp before saving it.
                const timestamp = new Date(val + 'T00:00:00Z').getTime();
                this.filters = this.$MultiFilters.updateFilters(this.filters, {start_date: timestamp});
            },

            filterEndDate(val) {
                // Close the date picker.
                this.$refs.show_end_date.save(val);
                //Convert the value to a timestamp before saving it.
                const timestamp = new Date(val + 'T00:00:00Z').getTime();
                this.filters = this.$MultiFilters.updateFilters(this.filters, {end_date: timestamp});
            },
        }
    }
</script>

<style>
    .text-title {
        width: 10%;
        padding: 0 8px!important;
    }
    .text-thumbnail {
        width: 10%;
        padding: 0 8px!important;
    }
    .text-pub-date {
        width: 10%;
        padding: 0 8px!important;
    }
    .text-category {
        width: 10%;
        padding: 0 8px!important;
    }
    .text-content {
        width: 20%;
        padding: 0 8px!important;
    }
    .text-copyright {
        width: 10%;
        padding: 0 8px!important;
    }
    .text-link {
        width: 10%;
        padding: 0 8px!important;
    }
    .text-release-date {
        width: 10%;
        padding: 0 8px!important;
    }
    .text-close-date {
        width: 10%;
        padding: 0 8px!important;
    }
</style>