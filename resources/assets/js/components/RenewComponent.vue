<script>

  export default {

    props: [
      'oldInput',
      'curSubscription',
      '_curBookSubscriptions',
      '_curAddons',
      'card',
      'curPaymentMethod',
    ],

    data: () => ({
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
      },

      subLength: '24', // subscription length in months

      bookAddresses: [],
      curBookSubscriptions: [],
      bookSubscriptionsToRemove: [],

      addons: [],
      curAddons: [],
      addonsToRemove: [],

      paymentMethod: 'stripe',
      isLoading: false,
    }),

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
      bookSubscriptionsToRemoveValue() {
        return this.bookSubscriptionsToRemove.map(b => b.id).join(',');
      },
      addonsToRemoveValue() {
        return this.addonsToRemove.map(b => b.id).join(',');
      },
      bookCount() {
        return this.bookAddresses.length + this.curBookSubscriptions.length;
      },
      addonCount() {
        return this.addons.length + this.curAddons.length;
      },
    },

    beforeMount() {

      this.subLength = String(this.curSubscription.frequency || 24);

      this.paymentMethod = this.curPaymentMethod || 'stripe';
      this.curBookSubscriptions = [].concat(this._curBookSubscriptions);
      this.curAddons = [].concat(this._curAddons);
      console.log(this.curAddons);
    },

    mounted() {
    },

    methods: {

      removeOldSubscription(id) {
        const removing = this.curBookSubscriptions.splice(this.curBookSubscriptions.findIndex(b => b.id === id), 1);
        this.bookSubscriptionsToRemove.push(...removing);
      },
      removeOldAddon(id) {
        const removing = this.curAddons.splice(this.curAddons.findIndex(a => a.id === id), 1);
        this.addonsToRemove.push(...removing);
      },

      addBook() {
        this.bookAddresses.push({
          line1: '',
          line2: '',
          city: '',
          state: 'CA',
          zip_code: '',
          special_instructions: '',
        });
      },

      addAddon() {
        this.addons.push({ email: '' });
      },

    }

  }
</script>

<style lang="scss" scoped>

  .form-group {
    margin-bottom: 16px;
  }

  .row {
    margin-bottom: 24px;
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

  .addLink {
    display: block;
    font-size: 14px;
    text-decoration: none;
    i {
      font-size: 16px;
      vertical-align: text-top;
    }
  }

  .addon-block {
    position: relative;
    a.remove-addon {
      position: absolute;
      right: 8px;
      top: 8px;
    }
  }
</style>
