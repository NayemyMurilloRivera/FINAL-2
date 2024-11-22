document.addEventListener('DOMContentLoaded', function () {
    const botones = document.querySelectorAll('.agregar-carrito');

    botones.forEach(boton => {
        boton.addEventListener('click', function () {
            const nombre = this.getAttribute('data-nombre');
            const precio = this.getAttribute('data-precio');

            const data = {
                nombre: nombre,
                precio: precio,
                cantidad: 1,
                descuento: "0",
            };

            enviarDatos(data);
        });
    });

    function enviarDatos(data) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'car_post.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
        
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.responseText);
            }
        };
        
        xhr.send(JSON.stringify(data));
    }
});