<x-layoutBase>
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-6">
                <h1 class="mt-4">Página inicial</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Página inicial</li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <canvas id="grafico_emprestimos"></canvas>
            </div>
            <div class="col-6">
                <canvas id="grafico_escritos"></canvas>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const emprestimos = {
            labels: @json(array_map(fn ($data) => $data->titulo, $qtdEmprestimos)),
            datasets: [{
                label: 'Quantidade de vezes que o livro foi emprestado.',
                backgroundColor: 'rgba(255, 99, 132, 0.3)',
                borderColor: 'rgb(255, 99, 132)',
                data: @json(array_map(fn ($data) => $data->qtdEmprestado, $qtdEmprestimos)),
            }],
        };

        const escritos = {
            labels: @json(array_map(fn ($data) => $data->nome, $qtdEscritos)),
            datasets: [{
                label: 'Quantidade de livros escritos por autor.',
                backgroundColor: 'rgba(255, 99, 132, 0.3)',
                borderColor: 'rgb(255, 99, 132)',
                data: @json(array_map(fn ($data) => $data->qtdEscritos, $qtdEscritos)),
            }],
        };

        const configEmprestimos = {
            type: 'bar',
            data: emprestimos
        };

        const configEscritos = {
            type: 'bar',
            data: escritos
        };

        const graficoEmprestimos = new Chart(
            document.getElementById('grafico_emprestimos'),
            configEmprestimos
        );

        const graficoEscritos = new Chart(
            document.getElementById('grafico_escritos'),
            configEscritos
        );
    </script>
</x-layoutBase>
