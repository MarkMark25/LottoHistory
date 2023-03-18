<template>
  <v-data-table
    :headers="headers"
    :items="list"
    sort-by="draw_date"
    :search="search"
    class="elevation-1"
  >
    <template v-slot:[`item.draw_date`]="{ item }">
      {{ dateFormat(item.draw_date) }}
    </template>
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title>Lotto Max History</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
        ></v-text-field>
        <v-spacer></v-spacer>
        <!-- Create New -->

        <v-dialog
          v-model="dialog"
          max-width="1000px"
          persistent
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              color="primary"
              dark
              class="mb-2"
              v-bind="attrs"
              v-on="on"
            >
              Add New
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
                <span class="font-italic">(All fields are required unless specified optional)</span>
              <v-container>
                <v-row>
                    <v-col cols="12" sm="12" md="6" lg="6" xl="6">
                        <v-dialog
                            ref="dialog"
                            v-model="modal"
                            :return-value.sync="editedItem.draw_date"
                            persistent
                            width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                                v-model="editedItem.draw_date"
                                label="Draw Date"
                                prepend-icon="mdi-calendar"
                                readonly
                                v-bind="attrs"
                                v-on="on"
                                @click="err_form.draw_date = ''"
                            ></v-text-field>
                            <small class="text-danger" v-text="err_form.draw_date"></small>
                            </template>
                            <v-date-picker
                            v-model="date"
                            scrollable
                            >
                            <v-spacer></v-spacer>
                            <v-btn
                                text
                                color="primary"
                                @click="modal = false"
                            >
                                Cancel
                            </v-btn>
                            <v-btn
                                text
                                color="primary"
                                @click="$refs.dialog.save(date)"
                            >
                                OK
                            </v-btn>
                            </v-date-picker>
                        </v-dialog>
                    </v-col>
                </v-row>
                <v-row>
                    <h4>Lotto Max Winning Numbers</h4>
                    <v-col cols="6" sm="3" md="3" lg="3" xl="3">
                        <v-text-field
                            label="First"
                            type="number"
                            step="any"
                            min="0"
                            ref="input"
                            :rules="[numberRule]"
                            v-model.number="editedItem.winning_number_1"
                            @keydown="err_form.winning_number_1 = ''"
                            @click="err_form.winning_number_1 = ''"
                            >
                        </v-text-field>
                        <small class="text-danger" v-text="err_form.winning_number_1"></small>
                    </v-col>
                    <v-col cols="6" sm="3" md="3" lg="3" xl="3">
                        <v-text-field
                            label="Second"
                            type="number"
                            step="any"
                            min="0"
                            ref="input"
                            :rules="[numberRule]"
                            v-model.number="editedItem.winning_number_2"
                            @keydown="err_form.winning_number_2 = ''"
                            @click="err_form.winning_number_2 = ''"
                            >
                        </v-text-field>
                        <small class="text-danger" v-text="err_form.winning_number_2"></small>
                    </v-col>
                    <v-col cols="6" sm="3" md="3" lg="3" xl="3">
                        <v-text-field
                            label="Third"
                            type="number"
                            step="any"
                            min="0"
                            ref="input"
                            :rules="[numberRule]"
                            v-model.number="editedItem.winning_number_3"
                            @keydown="err_form.winning_number_3 = ''"
                            @click="err_form.winning_number_3 = ''"
                            >
                        </v-text-field>
                        <small class="text-danger" v-text="err_form.winning_number_3"></small>
                    </v-col>
                    <v-col cols="6" sm="3" md="3" lg="3" xl="3">
                        <v-text-field
                            label="Fourth"
                            type="number"
                            step="any"
                            min="0"
                            ref="input"
                            :rules="[numberRule]"
                            v-model.number="editedItem.winning_number_4"
                            @keydown="err_form.winning_number_4 = ''"
                            @click="err_form.winning_number_4 = ''"
                            >
                        </v-text-field>
                        <small class="text-danger" v-text="err_form.winning_number_4"></small>
                    </v-col>
                    <v-col cols="6" sm="3" md="3" lg="3" xl="3">
                        <v-text-field
                            label="Fifth"
                            type="number"
                            step="any"
                            min="0"
                            ref="input"
                            :rules="[numberRule]"
                            v-model.number="editedItem.winning_number_5"
                            @keydown="err_form.winning_number_5 = ''"
                            @click="err_form.winning_number_5 = ''"
                            >
                        </v-text-field>
                        <small class="text-danger" v-text="err_form.winning_number_5"></small>
                    </v-col>
                    <v-col cols="6" sm="3" md="3" lg="3" xl="3">
                        <v-text-field
                            label="Sixth"
                            type="number"
                            step="any"
                            min="0"
                            ref="input"
                            :rules="[numberRule]"
                            v-model.number="editedItem.winning_number_6"
                            @keydown="err_form.winning_number_6 = ''"
                            @click="err_form.winning_number_6 = ''"
                            >
                        </v-text-field>
                        <small class="text-danger" v-text="err_form.winning_number_6"></small>
                    </v-col>
                    <v-col cols="6" sm="3" md="3" lg="3" xl="3">
                        <v-text-field
                            label="Seventh"
                            type="number"
                            step="any"
                            min="0"
                            ref="input"
                            :rules="[numberRule]"
                            v-model.number="editedItem.winning_number_7"
                            @keydown="err_form.winning_number_7 = ''"
                            @click="err_form.winning_number_7 = ''"
                            >
                        </v-text-field>
                        <small class="text-danger" v-text="err_form.winning_number_7"></small>
                    </v-col>
                    <v-col cols="6" sm="3" md="3" lg="3" xl="3">
                        <v-text-field
                            label="Bonus"
                            type="number"
                            step="any"
                            min="0"
                            ref="input"
                            :rules="[numberRule]"
                            v-model.number="editedItem.winning_number_bonus"
                            @keydown="err_form.winning_number_bonus = ''"
                            @click="err_form.winning_number_bonus = ''"
                            >
                        </v-text-field>
                        <small class="text-danger" v-text="err_form.winning_number_bonus"></small>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="6">
                         <v-text-field
                            v-model="editedItem.extra"
                            label="Extra Number"
                            @keydown="err_form.extra = ''"
                            @click="err_form.extra = ''"
                            dense
                            placeholder="0000000"
                            :maxlength="extra_num_max"
                        ></v-text-field>
                        <small class="text-danger" v-text="err_form.extra"></small>
                    </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                color="blue darken-1"
                text
                @click="close"
              >
                Cancel
              </v-btn>
              <v-btn
                color="blue darken-1"
                text
                @click="save"
              >
                Submit
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>

        <v-spacer></v-spacer>
        <!-- Update Information -->

        <v-dialog
          v-model="updateDialog"
          max-width="1000px"
          persistent
        >
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
                <span class="font-italic">(All fields are required unless specified optional)</span>
             <v-container>
                <v-row>
                    <v-col cols="12" sm="12" md="6" lg="6" xl="6">
                        <v-dialog
                            ref="dialog"
                            v-model="modal"
                            :return-value.sync="editedItem.draw_date"
                            persistent
                            width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                                v-model="editedItem.draw_date"
                                label="Draw Date"
                                prepend-icon="mdi-calendar"
                                readonly
                                v-bind="attrs"
                                v-on="on"
                                @click="err_form.draw_date = ''"
                            ></v-text-field>
                            <small class="text-danger" v-text="err_form.draw_date"></small>
                            </template>
                            <v-date-picker
                            v-model="date"
                            scrollable
                            >
                            <v-spacer></v-spacer>
                            <v-btn
                                text
                                color="primary"
                                @click="modal = false"
                            >
                                Cancel
                            </v-btn>
                            <v-btn
                                text
                                color="primary"
                                @click="$refs.dialog.save(date)"
                            >
                                OK
                            </v-btn>
                            </v-date-picker>
                        </v-dialog>
                    </v-col>
                </v-row>
                <v-row>
                    <h4>Lotto Max Winning Numbers</h4>
                    <v-col cols="6" sm="3" md="3" lg="3" xl="3">
                        <v-text-field
                            label="First"
                            type="number"
                            step="any"
                            min="0"
                            ref="input"
                            :rules="[numberRule]"
                            v-model.number="editedItem.winning_number_1"
                            @keydown="err_form.winning_number_1 = ''"
                            @click="err_form.winning_number_1 = ''"
                            >
                        </v-text-field>
                        <small class="text-danger" v-text="err_form.winning_number_1"></small>
                    </v-col>
                    <v-col cols="6" sm="3" md="3" lg="3" xl="3">
                        <v-text-field
                            label="Second"
                            type="number"
                            step="any"
                            min="0"
                            ref="input"
                            :rules="[numberRule]"
                            v-model.number="editedItem.winning_number_2"
                            @keydown="err_form.winning_number_2 = ''"
                            @click="err_form.winning_number_2 = ''"
                            >
                        </v-text-field>
                        <small class="text-danger" v-text="err_form.winning_number_2"></small>
                    </v-col>
                    <v-col cols="6" sm="3" md="3" lg="3" xl="3">
                        <v-text-field
                            label="Third"
                            type="number"
                            step="any"
                            min="0"
                            ref="input"
                            :rules="[numberRule]"
                            v-model.number="editedItem.winning_number_3"
                            @keydown="err_form.winning_number_3 = ''"
                            @click="err_form.winning_number_3 = ''"
                            >
                        </v-text-field>
                        <small class="text-danger" v-text="err_form.winning_number_3"></small>
                    </v-col>
                    <v-col cols="6" sm="3" md="3" lg="3" xl="3">
                        <v-text-field
                            label="Fourth"
                            type="number"
                            step="any"
                            min="0"
                            ref="input"
                            :rules="[numberRule]"
                            v-model.number="editedItem.winning_number_4"
                            @keydown="err_form.winning_number_4 = ''"
                            @click="err_form.winning_number_4 = ''"
                            >
                        </v-text-field>
                        <small class="text-danger" v-text="err_form.winning_number_4"></small>
                    </v-col>
                    <v-col cols="6" sm="3" md="3" lg="3" xl="3">
                        <v-text-field
                            label="Fifth"
                            type="number"
                            step="any"
                            min="0"
                            ref="input"
                            :rules="[numberRule]"
                            v-model.number="editedItem.winning_number_5"
                            @keydown="err_form.winning_number_5 = ''"
                            @click="err_form.winning_number_5 = ''"
                            >
                        </v-text-field>
                        <small class="text-danger" v-text="err_form.winning_number_5"></small>
                    </v-col>
                    <v-col cols="6" sm="3" md="3" lg="3" xl="3">
                        <v-text-field
                            label="Sixth"
                            type="number"
                            step="any"
                            min="0"
                            ref="input"
                            :rules="[numberRule]"
                            v-model.number="editedItem.winning_number_6"
                            @keydown="err_form.winning_number_6 = ''"
                            @click="err_form.winning_number_6 = ''"
                            >
                        </v-text-field>
                        <small class="text-danger" v-text="err_form.winning_number_6"></small>
                    </v-col>
                    <v-col cols="6" sm="3" md="3" lg="3" xl="3">
                        <v-text-field
                            label="Seventh"
                            type="number"
                            step="any"
                            min="0"
                            ref="input"
                            :rules="[numberRule]"
                            v-model.number="editedItem.winning_number_7"
                            @keydown="err_form.winning_number_7 = ''"
                            @click="err_form.winning_number_7 = ''"
                            >
                        </v-text-field>
                        <small class="text-danger" v-text="err_form.winning_number_7"></small>
                    </v-col>
                    <v-col cols="6" sm="3" md="3" lg="3" xl="3">
                        <v-text-field
                            label="Bonus"
                            type="number"
                            step="any"
                            min="0"
                            ref="input"
                            :rules="[numberRule]"
                            v-model.number="editedItem.winning_number_bonus"
                            @keydown="err_form.winning_number_bonus = ''"
                            @click="err_form.winning_number_bonus = ''"
                            >
                        </v-text-field>
                        <small class="text-danger" v-text="err_form.winning_number_bonus"></small>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="6">
                         <v-text-field
                            v-model="editedItem.extra"
                            label="Extra Number"
                            @keydown="err_form.extra = ''"
                            @click="err_form.extra = ''"
                            dense
                            placeholder="0000000"
                            :maxlength="extra_num_max"
                        ></v-text-field>
                        <small class="text-danger" v-text="err_form.extra"></small>
                    </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-btn
                color="success darken-1"
                text
                @click="clear"
                v-if="err != 0"
              >
                Clear Error Message
              </v-btn>
              <v-spacer></v-spacer>
              <v-btn
                color="blue darken-1"
                text
                @click="updateClose"
              >
                Cancel
              </v-btn>
              <v-btn
                color="blue darken-1"
                text
                @click="save"
              >
                Save Changes
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>

        <v-spacer></v-spacer>
        <!-- Delete Information -->
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card >
            <v-card-title ><h3>Whoa, there!</h3></v-card-title>
            <v-card-text>
                <p>
                    <b>
                        Once you delete this item, there's no way getting it back.
                        <br/>
                        Make sure you want to do this.
                    </b>
                </p>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
              <v-btn color="#fc6c71" text @click="deleteItemConfirm">Proceed</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <!-- Actions -->
    <template v-slot:[`item.actions`]="{ item }">
      <v-icon
        small
        class="mr-2"
        @click="editItem(item)"

      >
        mdi-pencil
      </v-icon>
      <v-icon
        small
        @click="deleteItem(item)"

      >
        mdi-delete
      </v-icon>
    </template>
    <!-- Winning Number -->
    <template v-slot:[`item.winning_number`]="{ item }">
        <v-btn
            class="mx-2"
            fab
            x-small
        >
            <span>{{item.winning_number_1}}</span>
        </v-btn>
        <v-btn
            class="mx-2"
            fab
            x-small
        >
            <span>{{item.winning_number_2}}</span>
        </v-btn>
        <v-btn
            class="mx-2"
            fab
            x-small
        >
            <span>{{item.winning_number_3}}</span>
        </v-btn>
        <v-btn
            class="mx-2"
            fab
            x-small
        >
            <span>{{item.winning_number_4}}</span>
        </v-btn>
        <v-btn
            class="mx-2"
            fab
            x-small
        >
            <span>{{item.winning_number_5}}</span>
        </v-btn>
        <v-btn
            class="mx-2"
            fab
            x-small
        >
            <span>{{item.winning_number_6}}</span>
        </v-btn>
        <v-btn
            class="mx-2"
            fab
            x-small
        >
            <span>{{item.winning_number_7}}</span>
        </v-btn>
        <v-btn
            class="mx-2"
            fab
            x-small
            color="warning"
        >
            <span>{{item.winning_number_bonus}}</span>
        </v-btn>
    </template>
    <!-- Uncomment this if you want to display it in a non circle form. -->
    <!-- <template v-slot:[`item.winning_number`]="{ item }">
        {{item.winning_number_1+' '+item.winning_number_2+' '+item.winning_number_3+' '+item.winning_number_4+' '+item.winning_number_5+' '+item.winning_number_6+' '+item.winning_number_7}}
        <span class="font-weight-bold">{{item.winning_number_bonus}}</span>
    </template> -->
  </v-data-table>
