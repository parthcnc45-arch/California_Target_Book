<script>

  export default {

    props: ['oldInput', 'user', 'serverErrors'],

    data: () => ({
      errors: {},
      ticketPrice: 60,
      ticketCount: 1,
      tickets: [],

      paymentMethod: 'stripe',
      isLoading: false,
    }),

    watch: {
      ticketCount() {
        this.calcTotals();
      },
    },

    computed: {
      totalCost() {
        return this.ticketPrice * this.ticketCount;
      },
    },

    beforeMount() {
      if (this.user && this.user.name) {
        this.tickets.push(this.user.name);
      }

      if (typeof this.oldInput === 'object' && !Array.isArray(this.oldInput)) {
        this.tickets = this.oldInput.ticket_holders || [];
        this.ticketCount = +this.oldInput.ticketCount || 1;
        this.paymentMethod = this.oldInput.payment_method || 'stripe';
      }
    },

    mounted() {
    },

    methods: {
      increment() {
        if (this.ticketCount === 9) return;
        this.ticketCount++;
      },
      decrement() {
        if (this.ticketCount === 1) return;
        this.ticketCount--;
      },
    },
  }
</script>

<style lang="scss" scoped>

  .alert.sold-out {
    i.material-icons {
      font-size: 36px;
    }
    p {
      color: rgba(0,0,0,0.6);
    }
  }

  .form-group {
    margin-bottom: 16px;
  }

  .select-options {
    label {
      display: block;
      padding: 5px 10px;
      border: 1px solid transparent;
      border-radius: 4px;
      cursor: pointer;

      &.selected {
        border: 1px solid #ddd;
        background: #f9f9f9;
      }
    }
  }

</style>
