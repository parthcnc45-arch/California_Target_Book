<template>

    <transition name="modal">
      <div class="modal-mask" @click="checkToClose">
        <div class="modal-wrapper">
          <div class="modal-container">

            <div class="modal-header">
              <h3 class="pull-left">
                California Target Book Subscription
              </h3>
              <button type="button"
                class="close pull-right mt-xs"
                @click="$emit('close')"
                aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th>Cost</th>
                  </tr>
                </thead>

                <tbody>
                  <tr v-for="(li, i) of lineItems" :key="li.id">
                    <th>{{ i }}</th>
                    <td>{{ li.description }}</td>
                    <td>${{ li.amount | stripeCost }}</td>
                  </tr>

                </tbody>

                <tfoot>
                  <tr>
                    <th></th>
                    <th>Total</th>
                    <th>${{ total | stripeCost }}</th>
                  </tr>
                </tfoot>

              </table>
            </div>

            <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-primary modal-default-button pull-right"
                  @click="$emit('close')">
                  Close
                </button>
            </div>

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
          return { }
        },
        computed: {
          lineItems() {
            return this.invoice.lines.data;
          },
          total() {
            return this.invoice.amount_due;
          }
        },

        mounted() {
        },

        methods: {

          // Close the modal if user clicked outside of modal container
          checkToClose(e) {
            if (e.target.className === 'modal-wrapper') {
              this.$emit('close');
            }
          }
        },

    };
</script>


