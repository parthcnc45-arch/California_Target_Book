<template>

    <transition name="modal">
      <div class="modal-mask" @click="checkToClose">
        <div class="modal-wrapper">
          <div class="modal-container">

            <form class="form" @submit="onSubmit" action="javascript:void(0)">

              <div class="modal-header">
                <h3 class="pull-left">
                  Change Password
                </h3>
                <button type="button"
                  class="close pull-right mt-xs"
                  @click="$emit('close')"
                  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div v-if="!success" class="modal-body">
                <div class="form-group">
                  <label class="control-label">Current Password</label>
                  <input class="form-control"
                    name="old"
                    v-model="currentPassword"
                    type="password"
                    required />
                </div>
                <div class="form-group">
                  <label class="control-label">New Password</label>
                  <input class="form-control"
                    name="password"
                    v-model="password"
                    type="password"
                    minlength="6"
                    required />
                </div>
                <div class="form-group">
                  <label class="control-label">Confirm Password</label>
                  <input class="form-control"
                    name="password_confirm"
                    v-model="passwordConfirm"
                    type="password"
                    minlength="6"
                    required />
                </div>

                <div class="bg-danger p-md" v-if="errors.length">
                  <ul class="m-n">
                    <li v-for="(e, i) of errors" :key="i">{{e}}</li>
                  </ul>
                </div>

              </div>

              <div v-if="success" class="modal-body bg-success p-lg">
                <p>Password updated successfully.</p>
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

                <button
                  v-if="success"
                  type="button"
                  class="btn btn-primary modal-default-button pull-right"
                  @click="$emit('close')">
                  Close
                </button>

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
        props: ['invoice'],

        data: () => {
          return {
            currentPassword: '',
            password: '',
            passwordConfirm: '',
            errors: [],
            isLoading: false,
            success: false,
          }
        },
        computed: {
          formValid() {
            return this.currentPassword && this.password && this.passwordConfirm;
          }
        },

        mounted() {
        },

        methods: {

          async onSubmit(form) {
            if (!this.formValid) return;
            this.isLoading = true;

            try {
              var res = await axios.put('/api/users/me/password', {
                current_password: this.currentPassword,
                password: this.password,
                password_confirmation: this.passwordConfirm,
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


