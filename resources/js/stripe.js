let stripe, elements;

initializePayment();

// Handle error messages.
const handleError = (error) => {
  const messageContainer = document.getElementById('error-message');
  messageContainer.textContent = error.message;
}

// Initialise the payment element.
async function initializePayment() {
  if (typeof Stripe == "undefined") {
    return;
  }

  let response = await fetch('/payment/stripe/element', {
    headers: {
      'Content-Type': 'application/json',
    },
  });

  const { publishable_key, amount, currency } = await response.json();

  stripe = Stripe(publishable_key);

  const options = {
    mode: 'payment',
    amount: amount,
    currency: currency,
    paymentMethodCreation: 'manual',
  };

  elements = stripe.elements(options);

  const paymentElementOptions = {
    layout: 'accordion',
    fields: {
      billingDetails: {
        name: 'never',
        email: 'never',
        phone: 'never',
        address: 'never',
      }
    }
  };
  const paymentElement = elements.create('payment', paymentElementOptions);
  paymentElement.mount('#payment-element');
}

// Confirm the payment.
async function setupPayment() {
  const {error: submitError} = await elements.submit();
  if (submitError) {
    handleError(submitError);
    return;
  }

  const params = {
    payment_method_data: {
      billing_details: {
        name: 'test',
        email: 'test@test.com',
        phone: '12345',
        address: {
          line1: '123',
          line2: '123',
          city: '123',
          state: '123',
          postal_code: '123',
          country: 'GB',
        },
      },
    },
    shipping: {
      carrier: 'test',
        name: 'test',
        phone: '12345',
        address: {
          line1: '123',
          line2: '123',
          city: '123',
          state: '123',
          postal_code: '123',
          country: 'GB',
        },
    },
  };

  const {error, confirmationToken} = await stripe.createConfirmationToken({
    elements,
    params,
  });

  Livewire.dispatch('payment-setup', {
    confirmationToken: confirmationToken,
  });
}

window.setupPayment = setupPayment;

async function confirmPayment(clientSecret) {
  console.log('starting confirmPayment...');

  const {
    error,
    paymentIntent
  } = await stripe.handleNextAction({
    clientSecret: clientSecret
  });

  console.log('handleNextAction finished...');
  console.log(error);
  console.log(paymentIntent);

  if (error) {
    console.log('handling error');
    handleError(error);
  } else {
    console.log('dispatching payment-confirmed event');
    // Livewire.dispatch('payment-confirmed', {
    //   paymentIntentId: paymentIntent.id,
    // });
  }

  console.log('finishing confirmPayment.');
}

window.confirmPayment = confirmPayment;
