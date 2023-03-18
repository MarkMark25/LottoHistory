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
        <v-toolbar-title>Lotto 6/49 History</v-toolbar-title>
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
                    <v-col cols="12" sm="12" md="6">
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
                    <h4>Classic Draw Winning Numbers</h4>
                    <v-col cols="6" sm="4" xs="4" md="">
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
                    <v-col cols="6" sm="4" xs="4" md="">
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
                    <v-col cols="6" sm="4" xs="4" md="">
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
                    <v-col cols="6" sm="4" xs="4" md="">
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
                    <v-col cols="6" sm="4" xs="4" md="">
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
                    <v-col cols="6" sm="4" xs="4" md="">
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
                    <v-col cols="6" sm="4" xs="4" md="">
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
                    <h4>Gold Ball Draw</h4>
                    <v-col cols="12" sm="6" xs="6" md="6">
                        <v-text-field
                            v-model="editedItem.gold_ball_win_num"
                            label="Winning Number"
                            @keydown="err_form.gold_ball_win_num = ''"
                            @click="err_form.gold_ball_win_num = ''"
                            dense
                            placeholder="00000000-00"
                            @input="enforceGoldWinning"
                            :maxlength="gold_win_num_max"
                        ></v-text-field>
                        <small class="text-danger" v-text="err_form.gold_ball_win_num"></small>
                    </v-col>
                    <v-col cols="12" sm="6" xs="6" md="6">
                        <v-select
                            :items="gold_ball_draw_color"
                            item-text="color"
                            item-value="id"
                            v-model="editedItem.ball_color"
                            label="Ball Color"
                            dense
                            @change="err_form.ball_color = ''"
                        ></v-select>
                        <small class="text-danger" v-text="err_form.ball_color"></small>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="6">
                        <v-select
                            :items="provinces"
                            item-text="province"
                            item-value="abbrv"
                            v-model="editedItem.gb_province_winner"
                            label="Gold ball province winner"
                            dense
                            sort
                            @change="err_form.gb_province_winner = ''"
                        ></v-select>
                        <small class="text-danger" v-text="err_form.gb_province_winner"></small>
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
                    <v-col cols="12" sm="12" md="6">
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
                    <h4>Classic Draw Winning Numbers</h4>
                    <v-col cols="6" sm="4" xs="4" md="">
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
                    <v-col cols="6" sm="4" xs="4" md="">
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
                    <v-col cols="6" sm="4" xs="4" md="">
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
                    <v-col cols="6" sm="4" xs="4" md="">
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
                    <v-col cols="6" sm="4" xs="4" md="">
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
                    <v-col cols="6" sm="4" xs="4" md="">
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
                    <v-col cols="6" sm="4" xs="4" md="">
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
                    <h4>Gold Ball Draw</h4>
                    <v-col cols="12" sm="6" xs="6" md="">
                        <v-text-field
                            v-model="editedItem.gold_ball_win_num"
                            label="Winning Number"
                            @keydown="err_form.gold_ball_win_num = ''"
                            @click="err_form.gold_ball_win_num = ''"
                            dense
                            placeholder="00000000-00"
                            @input="enforceGoldWinning"
                            :maxlength="gold_win_num_max"
                        ></v-text-field>
                        <small class="text-danger" v-text="err_form.gold_ball_win_num"></small>
                    </v-col>
                    <v-col cols="12" sm="6" xs="6" md="">
                        <v-select
                            :items="gold_ball_draw_color"
                            item-text="color"
                            item-value="id"
                            v-model="editedItem.ball_color"
                            label="Ball Color"
                            dense
                            @change="err_form.ball_color = ''"
                        ></v-select>
                        <small class="text-danger" v-text="err_form.ball_color"></small>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="6">
                        <v-select
                            :items="provinces"
                            item-text="province"
                            item-value="abbrv"
                            v-model="editedItem.gb_province_winner"
                            label="Gold ball province winner"
                            dense
                            sort
                            @change="err_form.gb_province_winner = ''"
                        ></v-select>
                        <small class="text-danger" v-text="err_form.gb_province_winner"></small>
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
    <!-- Ball Color -->
    <template v-slot:[`item.ball_color`]="{ item }">
        <v-btn
            class="mx-2"
            fab
            x-small
            v-if="item.ball_color === 1"
            color="warning"
        >
            G
        </v-btn>
        <v-btn
            class="mx-2"
            fab
            x-small
            v-else>
            W
        </v-btn>
    </template>
    <!-- Gold ball number and province winner -->
    <template v-slot:[`item.gold_ball_win_num_province`]="{ item }">
        <span>
            {{ item.gold_ball_win_num }}
        </span>
        <span class="font-weight-bold">
            {{ item.gb_province_winner }}
        </span>
    </template>
    <!-- Uncomment this if you want to display a circle balls -->
    <!--
    <template v-slot:[`item.classic_draw`]="{ item }">
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
            color="warning"
        >
            <span>{{item.winning_number_bonus}}</span>
        </v-btn>
    </template>
    -->
    <template v-slot:[`item.classic_draw`]="{ item }">
        {{item.winning_number_1+' '+item.winning_number_2+' '+item.winning_number_3+' '+item.winning_number_4+' '+item.winning_number_5+' '+item.winning_number_6}}
        <span class="font-weight-bold">{{item.winning_number_bonus}}</span>
    </template>
  </v-data-table>
