<template>
    <div>
        <div id="card-element" class="form-control pt-sm">
            <!-- a Stripe Element will be inserted here. -->
        </div>

        <input type="hidden" :value="stripeToken" name="stripe_token" required/>

        <!-- Used to display Element errors -->
        <span class="help-block">
            <strong id="card-errors" role="alert">
                {{ stripeError }}
            </strong>
        </span>
    </div>
    
</template>

<script>
    var stripe = window.Stripe(window.STRIPE_PUB_KEY);
    var elements = stripe.elements();

    // Create an instance of the card Element
    var card = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                fontWeight: 200,
                color: "#9a9a9a",
            }
        }
    });

    export default {
        
        data: () => {
            return {
                stripeError: '',
                stripeToken: '',
            }
        },

        mounted() {
            card.mount('#card-element');
            card.addEventListener('change', this.stripeEvent);
        },

        methods: {
            stripeEvent(event) {
                this.stripeError = event.error ? event.error.message : '';

                if (event.complete) {
                    stripe.createToken(card)
                        .then(result => {
                            if (result.error) {
                                this.stripeError = result.error.message;
                            } else {
                                this.stripeToken = result.token.id;
                            }
                        });
                }

            },
        },
    }
</script>
