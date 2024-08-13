document.addEventListener("DOMContentLoaded", function() {
    // pai
    const cargoSelect = document.getElementById("cargoSelect");

    // Função para buscar cargos
    function fetchCargos() {
        fetch('../controller/main.php',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'submit=Listar_cargos'
        }) 
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    console.log(data)
                    populateCargos(data.cargos);
                } else {
                    console.error('Erro ao obter cargos:', data.message);
                }
            })
            .catch(error => console.error('Erro na requisição:', error));
    }

    function populateCargos(cargos) {
        console.log(cargos)
        
        cargos.forEach(cargo => {
            // filho
            const option = document.createElement("option");
            option.value = cargo.id_cargo;  // Supondo que cada cargo tem um campo id
            option.textContent = cargo.nome;  // Supondo que cada cargo tem um campo nome
            cargoSelect.appendChild(option);
        });
    }

    fetchCargos();
});
