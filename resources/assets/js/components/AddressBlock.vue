<template>

  <div>

    <div class="col-md-6 mb-sm form-group clear">
      <label class="control-label">Address Line 1</label>
      <vue-google-autocomplete
          ref="address"
          required
          :name="name + '[line1]'"
          :id="name"
          v-model="address.line1"
          placeholder=""
          autocomplete="nope"
          classname="form-control form-control-sm"
          v-on:placechanged="getAddressData"
          country="us">
      </vue-google-autocomplete>

    </div>

    <div class="col-md-6 mb-sm form-group">
      <label class="control-label">Address Line 2</label>
      <input class="form-control form-control-sm"
          v-model="address.line2"
          :name="name + '[line2]'"/>
    </div>

    <div class="col-sm-4 mb-sm form-group">
      <label class="control-label">City</label>
      <input type="text" required v-model="address.city" :name="name + '[city]'"
          class="form-control form-control-sm"/>
    </div>

    <div class="col-sm-4 mb-sm form-group">
      <label class="control-label">State</label>
      <select class="form-control form-control-sm" v-model="address.state" required
          :name="name + '[state]'">

        <option v-for="(state, abbr) of states" :value="abbr">{{state}}</option>
      </select>
    </div>

    <div class="col-sm-4 mb-sm form-group">
      <label class="control-label">Zip Code</label>
      <input type="text" required :name="name + '[zip_code]'"
          v-model="address.zip_code"
          class="form-control form-control-sm"/>
    </div>

    <div class="col-md-12 mb-sm form-group">
      <label class="control-label">Special Instructions</label>
      <input type="text" v-model="address.special_instructions"
          :name="name + '[special_instructions]'"
          class="form-control form-control-sm"/>
    </div>
  </div>

</template>

<script>
  import VueGoogleAutocomplete from 'vue-google-autocomplete'

  const states = {
    "AL": "Alabama",
    "AK": "Alaska",
    "AZ": "Arizona",
    "AR": "Arkansas",
    "CA": "California",
    "CO": "Colorado",
    "CT": "Connecticut",
    "DE": "Delaware",
    "DC": "District Of Columbia",
    "FL": "Florida",
    "GA": "Georgia",
    "GU": "Guam",
    "HI": "Hawaii",
    "ID": "Idaho",
    "IL": "Illinois",
    "IN": "Indiana",
    "IA": "Iowa",
    "KS": "Kansas",
    "KY": "Kentucky",
    "LA": "Louisiana",
    "ME": "Maine",
    "MD": "Maryland",
    "MA": "Massachusetts",
    "MI": "Michigan",
    "MN": "Minnesota",
    "MS": "Mississippi",
    "MO": "Missouri",
    "MT": "Montana",
    "NE": "Nebraska",
    "NV": "Nevada",
    "NH": "New Hampshire",
    "NJ": "New Jersey",
    "NM": "New Mexico",
    "NY": "New York",
    "NC": "North Carolina",
    "ND": "North Dakota",
    "OH": "Ohio",
    "OK": "Oklahoma",
    "OR": "Oregon",
    "PA": "Pennsylvania",
    "RI": "Rhode Island",
    "SC": "South Carolina",
    "SD": "South Dakota",
    "TN": "Tennessee",
    "TX": "Texas",
    "UT": "Utah",
    "VT": "Vermont",
    "VA": "Virginia",
    "WA": "Washington",
    "WV": "West Virginia",
    "WI": "Wisconsin",
    "WY": "Wyoming"
  };

  export default {
    components: {VueGoogleAutocomplete},

    props: ['name', 'input', 'errors'],

    data: () => ({
      address: {
        line1: '',
        line2: '',
        city: '',
        state: 'CA',
        zip_code: '',
        special_instructions: '',
      },
      states,
    }),

    beforeMount() {
      Object.assign(this.address, this.input);
    },

    mounted() {
    },

    afterMount() {
      this.address.state = 'CA';
    },


    methods: {
      getAddressData(addressData, placeResultData, id) {
        this.address = {
          line1: ((addressData.street_number || '') + ' ' + (addressData.route || '')).trim(),
          city: addressData.locality,
          state: addressData.administrative_area_level_1,
          zip_code: addressData.postal_code,

          // Keep previous values
          line2: this.address.line2,
          special_instructions: this.address.special_instructions,
        };

        // update google maps autocomplete input
        setTimeout(() => {
          this.$refs.address.update(((addressData.street_number || '') + ' ' + (addressData.route || '')).trim());
        }, 0);
      },
    }
  }
</script>

<style scoped>

</style>