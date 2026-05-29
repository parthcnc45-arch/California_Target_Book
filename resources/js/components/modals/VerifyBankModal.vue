<template>

    <transition name="modal">
      <div class="modal-mask" @click="checkToClose">
        <div class="modal-wrapper">
          <div class="modal-container">

            <form class="form" @submit="onSubmit" action="javascript:void(0)">

              <div class="modal-header">
                <h3 class="pull-left">
                  Verify Bank
                </h3>
                <button type="button"
                  class="close pull-right mt-xs"
                  @click="$emit('close')"
                  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

              </div>

              <div v-if="!success" class="modal-body">
                <p class="clear sub">
                  To have your subscription activated, you need to verify your bank account.
                  Enter the amounts you see on your bank statement below.
                  If the deposits were $0.31 and $0.14, you would enter 31 and 14 below. Order does not matter.
                </p>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label class="control-label">Deposit 1</label>
                      <input class="form-control"
                          v-model="deposit1"
                          type="number"
                          placeholder="0"
                          maxlength="2"
                          required />
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label class="control-label">Deposit 2</label>
                      <input class="form-control"
                          v-model="deposit2"
                          placeholder="0"
                          maxlength="2"
                          type="number"
                          required />
                    </div>
                  </div>
                </div>

                <div class="bg-danger p-md" v-if="errors.length">
                  <ul class="m-n">
                    <li v-for="(e, i) of errors" :key="i">{{e}}</li>
                  </ul>
                </div>

              </div>

              <div v-if="success" class="modal-body bg-success p-lg">
                <p>
                  Your bank has been verified and your subscription is now active.
                  You will be charged the amount on your invoice withing 3-5 business days.
                </p>
              </div>

              <div class="modal-footer">

                <button
                  v-if="!success"
                  type="button"
                  class="btn btn-default modal-default-button pull-left"
                  @click="$emit('close')">
                  Cancel
                </button>

                <button :class="[{'is-loading': isLoading}, 'btn btn-primary modal-default-button']"
                  v-if="!success"
                  :disabled="!formValid || isLoading"
                  type="submit">
                  Submit
                </button>

                <a v-if="success"
                  href="/book"
                  class="btn btn-primary modal-default-button pull-right">
                  Go To Book
                </a>

              </div>

            </form>
          </div>
        </div>
      </div>
    </transition>

</template>

<script>
    import axios from 'axios';

    export default {
        // props: ['bankAccount'],

        data: () => {
          return {
            deposit1: '',
            deposit2: '',
            errors: [],
            isLoading: false,
            success: false,
          }
        },
        computed: {
          formValid() {
            return this.deposit1 && this.deposit2;
          }
        },

        mounted() {
        },

        methods: {

          async onSubmit(form) {
            if (!this.formValid) return;
            this.isLoading = true;

            try {
              var res = await axios.post('/api/users/me/verify-bank', {
                deposits: [this.deposit1, this.deposit2],
              });
            } catch (res) {
              const errors = res.response.data.errors;
              if (errors) {
                this.errors = Object.keys(errors)
                  .reduce((errs, e) => errs.concat(errors[e]), []);
              } else {
                this.errors = ['Something went wrong, please try again later.'];
              }
              return;
            } finally {
              this.isLoading = false;
            }
            this.success = true;
          },

          // Close the modal if user clicked outside of modal container
          checkToClose(e) {
            if (e.target.className === 'modal-wrapper') {
              this.$emit('close');
            }
          }
        },

    };
</script>


