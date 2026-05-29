<template>

    <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-container">
            <form class="form" @submit="onSubmit" action="javascript:void(0)">

              <div class="modal-header">
                <h3 class="pull-left">Send Message to {{to}}</h3>

                <button type="button" class="close pull-right mt-xs" @click="$emit('close')">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div :class="[{'bg-success': success, 'bg-danger': error}, 'modal-body']">

                <div class="row" v-if="!success">
                  <div class="col-sm-6">
                    <label>Your Name</label>
                    <input class="form-control" name="name" required v-model="name" />
                  </div>
                  <div class="col-sm-6">
                    <label>Your Email</label>
                    <input class="form-control" name="email" required v-model="email" />
                  </div>
                  <div class="col-sm-12">
                    <label>Subject</label>
                    <input class="form-control" name="subject" required v-model="subject" />
                  </div>
                  <div class="col-sm-12">
                    <label>Message</label>
                    <textarea name="message"
                        rows="5"
                        class="form-control"
                        v-model="message"
                        required>
                    </textarea>
                  </div>
                </div>


                <div v-if="success">
                  <p>Your message has been sent! They will be in touch with you by email soon.</p>
                </div>
                <div v-if="error">
                  <p>{{error}}</p>
                </div>
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
                  :disabled="!valid || isLoading"
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

        props: ['to'],

        data: () => {
          return {
            name: '',
            email: '',
            subject: '',
            message: '',

            error: '',
            isLoading: false,
            success: false,
          }
        },

        mounted() {
        },

        computed: {
          valid() {
            return this.name && this.email && this.subject && this.message && this.to;
          }
        },

        methods: {

          async onSubmit() {
            if (!this.valid) return;
            this.isLoading = true;

            try {
              var res = await axios.post('/api/mail', {
                to: String(this.to).toLowerCase(),
                from_name: this.name,
                from_email: this.email,
                subject: this.subject,
                message: this.message,
              });
            } catch (e) {
              this.error = 'Something went wrong, please try again later.';
              return;
            } finally {
              this.isLoading = false;
            }

            this.success = true;
          }
        },
    };
</script>

<style lang="scss" scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 600px;
  min-width: 300px;
  max-width: 95%;
  margin: 0px auto;
  padding: 0;
  background-color: #fff;
  box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
  transition: all .3s ease;
  text-align: left;
}

.modal-header h3 {
  margin: 0;
  text-align: left;
}

.form-control {
  margin-bottom: 12px;
}

div.modal-body {
  margin: 0;
  padding: 15px;
}

textarea {
  margin: 0 !important;
  max-width: 100%;
  min-width: 100%;
  min-height: 60px;
  max-height: 50vh;
  overflow: scroll;
}

.modal-default-button {
  float: right;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>

