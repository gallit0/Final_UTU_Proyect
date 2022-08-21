<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    
    <button id = "bdark"><i class="fas fa-moon"></i></button>

    <script>

        const bdark = document.querySelector('#bdark');
        const body = document.querySelector('body');

        load();

        bdark.addEventListener('click', e =>{
            body.classList.toggle('lightmode');
            store(body.classList.contains('lightmode'));
            console.log('cambio de tema');
        });

        function load(){
            const lightmode = localStorage.getItem('lightmode');

            if(!lightmode){
                store('false');
            }else if(lightmode == 'true'){
                body.classList.add('lightmode');
            }
        }

        function store(value){
            localStorage.setItem('lightmode', value);
        }

    </script>

</body>
</html>