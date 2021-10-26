<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <script src="https://js.braintreegateway.com/web/dropin/1.32.0/js/dropin.min.js"></script>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <div class="h-100">
        <div class="container app-height d-flex align-items-center">

        <form method="post" class="w-100 " id="payment-form" action="{{ route('admin.promo.makepayment', [$data['promozione'][0]->id,  $data['npromos'][0]]) }}">
            @csrf

            <div class="mx-auto d-flex justify-content-center" id="dropin-container">
            </div>
            <div class="mx-auto w-50 d-flex justify-content-center">   
                <input class="d-none" type="submit" value="Invia" id="premi"/>
            </div>
            <input type="hidden" id="nonce" name="payment_method_nonce"/>

        </form>
    </div>
    <script type="text/javascript" defer>
        @if ($data['token'])
            let client_token = "{{ $data['token'] }}";
        @endif
        
        const form = document.getElementById('payment-form');
        // create a dropin instance using that container 
        braintree.dropin.create({
        
        authorization: client_token,
        container: document.getElementById('dropin-container'),
        locale:'it_IT',
        card: {
            overrides: {
                styles: {
                    input: {
                    color: 'green',
                    'font-size': '18px'
                    },
                    '.number': {
                    'font-family': 'monospace',
                    // Custom web fonts are not supported. Only use system installed fonts.
                    },
                    '.invalid': {
                    color: 'red'
                    }
                }
            }
        }
        }).then((dropinInstance) => {
            // Add bottone verde
            document.getElementById('premi').setAttribute('class', 'px-4 btn btn-success');
            //
            form.addEventListener('submit', (event) => {
            event.preventDefault();
            document.getElementById('premi').setAttribute('value', 'Invio In Corso');

            dropinInstance.requestPaymentMethod().then((payload) => {
            document.getElementById('nonce').value = payload.nonce;
            form.submit();
            //scompare il bottone verde
            document.getElementById('premi').setAttribute('class', 'd-none');
            //
            }).catch((error) => { throw error; });
        });
        }).catch((error) => {
        // handle errors
        console.log(error);
        });
    </script>

</body>
</html>
