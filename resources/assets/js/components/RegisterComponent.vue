<script>

  import VueGoogleAutocomplete from 'vue-google-autocomplete'
  import axios from 'axios';

  export default {
    components: {VueGoogleAutocomplete},

    props: ['oldInput'],

    data: () => {
      const data = {
        errors: {},
        pricing: { // by subscription length (in years)
          '12': {
            base: window.globals.SUBSCRIPTION_COST_1YR,
            addon: window.globals.ADDON_COST_1YR,
            book: window.globals.getBookCountForSubscription(1) * window.globals.BOOK_COST,
          },
          '24': {
            base: window.globals.SUBSCRIPTION_COST_2YR,
            addon: window.globals.ADDON_COST_2YR,
            book: window.globals.getBookCountForSubscription(2) * window.globals.BOOK_COST,
          },
          '0': { // trial
            base: 0,
          }
        },

        coupon: null,
        couponLoading: false,
        couponCode: '',

        subLength: '24', // subscription length in months

        bookCount: 0,
        bookAddresses: [],

        addonCount: 0,
        addons: [],

        companyAddress: {
          line1: '',
          line2: '',
          city: '',
          state: 'CA',
          zip_code: '',
        },

        paymentMethod: 'stripe',
        isLoading: false,
      };

      return data;
    },

    computed: {
      isTrial() {
        return this.subLength === '0';
      },
      baseCost() {
        return this.pricing[this.subLength].base;
      },
      bookTotalCost() {
        return this.pricing[this.subLength].book * this.bookCount;
      },
      addonTotalCost() {
        return this.pricing[this.subLength].addon * this.addonCount;
      },
      totalCost() {
        return this.baseCost + this.bookTotalCost + this.addonTotalCost;
      },
      couponValid() {
        return this.coupon && this.coupon.valid;
      },
      couponInvalid() {
        return this.coupon && !this.coupon.valid;
      },
    },

    mounted() {

      // Restore from session
      if (typeof this.oldInput === 'object' && !Array.isArray(this.oldInput)) {
        this.companyAddress = this.oldInput.company.address;
        this.bookAddresses = this.oldInput.book_addresses;
        this.bookCount = +this.oldInput.bookCount;
        this.addons = this.oldInput.addons;
        this.addonCount = +this.oldInput.addonCount;
        this.paymentMethod = this.oldInput.payment_method;
      }

    },

    methods: {
      remove(i) {
        this.addons.splice(i, 1);
      },
      edit(i, event) {
        this.addons[i] = event.target.value;
        this.addons = this.addons
            .map(a => a.trim())
            .filter(a => !!a);
      },

      incrementBooks() {
        if (this.bookCount === 2) return;
        this.bookCount++;
        this.bookAddresses.push({
          line1: '',
          line2: '',
          city: '',
          state: 'CA',
          zip_code: '',
          special_instructions: '',
        });
      },
      decrementBooks() {
        if (this.bookCount === 0) return;
        this.bookCount--;
        this.bookAddresses.pop();
      },

      incrementAddons() {
        if (this.addonCount === 2) return;
        this.addonCount++;
      },
      decrementAddons() {
        if (this.addonCount === 0) return;
        this.addonCount--;
      },

      onSubmit(event) {
        this.isLoading = true;

        const el = document.querySelector('input[name=stripe_token]');
        // wait until stripe token is loaded
        if (el && !el.value) {
          event.preventDefault();
          setTimeout(() => this.onSubmit(event), 100);
        } else {
          event.target.submit();
        }
      },

      async applyCoupon() {
        this.couponLoading = true;
        try {
          const res = await axios.get(`/register/coupon/${this.couponCode}`);
          this.coupon = res.data;
        } catch (e) {
          console.error(e);
          this.coupon = { valid: false };
        }
        this.couponLoading = false;

        if (this.couponValid) {
          this.subLength = '0';
        }
      },
    },
  }
</script>

<style lang="scss" scoped>

  .address-block {
    background: #f9f9f9;
    padding: 15px 10px;
  }

  .form-group {
    margin-bottom: 16px;
  }

  .select-options {
    label {
      display: block;
      padding: 5px 10px;
      border: 1px solid transparent;
      cursor: pointer;

      &.selected {
        border: 1px solid #ddd;
        background: #f9f9f9;
      }
    }
  }

  .incrementor {
    user-select: none;
    display: inline-block;
    border-radius: 4px;
    background: #f9f9f9;
    border: 1px solid #ddd;
    text-align: center;

    span {
      cursor: pointer;
      width: 40px;
      height: 100%;
      display: inline-block;
    }

    span.value {
      background: #fff;
      border-left: 1px solid #eee;
      border-right: 1px solid #eee;
    }
  }
</style>
