<template>
  <div>

    <input type="hidden" :value="stripeToken" name="stripe_token" required/>

    <div class="row">
      <div class="col-sm-12 form-group">
        <label>Account Holder Name</label>
        <input type="text" class="form-control" required v-model="account_holder_name"/>
      </div>
      <div class="col-sm-6 form-group">
        <label>Routing Number</label>
        <input type="text" class="form-control" required v-model="routing_number"/>
      </div>
      <div class="col-sm-6 form-group">
        <label>Account Number</label>
        <input type="text" class="form-control" required v-model="account_number"/>
      </div>
    </div>

    <!-- Used to display Element errors -->
    <span class="help-block text-red">
      <strong id="card-errors" role="alert">
          {{ stripeError }}
      </strong>
    </span>
  </div>

</template>

<script>
  var stripe = window.Stripe(window.STRIPE_PUB_KEY);

  export default {

    data: () => {
      return {
        routing_number: '',
        account_number: '',
        account_holder_name: '',

        stripeError: '',
        stripeToken: '',
      }
    },


    mounted() {
      $(this.$el).parents('form').on('submit', this.formHandle);
    },

    beforeDestroy() {
      $(this.$el).parents('form').off('submit', this.formHandle);
    },

    methods: {
      async formHandle(e) {
        if (this.stripeToken) return;

        e.stopPropagation();
        e.preventDefault();

        const token = await this.getToken();

        if (!token) return;

        $(e.target).trigger('submit');
      },

      async getToken() {
        const {token, error} = await stripe.createToken('bank_account', {
          country: 'US',
          currency: 'usd',
          routing_number: this.routing_number,
          account_number: this.account_number,
          account_holder_name: this.account_holder_name,
          account_holder_type: 'company',
        });

        if (error) {
          this.stripeError = error.message;
          return false;
        }

        this.stripeToken = token.id;
        return token;
      }

    },
  }
</script>
