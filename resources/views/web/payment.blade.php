<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Payment</title>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 400px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .nav-pills .nav-link {
            color: #007bff;
            border-radius: 50px;
            font-weight: 500;
        }

        .nav-pills .nav-link.active {
            background-color: #007bff;
            color: #fff;
        }

        .form-group {
            margin-bottom: 20px;
        }

        #card-element {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }

        #card-errors {
            color: #dc3545;
            margin-top: 10px;
        }

        .subscribe {
            background-color: #007bff;
            border-radius: 25px;
            padding: 15px;
            font-weight: 500;
            color: #fff;
            transition: background-color 0.3s;
        }

        .subscribe:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <main>
        <div class="container">
            <div class="card">
                <div class="card-body p-5">
                    <ul class="nav nav-pills rounded nav-fill mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#nav-tab-card">
                                <i class="fa fa-credit-card"></i> Credit Card</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="nav-tab-card">
                            <form id="payment-form" action="{{ route('processPayment') }}" method="POST">
                                @csrf
                            
                                <div class="form-group">
                                    <label for="card-element">
                                        Credit or debit card
                                    </label>
                                    <div id="card-element">
                                        <!-- A Stripe Element will be inserted here. -->
                                    </div>

                                    <!-- Used to display form errors. -->
                                    <div id="card-errors" role="alert"></div>
                                </div>
                                <button id="confirm-payment" class="subscribe btn btn-primary btn-block" type="submit">Confirm</button>
                                <button id="cancel-payment" class="btn btn-secondary btn-block mt-3" type="button">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        // Set your publishable key
        var stripe = Stripe('pk_test_51OuhOdRpdk2DsT6ZkOgGaQMIpocRTFBO2a4JmQ2eJ9fSFzc3gJN4NRlAFBiOZpYpdocQGs2HwBzoJvgGbUBvmLu600jvDpOHvA');

        // Create an instance of Elements
        var elements = stripe.elements();

        // Create an instance of the card Element
        var card = elements.create('card');

        // Add an instance of the card Element into the `card-element` div
        card.mount('#card-element');

        // Handle form submission
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server
                    stripeTokenHandler(result.token);
                }
            });
        });

        // Submit the form with the token ID
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Add a hidden input field for the payment status
            var statusInput = document.createElement('input');
            statusInput.setAttribute('type', 'hidden');
            statusInput.setAttribute('name', 'stripeStatus');
            statusInput.setAttribute('value', 'pending'); // Set the initial status to pending
            form.appendChild(statusInput);
      var paymentIntentId = document.createElement('input');
            paymentIntentId.setAttribute('type', 'hidden');
            paymentIntentId.setAttribute('name', 'paymentIntentId');
            paymentIntentId.setAttribute('value', '{{ $paymentIntentId }}'); // Pass the paymentIntentId from PHP
            form.appendChild(paymentIntentId);
            // Submit the form
            form.submit();
        }
        var cancelButton = document.getElementById('cancel-payment');
        cancelButton.addEventListener('click', function() {
            // Redirect or perform any action when the cancel button is clicked
            window.location.href = '{{ route("processPayment") }}'; // Replace with your cancel route
        });ō
    </script>
</body>
</html>