</template>
<script>
    import moment from 'moment';
  export default {
      props: ['sixfournine'],
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
            { text: 'Classic Draw', value: 'classic_draw'},
            { text: 'Gold Ball Draw', value: 'gold_ball_win_num_province'},
            { text: 'Ball Color', value: 'ball_color'},
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
            winning_number_bonus: '',
            ball_color: '',
            gold_ball_win_num: '',
            gb_province_winner: '',
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
            winning_number_bonus: '',
            ball_color: '',
            gold_ball_win_num: '',
            gb_province_winner: '',
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
            winning_number_bonus: '',
            ball_color: '',
            gold_ball_win_num: '',
            gb_province_winner: '',
            extra: '',
        },
        gold_ball_draw_color: [
            {
                id: 0,
                color: 'White'
            },
            {
                id: 1,
                color: 'Gold'
            },
        ],
        provinces: [
            { id: 0, abbrv: 'AB', province:'Alberta' },
            { id: 1, abbrv: 'BC', province:'British Columbia' },
            { id: 2, abbrv: 'MB', province:'Manitoba' },
            { id: 3, abbrv: 'NB', province:'New Brunswick' },
            { id: 4, abbrv: 'NL', province:'Newfoundland and Labrador' },
            { id: 5, abbrv: 'NS', province:'Nova Scotia' },
            { id: 6, abbrv: 'NT', province:'Northwest Territories' },
            { id: 7, abbrv: 'NU', province:'Nunavut' },
            { id: 8, abbrv: 'ON', province:'Ontario' },
            { id: 9, abbrv: 'PE', province:'Prince Edward Island' },
            { id: 10, abbrv: 'QC', province:'Quebec' },
            { id: 11, abbrv: 'SK', province:'Saskatchewan' },
            { id: 12, abbrv: 'YT', province:'Yukon Territory' },
        ],
        date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
        modal: false,
        // Number role for number fields
        numberRule: val => {
            if(val < 0) return 'Please enter a positive number'
            return true
        },
        //Gold Winning Number Maximum Length
        gold_win_num_max:11,
        extra_num_max:7,
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
        //Gold ball winning number
        enforceGoldWinning(){
            let x = this.editedItem.gold_ball_win_num.replace(/\D/g,'').match(/(\d{0,8})(\d{0,2})/);
            this.editedItem.gold_ball_win_num = !x[2] ? x[1] : x[1] + '-' + x[2];
        },

        dateFormat(d){
            return moment(d, 'YYYY-MM-DD').format('MMMM DD YYYY');
        },

        initialize(){
            this.sixfournine.map( (l, index )=>{
                this.list.push({
                    id_string: l.id_string,
                    draw_date: l.draw_date,
                    classic_draw: l.winning_number_1 + ' ' + l.winning_number_2 + ' ' + l.winning_number_3 + ' ' + l.winning_number_4 + ' ' + l.winning_number_5 + ' ' + l.winning_number_6 + ' '+ l.winning_number_bonus,
                    gold_ball_win_num_province: l.gold_ball_win_num + ' ' + l.gb_province_winner,
                    gold_ball_win_num: l.gold_ball_win_num,
                    gb_province_winner: l.gb_province_winner,
                    ball_color: l.ball_color,
                    winning_number_1: l.winning_number_1,
                    winning_number_2: l.winning_number_2,
                    winning_number_3: l.winning_number_3,
                    winning_number_4: l.winning_number_4,
                    winning_number_5: l.winning_number_5,
                    winning_number_6: l.winning_number_6,
                    winning_number_bonus: l.winning_number_bonus,
                    extra: l.extra,
                });
            });
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
            this.axios.patch('/lotto/history/6-49/destroy/'+this.editedItem.id_string, this.editedItem)
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
            }/** Start - Maximum number is 49 */
            else if(this.editedItem.winning_number_1 <= 0 || this.editedItem.winning_number_1 > 49){
                this.err.push('0');
                this.err_form.winning_number_1= 'Choose number from 1-49.';
            }/** Start - Validation if number is repeated */
            else if(this.editedItem.winning_number_1 == this.editedItem.winning_number_2
                    || this.editedItem.winning_number_1 == this.editedItem.winning_number_3
                    || this.editedItem.winning_number_1 == this.editedItem.winning_number_4
                    || this.editedItem.winning_number_1 == this.editedItem.winning_number_5
                    || this.editedItem.winning_number_1 == this.editedItem.winning_number_6
                    || this.editedItem.winning_number_1 == this.editedItem.winning_number_bonus
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_1= 'Number cannot be repeated';
            }/** Start - 1st number is not greater than 2nd to 6th */
            else if(this.editedItem.winning_number_1 >= this.editedItem.winning_number_2
                    || this.editedItem.winning_number_1 >= this.editedItem.winning_number_3
                    || this.editedItem.winning_number_1 >= this.editedItem.winning_number_4
                    || this.editedItem.winning_number_1 >= this.editedItem.winning_number_5
                    || this.editedItem.winning_number_1 >= this.editedItem.winning_number_6
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_1= 'Invalid number';
            }//1st
            //2nd
            if(!this.editedItem.winning_number_2){
                this.err.push('0');
                this.err_form.winning_number_2= 'Field is required.';
            }else if(this.editedItem.winning_number_2 <= 0 || this.editedItem.winning_number_2 > 49){
                this.err.push('0');
                this.err_form.winning_number_2= 'Choose number from 1-49.';
            }/** Start - Validation if number is repeated */
            else if(this.editedItem.winning_number_2 == this.editedItem.winning_number_1
                    || this.editedItem.winning_number_2 == this.editedItem.winning_number_3
                    || this.editedItem.winning_number_2 == this.editedItem.winning_number_4
                    || this.editedItem.winning_number_2 == this.editedItem.winning_number_5
                    || this.editedItem.winning_number_2 == this.editedItem.winning_number_6
                    || this.editedItem.winning_number_2 == this.editedItem.winning_number_bonus
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_2= 'Number cannot be repeated';
            }/** Start - 2nd number is not greater than 3rd to 6th */
            else if(this.editedItem.winning_number_2 >= this.editedItem.winning_number_3
                    || this.editedItem.winning_number_2 >= this.editedItem.winning_number_4
                    || this.editedItem.winning_number_2 >= this.editedItem.winning_number_5
                    || this.editedItem.winning_number_2 >= this.editedItem.winning_number_6
                    || this.editedItem.winning_number_2 <= this.editedItem.winning_number_1
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_2= 'Invalid number';
            }//2nd
            //3rd
            if(!this.editedItem.winning_number_3){
                this.err.push('0');
                this.err_form.winning_number_3= 'Field is required.';
            }else if(this.editedItem.winning_number_3 <= 0 || this.editedItem.winning_number_3 > 49){
                this.err.push('0');
                this.err_form.winning_number_3= 'Choose number from 1-49.';
            }/** Start - Validation if number is repeated */
            else if(this.editedItem.winning_number_3 == this.editedItem.winning_number_2
                    || this.editedItem.winning_number_3 == this.editedItem.winning_number_1
                    || this.editedItem.winning_number_3 == this.editedItem.winning_number_4
                    || this.editedItem.winning_number_3 == this.editedItem.winning_number_5
                    || this.editedItem.winning_number_3 == this.editedItem.winning_number_6
                    || this.editedItem.winning_number_3 == this.editedItem.winning_number_bonus
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_3= 'Number cannot be repeated';
            }/** Start - 3rd number is not greater than 4th to 6th */
            else if(this.editedItem.winning_number_3 >= this.editedItem.winning_number_4
                    || this.editedItem.winning_number_3 >= this.editedItem.winning_number_5
                    || this.editedItem.winning_number_3 >= this.editedItem.winning_number_6
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
            }else if(this.editedItem.winning_number_4 <= 0 || this.editedItem.winning_number_4 > 49){
                this.err.push('0');
                this.err_form.winning_number_4= 'Choose number from 1-49.';
            }/** Start - Validation if number is repeated */
            else if(this.editedItem.winning_number_4 == this.editedItem.winning_number_2
                    || this.editedItem.winning_number_4 == this.editedItem.winning_number_3
                    || this.editedItem.winning_number_4 == this.editedItem.winning_number_1
                    || this.editedItem.winning_number_4 == this.editedItem.winning_number_5
                    || this.editedItem.winning_number_4 == this.editedItem.winning_number_6
                    || this.editedItem.winning_number_4 == this.editedItem.winning_number_bonus
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_4= 'Number cannot be repeated';
            }/** Start - 4th number is not greater than 5th to 6th */
            else if(this.editedItem.winning_number_4 >= this.editedItem.winning_number_5
                    || this.editedItem.winning_number_4 >= this.editedItem.winning_number_6
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
            }else if(this.editedItem.winning_number5 <= 0 || this.editedItem.winning_number_5 > 49){
                this.err.push('0');
                this.err_form.winning_number_5= 'Choose number from 1-49.';
            }/** Start - Validation if number is repeated */
            else if(this.editedItem.winning_number_5 == this.editedItem.winning_number_2
                    || this.editedItem.winning_number_5 == this.editedItem.winning_number_3
                    || this.editedItem.winning_number_5 == this.editedItem.winning_number_4
                    || this.editedItem.winning_number_5 == this.editedItem.winning_number_1
                    || this.editedItem.winning_number_5 == this.editedItem.winning_number_6
                    || this.editedItem.winning_number_5 == this.editedItem.winning_number_bonus
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_5= 'Number cannot be repeated';
            }/** Start - 5th number is not greater than 6th */
            else if(this.editedItem.winning_number_5 >= this.editedItem.winning_number_6
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
            }else if(this.editedItem.winning_number_6 <= 0 || this.editedItem.winning_number_6 > 49){
                this.err.push('0');
                this.err_form.winning_number_6= 'Choose number from 1-49.';
            }/** Start - Validation if number is repeated */
            else if(this.editedItem.winning_number_6 == this.editedItem.winning_number_2
                    || this.editedItem.winning_number_6 == this.editedItem.winning_number_3
                    || this.editedItem.winning_number_6 == this.editedItem.winning_number_4
                    || this.editedItem.winning_number_6 == this.editedItem.winning_number_5
                    || this.editedItem.winning_number_6 == this.editedItem.winning_number_1
                    || this.editedItem.winning_number_6 == this.editedItem.winning_number_bonus
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_6= 'Number cannot be repeated';

            }/** Start - 6th number is not less than 1st to 5th */
            else if(this.editedItem.winning_number_6 <= this.editedItem.winning_number_1
                    || this.editedItem.winning_number_6 <= this.editedItem.winning_number_2
                    || this.editedItem.winning_number_6 <= this.editedItem.winning_number_3
                    || this.editedItem.winning_number_6 <= this.editedItem.winning_number_4
                    || this.editedItem.winning_number_6 <= this.editedItem.winning_number_5
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_6= 'Invalid number';
            } //6th

            // Bonus
            if(!this.editedItem.winning_number_bonus){
                this.err.push('0');
                this.err_form.winning_number_bonus= 'Field is required.';
            }else if(this.editedItem.winning_number_bonus <= 0 || this.editedItem.winning_number_bonus > 49){
                this.err.push('0');
                this.err_form.winning_number_bonus= 'Choose number from 1-49.';
            }/** Start - Validation if number is repeated */
            else if(this.editedItem.winning_number_bonus == this.editedItem.winning_number_2
                    || this.editedItem.winning_number_bonus == this.editedItem.winning_number_3
                    || this.editedItem.winning_number_bonus == this.editedItem.winning_number_4
                    || this.editedItem.winning_number_bonus == this.editedItem.winning_number_5
                    || this.editedItem.winning_number_bonus == this.editedItem.winning_number_6
                    || this.editedItem.winning_number_bonus == this.editedItem.winning_number_1
                    ){
                    this.err.push('0');
                    this.err_form.winning_number_bonus= 'Number cannot be repeated';
            } // Bonus

            if(!this.editedItem.ball_color){
                this.err.push('0');
                this.err_form.ball_color= 'Field is required.';
            }
            if(!this.editedItem.gold_ball_win_num){
                this.err.push('0');
                this.err_form.gold_ball_win_num= 'Field is required.';
            }/** Start - Gold ball draw length validation */
            else if((this.editedItem.gold_ball_win_num).toString().length > 11){
                this.err.push('0');
                this.err_form.gold_ball_win_num = 'The number of characters exceeded its specified limit (11).';
            }/** End - Gold ball draw length validation */
            if(!this.editedItem.gb_province_winner){
                this.err.push('0');
                this.err_form.gb_province_winner= 'Field is required.';
            }
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
                this.validate();
                if(this.err.length <= 0){
                    this.axios.patch('/lotto/history/6-49/update/'+this.editedItem.id_string, this.editedItem)
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
                        this.err_form.draw_date = error.response.data.errors.draw_date
                        this.err_form.winning_number_1 = error.response.data.errors.winning_number_1
                        this.err_form.winning_number_2 = error.response.data.errors.winning_number_2
                        this.err_form.winning_number_3 = error.response.data.errors.winning_number_3
                        this.err_form.winning_number_4 = error.response.data.errors.winning_number_4
                        this.err_form.winning_number_5 = error.response.data.errors.winning_number_5
                        this.err_form.winning_number_6 = error.response.data.errors.winning_number_6
                        this.err_form.winning_number_bonus = error.response.data.errors.winning_number_bonus
                        this.err_form.ball_color = error.response.data.errors.ball_color
                        this.err_form.gold_ball_win_num = error.response.data.errors.gold_ball_win_num
                        this.err_form.gb_province_winner = error.response.data.errors.gb_province_winner
                        this.err_form.extra = error.response.data.errors.extra
                    });;
                }
            } else {
                this.validate();
                if(this.err.length <= 0){
                    this.axios.post('/lotto/history/6-49/store', this.editedItem)
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
                        this.err_form.winning_number_bonus = error.response.data.errors.winning_number_bonus
                        this.err_form.ball_color = error.response.data.errors.ball_color
                        this.err_form.gold_ball_win_num = error.response.data.errors.gold_ball_win_num
                        this.err_form.gb_province_winner = error.response.data.errors.gb_province_winner
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
            this.err_form.winning_number_bonus = '';
            this.err_form.ball_color = '';
            this.err_form.gold_ball_win_num = '';
            this.err_form.gb_province_winner = '';
            this.err_form.extra = '';
        },

    },
  }
</script>
