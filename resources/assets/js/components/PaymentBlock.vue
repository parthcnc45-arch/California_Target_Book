<template>

  <div>

    <div class="form-group payment-block">

      <ul class="clearfix">
        <li>
          <label class="control-label" for="stripe-payment" :class="{ selected: method === 'stripe' }">
            <input name="payment_method" type="radio" id="stripe-payment" class="hidden" value="stripe" v-model="method"/>
            <div>
              <i class="material-icons">payment</i>
              <span>By Credit Card</span>
            </div>
          </label>
        </li>
        <li>
          <label class="control-label" for="stripe-bank-payment" :class="{ selected: method === 'stripe-bank' }">
            <input name="payment_method" type="radio" class="hidden" id="stripe-bank-payment" value="stripe-bank" v-model="method"/>
            <div>
              <i class="material-icons">account_balance</i>
              <span>By Bank</span>
            </div>
          </label>
        </li>
        <li>
          <label class="control-label" for="check-payment" :class="{ selected: method === 'check' }">
            <input name="payment_method" type="radio" class="hidden" id="check-payment" value="check" v-model="method"/>
            <div>
              <i class="material-icons">mail</i>
              <span>By Check</span>
            </div>
          </label>
        </li>
      </ul>

    </div>

    <div class="form-group" :class="{'has-error': errors.stripe_token}" v-if="method === 'stripe'">
      <stripe-element></stripe-element>
      <span class="help-block" v-if="errors.stripe_token">
          <strong>{{ errors.stripe_token }}</strong>
      </span>
    </div>

    <div class="form-group" :class="{'has-error': errors.stripe_token}" v-if="method === 'stripe-bank'">
      <p>
        To pay by bank, we must first verify your bank account.
      </p>
      <ol>
        <li>
          <b>In 1-2 business days, look for 2 deposits in your bank account</b>
          <br />
          We’ll send 2 small deposit amounts (less than $1.00) and retrieve them both in 1 withdrawal.
        </li>
        <li>
          <b>Enter deposit amounts on your account page.</b>
          <br />
          Log in to the Target Book, and enter the 2 deposit amounts to confirm your bank.
        </li>

      </ol>
      <p>
        Once your bank is verified we will enable your account and withdraw the full invoice amount.
      </p>

      <stripe-bank-element></stripe-bank-element>

      <span class="help-block" v-if="errors.stripe_token">
          <strong>{{ errors.stripe_token }}</strong>
      </span>
    </div>

    <div class="form-group" v-if="method === 'check'">
      <p>Mail in a check. You will receive an email with instructions on how to mail the check.</p>
      <p>*** Your account will not be activated until the check is received.</p>
    </div>

  </div>

</template>

<script>
  export default {

    props: {
      'paymentMethod': {
        type: String,
        default: 'stripe',
        required: false,
      },
      'errors': {
        type: Object,
        default: () => ({}),
        required: false,
      },
    },

    data: () => ({
      method: 'stripe',
    }),

    beforeMount() {
      this.method = this.paymentMethod || 'stripe';
    },

    mounted() {
    },

    methods: {
    }
  }
</script>

<style lang="scss" scoped>
  @import "../../sass/variables";

  .payment-block {
    ul {
      list-style: none;
      padding: 0;
       margin: 0 auto;
      position: relative;
      text-align: center;

      li {
        float: left;
        display: inline-block;
        width: 33%;
      }

      label {
        display: block;
        padding: 5px 10px;
        border: 1px solid transparent;
        cursor: pointer;

        &.selected {
          border: 1px solid #ddd;
          background: #f9f9f9;
        }
        >div {
          i {
            font-size: 36px;
            color: $red;
          }
          span {
            display: block;
            clear: both;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 400;
            font-size: 12px;
          }


        }
      }
    }
  }

</style>