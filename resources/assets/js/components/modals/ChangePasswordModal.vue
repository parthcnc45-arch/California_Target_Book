<template>

    <transition name="modal">
      <div class="modal-mask" @click="checkToClose">
        <div class="modal-wrapper">
          <div class="modal-container">

            <form class="form" @submit="onSubmit" action="javascript:void(0)">

              <div class="modal-header">
                <div>
                  <h3 class="modal-title">Change Password</h3>
                  <p class="modal-subtitle">Enter your current password and choose a new one.</p>
                </div>
                <button type="button"
                  class="close"
                  @click="$emit('close')"
                  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div v-if="!success" class="modal-body">
                <div class="form-group">
                  <label class="control-label">Current password</label>
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
                  <label class="control-label">Confirm New Password</label>
                  <input class="form-control"
                    name="password_confirm"
                    v-model="passwordConfirm"
                    type="password"
                    minlength="6"
                    required />
                </div>

                <div class="bg-danger" v-if="errors.length">
                  <ul>
                    <li v-for="(e, i) of errors" :key="i">{{e}}</li>
                  </ul>
                </div>

              </div>

              <div v-if="success" class="modal-body bg-success">
                <p>Password updated successfully.</p>
              </div>

              <div class="modal-footer">

                <button
                  v-if="!success"
                  type="button"
                  class="btn btn-cancel"
                  @click="$emit('close')">
                  Cancel
                </button>

                <button :class="[{'is-loading': isLoading}, 'btn btn-update']"
                  v-if="!success"
                  :disabled="!formValid || isLoading"
                  type="submit">
                  Update Password
                </button>

                <button
                  v-if="success"
                  type="button"
                  class="btn btn-update"
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

<style scoped>
.modal-mask {
  position: fixed !important;
  z-index: 9998 !important;
  top: 0 !important;
  left: 0 !important;
  width: 100% !important;
  height: 100% !important;
  background-color: rgba(15, 23, 42, 0.6) !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  transition: opacity .3s ease !important;
}

.modal-wrapper {
  width: 100% !important;
  max-width: 440px !important;
  padding: 16px !important;
  box-sizing: border-box !important;
  display: block !important;
}

.modal-container {
  width: 100% !important;
  background-color: #ffffff !important;
  border-radius: 12px !important;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
  padding: 24px !important;
  box-sizing: border-box !important;
  text-align: left !important;
}

.modal-header {
  padding: 0 0 12px 0 !important;
  border-bottom: none !important;
  position: relative !important;
  display: flex !important;
  justify-content: space-between !important;
  align-items: flex-start !important;
}

.modal-title {
  font-size: 18px !important;
  font-weight: 700 !important;
  color: #0f172a !important;
  margin: 0 !important;
}

.modal-subtitle {
  font-size: 13.5px !important;
  color: #64748b !important;
  margin-top: 4px !important;
  margin-bottom: 20px !important;
  line-height: 1.5 !important;
}

.close {
  background: none !important;
  border: none !important;
  font-size: 22px !important;
  font-weight: 400 !important;
  color: #94a3b8 !important;
  cursor: pointer !important;
  padding: 0 !important;
  line-height: 1 !important;
  transition: color 0.15s !important;
  opacity: 0.8 !important;
}

.close:hover {
  color: #475569 !important;
  opacity: 1 !important;
}

.modal-body {
  padding: 0 !important;
  margin-bottom: 20px !important;
}

.form-group {
  margin-bottom: 16px !important;
}

.form-group:last-child {
  margin-bottom: 0 !important;
}

.control-label {
  display: block !important;
  font-size: 13px !important;
  font-weight: 600 !important;
  color: #334155 !important;
  margin-bottom: 6px !important;
  text-align: left !important;
}

.form-control {
  display: block !important;
  width: 100% !important;
  height: auto !important;
  padding: 8px 12px !important;
  font-size: 14px !important;
  line-height: 1.5 !important;
  color: #0f172a !important;
  background-color: #ffffff !important;
  border: 1px solid #cbd5e1 !important;
  border-radius: 6px !important;
  box-sizing: border-box !important;
  transition: border-color 0.15s, box-shadow 0.15s !important;
}

.form-control:focus {
  border-color: #d93838 !important;
  outline: none !important;
  box-shadow: 0 0 0 3px rgba(217, 56, 56, 0.15) !important;
}

.modal-footer {
  padding: 0 !important;
  border-top: none !important;
  display: flex !important;
  justify-content: flex-end !important;
  gap: 10px !important;
}

.btn {
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  padding: 8px 16px !important;
  font-size: 13.5px !important;
  font-weight: 600 !important;
  border-radius: 6px !important;
  cursor: pointer !important;
  transition: all 0.15s !important;
  border: 1px solid transparent !important;
  outline: none !important;
}

.btn-cancel {
  background-color: #ffffff !important;
  border-color: #cbd5e1 !important;
  color: #475569 !important;
}

.btn-cancel:hover {
  background-color: #f8fafc !important;
  border-color: #cbd5e1 !important;
  color: #1e293b !important;
}

.btn-update {
  background-color: #d93838 !important;
  color: #ffffff !important;
  border-color: #d93838 !important;
}

.btn-update:hover {
  background-color: #b91c1c !important;
  border-color: #b91c1c !important;
}

.btn-update:disabled {
  background-color: #fca5a5 !important;
  border-color: #fca5a5 !important;
  color: #ffffff !important;
  cursor: not-allowed !important;
}

.bg-danger {
  background-color: #fef2f2 !important;
  border: 1px solid #fee2e2 !important;
  border-radius: 6px !important;
  padding: 12px !important;
  margin-top: 16px !important;
  color: #991b1b !important;
}

.bg-danger ul {
  padding-left: 20px !important;
  margin: 0 !important;
}

.bg-success {
  background-color: #f0fdf4 !important;
  border: 1px solid #dcfce7 !important;
  border-radius: 6px !important;
  padding: 16px !important;
  color: #166534 !important;
}

.bg-success p {
  margin: 0 !important;
  font-weight: 500 !important;
}
</style>
