<div>
  @assets
    <script src="https://js.stripe.com/v3/"></script>
    <script>
      document.addEventListener('livewire:init', () => {
         Livewire.on('order-validated', () => {
           window.setupPayment();
         });

         Livewire.on('confirm-payment', (data) => {
           window.confirmPayment(data.clientSecret);
         });
      });
  </script>
  @endassets

  <div id="payment-element"></div>
  <div id="error-message"></div>

  <button id="submit-button" wire:click="validateCheckout">Submit Order Now</button>
</div>