</template>
<script>
    import moment from 'moment';
  export default {
      props: ['lotto_max'],
      components: {},
    data: () => ({
        search: '',
        dialog: false,
        updateDialog: false,
        dialogDelete: false,
        headers: [
            {
            text: 'Date',
            align: 'start',
            sortable: true,
            value: 'draw_date',
            },
            { text: 'Winning Number', value: 'winning_number'},
            { text: 'Extra', value: 'extra'},
            { text: 'Actions', value: 'actions', sortable: false },

        ],
        list: [],
        editedIndex: -1,
        store_id: '',
        editedItem: {
            id_string: '',
            draw_date: '',
            winning_number_1: '',
            winning_number_2: '',
            winning_number_3: '',
            winning_number_4: '',
            winning_number_5: '',
            winning_number_6: '',
            winning_number_7: '',
            winning_number_bonus: '',
            extra: '',
        },
        defaultItem: {
            id_string: '',
            draw_date: '',
            winning_number_1: '',
            winning_number_2: '',
            winning_number_3: '',
            winning_number_4: '',
            winning_number_5: '',
            winning_number_6: '',
            winning_number_7: '',
            winning_number_bonus: '',
            extra: '',
        },
        err: [],
        err_form: {
            draw_date: '',
            winning_number_1: '',
            winning_number_2: '',
            winning_number_3: '',
            winning_number_4: '',
            winning_number_5: '',
            winning_number_6: '',
            winning_number_7: '',
            winning_number_bonus: '',
            extra: '',
        },

        date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
        modal: false,
        // Number role for number fields
        numberRule: val => {
            if(val < 0) return 'Please enter a positive number'
            return true
        },
        extra_num_max: 7,
    }),

    computed: {
        formTitle () {
            return this.editedIndex === -1 ? 'Create New Information' : 'Update Information'
        },
    },

    watch: {
        dialog (val) {
            val || this.close()
        },
        dialogDelete (val) {
            val || this.closeDelete()
        },
        updateDialog (val) {
            val || this.updateClose()
        },
    },

    created () {
        this.initialize();
    },

    methods: {
        dateFormat(d){
            return moment(d, 'YYYY-MM-DD').format('MMMM DD YYYY');
        },

        initialize(){
            this.list = this.lotto_max;
        },

        editItem (item) {
            this.clear();
            this.editedIndex = this.list.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.updateDialog = true;
        },

        deleteItem (item) {
            this.clear();
            this.editedIndex = this.list.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialogDelete = true;
        },
        deleteItemConfirm () {
            this.axios.patch('/lotto/history/lotto-max/destroy/'+this.editedItem.id_string, this.editedItem)
                .then((response)=>{
                    this.list.splice(this.editedIndex, 1);
                    Vue.$toast.open({
                        message: response.data.success,
                        type: 'success',
                        position: 'top',
                        duration: 5000,
                    });
                    location.reload(true);
                });
                //In future updates maybe the catch phrase is needed.
            this.closeDelete();
        },

        close () {
            this.clear();
            this.dialog = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },

        closeDelete () {
            this.dialogDelete = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            })
        },

        updateClose () {
            this.clear();
            this.updateDialog = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            });
        },

        validate(){
            this.err = [];
            /** Start - Field is required */
            if(!this.editedItem.draw_date){
                this.err.push('0');
                this.err_form.draw_date= 'Field is required.';
            }
            //1st
            if(!this.editedItem.winning_number_1){
                this.err.push('0');
                this.err_form.winning_number_1= 'Field is required.';
            }/** Start - Maximum number is 50 */
            else if(this.editedItem.winning_number_1 <= 0 || this.editedItem.winning_number_1 > 50){
                this.err.push('0');
                this.err_form.winning_number_1= 'Choose number from 1-50.';
            }/** Start - Validation if number is repeated */
            else if(this.editedItem.winning_number_1 == this.editedItem.winning_number_2
                    || this.editedItem.winning_number_1 == this.editedItem.winning_number_3
                    || this.editedItem.winning_number_1 == this.editedItem.winning_number_4
                    || this.editedItem.winning_number_1 == this.editedItem.winning_number_5
                    || this.editedItem.winning_number_1 == this.editedItem.winning_number_6
                    || this.editedItem.winning_number_1 == this.editedItem.winning_number_7
                    || this.editedItem.winning_number_1 == this.editedItem.winning_number_bonus
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_1= 'Number cannot be repeated';
            }/** Start - 1st number is not greater than 2nd to 7th */
            else if(this.editedItem.winning_number_1 >= this.editedItem.winning_number_2
                    || this.editedItem.winning_number_1 >= this.editedItem.winning_number_3
                    || this.editedItem.winning_number_1 >= this.editedItem.winning_number_4
                    || this.editedItem.winning_number_1 >= this.editedItem.winning_number_5
                    || this.editedItem.winning_number_1 >= this.editedItem.winning_number_6
                    || this.editedItem.winning_number_1 >= this.editedItem.winning_number_7
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_1= 'Invalid number';
            }//1st
            //2nd
            if(!this.editedItem.winning_number_2){
                this.err.push('0');
                this.err_form.winning_number_2= 'Field is required.';
            }else if(this.editedItem.winning_number_2 <= 0 || this.editedItem.winning_number_2 > 50){
                this.err.push('0');
                this.err_form.winning_number_2= 'Choose number from 1-50.';
            }/** Start - Validation if number is repeated */
            else if(this.editedItem.winning_number_2 == this.editedItem.winning_number_1
                    || this.editedItem.winning_number_2 == this.editedItem.winning_number_3
                    || this.editedItem.winning_number_2 == this.editedItem.winning_number_4
                    || this.editedItem.winning_number_2 == this.editedItem.winning_number_5
                    || this.editedItem.winning_number_2 == this.editedItem.winning_number_6
                    || this.editedItem.winning_number_2 == this.editedItem.winning_number_7
                    || this.editedItem.winning_number_2 == this.editedItem.winning_number_bonus
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_2= 'Number cannot be repeated';
            }/** Start - 2nd number is not greater than 3rd to 7th */
            else if(this.editedItem.winning_number_2 >= this.editedItem.winning_number_3
                    || this.editedItem.winning_number_2 >= this.editedItem.winning_number_4
                    || this.editedItem.winning_number_2 >= this.editedItem.winning_number_5
                    || this.editedItem.winning_number_2 >= this.editedItem.winning_number_6
                    || this.editedItem.winning_number_2 >= this.editedItem.winning_number_7
                    || this.editedItem.winning_number_2 <= this.editedItem.winning_number_1
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_2= 'Invalid number';
            }//2nd
            //3rd
            if(!this.editedItem.winning_number_3){
                this.err.push('0');
                this.err_form.winning_number_3= 'Field is required.';
            }else if(this.editedItem.winning_number_3 <= 0 || this.editedItem.winning_number_3 > 50){
                this.err.push('0');
                this.err_form.winning_number_3= 'Choose number from 1-50.';
            }/** Start - Validation if number is repeated */
            else if(this.editedItem.winning_number_3 == this.editedItem.winning_number_2
                    || this.editedItem.winning_number_3 == this.editedItem.winning_number_1
                    || this.editedItem.winning_number_3 == this.editedItem.winning_number_4
                    || this.editedItem.winning_number_3 == this.editedItem.winning_number_5
                    || this.editedItem.winning_number_3 == this.editedItem.winning_number_6
                    || this.editedItem.winning_number_3 == this.editedItem.winning_number_7
                    || this.editedItem.winning_number_3 == this.editedItem.winning_number_bonus
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_3= 'Number cannot be repeated';
            }/** Start - 3rd number is not greater than 4th to 7th */
            else if(this.editedItem.winning_number_3 >= this.editedItem.winning_number_4
                    || this.editedItem.winning_number_3 >= this.editedItem.winning_number_5
                    || this.editedItem.winning_number_3 >= this.editedItem.winning_number_6
                    || this.editedItem.winning_number_3 >= this.editedItem.winning_number_7
                    || (this.editedItem.winning_number_3 <= this.editedItem.winning_number_2
                    || this.editedItem.winning_number_3 <= this.editedItem.winning_number_1)
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_3= 'Invalid number';
            }//3rd
            //4th
            if(!this.editedItem.winning_number_4){
                this.err.push('0');
                this.err_form.winning_number_4= 'Field is required.';
            }else if(this.editedItem.winning_number_4 <= 0 || this.editedItem.winning_number_4 > 50){
                this.err.push('0');
                this.err_form.winning_number_4= 'Choose number from 1-50.';
            }/** Start - Validation if number is repeated */
            else if(this.editedItem.winning_number_4 == this.editedItem.winning_number_2
                    || this.editedItem.winning_number_4 == this.editedItem.winning_number_3
                    || this.editedItem.winning_number_4 == this.editedItem.winning_number_1
                    || this.editedItem.winning_number_4 == this.editedItem.winning_number_5
                    || this.editedItem.winning_number_4 == this.editedItem.winning_number_6
                    || this.editedItem.winning_number_4 == this.editedItem.winning_number_7
                    || this.editedItem.winning_number_4 == this.editedItem.winning_number_bonus
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_4= 'Number cannot be repeated';
            }/** Start - 4th number is not greater than 5th to 7th */
            else if(this.editedItem.winning_number_4 >= this.editedItem.winning_number_5
                    || this.editedItem.winning_number_4 >= this.editedItem.winning_number_6
                    || this.editedItem.winning_number_4 >= this.editedItem.winning_number_7
                    || (this.editedItem.winning_number_4 <= this.editedItem.winning_number_1
                    || this.editedItem.winning_number_4 <= this.editedItem.winning_number_2
                    || this.editedItem.winning_number_4 <= this.editedItem.winning_number_3)
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_4= 'Invalid number';
            }//4th
            //5th
            if(!this.editedItem.winning_number_5){
                this.err.push('0');
                this.err_form.winning_number_5= 'Field is required.';
            }else if(this.editedItem.winning_number5 <= 0 || this.editedItem.winning_number_5 > 50){
                this.err.push('0');
                this.err_form.winning_number_5= 'Choose number from 1-50.';
            }/** Start - Validation if number is repeated */
            else if(this.editedItem.winning_number_5 == this.editedItem.winning_number_2
                    || this.editedItem.winning_number_5 == this.editedItem.winning_number_3
                    || this.editedItem.winning_number_5 == this.editedItem.winning_number_4
                    || this.editedItem.winning_number_5 == this.editedItem.winning_number_1
                    || this.editedItem.winning_number_5 == this.editedItem.winning_number_6
                    || this.editedItem.winning_number_5 == this.editedItem.winning_number_7
                    || this.editedItem.winning_number_5 == this.editedItem.winning_number_bonus
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_5= 'Number cannot be repeated';
            }/** Start - 5th number is not greater than 6th and 7th */
            else if(this.editedItem.winning_number_5 >= this.editedItem.winning_number_6
                    || this.editedItem.winning_number_5 >= this.editedItem.winning_number_7
                    || (this.editedItem.winning_number_5 <= this.editedItem.winning_number_1
                    || this.editedItem.winning_number_5 <= this.editedItem.winning_number_2
                    || this.editedItem.winning_number_5 <= this.editedItem.winning_number_3
                    || this.editedItem.winning_number_5 <= this.editedItem.winning_number_4)
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_4= 'Invalid number';
            }//5th
            //6th
            if(!this.editedItem.winning_number_6){
                this.err.push('0');
                this.err_form.winning_number_6= 'Field is required.';
            }else if(this.editedItem.winning_number_6 <= 0 || this.editedItem.winning_number_6 > 50){
                this.err.push('0');
                this.err_form.winning_number_6= 'Choose number from 1-50.';
            }/** Start - Validation if number is repeated */
            else if(this.editedItem.winning_number_6 == this.editedItem.winning_number_7
                    || this.editedItem.winning_number_6 == this.editedItem.winning_number_2
                    || this.editedItem.winning_number_6 == this.editedItem.winning_number_3
                    || this.editedItem.winning_number_6 == this.editedItem.winning_number_4
                    || this.editedItem.winning_number_6 == this.editedItem.winning_number_5
                    || this.editedItem.winning_number_6 == this.editedItem.winning_number_1
                    || this.editedItem.winning_number_6 == this.editedItem.winning_number_bonus
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_6= 'Number cannot be repeated';

            }/** Start - 6th number is not less than 1st to 5th OR !>= 7th */
            else if(this.editedItem.winning_number_6 >= this.editedItem.winning_number_7
                    || (this.editedItem.winning_number_6 <= this.editedItem.winning_number_1
                    || this.editedItem.winning_number_6 <= this.editedItem.winning_number_2
                    || this.editedItem.winning_number_6 <= this.editedItem.winning_number_3
                    || this.editedItem.winning_number_6 <= this.editedItem.winning_number_4
                    || this.editedItem.winning_number_6 <= this.editedItem.winning_number_5)
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_6= 'Invalid number';
            } //6th
            //7th
            if(!this.editedItem.winning_number_7){
                this.err.push('0');
                this.err_form.winning_number_7= 'Field is required.';
            }else if(this.editedItem.winning_number_7 <= 0 || this.editedItem.winning_number_7 > 50){
                this.err.push('0');
                this.err_form.winning_number_7= 'Choose number from 1-50.';
            }/** Start - Validation if number is repeated */
            else if(this.editedItem.winning_number_7 == this.editedItem.winning_number_1
                    || this.editedItem.winning_number_7 == this.editedItem.winning_number_2
                    || this.editedItem.winning_number_7 == this.editedItem.winning_number_3
                    || this.editedItem.winning_number_7 == this.editedItem.winning_number_4
                    || this.editedItem.winning_number_7 == this.editedItem.winning_number_5
                    || this.editedItem.winning_number_7 == this.editedItem.winning_number_6
                    || this.editedItem.winning_number_7 == this.editedItem.winning_number_bonus
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_7= 'Number cannot be repeated';

            }/** Start - 7th number is not less than 1st to 6th */
            else if(this.editedItem.winning_number_7 <= this.editedItem.winning_number_1
                    || this.editedItem.winning_number_7 <= this.editedItem.winning_number_2
                    || this.editedItem.winning_number_7 <= this.editedItem.winning_number_3
                    || this.editedItem.winning_number_7 <= this.editedItem.winning_number_4
                    || this.editedItem.winning_number_7 <= this.editedItem.winning_number_5
                    || this.editedItem.winning_number_7 <= this.editedItem.winning_number_6
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_7= 'Invalid number';
            } //7th

            // Bonus
            if(!this.editedItem.winning_number_bonus){
                this.err.push('0');
                this.err_form.winning_number_bonus= 'Field is required.';
            }else if(this.editedItem.winning_number_bonus <= 0 || this.editedItem.winning_number_bonus > 50){
                this.err.push('0');
                this.err_form.winning_number_bonus= 'Choose number from 1-50.';
            }/** Start - Validation if number is repeated */
            else if(this.editedItem.winning_number_bonus == this.editedItem.winning_number_1
                    || this.editedItem.winning_number_bonus == this.editedItem.winning_number_2
                    || this.editedItem.winning_number_bonus == this.editedItem.winning_number_3
                    || this.editedItem.winning_number_bonus == this.editedItem.winning_number_4
                    || this.editedItem.winning_number_bonus == this.editedItem.winning_number_5
                    || this.editedItem.winning_number_bonus == this.editedItem.winning_number_6
                    || this.editedItem.winning_number_bonus == this.editedItem.winning_number_7
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_bonus= 'Number cannot be repeated';
            } // Bonus

            /**Extra Number */
            if(!this.editedItem.extra){
                this.err.push('0');
                this.err_form.extra= 'Field is required.';
            }/** Start -Extra Number draw length validation */
            else if((this.editedItem.extra).toString().length > 7){
                this.err.push('0');
                this.err_form.extra = 'The number of characters exceeded its specified limit (7).';
            }/** End - Extra Number draw length validation */


        },

        save () {
            if (this.editedIndex > -1) {
                // this.validate();
                if(this.err.length <= 0){
                    this.axios.patch('/lotto/history/lotto-max/update/'+this.editedItem.id_string, this.editedItem)
                    .then( response=> {
                        Vue.$toast.open({
                            message: response.data.success,
                            type: 'success',
                            position: 'top',
                            duration: 5000,
                        });
                        location.reload(true);
                    })
                    .catch(error => {
                        Vue.$toast.open({
                            message: 'Validation error found. Failed to save details.',
                            type: 'error',
                            position: 'top',
                            duration: 2000,
                        });
                        this.err = error.response.data
                        this.err_form.draw_date = error.response.data.errors.draw_date
                        this.err_form.winning_number_1 = error.response.data.errors.winning_number_1
                        this.err_form.winning_number_2 = error.response.data.errors.winning_number_2
                        this.err_form.winning_number_3 = error.response.data.errors.winning_number_3
                        this.err_form.winning_number_4 = error.response.data.errors.winning_number_4
                        this.err_form.winning_number_5 = error.response.data.errors.winning_number_5
                        this.err_form.winning_number_6 = error.response.data.errors.winning_number_6
                        this.err_form.winning_number_7 = error.response.data.errors.winning_number_7
                        this.err_form.winning_number_bonus = error.response.data.errors.winning_number_bonus
                        this.err_form.extra = error.response.data.errors.extra
                    });;
                }
            } else {
                this.validate();
                if(this.err.length <= 0){
                    this.axios.post('/lotto/history/lotto-max/store', this.editedItem)
                    .then(response => {
                        this.close()
                        Vue.$toast.open({
                            message: response.data.success,
                            type: 'success',
                            position: 'top',
                            duration: 2000,
                        });
                        location.reload(true);
                    })
                    .catch(error => {
                        Vue.$toast.open({
                            message: 'Validation error found. Failed to save details.',
                            type: 'error',
                            position: 'top',
                            duration: 2000,
                        });
                        this.err_form.draw_date = error.response.data.errors.draw_date
                        this.err_form.winning_number_1 = error.response.data.errors.winning_number_1
                        this.err_form.winning_number_2 = error.response.data.errors.winning_number_2
                        this.err_form.winning_number_3 = error.response.data.errors.winning_number_3
                        this.err_form.winning_number_4 = error.response.data.errors.winning_number_4
                        this.err_form.winning_number_5 = error.response.data.errors.winning_number_5
                        this.err_form.winning_number_6 = error.response.data.errors.winning_number_6
                        this.err_form.winning_number_7 = error.response.data.errors.winning_number_7
                        this.err_form.winning_number_bonus = error.response.data.errors.winning_number_bonus
                        this.err_form.extra = error.response.data.errors.extra

                    });
                }
            }
        },

        clear(){
            this.err = [];
            this.err_form.draw_date = '';
            this.err_form.winning_number_1 = '';
            this.err_form.winning_number_2 = '';
            this.err_form.winning_number_3 = '';
            this.err_form.winning_number_4 = '';
            this.err_form.winning_number_5 = '';
            this.err_form.winning_number_6 = '';
            this.err_form.winning_number_7 = '';
            this.err_form.winning_number_bonus = '';
            this.err_form.extra = '';
        },

    },
  }
</script>
