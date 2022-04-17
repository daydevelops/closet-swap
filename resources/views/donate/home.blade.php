<x-app-layout>
    @push('css')
    <style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 2px solid rgb(206, 212, 218);
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }

    </style>
    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ "Support " . config('app.name')}}
        </h2>
    </x-slot>

    <div class="container my-16 mx-auto w-1/2">
        <h3 class="text-2xl mb-4">This website offers its services for free. <br>There is no charge to sign up and start
            trading with other users.</h3>
        <p class="mb-2 font-bold">However, this website does have expenses that need to be covered to remain
            operational. If
            you can afford to do so, any financial help to the support staff for this app is greatly appreciated.</p>
        <p class="mb-2 font-bold">As a thank you for your donation, we will also give you a cool pin for your avatar to
            show
            off your generosity! (make sure you <a href="{{route('login')}}" class="underline">log in</a> first)</p>
    </div>

    <div class="container mx-auto w-1/2">
        <table class="table-fixed w-full">
            <tbody>
                <tr>
                    <td class="w-1/4">
                        <label for="name">Name</label>
                    </td>
                    <td class="w-3/4">
                        <input type="text" class="w-full" name="name" id="name" aria-describedby="helpId"
                            placeholder="Jane Doe">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="name">Donation (CAD)</label>
                    </td>
                    <td>
                        <input type="number" class="w-full" name="cost" id="cost" aria-describedby="helpId" value="5"
                            min="0">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Credit Card</label>
                    </td>
                    <td>
                        <div id="card-element"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <x-button type="primary">
                            Process Payment
                        </x-button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>


    @push('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        addEventListener('load', function () {
            const stripe = Stripe('{{env("STRIPE_KEY")}}');

            const elements = stripe.elements();
            var style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };

            const cardElement = elements.create('card', {
                style: style
            });

            cardElement.mount('#card-element');

            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');

            cardButton.addEventListener('click', async (e) => {
                stripe.createToken(cardElement).then(function (result) {
                    if (result.error) {
                        alert(result.error.message);
                    } else {
                        axios.post('{{route("process-donation")}}', {
                            'id': result.token.id,
                            'cost': document.getElementById('cost').value,
                        }).then(function (response) {
                            if (response.status) {
                                window.location.replace(
                                    '{{route("successful-donation")}}');
                            } else {
                                alert(
                                    "Sorry, There was a problem with your card. Please check your card information and try again."
                                )
                            }
                        })
                    }
                });

            });
        });

    </script>

    @endpush
</x-app-layout>
